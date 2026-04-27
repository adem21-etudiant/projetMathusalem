<?php
session_start();
include "db.php";

require "models/FinModel.php";
require "controllers/FinController.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$model = new FinModel($conn);
$controller = new FinController($model);

$controller->afficherFin($id);

$conn->close();