<main class="main  container-fluid py-4">
    <div class="row">
        <!-- Coluna Principal - Cardápio -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-utensils me-2"></i>Cardápio</h4>
                </div>

                <!-- cardapio -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="lanches">
                            <div class="row">
                                <?php foreach ($produtos as $produto): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 shadow-sm position-relative text-white"
                                            style="background: url('<?= htmlspecialchars($produto['imagem']) ?>') no-repeat center center; background-size: cover;">

                                            <!-- Overlay preto -->
                                            <div style="position: absolute; top:0; left:0; right:0; bottom:0; background-color: rgba(0,0,0,0.5);"></div>

                                            <div class="card-body position-relative" style="z-index: 1;">
                                                <h5 class="card-title text-white"><?= htmlspecialchars($produto['nome']) ?></h5>
                                                <p class="card-text text-white text-muted" style="color:white !important"><?= htmlspecialchars($produto['descricao']) ?></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="h5 bg-white text-green p-1 rounded text-success mb-0">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                                                    <button class="btn-add btn btn-warning btn-sm"
                                                        onclick="addToCart('<?= htmlspecialchars($produto['nome']) ?>', <?= $produto['preco'] ?>, <?= $produto['id'] ?>)">
                                                        <i class="fas fa-plus"></i> Adicionar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Coluna Lateral - Carrinho e Formulário -->
        <div class="col-lg-4 col-md-5">
            <!-- Carrinho -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Seus Pedidos</h5>
                    <span class="badge bg-light text-dark" id="cart-count">0</span>
                </div>
                <div class="card-body">
                    <div id="cart-items">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                            <p>Seu carrinho está vazio</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total:</strong>
                        <strong class="text-success h5" id="cart-total">R$ 0,00</strong>
                    </div>
                </div>
            </div>

            <!-- Formulário de Finalização -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Finalizar Pedido
                    </h5>
                </div>
                <div class="card-body">
                    <form id="order-form" onsubmit="enviarPedido(); return false;">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="customer-name" name="nome_cliente" value="<?php echo htmlspecialchars($_SESSION['usuario']['nome'] ?? ''); ?>" disabled readonly>
                        </div>

                        <div class="mb-3">
                            <label for="customer-address" class="form-label">Endereço de Entrega</label>
                            <textarea class="form-control" id="customer-address" name="endereco" rows="3" placeholder="Rua, número, bairro, CEP" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="customer-phone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="customer-phone" name="telefone" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment-method" class="form-label">Forma de Pagamento</label>
                            <select class="form-select" id="payment-method" name="forma_pagamento" required>
                                <option value="">Selecione...</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao">Cartão</option>
                                <option value="pix">PIX</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100" id="finalize-order">
                            <i class="fas fa-check-circle me-2"></i>Finalizar Pedido
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="_public/js/enviarPedido.js"></script>

</html>