<?php
require_once '../models/models.php';
session_start();

$pdo = connectDB();

if (!isAdmin($pdo)) {
    header('Location: /index.php');
    exit;
}

$ad = selectAdForEdit($pdo, $_GET);
$brands = selectAllBrands($pdo);
$allModels = selectAllModels($pdo);

include '../views/edit.view.php';
?>