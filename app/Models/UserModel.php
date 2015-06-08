<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/7/2015
 * Time: 12:07 AM
 */

namespace Models;


use Libraries\Database;

class UserModel extends BaseModel{
    public function __construct()
    {
        parent::__construct();

        $this->database = new Database();
    }

    public function checkLogin($params)
    {
        if(!isset($params['username'])) {
            return false;
        }

        if(!isset($params['password'])) {
            return false;
        }

        $sql = 'SELECT * FROM `users` WHERE `username`=? AND `password` = ?';
        $this->database->setQuery($sql);
        $data = array(
            array($params['username'],\PDO::PARAM_STR),
            array($params['password'],\PDO::PARAM_STR)
        );
        $result = $this->database->loadRow($data);
        return $result;
    }

    public function updatePassword($params)
    {
        if(!isset($params['user_id'])) {
            return false;
        }

        if(!isset($params['password'])) {
            return false;
        }

        $sql = 'UPDATE `users` SET `password`=? WHERE `id`=?';
        $this->database->setQuery($sql);
        $data = array(
            array($params['password'],\PDO::PARAM_STR),
            array($params['user_id'],\PDO::PARAM_INT),
        );
        $result = $this->database->execute($data);
        return $result;
    }
} 