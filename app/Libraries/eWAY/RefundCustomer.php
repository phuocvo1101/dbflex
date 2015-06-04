<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:20 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details of a Customer with card details (for Direct only)
 */
class RefundCustomer extends Customer
{
    public function __construct()
    {
        $this->CardDetails = new RefundCardDetails();
    }
}