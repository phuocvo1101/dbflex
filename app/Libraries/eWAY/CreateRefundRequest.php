<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:19 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details to complete a Refund
 */
class CreateRefundRequest
{
    public $Refund;
    public $Customer;

    public $ShippingAddress;
    public $Items;
    public $Options;

    public $CustomerIP;
    public $DeviceID;
    public $PartnerID;

    public function __construct()
    {
        $this->Refund = new Refund();
        $this->Customer = new RefundCustomer();
        $this->ShippingAddress = new ShippingAddress();
        if (isset($_SERVER["REMOTE_ADDR"]) && !empty($_SERVER["REMOTE_ADDR"])) {
            $this->CustomerIP = $_SERVER["REMOTE_ADDR"];
        }
        $this->DeviceID = 'eWAY-php-1.2';
    }
}
