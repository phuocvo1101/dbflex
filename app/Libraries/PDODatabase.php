<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 5/30/2015
 * Time: 12:12 PM
 */

namespace Libraries;


class PDODatabase extends  \PDO{
    public function __construct($dsn, $username, $passwd, $options=array())
    {
        return new parent($dsn, $username, $passwd, $options);
    }
} 