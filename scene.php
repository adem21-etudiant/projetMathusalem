<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/models/SceneModel.php';
require_once __DIR__ . '/controllers/SceneController.php';

if (!isset($_SESSION['azariel'])) {
    $_SESSION['azariel'] = 0;
}

if (!isset($_SESSION['zulqar'])) {
    $_SESSION['zulqar'] = 0;
}

if (!isset($_SESSION['last_path'])) {
    $_SESSION['last_path'] = null;
}

$id = isset($_GET['id']) ? (int) trim($_GET['id']) : 1;

$gainAzariel = isset($_GET['azariel']) ? (int) trim($_GET['azariel']) : 0;
$gainZulqar = isset($_GET['zulqar']) ? (int) trim($_GET['zulqar']) : 0;

$currentPath = $id . '|' . $gainAzariel . '|' . $gainZulqar;

if ($_SESSION['last_path'] !== $currentPath) {
    $_SESSION['azariel'] += $gainAzariel;
    $_SESSION['zulqar'] += $gainZulqar;
    $_SESSION['last_path'] = $currentPath;
}

$pdo = getDB();

$model = new SceneModel($pdo);
$controller = new SceneController($model);

$controller->afficherScene($id);