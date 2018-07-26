<?php namespace Traits;

trait urlTrait {
    public static function GetUrlArray() {
        $urlArray = isset($_GET['url']) ? explode('/', rtrim($_GET['url'])) : [];
        return $urlArray;
    }

    public static function BaseUrl() {
        $baseUrl = $_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1' ? 'http://' : 'https://'; 
        $baseUrl .= $_SERVER['HTTP_HOST'];
        if($_SERVER['HTTP_HOST'] == 'localhost')
            $baseUrl .= '/blog/admin';
        else 
            $baseUrl .= '/admin';

        return $baseUrl;
    }
}