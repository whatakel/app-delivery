<?php 
require_once '../config/conexao.php';

class Usuario{
    private $conn;

    public function usuario(){
        $this->conn = Conexao::conectar();
    }

    public function inserir($nome, $email, $senha, $tipo){
        $sql = "INSERT INTO usuario (nome, email, senha, tipo
                VALUES (:nome, :email, :senha, :tipo)";

        $stmt = $this->conn->prepare($sql);
        
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':nome', $email);
        $stmt->bindParam(':nome', $senhaHash);
        $stmt->bindParam(':nome', $tipo);

        return $stmt->excecute();
        
    }
}
?>