<?php
require_once 'config/conexao.php';

class Produto
{
    private $conn;

    public function __construct()
    {
        $this->conn = Conexao::conectar();
    }

    public function listarProdutos()
    {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
