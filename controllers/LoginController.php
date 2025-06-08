<?php
require_once 'models/Usuario.php';

class LoginController
{

    public static function verificarAcesso($tipoNecessario)
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== $tipoNecessario) {
            $_SESSION['permissao'] = ['texto' => 'Acesso negado.', 'classe' => 'danger'];
            header("Location: index.php?pagina=login");
            exit;
        }
    }


    public function formulario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['acao'])) {
            if ($_POST['acao'] === 'cadastrar') {
                $this->cadastrarUsuario();
            } elseif ($_POST['acao'] === 'login') {
                $this->logarUsuario();
            }
        }
    }

    public function cadastrarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $tipo = $_POST['tipo'] ?? 'cliente';

            $usuario = new Usuario();
            $resultado = $usuario->inserir($nome, $email, $senha, $tipo);

            session_start();
            if ($resultado) {
                $_SESSION['mensagem'] = ['texto' => 'Usuário cadastrado com sucesso!', 'classe' => 'success'];
            } else {
                $_SESSION['mensagem'] = ['texto' => 'Erro ao cadastrar usuário.', 'classe' => 'danger'];
            }
            header('Location: index.php?pagina=login');
            exit;
        }
    }

    public function logarUsuario()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($email, $senha);

            session_start();
            if ($usuario) {
                ini_set('session.gc_maxlifetime', 60 * 60 * 2);
                session_set_cookie_params(60 * 60 * 2);
                $_SESSION['usuario'] = $usuario;
                if ($usuario['tipo'] === 'adm') {
                    header("Location: index.php?pagina=adm_pedidos");
                } else {
                    header("Location: index.php?pagina=produtos");
                }
                exit;
            } else {
                $_SESSION['mensagem'] = ['texto' => 'Email ou senha incorretos.', 'classe' => 'danger'];
                header("Location: index.php?pagina=login");
                exit;
            }
        }
    }

    

    public function sair()
    {
        session_start();
        session_unset(); // remove todas as variáveis de sessão
        session_destroy(); // destrói a sessão
        header('Location: index.php?pagina=login');
        exit;
    }
}
