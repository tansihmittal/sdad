<?php
/**
 * =======================================================================================
 *                           GemFramework (c) GemPixel
 * ---------------------------------------------------------------------------------------
 *  This software is packaged with an exclusive framework as such distribution
 *  or modification of this framework is not allowed before prior consent from
 *  GemPixel. If you find that this framework is packaged in a software not distributed
 *  by GemPixel or authorized parties, you must not use this software and contact GemPixel
 *  at https://gempixel.com/contact to inform them of this misuse.
 * =======================================================================================
 *
 * @package GemPixel\Premium-URL-Shortener
 * @author GemPixel (https://gempixel.com)
 * @license https://gempixel.com/licenses
 * @link https://gempixel.com
 */

namespace Helpers;

use Core\View;
use Core\Response;
use Core\Helper;
use Core\DB;
use Helpers\CDN;

class Gate {

    use \Traits\Overlays, \Traits\Pixels, \Traits\Links {
        \Traits\Links::validate insteadof \Traits\Pixels;
    }

    /**
     * Inactive Link
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function inactive(){

        View::set('title', e('Inactive Link'));

        View::set("description","This link has been marked as inactive and cannot currently be used.");

        return View::dryRender('errors.expired');
    }
    /**
     * Disabled Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function disabled(){

        View::set('title', e('Unsafe Link Detected'));

        View::set("description","This link has been marked as unsafe and we have disabled it for your own safety.");

        http_response_code(410);

        return View::dryRender('errors.disabled');
    }
    /**
     * Expired Page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @return void
     */
    public static function expired(){
        View::set('title', e('Link Expired'));
        return View::dryRender('errors.expired');
    }
    /**
     * Password protected page
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param object $url
     * @return void
     */
    public static function password(object $url){

        View::set('title', e('Enter your password to unlock this link'));
        View::set("description",e('The access to this link is restricted. Please enter your password to view it.'));

        // @group Plugin
        \Core\Plugin::dispatch('type.password', $url);

        if(config('detectadblock') && !$url->pro){

            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->toFooter();

			View::push(assets('detect.app.js'),"script")->toFooter();
		}

        return View::with('gates.password')->extend('layouts.auth');
    }
    /**
     * Direct method
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param object $url
     * @param object $user
     * @return void
     */
    public static function direct(object $url, $user = null){

        // @group Plugin
        \Core\Plugin::dispatch('type.direct', $url);

        if($user && ($user->has('pixels') && !empty($url->pixels) || $url->meta_image)){

            $request = request();
            $config = config('cookieconsent');

            if(isset($config->force) &&  $config->force && !$request->cookie('cookieconsent_status')){
                $request->session('redirectbackto', \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom));
                return Helper::redirect()->to(($url->domain ? $url->domain : config('url')).'/consent');
            }

            return (new Response('<!DOCTYPE html>
                        <html lang="en">
                        <head>
                        <meta charset="UTF-8">
                        <title>'.$url->meta_title.' | '.config("title").'</title>
                        <meta name="description" content="'.$url->meta_description.'" />
                        <meta property="og:type" content="website" />
                        <meta property="og:url" content="'.\Helpers\App::shortRoute($url->domain, $url->alias.$url->custom).'" />
                        <meta property="og:title" content="'.$url->meta_title.'" />
                        <meta property="og:description" content="'.$url->meta_description.'" />
                        <meta property="og:updated_time" content="'.strtotime('-1 hour').'" />
                        <meta name="twitter:card" content="summary_large_image">
                        <meta name="twitter:title" content="'.$url->meta_title.'">
                        <meta name="twitter:description" content="'.$url->meta_description.'">
                        '.($url->meta_image ? '<meta property="og:image" content="'.uploads($url->meta_image, 'images').''.'" />
                        <meta name="twitter:image" content="'.uploads($url->meta_image, 'images').'">' : '').'
                        <noscript>
                            <meta http-equiv="refresh" content="2;url='.$url->url.'">
                        </noscript>
                        <style>body{background:#f8f8f8; position: relative;}.loader,.loader:after{border-radius:50%;width:5em;height:5em}.loader{position:absolute!important;top:250px;display:block;left:48%;left:calc(50vw - 5em);font-size:10px;text-indent:-9999em;border-top:1.1em solid rgba(128,128,128,.2);border-right:1.1em solid rgba(128,128,128,.2);border-bottom:1.1em solid rgba(128,128,128,.2);border-left:1.1em solid grey;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0);-webkit-animation:load8 1.1s infinite linear;animation:load8 1.1s infinite linear}@-webkit-keyframes load8{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes load8{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}</style>
                        '. ($user->has('pixels') && !empty($url->pixels) ? self::injectPixels($url->pixels, $user) : '').'
                        <script>
                            window.setTimeout(function(){
                                window.location.href = "'.$url->url.'";
                            }, 2000);
                        </script>
                        </head>
                        <body>
                        <div class="loader">Redirecting</div>
                        </body>
                        </html>', 200))->send();
		}

        return (new Response(null, 301, ['location' => $url->url]))->send();
    }
    /**
     * Frame method
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param object $url
     * @return void
     */
    public static function frame(object $url, $user = null){
        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        View::set('bodyClass', 'overflow-hidden');

        View::push('<style> html { overflow: hidden } </style>','custom')->toHeader();
        View::push('<script type="text/javascript"> $("iframe#site,#main-overlay").height($(document).height()-$("#frame").height()).css("top",$("#frame").height()+30)</script>','custom')->toFooter();

        // @group Plugin
        \Core\Plugin::dispatch('type.frame', $url);

        return View::with('gates.frame', ['url' => $url])->extend('layouts.auth');
    }
    /**
     * Splash method
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.4.4
     * @param object $url
     * @return void
     */
    public static function splash(object $url, $user = null){

        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        if(!empty(config('analytic'))){
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytic')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytic')."');</script>","custom")->toFooter();
		}

		// Add timer animation
		if(!empty(config('timer')) || config('timer') != "0"){

            $count = App::randomWord();
            $countdown = App::randomWord();

            if(appConfig('app.redirectauto')){
                \Core\View::push('<script type="text/javascript">let '.$count.' = '.config('timer').';let '.$countdown.' = setInterval(function(){$("a.redirect").attr("href","#'.App::randomWord().'").html('.$count.' + " '.e('seconds').'");if ('.$count.' < 1) {clearInterval('.$countdown.');window.location="'.$url->url.'";}'.$count.'--;}, 1000);</script>',"custom")->toHeader();
            } else {
                \Core\View::push('<script type="text/javascript">let '.$count.' = '.config('timer').';let '.$countdown.' = setInterval(function(){$("a.redirect").attr("href","#'.App::randomWord().'").html('.$count.' + " '.e('seconds').'");if ('.$count.' < 1) {clearInterval('.$countdown.');$("a.redirect").attr("href","'.$url->url.'").html("'.e('Continue').'");}'.$count.'--;}, 1000);</script>',"custom")->toHeader();
            }
		}

		// BlockAdblock
		if(config('detectadblock') && !$url->pro){

            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->toFooter();

			View::push(assets('detect.app.js'),"script")->toFooter();
		}

        // @group Plugin
        \Core\Plugin::dispatch('type.splash', $url);

        return View::with('gates.splash', ['url' => $url])->extend('layouts.api');
    }
    /**
     * Custom Overlay
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @param [type] $user
     * @return void
     */
    public static function custom($url, $splash, $user){

        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        if(!empty(config('analytic'))){
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytic')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytic')."');</script>","custom")->toFooter();
		}

        $splash->data = json_decode($splash->data);

        $counter = isset($splash->data->counter) && is_numeric($splash->data->counter) ? $splash->data->counter : config('timer');

        \Core\View::push('<script type="text/javascript">var count = '.$counter.';var countdown = setInterval(function(){$("#counter span").text(count);if (count < 1) {clearInterval(countdown);window.location="'.$url->url.'";}count--;}, 1000);</script>',"custom")->toHeader();

        // @group Plugin
        \Core\Plugin::dispatch('type.custom', $url, $splash);

        View::set('bodyClass', 'bg-secondary');

        return View::with('gates.custom', ['url' => $url, 'splash' => $splash, 'user' => $user])->extend('layouts.auth');
    }
    /**
     * Overlay
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $url
     * @param [type] $user
     * @return void
     */
    public static function overlay($url, $user){

        $type = str_replace('overlay-', '', $url->type);

        if(!$overlay = \Core\DB::overlay()->where('id', $type)->where('userid', $url->userid)->first()){
            stop(404);
        }

        $overlay->data = json_decode($overlay->data);

        if(!empty(config('analytic'))){
            \Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytic')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytic')."');</script>","custom")->toFooter();
		}

        if(isset($overlay->data->link)){
            \Core\View::push('<script>$(document).ready(function(){ $(".clickable").click(function() { window.location = "'.$overlay->data->link.'"; });});</script>', "custom")->toFooter();
        }

		if(App::iframePolicy($url->url)) return self::direct($url);

        View::push('<style> html { overflow: hidden } </style>','custom')->toHeader();
        View::push('<script type="text/javascript"> $("iframe#site").height($(document).height())</script>','custom')->toFooter();

        // @group Plugin
        \Core\Plugin::dispatch('type.overlay', $url, $overlay);

        if($url->domain && $url->domain != config('url')) {
            $config = config();
            $config->url = trim($url->domain, '/');
            Helper::set("config", $config);            
        }

		$content = \call_user_func_array(self::types($overlay->type, 'view'), [$overlay, $url]);

        return View::with(function() use ($url, $content){
            return print('<iframe id="site" src="'.$url->url.'" frameborder="0" loading="lazy" style="border: 0; width: 100%; height: 100%;position: absolute;top: 0px;z-index: 1;" scrolling="yes"></iframe><div id="main-overlay">'.$content.'</div>');
        })->extend('layouts.auth');
    }

    /**
     * Embed Media
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param array $data
     * @category extendable
     * @return void
     */
    public static function embed(array $data){
        $sites = [
            // Youtube
            "youtube" => "<iframe id='ytplayer' type='text/html'  width='100%' height='400' allowtransparency='true' src='//www.youtube.com/embed/{$data['id']}?autoplay=1&origin=".config('url')."' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>",
            "youtu" => "<iframe id='ytplayer' type='text/html'  width='100%' height='400' allowtransparency='true' src='//www.youtube.com/embed/{$data['id']}?autoplay=1&origin=".config('url')."' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>",

            // Vimeo
            "vimeo" => "<iframe src='//player.vimeo.com/video/{$data['id']}' width='100%' height='400' allowtransparency='true' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
            // Dailymotion
            "dailymotion" => "<iframe src='//www.dailymotion.com/embed/video/{$data['id']}' width='100%' height='390' allowtransparency='true' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>",
            // FunnyOrDie
            "funnyordie" => "<iframe src='//www.funnyordie.com/embed/{$data['id']}' width='100%' height='400' allowtransparency='true' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>",
            // Collegehumor
            "collegehumor" => "<iframe src='//www.collegehumor.com/e/{$data['id']}'  width='100%' height='400' allowtransparency='true' frameborder='0' webkitAllowFullScreen allowFullScreen></iframe>",
        ];

        if($extended = \Core\Plugin::dispatch('mediaembed.extend')){
			foreach($extended as $fn){
				$sites = array_merge($sites, $fn);
			}
		}
        return $sites[$data['host']];
    }
    /**
     * Media Gateway
     *
     * @author GemPixel <https://gempixel.com>
     * @version 1.0
     * @param [type] $url
     * @param [type] $media
     * @return void
     */
    public static function media($url, $media, $user = null){

        if($user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

		if(!empty(config('analytic'))){
			\Core\View::push("<script async src='https://www.googletagmanager.com/gtag/js?id=".config('analytic')."'></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', '".config('analytic')."');</script>","custom")->toFooter();
		}
		if(config('detectadblock') && !$url->pro){

            CDN::load("blockadblock");

			View::push('<script type="text/javascript">var detect = '.json_encode(["on" => e("Adblock Detected"), "detail" => e("Please disable Adblock and refresh the page again.")]).'</script>','custom')->toFooter();

			View::push(assets('detect.app.js'),"script")->toFooter();
		}

        // @group Plugin
        \Core\Plugin::dispatch('type.media', $url);

        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();
        View::push(assets('custom.js'),"script")->toFooter();

        $url->embed = self::embed($media);

        return View::with('gates.media', ['url' => $url, 'media' => $media])->extend('layouts.api');
    }
    /**
     * Profile
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.3.2
     * @return void
     */
    public static function profile($profile, $user = null, $url = null){

        if(!$user) $user = \Models\User::where('id', $profile->userid)->first();

		if($user->banned) {
			return Gate::disabled();
		}

        $profiledata = json_decode($profile->data, true);

        if($url && $user && $user->has('pixels')){
			self::injectPixels($url->pixels, $user);
		}

        if(!$url) {
            $url = \Core\DB::url()->first($profile->urlid);
            if(!$url || !$url->status) return Gate::inactive();
        }

        $request = request();

        if($request->isPost()){

            // Click event
            if($request->action == "clicked" && $request->blockid && is_numeric($request->blockid)){

                \Gem::addMiddleware('BlockBot');

                if($url = \Core\DB::url()->first($request->blockid)){
                    (new Gate)->updateStats($request, $url, $user);
                    return Response::factory('success')->send();
                } else {
                    return Response::factory('error')->send();
                }
            }

            // Contact Widget
            if($request->action == "contact"){

                \Gem::addMiddleware('ValidateCaptcha');

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'));

                $data = $profiledata['links'][$request->blockid];
                $message = clean($request->message);
                $email = clean($request->email);
                $page = \Helpers\App::shortRoute($url->domain??null, $profile->alias);

                Emails::setup()
                        ->replyto([Helper::RequestClean($request->email)])
                        ->to($data['email'])
                        ->send([
                            'subject' => '['.config('title').'] You were contacted from your Bio Page: '.$profile->name,
                            'message' => function($template, $data) use ($message, $email, $page){
                                if(config('logo')){
                                    $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" width="166"/>';
                                } else {
                                    $title = '<h3>'.config('title').'</h3>';
                                }

                                return \Core\Email::parse($template, ['content' => "<p>You have received an email from <strong>{$email}</strong> sent via the Bio Page {$page}.</p><strong>Message:</strong><br><p>{$message}</p>", 'brand' => $title]);
                            }
                        ]);

                return back()->with('success', e('Message sent successfully.'));
            }

            // Newsletter Widget
            if($request->action == "newsletter"){

                if(!$request->email || !$request->validate($request->email, 'email')) return back()->with('danger', e('Please enter a valid email.'));

                $data = $profiledata['links'][$request->blockid];

                $resp = json_decode($profile->responses, true);

                if(!isset($resp['newsletter']) || !in_array($request->email, $resp['newsletter'])){
                    $resp['newsletter'][] = clean($request->email);

                    $profile->responses = json_encode($resp);
                    $profile->save();
                }
                return back()->with('success', e('You have been successfully subscribed.'));
            }

            if($request->action == 'vcard'){
                $data = $profiledata['links'][$request->blockid];

                $vcard = "BEGIN:VCARD\r\nVERSION:3.0\r\n";

                if($data['fname'] || $data['lname']){
                    $vcard .= "N:{$data['lname']};{$data['fname']}\r\n";
                }
                if(isset($data['company']) && $data['company']){
                    $vcard .= "ORG:{$data['company']}\r\n";
                }
                
                if($data['phone']){
                    $vcard .= "TEL;TYPE=work,voice:{$data['phone']}\r\n";
                }
                if(isset($data['cell']) && $data['cell']){
                    $vcard .= "TEL;TYPE=cell,voice:{$data['cell']}\r\n";
                }
                if(isset($data['fax']) && $data['fax']){
                    $vcard .= "TEL;TYPE=fax:{$data['fax']}\r\n";
                }

                if($data['email']){
                    $vcard .= "EMAIL;TYPE=INTERNET;TYPE=WORK;TYPE=PREF:{$data['email']}\r\n";
                }

                if($data['site']){
                    $vcard .= "URL;TYPE=work:{$data['site']}\r\n";
                }
                if($data['address'] || $data['city'] || $data['state'] || $data['country']){
                    $vcard .= "ADR;TYPE=work:;;{$data['address']};{$data['city']};{$data['state']};{$data['country']}\r\n";
                }

                $vcard .= "\r\nREV:" . date("Ymd") . "T195243Z\r\nEND:VCARD";

                return \Core\File::contentDownload('vcard.vcf', function() use ($vcard){
                    echo $vcard;
                });
            }
        }
        $config = config();
        $sitetitle = $config->title;
        $config->title = null;
        Helper::set("config", $config);

        View::set('title', !empty($url->meta_title) ? $url->meta_title : $profile->name);
        View::set('description', !empty($url->meta_description) ? $url->meta_description : $profile->name.' Bio Page');

        if($url->meta_image){
            View::set('image', uploads($url->meta_image, 'images'));
        }

        View::set('url', \Helpers\App::shortRoute($url->domain??null, $profile->alias));

        View::push(assets('biopages.min.css'))->toHeader();
        
        View::push('<style>body{min-height: 100vh;color: '.$profiledata['style']['textcolor'].';'.(isset($profiledata['style']['mode']) && $profiledata['style']['mode'] == 'singlecolor' ? 'background: '.$profiledata['style']['bg'].';' : '').''.(!isset($profiledata['style']['mode']) || $profiledata['style']['mode'] == 'gradient' ? 'background: linear-gradient('.($profiledata['style']['gradient']['angle'] && is_numeric($profiledata['style']['gradient']['angle']) ? $profiledata['style']['gradient']['angle'] : '135').'deg,'.$profiledata['style']['gradient']['start'].' 0%, '.$profiledata['style']['gradient']['stop'].' 100%);' : '').'}.fa,.fab,.far,.fas{font-size: 1.5em}h1,h3,em,p,a{color: '.$profiledata['style']['textcolor'].' !important;}a:hover{color: '.$profiledata['style']['textcolor'].';opacity: 0.8;}.btn-custom,.btn-custom.active{background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].' !important;}.btn-custom:hover{opacity: 0.8;background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].';}.btn-custom p, .btn-custom h3, .btn-custom span{color: '.$profiledata['style']['buttontextcolor'].' !important;}.rss{background:'.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].';height:300px} .rss a{color:'.$profiledata['style']['buttontextcolor'].' !important}.item > h1,.item > h2,.item > h3,.item > h4,.item > h5,.item > h6{color:'.$profiledata['style']['textcolor'].';}.cc-floating.cc-type-info.cc-theme-classic .cc-btn{color:#000 !important}.modal-backdrop.show{opacity:0.85!important}#social a:first-child{margin-left: 0 !important}.form-control{background:#fff !important;color:#000 !important}.layout2 .d-block{height:150px;}.layout2 .useravatar{margin-top: -60px;}.card{background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].' !important;}.card a, .card h6, .card p, .card .card-body {color: '.$profiledata['style']['buttontextcolor'].' !important;}.faqs a .fa{transition: transform 0.2s linear;font-size: 18px !important}.faqs a:not(.collapsed) .fa{transform: rotate(180deg);}</style>','custom')->toHeader();

        if(isset($profiledata['style']['buttonstyle'])){
            if($profiledata['style']['buttonstyle'] == 'trec'){
                View::push('<style>.btn-custom,.card{background-color:transparent;border:2px solid '.$profiledata['style']['buttoncolor'].';}</style>','custom')->toHeader();
            }elseif($profiledata['style']['buttonstyle'] == 'tro'){
                View::push('<style>.btn-custom,.card{background-color:transparent;border:2px solid '.$profiledata['style']['buttoncolor'].';border-radius:50px;}</style>','custom')->toHeader();
            }elseif($profiledata['style']['buttonstyle'] == 'rounded'){
                View::push('<style>.btn-custom,.card{border-radius:50px;}</style>','custom')->toHeader();
            }elseif($profiledata['style']['buttonstyle'] == 'none'){
                View::push('<style>.btn-custom,.card{border-radius:0;}</style>','custom')->toHeader();
            }
        }
        if(isset($profiledata['style']['shadow'])){
            if($profiledata['style']['shadow'] == 'soft'){
                View::push('<style>.btn-custom,.card{box-shadow: 2px 2px 5px '.$profiledata['style']['shadowcolor'].'}</style>','custom')->toHeader();
            }elseif($profiledata['style']['shadow'] == 'hard'){
                View::push('<style>.btn-custom,.card{box-shadow: 5px 5px 0px 1px '.$profiledata['style']['shadowcolor'].'}</style>','custom')->toHeader();
            }
        }

        if(isset($profiledata['settings']['share']) && $profiledata['settings']['share']){
            View::push("<script>
                    if(navigator.share){
                        $('body').prepend('<a href=\"#\" data-trigger=\"share\" class=\"btn btn-white btn-light btn-icon-only shadow rounded text-dark position-fixed zindex-101 right-4 me-4 end-0 top-4 mt-4 d-flex\" data-toggle=\"tooltip\" data-bs-toggle=\"tooltip\" data-bs-placement=\"right\" data-placement=\"right\" title=\"".e('Share')."\"><span class=\"btn-inner--icon small\"><i class=\"fa fa-share-alt\" class=\"text-dark\"></i></span></a>');
                    }
                    $('[data-trigger=share]').click(function(e){
                        e.preventDefault();
                        navigator.share({
                            title: '{$url->meta_title}',
                            text: '{$url->meta_decription}',
                            url: '".\Helpers\App::shortRoute($url->domain??null, $profile->alias)."'
                        });
                });</script>",'custom')->toFooter();
        }

        if(isset($profiledata['settings']['cookie']) && (is_null($profiledata['settings']['cookie']) || !$profiledata['settings']['cookie'])){
            $config = config();
            $config->cookieconsent->enabled = 0;
            Helper::set("config", $config);
        }
        

        if(isset($profiledata['settings']['sensitive']) && $profiledata['settings']['sensitive']){
            View::push('<div class="modal fade" id="sensitiveModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="sensitiveModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title text-dark" id="sensitiveModalLabel"><i class="fa fa-warning text-danger"></i> '.e('Sensitive Content').'</h5>
                                </div>
                                <div class="modal-body text-dark">
                                '.e('This page contains sensitive content which may not be suitable for all ages. By continuing, you agree to our terms of service.').'
                                </div>
                                <div class="modal-footer">
                                    <a href="'.url('?utm_source=biopage-'.$profile->alias.'&utm_medium=sensitivemodal').'" class="btn btn-primary text-white">'.e('Go Back').'</a>
                                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal" data-bs-dismiss="modal">'.e('Continue').'</button>
                                </div>
                            </div>
                            </div>
                        </div><script>new bootstrap.Modal(document.getElementById("sensitiveModal"), {backdrop:\'static\',keyboard: false}).show();$(\'.modal-backdrop.show\').attr(\'style\', \'opacity: 1 !important\');$(\'#sensitiveModal\').modal(\'show\');</script>','custom')->toFooter();
        }
        if(isset($profiledata['themeid']) && $profiledata['themeid'] && $theme = DB::themes()->where('id', clean($profiledata['themeid']))->first()){
            $theme->data = json_decode($theme->data);
            if($theme->data->bgtype == 'image'){
                View::push('<style>body{background-image: url(\''.uploads($theme->data->bgimage, 'profile').'\');background-size:cover}</style>','custom')->toHeader();
            }
            if($theme->data->bgtype == 'css'){
                View::push('<style>body{'.$theme->data->customcss.'}</style>','custom')->toHeader();
            }
        }
        // @group Plugin
        \Core\Plugin::dispatch('type.profile', $profile);

        if(isset($profiledata['style']['custom']) && $profiledata['style']['custom']){
            View::push('<style>'.$profiledata['style']['custom'].'</style>','custom')->toHeader();
        }

        if((!isset($profiledata['style']['mode']) && isset($profiledata['bgimage']) && $profiledata['bgimage']) ||
            (isset($profiledata['style']['mode']) && $profiledata['style']['mode'] == "image" && isset($profiledata['bgimage']) && $profiledata['bgimage'])) {
            View::push('<style>body{background-image: url('.uploads($profiledata['bgimage'], 'profile').');background-size:cover}</style>','custom')->toHeader();
        }
        if(isset($profiledata['style']['theme']) && $profiledata['style']['theme'] && $profiledata['style']['mode'] == 'custom'){
            View::set('bodyClass', $profiledata['style']['theme']);
        }
        
        View::push(($url->domain ?? config('url')).'/static/frontend/libs/fontawesome/all.min.css')->toHeader();
        if(isset($profiledata['style']['font']) && !empty($profiledata['style']['font'])){
            View::push(($url->domain ?? config('url')).'/static/fonts/index.css')->toHeader();
            View::push('<style>body{font-family: "'.str_replace('+', ' ', $profiledata['style']['font']).'" !important;}</style>', 'custom')->toHeader();
        }

        foreach($profiledata['links'] as $key => $value){
            if($value['type'] == "link"){
                if($url = \Core\DB::url()->first($value['urlid'])){
                    $profiledata['links'][$key]['shortlink'] = \Helpers\App::shortRoute($url->domain, $url->alias.$url->custom);
                }
            }

            if($value['type'] == 'youtube'){
                preg_match("/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/(watch|playlist)\?(v|list)=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/i", $value['link'], $match);
                if(isset($match[1])){
                    if($match[1] == 'playlist'){
                        $profiledata['links'][$key]['link'] = 'https://www.youtube.com/embed/videoseries?list='.$match[3];
                    }elseif($match[1] == 'watch') {
                        $profiledata['links'][$key]['link'] = 'https://www.youtube.com/embed/'.$match[3];
                    }else {
                        $profiledata['links'][$key]['link'] = 'https://www.youtube.com/embed/'.$match[3];
                    }
                }
            }
            if($value['type'] == 'spotify'){
                preg_match("/^https:\/\/open.spotify.com\/(track|playlist|episode)\/([a-zA-Z0-9]+)(.*)$/i", $value['link'], $match);
                if(isset($match[1])){
                    if($match[1] == 'playlist'){
                        $profiledata['links'][$key]['link'] = str_replace('/playlist/', '/embed/playlist/', $value['link']);
                    }elseif($match[1] == 'episode'){
                        $profiledata['links'][$key]['link'] = str_replace('/episode/', '/embed/episode/', $value['link']);
                    }else{
                        $profiledata['links'][$key]['link'] = str_replace('/track/', '/embed/track/', $value['link']);
                    }
                }
            }

            if($value['type'] == 'itunes'){
                $profiledata['links'][$key]['link'] = str_replace('music.apple', 'embed.music.apple', $value['link']);
            }
            if($value['type'] == 'tiktok'){
                $id = explode('/', $value['link']);
                $profiledata['links'][$key]['id'] = end($id);
            }

            if($value['type'] == 'opensea'){
                preg_match("/^https?:\/\/(www.)?(opensea.io)\/assets\/(.*)\/(.*)\/(.*)/i", $value['link'], $match);
                $profiledata['links'][$key]['ids'] = $match;
            }

            if($value['type'] == 'typeform'){
                preg_match("/^https?:\/\/(www.)?((.*).typeform.com)\/to\/(.*)/i", $value['link'], $match);                
                $profiledata['links'][$key]['ids'] = end($match);
                View::push('<style>.tf-v1-widget, .tf-v1-widget iframe { min-height: 400px}</style>', 'custom')->toHeader();
            }

            if($value['type'] == 'reddit'){
                preg_match("/^https?:\/\/(www.)?((.*).reddit.com)\/user\/(.*)/i", $value['link'], $match);                
                $profiledata['links'][$key]['ids'] = trim(end($match), '/');
            }

            if($value['type'] == 'tagline' ){
                $profiledata['tagline'] = clean($value['text']);
            }

            if($value['type'] == 'calendly' ){
                View::push('https://assets.calendly.com/assets/external/widget.css', 'css')->toHeader();
                View::push('https://assets.calendly.com/assets/external/widget.js', 'script')->toFooter();
            }
        }

        return View::with('gates.profile', compact('profile', 'profiledata', 'user', 'sitetitle'))->extend('layouts.auth');

    }
    /**
     * Bundle
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param [type] $profile
     * @return void
     */
    public static function bundle($profile, $bundle, $user = null){

        if(!$user) $user = \Models\User::where('id', $profile->userid)->first();

        $profiledata = json_decode($profile->data, true);

        View::push('<style>body{min-height: 100vh;color: '.$profiledata['style']['textcolor'].'background: '.$profiledata['style']['bg'].';background: linear-gradient(135deg,'.$profiledata['style']['gradient']['start'].' 0%, '.$profiledata['style']['gradient']['stop'].' 100%);}.fab{font-size: 1.5em}h1,h3,em,p,a{color: '.$profiledata['style']['textcolor'].' !important;}a:hover{color: '.$profiledata['style']['textcolor'].';opacity: 0.8;}.btn-custom{background: '.$profiledata['style']['buttoncolor'].';color: '.$profiledata['style']['buttontextcolor'].' !important;border:0;}.btn-custom:hover{background: '.$profiledata['style']['buttoncolor'].';opacity: 0.8;color: '.$profiledata['style']['buttontextcolor'].';}.cc-floating.cc-type-info.cc-theme-classic .cc-btn{color:#000 !important}</style>','custom')->toHeader();

        $urls = \Models\Url::recent()->where('bundle', $bundle->id)->orderByDesc('date')->paginate(10, true);

        View::set('title', $profile->name.' '.e('List'));

        // @group Plugin
        \Core\Plugin::dispatch('type.campaign', $profile);

        return View::with('gates.list', compact('profile', 'profiledata', 'user', 'urls'))->extend('layouts.auth');

    }
    /**
     * Inject Pixel
     *
     * @author GemPixel <https://gempixel.com>
     * @version 6.0
     * @param string $pixels
     * @param object $user
     * @return void
     */
    protected static function injectPixels($pixels, object $user){
        if(!$pixels) return;
		$pixels = explode(",", $pixels);
		$output = "";
        foreach ($pixels as $pixel) {

            if(empty($pixel) || is_null($pixel)) continue;

            [$name, $id] = explode("-", $pixel);

            if(!$pixelInfo = \Core\DB::pixels()->select('tag')->where('userid', $user->id)->where('id', $id)->first()) continue;

            $output .= self::display($name, $pixelInfo->tag)."\n";
            \Core\View::push(self::display($name, $pixelInfo->tag), "custom")->toHeader();
        }

        return $output;
	}
}