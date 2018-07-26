<?php namespace Models;
use Traits\FormData as FormData;
use Models\CSRFToken as CSRFToken;
use Traits\AccentedHandling as AccentedHandling;
use PDO;

class Atricles extends Conn {
    use FormData;
    use AccentedHandling;
    protected $formData;
    function __construct() {
        if(isset($_POST['formData']))
            $this->formData = $this->FormDataAssoc($_POST['formData']);
        parent::__construct();
    }

    public function CheckExists($attribute, $tableName, $value) {
        $stmt = $this->conn->prepare("SELECT " . $attribute . " FROM " . $tableName . " WHERE " . $attribute . " = " . "? ");
        $stmt->execute([$value]);
        return $stmt->rowCount();
    }

    public function CheckUpdateExists($attribute, $tableName, $value, $idName, $id) {
        $stmt = $this->conn->prepare("SELECT " . $attribute . " FROM " . $tableName . " WHERE " . $attribute . " = " . "? AND ".$idName." != ?");
        $stmt->execute([$value, $id]);
        return $stmt->rowCount();
    }

    public function SetCategory() {
        $this->formData[":category_url"] = $this->RemoveAccented($this->formData[":category_name"]);
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        if(!isset($this->formData[":category_name"]))
            return false;
        $rowCount = $this->CheckExists("category_name", "categories", $this->formData[":category_name"]);
        if($rowCount == 0) {
            $stmt = $this->conn->prepare("INSERT INTO categories (category_name, category_url) VALUES(:category_name, :category_url)");
            try {
                $stmt->execute($this->formData);
                return true;
            } catch(PDOException $ex) {
                return false;
            }
        } else {
            return "exists";
        }
    }

    public function UpdateCategory() {
        $this->formData[":category_url"] = $this->RemoveAccented($this->formData[":category_name"]);
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        if(!isset($this->formData[":category_name"]))
            return false;
        
        $rowCount = $this->CheckUpdateExists("category_name", "categories", $this->formData[":category_name"], "category_id", $this->formData[":category_id"]);
        $stmt = $this->conn->prepare("UPDATE categories SET category_name = :category_name, category_url = :category_url WHERE category_id = :category_id");
        if($rowCount == 0) {
            try {
                $stmt->execute($this->formData);
                return true;
            } catch(PDOException $ex) {
                return false;
            }
        } else {
            echo "exists";
        }
    }

    public function DeleteCategory() {
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        if(!isset($this->formData[":category_id"]))
            return false;
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE category_id = :category_id");
        $article = $this->conn->prepare("UPDATE articles SET category_id = ? WHERE category_id = ?");
        $article->execute([-1, $this->formData[":category_id"]]);
        try {
            $stmt->execute($this->formData);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    public function DeleteArticle() {
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        if(!isset($this->formData[":article_id"]))
            return false;
        $stmt = $this->conn->prepare("DELETE FROM articles WHERE article_id = :article_id");
        try {
            $stmt->execute($this->formData);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    public function DeleteTags() {
        $stmt = $this->conn->prepare("DELETE FROM tags WHERE article_id = ?");
        $stmt->execute([$this->formData[":article_id"]]);
    }

    public function SetTags($tags, $article_id) {
        $tags = explode(",", $tags);
        $check = $this->conn->prepare("SELECT * FROM tags WHERE article_id = ? AND tag_name = ?");
        $tagStmt = $this->conn->prepare("INSERT INTO tags (article_id, tag_name) VALUES(?, ?)");
        foreach($tags as $tag) {
            if(!empty($tag)) {
                $check->execute([$article_id, $tag]);
                if($check->rowCount() == 0) {
                    $tagStmt->execute([$article_id, $tag]);
                }
            }
        }
    }

    public function SetAtricle() {
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        $rowCount = $this->CheckExists("title", "articles", "title", $this->formData[':title']);
        if($rowCount == 0 && 
        isset($this->formData[":title"]) 
        && isset($this->formData[":tags"]) 
        && isset($this->formData[":category"])
        && isset($this->formData[":content"])) {
            $this->formData[":article_url"] = $this->RemoveAccented($this->formData[":title"]);
            try {
                $this->formData[":create_date"] = date("Y-m-d H:i:s");
                $stmt = $this->conn->prepare("INSERT INTO articles 
                (title, article_url, category_id, content, create_date) 
                VALUES(:title, :article_url, :category, :content, :create_date)");
                $tags = $this->formData[":tags"];
                unset($this->formData[":tags"]);
                $stmt->execute($this->formData);
                $lastInsertId = $this->conn->lastInsertId();
                $this->setTags($tags, $lastInsertId);
                return $lastInsertId;
            } catch(PDOException $ex) {
                return false;
            }
        } else {
            return "exists";
        }
    }

    public function UpdateArticle() {
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        $rowCount = $this->CheckUpdateExists("title", "articles", $this->formData[':title'], "article_id", $this->formData[":article_id"]);
        if($rowCount == 0 && isset($this->formData[":title"]) 
        && isset($this->formData[":content"]) 
        && isset($this->formData[":category"])
        && isset($this->formData[":tags"])
        && isset($this->formData[":article_id"])) {
            $this->formData[":article_url"] = $this->RemoveAccented($this->formData[":title"]);
            try {
                $this->formData[":modify_date"] = date("Y-m-d H:i:s");
                $stmt = $this->conn->prepare("UPDATE articles SET 
                category_id = :category,
                title = :title,
                article_url = :article_url,
                content = :content,
                modify_date = :modify_date
                WHERE article_id = :article_id");
                $tags = $this->formData[":tags"];
                unset($this->formData[":tags"]);
                $stmt->execute($this->formData);
                $this->DeleteTags();
                $this->setTags($tags, $this->formData[":article_id"]);
                return $this->formData[":article_id"];
            } catch(PDOException $ex) {
                return false;
            }
        } else {
            return "exists";
        }
    }

    public function TableJson($tableName, $where = "") {
        $stmt = $this->conn->query("SELECT * FROM " . $tableName . $where);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    private function MakePaginationSql($limit = false) {
        $sql = "";
        if(isset($this->formData[":title"]) && $this->formData[":title"] !== "") {
            $this->formData[":title"] = $this->formData[":title"] . "%";
            $sql .= " AND title LIKE :title";
        } else {
            unset($this->formData[":title"]);
        }

        if(isset($this->formData[":date_from"]) && $this->formData[":date_from"] != "") {
            $sql .= " AND create_date >= :date_from";
        } else {
            unset($this->formData[":date_from"]);
        }

        if(isset($this->formData[":date_to"]) && $this->formData[":date_to"] !== "") {
            $sql .= " AND create_date <= :date_to";
        } else {
            unset($this->formData[":date_to"]);
        }
        if($limit === true)
            return $sql;
        
        if(isset($this->formData[":page"]) && $this->formData[":page"] !== "") {
            $this->formData[":page"] = ($this->formData[":page"]-1) * 5;
            $sql .= " LIMIT 5 OFFSET :page";
        } else {
            $sql .= " LIMIT 5 OFFSET 0";
            unset($this->formData[":page"]);
        }
        return $sql;
    }

    public function GetMaxPage() {
        $sql = "SELECT COUNT(article_id) as maxRows FROM articles WHERE 1 = 1";
        $sql .= $this->MakePaginationSql(true);

        $stmt = $this->conn->prepare($sql);
        if(isset($this->formData[":title"]))
            $stmt->bindValue(':title', urldecode($this->formData[":title"]), PDO::PARAM_STR);
        if(isset($this->formData[":date_from"]))
            $stmt->bindValue(':date_from', urldecode($this->formData[":date_from"]), PDO::PARAM_STR);
        if(isset($this->formData[":date_to"]))
            $stmt->bindValue(':date_to', urldecode($this->formData[":date_to"]), PDO::PARAM_STR);

        $stmt->execute();
        
        $rows = $stmt->fetch();
        return $rows["maxRows"];
    }

    public function Pagination() {
        $sql = "SELECT * FROM articles WHERE 1 = 1";
        $sql .= $this->MakePaginationSql();
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':page', (int) $this->formData[":page"], PDO::PARAM_INT);
        if(isset($this->formData[":title"]))
            $stmt->bindValue(':title', urldecode($this->formData[":title"]), PDO::PARAM_STR);
        if(isset($this->formData[":date_from"]))
            $stmt->bindValue(':date_from', urldecode($this->formData[":date_from"]), PDO::PARAM_STR);
        if(isset($this->formData[":date_to"]))
            $stmt->bindValue(':date_to', urldecode($this->formData[":date_to"]), PDO::PARAM_STR);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($rows);
    }

    function __destruct() {
        parent::__destruct();
    }
}