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
                header("Location: index.php?pagina=cardapio");
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

    case 'cardapio':
        require_once './controllers/LoginController.php';
        LoginController::verificarAcesso('cliente');

        require_once './controllers/ProdutoController.php';
        $controller = new ProdutoController();
        $produtos = $controller->mostrarProdutos();

        headerMenu($tipoUsuario, 'cardapio.css', 'cardapio');
        require_once './view/cardapio.php';
        break;

    case 'sair':
        require_once './controllers/LoginController.php';
        $controller = new LoginController();
        $controller->sair();
        break;
}
