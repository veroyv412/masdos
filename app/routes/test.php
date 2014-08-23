<?php

$app->get('/test', function() use ($app) {


    //LOGIN
    /*$url = "https://www.secureinfossl.com/login/loginCheck";

    $fields = array(
        'user_name' => urlencode("dlieberman@learnit.com"),
        'user_password' => urlencode("host!@#$")
    );*/

    $url = 'https://www.secureinfossl.com/affiliateAdmin/affiliate_home/saveAffiliateInfo.html';

    $affiliate_fields = array(
        'affiliate_name' => "veronica nisenbaum",
        'affiliate_email' => "veroyv412@gmail.com   ",
        'affiliate_password' => "password",
        'affiliate_address1' => "123 easy street",
        'affiliate_address2' => "apt B",
        'affiliate_city' => "Argentina",
        'affiliate_state' => "BA",
        'affiliate_zip' => "125",
        'affiliate_country' => "AS",
        'affiliate_home_phone' => "5125551212",
    );

    $postResult = curlPost($url, $affiliate_fields);
    var_dump($postResult);


    //curl_close($ch);
});

/**
 * @param string $url
 * @param array $postFields
 */
function curlPost( $url, $postFields )
{
    $fields_string = "";
    foreach($postFields as $key => $value) {
        $fields_string .= $key.'='.$value.'&';
    }
    rtrim($fields_string, '&');

    $ch = curl_init();

    //open connection
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE); //to write necesssary cookie info
    //curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE); //to read necesssary cookie info
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //ignore SSL certs for now
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  $fields_string);
    curl_setopt ($ch, CURLOPT_COOKIE, 'ci_session: a:5:{s:10:"session_id";s:32:"1f883cb22771f9f0dd7603716eb76cf3";s:10:"ip_address";s:14:"190.245.225.64";s:10:"user_agent";s:50:"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:25.0) G";s:13:"last_activity";i:1391294147;s:10:"last_visit";i:0;}');
    curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);


    $postResult = array();
    $postResult['result'] = curl_exec($ch);
    $postResult['err'] = curl_errno ( $ch );
    $postResult['errmsg'] = curl_error ( $ch );
    $postResult['header'] = curl_getinfo ( $ch );
    $postResult['httpCode'] = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

    return $postResult;
}

function readCookie() {
    echo "cookie:<br>";
    $file = fopen(COOKIE_FILE, 'r');
    echo fread($file, 100000000);
    echo "<hr>";
    fclose($file);
}

