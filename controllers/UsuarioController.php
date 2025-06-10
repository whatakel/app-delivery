<?php
require_once './models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function listar() {
        return $this->usuarioModel->listarTodos();
    }

    public function editar($id, $nome, $email, $tipo) {
        return $this->usuarioModel->atualizar($id, $nome, $email, $tipo);
    }

    public function excluir($id) {
        return $this->usuarioModel->excluir($id);
    }
}
