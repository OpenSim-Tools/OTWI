<?php

class dashboard extends Controller {

    public $_OPENSIM = NULL;
    public $_OS = FALSE;

    function __construct() {
        parent::__construct();
        Session::init();
        $logged = Session::get('loggedIn');
        if ($logged == false) {
            Session::destroy();
            header('location: ../index');
            exit;
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/config/robust.php')) {
            $this->_OPENSIM = new OpenSim();
            $this->_OS = TRUE;
        }
        $this->view->findUser = $this->_OPENSIM;
    }

    public function index() {
        $this->view->PageTitle = "OTWI | Dashboard";
        if ($this->_OS) {
            $this->view->os_Info = $this->_OPENSIM->os_Info();
            if($this->_OPENSIM->os_Info()['region_count'] > 0) {
                $this->view->grid = true;
            } else {
                $this->view->grid = false;
            }
            $this->view->os_griduser = $this->_OPENSIM->os_griduser();
        }
        $this->view->render('dashboard/index', true);
    }

    public function partner() {
        $this->view->PageTitle = "OTWI | Partnerschaft";
        $this->view->partnersearch = $this->_OPENSIM->os_userprofile_partner();
        $this->view->render('dashboard/partner', true);
    }
    
    public function create_partner() {
        $this->view->PageTitle = "OTWI | Partnerschaft erstellen";
        $this->view->os_griduser = $this->_OPENSIM->os_griduser();
        $this->view->render('dashboard/create_partner', true);
    }

    public function region() {
        $this->view->PageTitle = "OTWI | Regions";
        $this->view->os_region = $this->_OPENSIM->os_regions();
        $this->view->render('dashboard/region', true);
    }

    public function griduser() {
        $this->view->PageTitle = "OTWI | Grid User";
        $this->view->useraccounts = $this->_OPENSIM->os_useraccounts();
        $this->view->render('dashboard/griduser', true);
    }

    public function groups() {
        $this->view->PageTitle = "OTWI | Groups";
        $this->view->os_groups = $this->_OPENSIM->os_groups();
        $this->view->render('dashboard/groups', true);
    }
    
    public function groups_view($param) {
      
        $this->view->PageTitle = "OTWI | Groups View";
        $this->view->os_groups = $this->_OPENSIM->os_groups_groups($param);
        $this->view->membership = $this->_OPENSIM->os_groups_membership($param);
        $this->view->render('dashboard/groups_view', true);        
    }
    
    public function groups_edit($param) {

        $this->view->PageTitle = "OTWI | Groups Edit";
        $this->view->os_groups = $this->_OPENSIM->os_groups_roles($param);
        $this->view->render('dashboard/groups_edit', true);        
    }

    public function robust() {
        $this->view->PageTitle = "OTWI | Robust Settings";
        $this->view->robust = $this->model->otwi_robust();
        $this->view->render('dashboard/robust', true);
    }
    
    public function robust_save() {
        $this->model->otwi_robust_save();
    }

    public function remote() {
        $this->view->PageTitle = "OTWI | Remote Settings";
        $this->view->render('dashboard/remote', true);
    }

    public function updates() {
        $this->view->PageTitle = "OTWI | Major Updates";
        $this->view->update = $this->model;
        $this->view->render('dashboard/updates', true);
    }

    public function settings() {
        $this->view->PageTitle = "OTWI | Settings";
        $this->view->settings = $this->model->otwi_settings();
        $this->view->render('dashboard/settings', true);
    }

    public function settings_save() {
        $this->model->otwi_settings_save();
    }

    public function cache() {
        $this->model->otwi_settings_cache();
    }

    public function credits() {
        $this->view->PageTitle = "OTWI | Credits";
        $this->view->render('dashboard/credits', true);
    }

    public function feeds() {
        $this->view->PageTitle = "OTWI | GridTalk Forum Feeds";
        $this->view->rss = $this->model;
        $this->view->render('dashboard/feeds', true);
    }
    
    public function tools() {
        $this->view->PageTitle = "OTWI | Grid Tools";
        $this->view->render('dashboard/tools', true);
    }

    public function logout() {
        SESSION::destroy();
        header('Location: /');
    }
}
