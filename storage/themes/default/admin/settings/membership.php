<h1 class="h3 mb-5"><?php ee('Membership Settings') ?></h1>
<div class="row">
    <div class="col-md-3 d-none d-lg-block">
        <?php view('admin.partials.settings_menu') ?>
    </div>
    <div class="col-md-12 col-lg-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="post" action="<?php echo route('admin.settings.save') ?>" enctype="multipart/form-data">
                    <?php echo csrf() ?>                                        
                    <div class="form-group">
                        <label for="pro" class="form-label fw-bold"><?php ee('Membership Module') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="pro" name="pro" value="1" <?php echo config("pro") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="pt,skpk,sksk,stripesig,pppublic,ppprivate,paypalemail">
                            <label class="form-check-label" for="pro"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text"><?php ee('Enabling this module will allow you to charge users for premium features. Disable this if you want to offer these for free.') ?></p>
                    </div>                       
					<div class="form-group input-select rounded">
					    <label for="currency" class="form-label fw-bold"><?php ee('Currency') ?></label>
                        <select name="currency" id="currency" class="form-control p-2" data-toggle="select">
					      <?php foreach (\Helpers\App::currency() as $code => $info): ?>
					      	<option value="<?php echo $code ?>" <?php if(config("currency") == $code) echo "selected" ?>><?php echo $code ?>: <?php echo $info["label"] ?></option>
					      <?php endforeach ?>
					    </select>
					  	<p class="form-text"><?php ee('<strong>Notice</strong> If you already have subscribed members, it is highly recommend you <u>do not change</u> the currency or the membership fees because Stripe does not allow modifcation of these parameters. The script will delete the plan and create another one!') ?></p>
                    </div>	
                    <div class="form-group">
                        <label for="customplan" class="form-label fw-bold"><?php ee('Custom Plan') ?></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" data-binary="true" id="customplan" name="customplan" value="1" <?php echo config("customplan") ? 'checked':'' ?> data-toggle="togglefield" data-toggle-for="pt,skpk,sksk,stripesig,pppublic,ppprivate,paypalemail">
                            <label class="form-check-label" for="customplan"><?php ee('Enable') ?></label>
                        </div>
                        <p class="form-text fs-6 mt-2"><?php ee('Enabling this will enable a special box on the pricing where users can contact you for custom plans.') ?></p>
                    </div> 	
                    <hr>
					<div class="form-group">
					    <label for="aliases" class="form-label fw-bold"><?php ee('Premium Aliases') ?></label>
                        <input type="text" name="aliases" id="aliases" class="form-control p-2" rows="5" data-toggle="tags" value="<?php echo config("aliases") ?>" placeholder="Enter alias">
                        <p class="form-text"><?php ee('To reserve an alias for pro members only, add it to the list above (separated by a comma without space between each): google,apple,microsoft,etc. Only admins and pro users can select these.') ?></p>
                    </div>	
                    <hr>
                    <div class="form-group">
					    <label for="saleszapier" class="form-label fw-bold"><?php ee('Sales Zapier Integration') ?></label>
                        <input type="text" name="saleszapier" id="saleszapier" class="form-control p-2" value="<?php echo config("saleszapier") ?>">
					    <p class="form-text"><?php ee('Enter your zapier url or any other webhook services url to receive data as soon a sales is confirmed. Please check the <a href="https://gemp.me/docs" target="_blank">documentation</a> for more info.') ?></p>
                    </div>
                    <hr>
                    <h5 class="fw-bolder"><?php ee('Invoice Settings') ?></h5>
                    <div class="form-group">
					    <label for="invoice[header]" class="form-label fw-bold"><?php ee('Invoice Header') ?></label>
                        <textarea name="invoice[header]" id="invoice[header]" rows="5" class="form-control p-2"><?php echo config("invoice")->header ?></textarea>
					    <p class="form-text"><?php ee('This information will be added to the invoice header. It can be your address or your company information.') ?></p>
                    </div>
                    <div class="form-group">
					    <label for="invoice[footer]" class="form-label fw-bold"><?php ee('Invoice Footer') ?></label>
                        <textarea name="invoice[footer]" id="invoice[footer]" rows="5" class="form-control p-2"><?php echo config("invoice")->footer ?></textarea>
					    <p class="form-text"><?php ee('This information will be added to the invoice footer. It can be your policy.') ?></p>
                    </div>
                    
                    <button type="submit" class="btn btn-success"><?php ee('Save Settings') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>