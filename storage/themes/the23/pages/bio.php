<section class="py-4">
    <div class="container align-items-center" data-offset-top="#navbar-main">
        <div class="row align-items-center py-8">
            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-4">
                    <?php ee('Bio Pages') ?>
                </h1>                    
                <p class="lead opacity-8 ">
                    <?php ee('Convert your followers by creating beautiful pages that group all of your important links on the single page.') ?>
                </p>  
                <p class="my-5">
                    <a href="<?php echo route('register') ?>" class="btn btn-primary px-5 py-3 fw-bold"><?php ee('Get Started') ?></a>
                    <a href="<?php echo route('contact', ['subject' => 'Contact Sales']) ?>" class="btn btn-transparent text-dark fw-bold"><?php ee('Contact sales') ?></a>
                </p>             
            </div>
            <div class="col-md-5 text-center">
                <div class="card gradient-primary border-0 shadow p-5">
                    <span class="rounded-circle mb-3 d-block bg-white mx-auto opacity-8" style="width:100px;height:100px"><img src="<?php echo assets('images/avatar-f1.svg') ?>" class="img-fluid rounded-circle"></span>
                    <h3 class="text-white fw-bold"><span><?php echo config('title') ?></span></h3></em>
                    <div id="social" class="text-center mt-2">
                        <a href="<?php echo config('facebook') ?>" class="mx-2 text-white"><i class="fab fa-facebook"></i></a>
                        <a href="<?php echo config('twitter') ?>" class="mx-2 text-white"><i class="fab fa-twitter"></i></a>
                    </div>
                    <div id="content" class="mt-5">
                        <div class="item mb-3">
                            <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🛒 <?php ee('New Merch') ?></a>
                        </div>
                        <div class="item mb-3">
                            <a href="#" class="btn d-block btn-light text-primary shadow-sm py-3">🔥 <?php ee('Shop') ?></a>
                        </div>
                    </div>                     
                </div>               
            </div>
        </div> 
    </div>
</section>
<section class="bg-primary py-10">
    <div class="container">
        <div class="row row-grid justify-content-between align-items-center">
            <div class="col-lg-5 order-lg-2">
                <h5 class="h3 fw-bold"><?php ee('One link to rule them all') ?>.</h5>
                <p class="lead my-4">
                    <?php ee('Create beautiful profiles and add content like links, donation, videos and more for your social media users. Share a single on your social media profiles so your users can easily find all of your important links on a single page.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6 order-lg-1">
                <img src="<?php echo assets('images/profiles.png') ?>" alt="<?php ee('The new standard') ?>" class="img-responsive w-100">
            </div>
        </div>
        <div class="row row-grid justify-content-between align-items-center mt-10">
            <div class="col-lg-5">
                <h5 class="h3 fw-bold"><?php ee('Trackable to the dot') ?>.</h5>
                <p class="lead my-4">
                <?php ee('Profiles are fully trackable and you can find out exactly how many people have visited your profiles or clicked links on your profile and where they are from.') ?>
                </p>
                <a href="<?php echo route('register') ?>" class="btn btn-primary rounded-pill"><?php ee('Get Started') ?></a>
            </div>
            <div class="col-lg-6">
                <img src="<?php echo assets('images/map.png') ?>" alt="<?php ee('Trackable to the dot') ?>" class="img-responsive w-100 py-5">
            </div>
        </div>
        <div class="h-100 p-5 mt-10 gradient-primary text-white with-shapes rounded-4 border-0 ">
			<div class="row align-items-center gy-lg-5">
				<div class="col-sm-8">
					<h2 class="fw-bold"><?php ee('Take control of your links') ?></h2>
					<p><?php ee('You are one click away from taking control of all of your links, and instantly get better results.') ?></p>
				</div>
				<div class="col-sm-4 text-end">
					<a class="btn btn-light text-primary btn-lg d-block d-sm-inline-block" href="<?php echo route('register') ?>"><?php ee('Get Started') ?></a>
				</div>
			</div>
		</div>
    </div>
</section>      