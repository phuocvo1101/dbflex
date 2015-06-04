<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 5/30/2015
 * Time: 11:30 AM
 */

namespace Models;


//use Libraries\Database;

use Libraries\Database;

class BaseModel {
    protected $database;
    public function __construct()
    {
        $this->database = new Database();
    }
} 