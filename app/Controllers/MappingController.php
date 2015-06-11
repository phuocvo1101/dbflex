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
        $setting= $this->model->getSetting();
        $mappings= $this->model->getMaps();
       // echo "<pre>".print_r($mappings,true)."</pre>";die();
        $this->template->assign('maps',$mappings);
        $this->template->assign('setting',$setting);
        return $this->template->fetch('mapping/index.tpl');
    }
    public function createAction()
    {
        if(isset($_POST['create'])){

            $key= isset($_POST['key'])?$_POST['key']:'';
            $value= isset($_POST['value'])?$_POST['value']:'';
            $data= array(
                'key'=>$key,
                'value'=>$value,
            );
            $this->model->createMap($data);
            return $this->indexAction();
        }
        return $this->template->fetch('mapping/create.tpl');


    }
    public function updateAction()
    {
        $id= $_GET['id'];
        if(isset($_POST['update'])){
            $key= isset($_POST['key'])?$_POST['key']:'';
            $value= isset($_POST['value'])?$_POST['value']:'';
            $data= array(
                'key'=>$key,
                'value'=>$value,
            );
            $this->model->updateMap($data,$id);
            return $this->indexAction();
        }

        $map= $this->model->getMap($id);
       // echo '<pre>'.print_r($map,true).'</pre>';die();
        $this->template->assign('map',$map);
        return $this->template->fetch('mapping/update.tpl');
        // echo 'update test';
    }
    public function deleteAction()
    {
        $id= $_GET['id'];
        $this->model->deleteMap($id);
        return $this->indexAction();


    }
} 