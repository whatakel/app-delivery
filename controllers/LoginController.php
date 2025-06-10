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
            $senhaValida = preg_match('/[A-Z]/', $senha) &&
                preg_match('/[0-9]/', $senha) &&
                preg_match('/[\W]/', $senha) &&
                strlen($senha) >= 8;

            if (!$senhaValida) {
                $_SESSION['mensagem'] = ['texto' => 'A senha deve conter no mínimo 8 caracteres, incluindo uma letra maiúscula, um número e um caractere especial.', 'classe' => 'danger'];
                header('Location: index.php?pagina=login');
                exit;
            }

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
            $lembrar = isset($_POST['lembrar']); // checkbox "lembrar de mim"

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->login($email, $senha);

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            if ($usuario) {
                ini_set('session.gc_maxlifetime', 60 * 60 * 2);
                session_set_cookie_params(60 * 60 * 2);
                $_SESSION['usuario'] = $usuario;

                //Armazenar cookie 
                if ($lembrar) {
                    setcookie('usuario_email', $email, time() + (86400 * 30), "/");
                    setcookie('usuario_senha', $senha, time() + (86400 * 30), "/");
                } else {
                    // Remover cookie
                    if (isset($_COOKIE['usuario_email'])) {
                        setcookie('usuario_email', '', time() - 3600, "/");
                        setcookie('usuario_senha', '', time() - 3600, "/");
                    }
                }

                // Redirecionar de acordo com o tipo de usuário
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
        session_unset();
        session_destroy();
        header('Location: index.php?pagina=login');
        exit;
    }
}
