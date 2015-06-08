<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/7/2015
 * Time: 12:07 AM
 */

namespace Controllers;


use Models\UserModel;

class UserController extends BaseController{
    protected $model;
    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
    }
    public function logout()
    {
        session_destroy();
        header('location: index.php?controller=user&action=login');
        exit();
    }

    public function login()
    {
        if(isset($_POST['submitSigin'])) {
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $result = $this->model->checkLogin(array(
                'username' => $username,
                'password' => md5($password)
            ));
            if($result==false || !isset($result->id)) {
                $message = 'Username or Password is invalid!';
                $this->template->assign('message',$message);
                return $this->template->fetch('user/login.tpl');
            }

            $_SESSION['username'] = $result->username;
            $_SESSION['fullname'] = $result->fullname;
            $_SESSION['email'] = $result->email;
            $_SESSION['user_id'] = $result->id;
            header('location:index.php');
            exit();
        }
        return $this->template->fetch('user/login.tpl');
    }

    public function changePassword()
    {
        if(isset($_POST['subFormChangePassword'])) {
            $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
            $newPassword =  isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $confirmPassword =  isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
            if(empty($currentPassword)) {
                $message = 'Current Password is not blank!';
                $this->template->assign('message',$message);
                return $this->template->fetch('user/changepassword.tpl');
            }

            if(empty($newPassword)) {
                $message = 'New Password is not blank!';
                $this->template->assign('message',$message);
                return $this->template->fetch('user/changepassword.tpl');
            }

            if($newPassword!=$confirmPassword) {
                $message = 'New Password and Confirm Passowrd is not same!';
                $this->template->assign('message',$message);
                return $this->template->fetch('user/changepassword.tpl');
            }
            $checkPassword = $this->model->checkLogin(array(
                'username' => $_SESSION['username'],
                'password' => md5($currentPassword)
            ));

            if($checkPassword==false) {
                $message = 'Current Password is invalid!';
                $this->template->assign('message',$message);
                return $this->template->fetch('user/changepassword.tpl');
            }

            $result = $this->model->updatePassword(array(
               'user_id' => $_SESSION['user_id'],
                'password' => md5($confirmPassword)
            ));

            if(!$result) {
                $this->template->assign('result',0);
                return $this->template->fetch('user/changepassword.tpl');
            }
            session_destroy();
            header('location:index.php');

        }
        return $this->template->fetch('user/changepassword.tpl');
    }
} 