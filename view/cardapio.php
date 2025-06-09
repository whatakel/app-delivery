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
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                                                <p class="card-text text-muted"><?= htmlspecialchars($produto['descricao']) ?></p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="h5 text-success mb-0">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                                                    <button class="btn-add btn btn-warning btn-sm"
                                                        onclick="addToCart('<?= htmlspecialchars($produto['nome']) ?>', <?= $produto['preco'] ?>)">
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
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>Finalizar Pedido</h5>
                </div>
                <div class="card-body">
                    <form id="order-form">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="customer-name" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer-address" class="form-label">Endereço de Entrega</label>
                            <textarea class="form-control" id="customer-address" rows="3" placeholder="Rua, número, bairro, CEP" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="payment-method" class="form-label">Forma de Pagamento</label>
                            <select class="form-select" id="payment-method" required>
                                <option value="">Selecione...</option>
                                <option value="dinheiro">Dinheiro</option>
                                <option value="cartao-credito">Cartão</option>
                                <option value="cartao-debito">Pix</option>
                                <option value="pix">PIX</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100" id="finalize-order" disabled>
                            <i class="fas fa-check-circle me-2"></i>Finalizar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    let cart = [];
    let cartTotal = 0;

    function addToCart(itemName, itemPrice) {
        const existingItem = cart.find(item => item.name === itemName);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                name: itemName,
                price: itemPrice,
                quantity: 1
            });
        }

        updateCartDisplay();
    }

    function removeFromCart(itemName) {
        const itemIndex = cart.findIndex(item => item.name === itemName);
        if (itemIndex > -1) {
            if (cart[itemIndex].quantity > 1) {
                cart[itemIndex].quantity -= 1;
            } else {
                cart.splice(itemIndex, 1);
            }
        }
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartItemsDiv = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartTotalSpan = document.getElementById('cart-total');
        const finalizeButton = document.getElementById('finalize-order');

        if (cart.length === 0) {
            cartItemsDiv.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                <p>Seu carrinho está vazio</p>
            </div>
        `;
            cartTotal = 0;
        } else {
            let itemsHtml = '';
            let totalItems = 0;
            cartTotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                cartTotal += itemTotal;
                totalItems += item.quantity;

                itemsHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                    <div class="flex-grow-1">
                        <div class="fw-bold">${item.name}</div>
                        <small class="text-muted">R$ ${item.price.toFixed(2)} cada</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn qtd-btn btn-sm btn-outline-danger me-2" onclick="removeFromCart('${item.name}')">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-2">${item.quantity}</span>
                        <button class="btn qtd-btn btn-sm btn-outline-success ms-2" onclick="addToCart('${item.name}', ${item.price})">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            `;
            });

            cartItemsDiv.innerHTML = itemsHtml;
            cartCount.textContent = totalItems;
        }

        cartTotalSpan.textContent = `R$ ${cartTotal.toFixed(2)}`;
        finalizeButton.disabled = cart.length === 0;
    }

    document.getElementById('order-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (cart.length === 0) {
            alert('Adicione itens ao seu pedido antes de finalizar!');
            return;
        }

        const name = document.getElementById('customer-name').value;
        const address = document.getElementById('customer-address').value;
        const payment = document.getElementById('payment-method').value;

        // Simulação de envio do pedido
        alert(`Pedido finalizado com sucesso!\n\nCliente: ${name}\nTotal: R$ ${cartTotal.toFixed(2)}\nPagamento: ${payment}`);

        // Limpar carrinho e formulário
        cart = [];
        updateCartDisplay();
        document.getElementById('order-form').reset();
    });
</script>

</body>

</html>