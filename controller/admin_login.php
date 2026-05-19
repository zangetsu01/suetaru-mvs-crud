<?php
session_start();
require_once '../models/models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    tryLogin(connectDB(), $_POST);
    header('Location: /index.php');
    exit;
}

include '../views/admin_login.view.php';
?>