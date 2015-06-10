<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/10/2015
 * Time: 12:12 AM
 */

namespace Controllers;

use Controllers\BaseController;
use Controllers\IBaseController;
use Libraries\Pagination;
use Models\MappingModel;

class MappingController extends  BaseController implements IBaseController
{
    protected  $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new MappingModel();
    }
    public function indexAction()
    {
        return $this->template->fetch('mapping/index.tpl');
    }
} 