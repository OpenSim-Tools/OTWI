
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header"><?php echo _('Regionen'); ?></div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-borderless">
                            <thead>
                                <tr>
                                    <th><?php echo _('Region Name'); ?></th>
                                    <th><?php echo _('Region Type'); ?></th>
                                    <th><?php echo _('Region Size'); ?></th>
                                    <th><?php echo _('Region Owner'); ?></th>
                             
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->os_region as $value) { ?>
                                    <tr>
                                        <td><?php echo $value['regionName']; ?></td>
                                        <td><?php if($value['sizeX'] == '256' & $value['sizeY'] == '256') { echo 'Standard Sim'; } else { echo 'Var Sim'; } ?></td>
                                        <td><?php echo $value['sizeX'] . 'x' . $value['sizeY']; ?></td>
                                        <td><?php echo $this->findUser->os_findUser($value['owner_uuid']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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