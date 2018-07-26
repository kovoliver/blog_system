<?php use Models\Files as Files;

    include '../models/init.php';
    $file = new Files($_FILES['file']);
    //UploadFile() metódus meghívása
    $file->UploadFile();
