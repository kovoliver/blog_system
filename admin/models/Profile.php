<?php namespace Models;
use Models\CSRFToken as CSRFToken;
use Models\StaticConn as StaticConn;
use PDO;

class Profile extends StaticConn {
    
    public static function ChangePassword() {
        $conn = StaticConn::StaticConnection();
        $_POST["password"] = hash("sha512", $_POST["password"]);
        $_POST["old_password"] = hash("sha512", $_POST["old_password"]);
        if(!CSRFToken::CheckToken())
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";

        $checkPass = $conn->prepare("SELECT password FROM login WHERE user_id = 1 AND password = ?");
        $checkPass->execute([$_POST["old_password"]]);
        if($checkPass->rowCount() == 1) {
            $stmt = $conn->prepare("UPDATE login SET password = ? WHERE user_id = 1");
            try {
                $stmt->execute([$_POST["password"]]);
                return "Sikeres módosítás!";
            } catch(PDOException $ex) {
                return "Sikertelen módosítás!";
            }
        } else {
            return "Nem megfelelő jelszó!";
        }
        StaticConn::KillConn($conn);
    }

    public static function ChangeBlogData() {
        $conn = StaticConn::StaticConnection();
        $message = "";
        if(!CSRFToken::CheckToken())
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        unset($_POST["token"]);

        if(!empty($_POST[":title"]) && (!isset($_POST[":title"]) || strlen($_POST[":title"]) < 3)) {
            $message .= "<h3>Nem megfelelő cím formátum!</h3>";
        }
        if(!empty($_POST[":public_email"]) && (!isset($_POST[":public_email"]) || !filter_var($_POST[":public_email"], FILTER_VALIDATE_EMAIL))) {
            $message .= "<h3>Nem megfelelő email formátum!</h3>";
        }
        if(!empty($_POST[":public_phone"]) && (!isset($_POST[":public_phone"]) || !preg_match("/^[\d]{10,11}|[\d\+]{12}$/", $_POST[":public_phone"]))) {
            $message .= "<h3>Nem megfelelő telefonszám formátum!</h3>";
        }
        $_POST[":email_on"] = isset($_POST[":email_on"]) ? 1 : 0;
        $_POST[":phone_on"] = isset($_POST[":phone_on"]) ? 1 : 0;

        if(empty($message)) {
            unset($_POST["save_blog_data"]);
            $stmt = $conn->prepare("
                UPDATE blog_data SET 
                public_email = :public_email,
                email_on = :email_on,
                public_phone = :public_phone,
                phone_on = :phone_on,
                blog_title = :title,
                facebook_app_id = :facebook_app_id,
                share_this_link = :share_this_link
                WHERE id = 2
            ");
            try {
                $stmt->execute($_POST);
                return "Sikeres mentés!";
            } catch(PDOException $ex) {
                return "Meghatározhatatlan hiba lépett fel!";
            }
        }
        StaticConn::KillConn($conn);
        return $message;
    }

    public static function GetBlogData() {
        $conn = StaticConn::StaticConnection();
        $stmt = $conn->query("SELECT * FROM blog_data LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

}