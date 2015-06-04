<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:23 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details of a Payment
 */
class Payment
{
    /**
     * @var int The amount of the transaction in the lowest denomination for the
     * currency (e.g. a $27.00 transaction would have a TotalAmount value of ‘2700’).
     *
     * The value of this field must be 0 for the CreateTokenCustomer and
     * UpdateTokenCustomer methods
     */
    public $TotalAmount;

    public $InvoiceNumber;
    public $InvoiceDescription;
    public $InvoiceReference;

    /**
     * @var string The 3 character code that represents the currency that this
     * transaction is to be processed in. Default is merchant's default currency.
     * e.g. AUD for Australian Dollar
     */
    public $CurrencyCode;
}