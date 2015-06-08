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
} 