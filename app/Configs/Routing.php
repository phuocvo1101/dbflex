<?php
namespace Configs;


use Controllers\ReportController;
use Controllers\DashBoardController;
use Controllers\ProductController;
class Routing {
    protected  $baseController;
    protected  $content;
    public function __construct()
    {
        $this->baseController = null;
    }

    public function getRouting()
    {
        if(isset($_GET["controller"]) && isset($_GET['action'])) {

            switch($_GET["controller"]) {

                case "report":
                    $this->baseController = new ReportController();
                    break;
                case "product":
                    $this->baseController = new ProductController();
                    break;
                case "dashboard":
                    $this->baseController = new DashBoardController();
                    break;
                default:
                    $this->baseController = new DashBoardController();
                    break;
            }
            switch(strtolower($_GET['action'])) {
                case 'index':
                    $this->content = $this->baseController->indexAction();
                    break;
                default:
                    $this->content =$this->baseController->indexAction();
                    break;
            }
        } else {
            $_GET['controller'] = 'dashboard';
            $_GET['action'] = 'index';
            $basecontroller = new DashBoardController();
            $this->content = $basecontroller->indexAction();
        }

        return $this->content;
    }
}