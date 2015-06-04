<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:17 PM
 */

namespace Libraries\eWAY;


/**
 * Base eWAY Request class
 */
abstract class Request
{
    public $Customer;

    public $ShippingAddress;
    public $Items;
    public $Options;

    public $Payment;

    /**
     * @var string The action to perform with this request (defaults to ProcessPayment)
     * One of: ProcessPayment, CreateTokenCustomer, ​UpdateTokenCustomer, TokenPayment, Authorise
     */
    public $Method;

    /**
     * @var string The type of transaction you’re performing. (defaults to Purchase)
     * One of: Purchase, MOTO, Recurring
     */
    public $TransactionType;

    /**
     * @var string The customer’s IP address. Defaults to $_SERVER["REMOTE_ADDR"]
     */
    public $CustomerIP;

    /**
     * @var string The identification name/number for the device or application
     * used to process the transaction.
     */
    public $DeviceID;

    /**
     * @var string The partner ID generated from a partner agreement with eWAY
     */
    public $PartnerID;

    public function __construct()
    {
        $this->Customer = new Customer();
        $this->ShippingAddress = new ShippingAddress();
        $this->Payment = new Payment();
        if (isset($_SERVER["REMOTE_ADDR"]) && !empty($_SERVER["REMOTE_ADDR"])) {
            $this->CustomerIP = $_SERVER["REMOTE_ADDR"];
        }
        $this->DeviceID = 'eWAY-php-1.2';
    }
}