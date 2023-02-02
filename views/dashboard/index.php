
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->

                    <div class="card mt-3">
                        <div class="card-content">
                            <div class="row row-group m-0">
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php echo $this->os_Info['user_count']; ?> <span class="float-right"><i class="fa fa-users"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('Total Grid Users'); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php echo $this->os_Info['region_count']; ?> <span class="float-right"><i class="fa fa-th"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('Total Region(s)'); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php echo $this->os_Info['hg_online']; ?> <span class="float-right"><i class="fa fa-eye"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('HG - Visitors'); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php echo $this->os_Info['now_online']; ?> <span class="float-right"><i class="fa fa-user"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('User Online'); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php echo $this->os_Info['lastmonth_online']; ?> <span class="float-right"><i class="fa fa-user"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('Online last month'); ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-2 border-light">
                                    <div class="card-body">
                                        <h5 class="text-white mb-0"><?php if($this->grid) { echo "<strong style='color: lime;'>Online</strong>"; } else { echo "<strong style='color: red;'>Offline</strong>"; } ?> <span class="float-right"><i class="fa fa-server"></i></span></h5>
                                        <div class="progress my-3" style="height:3px;">
                                            <div class="progress-bar" style="width:100%"></div>
                                        </div>
                                        <p class="mb-0 text-white small-font"><?php echo _('Grid System Status'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-12 col-lg-8 col-xl-8">
                            <div class="card">
                                <div class="card-header">Site Traffic
                                    <div class="card-action">
                                        <div class="dropdown">
                                            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                                <i class="icon-options"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void();">Action</a>
                                                <a class="dropdown-item" href="javascript:void();">Another action</a>
                                                <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><i class="fa fa-circle mr-2 text-white"></i>New Visitor</li>
                                        <li class="list-inline-item"><i class="fa fa-circle mr-2 text-light"></i>Old Visitor</li>
                                    </ul>
                                    <div class="chart-container-1">
                                        <canvas id="chart1"></canvas>
                                    </div>
                                </div>

                                <div class="row m-0 row-group text-center border-top border-light-3">
                                    <div class="col-12 col-lg-4">
                                        <div class="p-3">
                                            <h5 class="mb-0">45.87M</h5>
                                            <small class="mb-0">Overall Visitor <span> <i class="fa fa-arrow-up"></i> 2.43%</span></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="p-3">
                                            <h5 class="mb-0">15:48</h5>
                                            <small class="mb-0">Visitor Duration <span> <i class="fa fa-arrow-up"></i> 12.65%</span></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="p-3">
                                            <h5 class="mb-0">245.65</h5>
                                            <small class="mb-0">Pages/Visit <span> <i class="fa fa-arrow-up"></i> 5.62%</span></small>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 col-lg-4 col-xl-4">
                            <div class="card">
                                <div class="card-header">Weekly sales
                                    <div class="card-action">
                                        <div class="dropdown">
                                            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                                                <i class="icon-options"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="javascript:void();">Action</a>
                                                <a class="dropdown-item" href="javascript:void();">Another action</a>
                                                <a class="dropdown-item" href="javascript:void();">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:void();">Separated link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container-2">
                                        <canvas id="chart2"></canvas>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-items-center">
                                        <tbody>
                                            <tr>
                                                <td><i class="fa fa-circle text-white mr-2"></i> Direct</td>
                                                <td>$5856</td>
                                                <td>+55%</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-circle text-light-1 mr-2"></i>Affiliate</td>
                                                <td>$2602</td>
                                                <td>+25%</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-circle text-light-2 mr-2"></i>E-mail</td>
                                                <td>$1802</td>
                                                <td>+15%</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-circle text-light-3 mr-2"></i>Other</td>
                                                <td>$1105</td>
                                                <td>+5%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--End Row-->

                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">Aktive Avatare</div>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush table-borderless">
                                        <thead>
                                            <tr>
                                                <th>FirstName LastName</th>
                                                <th>Created</th>
                                                <th>Account</th>
                                                <th>Letzte Region</th>
                                                <th>Now Online</th>
                                                <th>Last Login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($this->os_griduser as $value) { ?>
                                            <tr>
                                                <td><?php echo $value['FirstName'] . ' ' . $value['LastName']; ?></td>
                                                <td><?php echo date("d.m.Y H:i", $value['Created']); ?> Uhr</td>
                                                <td><?php if($value['active'] == 1) { echo 'Aktiv'; } else { echo 'Inaktiv'; } ?></td>
                                                <td><?php echo $value['regionName']; ?></td>
                                                <td><?php if($value['Online'] == 'True') { echo 'Jetzt Online'; } else { echo 'Offline'; } ?></td>
                                                <td><?php echo date("d.m.Y H:i", $value['Logout']); ?> Uhr</td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--End Row-->


        <!--End Dashboard Content-->

        <!--start overlay-->
        <div class="overlay toggle-menu"></div>
        <!--end overlay-->

    </div>
    <!-- End container-fluid-->

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