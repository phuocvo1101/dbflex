<?php
/**
 * A PHP eWAY Rapid API library implementation.
 * This class is an example of how to connect to eWAY's Rapid API.
 *
 * Requires PHP 5.3 or greater with the cURL extension
 *
 * @see https://eway.io/api-v3/
 * @version 1.2
 * @package eWAY
 * @author eWAY
 * @copyright (c) 2015, Web Active Corporation Pty Ltd
 */

namespace Libraries\eWAY;

/**
 * eWAY Rapid 3.1 Library
 *
 * Check examples for usage
 *
 * @package eWAY
 */
class RapidAPI
{

    /**
     * @var string the eWAY endpoint
     */
    private $url;

    /**
     * @var bool true if using eWAY sandbox
     */
    private $sandbox;

    /**
     * @var string the eWAY API key
     */
    private $apiKey;

    /**
     * @var string the eWAY API password
     */
    private $apiPassword;

    /**
     * @var bool true to turn off cURL SSL_VERIFYPEER for testing
     * NOTE: only available on sandbox
     */
    private $disableSslVerify;

    /**
     * @var string raw last request sent to eWAY
     */
    private $lastRequest;

    /**
     * @var string raw last response from eWAY
     */
    private $lastResponse;

    /**
     * @var string last URL connected to
     */
    private $lastUrl;


    /**
     * RapidAPI constructor
     *
     * @param string $apiKey your eWAY Rapid API Key
     * @param string $apiPassword your eWAY Rapid API Password
     * @param array $params set options for connecting to eWAY
     *      $params['sandbox'] to true to use the sandbox for testing
     *      $params['disable_ssl_verification'] to true to disable SSL verification in sandbox
     */
    public function __construct($apiKey, $apiPassword, $params = array())
    {
        if (strlen($apiKey) === 0 || strlen($apiPassword) === 0) {
            die("Username and Password are required");
        }

        $this->apiKey = $apiKey;
        $this->apiPassword = $apiPassword;
        $this->url = 'https://api.ewaypayments.com/';
        $this->sandbox = false;

        if (count($params)) {
            if (isset($params['sandbox']) && $params['sandbox']) {
                $this->url = 'https://api.sandbox.ewaypayments.com/';
                $this->sandbox = true;
            }
            if (isset($params['disable_ssl_verification'])
                    && $params['disable_ssl_verification']
                    && $this->sandbox == true) {
                $this->disableSslVerify = true;
            }
        }
    }

    /**
     * Create a request for a Transparent Redirect Access Code
     *
     * @see https://eway.io/api-v3/#transparent-redirect
     * @param eWAY\CreateAccessCodeRequest $request
     * @return object decoded response from eWAY
     */
    public function CreateAccessCode($request)
    {
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("AccessCodes", $jsonRequest);
        return $response;
    }

    /**
     * Create an AccessCode & Redirect URL for a Responsive Shared Page payment
     *
     * @see https://eway.io/api-v3/#responsive-shared-page
     * @param eWAY\CreateAccessCodesSharedRequest $request
     * @return object decoded response from eWAY
     */
    public function CreateAccessCodesShared($request)
    {
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("AccessCodesShared", $jsonRequest);
        return $response;
    }

    /**
     * Get the result from an AccessCode after a customer has completed
     * a transaction with either Responsive Shared or Transparent Redirect.
     *
     * @param eWAY\GetAccessCodeResultRequest|string $request either a GetAccessCodeResultRequest
     *  containing the access code or the access code itself.
     * @return object decoded response from eWAY
     */
    public function GetAccessCodeResult($request)
    {
        // Fallback on using the GET variable (old behaviour)
        if ((empty($request)
                || (is_a($request, 'eWAY\GetAccessCodeResultRequest')
                && empty($request->AccessCode)))
                && isset($_GET['AccessCode'])) {
            $request = $_GET['AccessCode'];
        }
        if (empty($request)
                && !isset($request->AccessCode)
                && empty($request->AccessCode)) {
            die('No access code provided!');
        }
        // Legacy method
        if (is_a($request, 'eWAY\GetAccessCodeResultRequest')) {
            $response = $this->PostToRapidAPI("AccessCode/" . $request->AccessCode, '', false);
        } else {
            $response = $this->PostToRapidAPI("AccessCode/" . $request, '', false);
        }
        return $response;
    }

    /**
     * Perform a Direct Payment
     *
     * Note: Before being able to send credit card data via the direct API, eWAY
     * must enable it on the account. To be enabled on a live account eWAY must
     * receive proof that the environment is PCI-DSS compliant or use Client
     * Side Encryption
     *
     * @see https://eway.io/api-v3/#direct-connection
     * @param eWAY\CreateDirectPaymentRequest $request
     * @return object decoded response from eWAY
     */
    public function DirectPayment($request)
    {
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("Transaction", $jsonRequest);
        return $response;
    }

    /**
     * Performs a refund
     * Note: Before accessing the direct refund API you must add the Refund
     *  ability to your API user role.
     *
     * @see https://eway.io/api-v3/#refunds
     * @param eWAY\CreateRefundRequest $request
     * @return object decoded response from eWAY
     */
    public function Refund($request)
    {
        $transactionID = $request->Refund->TransactionID;
        if (empty($transactionID)) {
            die("Refund transaction ID missing");
        }
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("Transaction/$transactionID/Refund", $jsonRequest);
        return $response;
    }

    /**
     * Queries a transaction using either the Transaction ID or Access Code
     *
     * @see https://eway.io/api-v3/#transaction-query
     * @param string $request access code or transaction ID
     * @return object decoded response from eWAY
     */
    public function TransactionQuery($request)
    {
        if (empty($request)) {
            die('No Transaction ID or Access Code provided!');
        }
        $response = $this->PostToRapidAPI("Transaction/" . $request, '', false);

        return $response;
    }

    /**
     * Captures a pre-auth
     *
     * @see https://eway.io/api-v3/#capture-a-payment
     * @param eWAY\CaptureRequest $request
     * @return object decoded response from eWAY
     */
    public function CapturePayment($request)
    {
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("CapturePayment", $jsonRequest);
        return $response;
    }

    /**
     * Cancels a pre-auth
     *
     * @see https://eway.io/api-v3/#cancel-an-authorisation
     * @param eWAY\CancelRequest $request
     * @return object decoded response from eWAY
     */
    public function CancelAuthorisation($request)
    {
        $jsonRequest = $this->fixObjtoJSON($request);
        $response = $this->PostToRapidAPI("CancelAuthorisation", $jsonRequest);
        return $response;
    }

    /**
     * Fetches the message associated with a Response Code
     *
     * @param string $code
     * @return string
     */
    public function getMessage($code)
    {
        return ResponseCode::getMessage($code);
    }

    /**
     * Formats the request into JSON
     *
     * @param object $request
     * @return string JSON encoded string
     */
    private function fixObjtoJSON($request)
    {
        // Nest options correctly
        if (isset($request->Options) && count($request->Options->Option)) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Options->Option as $Option) {
                $tempClass->Options[$i] = $Option;
                $i++;
            }
            $request->Options = $tempClass->Options;
        }
        
        // Format and nest LineItems correctly
        if (isset($request->Items) && count($request->Items->LineItem)) {
            $i = 0;
            $tempClass = new \stdClass();
            foreach ($request->Items->LineItem as $LineItem) {
                // must be strings
                if (isset($LineItem->Quantity)) {
                    $LineItem->Quantity = (string)($LineItem->Quantity);
                }
                if (isset($LineItem->UnitCost)) {
                    $LineItem->UnitCost = strval($LineItem->UnitCost);
                }
                if (isset($LineItem->Tax)) {
                    $LineItem->Tax = strval($LineItem->Tax);
                }
                if (isset($LineItem->Total)) {
                    $LineItem->Total = strval($LineItem->Total);
                }
                $tempClass->Items[$i] = $LineItem;
                $i++;
            }
            $request->Items = $tempClass->Items;
        }

        // fix blank issue
        if (isset($request->RedirectUrl)) {
            $request->RedirectUrl = str_replace(' ', '%20', $request->RedirectUrl);
        }
        if (isset($request->CancelUrl)) {
            $request->CancelUrl = str_replace(' ', '%20', $request->CancelUrl);
        }

        $jsonRequest = json_encode($request);

        return $jsonRequest;
    }

    /**
     * A function for doing a Curl GET/POST
     *
     * This will die in event of an error!
     *
     * @param string $path the path for this request
     * @param sring $request JSON encoded request body
     * @param boolean $isPost set to false to perform a GET
     * @return object response from eWAY
     */
    private function PostToRapidAPI($path, $request, $isPost = true)
    {
        $this->lastRequest = $request;
        $this->lastResponse = '';

        $url = $this->url . $path;
        $ch = curl_init($url);
        $this->lastUrl = $url;

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'User-Agent: eWAY-PHP-1.2'
        ));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":" . $this->apiPassword);
        if ($isPost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if ($this->disableSslVerify) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        // Ucomment for CURL debugging
        //curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);

        $this->lastResponse = $response;

        if (curl_errno($ch) != CURLE_OK) {
            echo "<h2>Connection Error: " . curl_error($ch) . " URL: $url</h2><pre>";
            die();
        } else {
            $info = curl_getinfo($ch);
            if ($info['http_code'] == 401 || $info['http_code'] == 404 || $info['http_code'] == 403) {
                $__is_in_sandbox = $this->sandbox ? ' (Sandbox)' : ' (Live)';
                echo "<h2>Please check the API Key and Password $__is_in_sandbox</h2><pre>";
                die();
            }

            curl_close($ch);
            $decode = json_decode($response);
            if ($decode === null) {
                die("Error decoding response from eWAY");
            }

            return $decode;
        }
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setApiPassword($password)
    {
        $this->apiPassword = $password;
    }

    public function setSandbox($sandbox)
    {
        $this->sandbox = $sandbox;
    }

    public function setDisableSslVerify($disableSslVerify)
    {
        $this->disableSslVerify = $disableSslVerify;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    public function getLastUrl()
    {
        return $this->lastUrl;
    }
}
























