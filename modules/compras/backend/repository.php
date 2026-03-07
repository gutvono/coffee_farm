<?php
// Repository do módulo compras
class ComprasRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        // Lógica para buscar dados do banco
        return [];
    }
}
?>