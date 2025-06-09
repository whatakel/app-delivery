<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/conexao.php';
require_once '../controllers/PedidoController.php';

$pedidoController = new PedidoController($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pedido_id']) && isset($_POST['status'])) {
    $pedidoId = (int)$_POST['pedido_id'];
    $novoStatus = $_POST['status'];

    $statusPermitidos = ['Pendente', 'Preparando', 'Saiu para entrega', 'Entregue'];
    if (!in_array($novoStatus, $statusPermitidos)) {
        $_SESSION['msg_erro'] = "Status inválido fornecido.";
        header("Location: adm_pedidos.php");
        exit();
    }

    if ($pedidoController->alterarStatusPedido($pedidoId, $novoStatus)) {
        $_SESSION['msg_sucesso'] = "Status do pedido atualizado com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao atualizar status do pedido. Verifique o log de erros.";
    }
    header("Location: adm_pedidos.php");
    exit();
} else {
    $_SESSION['msg_erro'] = "Dados para alterar status inválidos.";
    header("Location: adm_pedidos.php");
    exit();
}
?>