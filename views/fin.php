<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fin du jeu</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php
$scoreAz = (int)($_SESSION['azariel'] ?? 0);
$scoreZu = (int)($_SESSION['zulqar'] ?? 0);
?>

<div class="container">
    <div class="panel final-panel">

        <h1 class="final-title">
            <?= htmlspecialchars($fin['titre'] ?? 'Fin') ?>
        </h1>

        <!-- ========================= -->
        <!-- EGALITE PARFAITE -->
        <!-- ========================= -->

        <?php if (($fin['code_fin'] ?? '') === 'egalite_parfaite'): ?>

            <p class="scene-text">
                <?= nl2br(htmlspecialchars($fin['texte'] ?? '')) ?>
            </p>

            <div class="egalite-parfaite">

                <h2>⚖️ Équilibre absolu</h2>

                <div class="thubaran-container">

                    <img src="/assets/img/thubaran_eveiller.png"
                         alt="Thubaran éveillé"
                         class="thubaran-img">

                    <div class="thubaran-title">
                        Thubaran éveillé
                    </div>

                    <div class="mystere">❓</div>

                </div>

            </div>

        <!-- ========================= -->
        <!-- AUTRES FINS -->
        <!-- ========================= -->

        <?php else: ?>

            <p class="scene-text">
                <?= nl2br(htmlspecialchars($fin['texte'] ?? '')) ?>
            </p>

            <?php if (!empty($fin['image'])): ?>
                <img
                    src="/<?= htmlspecialchars($fin['image']) ?>"
                    class="final-img"
                    alt="Fin"
                >
            <?php endif; ?>

        <?php endif; ?>

        <!-- SCORE -->
        <p class="final-score">
            Azariel : <strong><?= $scoreAz ?></strong> |
            Zulqar : <strong><?= $scoreZu ?></strong>
        </p>

        <!-- ACTIONS -->
        <div class="actions" style="justify-content:center;">
            <a href="/scene.php?id=1" class="btn">🔄 Recommencer</a>
            <a href="/reset.php" class="btn btn-danger">❌ Reset</a>
            <a href="/credits.php" class="btn btn-ghost">📜 Crédits</a>
        </div>

    </div>
</div>

</body>
</html>