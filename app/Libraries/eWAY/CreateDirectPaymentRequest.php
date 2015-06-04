<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:18 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details to complete a Direct Payment
 */
class CreateDirectPaymentRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $this->Customer = new CardCustomer();
    }
}
