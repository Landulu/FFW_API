<?php


class CurlManager
{

    private static $manager;

    private function __construct() {
    }

    public static function getManager(): CurlManager {
        if(!isset(self::$manager)) {
            self::$manager = new CurlManager();
        }
        return self::$manager;
    }

    public function curlGet($url, array $get = NULL, array $options = array()){


        $defaults = array(
            CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get? $get : []),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4
        );

        $ch = curl_init();
        curl_setopt_array($ch, ( $options + $defaults ));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        $httpCode= curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);


        return array('result'=>$result,'httpCode'=> $httpCode);
    }

    public function curlPost($url,  $post = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => $post
        );

        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        $httpCode= curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('result'=>$result,'httpCode'=> $httpCode);
    }

    public function curlPut($url,  $put = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => $put
        );



        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        $httpCode= curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return array('result'=>$result,'httpCode'=> $httpCode);
    }

}