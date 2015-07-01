<?php
require_once realpath(dirname(__FILE__)) . '/../app/start.php';

$api_key = 'wchj4anfb7y3wt5cvdzqeh99';
$pathCokie = realpath(dirname(__FILE__)) .'/../cookie.txt';
$tokenFile = realpath(dirname(__FILE__)) .'/../token.txt';
$redirectUrl = 'http://abitech.com.au';
$secret_key = 'XFzFdAC4smfRveeHq3eRkR3a';
/*$username='develop@abitech.com.au';
$password='C0mputers';*/
$username='develop@abitech.com.au';
$password='C0mputers';
$api_scope = 'CompanyFile';
$params=array(
    'client_id' => $api_key,
    'redirect_uri' => $redirectUrl,
    'client_secret' => $secret_key
);
$loginUrl = 'https://secure.myob.com/oauth2/Account/Login';
$clientAuth = new \MYOB\AccountRight\Client($api_key);
$objauth = $clientAuth->auth($params);
$urlAuth = $objauth->getAccessCodeUrl();
$strData = 'Username='.$username.'&Password='.$password.'&RememberMe=false';
$data = $strData;
$myobAuth = new \Libraries\MyobAuth();

$myobAuth->login($loginUrl,$data,$pathCokie);
$myHtml =$myobAuth->grab_page($urlAuth,$pathCokie);
$code = $myobAuth->getAuth($myHtml);

$api_access_code= urldecode($code);
$oauth_tokens = null;

if(!file_exists($tokenFile)) {
    $oauth_tokens = $myobAuth->getAccessToken($api_key, $secret_key, $redirectUrl, $api_access_code, $api_scope);

    if(!isset($oauth_tokens->access_token) && !isset($oauth_tokens->refresh_token)) {
        echo 'Can not get token'."\n";
        exit();
    }
    $handle = fopen($tokenFile, 'w') or die('Cannot open file:  '.$tokenFile);
    $data = $oauth_tokens->refresh_token;
    fwrite($handle, $data);
} else{
    $handle = fopen($tokenFile, 'r');
    $data = fread($handle,filesize($tokenFile));
    $oauth_tokens = $myobAuth->refreshAccessToken($api_key, $secret_key, $data);

    if(!isset($oauth_tokens->access_token) && !isset($oauth_tokens->refresh_token)) {
        $oauth_tokens = $myobAuth->getAccessToken($api_key, $secret_key, $redirectUrl, $api_access_code, $api_scope);
        if(!isset($oauth_tokens->access_token) && !isset($oauth_tokens->refresh_token)) {
            echo 'Can not get token'."\n";
            exit();
        }
    }

    $handle = fopen($tokenFile, 'w') or die('Cannot open file:  '.$tokenFile);
    $data = $oauth_tokens->refresh_token;
    fwrite($handle, $data);
}

$auth = 'Bearer '.$oauth_tokens->access_token;

$version = 'v2';
//$url = 'https://api.myob.com/accountright';
$base_url = 'https://api.myob.com/accountright/82f87034-6d7d-4777-b728-8bdaaf96a176';
//$url = $base_url.'/Contact/Customer';
//$url = $base_url.'/GeneralLedger/TaxCode';
$url = $base_url. '/GeneralLedger/Account';
//$url = $base_url.'/Sale/Invoice';
//$url = $base_url.'/Contact/Personal';
$usernametoken = 'Administrator';
$passwordtoken = '';
/*$data = array(
    'CompanyName' => 'Company Test',
    'LastName' => 'Quang',
    'FirstName' => 'Vo',
    'IsIndividual' => true,
    'Addresses' => array (
        'Location' => 1,
        'Street' => '48/13 28 Street',
        'City' => 'Ho Chi Minh'
    ),
    'UID' => '82f87034-6d7d-4777-b728-8bdaaf96a176'
);*/

$dataAccount = array(
    'Name' => 'Quang test',
    'DisplayID' => 'Q-1',
    'Classification' => 'Asset',
    'Type' => 'Bank',
    'Number' => 1,
    'TaxCode' => array(
        'UID' => 'd6dedb7b-8316-4427-a427-4d64964aa2c7'
    )
);

$dataTax = array(
    'Code' => 'QB2',
    'Description' => 'No ABN Withholding',
    'Type' => 'NoABN_TFN',
    'WithholdingCreditAccount' => array(
        'UID' => '63078b52-9f6c-4b60-b066-e882a07929dd'
    ),
    'WithholdingPayableAccount' => array(
        'UID' => '77a5560c-d96b-42f6-9586-c17a18cb91ff'
    )
);
$cftoken = base64_encode($usernametoken.':'.$passwordtoken);
echo 'Url:'.$url."\n";
$option = array(
    'headers' => array(
        'Authorization' => $auth,
        'x-myobapi-cftoken' => $cftoken,
        'x-myobapi-key' => $api_key,
        'x-myobapi-version' => $version
    )
);
//var_dump($option);die();
/*var_dump(json_encode($data));die();*/
$client = new GuzzleHttp\Client($option);
$response = $client->get($url);
/*try{

    $params = array(
        'content-type' => 'application/json',
        'body' => json_encode($dataAccount)
    );

    $response = $client->post($url,$params,array());

//var_dump($response);die();
} catch (Exception $e){
    //echo $e->getTraceAsString();die();
    echo $e->getMessage();
    if ($e->hasResponse()) {
        $exResponse = $e->getResponse();
        $stream = $exResponse->getBody(true);
        $content = $stream->getContents();
        $result = json_decode($content,true);
        var_dump($result);
    }
    die();
}*/


$stream = $response->getBody(true);
$content = $stream->getContents();
//$result = json_decode($content,true);
$arrResult = array(
    'Status' => $response->getStatusCode(),
    'Result' => $content
);
echo '<pre>'.print_r($arrResult,true).'</pre>';