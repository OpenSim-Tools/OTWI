
    <div class="clearfix"></div>

    <div class="content-wrapper">
        <div class="container-fluid">

            <!--Start Dashboard Content-->
            <h1>OSP(S) Software Updates</h1>
            <p><?php echo $this->update->otwi_updater($this->otserv); ?></p>
            OpenSource Repository GitHub: <a href="https://github.com/OpenSim-Tools/OTWI" target="_blank">OSP-PHP by GitHub</a>
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