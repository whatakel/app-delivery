<?php
require_once './config/conexao.php';
require_once './controllers/PedidoController.php';
$pdo = Conexao::conectar();
$controller = new PedidoController($pdo);
$pedidos = $controller->listarPedidosCliente();
?>

<div class="container shadow-lg p-5 rounded">
  <h2 class="mb-4">Meus Pedidos</h2>
  <table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
      <tr>
        <th>ID</th><th>Status</th><th>Pagamento</th><th>Data</th><th>Itens</th><th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($pedidos) && count($pedidos) > 0): ?>
        <?php foreach ($pedidos as $pedido): ?>
          <?php
            $statusClass = match ($pedido['status']) {
              'Pendente' => 'status-pendente',
              'Preparando' => 'status-preparando',
              'Saiu para entrega' => 'status-saiu-para-entrega',
              'Entregue' => 'status-entregue',
              default => ''
            };
          ?>
          <tr>
            <td><?= htmlspecialchars($pedido['id']) ?></td>
            <td class="<?= $statusClass ?>"><?= htmlspecialchars($pedido['status']) ?></td>
            <td><?= htmlspecialchars($pedido['forma_pagamento']) ?></td>
            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['data_pedido']))) ?></td>
            <td>
              <?php if (!empty($pedido['itens'])): ?>
                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#itensModal<?= $pedido['id'] ?>">Lista</button>
              <?php else: ?>
                Nenhum item
              <?php endif; ?>
            </td>
            <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
          </tr>

          <?php if (!empty($pedido['itens'])): ?>
            <div class="modal fade" id="itensModal<?= $pedido['id'] ?>" tabindex="-1" aria-labelledby="itensModalLabel<?= $pedido['id'] ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="itensModalLabel<?= $pedido['id'] ?>">Itens do Pedido #<?= $pedido['id'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <ul class="list-group">
                      <?php foreach ($pedido['itens'] as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <?= htmlspecialchars($item['nome']) ?>
                          <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($item['quantidade']) ?>x</span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center"><p class="alert alert-info">Nenhum pedido encontrado para exibir.</p></td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
