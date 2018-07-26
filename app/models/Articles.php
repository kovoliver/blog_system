<?php namespace Models;
use Models\StaticConn as StaticConn;
use Traits\urlTrait as urlTrait;
use PDO;

class Articles extends StaticConn {
    use urlTrait;
    private static function GetCategoryId() {
        $urlArray = self::GetUrlArray();
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_url = ?");
        $stmt->execute([$urlArray[1]]);
        $row = $stmt->fetch();
        self::KillConn($conn);
        return $row["category_id"];
    }
    public static function MakeSqlSrting() {
        $urlArray = self::GetUrlArray();
        $sql = "";
        if(isset($_GET["tags"])) {
            $sql .= " AND EXISTS (SELECT * FROM tags 
            WHERE articles.article_id = tags.article_id 
            AND tags.tag_name = :tag_name
            OR articles.content LIKE :content
            OR articles.title LIKE :title)";
        }
        if(isset($urlArray[1]))
            $sql .= " AND category_id = :category_id";
        return $sql;
    }

    public static function GetArticles() {
        $urlArray = self::GetUrlArray();
        $sql = "SELECT * FROM articles WHERE 1 = 1";
        $sql .= self::MakeSqlSrting();
        if(isset($_GET["page"]) && is_numeric($_GET["page"]))
            $sql .= " ORDER BY create_date ASC LIMIT 10 OFFSET :offset";
        $offset = 0;
        
        $conn = self::StaticConnection();
        $stmt = $conn->prepare($sql);
        if(isset($_GET["page"]) && is_numeric($_GET["page"])) {
            $offset = ($_GET["page"] -1)*10;
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
        }
        if(isset($urlArray[1])) {
            $category_id = self::GetCategoryId();
            $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        }
        if(isset($_GET["tags"])) {
            $stmt->bindValue(":content", "%" . $_GET["tags"] . "%", PDO::PARAM_STR);
            $stmt->bindValue(":tag_name", $_GET["tags"], PDO::PARAM_STR);
            $stmt->bindValue(":title", "%" . $_GET["tags"] . "%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::KillConn($conn);
        return $rows;
    }

    public static function GetTags() {
        $conn = self::StaticConnection();
        $stmt = $conn->prepare("SELECT * FROM tags WHERE id = ?");
        self::KillConn($conn);
    }

    public static function MaxPage() {
        $urlArray = self::GetUrlArray();
        $conn = self::StaticConnection();
        $sql = "SELECT Count(article_id) as maxRows FROM articles WHERE 1 = 1";
        $sql .= self::MakeSqlSrting();
        $stmt = $conn->prepare($sql);
        if(isset($urlArray[1])) {
            $category_id = self::GetCategoryId();
            $stmt->bindValue(":category_id", $category_id, PDO::PARAM_INT);
        }
        if(isset($_GET["tags"])) {
            $stmt->bindValue(":content", "%" . $_GET["tags"] . "%", PDO::PARAM_STR);
            $stmt->bindValue(":tag_name", $_GET["tags"], PDO::PARAM_STR);
            $stmt->bindValue(":title", "%" . $_GET["tags"] . "%", PDO::PARAM_STR);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        self::KillConn($conn);
        return ceil($row["maxRows"]/10);
    }

    public static function Pagination($nextPrev) {
        $category = isset($_GET["category"]) ? "&category=" . $_GET["category"] : "";
        $tags = isset($_GET["tags"]) ? "&tags=" . $_GET["tags"] : "";
        if($nextPrev == "next") {
            $page = isset($_GET["page"]) ? $_GET["page"]+1 : 2;   
        } else {
            $page = isset($_GET["page"]) && $_GET["page"] > 0 ? $_GET["page"]-1 : 1;
        }
        return "?page=" . $page . $category . $tags;
    }

    public static function HidePagi($nextPrev) {
        if($nextPrev == "prev" && isset($_GET["page"]) && $_GET["page"] <= 1) {
            return "style='display:none;'";
        } else if($nextPrev == "prev" && !isset($_GET["page"])) {
            return "style=display:none;";
        } else if($nextPrev == "next" && isset($_GET["page"]) && $_GET["page"] >= self::MaxPage()) {
            return "style='display:none;'";
        }
        if(self::MaxPage() <= 1) {
            return "style='display:none;'";
        }
    }

    public static function GetArticle() {
        $urlArray = self::GetUrlArray();
        if(isset($urlArray[1])) {
            $conn = self::StaticConnection();
            $stmt = $conn->prepare("SELECT * FROM articles WHERE article_url = ?");
            $stmt->execute([$urlArray[1]]);
            $row = $stmt->fetch();
            self::KillConn($conn);
            return $row;
        }
        return [];
    }

    public static function GetCategories() {
        $conn = self::StaticConnection();
        $stmt =  $conn->query("SELECT * FROM categories");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::KillConn($conn);
        return $rows;
    }
}