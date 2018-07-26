<?php namespace Controllers;
use Traits\urlTrait;
use Models\StaticConn as StaticConn;
use Models\Registration as Registration;
use Models\Profile as Profile;
use Models\PageData as PageData;
use Models\CSRFToken as CSRFToken;
use Models\Files as Files;
use Models\FirstStart as FirstStart;
use PDO;

class Bootstrap extends StaticConn {
    use urlTrait;
    
    public static function LoadHead() {
        $baseUrl = self::BaseUrl();
        include 'common/head.php';
    }

    public static function LoadHeader() {
        $baseUrl = self::BaseUrl();
        include 'common/header.php';
    }

    public static function CheckFirstStart() {
        $conn = self::StaticConnection();
        $stmt = $conn->query("SELECT * FROM login");
        if($stmt->rowCount() == 0) {
            return true;
        } else {
            return false;
        }
        self::KillConn($conn);
    }

    public static function LoadContent() {
        $urlArray = self::GetUrlArray();
        $urlArray[0] = isset($urlArray[0]) ? $urlArray[0] : "cikk";
        $file = isset($urlArray[0]) ? 'views/' . htmlspecialchars($urlArray[0]) . '.php' : 'views/cikk.php';
        $data = [];
        $tags = "";
        $category = [];
        $socialMedia = [];
        $seo = [];
        $registration;
        $passwordChangeMessage = "";
        $headerMessage = "";
        $blogDataMessage = "";
        if(isset($_POST["save_blog_data"])) {
            $blogDataMessage = Profile::ChangeBlogData();
        }
        if(isset($_POST["change_password"]) 
        && isset($_POST["password"]) 
        && isset($_POST["old_password"])) {
            $passwordChangeMessage = Profile::ChangePassword();
        }
        if(isset($_POST["change_cover"]) && isset($_FILES["cover"])) {
            $headerMessage = Files::ChangeHeader();
        }
        $token = CSRFToken::GenerateToken();
        if(self::CheckFirstStart()) {
            $file = "views/regisztracio.php";
            $registration = new Registration();
            if(isset($_POST["reg"])) {
                $message = $registration->SetRegistration();
                echo $message;
            }
            if(file_exists($file)) {
                include($file);
            } else {
                echo "<h1>Az első inditáshoz szükséges állomány nem található!</h1>";
            }
            return;
        }

        if(empty($urlArray[0]) || $urlArray[0] == "cikk") {
            $data = PageData::GetArticleData();
            $tags = PageData::GetTags();
            $category = PageData::GetCategory();
        }
        if($urlArray[0] == "kozossegi_media")
            $socialMedia = PageData::GetSocialMedia();
        if($urlArray[0] == "seo")
            $seo = PageData::GetSeo();
        if($urlArray[0] == "adatlap") 
            $blogData = Profile::GetBlogData();

        if(file_exists($file))
            include $file;
        else
            echo "<h1>404 A keresett oldal nem található!</h1>";

    }
}