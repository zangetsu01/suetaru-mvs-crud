<?php
require_once '../models/models.php';
session_start();

if (!isLogged()) {
    header('Location: login.php');
    exit;
}

$brands = selectAllBrands(connectDB());
$allModels = selectAllModels(connectDB());
include '../views/create.view.php';