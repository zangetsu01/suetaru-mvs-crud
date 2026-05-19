<?php
require_once '../models/models.php';
session_start();

if (!isLogged()) {
    header('Location: login.php');
    exit;
}

$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    insertCarAd($pdo, $_POST, $_FILES);
    header('Location: /index.php');
    exit;
}


$brands = selectAllBrands($pdo);
$allModels = selectAllModels($pdo);
$isAdmin = isAdmin($pdo);
$currentUser = getCurrentUser($pdo);

include '../views/add_ad.view.php';
?>