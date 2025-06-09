<?php
session_start();
require_once './view/template.php';

$pagina = $_GET['pagina'] ?? 'login';
$tipoUsuario = $_SESSION['usuario']['tipo'] ?? null;


switch ($pagina) {
    case 'login':
        if (isset($_SESSION['usuario'])) {
            $tipo = $_SESSION['usuario']['tipo'] ?? '';
            if ($tipo === 'adm') {
                header("Location: index.php?pagina=adm_pedidos");
            } else {
                header("Location: index.php?pagina=produtos");
            }
            exit;
        }

        require_once './controllers/LoginController.php';
        $controller = new LoginController();
        $controller->formulario();

        headerMenu(null, 'login.css', "Login - On Delivery");
        require_once './view/login.php';
        footer();
        break;

    case 'adm_pedidos':
        require_once './controllers/LoginController.php';
        LoginController::verificarAcesso('adm');
        headerMenu($tipoUsuario, 'adm_pedidos.css', 'Pedidos');
        require_once './view/adm_pedidos.php';
        footer();
        break;

    case 'produtos':
        require_once './controllers/LoginController.php';
        LoginController::verificarAcesso('cliente');
        headerMenu($tipoUsuario, 'produtos.css', 'Pedidos');
        require_once './view/produtos.php';
        break;

    case 'sair':
        require_once './controllers/LoginController.php';
        $controller = new LoginController();
        $controller->sair();
        break;
}
