<?php

class SceneModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSceneById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM histoire WHERE id_histoire = ?");
        $stmt->execute([$id]);
        $scene = $stmt->fetch(PDO::FETCH_ASSOC);

        return $scene ?: null;
    }

    public function getChoixBySceneId(int $idHistoire): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM choix
            WHERE id_histoire_source = ?
            ORDER BY id_choix ASC
        ");
        $stmt->execute([$idHistoire]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFinByCode(string $codeFin): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM fins WHERE code_fin = ?");
        $stmt->execute([$codeFin]);
        $fin = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fin ?: null;
    }

    public function getPersonnageByNom(string $nom): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM personnage WHERE nom = ?");
        $stmt->execute([$nom]);
        $perso = $stmt->fetch(PDO::FETCH_ASSOC);

        return $perso ?: null;
    }
}