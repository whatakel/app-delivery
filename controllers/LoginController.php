<?php
require_once '../models/Usuario.php';

class LoginController{
    public function cadastrarUsuario(){
        if($_SERVER['REQUESTED_METHOD'] === 'POST'){
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $tipo = $_POST['tipo'] ?? 'cliente';

            $usuario = new Usuario();
            $resultado = $usuario->inserir($nome, $email, $senha, $tipo);

            if($resultado){
                echo "Usuário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
    }
}


?>