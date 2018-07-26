<?php namespace Models;
use Models\Conn as Conn;
use Traits\FormData as FormData;
use PDO;

class Registration extends Conn {
    use FormData;
    private $formData = [];
    function __construct() {
        if(isset($_POST)) {
            $this->formData = $_POST;
            unset($this->formData["reg"]);
        }
        parent::__construct();
    }

    protected function EscapeScript() {
        foreach($this->formData as $key=>$value) {
            $this->formData[$key] = htmlspecialchars($value);
        }
    }

    protected function CheckUserData() {
        $this->EscapeScript();
        $bool = true;
        $message = "";
        if(!filter_var($this->formData[":email"], FILTER_VALIDATE_EMAIL)) {
            $bool = false;
            $message .= "<h3>Az emailcím formátuma nem megfelelő!</h3>";
        }

        if(strlen($this->formData[":password"]) < 6) {
            $bool = false;
            $message .= "<h3>A jelszónak legalább hat karakteresnek kell lenie!</h3>";
        }

        if(strlen($this->formData[":first_name"]) < 3) {
            $bool = false;
            $message .= "<h3>A keresztnévnek legalább három karakteresnek kell lenie!</h3>";
        }

        if(strlen($this->formData[":last_name"]) < 3) {
            $bool = false;
            $message .= "<h3>A vezetéknévnek legalább három karakteresnek kell lenie!</h3>";
        }
        return [$bool, $message];
    }

    public function SetRegistration() {
        $messageAry = $this->CheckUserData();
        if(!$messageAry[0])
            return $messageAry[1];

        $this->formData[":password"] = hash("sha512", $this->formData[":password"]);
        print_r($this->formData);

        $stmt = $this->conn->prepare("INSERT INTO login 
        (email, first_name, last_name, password)
        VALUEs(:email, :first_name, :last_name, :password) ");
        try {   
            $stmt->execute($this->formData);
            header("location:cikk");
            return true;
        } catch(PDOException $ex) {
            return false;
        }
    }

    function __destruct() {
        parent::__destruct();
    }
}