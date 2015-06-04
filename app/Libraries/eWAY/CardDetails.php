<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:25 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details of a credit card
 */
class CardDetails
{
    public $Name;
    public $Number;
    public $ExpiryMonth;
    public $ExpiryYear;
    public $StartMonth;
    public $StartYear;
    public $IssueNumber;
    public $CVN;
}