<?php

namespace Controllers;


class BaseController {
    protected  $template;
    public function __construct()
    {
        global $smarty;
        $this->template= $smarty;

        if(!$this->checkLogin()) {
            if(isset($_REQUEST['controller']) && $_REQUEST['controller']=='user' && isset($_REQUEST['controller']) && $_REQUEST['action']=='login') {
                return;
            } else{
                header('location: index.php?controller=user&action=login');
                exit();
            }


        } else{
            if(isset($_REQUEST['controller']) && $_REQUEST['controller']=='user'  && $_REQUEST['action']=='login') {
                header('location: index.php');
                exit();
            }
        }
    }

    public function checkLogin()
    {
        if(!isset($_SESSION['user_id'])) {
            return false;
        }
        return true;
    }

} 