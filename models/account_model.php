<?php

class account_model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function run() {
        $sth = $this->db->prepare("SELECT Username FROM " . DB_PREF . "user WHERE Username = :login AND Password = :password");
        $sth->execute(array(
            ':login' => $_POST['username'],
            ':password' => md5(md5($_POST['password']))
        ));

        $data = $sth->fetch();
        
        $count = $sth->rowCount();
        if ($count > 0) {
            // login
            Session::init();
            Session::set('Username', $data['Username']);
            Session::set('loggedIn', true);
            header('location: ../dashboard');
        } else {
            header('location: ../');
        }
    }

}
