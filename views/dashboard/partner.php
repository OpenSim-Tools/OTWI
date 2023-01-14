
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->
        
        <hr>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">Avatar <=> Avatar</div>
                    <p class="text-right"><a href="<?php echo URL; ?>dashboard/create_partner" class="btn btn-dark">Create Partner</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-borderless">
                            <thead>
                                <tr>
                                    <th>1. Avatar</th>
                                    <th>2. Avatar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->os_groups as $value) { ?>
                                    <tr>
                                        <td><?php echo $value['Name']; ?></td>
                                        <td><?php echo $value['FirstName'] . ' ' . $value['LastName']; ?></td>
                                        <td><a href="#" class="btn btn-primary">View</a>&nbsp;<a href="#" class="btn btn-success">Edit</a></td>
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
            Copyright 2023 by OpenSim Tools. Alle Rechte vorbehalten. <?php echo $this->version; ?>
        </div>
    </div>
</footer>
<!--End footer-->