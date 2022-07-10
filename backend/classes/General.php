<?php

class General{

    static function redirectHeader(){
        $serverUrl = self::getServerUrl();
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $serverUrl");
        header("Connection: close");
    }

    static function imageHeader(){
        header("Content-type: image/png");
        header('Content-Disposition: filename="map.png"');
    }

    static function destroySession(){
        setcookie("cookie", "",time()-3600,"/");
        session_destroy();
    }

    static function getServerUrl(){
        return $_SERVER["HTTP_HOST"];
    }
}