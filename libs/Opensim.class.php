<?php

class OpenSim extends Model {

    function __construct() {
        parent::__construct();
    }

    public function osdb_init() {

        $sth = $this->db->prepare("SELECT server_host, server_dbname, server_user, server_pass FROM " . DB_PREF . "robust WHERE ID = 1");
        $sth->execute();

        $data = $sth->fetch();

        $zeile = "<?php \r\n";
        $zeile .= "define('OSDB_TYPE', 'mysql'); \r\n";
        $zeile .= "define('OSDB_HOST', '" . $data['server_host'] . "'); \r\n";
        $zeile .= "define('OSDB_NAME', '" . $data['server_dbname'] . "'); \r\n";
        $zeile .= "define('OSDB_USER', '" . $data['server_user'] . "'); \r\n";
        $zeile .= "define('OSDB_PASS', '" . $data['server_pass'] . "'); \r\n";
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/config/robust.php", $zeile);

        return true;
    }

    public function os_griduser() {
        try {
            $sth = $this->osDB->prepare("SELECT * FROM (UserAccounts INNER Join GridUser ON UserAccounts.PrincipalID = GridUser.UserID) INNER JOIN regions ON GridUser.LastRegionID = regions.uuid");
            $sth->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function os_regions() {
        try {
            $sth = $this->osDB->prepare("SELECT * FROM regions");
            $sth->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function os_Info() {

        $ret['now_online'] = 0;
        $ret['hg_online'] = 0;
        $ret['lastmonth_online'] = 0;
        $ret['user_count'] = 0;
        $ret['region_count'] = 0;

        try {
            $region = $this->osDB->prepare("SELECT * FROM regions");
            $region->execute();
            $regionData = $region->rowCount();

            $userAccounts = $this->osDB->prepare("SELECT * FROM UserAccounts");
            $userAccounts->execute();
            $userAccountData = $userAccounts->rowCount();

            $presence = $this->osDB->prepare("SELECT COUNT(DISTINCT Presence.UserID) FROM GridUser, Presence WHERE GridUser.UserID = Presence.UserID AND RegionID != '" . UUID_ZERO . "'");
            $presence->execute();
            $presenceData = $presence->rowCount();

            $allUser = $this->osDB->prepare("SELECT * FROM Presence WHERE RegionID != '" . UUID_ZERO . "'");
            $allUser->execute();
            $allUserData = $allUser->rowCount();

            $lastmonth_online = $this->osDB->prepare("SELECT * FROM GridUser WHERE Login > unix_timestamp(now() - 2592000)");
            $lastmonth_online->execute;
            $lastmonth_onlineData = $lastmonth_online->rowCount();

            $ret['now_online'] = $allUserData;
            if ($allUserData - $presenceData == '-1') {
                $ret['hg_online'] = 0;
            } else {
                $ret['hg_online'] = $allUserData - $presenceData;
            }
            $ret['region_count'] = $regionData;
            $ret['user_count'] = $userAccountData;
            $ret['lastmonth_online'] = $lastmonth_onlineData;
            
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $ret;
    }
    
    public function os_groups() {
        $sth = $this->osDB->prepare("SELECT * FROM os_groups_groups INNER Join os_groups_membership ON os_groups_groups.GroupID = os_groups_membership.GroupID");
        $sth->execute();
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }
    
    public function os_groups_groups($params) {
        $sth = $this->osDB->prepare("SELECT * FROM os_groups_groups INNER Join os_groups_membership ON os_groups_groups.GroupID = os_groups_membership.GroupID WHERE os_groups_groups.GroupID = :groupid");
        $sth->execute(array(
            ':groupid' => $params
        ));
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function os_groups_membership($param) {
        $sth = $this->osDB->prepare("SELECT * FROM os_groups_membership INNER Join os_groups_roles ON os_groups_membership.SelectedRoleID = os_groups_roles.RoleID WHERE os_groups_membership.GroupID = :groupid");
        $sth->execute(array(
            ':groupid' => $param
        ));
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }


    public function os_findUser($uuid) {
        $sth = $this->osDB->prepare("SELECT FirstName, LastName FROM UserAccounts WHERE PrincipalID = :uuid");
        $sth->execute(array(
            ':uuid' => $uuid
        ));
        
        $data = $sth->fetch();
        
        return $data['FirstName'] . ' ' . $data['LastName']; 
    }
    
    public function os_useraccounts() {
        $sth = $this->osDB->prepare("SELECT * FROM UserAccounts");
        $sth->execute();
        
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
