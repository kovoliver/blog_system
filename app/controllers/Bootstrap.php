<?php namespace Controllers;
use Models\StaticConn as StaticConn;
use Models\Articles as Articles;
use Models\SocialMedia as SocialMedia;
use Models\Header as Header;
use Models\Profile as Profile;
use Traits\urlTrait as urlTrait;
use Models\Seo as Seo;
use PDO;

class Bootstrap extends Articles {
    use urlTrait;
    public static function LoadHead() {
        $profile = Profile::GetProfileData();
        $baseUrl = self::BaseUrl();
        $seo = Seo::GetSeoData();
        include "common/head.php";
    }

    public static function LoadHeader() {
        $baseUrl = self::BaseUrl();
        $categories = self::GetCategories();
        $profile = Profile::GetProfileData();
        $socialMedia =  SocialMedia::GetSocialMedia();
        $extension = Header::GetHeader();
        include "common/header.php";
    }

    public static function LoadFooter() {
        $profile = Profile::GetProfileData();
        include "common/footer.php";
    }

    public static function LoadContent() {
        $baseUrl = self::BaseUrl();
        $urlArray = self::GetUrlArray();
        $articles = [];
        $article =  Articles::GetArticle();
        $nextPage = Articles::Pagination("next");
        $prevPage = Articles::Pagination("prev");
        $nextHide = Articles::HidePagi("next");
        $prevHide = Articles::HidePagi("prev");

        $file = isset($urlArray[0]) ? "views/" . htmlspecialchars($urlArray[0]) . ".php" : "views/cikkek.php";

        if($file == "views/cikkek.php") {
            $articles = self::GetArticles();
        }
        if(file_exists($file)) {
            include $file;
        }
    }
}