<?php
class FinModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getFinById($id) {
        $stmt = $this->conn->prepare("SELECT texte_fin FROM fin_histoire WHERE id_fin = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $res = $stmt->get_result();
        $fin = $res->fetch_assoc();

        $stmt->close();

        return $fin;
    }
}