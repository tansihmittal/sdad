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

use Core\Request;
use Core\Response;
use Core\DB;
use Core\Helper;
use Core\Localization;
use Core\View;
use Core\Email;
use Core\Auth;
use Core\Plugin;

class Page {
    use \Traits\Pixels;
    /**
     * Get Custom Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param string $page
     * @return void
     */
    public function index(string $slug){
        
        $locale = Localization::locale();

        if(!$page = DB::page()->where('seo', Helper::RequestClean($slug))->first()){
            stop(404);
        }        

        $page->lastupdated = date('F d, Y', strtotime($page->lastupdated));
        $page->metadata = $page->metadata ? json_decode($page->metadata) : [];

        View::set('title', $page->metadata->title ?? $page->name);

        View::set('description', $page->metadata->description ?? Helper::truncate($page->name, 150));

        if($page->category == "main"){
            $template = 'pages.main';            
        } else {
            $template = 'pages.index';
        }

        return View::with($template, compact('page'))->extend('layouts.main');
    }
    /**
     * Contact Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function contact(){

        if(!config('contact')) stop(404);

        View::set('title', e('Contact Us'));

        // @group Plugin
        Plugin::dispatch('contact');

        return View::with('pages.contact')->extend('layouts.main');
    }   

    /**
     * Send Contact Form
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function contactSend(Request $request){

        if(!config('contact')) stop(404);

        if(!Helper::Email($request->email)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid email.'),
                'token' => csrf_token()
            ]))->json();
        }

        
        
        $message = 'Name: '.Helper::RequestClean($request->name).'<br>Email: '.Helper::RequestClean($request->email).'<br><br>'.Helper::RequestClean($request->message);

        // @group Plugin
        Plugin::dispatch('contacted', ['name' => Helper::RequestClean($request->name), 'email' => Helper::RequestClean($request->email), 'message' => Helper::RequestClean($request->message)]);

        \Helpers\Emails::setup()
                ->replyto([Helper::RequestClean($request->email),Helper::RequestClean($request->name)])
                ->to(config('email'))
                ->send([
                    'subject' => '['.config('title').'] You have been contacted!',
                    'message' => function($template, $data) use ($message){

                        if(config('logo')){
                            $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" title="Image" width="166"/>';
                        } else {
                            $title = '<h3>'.config('title').'</h3>';
                        }

                        return Email::parse($template, ['content' => $message, 'brand' => $title]);
                   }
                ]);

        return (new Response([
            'error' => false,
            'message' => e('Your message has been sent. We will reply you as soon as possible.'),
            'html' => '<script>$(\'form input, form textarea\').val(\'\');</script>',
            'token' => csrf_token()
        ]))->json();
    }
    /**
     * Report Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function report(){
        
        if(!config('report')) stop(404);

        View::set('title', e('Report Link'));

        // @group Plugin
        Plugin::dispatch('report');

        return View::with('pages.report')->extend('layouts.main');
    }
    /**
     * Send Report
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @param \Core\Request $request
     * @return void
     */
    public function reportSend(Request $request){

        if(!config('report')) stop(404);

        if(!Helper::Email($request->email)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid email.'),
                'token' => csrf_token()
            ]))->json();
        }

        if(!$request->link || !filter_var($request->link, FILTER_VALIDATE_URL)) {
            return (new Response([
                'error' => true,
                'message' => e('Please enter a valid link.'),
                'token' => csrf_token()
            ]))->json();
        }

        // @group Plugin
        Plugin::dispatch('reported', ['email' => Helper::RequestClean($request->email), 'link' => Helper::RequestClean($request->link)]);

        if(!DB::reports()->where('url', $request->link)->first()){

            $report = DB::reports()->create();
            $report->url = Helper::RequestClean($request->link);
            $report->type = Helper::RequestClean($request->reason);
            $report->email = Helper::RequestClean($request->email);            
            $report->status = 0;
            $report->ip = appConfig('haship') ? md5(AuthToken.$request->ip()) : $request->ip();
            $report->date = Helper::dtime();
            $report->save();

            $smtp = config('smtp');

            \Helpers\Emails::setup()
                    ->replyto([Helper::RequestClean($request->email)])
                    ->to(config('email'))
                    ->send([
                        'subject' => '['.config('title').'] A link has been reported!',
                        'message' => function($template, $data) use ($report){
                            if(config('logo')){
                                $title = '<img align="center" border="0" class="center autowidth" src="'.uploads(config('logo')).'" style="text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 166px; display: block;" width="166"/>';
                            } else {
                                $title = '<h3>'.config('title').'</h3>';
                            }

                            return Email::parse($template, ['content' => 'A user reported a link as '.clean($report->type).'. Please review the link below and ban it in Admin > Links > Reported Links if necessary to keep your website clean. Do not delete the link because they will be able shorten it again.<br>'.clean($report->url), 'brand' => $title]);
                       }
                    ]);
                
        }    
        return (new Response([
            'error' => false,
            'message' => e('Thank you. We will review this link and take action.'),
            'token' => csrf_token()
        ]))->json();
    }
    /**
     * FAQ Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.2
     * @deprecated 6.7
     * @return void
     */
    public function faq(){    
        return Helper::redirect(null, 301)->to(route('help'));
    }
    /**
     * API Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function api(){
        
        if(!config('api')) return stop(404);

        View::set('title', e('API Reference for Developers'));
        
        $token = Auth::logged() && Auth::user()->has('api') ? Auth::user()->api : 'YOURAPIKEY';       

        $api = appConfig('api');
        
        $menu = [];

        if($extended = \Core\Plugin::dispatch('apidocs.extend')){
			foreach($extended as $array){
				$api = array_merge($api, $array);
			}
		}

        asort($api);
        $content = [];

        foreach($api as $key => $data){

            if(isset($data['admin']) && $data['admin'] && (!Auth::logged() || !Auth::user()->admin)) continue;

            $menu[$key] = [];
            $menu[$key]['title'] = $data['title'];
            $menu[$key]['endpoints'] = [];
            $menu[$key]['admin'] = isset($data['admin']) && $data['admin'] ? true : false;

            foreach($data['endpoints'] as $endpoint){                
                $menu[$key]['endpoints'][Helper::slug($endpoint['title'])] = $endpoint['title'];
            }
            $content[$key] = $data;
        }

        $rate = appConfig('app.throttle');

        \Helpers\CDN::load('hljs');
        View::push('<script>hljs.highlightAll();</script>','custom')->toFooter();
        View::push(assets('frontend/libs/clipboard/dist/clipboard.min.js'), 'js')->toFooter();

        // @group Plugin
        Plugin::dispatch('api');

        return View::with('pages.api', compact('token', 'rate', 'menu', 'api', 'content'))->extend('layouts.api');
    }

    /**
     * Affiliate Page
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function affiliate(){

        $affiliate = config('affiliate');

        if(!config('pro') || !$affiliate->enabled) {
            stop(404);
        }

        View::set('title', e('Affiliate Program'));

        // @group Plugin
        Plugin::dispatch('affiliate');

        return View::with('pages.affiliate', compact('affiliate'))->extend('layouts.main');
    }
    /**
     * QR Codes
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function qr(){

        View::set('title', e('QR Codes'));

        View::set('description', e('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.'));

        return View::with('pages.qr')->extend('layouts.main');        
    }
    /**
     * Bio Profiles
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.0
     * @return void
     */
    public function bio(){

        View::set('title', e('Bio Pages'));
        
        View::set('description', e('Convert your followers by creating beautiful pages that group all of your important links on the single page.'));

        return View::with('pages.bio')->extend('layouts.main'); 
    }
    /**
     * Consent
     *
     * @author GemPixel <https://gempixel.com> 
     * @version 6.3
     * @return void
     */
    public function consent(Request $request){

        if($request->accept){
            $request->cookie('cookieconsent_status', 'dismiss', 15*60*24);
            return Helper::redirect()->to($request->session('redirectbackto'));
        }
        
        View::set('title', e('Cookie Policy Consent'));

        return View::with('pages.consent')->extend('layouts.api'); 
    }
}