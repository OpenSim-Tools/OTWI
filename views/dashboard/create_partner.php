
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        
        <hr>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><?php echo _('New create partnership'); ?></div>
                    <div class="table-responsive">
                        <form method="post" action="<?php echo URL; ?>dashboard/#">
                        <table class="table align-items-center table-flush table-borderless">
                            <thead>
                                <tr>
                                    <th>1. Avatar</th>
                                    <th>2. Avatar</th>
                                    <th><?php echo _('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <tr>
                                        <td>
                                            <select size="1" class="form-control" name="avatar_one">
                                                <option selected>-- Auswahl --</option>
                                            <?php foreach ($this->os_griduser as $value) { ?>
                                                <option value="<?php echo $value['PrincipalID']; ?>"><?php echo $value['FirstName'] . ' ' . $value['LastName']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select size="1" class="form-control" name="avatar_two">
                                                <option selected>-- Auswahl --</option>
                                            <?php foreach ($this->os_griduser as $value) { ?>
                                                <option value="<?php echo $value['uuid']; ?>"><?php echo $value['FirstName'] . ' ' . $value['LastName']; ?></option>
                                            <?php } ?>
                                            </select> 
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success"><?php echo _('Create partnership'); ?></button>
                                        </td>
                                    </tr>
                                
                            </tbody>
                        </table>
                        </form>
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