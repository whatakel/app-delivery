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

    public function editar($id, $nome, $email, $tipo, $senha = null) {
        return $this->usuarioModel->atualizar($id, $nome, $email, $tipo, $senha);
    }

    public function excluir($id) {
        return $this->usuarioModel->excluir($id);
    }

    public function processarRequisicao() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            if (isset($_POST['editar_usuario'])) {
                $tipo = $_POST['tipo'] === 'administrador' ? 'adm' : 'usuario';
                $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;
                $ok = $this->editar($id, $_POST['nome'], $_POST['email'], $tipo, $senha);
                $_SESSION[$ok ? 'msg_sucesso' : 'msg_erro'] = $ok ? "Usuário atualizado com sucesso!" : "Erro ao atualizar usuário.";
                header('Location: index.php?pagina=adm_usuarios');
                exit;
            } elseif (isset($_POST['excluir_usuario'])) {
                $ok = $this->excluir($id);
                $_SESSION[$ok ? 'msg_sucesso' : 'msg_erro'] = $ok ? "Usuário excluído com sucesso!" : "Erro ao excluir usuário.";
                header('Location: index.php?pagina=adm_usuarios');
                exit;
            }
        }
    }

    public function obterMensagem() {
        if (isset($_SESSION['msg_sucesso']) || isset($_SESSION['msg_erro'])) {
            $classe = isset($_SESSION['msg_sucesso']) ? 'success' : 'danger';
            $msg = $_SESSION['msg_sucesso'] ?? $_SESSION['msg_erro'];
            $mensagem = "<div class='alert alert-$classe'>" . htmlspecialchars($msg) . "</div>";
            unset($_SESSION['msg_sucesso'], $_SESSION['msg_erro']);
            return $mensagem;
        }
        return '';
    }
}
