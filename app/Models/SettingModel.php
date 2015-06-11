<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/6/2015
 * Time: 11:16 AM
 */

namespace Models;

use Libraries\Database;
use Models\BaseModel;

class SettingModel extends  BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->database = new Database();
    }

    public function getSettings()
    {
        $sql = 'SELECT * FROM `settings`';
        $this->database->setQuery($sql);
        $settings = $this->database->loadAllRows();
        $result = array();
        foreach($settings as $item) {
            $result[$item->key] = $item->value;
        }

        return $result;
    }


    public function updateSetting($settings)
    {
        foreach($settings as $key=>$value) {
            $sql = 'UPDATE `settings` SET `value`=? WHERE `key`= ? ';

            $this->database->setQuery($sql);
            $data = array(
                array($value,\PDO::PARAM_STR),
                array($key,\PDO::PARAM_STR)
            );
            $result = $this->database->execute($data);
        }
        return true;
    }
    public function getSetting()
    {
        $key= "transaction_table";
        $sql = 'SELECT * FROM settings where `key`=?';
        $this->database->setQuery($sql);
        $arr= array(
            array($key,\PDO::PARAM_STR )
        );
        $settings = $this->database->loadRow($arr);
        // var_dump($settings);die();
        return $settings;
    }
    public function updateTransaction($value)
    {
        $key= 'transaction_table';

        $sql = 'UPDATE `settings` SET `value`=? WHERE `key`= ? ';

        $this->database->setQuery($sql);
        $data = array(
            array($value,\PDO::PARAM_STR),
            array($key,\PDO::PARAM_STR)
        );
        $result = $this->database->execute($data);
        if(!$result){
            return false;
        }

        return true;
    }
} 