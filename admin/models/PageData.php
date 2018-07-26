<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class PageData extends StaticConn {
    public static function GetArticleData() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT content, title FROM articles WHERE article_id = ?");
        if(isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
            $stmt->execute([$_GET['article_id']]);
            $rows = $stmt->fetch();
            return $rows;
        }
        return [];
    }

    public static function GetTags() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT tag_name FROM tags WHERE article_id = ? ORDER BY tag_id ASC");
        $tags = "";
        if(isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
            $stmt->execute([$_GET['article_id']]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $counter = 0;
            foreach($rows as $row) {
                $tags .= $row["tag_name"];
                $counter++;
                if($counter != count($rows))
                    $tags .= ",";
            }
            self::KillConn($conn);
            return $tags;
        }
        self::KillConn($conn);
        return "";
    }

    public static function GetCategory() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT category_id FROM articles WHERE article_id = ?");
        if(isset($_GET["article_id"])) {
            $stmt->execute([$_GET["article_id"]]);
            $row = $stmt->fetch();
            return $row;
        }
        self::KillConn($conn);
        return [];
    }

    public static function GetSocialMedia() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT * FROM social_media");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::KillConn($conn);
        return $rows;
    }

    public static function GetSeo() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT * FROM seo");
        $stmt->execute();
        $rows = $stmt->fetch();
        self::KillConn($conn);
        return $rows;
    }
}