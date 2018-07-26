<?php use Models\Atricles as Atricles;

include '../models/init.php';

$articles = new Atricles();
echo $articles->GetMaxPage();
