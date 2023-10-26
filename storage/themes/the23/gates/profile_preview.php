<div class="container py-5 pb-2" id="profile">
     <div class="row">
        <div class="col-md-6 offset-md-3 text-center mt-5">
            <?php message() ?>
            <?php if(!isset($profiledata['style']['layout']) || $profiledata['style']['layout'] == 'layout1'): ?>                
                <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                    <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                        <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                    <?php else: ?>
                        <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                    <?php endif ?>
                <?php endif ?>
                <h3>
                    <span><?php echo $profile->name ?></span>
                    <?php if($user->verified): ?>
                        <span class="text-success fw-bold ms-2 bg-white rounded-circle checkmark" data-bs-toggle="tooltip" data-placement="top" title="<?php ee('Verified Account') ?>"><i class="fa fa-check-circle"></i></span>
                    <?php endif ?>
                </h3>
                <?php if(isset($profiledata['tagline'])): ?>
                    <p><?php echo $profiledata['tagline'] ?></p>
                <?php endif ?>
                <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                    <?php if(isset($profiledata['social'])): ?>
                        <div id="social" class="text-center mt-3">
                            <?php foreach($profiledata['social'] as $key => $value): ?>
                                <?php if(empty($value)) continue ?>
                                <a href="#" class="ms-3" target="_blank" data-bs-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($key) ?>" rel="nofollow"><i class="fab fa-<?php echo $key ?>"></i></a>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php elseif($profiledata['style']['layout'] == 'layout2'): ?>
                <div class="layout2">
                    <div class="d-block p-3 rounded" style="background-color: <?php echo $profiledata['style']['bg'] ?>;<?php if(isset($profiledata['layoutbanner']) && $profiledata['layoutbanner']) echo 'background-image:url(\''.uploads($profiledata['layoutbanner'], 'profile').'\');background-size:cover;'; ?>">

                    </div>
                    <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                        <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                            <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                        <?php else: ?>
                            <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="120" height="120">
                        <?php endif ?>
                    <?php endif ?>
                    <h3>
                        <span><?php echo $profile->name ?></span>
                        <?php if($user->verified): ?>
                            <span class="text-success fw-bold ms-2 bg-white rounded-circle checkmark" data-bs-toggle="tooltip" data-placement="top" title="<?php ee('Verified Account') ?>"><i class="fa fa-check-circle"></i></span>
                        <?php endif ?>
                    </h3>
                    <?php if(isset($profiledata['tagline'])): ?>
                        <p><?php echo $profiledata['tagline'] ?></p>
                    <?php endif ?>
                    <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                        <?php if(isset($profiledata['social'])): ?>
                            <div id="social" class="text-center mt-3">
                                <?php foreach($profiledata['social'] as $key => $value): ?>
                                    <?php if(empty($value)) continue ?>
                                    <a href="#" class="ms-3" target="_blank" data-bs-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($key) ?>" rel="nofollow"><i class="fab fa-<?php echo $key ?>"></i></a>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                </div>                
            <?php elseif($profiledata['style']['layout'] == 'layout3'): ?>
                <div class="layout3">
                    <div class="d-block p-5 rounded" style="background-color: <?php echo $profiledata['style']['bg'] ?>;<?php if(isset($profiledata['layoutbanner']) && $profiledata['layoutbanner']) echo 'background-image:url(\''.uploads($profiledata['layoutbanner'], 'profile').'\');background-size:cover;'; ?>">
                        <div class="d-flex align-items-center">
                            <div>
                                <?php if(!isset($profiledata['avatarenabled']) || $profiledata['avatarenabled']): ?>
                                    <?php if(isset($profiledata['avatar']) && $profiledata['avatar']): ?>
                                        <img src="<?php echo uploads($profiledata['avatar'], 'profile') ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="80" height="80">
                                    <?php else: ?>
                                        <img src="<?php echo $user->avatar() ?>" class="<?php echo isset($profiledata['avatarstyle']) && $profiledata['avatarstyle'] == "rectangular" ? 'rounded' : 'rounded-circle' ?> mb-3 useravatar" width="80" height="80">
                                    <?php endif ?>
                                <?php endif ?>                                
                            </div>
                            <div class="ms-4 text-left text-start">
                                <h3>
                                    <span><?php echo $profile->name ?></span>
                                    <?php if($user->verified): ?>
                                        <span class="text-success fw-bold ms-2 bg-white rounded-circle checkmark text-center" data-bs-toggle="tooltip" data-placement="top" title="<?php ee('Verified Account') ?>"><i class="fa fa-check-circle"></i></span>
                                    <?php endif ?>
                                </h3>
                                <?php if(isset($profiledata['tagline'])): ?>
                                    <p><?php echo $profiledata['tagline'] ?></p>
                                <?php endif ?>
                                <?php if(!isset($profiledata['style']['socialposition']) || $profiledata['style']['socialposition'] == 'top'): ?>
                                    <?php if(isset($profiledata['social'])): ?>
                                        <div id="social" class="mt-3">
                                            <?php foreach($profiledata['social'] as $key => $value): ?>
                                                <?php if(empty($value)) continue ?>
                                                <a href="#" class="ms-3" target="_blank" data-bs-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($key) ?>" rel="nofollow"><i class="fab fa-<?php echo $key ?>"></i></a>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                            </div> 
                        </div>                    
                    </div>                    
                </div> 
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center my-4">
            <div id="content">
                <?php foreach($profiledata['links'] as $id => $value): ?>
                    <div class="item mb-3">
                        <?php if($value['type'] == "heading"): ?>
                            <?php if(in_array($value['format'], ['h1','h2','h3','h4','h5','h6'])):?>
                                <<?php echo $value['format'] ?> style="color:<?php echo $value['color'] ?? '' ?> !important"><?php echo $value['text'] ?></<?php echo $value['format'] ?>>
                            <?php else: ?>
                                <h1><?php echo $value['text'] ?></h1>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if($value['type'] == "divider"): ?>
                            <hr style="background:transparent;border-top-style:<?php echo $value['style'] ?? 'solid' ?> !important;border-top-width:<?php echo $value['height'] ?? '3' ?>px !important;border-top-color:<?php echo $value['color'] ?? '#000' ?> !important;border-radius: 5px;">
                        <?php endif ?>

                        <?php if($value['type'] == "image"): ?>
                            <?php if(isset($value['image2']) && $value['image2']): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <?php if($value['link']): ?>
                                            <a href="#" target="_blank" rel="nofollow"><img src="<?php echo uploads($value['image'], 'profile') ?>" class="img-fluid rounded w-100"></a>
                                        <?php else: ?>
                                            <img src="<?php echo uploads($value['image'], 'profile') ?>" class="img-fluid rounded w-100">
                                        <?php endif ?>                                        
                                    </div>
                                    <div class="col-6">
                                        <?php if(isset($value['link2']) && $value['link2']): ?>
                                            <a href="#" target="_blank" rel="nofollow"><img src="<?php echo uploads($value['image2'], 'profile') ?>" class="img-fluid rounded w-100"></a>
                                        <?php else: ?>
                                            <img src="<?php echo uploads($value['image2'], 'profile') ?>" class="img-fluid rounded w-100">
                                        <?php endif ?>                                         
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php if($value['link']): ?>
                                    <a href="#" target="_blank" rel="nofollow"><img src="<?php echo uploads($value['image'], 'profile') ?>" class="img-fluid rounded w-100"></a>
                                <?php else: ?>
                                    <img src="<?php echo uploads($value['image'], 'profile') ?>" class="img-fluid rounded w-100">
                                <?php endif ?>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if($value['type'] == "rss"): ?>
                            <div class="rss card card-body overflow-auto rounded-3">
                                <?php $items = \Helpers\App::rss($value['link']) ?>
                                <?php if(!is_array($items)): ?>
                                    <?php echo $items ?>
                                <?php else: ?>
                                    <?php foreach($items as $item): ?>
                                        <div class="media mb-3">
                                            <?php if($item['image']): ?>
                                                <img class="mr-3" src="<?php echo $item['image'] ?>" alt="<?php echo $item['title'] ?>">
                                            <?php endif ?>
                                            <div class="media-body">
                                                <h6 class="mt-3 fw-bolder"><a href="<?php echo $item['link'] ?>" target="_blank"><?php echo $item['title'] ?></a></h6>
                                                <?php echo $item['description'] ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <?php if($value['type'] == "text"): ?>
                            <div><?php echo $value['text'] ?></div>
                        <?php endif ?>

                        <?php if($value['type'] == "whatsapp"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative"><img src="<?php echo assets('images/whatsapp.svg') ?>" height="26" class="ms-3 position-absolute start-0"> <?php echo isset($value['label']) && $value['label'] ? $value['label'] : $value['phone'] ?></a>
                        <?php endif ?>

                        <?php if($value['type'] == "phone"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative"><i class="fa fa-phone ms-3 position-absolute start-0"></i> <?php echo isset($value['label']) && $value['label'] ? $value['label'] : $value['phone'] ?></a>
                        <?php endif ?>

                        <?php if($value['type'] == "whatsappmessage"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative"><img src="<?php echo assets('images/whatsapp.svg') ?>" height="26" class="ms-3 position-absolute start-0"> <?php echo isset($value['label']) && $value['label'] ? $value['label'] : $value['phone'] ?></a>
                        <?php endif ?>

                        <?php if($value['type'] == "link"): ?>
                            <a href="#" class="<?php echo (isset($value['animation']) && in_array($value['animation'], ['shake','wobble','vibrate','jello','scale']) ? 'animate_'.$value['animation'].' ':'') ?>btn btn-block d-block p-3 btn-custom position-relative">
                                <?php echo ($value['icon'] ?? '' ? '<i class="'.$value['icon'].' position-absolute start-0 ms-3"></i>' : '') ?> <span class="align-top"><?php echo $value['text'] ?></span>
                            </a>
                        <?php endif ?>

                        <?php if($value['type'] == "youtube"): ?>
                            <iframe width="100%" height="315" src="<?php echo $value["link"] ?>" class="rounded"></iframe>
                        <?php endif ?>

                        <?php if($value['type'] == "itunes"): ?>
                            <iframe width="100%" height="450" src="<?php echo $value["link"] ?>" class="rounded"></iframe>
                        <?php endif ?>
                        <?php if($value['type'] == "paypal"): ?>

                            <form action="#">

                                <input type="hidden" name="business" value="<?php echo $value['email'] ?>">

                                <input type="hidden" name="cmd" value="_xclick">

                                <input type="hidden" name="item_name" value="<?php echo $value['label'] ?>">
                                <input type="hidden" name="amount" value="<?php echo $value['amount'] ?>">
                                <input type="hidden" name="currency_code" value="<?php echo $value['currency'] ?>">

                                <button type="submit" name="submit" class="btn btn-block d-block p-3 btn-custom w-100"><?php echo $value['label'] ?></button>
                            </form>
                        <?php endif ?>
                        <?php if($value['type'] == "spotify"): ?>
                            <iframe width="100%" height="232" src="<?php echo $value["link"] ?>" class="rounded"></iframe>
                        <?php endif ?>
                        <?php if($value['type'] == "tiktok"): ?>
                            <blockquote class="tiktok-embed rounded btn-rounded" cite="<?php echo $value['link'] ?>" data-video-id="<?php echo $value['id'] ?>" style="max-width: 605px;min-width: 325px;" > <section> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>
                        <?php endif ?>
                        <?php if($value['type'] == "html"): ?>
                            <?php echo $value['html'] ?>
                        <?php endif ?>
                        <?php if($value['type'] == "newsletter"): ?>
                            <a href="#" data-bs-target="#N<?php echo $id ?>" data-bs-toggle="collapse" role="button" class="btn btn-block d-block p-3 btn-custom position-relative">
                                <span class="align-top"><?php echo $value['text'] ?></span>
                                <i class="fa fa-chevron-down position-absolute end-0 me-3"></i>
                            </a>
                            <form method="post" action="#" class="collapse" id="N<?php echo $id ?>">
                                <div class="d-flex align-items-center border rounded bg-white p-2 mt-4">
                                    <div class="flex-fill">
                                        <input type="text" class="form-control border-0 bg-white" name="email" placeholder="johnsmith@company.com">
                                    </div>
                                    <div class="ms-auto">
                                        <button type="submit" class="btn btn-custom"><?php echo $value['text'] ?></button>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="newsletter">
                                <input type="hidden" name="blockid" value="<?php echo $id ?>">
                            </form>
                        <?php endif ?>
                        <?php if($value['type'] == "contact"): ?>
                            <a href="#" data-bs-target="#C<?php echo $id ?>" data-bs-toggle="collapse" role="button" class="btn btn-block d-block p-3 btn-custom position-relative">
                                <span class="align-top"><?php echo $value['text'] ?></span>
                                <i class="fa fa-chevron-down position-absolute end-0 me-3"></i>
                            </a>
                            <form method="get" action="#" id="C<?php echo $id ?>" class="collapse border rounded text-start p-3 mt-3">
                                <div class="form-group mb-2">
                                    <label for="email" class="form-label fw-bold"><?php ee('Email') ?></label>
                                    <input type="text" class="form-control" name="email" placeholder="johnsmith@company.com">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="email" class="form-label fw-bold"><?php ee('Message') ?></label>
                                    <textarea class="form-control" name="message"></textarea>
                                </div>
                                <?php csrf() ?>
                                <input type="hidden" name="action" value="contact">
                                <input type="hidden" name="blockid" value="<?php echo $id ?>">
                                <?php echo \Helpers\Captcha::display(); ?>
                                <button type="submit" class="btn btn-custom d-block"><?php echo ee('Send') ?></button>
                            </form>
                        <?php endif ?>
                        <?php if($value['type'] == "vcard"): ?>
                            <button type="submit" class="btn btn-custom btn-block d-block w-100 p-3"><?php echo !empty($value['button']) ? $value['button'] : e('Download vCard') ?></button>
                        <?php endif ?>
                        <?php if($value['type'] == "product"): ?>
                            <a href="#" target="_blank" class="d-block btn-custom rounded-3 p-2 mt-2 text-start text-left" rel="nofollow">
                                <div class="d-flex align-items-center">
                                    <?php if(isset($value['image']) && $value['image']): ?>
                                    <div class="mr-3 me-3">
                                        <img src="<?php echo uploads($value['image'], 'profile') ?>" class="rounded" style="max-width: 130px">
                                    </div>
                                    <?php endif ?>
                                    <div class="text-left text-start">
                                        <h3 class="mb-1"><?php echo $value['name'] ?></h3>
                                        <strong><?php echo $value['amount'] ?></strong>
                                        <p><?php echo $value['description'] ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endif ?>
                        <?php if($value['type'] == "twitter"): ?>
                            <div class="mb-1">
                                <a class="twitter-timeline" data-width="100%" data-tweet-limit="<?php echo $value['amount'] ?>" href="<?php echo $value['link'] ?>" data-chrome="nofooter">Tweets</a>
                                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                            </div>
                        <?php endif ?>
                        <?php if($value['type'] == "facebook"): ?>
                            <div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0" nonce="WaCixDC1"></script><div class="fb-post" data-href="<?php echo $value['link'] ?>" data-show-text="true"></div>
                        <?php endif ?>
                        <?php if($value['type'] == "instagram"): ?>
                            <blockquote class="instagram-media" data-instgrm-permalink="<?php echo $value['link'] ?>" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"></blockquote><script async src="//www.instagram.com/embed.js"></script>
                        <?php endif ?>
                        <?php if($value['type'] == "soundcloud"): ?>
                            <div class="mb-1">
                                <iframe width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=<?php echo urlencode($value['link']) ?>&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe>
                            </div>
                        <?php endif ?>
                        <?php if($value['type'] == "opensea"): ?>
                            <div class="mb-1">
                                <nft-card width="100%" contractAddress="<?php echo $value['ids'][4] ?>" tokenId="<?php echo $value['ids'][5] ?>"> </nft-card>
                                <script src="https://unpkg.com/embeddable-nfts/dist/nft-card.min.js"></script>
                            </div>
                        <?php endif ?>
                        <?php if($value['type'] == "faqs"): ?>
                            <div class="card mb-2 rounded-3 faqs">
                                <?php if(!isset($value['question'])) return ?>
                                <?php foreach($value['question'] as $i => $question): ?>                                
                                    <div class="card-body text-start">
                                        <a href="#faq-<?php echo $i ?>" class="collapsed" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $i ?>">
                                            <h6 class="card-title fw-bold mb-0">
                                                <i class="fa fa-chevron-down me-2"></i>
                                                <span class="align-middle"><?php echo $question ?></span>
                                            </h6>
                                        </a>
                                        <div class="collapse pt-3" id="faq-<?php echo $i ?>">
                                            <?php echo $value['answer'][$i] ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                        <?php if($value['type'] == "typeform"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-bs-toggle="modal" data-bs-target="modal-<?php echo $id?>"><?php echo isset($value['name']) && $value['name'] ? $value['name'] : 'Typeform' ?></a>
                        <?php endif ?>
                        <?php if($value['type'] == "pinterest"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $id?>"><?php echo isset($value['name']) && $value['name'] ? $value['name'] : 'Pinterest Board' ?></a>
                        <?php endif ?>
                        <?php if($value['type'] == "reddit"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $id?>"><?php echo isset($value['name']) && $value['name'] ? $value['name'] : 'Reddit' ?></a>
                        <?php endif ?>
                        <?php if($value['type'] == "calendly"): ?>
                            <a href="#" class="btn btn-block d-block p-3 btn-custom position-relative"><?php echo isset($value['name']) && $value['name'] ? $value['name'] : 'Calendly' ?></a>
                        <?php endif ?>
                        <?php if($value['type'] == "threads"): ?>
                            <blockquote class="text-post-media btn-custom" data-text-post-permalink="<?php echo $value['link'] ?>" data-text-post-version="0" id="ig-tp-Cvk_NVnyZV9" style=" background:#FFF; border-width: 1px; border-style: solid; border-color: #00000026; border-radius: 16px; max-width:660px; margin: 1px; min-width:270px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"> <a href="<?php echo $value['link'] ?>" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%; font-family: -apple-system, BlinkMacSystemFont, sans-serif;" target="_blank"> <div style=" padding: 40px; display: flex; flex-direction: column; align-items: center;"><div style=" display:block; height:32px; width:32px; padding-bottom:20px;"> <svg aria-label="Threads" height="32px" role="img" viewBox="0 0 192 192" width="32px" xmlns="http://www.w3.org/2000/svg"> <path d="M141.537 88.9883C140.71 88.5919 139.87 88.2104 139.019 87.8451C137.537 60.5382 122.616 44.905 97.5619 44.745C97.4484 44.7443 97.3355 44.7443 97.222 44.7443C82.2364 44.7443 69.7731 51.1409 62.102 62.7807L75.881 72.2328C81.6116 63.5383 90.6052 61.6848 97.2286 61.6848C97.3051 61.6848 97.3819 61.6848 97.4576 61.6855C105.707 61.7381 111.932 64.1366 115.961 68.814C118.893 72.2193 120.854 76.925 121.825 82.8638C114.511 81.6207 106.601 81.2385 98.145 81.7233C74.3247 83.0954 59.0111 96.9879 60.0396 116.292C60.5615 126.084 65.4397 134.508 73.775 140.011C80.8224 144.663 89.899 146.938 99.3323 146.423C111.79 145.74 121.563 140.987 128.381 132.296C133.559 125.696 136.834 117.143 138.28 106.366C144.217 109.949 148.617 114.664 151.047 120.332C155.179 129.967 155.42 145.8 142.501 158.708C131.182 170.016 117.576 174.908 97.0135 175.059C74.2042 174.89 56.9538 167.575 45.7381 153.317C35.2355 139.966 29.8077 120.682 29.6052 96C29.8077 71.3178 35.2355 52.0336 45.7381 38.6827C56.9538 24.4249 74.2039 17.11 97.0132 16.9405C119.988 17.1113 137.539 24.4614 149.184 38.788C154.894 45.8136 159.199 54.6488 162.037 64.9503L178.184 60.6422C174.744 47.9622 169.331 37.0357 161.965 27.974C147.036 9.60668 125.202 0.195148 97.0695 0H96.9569C68.8816 0.19447 47.2921 9.6418 32.7883 28.0793C19.8819 44.4864 13.2244 67.3157 13.0007 95.9325L13 96L13.0007 96.0675C13.2244 124.684 19.8819 147.514 32.7883 163.921C47.2921 182.358 68.8816 191.806 96.9569 192H97.0695C122.03 191.827 139.624 185.292 154.118 170.811C173.081 151.866 172.51 128.119 166.26 113.541C161.776 103.087 153.227 94.5962 141.537 88.9883ZM98.4405 129.507C88.0005 130.095 77.1544 125.409 76.6196 115.372C76.2232 107.93 81.9158 99.626 99.0812 98.6368C101.047 98.5234 102.976 98.468 104.871 98.468C111.106 98.468 116.939 99.0737 122.242 100.233C120.264 124.935 108.662 128.946 98.4405 129.507Z" /></svg></div><div style=" font-size: 15px; line-height: 21px; color: #000000; font-weight: 600; "> View on Threads</div></div></a></blockquote> <script async src="https://www.threads.net/embed.js"></script>
                        <?php endif ?>
                        <?php if($value['type'] == "tiktokprofile"): ?>
                            <blockquote class="tiktok-embed btn-custom rounded" cite="<?php echo $value['link'] ?>" data-unique-id="<?php echo str_replace('https://www.tiktok.com/@', '', $value['link']) ?>" data-embed-type="creator" style="max-width: 660px; min-width: 288px;" > <section> <a target="_blank" href="<?php echo $value['link'] ?>?refer=creator_embed">@<?php echo str_replace('https://www.tiktok.com/@', '', $value['link']) ?></a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>                             
                        <?php endif ?>
                        <?php if($value['type'] == "googlemaps"): ?>
                            <iframe src="https://maps.google.com/maps?q=<?php echo urlencode($value['address']) ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="250" style="border:0;" class="rounded" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                            
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
            <?php if(isset($profiledata['style']['socialposition']) && $profiledata['style']['socialposition'] == 'bottom'): ?>
            <div id="social" class="text-center mt-5">
                <?php foreach($profiledata['social'] as $key => $value): ?>
                    <?php if(empty($value)) continue ?>
                    <a href="#" class="ms-3" target="_blank" data-bs-toggle="tooltip" data-placement="top" title="<?php echo ucfirst($key) ?>" rel="nofollow"><i class="fab fa-<?php echo $key ?>"></i></a>
                <?php endforeach ?>
            </div>
            <?php endif ?>
        </div>
    </div>
    <?php if(!isset($profiledata['settings']['branding']) || !$profiledata['settings']['branding']): ?>
    <div class="text-center mt-3 opacity-8">
        <a class="navbar-brand me-0" href="#">
            <?php if(config('logo')): ?>
                <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" width="80" id="navbar-logo">
            <?php else: ?>
                <h1 class="h5 mt-2"><?php echo config('title') ?></h1>
            <?php endif ?>
        </a>
    </div>
    <?php endif ?>
</div>