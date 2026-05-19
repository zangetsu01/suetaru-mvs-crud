<?php
require_once '../models/models.php';
$ad = selectAdById(connectDB(), ['id' => $_GET['id']]);
include '../views/show.view.php';
?>