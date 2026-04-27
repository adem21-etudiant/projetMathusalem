<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php
$sceneId = (int)($scene['id_histoire'] ?? 1);
$totalScenes = 25;
$progressPercent = max(0, min(100, (int)round((($sceneId - 1) / ($totalScenes - 1)) * 100)));
?>

<div class="container">

    <div class="topbar">
        <h1 class="title">Scène</h1>

        <div class="scores">
            <div class="score score-azariel">
                Azariel : <b><?= (int)($_SESSION['azariel'] ?? 0) ?></b>
            </div>
            <div class="score score-zulqar">
                Zulqar : <b><?= (int)($_SESSION['zulqar'] ?? 0) ?></b>
            </div>
        </div>
    </div>

    <div class="progress-wrap">
        <div class="progress-head">
            <span>Progression</span>
            <span>Scène <?= $sceneId ?> / <?= $totalScenes ?></span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" style="width: <?= $progressPercent ?>%;"></div>
        </div>
    </div>

    <div class="cards">

        <div class="card card-azariel">
            <img src="/assets/img/azariel.png" class="card-img" alt="Azariel">
            <h3 class="card-name">Azariel</h3>
            <p class="card-desc">Guide lumineux.</p>
        </div>

        <div class="card card-zulqar">
            <img src="/assets/img/zulqar.png" class="card-img" alt="Zulqar">
            <h3 class="card-name">Zulqar</h3>
            <p class="card-desc">Voix obscure.</p>
        </div>

        <div class="card card-saahir">
            <img src="/assets/img/saahir.png" class="card-img" alt="Saahir">
            <h3 class="card-name">Saahir</h3>
            <p class="card-desc">Gardien du savoir.</p>
        </div>

    </div>

    <div class="panel">

        <p class="scene-text">
            <?= htmlspecialchars($scene['texte'] ?? '') ?>
        </p>

        <h2 class="choices-title">Choix :</h2>

        <div class="choices">

            <?php foreach ($choix as $c): ?>
                <?php
                $class = "choice";

                $influenceAzariel = (int)($c['influence_azariel'] ?? 0);
                $influenceZulqar = (int)($c['influence_zulqar'] ?? 0);
                $destination = (int)($c['id_histoire_destination'] ?? 1);

                if ($influenceAzariel > 0) {
                    $class .= " choice-azariel";
                } elseif ($influenceZulqar > 0) {
                    $class .= " choice-zulqar";
                } else {
                    $class .= " choice-neutral";
                }

                $href = "/scene.php?id={$destination}&azariel={$influenceAzariel}&zulqar={$influenceZulqar}";
                ?>

                <a class="<?= $class ?>" href="<?= $href ?>">
                    <?= htmlspecialchars($c['texte_choix']) ?>
                </a>
            <?php endforeach; ?>

        </div>

        <div class="actions">
            <a href="/scene.php?id=1" class="btn">🔄 Recommencer</a>
            <a href="/reset.php" class="btn btn-danger">❌ Reset</a>
            <a href="/credits.php" class="btn btn-ghost">📜 Crédits</a>
        </div>

    </div>

</div>

</body>
</html>