<?php
require_once 'models/Usuario.php';

class LoginController
{

    public static function verificarAcesso($tipoNecessario)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();

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

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            // Validação do e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['mensagem'] = ['texto' => 'E-mail inválido.', 'classe' => 'danger'];
                header('Location: index.php?pagina=login');
                exit;
            }

            // Validação da senha
            $senhaValida = preg_match('/[A-Z]/', $senha) &&       // letra maiúscula
                           preg_match('/[0-9]/', $senha) &&       // número
                           preg_match('/[\W]/', $senha) &&        // caractere especial
                           strlen($senha) >= 8;                   // mínimo 8 caracteres

            if (!$senhaValida) {
                $_SESSION['mensagem'] = ['texto' => 'A senha deve conter no mínimo 8 caracteres, incluindo uma letra maiúscula, um número e um caractere especial.', 'classe' => 'danger'];
                header('Location: index.php?pagina=login');
                exit;
            }

            // Criptografar senha aqui (foi removido do model para evitar dupla hash)
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $usuario = new Usuario();
            $resultado = $usuario->inserir($nome, $email, $senhaCriptografada, $tipo);

            if ($resultado === true) {
                $_SESSION['mensagem'] = ['texto' => 'Usuário cadastrado com sucesso!', 'classe' => 'success'];
            } else {
                $_SESSION['mensagem'] = ['texto' => $resultado, 'classe' => 'danger'];
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

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            if ($usuario) {
                ini_set('session.gc_maxlifetime', 60 * 60 * 2);
                session_set_cookie_params(60 * 60 * 2);
                $_SESSION['usuario'] = $usuario;
                if ($usuario['tipo'] === 'adm') {
                    header("Location: index.php?pagina=adm_pedidos");
                } else {
                    header("Location: index.php?pagina=cardapio");
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
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_unset(); // remove todas as variáveis de sessão
        session_destroy(); // destrói a sessão
        header('Location: index.php?pagina=login');
        exit;
    }   
}
