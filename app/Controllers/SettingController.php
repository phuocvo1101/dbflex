<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/5/2015
 * Time: 10:52 PM
 */

namespace Controllers;

use Controllers\BaseController;
use Controllers\IBaseController;
use Libraries\Pagination;
use Models\ReportModel;
use Models\SettingModel;

class SettingController extends BaseController implements IBaseController{
    protected  $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new SettingModel();
    }

    public function indexAction()
    {
        if(isset($_POST['subFormSetting'])) {
            $message = '';
            $flag = true;
            $settings = $_POST;

            if(!isset($_POST['dbflex_user']) || empty($_POST['dbflex_user'])) {
                $flag= false;
                $message = 'DBFlex User is not empty!';
            }
             if(!isset($_POST['dbflex_pass']) || empty($_POST['dbflex_pass'])) {
                $flag= false;
                $message = 'DBFlex Password is not empty!';
            }
             if(!isset($_POST['dbflex_url']) || empty($_POST['dbflex_url'])) {
                $flag= false;
                $message = 'DBFlex URL is not empty!';
            }
             if(!isset($_POST['eway_key']) || empty($_POST['eway_key'])) {
                $flag= false;
                $message = 'Eway Key  is not empty!';
            }
             if(!isset($_POST['eway_pass']) || empty($_POST['eway_pass'])) {
                $flag= false;
                $message = 'Eway Password  is not empty!';
            }

             if(!isset($_POST['eway_envir'])) {
                $flag= false;
                $message = 'Eway Enviroment  is not empty!';
            }
             if(!isset($_POST['eway_appid']) || empty($_POST['eway_appid'])) {
                $flag= false;
                $message = 'Eway AppID  is not empty!';
            }
            if(!isset($_POST['cronjob_interval']) || empty($_POST['cronjob_interval'])) {
                $flag= false;
                $message = 'Cronjob Interval Time  is not empty!';
            }

            if($flag==false) {
                $this->template->assign('message',$message);
                $this->template->assign('settings', $settings);
                return $this->template->fetch('setting/index.tpl');
            }
            $result = $this->model->updateSetting($settings);

            if(!$result) {
                $this->template->assign('result',0);
                $this->template->assign('settings', $settings);
                return $this->template->fetch('setting/index.tpl');
            }
            $this->template->assign('result',1);
            $settings = $this->model->getSettings();
            $this->template->assign('settings', $settings);
            return $this->template->fetch('setting/index.tpl');
        }
        $settings = $this->model->getSettings();
        $this->template->assign('settings', $settings);
        return $this->template->fetch('setting/index.tpl');
    }
    public function updateAction()
    {

        if(isset($_POST['update'])){
            $value=$_POST['transaction'];
          // echo $value;die();
            $this->model->updateTransaction($value);
            header('location:index.php?controller=mapping&action=index');
        }
        $setting= $this->model->getSetting();
        $this->template->assign('setting',$setting);
       return  $this->template->fetch('setting/update.tpl');

    }
} 