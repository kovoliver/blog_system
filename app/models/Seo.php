<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class Seo extends StaticConn {
    public static function GetSeoData() {
        $conn = self::StaticConnection();
        $stmt = $conn->query("SELECT * FROM seo");
        $stmt->execute();
        $rows = $stmt->fetch();
        self::KillConn($conn);
        return $rows;
    }
}