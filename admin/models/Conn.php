<?php namespace Models;
use Models\Config as Config;
use PDO;

class Conn extends Config {
    protected $conn;
    
    function __construct() {
        $config = self::GetConfigData();

        try {
            $this->conn = new PDO(
                "".$config->dbType.":
                host=".$config->host.";
                dbname=".$config->dbName.";
                charset=".$config->charset.";",
                $config->dbUser, $config->dbPass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $ex) {
            die("A következő hiba lépett fel az adatbázishoz való csatlakozás során: " . $ex);
        }
    }

    function __destruct() {
        $this->conn = null;
    }
}