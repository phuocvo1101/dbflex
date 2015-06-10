<?php
namespace Configs;


use Controllers\MappingController;
use Controllers\SettingController;
use Controllers\UserController;

class Routing {
    protected  $baseController;
    protected  $content;
    public function __construct()
    {
        $this->baseController = null;
    }

    public function getRouting()
    {

        $layout='layout.tpl';
        if(isset($_GET["controller"]) && isset($_GET['action'])) {

            switch(strtolower($_GET["controller"])) {
                case "setting":
                    $this->baseController = new SettingController();
                    break;
                case "user":
                    $this->baseController = new UserController();
                    break;
                case "mapping":
                    $this->baseController = new MappingController();
                    break;
                default:
                    $this->baseController = new SettingController();
                    break;
            }
            switch(strtolower($_GET['action'])) {
                case 'index':
                    $this->content = $this->baseController->indexAction();
                    break;
                case 'login':
                    $layout='loginlayout.tpl';
                    $this->content = $this->baseController->login();
                    break;
                case 'logout':
                    $this->content = $this->baseController->logout();
                    break;
                case 'changepassword':
                    $this->content = $this->baseController->changePassword();
                    break;
                default:
                    $this->content =$this->baseController->indexAction();
                    break;
            }
        } else {
            $_GET['controller'] = 'setting';
            $_GET['action'] = 'index';
            $basecontroller = new SettingController();
            $this->content = $basecontroller->indexAction();
        }

        return array($this->content,$layout);
    }
}