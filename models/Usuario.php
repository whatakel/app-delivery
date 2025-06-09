<?php 
require_once 'config/conexao.php';

class Usuario {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::conectar();
    }

    public function inserir($nome, $email, $senha, $tipo) {
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha, tipo)
                    VALUES (:nome, :email, :senha, :tipo)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha); // já vem criptografada
            $stmt->bindParam(':tipo', $tipo);

            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "E-mail já cadastrado.";
            }
            return "Erro ao cadastrar: " . $e->getMessage();
        }
    }

    public function login($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }
}