<?php

session_start();
session_unset();
session_destroy();

header('Location: /scene.php?id=1');
exit;