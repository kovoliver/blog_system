<?php use Models\SocialMedia as SocialMedia;

include '../models/init.php';

$social = new SocialMedia();
echo $social->UpdateSocialMedia();