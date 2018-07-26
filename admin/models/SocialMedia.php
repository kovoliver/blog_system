<?php namespace Models;
use Models\CSRFToken as CSRFToken;

class SocialMedia extends Conn {
    private $formData = [];
    function __construct() {
        $this->formData = $_POST["formData"];
        parent::__construct();
    }

    public function UpdateSocialMedia() {
        if(!CSRFToken::CheckToken($this->formData["token"]))
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        $stmt = $this->conn->prepare("UPDATE social_media 
        SET link = :link, is_on = :is_on 
        WHERE media_name = :media_name");
        try {
            $stmt->execute($this->formData);
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    function __destruct() {
        parent::__destruct();
    }
}