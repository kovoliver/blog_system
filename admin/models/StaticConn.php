<?php namespace Models;
use Models\Config as Config;
use PDO;

class StaticConn extends Config {
    public static function StaticConnection() {
        $config = self::GetConfigData();
        $conn = new PDO(
            "".$config->dbType.":
            host=".$config->host.";
            dbname=".$config->dbName.";
            charset=".$config->charset.";",
            $config->dbUser, $config->dbPass, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }

    public static function KillConn(&$conn) {
        $conn = null;
    }
}