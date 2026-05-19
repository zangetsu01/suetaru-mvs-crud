<?php
session_start();
require_once '../models/models.php';
logout();
header('Location: /index.php');
?>