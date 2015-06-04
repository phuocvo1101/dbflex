<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:18 PM
 */

namespace Libraries\eWAY;



/**
 * Contains details to create a Responsive Shared Page Redirect
 */
class CreateAccessCodesSharedRequest extends Request
{
    /**
     * @var string The URL that the shared page redirects to after a payment is
     * processed
     */
    public $RedirectUrl;

    /**
     * @var string The URL that the shared page redirects to if a customer
     * cancels the transaction
     */
    public $CancelUrl;

    /**
     *
     * @var string The URL of the merchant's logo to display on the shared page
     */
    public $LogoUrl;

    /**
     * @var string Short text description to be placed under the logo on the shared page
     */
    public $HeaderText;

    /**
     * @var bool When set to false, cardholders will be able to edit the
     * information on the shared page even if it’s sent through in the server
     * side reques
     */
    public $CustomerReadOnly;

    /**
     * @var string Language code determines the language that the shared page will be
     * displayed in. One of EN or ES
     */
    public $Language;

    /**
     *
     * @var string Set the theme of the Responsive Shared Page from 12
     * predetermined themes (default is Default)
     * One of: Default, Bootstrap, BootstrapAmelia, BootstrapCerulean, BootstrapCosmo,
     * BootstrapCyborg, BootstrapFlatly, BootstrapJournal, BootstrapReadable,
     * BootstrapSimplex, BootstrapSlate, BootstrapSpacelab, BootstrapUnited
     */
    public $CustomView;

    /**
     * @var bool Set whether the customers phone should be confirmed using Beagle Verify
     * (an SMS is sent to the customer's phone)
     */
    public $VerifyCustomerPhone;

    /**
     * @var bool Set whether the customers email should be confirmed using Beagle Verify
     */
    public $VerifyCustomerEmail;
}