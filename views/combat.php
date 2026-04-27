<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat final</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php
$scoreAz = (int)($_SESSION['azariel'] ?? 0);
$scoreZu = (int)($_SESSION['zulqar'] ?? 0);
$ecart = abs($scoreAz - $scoreZu);

$phraseBonus = '';

if ($ecart >= 18) {
    $phraseBonus = " Le camp victorieux dominait déjà largement avant le duel final.";
} elseif ($ecart >= 10) {
    $phraseBonus = " Le combat confirme une supériorité installée au fil des choix.";
} elseif ($ecart >= 4) {
    $phraseBonus = " La victoire est solide, mais l’adversaire a opposé une vraie résistance.";
} else {
    $phraseBonus = " Le combat fut serré : quelques décisions différentes auraient pu changer l’issue.";
}
?>

<div class="container">
    <div class="panel final-panel">

        <h1 class="final-title">⚔️ Combat final de Mathusalem</h1>

        <div class="combat-head">
            <div class="fighter fighter-duo">
                <div class="fighter-team">
                    <img
                        src="/<?= htmlspecialchars($combat['duo']['leader']['image'] ?? 'assets/img/azariel.png') ?>"
                        alt="<?= htmlspecialchars($combat['duo']['leader']['nom'] ?? 'Leader') ?>"
                        class="fighter-avatar"
                    >

                    <img
                        src="/<?= htmlspecialchars($combat['duo']['allie']['image'] ?? 'assets/img/saahir.png') ?>"
                        alt="<?= htmlspecialchars($combat['duo']['allie']['nom'] ?? 'Allié') ?>"
                        class="fighter-avatar"
                    >
                </div>

                <h2 class="fighter-name"><?= htmlspecialchars($combat['duo']['nom'] ?? 'Duo') ?></h2>

                <div class="stat-block">
                    <div class="stat-label">PV</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-pv" style="width: <?= max(0, min(100, (($combat['duo']['pv_final'] ?? 0) / max(1, ($combat['duo']['pv_max'] ?? 1))) * 100)) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['duo']['pv_final'] ?? 0) ?> / <?= (int)($combat['duo']['pv_max'] ?? 0) ?></div>
                </div>

                <div class="stat-block">
                    <div class="stat-label">Attaque</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-attack" style="width: <?= max(8, min(100, (int)($combat['duo']['attaque'] ?? 0))) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['duo']['attaque'] ?? 0) ?></div>
                </div>

                <div class="stat-block">
                    <div class="stat-label">Pouvoir</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-power" style="width: <?= max(8, min(100, (int)($combat['duo']['pouvoir'] ?? 0))) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['duo']['pouvoir'] ?? 0) ?></div>
                </div>
            </div>

            <div class="combat-versus">VS</div>

            <div class="fighter fighter-solo">
                <div class="fighter-team fighter-team-solo">
                    <img
                        src="/<?= htmlspecialchars($combat['solo']['leader']['image'] ?? 'assets/img/zulqar.png') ?>"
                        alt="<?= htmlspecialchars($combat['solo']['leader']['nom'] ?? 'Adversaire') ?>"
                        class="fighter-avatar"
                    >
                </div>

                <h2 class="fighter-name"><?= htmlspecialchars($combat['solo']['nom'] ?? 'Adversaire') ?></h2>

                <div class="stat-block">
                    <div class="stat-label">PV</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-pv enemy" style="width: <?= max(0, min(100, (($combat['solo']['pv_final'] ?? 0) / max(1, ($combat['solo']['pv_max'] ?? 1))) * 100)) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['solo']['pv_final'] ?? 0) ?> / <?= (int)($combat['solo']['pv_max'] ?? 0) ?></div>
                </div>

                <div class="stat-block">
                    <div class="stat-label">Attaque</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-attack enemy" style="width: <?= max(8, min(100, (int)($combat['solo']['attaque'] ?? 0))) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['solo']['attaque'] ?? 0) ?></div>
                </div>

                <div class="stat-block">
                    <div class="stat-label">Pouvoir</div>
                    <div class="stat-bar">
                        <div class="stat-fill stat-power enemy" style="width: <?= max(8, min(100, (int)($combat['solo']['pouvoir'] ?? 0))) ?>%;"></div>
                    </div>
                    <div class="stat-value"><?= (int)($combat['solo']['pouvoir'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="scores combat-scoreboard">
            <div class="score score-azariel">
                Azariel : <b><?= $scoreAz ?></b>
            </div>
            <div class="score score-zulqar">
                Zulqar : <b><?= $scoreZu ?></b>
            </div>
        </div>

        <div class="combat-log">
            <?php foreach (($combat['journal'] ?? []) as $index => $ligne): ?>
                <?php
                $class = 'log-neutral';

                if ($index === 0 || $index === 2 || $index === 4) {
                    $class = 'log-attack';
                }

                if ($index === 1 || $index === 3) {
                    $class = 'log-counter';
                }

                if ($index === 4) {
                    $class = 'log-death';
                }
                ?>
                <div class="log-line <?= $class ?>">
                    <?= htmlspecialchars($ligne) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="panel combat-result-panel">
            <h2 class="choices-title"><?= htmlspecialchars($fin['titre'] ?? 'Fin') ?></h2>

            <p class="scene-text">
                <?= nl2br(htmlspecialchars(($fin['texte'] ?? '') . $phraseBonus)) ?>
            </p>

            <?php if (!empty($fin['image'])): ?>
                <img
                    src="/<?= htmlspecialchars($fin['image']) ?>"
                    alt="<?= htmlspecialchars($fin['titre'] ?? 'Image finale') ?>"
                    class="final-img"
                >
            <?php endif; ?>
        </div>

        <div class="actions" style="justify-content:center;">
            <a href="/scene.php?id=1" class="btn">🔄 Recommencer</a>
            <a href="/reset.php" class="btn btn-danger">❌ Reset</a>
            <a href="/credits.php" class="btn btn-ghost">📜 Crédits</a>
        </div>

    </div>
</div>

</body>
</html>