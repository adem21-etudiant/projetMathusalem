<?php
class FinController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function afficherFin($id) {

        $fin = $this->model->getFinById($id);

        // Scores
        $az = $_SESSION['azariel'] ?? 0;
        $zu = $_SESSION['zulqar'] ?? 0;

        // Dernier choix
        $last = $_SESSION['last_path'] ?? null;

        // Logique
        if ($last === 'zulqar') {
            $isPurifie = false;
        } elseif ($last === 'azariel') {
            $isPurifie = true;
        } else {
            $isPurifie = ($az >= $zu);
        }

        $thubaranImg = $isPurifie
            ? "assets/img/thubaran_purifiee.png"
            : "assets/img/thubaran_corrompue.png";

        $thubaranTitre = $isPurifie
            ? "Thubaran — Purifiée"
            : "Thubaran — Corrompue";

        require "views/fin.php";
    }
}