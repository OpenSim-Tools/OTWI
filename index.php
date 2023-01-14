<!--
   ____                    _____ _             _______          _        ______ _________          _________  
  / __ \                  / ____(_)           |__   __|        | |      / / __ \__   __\ \        / /_   _\ \ 
 | |  | |_ __   ___ _ __ | (___  _ _ __ ___      | | ___   ___ | |___  | | |  | | | |   \ \  /\  / /  | |  | |
 | |  | | '_ \ / _ \ '_ \ \___ \| | '_ ` _ \     | |/ _ \ / _ \| / __| | | |  | | | |    \ \/  \/ /   | |  | |
 | |__| | |_) |  __/ | | |____) | | | | | | |    | | (_) | (_) | \__ \ | | |__| | | |     \  /\  /   _| |_ | |
  \____/| .__/ \___|_| |_|_____/|_|_| |_| |_|    |_|\___/ \___/|_|___/ | |\____/  |_|      \/  \/   |_____|| |
        | |                                                             \_\                               /_/ 
        |_|                                                                                                   
Copyright <?= date("Y"); ?> by OpenSim-Tools | www.opensim-tools.de | OpenSim Webinterface                                                                                                                                       
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
