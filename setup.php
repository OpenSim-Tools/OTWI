<?php
require 'libs/Database.php';
require 'config/database.php';
require 'config/paths.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="OpenSim Service Panel, Webinterface for OpenSim"/>
        <meta name="author" content="Sleimer Akina & Jam MC<support@osp-php.de>"/>
        <title>OSP-PHP (S) | Setup</title>
        <!-- loader-->
        <!-- <link href="assets/css/pace.min.css" rel="stylesheet"/>
        <script src="assets/js/pace.min.js"></script> -->
        <!--favicon-->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
        <!-- Bootstrap core CSS-->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
        <!-- animate CSS-->
        <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
        <!-- Icons CSS-->
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
        <!-- Custom Style-->
        <link href="assets/css/app-style.css" rel="stylesheet"/>
    </head>
    <body class="bg-theme bg-theme1">

        <?php
        switch (true) {
            case isset($_POST['pfad']):

                $zeile = "<?php \r\n";
                $zeile .= "define('URL', '" . $_POST['pfad'] . "');";
                file_put_contents("config/paths.php", $zeile);
                ?>
                <div id="wrapper">

                    <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
                    <div class="card card-authentication1 mx-auto my-5">
                        <div class="card-body">
                            <div class="card-content p-2">
                                <div class="text-center">
                                    <img src="assets/images/logo-icon.png" alt="logo icon">
                                </div>
                                <div class="card-title text-uppercase text-center py-3">OSP-PHP(S) | Setup</div>
                                <form method="post" action="setup.php" class="form-group">
                                    <p>Trage bitte deine MySQL Datenbank Daten ein. Damit die Tabellen erstellt werden können.</p>
                                    <label>MySQL Host:</label>
                                    <input type="text" name="host" value="localhost" placeholder="localhost" class="form-control"><br />
                                    <label>MySQL Datenbankname:</label>
                                    <input type="text" name="dbname" placeholder="Datenbankname" class="form-control" require><br />
                                    <label>MySQL Datenbank User:</label>
                                    <input type="text" name="dbuser" placeholder="Username" class="form-control" require><br />
                                    <label>MySQL Datenbank Password:</label>
                                    <input type="password" name="dbpass" placeholder="********" class="form-control"><br />
                                    <input type="hidden" name="dbsource" value="sources">
                                    <button type="submit" class="btn btn-success">Weiter</button>
                                </form>
                            </div>
                        </div>

                        <!--Start Back To Top Button-->
                        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
                        <!--End Back To Top Button-->

                    </div><!--wrapper-->

                    <?php
                    break;
                case isset($_POST['dbsource']):
                    $zeile = "<?php \r\n\n";
                    $zeile .= "// OSP-PHP Webinterface\n";
                    $zeile .= "define('DB_TYPE', 'mysql');\n";
                    $zeile .= "define('DB_HOST', '" . $_POST['host'] . "');\n";
                    $zeile .= "define('DB_NAME', '" . $_POST['dbname'] . "');\n";
                    $zeile .= "define('DB_USER', '" . $_POST['dbuser'] . "');\n";
                    $zeile .= "define('DB_PASS', '" . $_POST['dbpass'] . "');\n";
                    $zeile .= "define('DB_PREF', 'otwi_'); // Don't change this\n";
                    $zeile .= "define('UUID_ZERO', '00000000-0000-0000-0000-000000000000'); // Don't change this";
                    file_put_contents("config/database.php", $zeile);
                    ?>
                    <div id="wrapper">

                        <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
                        <div class="card card-authentication1 mx-auto my-5">
                            <div class="card-body">
                                <div class="card-content p-2">
                                    <div class="text-center">
                                        <img src="assets/images/logo-icon.png" alt="logo icon">
                                    </div>
                                    <div class="card-title text-uppercase text-center py-3">OSP-PHP(S) | Setup</div>
                                    <form method="post" action="setup.php" class="form-group">
                                        <p>Zu guter letzt noch einen Administrator anlegen.</p>
                                        <label>Administrator Name:</label>
                                        <input type="text" name="admin" placeholder="Username" class="form-control" require><br />
                                        <label>Administrator Password:</label>
                                        <input type="password" name="password" placeholder="********" class="form-control" require><br />
                                        <input type="hidden" name="finish" value="finish">
                                        <button type="submit" class="btn btn-success">Fertigstellen</button>
                                    </form>
                                </div>
                            </div>

                            <!--Start Back To Top Button-->
                            <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
                            <!--End Back To Top Button-->

                        </div><!--wrapper-->
                        <?php
                        break;
                    case isset($_POST['finish']):

                        $db = new Database();
                        $robust = "CREATE TABLE IF NOT EXISTS `otwi_robust` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `server_host` text NOT NULL,
  `server_dbname` text NOT NULL,
  `server_user` text NOT NULL,
  `server_pass` text NOT NULL,
  KEY `Schlüssel 1` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Robust Database';";
                        $db->exec($robust);

                        $settings = "CREATE TABLE IF NOT EXISTS `otwi_settings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `property` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
                        $db->exec($settings);
                        
                        $user = "CREATE TABLE IF NOT EXISTS `otwi_user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='OTWI Central User';";
                        $db->exec($user);
                        
                        $sth = $db->prepare("INSERT INTO " . DB_PREF . "user (Username, Password) VALUES(:username, :password)");
                        $sth->execute(array(
                            ':username' => $_POST['admin'],
                            ':password' => md5(md5($_POST['password']))
                        ));
                        
                        $sth_robust = $db->prepare("INSERT INTO " . DB_PREF . "robust (server_host, server_dbname, server_user, server_pass) VALUES(:serverhost, :serverdbname, :serveruser, :serverpass)");
                        $sth_robust->execute(array(
                            ':serverhost' => 'ROBUST DBHOST',
                            ':serverdbname' => 'ROBUST DBNAME',
                            ':serveruser' => 'ROBUST DBUSER',
                            ':serverpass' => 'ROBUST DBPASS'
                        ));
                        
                        $sth_settings = $db->prepare("INSERT INTO " . DB_PREF . "settings (property, value, description) VALUE(:property, :value, :desc)");
                        $sth_settings->execute(array(
                            ':property' => 'gridtalk_time',
                            ':value' => '60',
                            ':desc' => 'GridTalk Forum Aktualisierung <sub>(Angabe in sekunden)</sub>'
                        ));
                        $sth_settings1 = $db->prepare("INSERT INTO " . DB_PREF . "settings (property, value, description) VALUE(:property, :value, :desc)");
                        $sth_settings1->execute(array(
                            ':property' => 'gridtalk_entries',
                            ':value' => '10',
                            ':desc' => 'GridTalk Forum letzten Einträge'
                        ));
                        $sth_settings2 = $db->prepare("INSERT INTO " . DB_PREF . "settings (property, value, description) VALUE(:property, :value, :desc)");
                        $sth_settings2->execute(array(
                            ':property' => 'language',
                            ':value' => 'de_DE',
                            ':desc' => 'Sprache auswählen'
                        ));
                        $sth_settings3 = $db->prepare("INSERT INTO " . DB_PREF . "settings (property, value, description) VALUE(:property, :value, :desc)");
                        $sth_settings3->execute(array(
                            ':property' => 'update_src',
                            ':value' => 'https://updates.osp-php.de/?src=major',
                            ':desc' => 'OSP Update Kanal'
                        ));                        
                        $sth_settings4 = $db->prepare("INSERT INTO " . DB_PREF . "settings (property, value, description) VALUE(:property, :value, :desc)");
                        $sth_settings4->execute(array(
                            ':property' => 'avatar_src',
                            ':value' => 'UUID here',
                            ':desc' => 'Standard Avatar UUID Kleidung'
                        ));          
                        
                        ?>
                        <div id="wrapper">

                            <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
                            <div class="card card-authentication1 mx-auto my-5">
                                <div class="card-body">
                                    <div class="card-content p-2">
                                        <div class="text-center">
                                            <img src="assets/images/logo-icon.png" alt="logo icon">
                                        </div>
                                        <div class="card-title text-uppercase text-center py-3">OSP-PHP(S) | Setup</div>
                                        <p>Fertig ;) jetzt kannst du das Interface nutzen. Vergesse nicht die setup.php zu löschen oder wenigstens, umzubennen.<br />Klicke hier um auf die Login Seite zu gelangen.<a href="<?php echo URL; ?>">Zum Login</p>
                                    </div>
                                </div>

                                <!--Start Back To Top Button-->
                                <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
                                <!--End Back To Top Button-->

                            </div><!--wrapper-->
                            <?php
                            break;
                        default:
                            ?>
                            <!-- Start wrapper-->
                            <div id="wrapper">

                                <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
                                <div class="card card-authentication1 mx-auto my-5">
                                    <div class="card-body">
                                        <div class="card-content p-2">
                                            <div class="text-center">
                                                <img src="assets/images/logo-icon.png" alt="logo icon">
                                            </div>
                                            <div class="card-title text-uppercase text-center py-3">OSP-PHP(S) | Setup</div>
                                            <form method="post" action="setup.php" class="form-group">
                                                <p>Bitte gebe deinen Domain Pfad zum OSP Webinterface an, sollte der unten angezeigte Pfad stimmen kannst du auf <u>Weiter</u> klicken.</p>
                                                <label>Domain Pfad:</label>
                                                <input type="text" name="pfad" value="https://<?php echo $_SERVER["SERVER_NAME"]; ?>/" class="form-control"><br />
                                                <button type="submit" class="btn btn-success">Weiter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!--Start Back To Top Button-->
                                <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
                                <!--End Back To Top Button-->

                            </div><!--wrapper-->
                            <footer style="align-items:center; text-align: center; position: absolute; bottom: 0; width: 100%;">
                                <p>Copyright <?php echo date("Y"); ?> by OSP-PHP (S). Alle Rechte vorbehalten.</p>
                            </footer>

                            <?php
                            break;
                    }
                    ?>


                    <!-- Bootstrap core JavaScript-->
                    <script src="assets/js/jquery.min.js"></script>
                    <script src="assets/js/popper.min.js"></script>
                    <script src="assets/js/bootstrap.min.js"></script>

                    <!-- sidebar-menu js -->
                    <script src="assets/js/sidebar-menu.js"></script>

                    <!-- Custom scripts -->
                    <script src="assets/js/app-script.js"></script>
                    </body>
                    </html>
