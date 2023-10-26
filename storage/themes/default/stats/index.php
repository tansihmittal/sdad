<?php view('stats.partial', ['url' => $url, 'top' => $top]) ?>

<div class="card border-0 card-body shadow-sm mb-4">
    <div class="align-items-center">
        <?php view('partials.stats_nav', ['url' => $url]) ?>
    </div>
</div>

<div class="d-flex mb-4 align-items-center">
    <h3 class="mb-0 fw-bold"><?php ee('Clicks') ?></h3>
    <div class="ms-auto ml-auto card border-0 mb-0 shadow-sm p-2">
        <input type="text" name="customreport" data-action="customreport" class="form-control border-0" placeholder="<?php echo e("Choose a date range to update stats") ?>">
    </div> 
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body py-3">
        <div>
            <canvas data-trigger="chart" data-url="<?php echo route('data.clicks', [$url->id]) ?>" height="400"></canvas>
        </div>
    </div>
</div>

<h3 class="mt-5 mb-4 fw-bold"><?php ee('Recent Activity') ?></h3>
<div class="card border-0 shadow-sm">
    <div class="card-body no-checkbox">
        <?php foreach($recentActivity as $stats): ?>
            <div class="d-flex align-items-start">
                <div class="flex-grow-1">                                    
                    <?php if($stats->country): ?>
                        <img src="<?php echo \Helpers\App::flag($stats->country) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->country) ?>">
                        <span class="mr-3 me-3 align-middle"><?php echo $stats->city ? ucfirst($stats->city).',': e('Somewhere from') ?> <?php echo ucfirst($stats->country) ?></span>
                    <?php endif ?>
                    <?php if($stats->os): ?>
                        <img src="<?php echo \Helpers\App::os($stats->os) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->os) ?>">
                        <span class="mr-3 me-3 align-middle text-navy"><?php echo $stats->os ?></span> 
                    <?php endif ?>
                    <?php if($stats->browser): ?>
                        <img src="<?php echo \Helpers\App::browser($stats->browser) ?>" width="16" class="rounded me-1" alt=" <?php echo ucfirst($stats->browser) ?>">
                        <span class="mr-3 me-3 align-middle text-navy"><?php echo $stats->browser ?></span>
                    <?php endif ?>
                    <?php if($stats->domain): ?>
                        <i data-feather="globe" class="me-1"></i>
                        <a href="<?php echo $stats->referer ?>" rel="nofollow" target="_blank"><span class="mr-3 me-3 align-middle text-navy"><?php echo $stats->domain ?></span></a>
                    <?php else: ?>
                        <i data-feather="globe" class="me-1"></i>
                        <span class="mr-3 me-3 align-middle text-navy"><?php echo ee('Direct, email or others') ?></span>
                    <?php endif ?>
                    <?php if($stats->language): ?>
                        <i data-feather="user" class="me-1"></i>
                        <span class="mr-3 me-3 align-middle text-navy"><?php echo \Helpers\App::languagelist($stats->language, true) ?></span>
                    <?php endif ?>
                    <div class="mt-1">
                        <small class="fw-bold"><?php echo \Core\Helper::timeago($stats->date) ?></small>
                    </div>
                </div>
            </div>
            <hr>
        <?php endforeach ?>            
    </div>
</div> 