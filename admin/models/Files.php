<?php namespace Models;
use Models\Conn as Conn;
use Models\StaticConn as StaticConn;
use PDO;

class Files extends Conn {
    private $fileArray = [];
    function __construct() {
        if(isset($_POST["fileUpload"]))
            $this->fileArray = $_FILES["files"];
        parent::__construct();
    }

    private function FileToDatabase($fileName, $fileType) {
        $type = "";
        switch($fileType) {
            case "png":
                $type = "image";
                break;
            case "jpg":
                $type = "image";
                break;
            case "bmp":
                $type = "image";
                break;
            case "docx":
                $type = "file";
                break;
            case "xlsx":
                $type = "file";
                break;
            case "rar":
                $type = "file";
                break;
            case "pdf":
                $type = "file";
                break;
        }

        $stmt = $this->conn->prepare("INSERT INTO files (filename, file_type)
        VALUES(?,?)");
        $stmt->execute([$fileName, $type]);
    }

    //A $_FILES tömb újrarendezése
    private function ReArrange() {
        $files = [];
        $keys = array_keys($this->fileArray);
        $counter = 0;
        $fileCount = count($this->fileArray['name']);
        /*
        A $_FILES tömböt rendezi át úgy, hogy 
        az egyes tömbelemek egy-egy fájl 
        adatait tartalmazzák, de az összes fájl 
        name kulcsát, size kulcsát stb... 
        */
        for($i = 0; $i < $fileCount; $i++) {
            foreach($keys  as $key) {
                $files[$i][$key] = $this->fileArray[$key][$i];
            }
        }
        return $files;
    }

    public function UploadFiles() {
        $files = $this->ReArrange();
        $errorArray = [];
        $counter = 0;
        //foreach ciklus a $files tömbhöz
        foreach($files as $file) {
            $fileExtension = strtolower(
                pathinfo($file['name'], PATHINFO_EXTENSION)
            );
            $fileSize = $file['size'];
            //5 megabájt
            $errorArray[$counter]['file_name'] = $file['name'];
            /*
            Az $errorArray false értéket kap a size kulcsnál, 
            ha a fájlméret nem megfelelő!
            */
            if($fileSize > 5242880) {
                $errorArray[$counter]['size'] = false;
            } else {
                $errorArray[$counter]['size'] = true;
            }

            if($fileExtension != 'bmp' 
            && $fileExtension != 'png' 
            && $fileExtension != 'jpg'
            && $fileExtension != "docx"
            && $fileExtension != "xlsx"
            && $fileExtension != "rar"
            && $fileExtension != "pdf") {
                $errorArray[$counter]['extension'] = false;
            } else {
                $errorArray[$counter]['extension'] = true;
            }

            if(file_exists("../uploads/" . $file['name'])) {
                $errorArray[$counter]['not_exists'] = false;
            } else {
                $errorArray[$counter]['not_exists'] = true;
            }
            /*
            Hogyha létezik false érték az $errorArray-ben, 
            akkor nem engedi feltölteni a fájlt. 
            */
            if(!in_array(false, $errorArray[$counter])) {
                if(move_uploaded_file($file['tmp_name'], 
                "../uploads/" . $file['name'])) {
                    $errorArray[$counter]['is_uploaded'] = true;
                    $this->FileToDatabase($file['name'], $fileExtension);
                } else {
                    $errorArray[$counter]['is_uploaded'] = false;
                }
            } else {
                $errorArray[$counter]['is_uploaded'] = false;
            }
            $counter++;
        }
        return $errorArray;
    }

    public function GetFiles($fileOrImage) {
        $stmt = $this->conn->prepare("SELECT * FROM files WHERE file_type = ?");
        $stmt->execute([$fileOrImage]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function DeleteFiles() {
        foreach($_POST["fileid"] as $id) {
            $stmt = $this->conn->prepare("SELECT filename FROM files WHERE file_id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();

            $delete = $this->conn->prepare("DELETE FROM files WHERE file_id = ?");
            $delete->execute([$id]);

            if(file_exists("../uploads/" . $row["filename"])) {
                unlink("../uploads/" . $row["filename"]);
            }
        }
    }

    public static function ChangeHeader() {
        $conn = StaticConn::StaticConnection();
        $isLocalhot = GetLocalhostPath();
        $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
        $fileName = $_SERVER["DOCUMENT_ROOT"] . $isLocalhot . "admin/uploads/header/header." . $extension;
        $fileSize = $_FILES["cover"]["size"];
        $message = "";
        if(!($extension == "png" || $extension == "jpg" || $extension == "jpeg" || $extension == "gif")) {
            $message .= "A következő képformátumok engedélyezettek: png, jps, jpeg, gif <br/>";
        }
        if($fileSize > 5242880) {
            $message .= "A maximális fájlméret 5 megabájt! <br/>";
        }
        if(empty($message)) {
            if(file_exists($fileName)) {
                unlink($fileName);
            }
            if(move_uploaded_file($_FILES["cover"]["tmp_name"], $fileName)) {
                $stmt = $conn->prepare("UPDATE cover SET extension = ? WHERE id = ?");
                try {
                    $stmt->execute([$extension, 2]);
                    $message .= "Sikeres módosítás!";
                } catch(PDOException $ex) {
                    echo $ex;
                }
                StaticConn::KillConn($conn);
            } else {
                $message .= "Meghatározhatatlan hiba történt.";
            }
        }
        return $message;
    } 

    function __destruct() {
        unset($this->fileArray);
        parent::__destruct();
    }
}