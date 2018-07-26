<?php namespace Models;
use Models\StaticConn as StaticConn;
use PDO;

class FirstStart extends StaticConn {
    public static function CreateDatabase() {
        $config = self::GetConfigData();
        $conn = self::FirstConn();
        $stmt = $conn->prepare("SELECT COUNT(DISTINCT `table_name`) as countTables
        FROM `information_schema`.`columns` WHERE `table_schema` = '".$config->dbName."' ");
        $stmt->execute();
        $row = $stmt->fetch();
        if($row["countTables"] == 0) {
            /*$createDb = $conn->query("
                CREATE DATABASE IF NOT EXISTS
                `blogroot` DEFAULT 
                CHARACTER SET utf8;
            ");
            $createDb->execute();*/
            return true;
        }
        return false;
    }

    public static function SeoDefault() {
        $conn = self::StaticConnection();
        $seoDefault = $conn->query("INSERT INTO `seo`
        (`title`, `description`, 
        `schema_dcterms`, `DC_coverage`, 
        `DC_description`, `DC_format`, 
        `DC_identifier`, `DC_publisher`, 
        `DC_title`, `DC_type`, `og_image`) VALUES
        ('', '', 'http://purl.org/dc/terms/', '', '', 'text/html', '', '', '', 'Text', '');");
        self::KillConn($conn);
    }

    public static function SocialDefault() {
        $conn = self::StaticConnection();
        $socialDefault = $conn->query("INSERT INTO `social_media` (`media_name`, `link`, `is_on`) VALUES
        ('facebook', NULL, 0),
        ('twitter', NULL, 0),
        ('instagram', NULL, 0),
        ('youtube', NULL, 0),
        ('soundcloud', NULL, 0);");
        self::KillConn($conn);
    }

    public static function CoverDefault() {
        $conn = self::StaticConnection();
        $coverDefault = $conn->query("INSERT INTO `cover` (`extension`) VALUES
        (NULL);");
        self::KillConn($conn);
    }

    public static function BlogDataDefault() {
        $conn = self::StaticConnection();
        $coverDefault = $conn->query("INSERT INTO `blog_data` 
        (`public_email`, `email_on`, 
        `public_phone`, `phone_on`, 
        `blog_title`, `facebook_app_id`, 
        `share_this_link`) VALUES
        ('', 0, '', 0, '', '', '');");
        self::KillConn($conn);
    }

    public static function MakeTables() {
        $conn = self::StaticConnection();

        $articles = $conn->query("CREATE TABLE IF NOT EXISTS `articles` (
            `article_id` int(11) NOT NULL AUTO_INCREMENT,
            `category_id` int(11) NOT NULL,
            `title` varchar(255) NOT NULL,
            `article_url` varchar(255) NOT NULL,
            `content` text NOT NULL,
            `create_date` datetime NOT NULL,
            `modify_date` datetime DEFAULT NULL,
            PRIMARY KEY (`article_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;");

        //create categories table
        $categories = $conn->query("
            CREATE TABLE IF NOT EXISTS `categories` (
            `category_id` int(11) NOT NULL AUTO_INCREMENT,
            `category_name` varchar(255) NOT NULL,
            `category_url` varchar(255) NOT NULL,
            `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`category_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
        ");
        $categories->execute();
        
        //create cover table
        $cover = $conn->query("
        CREATE TABLE IF NOT EXISTS `cover` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `extension` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;");
        $cover->execute();

        $files = $conn->query("
        CREATE TABLE IF NOT EXISTS `files` (
          `file_id` int(11) NOT NULL AUTO_INCREMENT,
          `filename` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
          `file_type` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
          `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`file_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;");
        $files->execute();

        $login = $conn->query("
        CREATE TABLE IF NOT EXISTS `login` (
          `user_id` int(11) NOT NULL AUTO_INCREMENT,
          `email` varchar(255) NOT NULL,
          `first_name` varchar(255) NOT NULL,
          `last_name` varchar(255) NOT NULL,
          `password` varchar(255) NOT NULL,
          `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`user_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;");

        $seo = $conn->query("
        CREATE TABLE IF NOT EXISTS `seo` (
          `seo_id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) NOT NULL,
          `description` varchar(255) NOT NULL,
          `schema_dcterms` varchar(255) NOT NULL DEFAULT 'http://purl.org/dc/terms/',
          `DC_coverage` varchar(255) NOT NULL,
          `DC_description` varchar(255) NOT NULL,
          `DC_format` varchar(255) NOT NULL DEFAULT 'text/html',
          `DC_identifier` varchar(255) NOT NULL,
          `DC_publisher` varchar(255) NOT NULL,
          `DC_title` varchar(255) NOT NULL,
          `DC_type` varchar(255) NOT NULL DEFAULT 'Text',
          `og_image` varchar(255) NOT NULL,
          PRIMARY KEY (`seo_id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;");
        $seo->execute();

        $socialMedia = $conn->query("
        CREATE TABLE IF NOT EXISTS `social_media` (
          `social_id` int(11) NOT NULL AUTO_INCREMENT,
          `media_name` varchar(255) NOT NULL,
          `link` varchar(255) DEFAULT NULL,
          `is_on` tinyint(4) NOT NULL,
          PRIMARY KEY (`social_id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;");
        $socialMedia->execute();

        $tags = $conn->query("
        CREATE TABLE IF NOT EXISTS `tags` (
          `tag_id` int(11) NOT NULL AUTO_INCREMENT,
          `article_id` int(11) NOT NULL,
          `tag_name` varchar(255) NOT NULL,
          PRIMARY KEY (`tag_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;");
        $tags->execute();

        $profile = $conn->query("CREATE TABLE IF NOT EXISTS `blog_data` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `public_email` varchar(255) DEFAULT NULL,
            `email_on` tinyint(4) NOT NULL DEFAULT '0',
            `public_phone` varchar(255) DEFAULT NULL,
            `phone_on` tinyint(4) NOT NULL DEFAULT '0',
            `blog_title` varchar(255) NOT NULL DEFAULT 'A blog címe',
            `facebook_app_id` varchar(255) DEFAULT '',
            `share_this_link` varchar(255) DEFAULT '',
            PRIMARY KEY (`id`)
          ) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;");
          $profile->execute();

        self::KillConn($conn);
    }
}