<div class="d-flex">
    <div>
        <h1 class="h3 mb-5"><?php ee('Themes') ?></h1>
    </div>
    <div class="ms-auto">
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#uploadModal" class="btn btn-primary"><?php ee('Upload Theme') ?></a>
        <a href="#" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#customizeModal" class="btn btn-dark"><i data-feather="help-circle"></i> <?php ee('Child Theme') ?></a>
    </div>
</div>
<div class="row">
     <?php foreach($themes as $theme): ?>
        <div class="col-md-3">        
            <div class="card shadow-sm">
                <div class="card-body">          
                    <?php if($theme->thumbnail): ?>
                        <img src="<?php echo url($theme->thumbnail) ?>" alt="<?php echo $theme->name ?>">
                    <?php endif ?>
                    <h5 class="card-title fw-bold"><?php echo $theme->name ?> (v<?php echo $theme->version ?>)
                      <?php if($theme->child): ?>
                        <span class="badge bg-primary text-sm"><?php ee('Child') ?></span>
                      <?php endif ?>
                    </h5>                   
                    <a href="<?php echo $theme->link ?>" target="_blank"><small class="text-muted"><?php ee('By') ?> <?php echo $theme->author ?></small></a> -                    
                    <small class="text-muted"><?php ee('Since') ?> <?php echo $theme->date ?></small>
                    <br>
                    <div class="d-flex mt-4">
                        <div>
                            <?php if(config('theme') == $theme->id): ?>
                                <span class="badge bg-info fs-6"><?php ee('Active') ?></span>
                            <?php else: ?>
                                <a href="<?php echo route('admin.themes.activate', [$theme->id]) ?>" class="btn btn-success btn-sm"><?php ee('Activate') ?></a>
                            <?php endif ?>
                        </div>
                        <div class="ms-auto">
                            <a href="<?php echo route('admin.themes.clone', [$theme->id, \Core\Helper::nonce('themes.clone')]) ?>" class="btn btn-primary btn-sm" title="<?php ee('Clone Theme') ?>" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#cloneModal"><span data-feather="copy"></span></a>
                            <?php if($theme->id != 'default' && config('theme') != $theme->id): ?>
                                <a href="<?php echo route('admin.themes.delete', [$theme->id, \Core\Helper::nonce('themes.delete')]) ?>" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-trigger="modalopen" data-bs-target="#deleteModal"><span data-feather="trash-2"></span></a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <?php endforeach ?>
</div>
<div class="modal fade" id="customizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Learn how to create a child theme') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('We have introduced the ability to make child themes. Child Themes allow to you change only the part of the website you need to change without having to copy all theme files. They are easy to make and more importantly they are safe from all automated updates.') ?></p>

        <a href="https://gempixel.com/docs/premium-url-shortener#tct" class="btn btn-primary" target="_blank"><?php ee('Learn how to make a child theme') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
<div class="modal fade" id="cloneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php ee('Things to know about cloning') ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php ee('You are about to clone the whole theme. Please note that if you clone the theme and the original is updated, your cloned theme will not be updated automatically. If you are an experienced user you can continue but otherwise it is recommended to change the cloned theme to a Child Theme so you can customize only some pages while keeping everything else up to date.') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
        <a href="#" class="btn btn-success" data-trigger="confirm"><?php ee('Confirm') ?></a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="uploadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="<?php echo route('admin.themes.upload') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title"><?php ee('Upload New Theme or Update Existing Theme') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo csrf() ?>
                <div class="form-group mb-4">
                    <label for="file" class="form-label"><?php ee('Theme File') ?></label>
                    <input type="file" class="form-control" name="file" id="file" value="" accept=".zip" placeholder="e.g. theme.zip">
                    <p class="form-text"><?php ee('Upload the zip file that comes in the package. Usually it is named THEMENAME.zip. Please make sure the theme respects the file structure.') ?></p>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php ee('Cancel') ?></button>
                <button type="submit" class="btn btn-success"><?php ee('Upload') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>