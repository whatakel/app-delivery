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

    public function listarTodos() {
        try {
            $sql = "SELECT id, nome, email, tipo FROM usuarios ORDER BY nome";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($id, $nome, $email, $tipo) {
        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':tipo', $tipo);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}