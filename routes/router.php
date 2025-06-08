<?php
require_once './view/template.php';

$pagina = $_GET['pagina'] ?? 'adm_pedidos';

switch ($pagina){
    case 'login':
        require_once './controllers/LoginController.php';
        $controller = new LoginController();
        $controller->cadastrarUsuario();
        headerMenu();
        require_once './view/login.php';
        // require_once './controllers/LoginController.php';
        // $controller = new LoginController();
        // $controller->cadastrarUsuario();
        // require_once './view/login.php';
        break;
    case 'adm_pedidos': 
        headerMenu();
        require_once './view/adm_pedidos.php';
        footer();
        break;
}

?>