<?php namespace Models;
use Models\Conn as Conn;
use Traits\FormData as FormData;
use PDO;

class Seo extends Conn {
    use FormData;
    private $formData = [];
    function __construct() {
        if(isset($_POST['formData']))
            $this->formData = $this->FormDataAssoc($_POST['formData']);
        parent::__construct();
    }

    public function SetSeoData() {
        $stmt = $this->conn->prepare("UPDATE seo SET 
        title = :title,
        description = :description,
        schema_dcterms = :schema_dcterms,
        DC_coverage = :DC_coverage,
        DC_description = :DC_description,
        DC_format = :DC_format,
        DC_identifier = :DC_identifier,
        DC_publisher = :DC_publisher,
        DC_title = :DC_title,
        DC_type = :DC_type,
        og_image = :og_image");
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