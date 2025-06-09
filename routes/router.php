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
        footer();
        break;

    case 'pedido/adicionar':
        require_once './config/conexao.php';
        $pdo = Conexao::conectar();
        require_once './controllers/LoginController.php';
        LoginController::verificarAcesso('cliente');
        require_once './controllers/PedidoController.php';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['erro' => 'Método inválido']);
            exit;
        }

        require_once './controllers/PedidoController.php';
        $controller = new PedidoController($pdo);
        $controller->adicionarPedido(); // já retorna JSON e termina
        break;

    case 'sair':
        require_once './controllers/LoginController.php';
        $controller = new LoginController();
        $controller->sair();
        break;
}
