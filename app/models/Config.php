<?php namespace Models;

class Config {
    public static function GetConfigData() {
        $localhostPath = GetLocalhostPath();

        $file = $_SERVER["DOCUMENT_ROOT"] . "/".$localhostPath."/admin/config.json";
        $config = [];
        $connString = "";
        if(file_exists($file)) {
            $config = json_decode(file_get_contents($file));
        } else {
            die("A konfigurációs fájl nem elérhető!");
        }
        return $config;
    }
}