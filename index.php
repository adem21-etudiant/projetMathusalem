<?php
session_start();

// Reset des scores au démarrage
$_SESSION['azariel'] = 0;
$_SESSION['zulqar'] = 0;
$_SESSION['last_path'] = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mathusalem</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="panel final-panel">

        <h1 class="final-title">Mathusalem</h1>

        <p class="scene-text" style="text-align:center;">
            Entre lumière et ténèbres, tes choix façonneront le destin de Thubaran.
        </p>

        <div class="actions" style="justify-content:center; margin-top:20px;">
            <a href="/scene.php?id=1" class="btn">▶️ Commencer</a>
            <a href="/credits.php" class="btn btn-ghost">📜 Crédits</a>
        </div>

    </div>
</div>

</body>
</html>