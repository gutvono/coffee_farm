<?php
// Repository do módulo pcp
class PcpRepository {
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