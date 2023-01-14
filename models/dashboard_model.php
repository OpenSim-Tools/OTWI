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

}
