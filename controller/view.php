<?php
require_once '../models/models.php';
session_start();

$pdo = connectDB();
$ad = selectAdById($pdo, $_GET);
$isAdmin = isAdmin($pdo); 

include '../views/view.view.php';
?>