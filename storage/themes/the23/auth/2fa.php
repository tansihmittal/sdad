<section class="bg-primary min-vh-100 pt-5">
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center justify-content-lg-start min-vh-100">
            <div class="row justify-content-center px-0 px-sm-5">
                <div class="col-12 col-lg-5">
                    <a href="<?php echo route('home') ?>" class="mb-5 mb-md-0 text-dark text-decoration-none text-center">
                    <?php if(config('logo')): ?>
                        <img alt="<?php echo config('title') ?>" src="<?php echo uploads(config('logo')) ?>" id="navbar-logo">
                    <?php else: ?>
                        <h1 class="h5 fw-bold"><?php echo config('title') ?></h1>
                    <?php endif ?>
                    </a>
                    <div class="card border-0 p-5 shadow-sm mt-5">
                        <div class="mb-3 text-center">
                            <h6 class="mb-2"><?php ee('Enter your 2FA access code') ?></h6>
                            <p class="text-muted mb-0"><?php ee("The access code can be found on the Authenticator app. Please enter the code shown for this website. If you lost your phone or can't use the app, please contact us.") ?></p>
                        </div>
                        <?php message() ?>
                        <form method="post" action="<?php echo route('login.2fa.validate') ?>">
                            <div class="my-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" size="6" name="secret" id="input-code" placeholder="e.g.123456" data-mask="000 000" required>
                                    <label><?php ee('2FA Access Code') ?></label>
                                </div>
							</div>
                            <div class="mt-4">
                                <?php echo csrf() ?>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2"><?php ee('Validate') ?></button>
                                </div>
                            </div>                        
                        </form>
                    </div>
                    <div class="text-center mt-5">&copy; <?php echo date("Y") ?> <a href="<?php echo config('url') ?>" class="fw-bold"><?php echo config('title') ?></a>. <?php ee('All Rights Reserved') ?></p>
                </div>
            </div>
        </div>
    </div>
</section>