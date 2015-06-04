<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:18 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details to create a Transparent Redirect Access Code
 */
class CreateAccessCodeRequest extends Request
{
    /**
     * @var string The web address the customer is redirected to with the result
     * of the action
     */
    public $RedirectUrl;

    /**
     * @var bool Setting this to "True" will process a PayPal Checkout payment
     */
    public $CheckoutPayment;

    /**
     * @var string When CheckoutPayment is set to "True" you must specify a
     * CheckoutURL for the customer to be returned to after logging in to their
     * PayPal account
     */
    public $CheckoutURL;
}