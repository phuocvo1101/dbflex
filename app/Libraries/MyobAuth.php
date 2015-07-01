<?php
/**
 * Created by PhpStorm.
 * User: Tam Tran
 * Date: 6/16/2015
 * Time: 11:29 PM
 */

namespace Libraries;


class MyobAuth {
    // public function to get an access token
    public function getAccessToken($api_key, $api_secret, $redirect_url, $access_code, $scope) {


        // build up the params
        $params = array(
            'client_id'				=>	$api_key,
            'client_secret'			=>	$api_secret,
            'scope'					=>	$scope,
            'code'					=>	$access_code,
            'redirect_uri'			=>	$redirect_url,
            'grant_type'			=>	'authorization_code', // authorization_code -> gives you an access token
        ); // end params array */

        $params = http_build_query($params); // will urlencode data
        return( $this->getToken($params) );

    }

    // public function to refresh an access token
    public function refreshAccessToken($api_key, $api_secret, $refresh_token) {
        // use the getAccessToken function
        $params = array(
            'client_id'				=>	$api_key,
            'client_secret'			=>	$api_secret,
            'refresh_token'			=>	$refresh_token,
            'grant_type'			=>	'refresh_token', // refresh_token -> refreshes your access token
        ); // end params array */

        $params = http_build_query($params);

        return( $this->getToken($params) );
    }

    // private function for token calls
    private function getToken($params) {

        //echo $params;
        $response = $this->getURL('https://secure.myob.com/oauth2/v1/authorize', $params);

        $response_json = json_decode( $response );

        // ***********************
        //
        //  TODO: ERROR CHECKING
        //
        // **********************

        // if no errors update the tokens
        return($response_json);
    }

    // private function for CURL
    private function getURL($url, $params, $headers=null) {

        $session = curl_init($url);
        // do we have headers? set them
        if( isset($headers) ) {
            curl_setopt($session, CURLOPT_HTTPHEADER, $headers);
        }
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        // setup the authentication
        //curl_setopt($session, CURLOPT_USERPWD, $_SESSION['username'] . ":" . $_SESSION['password']);
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);



        $response = curl_exec($session);
        curl_close($session);
        //var_dump($response);
        return($response);
    }

public function login($url,$data,$pathCokie){
        $fp = fopen($pathCokie, "w");
        fclose($fp);
        $login = curl_init();
        curl_setopt($login, CURLOPT_COOKIEJAR, "cookie.txt");
        curl_setopt($login, CURLOPT_COOKIEFILE, "cookie.txt");
        curl_setopt($login, CURLOPT_TIMEOUT, 40000);
        curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($login, CURLOPT_URL, $url);
        curl_setopt($login, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
        curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($login, CURLOPT_POST, TRUE);
        curl_setopt($login, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec ($login);
        ob_end_clean();
        curl_close ($login);
        unset($login);
    }

public function grab_page($site,$pathCokie){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $pathCokie);
        curl_setopt($ch, CURLOPT_URL, $site);
        ob_start();
        return curl_exec ($ch);
        ob_end_clean();
        curl_close ($ch);
    }

public function post_data($site,$data,$pathCokie){
        $datapost = curl_init();
        $headers = array("Expect:");
        curl_setopt($datapost, CURLOPT_URL, $site);
        curl_setopt($datapost, CURLOPT_TIMEOUT, 40000);
        curl_setopt($datapost, CURLOPT_HEADER, TRUE);
        curl_setopt($datapost, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($datapost, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($datapost, CURLOPT_POST, TRUE);
        curl_setopt($datapost, CURLOPT_POSTFIELDS, $data);
        curl_setopt($datapost, CURLOPT_COOKIEFILE, $pathCokie);
        ob_start();
        return curl_exec ($datapost);
        ob_end_clean();
        curl_close ($datapost);
        unset($datapost);
    }

    public function getAuth($myHtml)
    {
        $xml = simplexml_load_string($myHtml);
        $list = $xml->xpath("//@href");

        $preparedUrls = array();
        $code ='';
        foreach($list as $item) {
            $item = parse_url($item);
            $code = str_replace('code=','',$item['query']);
            break;
        }
        return $code;
    }
} 