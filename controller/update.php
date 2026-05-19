<?php
require_once '../models/models.php';
updateCarAd(connectDB(), $_POST, $_FILES);
header('Location: view.php?id=' . $_POST['id']);

?>