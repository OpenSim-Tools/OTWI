<?php

class dashboard_model extends Model {

    public $_OPENSIM = NULL;

    function __construct() {
        parent::__construct();

        $this->_OPENSIM = new OpenSim();
    }

    public function GridTalk_Feed() {
        $feed_url = 'https://www.gridtalk.de/syndication.php';
        $feedcache_path = $_SERVER['DOCUMENT_ROOT'] . '/feed_tmp/feed_cache.html';
        $feedcache_max_age = 60;
        $max_entries = 10;

        if (!file_exists($feedcache_path) or filemtime($feedcache_path) < (time() - $feedcache_max_age)) {
            $xml = simplexml_load_string(file_get_contents($feed_url));
            $output = '<a href="https://www.gridtalk.de" target="_blank"><img src="' . URL . 'assets/images/gridtalk_logo.png" style="border-radius: 10px;" title="GridTalk.de | Das deutsche OpenSim Forum"></a><br /><br />';
            $output .= '<div class="row"><div class="col-lg-12"><div class="card"><div class="card-body"><h5 class="card-title"><a href="' . htmlspecialchars($xml->channel->link) . '">' . htmlspecialchars($xml->channel->title) . '</a> (Die ' . (int) $max_entries . ' neusten Einträge)</h5><div class="table-responsive">' . PHP_EOL;
            $entries = $xml->channel->item;
            $counter = 0;
            $output .= '<table class="table table-striped">';
            $output .= '<thead>';
            $output .= '<tr>';
            $output .= '<th scope="col">Topic</th>';
            $output .= '<th scope="col">Date, time</th>';
            $output .= '<th scope="col">Forum</th>';
            $output .= '</tr>';
            $output .= '<tbody>';

            foreach ($entries as $root) {
                $counter++;
                // Ausgabe nach x Einträgen beenden:
                if ($counter > $max_entries) {
                    break;
                }
                $date = date('d.m.Y, H:i:s', strtotime($root->pubDate));
                // Anreißertext:
                //$description = strip_tags($root->description);
                $output .= '<tr><td>' . htmlspecialchars($root->title) . '</td><td>' . htmlspecialchars($date) . '</td><td><a href="' . htmlspecialchars($root->link) . '" title="' . htmlspecialchars($date) . '" target="_blank">' . _('Read more') . '</a></td></tr>' . PHP_EOL;
            }
            $output .= '</tbody>';
            $output .= '</table>';
            $output .= '</div></div></div></div>';
            echo $output;
            file_put_contents($feedcache_path, $output);
        } else {
            echo file_get_contents($feedcache_path);
        }
    }

    public function otwi_settings() {
        $sth = $this->db->prepare("SELECT * FROM " . DB_PREF . "settings");
        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function otwi_settings_save() {
        $sth = $this->db->prepare("UPDATE " . DB_PREF . "settings SET value = :value WHERE ID = :id");
        $sth->execute(array(
            ':value' => $_POST['gridtalk_time'],
            ':id' => 1
        ));

        $sth = $this->db->prepare("UPDATE " . DB_PREF . "settings SET value = :value WHERE ID = :id");
        $sth->execute(array(
            ':value' => $_POST['gridtalk_entries'],
            ':id' => 2
        ));

        $sth = $this->db->prepare("UPDATE " . DB_PREF . "settings SET value = :value WHERE ID = :id");
        $sth->execute(array(
            ':value' => $_POST['language'],
            ':id' => 3
        ));

        $sth = $this->db->prepare("UPDATE " . DB_PREF . "settings SET value = :value WHERE ID = :id");
        $sth->execute(array(
            ':value' => $_POST['update'],
            ':id' => 4
        ));

        $sth = $this->db->prepare("UPDATE " . DB_PREF . "settings SET value = :value WHERE ID = :id");
        $sth->execute(array(
            ':value' => $_POST['avatar_src'],
            ':id' => 5
        ));

        return header('Location: ' . URL . 'dashboard/settings');
    }

    public function otwi_robust() {
        $sth = $this->db->prepare("SELECT * FROM " . DB_PREF . "robust");
        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function otwi_robust_save() {
        $sth = $this->db->prepare("UPDATE " . DB_PREF . "robust SET server_host = :dbhost, server_dbname = :dbname, server_user = :dbuser, server_pass = :dbpass WHERE ID = 1");
        $sth->execute(array(
            ':dbhost' => $_POST['server_host'],
            ':dbname' => $_POST['server_dbname'],
            ':dbuser' => $_POST['server_user'],
            ':dbpass' => $_POST['server_pass']
        ));

        $this->_OPENSIM->osdb_init();

        return header('Location: ' . URL . 'dashboard/robust');
    }

    public function otwi_settings_cache() {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/feed_tmp/feed_cache.html');
        return header('Location: ' . URL . 'dashboard/settings');
    }

    public function otwi_updater($value) {

        $sth = $this->db->prepare("SELECT value FROM " . DB_PREF . "settings WHERE property = :property");
        $sth->execute(array(
            ':property' => 'update_src'
        ));
        $data = $sth->fetch();

        $ota = file_get_contents($data['value'] . '&ver=' . $value);

        return $ota;
    }

    private function uuidv4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits
                mt_rand(0, 0xffff),
                // 16 bits
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits - 8 bits
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function ospswdsalt() {
        $randomuuid = $this->uuidv4();
        $strrep = str_replace("-", "", $randomuuid);
        return md5($strrep);
    }

    private function ospswdhash($osPasswd, $osSalt) {

        return md5(md5($osPasswd) . ":" . $osSalt);
    }

    public function create_user_push() {

        $benutzeruuid = $this->uuidv4();
        $inventoryuuid = $this->uuidv4();
        $neuparentFolderID = $this->uuidv4();
        $neuHauptFolderID = $this->uuidv4();
        $osVorname = $_POST['firstname'];
        $osNachname = $_POST['lastname'];
        if (!empty($_POST['email'])) {
            $osEMail = $_POST['email'];
        } 

        
        $osDatum = time();
        $osPasswd = $_POST['password'];

        
        $osSalt = $this->ospswdsalt();
        $osHash = $this->ospswdhash($osPasswd, $osSalt);

        $statement = $this->osDB->prepare("SELECT * FROM UserAccounts WHERE FirstName = :FirstName AND LastName = :LastName");
        $result = $statement->execute(array('FirstName' => $osVorname, 'LastName' => $osNachname));
        $user = $statement->fetch();

        // Avatar eintragen
        $neuer_user = array();
        $neuer_user['PrincipalID'] = $benutzeruuid;
        $neuer_user['ScopeID'] = '00000000-0000-0000-0000-000000000000';
        $neuer_user['FirstName'] = $osVorname;
        $neuer_user['LastName'] = $osNachname;
        $neuer_user['Email'] = $osEMail;
        $neuer_user['ServiceURLs'] = 'HomeURI= InventoryServerURI= AssetServerURI=';
        $neuer_user['Created'] = $osDatum;
        $neuer_user['UserLevel'] = '0';
        $neuer_user['UserFlags'] = '0';
        $neuer_user['UserTitle'] = '';
        $neuer_user['active'] = '1';

        $statement = $this->osDB->prepare("INSERT INTO UserAccounts (PrincipalID, ScopeID, FirstName, LastName, Email, ServiceURLs, Created, UserLevel, UserFlags, UserTitle, active) VALUES (:PrincipalID, :ScopeID, :FirstName, :LastName, :Email, :ServiceURLs, :Created, :UserLevel, :UserFlags, :UserTitle, :active)");
        $statement->execute($neuer_user);

// UUID, passwordHash, passwordSalt, webLoginKey, accountType
        $neues_passwd = array();
        $neues_passwd['UUID'] = $benutzeruuid;
        $neues_passwd['passwordHash'] = $osHash;
        $neues_passwd['passwordSalt'] = $osSalt;
        $neues_passwd['webLoginKey'] = '00000000-0000-0000-0000-000000000000';
        $neues_passwd['accountType'] = 'UserAccount';

        $statement = $this->osDB->prepare("INSERT INTO auth (UUID, passwordHash, passwordSalt, webLoginKey, accountType) VALUES (:UUID, :passwordHash, :passwordSalt, :webLoginKey, :accountType)");
        $statement->execute($neues_passwd);

// Das nachfolgende eintragen in der GridUser Spalte
        $neuer_GridUser = array();
        $neuer_GridUser['UserID'] = $benutzeruuid;
        $neuer_GridUser['HomeRegionID'] = '00000000-0000-0000-0000-000000000000';
        $neuer_GridUser['HomePosition'] = '<0,0,0>';
        $neuer_GridUser['LastRegionID'] = '00000000-0000-0000-0000-000000000000';
        $neuer_GridUser['LastPosition'] = '<0,0,0>';

        $statement = $this->osDB->prepare("INSERT INTO GridUser (UserID, HomeRegionID, HomePosition, LastRegionID, LastPosition) VALUES (:UserID, :HomeRegionID, :HomePosition, :LastRegionID, :LastPosition)");
        $statement->execute($neuer_GridUser);

// Inventarverzeichnisse erstellen
// Ordner Textures
        $Texturesuuid = $this->uuidv4();

        $verzeichnistextur = array();
        $verzeichnistextur['folderName'] = 'Textures';
        $verzeichnistextur['type'] = '0';
        $verzeichnistextur['version'] = '1';
        $verzeichnistextur['folderID'] = $Texturesuuid;
        $verzeichnistextur['agentID'] = $benutzeruuid;
        $verzeichnistextur['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnistextur);

// Ordner Sounds
        $Soundsuuid = $this->uuidv4();

        $verzeichnisSounds = array();
        $verzeichnisSounds['folderName'] = 'Sounds';
        $verzeichnisSounds['type'] = '1';
        $verzeichnisSounds['version'] = '1';
        $verzeichnisSounds['folderID'] = $Soundsuuid;
        $verzeichnisSounds['agentID'] = $benutzeruuid;
        $verzeichnisSounds['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisSounds);

// Ordner Calling Cards
        $CallingCardsuuid = $this->uuidv4();

        $verzeichnisCallingCards = array();
        $verzeichnisCallingCards['folderName'] = 'Calling Cards';
        $verzeichnisCallingCards['type'] = '2';
        $verzeichnisCallingCards['version'] = '2';
        $verzeichnisCallingCards['folderID'] = $CallingCardsuuid;
        $verzeichnisCallingCards['agentID'] = $benutzeruuid;
        $verzeichnisCallingCards['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisCallingCards);

// Ordner Landmarks
        $Landmarksuuid = $this->uuidv4();

        $verzeichnisLandmarks = array();
        $verzeichnisLandmarks['folderName'] = 'Landmarks';
        $verzeichnisLandmarks['type'] = '3';
        $verzeichnisLandmarks['version'] = '1';
        $verzeichnisLandmarks['folderID'] = $Landmarksuuid;
        $verzeichnisLandmarks['agentID'] = $benutzeruuid;
        $verzeichnisLandmarks['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisLandmarks);

// Ordner My Inventory
        $MyInventoryuuid = $this->uuidv4();

        $verzeichnisMyInventory = array();
        $verzeichnisMyInventory['folderName'] = 'My Inventory';
        $verzeichnisMyInventory['type'] = '8';
        $verzeichnisMyInventory['version'] = '17';
        $verzeichnisMyInventory['folderID'] = $neuHauptFolderID;
        $verzeichnisMyInventory['agentID'] = $benutzeruuid;
        $verzeichnisMyInventory['parentFolderID'] = '00000000-0000-0000-0000-000000000000';

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisMyInventory);

// Ordner Photo Album
        $PhotoAlbumuuid = $this->uuidv4();

        $verzeichnisPhotoAlbum = array();
        $verzeichnisPhotoAlbum['folderName'] = 'Photo Album';
        $verzeichnisPhotoAlbum['type'] = '15';
        $verzeichnisPhotoAlbum['version'] = '1';
        $verzeichnisPhotoAlbum['folderID'] = $PhotoAlbumuuid;
        $verzeichnisPhotoAlbum['agentID'] = $benutzeruuid;
        $verzeichnisPhotoAlbum['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisPhotoAlbum);

// Ordner Clothing
        $Clothinguuid = $this->uuidv4();

        $verzeichnisClothing = array();
        $verzeichnisClothing['folderName'] = 'Clothing';
        $verzeichnisClothing['type'] = '5';
        $verzeichnisClothing['version'] = '3';
        $verzeichnisClothing['folderID'] = $Clothinguuid;
        $verzeichnisClothing['agentID'] = $benutzeruuid;
        $verzeichnisClothing['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisClothing);

// Ordner Objects
        $Objectsuuid = $this->uuidv4();

        $verzeichnisObjects = array();
        $verzeichnisObjects['folderName'] = 'Objects';
        $verzeichnisObjects['type'] = '6';
        $verzeichnisObjects['version'] = '1';
        $verzeichnisObjects['folderID'] = $Objectsuuid;
        $verzeichnisObjects['agentID'] = $benutzeruuid;
        $verzeichnisObjects['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisObjects);

// Ordner Notecards
        $Notecardsuuid = $this->uuidv4();

        $verzeichnisNotecards = array();
        $verzeichnisNotecards['folderName'] = 'Notecards';
        $verzeichnisNotecards['type'] = '7';
        $verzeichnisNotecards['version'] = '1';
        $verzeichnisNotecards['folderID'] = $Notecardsuuid;
        $verzeichnisNotecards['agentID'] = $benutzeruuid;
        $verzeichnisNotecards['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisNotecards);

// Ordner Scripts
        $Scriptsuuid = $this->uuidv4();

        $verzeichnisScripts = array();
        $verzeichnisScripts['folderName'] = 'Scripts';
        $verzeichnisScripts['type'] = '10';
        $verzeichnisScripts['version'] = '1';
        $verzeichnisScripts['folderID'] = $Scriptsuuid;
        $verzeichnisScripts['agentID'] = $benutzeruuid;
        $verzeichnisScripts['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisScripts);

// Ordner Body Parts
        $BodyPartsuuid = $this->uuidv4();

        $verzeichnisBodyParts = array();
        $verzeichnisBodyParts['folderName'] = 'Body Parts';
        $verzeichnisBodyParts['type'] = '13';
        $verzeichnisBodyParts['version'] = '5';
        $verzeichnisBodyParts['folderID'] = $BodyPartsuuid;
        $verzeichnisBodyParts['agentID'] = $benutzeruuid;
        $verzeichnisBodyParts['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisBodyParts);

// Ordner Trash
        $Trashuuid = $this->uuidv4();

        $verzeichnisTrash = array();
        $verzeichnisTrash['folderName'] = 'Trash';
        $verzeichnisTrash['type'] = '14';
        $verzeichnisTrash['version'] = '1';
        $verzeichnisTrash['folderID'] = $Trashuuid;
        $verzeichnisTrash['agentID'] = $benutzeruuid;
        $verzeichnisTrash['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisTrash);

// Ordner Lost And Found
        $LostAndFounduuid = $this->uuidv4();

        $verzeichnisLostAndFound = array();
        $verzeichnisLostAndFound['folderName'] = 'Lost And Found';
        $verzeichnisLostAndFound['type'] = '16';
        $verzeichnisLostAndFound['version'] = '1';
        $verzeichnisLostAndFound['folderID'] = $LostAndFounduuid;
        $verzeichnisLostAndFound['agentID'] = $benutzeruuid;
        $verzeichnisLostAndFound['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisLostAndFound);

// Ordner Animations
        $Animationsuuid = uuidv4();

        $verzeichnisAnimations = array();
        $verzeichnisAnimations['folderName'] = 'Animations';
        $verzeichnisAnimations['type'] = '20';
        $verzeichnisAnimations['version'] = '1';
        $verzeichnisAnimations['folderID'] = $Animationsuuid;
        $verzeichnisAnimations['agentID'] = $benutzeruuid;
        $verzeichnisAnimations['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisAnimations);

// Ordner Gestures
        $Gesturesuuid = $this->uuidv4();

        $verzeichnisGestures = array();
        $verzeichnisGestures['folderName'] = 'Gestures';
        $verzeichnisGestures['type'] = '21';
        $verzeichnisGestures['version'] = '1';
        $verzeichnisGestures['folderID'] = $Gesturesuuid;
        $verzeichnisGestures['agentID'] = $benutzeruuid;
        $verzeichnisGestures['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisGestures);

// Friends
        $Friendsuuid = $this->uuidv4();

        $verzeichnisFriends = array();
        $verzeichnisFriends['folderName'] = 'Friends';
        $verzeichnisFriends['type'] = '2';
        $verzeichnisFriends['version'] = '2';
        $verzeichnisFriends['folderID'] = $Friendsuuid;
        $verzeichnisFriends['agentID'] = $benutzeruuid;
        $verzeichnisFriends['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisFriends);

// Favorites
        $Favoritesuuid = $this->uuidv4();

        $verzeichnisFavorites = array();
        $verzeichnisFavorites['folderName'] = 'Favorites';
        $verzeichnisFavorites['type'] = '23';
        $verzeichnisFavorites['version'] = '1';
        $verzeichnisFavorites['folderID'] = $Favoritesuuid;
        $verzeichnisFavorites['agentID'] = $benutzeruuid;
        $verzeichnisFavorites['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisFavorites);

// Current Outfit
        $CurrentOutfituuid = $this->uuidv4();

        $verzeichnisCurrentOutfit = array();
        $verzeichnisCurrentOutfit['folderName'] = 'Current Outfit';
        $verzeichnisCurrentOutfit['type'] = '46';
        $verzeichnisCurrentOutfit['version'] = '1';
        $verzeichnisCurrentOutfit['folderID'] = $CurrentOutfituuid;
        $verzeichnisCurrentOutfit['agentID'] = $benutzeruuid;
        $verzeichnisCurrentOutfit['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisCurrentOutfit);



// All
        $Alluuid = $this->uuidv4();

        $verzeichnisAll = array();
        $verzeichnisAll['folderName'] = 'All';
        $verzeichnisAll['type'] = '2';
        $verzeichnisAll['version'] = '1';
        $verzeichnisAll['folderID'] = $Alluuid;
        $verzeichnisAll['agentID'] = $benutzeruuid;
        $verzeichnisAll['parentFolderID'] = $neuHauptFolderID;

        $statement = $this->osDB->prepare("INSERT INTO inventoryfolders (folderName, type, version, folderID, agentID, parentFolderID) VALUES (:folderName, :type, :version, :folderID, :agentID, :parentFolderID)");
        $statement->execute($verzeichnisAll);

        //InventoryItems
/**
        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Skin';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '1';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        
        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '13';
        $inventoryItem['inventoryName'] = 'Default Shape';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '0';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Shape';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '0';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Shirt';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '4';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '5';
        $inventoryItem['inventoryName'] = 'Default Pants';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '5';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '5';
        $inventoryItem['inventoryName'] = 'Default Shirt';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '4';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Hair';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '2';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '13';
        $inventoryItem['inventoryName'] = 'Default Eyes';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '3';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Pants';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '5';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '24';
        $inventoryItem['inventoryName'] = 'Default Eyes';
        $inventoryItem['inventoryNextPermissions'] = '32768';
        $inventoryItem['inventoryCurrentPermissions'] = '32768';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '32768';
        $inventoryItem['inventoryEveryOnePermissions'] = '32768';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '3';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '32768';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);        

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '13';
        $inventoryItem['inventoryName'] = 'Default Hair';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '2';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);

        $inventoryItem = array();
        $inventoryItem['assetID'] = $this->uuidv4();
        $inventoryItem['assetTyp'] = '13';
        $inventoryItem['inventoryName'] = 'Default Skin';
        $inventoryItem['inventoryNextPermissions'] = '581632';
        $inventoryItem['inventoryCurrentPermissions'] = '581632';
        $inventoryItem['invType'] = '18';
        $inventoryItem['CreatorID'] = $benutzeruuid;
        $inventoryItem['inventoryBasePermissions'] = '581632';
        $inventoryItem['inventoryEveryOnePermissions'] = '581632';
        $inventoryItem['salePrice'] = '0';
        $inventoryItem['saleType'] = '0';
        $inventoryItem['creationdate'] = $osDatum;
        $inventoryItem['groupID'] = '00000000-0000-0000-0000-000000000000';
        $inventoryItem['groupOwned'] = '0';
        $inventoryItem['flags'] = '1';
        $inventoryItem['inventoryID'] = $Clothinguuid;
        $inventoryItem['avatarID'] = $benutzeruuid;
        $inventoryItem['parentFolderID'] = $Clothinguuid;
        $inventoryItem['inventoryGroupPermissions'] = '581632';
        
        $statement = $this->osDB->prepare("INSERT INTO inventoryitems (assetID, assetTyp, inventoryName, inventoryNextPermissions, inventoryCurrentPermissions, invType, CreatorID, inventoryBasePermissions, inventoryEveryOnePermissions, salePrice, saleType, creationdate, groupID, groupOwned, flags, inventoryID, avatarID, parentFolderID, inventoryGroupPermissions) VALUES (:assetID, :assetTyp, :inventoryName, :inventoryNextPermissions, :inventoryCurrentPermissions, :invType, :CreatorID, :inventoryBasePermissions, :inventoryEveryOnePermissions, :salePrice, :saleType, :creationdate, :groupID, :groupOwned, :flags, :inventoryID, :avatarID, :parentFolderID, :inventoryGroupPermissions)");        
        $statement->execute($inventoryItem);
**/
        return header('Location: /dashboard/');        
    }
    
    
    public function userMode(string $userID, string $mode) {
        if($mode == 'activate') {
            $sth = $this->osDB->prepare("UPDATE UserAccounts set active = :set, UserLevel = :userlvl WHERE PrincipalID = :avatar");
            $sth->execute(array(
                ':set' => 1,
                ':avatar' => $userID,
                ':userlvl' => 0
            ));
            
            return header('Location: ' . URL . 'dashboard/griduser');
        }
        
        if($mode == 'deactivate') {
            $sth = $this->osDB->prepare("UPDATE UserAccounts set active = :set, UserLevel = :userlvl WHERE PrincipalID = :avatar");
            $sth->execute(array(
                ':set' => 0,
                ':avatar' => $userID,
                ':userlvl' => "-1"
            ));
            
            return header('Location: ' . URL . 'dashboard/griduser');            
        }
    }

}



