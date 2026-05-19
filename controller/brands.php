<?php
require_once '../models/models.php';
$brands = selectAllBrands(connectDB());
include '../views/brands.view.php';