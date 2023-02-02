
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <?php echo _('Create new Avatar for this Grid'); ?> 
                        </div>
                        <hr>
                        <sup class="alert alert-danger"> || DEMO MODE ACTIVATED YOU CAN NOT CHANGE THIS || </sup>
                        <form method="post" action="<?php echo URL; ?>dashboard/create_user_push">
                            <div class="form-group">
                                <label for="input-1"><?php echo _('FirstName'); ?></label>
                                <input type="text" class="form-control" id="input-1" name="firstname">
                            </div>
                            <div class="form-group">
                                <label for="input-2"><?php echo _('LastName'); ?></label>
                                <input type="text" class="form-control" id="input-2" name="lastname">
                            </div>
                            <div class="form-group">
                                <label for="input-3"><?php echo _('E-Mail (optional)'); ?></label>
                                <input type="text" class="form-control" id="input-3" name="email">
                            </div>
                            <div class="form-group">
                                <label for="input-4"><?php echo _('Password'); ?></label>
                                <input type="password" class="form-control" id="input-4" name="password">
                            </div>
                            <div class="form-group">
                                <br />
                                <button type="submit" class="btn btn-light px-5" title="DEMO MODE NOT ACTIVATED"><i class="icon-lock"></i> <?php echo _('Submit'); ?></button>
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
            Copyright 2023 by OSP-PHP. Alle Rechte vorbehalten. <?php echo $this->version; ?>
        </div>
    </div>
</footer>
<!--End footer-->