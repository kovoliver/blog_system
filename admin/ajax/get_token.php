<?php use Models\CSRFToken as CSRFToken;

include '../models/init.php';

echo CSRFToken::GenerateToken();