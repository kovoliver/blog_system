<?php namespace Models;

class CSRFToken {
    public static function GenerateToken() {
        $_SESSION["token"] = base64_encode(openssl_random_pseudo_bytes(32));
        return $_SESSION["token"];
    }

    public static function CheckToken($token = "") {
        if(isset($_SESSION["token"]) 
        && isset($_POST["token"])
        && $_POST["token"] == $_SESSION["token"]
        && $token == "") {
            unset($_SESSION["token"]);
            unset($_POST["token"]);
            return true;
        } else if(isset($_SESSION["token"]) && $token == $_SESSION["token"]) {
            unset($_SESSION["token"]);
            unset($token);
            return true;
        }
        return false;
    }
}