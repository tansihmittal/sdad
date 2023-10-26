<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Campaigns') ?></h1>
    </div>
    <div class="ms-auto">
        <?php if(user()->teamPermission('bundle.create')): ?>
        <a href="#" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary"><?php ee('Create a Campaign') ?></a>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card flex-fill shadow-sm">  
            <?php if($campaigns): ?>
                <div class="table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th><?php ee('Name') ?></th>
                                <th><?php ee('List') ?></th>
                                <th><?php ee('Rotator') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($campaigns as $campaign): ?>
                            <tr>
                                <td>                                    
                                   <strong><?php echo $campaign->name ?></strong>
                                   <?php echo $campaign->access == 'private' ? '<span class="badge bg-danger">'.e('Inactive').'</span>' : '<span class="badge bg-success">'.e('Active').'</span>' ?>
                                   <p>
                                        <small class="text-navy"><?php echo $campaign->view ?> <?php ee('views') ?></small> - 
                                        <small class="text-navy"><?php echo $campaign->urlcount ?> <?php ee('links') ?></small> - 
                                        <small class="text-navy"><?php echo \Core\Helper::timeago($campaign->date) ?></small>
                                    </p>
                                </td>
                                <td>
                                    <?php if($campaign->slug): ?>
                                        <?php if(user()->username): ?>
                                            <small class="text-muted" data-href="<?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?>"><?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?></small>
                                            <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo route('campaign.list', [user()->username, $campaign->slug.'-'.$campaign->id]) ?>"><small><?php echo e("Copy")?></small></a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if($campaign->slug): ?>
                                        <small class="text-muted" data-href="<?php echo route('campaign', [$campaign->slug]) ?>"><?php echo route('campaign', [$campaign->slug]) ?></small>
                                        <a href="#copy" class="copy inline-copy" data-clipboard-text="<?php echo route('campaign', [$campaign->slug]) ?>"><small><?php echo e("Copy")?></small></a>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-default bg-white btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="more-horizontal"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo route('links', ['campaign' => $campaign->id]) ?>"><i data-feather="link"></i> <?php ee('Links') ?></span></a></li>
                                        <?php if(user()->teamPermission('bundle.edit')): ?>
                                        <li><a class="dropdown-item" href="<?php echo route('campaigns.update', [$campaign->id]) ?>" data-bs-toggle="modal" data-bs-target="#updateModal" data-toggle="updateFormContent" data-content='<?php echo htmlentities(json_encode(['newname' => $campaign->name, 'newslug' => $campaign->slug, 'newaccess' => $campaign->access == 'public' ? '1' : '0']), ENT_QUOTES) ?>'><i data-feather="edit"></i> <?php ee('Edit') ?></span></a></li>
                                        <?php endif ?>
                                        <li><a class="dropdown-item" href="<?php echo route('campaigns.stats', [$campaign->id]) ?>"><i data-feather="bar-chart-2"></i> <?php ee('Statistics') ?></span></a></li>                                        
                                        <?php if(user()->teamPermission('bundle.delete')): ?>
                                        <li class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="<?php echo route('campaigns.delete', [$campaign->id, \Core\Helper::nonce('campaign.delete')]) ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><i data-feather="trash"></i> <?php ee('Delete') ?></span></a></li>
                                        <?php endif ?>
                                    </ul> 
                                </td>
                            </tr>                        
                        <?php endforeach ?>                        
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="card-body text-center">
                    <p><?php ee('No content found. You can create some.') ?></p>
                    <?php if(user()->teamPermission('bundle.create')): ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-primary btn-sm"><?php ee('Create a Campaign') ?></a>
                    <?php endif ?>
                </div>            
            <?php endif ?>
            <?php echo pagination('bg-white shadow rounded pagination p-3') ?>
        </div>
    </div>
    <div class="col-md-3">        
        <?php if(!user()->public || !user()->defaultbio): ?>
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex">
                        <h5 class="card-title mb-0"><?php ee('Campaign List Disabled') ?></h5>
                    </div>
                </div>
                <div class="card-body">
                    <p><?php ee('To create a list page for the campaign, you need a default bio page and public profile settings.') ?></p>

                    <p><i <?php echo (user()->defaultbio ? 'data-feather="check-circle" class="text-success"' : 'data-feather="x-circle" class="text-danger"') ?>></i> <?php ee('Default Bio') ?></p>
                    <p><i <?php echo (user()->public ? 'data-feather="check-circle" class="text-success"' : 'data-feather="x-circle" class="text-danger"') ?>></i> <?php ee('Public Profile') ?></p>
                </div>
            </div>
        <?php endif ?>        
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="d-flex">
                    <h5 class="card-title mb-0"><?php ee('What is a campaign?') ?></h5>
                </div>
            </div>
            <div class="card-body">
                <p class="text-justify"> <?php echo ee('A campaign can be used to group links together for various purpose. You can use the dedicated rotator link where a random link will be chosen and redirected to among the group. You will also be able to view aggregated statistics for a campaign.') ?></p>            
            </div>
        </div>
    </div>
</div>
<?php if(user()->teamPermission('bundle.create')): ?>
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('campaigns.save') ?>" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Create a Campaign') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>			
                    <input type="text" value="" name="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>			
                    <input type="text" value="" name="slug" class="form-control">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label" for="access"><?php ee('Access') ?></label>
                        <p class="form-text"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="access" name="access" value="1">
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Create Campaign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>
<?php if(user()->teamPermission('bundle.edit')): ?>
<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="#" method="post">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Update Campaign') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Campaign Name") ?> (<?php ee("required") ?>)</label>			
                    <input type="text" value="" name="newname" id="newname" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><?php ee("Rotator Slug") ?> (<?php ee("optional") ?>)</label>			
                    <input type="text" value="" name="newslug" id="newslug" class="form-control">
                    <p class="form-text"><?php ee("If you want to set a custom alias for the rotator link, you can fill this field.") ?></p>
                </div>
                <div class="d-flex">
                    <div>
                        <label class="form-check-label" for="access"><?php ee('Access') ?></label>
                        <p class="form-text"><?php ee('Disabling this option will deactivate the rotator link.') ?></p>
                    </div>
                    <div class="form-check form-switch ms-auto">
                        <input class="form-check-input" type="checkbox" data-binary="true" id="newaccess" name="newaccess" value="1">
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Update Campaign') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<?php endif ?>
<?php if(user()->teamPermission('bundle.delete')): ?>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Are you sure you want to delete this?') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are trying to delete a record. This action is permanent and cannot be reversed.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-danger" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<?php endif ?>