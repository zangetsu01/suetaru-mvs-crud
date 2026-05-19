<?php
require_once '../models/models.php';
deleteCarAd(connectDB(), $_GET);
header('location: /index.php');
?>