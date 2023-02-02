<!--
 ██████╗ ███████╗██████╗       ██████╗ ██╗  ██╗██████╗      ██╗███████╗██╗ 
██╔═══██╗██╔════╝██╔══██╗      ██╔══██╗██║  ██║██╔══██╗    ██╔╝██╔════╝╚██╗
██║   ██║███████╗██████╔╝█████╗██████╔╝███████║██████╔╝    ██║ ███████╗ ██║
██║   ██║╚════██║██╔═══╝ ╚════╝██╔═══╝ ██╔══██║██╔═══╝     ██║ ╚════██║ ██║
╚██████╔╝███████║██║           ██║     ██║  ██║██║         ╚██╗███████║██╔╝
 ╚═════╝ ╚══════╝╚═╝           ╚═╝     ╚═╝  ╚═╝╚═╝          ╚═╝╚══════╝╚═╝ 
Copyright <?= date("Y"); ?> by OSP-PHP | www.osp-php.de | OpenSim Service Panel (Standalone)                                                                                                                                      
-->
<?php

// Use an autoloader!
require 'libs/Bootstrap.php';
require 'libs/Controller.php';
require 'libs/Model.php';
require 'libs/View.php';


// Library
require 'libs/Database.php';
require 'libs/Session.php';
if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/robust.php')) {
    require 'config/robust.php';
    require 'libs/OpenSimDB.php';
}

require 'libs/Opensim.class.php';

require 'config/paths.php';
require 'config/database.php';

$app = new Bootstrap();
