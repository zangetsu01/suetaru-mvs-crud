<?php
session_start();
require_once '../models/models.php';

if (isLogged()) {
    header('Location: /index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connectDB();
    $result = createUser($pdo, $_POST);
    
    if ($result === true) {
        $success = 'Регистрация успешна! Теперь войдите.';
    } else {
        $error = $result;
    }
}

include '../views/register.view.php';
?>