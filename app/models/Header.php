<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class Header extends StaticConn {
    public static function GetHeader() {
        $conn = self::StaticConnection();
        $stmt = $conn->query("SELECT extension FROM cover LIMIT 1");
        $row = $stmt->fetch();
        self::KillConn($conn);
        return $row;
    }
}