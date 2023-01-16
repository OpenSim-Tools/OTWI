<!-- Start wrapper-->
<div id="wrapper">

    <!--Start sidebar-wrapper-->
    <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
        <div class="brand-logo">
            <a href="<?php echo URL; ?>dashboard">
                <img src="<?php echo URL; ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                <h5 class="logo-text">OTWI Admin</h5>
            </a>
        </div>
        <ul class="sidebar-menu do-nicescrol">
            <li class="sidebar-header"><?php echo _('Main Navigation'); ?></li>
            <li>
                <a href="<?php echo URL; ?>dashboard">
                    <i class="zmdi zmdi-view-dashboard"></i> <span><?php echo _('Home'); ?></span>
                </a>
            </li>

            <li>
                <a href="<?php echo URL; ?>dashboard/partner">
                    <i class="zmdi zmdi-invert-colors"></i> <span><?php echo _('Partner'); ?></span>
                </a>
            </li>

            <li>
                <a href="<?php echo URL; ?>dashboard/region">
                    <i class="zmdi zmdi-format-list-bulleted"></i> <span><?php echo _('Region(s)'); ?></span>
                </a>
            </li>

            <li>
                <a href="<?php echo URL; ?>dashboard/griduser">
                    <i class="zmdi zmdi-face"></i> <span><?php echo _('Grid User'); ?></span>
                </a>
            </li>

            <li>
                <a href="<?php echo URL; ?>dashboard/groups">
                    <i class="zmdi zmdi-calendar-check"></i> <span><?php echo _('Groups'); ?></span>
                    <!-- <small class="badge float-right badge-light">New</small> -->
                </a>
            </li>
            <li><a href="<?php echo URL; ?>dashboard/robust"><i class="zmdi zmdi-grid"></i> <span><?php echo _('Robust Settings'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/remote"><i class="zmdi zmdi-grid"></i> <span><?php echo _('Remote Settings'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/updates"><i class="zmdi zmdi-grid"></i> <span><?php echo _('OTWI Update(s)'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/settings"><i class="zmdi zmdi-grid"></i> <span><?php echo _('OTWI Settings'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/credits"><i class="zmdi zmdi-grid"></i> <span><?php echo _('Credits'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/feeds"><i class="zmdi zmdi-assignment"></i> <span><?php echo _('GridTalk Feeds'); ?></span></a></li>
            <li><a href="<?php echo URL; ?>dashboard/tools"><i class="zmdi zmdi-assignment"></i> <span><?php echo _('Helper Tools'); ?></span></a></li>
        </ul>
    </div>
    <!--End sidebar-wrapper-->

    <!--Start topbar header-->
    <header class="topbar-nav">
        <nav class="navbar navbar-expand fixed-top">
            <ul class="navbar-nav mr-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link toggle-menu" href="javascript:void();">
                        <i class="icon-menu menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    &nbsp;&nbsp; <?php echo _('Currently running OpenSim version:'); ?> ###Unavilable## | Standalone Version
                </li>
            </ul>

            <ul class="navbar-nav align-items-center right-nav-link">

                <li class="nav-item">
                    
                        <?php echo _('Welcome back,'); ?> <span class="user-profile"><?php echo Session::get('Username'); ?> | <a href="<?php echo URL; ?>dashboard/logout"><?php echo _('Logout'); ?></a></span>
                 

                </li>
            </ul>
        </nav>
    </header>
    <!--End topbar header-->