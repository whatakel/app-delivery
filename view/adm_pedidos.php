<?php
require_once './config/conexao.php';
require_once './controllers/PedidoController.php';

$pdo = Conexao::conectar();
$controller = new PedidoController($pdo);
$dados = $controller->gerenciarPedidosAdmin();
$pedidos = $dados['pedidos'];
$mensagem = $dados['mensagem'];
?>

<div class="container shadow-lg p-5 rounded">
    <h2 class="mb-4">Pedidos</h2>
    <?= $mensagem ?>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nome</th><th>Pagamento</th><th>Data</th><th>Itens</th><th>Total</th><th>Status</th><th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($pedidos): foreach ($pedidos as $pedido): 
                $classes = [
                    'Pendente' => 'bg-warning',
                    'Preparando' => 'bg-info',
                    'Saiu para entrega' => 'bg-primary',
                    'Entregue' => 'bg-success'
                ];
                $statusClass = $classes[$pedido->status] ?? '';
            ?>
            <tr>
                <td><?= htmlspecialchars($pedido->id) ?></td>
                <td><?= htmlspecialchars($pedido->nome_cliente) ?></td>
                <td><?= htmlspecialchars($pedido->forma_pagamento) ?></td>
                <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($pedido->data_pedido)) ?></small></td>
                <td>
                    <?php if (!empty($pedido->itens)): ?>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#itensModal<?= $pedido->id ?>">Lista</button>
                    <?php else: ?>Nenhum item<?php endif; ?>
                </td>
                <td>R$ <?= number_format($pedido->total, 2, ',', '.') ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="pedido_id" value="<?= $pedido->id ?>">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option disabled selected>Status Atual: <?= htmlspecialchars($pedido->status) ?></option>
                            <?php 
                            $statusColors = [
                                'Pendente' => 'bg-warning text-dark',
                                'Preparando' => 'bg-info text-dark',
                                'Saiu para entrega' => 'bg-primary text-white',
                                'Entregue' => 'bg-success text-white'
                            ];
                            foreach (['Pendente', 'Preparando', 'Saiu para entrega', 'Entregue'] as $status): ?>
                                <option class="<?= $statusColors[$status] ?>" <?= $pedido->status == $status ? 'selected' : '' ?> value="<?= $status ?>"><?= $status ?></option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Deseja excluir este pedido?');">
                        <input type="hidden" name="pedido_id" value="<?= $pedido->id ?>">
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> Excluir</button>
                    </form>
                </td>
            </tr>

            <?php if (!empty($pedido->itens)): ?>
            <div class="modal fade" id="itensModal<?= $pedido->id ?>" tabindex="-1" aria-labelledby="itensModalLabel<?= $pedido->id ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Itens do Pedido #<?= $pedido->id ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                <?php foreach ($pedido->itens as $item): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= htmlspecialchars($item['nome']) ?>
                                        <span class="badge bg-primary rounded-pill"><?= $item['quantidade'] ?>x</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; else: ?>
            <tr><td colspan="8" class="text-center"><p class="alert alert-info">Nenhum pedido encontrado.</p></td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
