<?php 
require_once 'config/conexao.php';

class Usuario{
    private $conn;

    public function __construct(){
        $this->conn = Conexao::conectar();
    }

    public function inserir($nome, $email, $senha, $tipo){
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo)
                VALUES (:nome, :email, :senha, :tipo)";

        $stmt = $this->conn->prepare($sql);
        
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':tipo', $tipo);

        return $stmt->execute();
        
    }
}
?>