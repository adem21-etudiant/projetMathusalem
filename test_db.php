<?php
require __DIR__ . '/db.php';

try {
    getDB();
    echo "BDD OK";
} catch (Throwable $e) {
    echo $e->getMessage();
}
