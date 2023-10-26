<section class="slice slice-lg py-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'bg-white', 'bg-section-dark') ?>" <?php echo themeSettings::config('homecolor') ?>>
    <div class="container d-flex align-items-center" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> font-weight-bolder mb-4">
                    <?php ee('QR Codes') ?>
                </h1>                    
                <p class="lead <?php echo \Helpers\App::themeConfig('homestyle', 'light', 'text-dark', 'text-white') ?> opacity-8">
                    <?php ee('Easy to use, dynamic and customizable QR codes for your marketing campaigns. Analyze statistics and optimize your marketing strategy and increase engagement.') ?>
                </p>  
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact') ?>" class="btn btn-secondary"><?php ee('Contact us') ?></a>
                </p>              
            </div>
            <div class="col-md-5 text-center">
                <div class="row">
                    <div class="col-6">
                        <div class="card bg-primary shadow rounded-3 border-0">
                            <div class="px-4 py-5 text-center text-white">
                                <div class="h1 mb-3">
                                    <i class="fa fa-qrcode fw-bolder"></i>
                                </div>
                                <h5 class="fw-bolder text-white"><?php ee('Advanced QR Codes') ?></h5>
                            </div>
                        </div>
                        <div class="card shadow rounded-3 border-0 mt-5">
                            <div class="px-4 py-5 text-center text-primary">
                                <div class="h1 mb-3">
                                    <i class="fa fa-eyedropper"></i>
                                </div>
                                <h5 class="fw-bolder"><?php ee('Customize Colors') ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 pt-lg-5">
                        <div class="card shadow rounded-3 border-0 mt-5">
                            <div class="px-4 py-5 text-center text-dark">
                                <div class="h1 mb-3">
                                    <i class="fa fa-map-pin"></i>
                                </div>
                                <h5 class="fw-bolder"><?php ee('Track Scans') ?></h5>
                            </div>
                        </div>                            
                        <div class="card bg-primary shadow rounded-3 border-0 mt-5">
                            <div class="px-4 py-5 text-center text-white">
                                <div class="h1 mb-3">
                                    <i class="fa fa-wand-magic-sparkles fw-bolder"></i>
                                </div>
                                <h5 class="fw-bolder text-white"><?php ee('Customize Design & Frames') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
<section class="slice">
    <div class="container">
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5 order-lg-2">
                    <h5 class="h3"><?php ee('The new standard') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('QR Codes are everywhere and they are not going away. They are a great asset to your company because you can easily capture users and convert them. QR codes can be customized to match your company, brand or product.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="card mb-0 shadow-sm mr-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/qrcodes.png') ?>" alt="<?php ee('The new standard') ?>" class="img-responsive w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-process-step">
            <div class="row row-grid justify-content-between align-items-center">
                <div class="col-lg-5">
                    <h5 class="h3"><?php ee('Trackable to the dot') ?>.</h5>
                    <p class="lead my-4">
                        <?php ee('The beautify of QR codes is that almost any type of data can be encoded in them. Most types of data can be tracked very easily so you will know exactly when and from where a person scanned your QR code.') ?>
                    </p>
                    <a href="<?php echo route('register') ?>" class="btn btn-primary btn-sm"><?php ee('Get Started') ?></a>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-0 shadow-sm ml-lg-5">
                        <div class="card-body p-2">
                            <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   