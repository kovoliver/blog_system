<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class Profile extends StaticConn {
    public static function GetProfileData() {
        $conn = self::StaticConnection();
        $stmt = $conn->query("SELECT * FROM blog_data");
        $stmt->execute();
        $rows = $stmt->fetch();
        self::KillConn($conn);
        return $rows;
    }
}