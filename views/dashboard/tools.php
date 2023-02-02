
<div class="clearfix"></div>

<div class="content-wrapper">
    <div class="container-fluid">

        <!--Start Dashboard Content-->

        <hr>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">Grid Tools</div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush table-borderless">
                            <thead>
                                <tr>
                                    <th>&raquo; Hypergrid Destination Guide & OpenSim Helper</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h4>Robust.ini</h4>
                                        <code>
                                            [LoginService]<br />
                                            ; For V3 destination guide<br />
                                            ; DestinationGuide = "${Const|BaseURL}/inc/destinations-inworld.php"<br />
                                            DestinationGuide = "https://guide.osp-php.de/inc/destinations-inworld.php"<br />
                                        </code>
                                        <br /><h4>OpenSim.ini</h4>
                                        <code>
                                            [Network]<br />
                                            ExternalHostNameForLSL = yourdomain.com<br />
                                            OutboundDisallowForUserScripts = ""<br />
                                            shard = "OpenSim"<br />
                                            user_agent = "OpenSim LSL (Mozilla Compatible)"<br />
                                        </code>
                                        <br /><h4>osslEnable.ini</h4>
                                        <code>
                                            AllowOsFunctions = true<br />
                                        </code>
                                        <br /><br />
                                        <h4>Helper Scripts for OpenSim Robust.ini</h4>
                                        <code>
                                            [GridInfoService]<br />
                                            economy = <?php echo URL; ?>helpers/<br />
                                            <-- This is not implements is coming soon -->
                                        </code>
                                        
                                        <br /><br />
                                        <h4>LSL Script for Destination Guide</h4>
                                        <a href="https://osp-php.de/lsl/terminal.lsl" target="_blank" class="btn btn-success">Donwload/View LSL Script</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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