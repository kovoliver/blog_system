<?php

    function GetLocalhostPath() {
        $localhostPath = "";
        if($_SERVER["HTTP_HOST"] == "localhost") {
            $pathArray = explode("/", $_SERVER["REQUEST_URI"]);
            $localhostPath = "/" . $pathArray[1] . "/";
        }
        return $localhostPath;
    }
    $localhostPath = GetLocalhostPath();

    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/Config.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/tUrl.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/StaticConn.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/Articles.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/Seo.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/SocialMedia.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/Header.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/Profile.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/controllers/Bootstrap.php';
    include $_SERVER['DOCUMENT_ROOT'] . $localhostPath.'app/models/FirstStart.php';