<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class SocialMedia extends StaticConn {
    public static function GetSocialMedia() {
        $conn = self::StaticConnection();
        $stmt = $conn->query("SELECT * FROM social_media WHERE is_on = 1");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
        self::KillConn($conn);
    }
}