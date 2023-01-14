
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <?php echo _('Robust Settings'); ?> | 
                            <?php if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/robust.php')) { ?>
                            <strong style="color: lime;"><?php echo _('Configuration available'); ?></strong>
                            <?php } else { ?>
                            <strong style="color: red;"><?php echo _('Configuration not available'); ?></strong>
                            <?php } ?>
                        
                        </div>
                        <hr>
                        <sup class="alert alert-danger"> || DEMO MODE ACTIVATED YOU CAN NOT CHANGE THIS || </sup>
                        <form method="post" action="<?php echo URL; ?>dashboard/robust_save">
                            <?php foreach($this->robust as $value) { ?>
                            <div class="form-group">
                                <label for="input-1">Robust - DB Host</label>
                                <input type="text" class="form-control" id="input-1" name="server_host" value="<?php echo 'localhost'; // $value['server_host']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="input-2">Robust - DB Name</label>
                                <input type="text" class="form-control" id="input-2" name="server_dbname" value="<?php echo 'example_robust'; // $value['server_dbname']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="input-3">Robust - DB User</label>
                                <input type="text" class="form-control" id="input-3" name="server_user" value="<?php echo 'example_robust'; // $value['server_user']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="input-4">Robust - DB Password</label>
                                <input type="password" class="form-control" id="input-4" name="server_pass" value="<?php echo '********'; // $value['server_pass']; ?>" disabled>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <br />
                                <button type="submit" class="btn btn-light px-5" title="DEMO MODE NOT ACTIVATED" disabled><i class="icon-lock"></i> <?php echo _('Submit'); ?></button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            
                
                
                
        </div><!--End Row-->
        
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
            Copyright 2023 by OpenSim Tools. Alle Rechte vorbehalten. <?php echo $this->version; ?>
        </div>
    </div>
</footer>
<!--End footer-->