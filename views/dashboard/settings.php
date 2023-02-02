
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">
        <!--Start Dashboard Content-->
        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><?php echo _('OSP Settings'); ?></div>
                        <hr>
                        
                        <form method="post" action="<?php echo URL; ?>dashboard/settings_save">
                            <?php foreach($this->settings as $value) {  $count = count($value); ?>
                            <?php if($value['property'] == 'update_src') { ?>
                            <div class="form-group">
                                <label for="input-<?php echo $count; ?>"><?php echo $value['description']; ?></label>
                                <select class="form-control" size="1" name="update">
                                    <option value="https://updates.osp-php.de/?src=major" <?php if($value['value'] == 'https://updates.osp-php.de/?src=major') { echo 'selected'; } ?>>OSP Major</option>
                                    <option value="https://updates.osp-php.de/?src=beta" <?php if($value['value'] == 'https://updates.osp-php.de/?src=beta') { echo 'selected'; } ?>>OSP Beta</option>
                                </select>
                            </div>
                            <?php } elseif($value['property'] == 'language') { ?> 
                            <div class="form-group">
                                <label for="input-<?php echo $count; ?>"><?php echo $value['description']; ?></label>
                                <select class="form-control" size="1" name="language">
                                    <option value="de_DE" <?php if($value['value'] == 'de_DE') { echo 'selected'; } ?>>German</option>
                                </select>
                            </div>
                            <?php } else { ?>
                            <div class="form-group">
                                <label for="input-<?php echo $count; ?>"><?php echo $value['description']; ?></label>
                                <input type="text" class="form-control" id="input-<?php echo $count; ?>" name="<?php echo $value['property']; ?>" value="<?php echo $value['value']; ?>">
                            </div>
                            <?php } ?>
                            <?php } ?>
                            <div class="form-group">
                                <br />
                                <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> <?php echo _('Submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            
                
                
                
        </div><!--End Row-->
        
        <div class="col-lg-6">
        <div class="card">
           <div class="card-body">
           <div class="card-title">Info</div>
           <hr>
           <form method="post" action="<?php echo URL; ?>dashboard/cache">
           <div class="form-group">
            <label for="input-6">GridTalk Cache</label>
            <button type="submit" class="btn btn-danger px-5"><i class="icon-delete"></i> Cache Delete</button>
           </div>
          </form>
           <div class="form-group">
               <label>PHP Version: <?php if(phpversion() >= '7.4.33') { echo '<strong style="color: lime;">' . phpversion() . ' (ready)</strong>'; } else { echo '<strong style="color: red;">' . phpversion() . ' (Not compatible)</strong>';} ?></label>
           </div>
           <div class="form-group">
               <label>Ordner /feed_tmp/ (CHMOD 777): <?php if(is_writable($_SERVER['DOCUMENT_ROOT'] . '/feed_tmp/')) { echo '<strong style="color: lime;">Verzeichnis ist beschreibar</strong>'; } else { echo '<strong style="color: red;">Verzeichnis ist nicht beschreibar</strong>';} ?></label>
           </div>
           <div class="form-group">
               <label>Update Server: <?php $online = @fsockopen("updates.osp-php.de", 80); if($online) { echo '<strong style="color: lime;">OSP Updateserver erreichbar</strong>'; } else { echo '<strong style="color: red;">OSP Updateserver Störung</strong>';} ?></label>
           </div>
         </div>
         </div>
      </div>
        <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->

</div><!--End content-wrapper-->


</div><!--End content-wrapper-->
<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->

<!--Start footer-->
<footer class="footer">
    <div class="container">
        <div class="text-center">
            Copyright 2023 by OSP-PHP. Alle Rechte vorbehalten. <?php echo $this->version; ?>
        </div>
    </div>
</footer>
<!--End footer-->