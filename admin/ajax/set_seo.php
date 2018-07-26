<?php use Models\Seo as Seo;

include '../models/init.php';

$seo = new Seo();
echo $seo->SetSeoData();