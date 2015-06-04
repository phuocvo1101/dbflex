<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/4/2015
 * Time: 9:16 PM
 */

namespace Libraries\eWAY;


/**
 * Class containing translations of Response Codes
 */
class ResponseCode
{
    /**
     * @see https://eway.io/api-v3/#response-amp-error-codes
     * @var array response codes
     */
    private static $codes = array(
        'F7000' => 'Undefined Fraud Error',
        'V5000' => 'Undefined System',
        'A0000' => 'Undefined Approved',
        'A2000' => 'Transaction Approved',      // Successful
        'A2008' => 'Honour With Identification', // Successful
        'A2010' => 'Approved For Partial Amount', // Successful
        'A2011' => 'Approved VIP',              // Successful
        'A2016' => 'Approved Update Track 3',   // Successful
        'V6000' => 'Undefined Validation Error',
        'V6001' => 'Invalid Customer IP',
        'V6002' => 'Invalid DeviceID',
        'V6011' => 'Invalid Amount',
        'V6012' => 'Invalid Invoice Description',
        'V6013' => 'Invalid Invoice Number',
        'V6014' => 'Invalid Invoice Reference',
        'V6015' => 'Invalid Currency Code',
        'V6016' => 'Payment Required',
        'V6017' => 'Payment Currency Code Required',
        'V6018' => 'Unknown Payment Currency Code',
        'V6021' => 'Cardholder Name Required',
        'V6022' => 'Card Number Required',
        'V6023' => 'CVN Required',
        'V6031' => 'Invalid Card Number',
        'V6032' => 'Invalid CVN',
        'V6033' => 'Invalid Expiry Date',
        'V6034' => 'Invalid Issue Number',
        'V6035' => 'Invalid Start Date',
        'V6036' => 'Invalid Month',
        'V6037' => 'Invalid Year',
        'V6040' => 'Invalid Token Customer Id',
        'V6041' => 'Customer Required',
        'V6042' => 'Customer First Name Required',
        'V6043' => 'Customer Last Name Required',
        'V6044' => 'Customer Country Code Required',
        'V6045' => 'Customer Title Required',
        'V6046' => 'Token Customer ID Required',
        'V6047' => 'RedirectURL Required',
        'V6051' => 'Invalid Customer First Name',
        'V6052' => 'Invalid Customer Last Name',
        'V6053' => 'Invalid Customer Country Code',
        'V6054' => 'Invalid Customer Email',
        'V6055' => 'Invalid Customer Phone',
        'V6056' => 'Invalid Customer Mobile',
        'V6057' => 'Invalid Customer Fax',
        'V6058' => 'Invalid Customer Title',
        'V6059' => 'Redirect URL Invalid',
        'V6060' => 'Invalid TokenCustomerID',
        'V6061' => 'Invalid Customer Reference',
        'V6062' => 'Invalid Customer Company Name',
        'V6063' => 'Invalid Customer Job Description',
        'V6064' => 'Invalid Customer Street1',
        'V6065' => 'Invalid Customer Street2',
        'V6066' => 'Invalid Customer City',
        'V6067' => 'Invalid Customer State',
        'V6068' => 'Invalid Customer Postalcode',
        'V6069' => 'Invalid Customer Email',
        'V6070' => 'Invalid Customer Phone',
        'V6071' => 'Invalid Customer Mobile',
        'V6072' => 'Invalid Customer Comments',
        'V6073' => 'Invalid Customer Fax',
        'V6074' => 'Invalid Customer Url',
        'V6075' => 'Invalid ShippingAddress First Name',
        'V6076' => 'Invalid ShippingAddress Last Name',
        'V6077' => 'Invalid ShippingAddress Street1',
        'V6078' => 'Invalid ShippingAddress Street2',
        'V6079' => 'Invalid ShippingAddress City',
        'V6080' => 'Invalid ShippingAddress State',
        'V6081' => 'Invalid ShippingAddress PostalCode',
        'V6082' => 'Invalid ShippingAddress Email',
        'V6083' => 'Invalid ShippingAddress Phone',
        'V6084' => 'Invalid ShippingAddress Country',
        'V6091' => 'Unknown Country Code',
        'V6100' => 'Invalid Card Name',
        'V6101' => 'Invalid Card Expiry Month',
        'V6102' => 'Invalid Card Expiry Year',
        'V6103' => 'Invalid Card Start Month',
        'V6104' => 'Invalid Card Start Year',
        'V6105' => 'Invalid Card Issue Number',
        'V6106' => 'Invalid Card CVN',
        'V6107' => 'Invalid AccessCode',
        'V6108' => 'Invalid CustomerHostAddress',
        'V6109' => 'Invalid UserAgent',
        'V6110' => 'Invalid Card Number',
        'V6111' => 'Unauthorised API Access, Account Not PCI Certified',
        'V6112' => 'Redundant card details other than expiry year and month',
        'V6113' => 'Invalid transaction for refund',
        'V6114' => 'Gateway validation error',
        'V6115' => 'Invalid DirectRefundRequest, Transaction ID',
        'V6116' => 'Invalid card data on original TransactionID',
        'V6117' => 'Invalid CreateAccessCodeSharedRequest, FooterText',
        'V6118' => 'Invalid CreateAccessCodeSharedRequest, HeaderText',
        'V6119' => 'Invalid CreateAccessCodeSharedRequest, Language',
        'V6120' => 'Invalid CreateAccessCodeSharedRequest, LogoUrl',
        'V6121' => 'Invalid TransactionSearch, Filter Match Type',
        'V6122' => 'Invalid TransactionSearch, Non numeric Transaction ID',
        'V6123' => 'Invalid TransactionSearch,no TransactionID or AccessCode specified',
        'V6124' => 'Invalid Line Items. The line items have been provided however the totals do not match the TotalAmount field',
        'V6125' => 'Selected Payment Type not enabled',
        'V6126' => 'Invalid encrypted card number, decryption failed',
        'V6127' => 'Invalid encrypted cvn, decryption failed',
        'V6128' => 'Invalid Method for Payment Type',
        'V6129' => 'Transaction has not been authorised for Capture/Cancellation',
        'V6130' => 'Generic customer information error',
        'V6131' => 'Generic shipping information error',
        'V6132' => 'Transaction has already been completed or voided, operation not permitted',
        'V6133' => 'Checkout not available for Payment Type',
        'V6134' => 'Invalid Auth Transaction ID for Capture/Void',
        'V6135' => 'PayPal Error Processing Refund',
        'V6140' => 'Merchant account is suspended',
        'V6141' => 'Invalid PayPal account details or API signature',
        'V6142' => 'Authorise not available for Bank/Branch',
        'V6150' => 'Invalid Refund Amount',
        'V6151' => 'Refund amount greater than original transaction',
        'V6152' => 'Original transaction already refunded for total amount',
        'V6153' => 'Card type not support by merchant',
        'D4401' => 'Refer to Issuer',
        'D4402' => 'Refer to Issuer, special',
        'D4403' => 'No Merchant',
        'D4404' => 'Pick Up Card',
        'D4405' => 'Do Not Honour',
        'D4406' => 'Error',
        'D4407' => 'Pick Up Card, Special',
        'D4409' => 'Request In Progress',
        'D4412' => 'Invalid Transaction',
        'D4413' => 'Invalid Amount',
        'D4414' => 'Invalid Card Number',
        'D4415' => 'No Issuer',
        'D4419' => 'Re-enter Last Transaction',
        'D4421' => 'No Method Taken',
        'D4422' => 'Suspected Malfunction',
        'D4423' => 'Unacceptable Transaction Fee',
        'D4425' => 'Unable to Locate Record On File',
        'D4430' => 'Format Error',
        'D4431' => 'Bank Not Supported By Switch',
        'D4433' => 'Expired Card, Capture',
        'D4434' => 'Suspected Fraud, Retain Card',
        'D4435' => 'Card Acceptor, Contact Acquirer, Retain Card',
        'D4436' => 'Restricted Card, Retain Card',
        'D4437' => 'Contact Acquirer Security Department, Retain Card',
        'D4438' => 'PIN Tries Exceeded, Capture',
        'D4439' => 'No Credit Account',
        'D4440' => 'Function Not Supported',
        'D4441' => 'Lost Card',
        'D4442' => 'No Universal Account',
        'D4443' => 'Stolen Card',
        'D4444' => 'No Investment Account',
        'D4451' => 'Insufficient Funds',
        'D4452' => 'No Cheque Account',
        'D4453' => 'No Savings Account',
        'D4454' => 'Expired Card',
        'D4455' => 'Incorrect PIN',
        'D4456' => 'No Card Record',
        'D4457' => 'Function Not Permitted to Cardholder',
        'D4458' => 'Function Not Permitted to Terminal',
        'D4460' => 'Acceptor Contact Acquirer',
        'D4461' => 'Exceeds Withdrawal Limit',
        'D4462' => 'Restricted Card',
        'D4463' => 'Security Violation',
        'D4464' => 'Original Amount Incorrect',
        'D4466' => 'Acceptor Contact Acquirer, Security',
        'D4467' => 'Capture Card',
        'D4475' => 'PIN Tries Exceeded',
        'D4482' => 'CVV Validation Error',
        'D4490' => 'Cutoff In Progress',
        'D4491' => 'Card Issuer Unavailable',
        'D4492' => 'Unable To Route Transaction',
        'D4493' => 'Cannot Complete, Violation Of The Law',
        'D4494' => 'Duplicate Transaction',
        'D4496' => 'System Error',
        'D4497' => 'MasterPass Error Failed',
        'D4498' => 'PayPal Create Transaction Error Failed',
        'D4499' => 'Invalid Transaction for Auth/Void'
    );

    /**
     * Fetches the message associated with a Response Code
     *
     * @param string $code
     * @return string
     * @static
     */
    public static function getMessage($code)
    {
        if (isset(ResponseCode::$codes[$code])) {
            return ResponseCode::$codes[$code];
        } else {
            return $code;
        }
    }
}
