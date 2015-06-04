<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:21 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details of Shipping Address
 */
class ShippingAddress
{
    public $FirstName;
    public $LastName;
    public $Street1;
    public $Street2;
    public $City;
    public $State;

    /**
     * @var string The customer’s country. This should be the two letter
     * ISO 3166-1 alpha-2 code in lower case.
     * e.g. au for Australia
     */
    public $Country;

    public $PostalCode;
    public $Email;
    public $Phone;

    /**
     * @var string The method used to ship the customer’s order
     * One of: Unknown, LowCost, DesignatedByCustomer, International, Military,
     * NextDay, StorePickup, TwoDayService, ThreeDayService, Other
     */
    public $ShippingMethod;
}
