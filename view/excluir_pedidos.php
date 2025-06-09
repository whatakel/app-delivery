<?php

require_once '../config/conexao.php';
require_once '../controllers/PedidoController.php';

$pedidoController = new PedidoController($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pedido_id'])) {
    $pedidoId = (int)$_POST['pedido_id'];

    if ($pedidoController->excluirPedido($pedidoId)) {
        $_SESSION['msg_sucesso'] = "Pedido #" . htmlspecialchars($pedidoId) . " excluído com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao excluir o pedido #" . htmlspecialchars($pedidoId) . ". Por favor, tente novamente ou verifique o log de erros do servidor.";
    }
    header("Location: adm_pedidos.php");
    exit();
} else {
    $_SESSION['msg_erro'] = "Requisição inválida para exclusão de pedido. ID do pedido não fornecido.";
    header("Location: adm_pedidos.php");
    exit();
}
?>