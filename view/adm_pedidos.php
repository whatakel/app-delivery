<?php
require_once './config/conexao.php';
require_once './controllers/PedidoController.php';

$pdo = Conexao::conectar();
$pedidoController = new PedidoController($pdo);

// Processar alteração de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && isset($_POST['pedido_id'])) {
    $pedidoId = (int)$_POST['pedido_id'];
    $novoStatus = $_POST['status'];
    
    if ($pedidoController->alterarStatusPedido($pedidoId, $novoStatus)) {
        $_SESSION['msg_sucesso'] = "Status do pedido atualizado com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao atualizar status do pedido.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Processar exclusão de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id']) && !isset($_POST['status'])) {
    $pedidoId = (int)$_POST['pedido_id'];
    
    if ($pedidoController->excluirPedido($pedidoId)) {
        $_SESSION['msg_sucesso'] = "Pedido excluído com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao excluir pedido.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

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

<div class="container shadow-lg p-5 rounded">
    <h2 class="mb-4">Pedidos</h2>

    <?php echo $mensagem ?>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Pagamento</th>
                <th>Data</th>
                <th>Itens</th>
                <th>Total</th>
                <th>Status</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (is_array($pedidos) && count($pedidos) > 0) {
                foreach ($pedidos as $pedido) {
                    $statusClass = match ($pedido->status) {
                        'Pendente' => 'status-pendente',
                        'Preparando' => 'status-preparando',
                        'Saiu para entrega' => 'status-saiu-para-entrega',
                        'Entregue' => 'status-entregue',
                        default => ''
                    };

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($pedido->id) . "</td>";
                    echo "<td class='" . $statusClass . "'>" . htmlspecialchars($pedido->status) . "</td>";
                    echo "<td>" . htmlspecialchars($pedido->forma_pagamento) . "</td>";
                    echo "<td>" . htmlspecialchars(date('d/m/Y H:i', strtotime($pedido->data_pedido))) . "</td>";
                    
                    // Coluna de Itens
                    echo "<td>";
                    if (!empty($pedido->itens)) {
                        echo "<button type='button' class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#itensModal" . $pedido->id . "'>Lista</button>";
                    } else {
                        echo "Nenhum item";
                    }
                    echo "</td>";
                    
                    // Coluna de Total
                    echo "<td>R$ " . number_format($pedido->total, 2, ',', '.') . "</td>";

                    // Coluna de Ações (Status)
                    echo "<td>";
                    echo "<form method='POST' class='mb-1'>";
                    echo "<input type='hidden' name='pedido_id' value='" . htmlspecialchars($pedido->id) . "'>";
                    echo "<select class='form-select form-select-sm' name='status' onchange='this.form.submit()'>";
                    echo "<option selected disabled>Status Atual: " . htmlspecialchars($pedido->status) . "</option>";
                    $statusOptions = ['Pendente', 'Preparando', 'Saiu para entrega', 'Entregue'];
                    foreach ($statusOptions as $option) {
                        echo "<option value='" . htmlspecialchars($option) . "'" . ($pedido->status == $option ? ' selected' : '') . ">" . htmlspecialchars($option) . "</option>";
                    }
                    echo "</select>";
                    echo "</form>";
                    echo "</td>";

                    // Coluna de Excluir
                    echo "<td>";
                    echo "<form method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir este pedido?\");'>";
                    echo "<input type='hidden' name='pedido_id' value='" . htmlspecialchars($pedido->id) . "'>";
                    echo "<button type='submit' class='btn btn-sm btn-danger'><i class='fa fa-trash-alt'></i> Excluir</button>";
                    echo "</form>";
                    echo "</td>";

                    echo "</tr>";

                    // Modal para exibir itens
                    if (!empty($pedido->itens)) {
                        echo "<div class='modal fade' id='itensModal" . $pedido->id . "' tabindex='-1' aria-labelledby='itensModalLabel" . $pedido->id . "' aria-hidden='true'>";
                        echo "<div class='modal-dialog'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='itensModalLabel" . $pedido->id . "'>Itens do Pedido #" . $pedido->id . "</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        echo "<ul class='list-group'>";
                        foreach ($pedido->itens as $item) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                            echo htmlspecialchars($item['nome']);
                            echo "<span class='badge bg-primary rounded-pill'>" . htmlspecialchars($item['quantidade']) . "x</span>";
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'><p class='alert alert-info'>Nenhum pedido encontrado para exibir.</p></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>