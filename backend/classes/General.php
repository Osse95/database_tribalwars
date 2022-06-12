<?php

class General{

    static function redirectHeader(){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: https://diestaemmedb.de");
        header("Connection: close");
    }

    static function destroySession(){
        setcookie("cookie", "",time()-3600,"/");
        session_destroy();
    }

    static function getServerUrl(){
        return $_SERVER[HTTP_HOST];
    }
}