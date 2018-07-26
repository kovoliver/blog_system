<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

    function GetLocalhostPath() {
        $localhostPath = "";
        if($_SERVER["HTTP_HOST"] == "localhost") {
            $pathArray = explode("/", $_SERVER["REQUEST_URI"]);
            $localhostPath = "/" . $pathArray[1] . "/";
        }
        return $localhostPath;
    }
    $localhostPath = GetLocalhostPath();
    
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Config.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/tFormData.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/tUrl.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/tAccentedHandling.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/StaticConn.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/controllers/Bootstrap.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Conn.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Atricles.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/SocialMedia.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Seo.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Registration.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Login.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Files.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/CSRFToken.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/Profile.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'admin/models/PageData.php';