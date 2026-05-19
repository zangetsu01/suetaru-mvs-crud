<?php
require 'models/models.php';
session_start();

$pdo = connectDB();

$ads = selectAllAds($pdo, $_GET);
$brands = selectAllBrands($pdo);
$allModels = selectAllModels($pdo);
$isAdmin = isAdmin($pdo);
$isLoggedIn = isLogged();
$currentUser = getCurrentUser($pdo);

include 'views/index.view.php';
?> 