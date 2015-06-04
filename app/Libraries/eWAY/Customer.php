<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:19 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details of a Customer
 */
class Customer
{
    /**
     * @var string An eWAY-issued ID that represents the Token customer to be
     * loaded for this action
     */
    public $TokenCustomerID;

    /**
     * @var string The merchant’s reference for this customer
     */
    public $Reference;

    /**
     *
     * @var string The customer’s title, empty string allowed
     * One of: Mr., Ms., Mrs., Miss, Dr., Sir., Prof.
     */
    public $Title;

    public $FirstName;
    public $LastName;
    public $CompanyName;
    public $JobDescription;
    public $Street1;
    public $Street2;
    public $City;
    public $State;
    public $PostalCode;

    /**
     * @var string The customer’s country. This should be the two letter
     * ISO 3166-1 alpha-2 code in lower case.
     * e.g. au for Australia
     */
    public $Country;

    public $Email;
    public $Phone;
    public $Mobile;
    public $Comments;
    public $Fax;
    public $Url;
}
