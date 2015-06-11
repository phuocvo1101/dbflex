<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/10/2015
 * Time: 12:30 AM
 */

namespace Models;

use Libraries\Database;
class MappingModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->database = new Database();
    }

    public function getMap($id)
    {
        $query= 'select * from mappings WHERE id=?';
        $this->database->setQuery($query);
        $arr= array(
            array($id,\PDO::PARAM_INT )
        );
        $result= $this->database->loadAllRows($arr);
        return $result;
    }
    public function getMaps()
    {
        $query= 'select * from mappings';
        $this->database->setQuery($query);
        $result= $this->database->loadAllRows();
        return $result;
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
    public function createMap($data)
    {
       // var_dump($data);die();
        $query= 'INSERT INTO mappings(keymap,valuemap) values(?,?)';
        $this->database->setQuery($query);
        $arr=array(
            array($data['key'],\PDO::PARAM_STR),
            array($data['value'],\PDO::PARAM_STR),
        );
        $result=$this->database->execute($arr);
        if(!$result){
            return false;
        }
        return true;

    }
    public function updateMap($data,$id)
    {
       // var_dump($data) ;die();
       // echo $data['key'];die();
        $query = 'UPDATE mappings SET keymap=?,valuemap=? WHERE id=?';
        $this->database->setQuery($query);
        $arr=array(
            array($data['key'],\PDO::PARAM_STR),
            array($data['value'],\PDO::PARAM_STR),
            array($id,\PDO::PARAM_INT),
        );
        $result=$this->database->execute($arr);
        if(!$result){
            return false;
        }
        return true;

    }
    public function deleteMap($id)
    {
        $query= 'DELETE FROM mappings WHERE id=?';
        $this->database->setQuery($query);
        $result = $this->database->execute(array(
            array($id,\PDO::PARAM_INT)
        ));
        if(!$result){
            return false;
        }
        return true;
    }
} 