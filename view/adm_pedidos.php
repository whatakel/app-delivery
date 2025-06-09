<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/conexao.php';

require_once '../controllers/PedidoController.php';

$pedidoController = new PedidoController($pdo);

$pedidos = $pedidoController->listar();

// Lógica para exibir mensagens sucesso/erro da sessão
$mensagem = '';
if (isset($_SESSION['msg_sucesso'])) {
    $mensagem = "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['msg_sucesso']) . "</div>";
    unset($_SESSION['msg_sucesso']); 
} elseif (isset($_SESSION['msg_erro'])) {
    $mensagem = "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['msg_erro']) . "</div>";
    unset($_SESSION['msg_erro']); 
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Pedidos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="../_public/css/style.css" rel="stylesheet">
    <link href="../_public/css/adm_pedidos.css" rel="stylesheet">
</head>
<body>
    <div class="container shadow-lg p-5 rounded">
        <h2 class="mb-4">Pedidos</h2>

        <?php echo $mensagem ?>

        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Pagamento</th>
                    <th>Data</th>
                    <th>Ações (Status/Editar)</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($pedidos) && count($pedidos) > 0) {
                    foreach ($pedidos as $pedido) {
                        $statusClass = '';
                        switch ($pedido->status) {
                            case 'Pendente':
                                $statusClass = 'status-pendente';
                                break;
                            case 'Preparando':
                                $statusClass = 'status-preparando';
                                break;
                            case 'Saiu para entrega':
                                $statusClass = 'status-saiu-para-entrega';
                                break;
                            case 'Entregue':
                                $statusClass = 'status-entregue';
                                break;
                            default:
                                $statusClass = '';
                                break;
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($pedido->id) . "</td>";
                        echo "<td>" . htmlspecialchars($pedido->nome_cliente) . "</td>";
                        echo "<td class='" . $statusClass . "'>" . htmlspecialchars($pedido->status) . "</td>";
                        echo "<td>" . htmlspecialchars($pedido->forma_pagamento) . "</td>";
                        echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($pedido->data_pedido))) . "</td>";

                        echo "<td>";
                        // Formulário para alterar status - APONTA PARA processar_status.php
                        echo "<form method='POST' action='processar_status.php' class='mb-1'>";
                        echo "<input type='hidden' name='pedido_id' value='" . htmlspecialchars($pedido->id) . "'>";
                        echo "<select class='form-select form-select-sm' name='status' onchange='this.form.submit()'>";
                        echo "<option selected disabled>Status Atual: " . htmlspecialchars($pedido->status) . "</option>";
                        $statusOptions = ['Pendente', 'Preparando', 'Saiu para entrega', 'Entregue'];
                        foreach ($statusOptions as $option) {
                            echo "<option value='" . htmlspecialchars($option) . "'" . ($pedido->status == $option ? ' selected' : '') . ">" . htmlspecialchars($option) . "</option>";
                        }
                        echo "</select>";
                        echo "</form>";
                        
                        // Coluna de Excluir
                        echo "<td>";
                        echo "<form method='POST' action='excluir_pedido.php' onsubmit='return confirm(\"Tem certeza que deseja excluir este pedido?\");'>";
                        echo "<input type='hidden' name='pedido_id' value='" . htmlspecialchars($pedido->id) . "'>";
                        echo "<button type='submit' class='btn btn-sm btn-danger'><i class='fa fa-trash-alt'></i> Excluir</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'><p class='alert alert-info'>Nenhum pedido encontrado para exibir.</p></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>