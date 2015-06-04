<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:22 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details of an Option
 */
class Option
{
    public $Value;
    public function __construct($value = '')
    {
        $this->Value = $value;
    }
}
