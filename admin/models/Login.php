<?php namespace Models;
use Models\Conn as Conn;
use Traits\FormData as FormData;
use Traits\urlTrait as urlTrait;
use Models\CSRFToken as CSRFToken;
use PDO;

class Login extends Conn {
    use urlTrait;
    function __construct() {
        if(isset($_POST)) {
            $this->formData = $_POST;
            unset($this->formData["login"]);
        }
        parent::__construct();
    }

    public function CheckPermission() {
        $baseUrl = $this->BaseUrl();
        $url = $this->GetUrlArray();
        if(!isset($_COOKIE["rand"]) && $url[0] != "bejelentkezes") {
            header("location:" . $baseUrl . "/bejelentkezes");
        }
    }

    public function LoginFunc() {
        if(!CSRFToken::CheckToken())
            return "<h1>TÁÁÁMADÁÁÁÁÁS!!!!!</h1>";
        
        unset($this->formData["token"]);
        $this->formData[":password"] = hash("sha512", $this->formData[":password"]);
        $stmt = $this->conn->prepare("SELECT * FROM login WHERE email = :email AND password = :password");
        $stmt->execute($this->formData);
        $userData = $stmt->fetch();
        $baseUrl = $this->BaseUrl();
        if($stmt->rowCount() == 1) {
            setcookie("rand", random_int(100000000, 999999999), time() + 86400, "/", "", null, true);
            setcookie("firstName", $userData["first_name"], time() + 86400);
            header("location:".$baseUrl);
        }
    }

    public function Logout() {
        $baseUrl = $this->BaseUrl();
        if(isset($_GET["logout"])) {
            setcookie("rand", random_int(100000000, 999999999), time() - 86400, "/", "", null, true);
            setcookie("firstName", "", time() - 86400);
            header("location:".$baseUrl);
        }
    }

    function __destruct() {
        parent::__destruct();
    }
}