<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:24 PM
 */

namespace Libraries\eWAY;


/**
 * Contains details to request the result of an Access Code
 * GetAccessCodeResult can now be called with just the Access Code.
 * @deprecated since version 1.1
 */
class GetAccessCodeResultRequest
{
    public $AccessCode;

    public function __construct($accessCode = '')
    {
        $this->AccessCode = $accessCode;
    }
}
