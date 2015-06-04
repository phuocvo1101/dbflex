<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:24 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details to capture a pre-auth
 */
class CaptureRequest
{
    public $Payment;
    public $TransactionID;

    public function __construct()
    {
        $this->Payment = new Payment();
    }
}
