<a class="sidebar-toggle d-flex">
    <i class="hamburger align-self-center"></i>
</a>

<form class="d-none d-sm-inline-block" method="get" action="<?php echo route('admin.search') ?>">
    <div class="input-group input-group-navbar">
        <input type="text" class="form-control" name="q" value="<?php echo (new \Core\Request)->q ?>" placeholder="Search for ..." aria-label="Search">
        <select class="form-select border-0" name="type">
            <option value="links"><?php ee('Links') ?></option>
            <option value="users"><?php ee('Users') ?></option>
            <option value="payments"><?php ee('Payments') ?></option>
        </select>
        <button class="btn" type="submit">
            <i class="align-middle" data-feather="search"></i>
        </button>
    </div>
</form>

<div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align"> 
        <li class="nav-item">
            <a class="nav-link fw-bold me-2<?php echo request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" title="<?php ee('Dark Mode') ?>" data-trigger="darkmode">
                <i class="align-middle" data-feather="moon"></i>
            </a>
            <a class="nav-link text-white fw-bold me-2<?php echo !request()->cookie('darkmode') ? ' d-none':'' ?>" href="#" title="<?php ee('Light Mode') ?>" data-trigger="lightmode">
                <i class="align-middle" data-feather="sun"></i>
            </a>
        </li>
        <?php if($notifications['total']): ?>
        <li class="nav-item dropdown">
            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                <div class="position-relative">
                    <i class="align-middle" data-feather="bell"></i>
                    <span class="indicator"><?php echo $notifications['total'] ?></span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0 <?php echo \Helpers\App::isDark() ? 'text-light' : 'text-dark' ?>" aria-labelledby="alertsDropdown">
                <div class="dropdown-menu-header">
                    <?php ee('{t} Notifications', null, ['t' => $notifications['total']]) ?>
                </div>
                <div class="list-group">
                    <?php foreach($notifications['data']['reports']['list'] as $report): ?>
                        <a href="<?php echo route('admin.links.report') ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-danger" data-feather="alert-circle"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('New Link Report') ?></div>
                                    <div class="text-muted small mt-1"><?php echo $report->url ?></div>
                                    <div class="text-muted small mt-1"><?php \Core\Helper::timeago($report->date) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                    <?php foreach($notifications['data']['pending']['list'] as $url): ?>
                        <a href="<?php echo route('admin.links.view', [$url->id]) ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-danger" data-feather="alert-circle"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('Require Approval') ?></div>
                                    <div class="text-muted small mt-1"><?php echo $url->url ?></div>
                                    <div class="text-muted small mt-1"><?php \Core\Helper::timeago($url->date) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                    <?php foreach($notifications['data']['verifications']['list'] as $verify): ?>
                        <a href="<?php echo route('admin.verifications.view', [$verify->id]) ?>" class="list-group-item">
                            <div class="row g-0 align-items-center">
                                <div class="col-2">
                                    <i class="text-danger" data-feather="alert-circle"></i>
                                </div>
                                <div class="col-10">
                                    <div class="text-dark"><?php ee('Verification request') ?></div>
                                    <div class="text-muted small mt-1"><?php \Core\Helper::timeago($verify->created_at) ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>               
            </div>
        </li>
        <?php endif ?>
        <?php if(\Helpers\App::newUpdate()): ?>
            <li class="nav-item">
                <a class="nav-link text-primary fw-bold" href="<?php echo route("admin.update") ?>"><i data-feather="bell" class="me-1"></i> <?php ee('Update') ?></a>
            </li>
        <?php endif ?>
        <li class="nav-item">
            <a class="nav-link fw-bold me-2 align-middle" href="<?php echo route('home') ?>" data-tooltip="<?php ee('Home') ?>">
                <?php ee('Home') ?>
            </a>            
        </li>
        <li class="nav-item">
            <a class="nav-link fw-bold me-2 align-middle" href="<?php echo route('dashboard') ?>" data-tooltip="<?php ee('User Dashboard') ?>">
                <?php ee('Dashboard') ?>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="<?php echo route('settings') ?>" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
            </a>

            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?php echo $user->avatar() ?>" class="avatar img-fluid rounded me-1" alt="<?php echo $user->username ?>" /> <span class="text-dark"><?php echo $user->username ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="<?php echo route('settings') ?>"><i class="align-middle me-1" data-feather="settings"></i> <?php ee('Settings') ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo route('logout') ?>"><i class="align-middle me-1" data-feather="log-out"></i> <?php ee('Log out') ?></a>
            </div>
        </li>
    </ul>
</div>