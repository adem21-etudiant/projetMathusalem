<?php

class SceneController
{
    private SceneModel $model;

    public function __construct(SceneModel $model)
    {
        $this->model = $model;
    }

    public function afficherScene(int $id): void
    {
        $scene = $this->model->getSceneById($id);

        if (!$scene) {
            http_response_code(404);
            echo "Scène introuvable.";
            return;
        }

        if (($scene['type_scene'] ?? '') === 'final') {
            $this->afficherCombatOuFin();
            return;
        }

        $choix = $this->model->getChoixBySceneId($id);

        require __DIR__ . '/../views/scene.php';
    }

    private function afficherCombatOuFin(): void
    {
        $scoreAzariel = (int)($_SESSION['azariel'] ?? 0);
        $scoreZulqar  = (int)($_SESSION['zulqar'] ?? 0);

        if ($scoreAzariel === $scoreZulqar) {
            $finCode = ($scoreAzariel === 12 && $scoreZulqar === 12)
                ? 'egalite_parfaite'
                : 'egalite';

            $fin = $this->model->getFinByCode($finCode);

            if (!$fin) {
                http_response_code(500);
                echo "Fin d'égalité introuvable.";
                return;
            }

            require __DIR__ . '/../views/fin.php';
            return;
        }

        $campMajoritaire = $scoreAzariel > $scoreZulqar ? 'Azariel' : 'Zulqar';
        $campMinoritaire = $campMajoritaire === 'Azariel' ? 'Zulqar' : 'Azariel';

        $leader = $this->model->getPersonnageByNom($campMajoritaire);
        $adversaire = $this->model->getPersonnageByNom($campMinoritaire);
        $saahir = $this->model->getPersonnageByNom('Saahir');

        if (!$leader || !$adversaire || !$saahir) {
            http_response_code(500);
            echo "Impossible de charger les personnages du combat.";
            return;
        }

        $difference = abs($scoreAzariel - $scoreZulqar);

        $duo = [
            'nom'    => $campMajoritaire . ' + Saahir',
            'leader' => $leader,
            'allie'  => $saahir
        ];

        $solo = [
            'nom'    => $campMinoritaire,
            'leader' => $adversaire
        ];

        $combat = $this->simulerCombatFinalScript($duo, $solo, $difference);

        $finCode = $campMajoritaire === 'Azariel' ? 'azariel_win' : 'zulqar_win';
        $fin = $this->model->getFinByCode($finCode);

        if (!$fin) {
            http_response_code(500);
            echo "Fin du combat introuvable.";
            return;
        }

        require __DIR__ . '/../views/combat.php';
    }

    private function simulerCombatFinalScript(array $duo, array $solo, int $difference): array
    {
        $duoPvMax =
            (int)$duo['leader']['pv'] +
            (int)$duo['allie']['pv'] +
            ($difference * 4);

        $soloPvMax =
            (int)$solo['leader']['pv'] +
            max(10, (int)floor($difference * 1.5));

        $duoAttaque =
            (int)$duo['leader']['attaque'] +
            (int)$duo['allie']['attaque'] +
            (int)floor(((int)$duo['leader']['pouvoir'] + (int)$duo['allie']['pouvoir']) / 2) +
            ($difference * 2);

        $soloAttaque =
            (int)$solo['leader']['attaque'] +
            (int)floor((int)$solo['leader']['pouvoir'] / 2);

        $duoPouvoir =
            (int)$duo['leader']['pouvoir'] +
            (int)$duo['allie']['pouvoir'];

        $soloPouvoir =
            (int)$solo['leader']['pouvoir'];

        $duoPv = $duoPvMax;
        $soloPv = $soloPvMax;

        $journal = [];

        $degat1 = max(18, (int)floor($soloPvMax * 0.35));
        $soloPv -= $degat1;
        $journal[] = "{$duo['nom']} frappe en premier et inflige {$degat1} dégâts à {$solo['nom']}.";

        $degat2 = max(12, (int)floor($duoPvMax * 0.18));
        $duoPv -= $degat2;
        $journal[] = "{$solo['nom']} réplique violemment et inflige {$degat2} dégâts à {$duo['nom']}.";

        $soloPvCible = max(8, (int)floor($soloPvMax * 0.12));
        $degat3 = max(1, $soloPv - $soloPvCible);
        $soloPv -= $degat3;
        $journal[] = "{$duo['nom']} contre-attaque et pousse {$solo['nom']} au bord de la défaite.";

        $degat4 = max(10, (int)floor($duoPvMax * 0.14));
        $duoPv -= $degat4;
        $journal[] = "{$solo['nom']} lance une ultime attaque, mais {$duo['nom']} encaisse le choc.";

        $soloPv = 0;
        $journal[] = "{$duo['nom']} achève {$solo['nom']} d’un dernier assaut décisif.";

        return [
            'duo' => [
                'nom'      => $duo['nom'],
                'leader'   => $duo['leader'],
                'allie'    => $duo['allie'],
                'pv_max'   => $duoPvMax,
                'pv_final' => max(0, $duoPv),
                'attaque'  => $duoAttaque,
                'pouvoir'  => $duoPouvoir,
            ],
            'solo' => [
                'nom'      => $solo['nom'],
                'leader'   => $solo['leader'],
                'pv_max'   => $soloPvMax,
                'pv_final' => max(0, $soloPv),
                'attaque'  => $soloAttaque,
                'pouvoir'  => $soloPouvoir,
            ],
            'journal'   => $journal,
            'vainqueur' => $duo['nom'],
            'perdant'   => $solo['nom'],
        ];
    }
}