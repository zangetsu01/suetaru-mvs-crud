<?php
session_start();
require_once '../models/models.php';

if (isLogged()) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connectDB();
    if (tryLogin($pdo, $_POST)) {
        header('Location: /index.php');
        exit;
    } else {
        $error = 'Неверный email или пароль';
    }
}

include '../views/login.view.php';
?>