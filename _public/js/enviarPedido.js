let cart = [];
let cartTotal = 0;

// Phone mask implementation
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('customer-phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            // Limita a 11 dígitos
            value = value.substring(0, 11);
            if (value.length > 0) {
                // Formata como (XX) XXXXX-XXXX
                value = value.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });
    }
});

// validacao telefone
function validatePhone(phone) {
    const phoneRegex = /^\(\d{2}\) \d{5}-\d{4}$/;
    return phoneRegex.test(phone);
}

function addToCart(itemName, itemPrice, itemId) {
    // Procura o item no carrinho pelo nome
    const index = cart.findIndex(item => item.name === itemName);

    if (index !== -1) {
        // Se existir, incrementa a quantidade
        cart[index].quantidade = (cart[index].quantidade || 1) + 1;
    } else {
        // Se não existir, adiciona com quantidade 1
        cart.push({
            id: itemId,
            name: itemName,
            price: itemPrice,
            quantidade: 1
        });
    }

    updateCartDisplay();
}

function removeFromCart(index) {
    if (index >= 0 && index < cart.length) {
        cart.splice(index, 1);
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

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantidade;
            cartTotal += itemTotal;
            totalItems += item.quantidade;

            itemsHtml += `
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                    <div class="flex-grow-1">
                        <div class="fw-bold">${item.name}</div>
                        <small class="text-muted">R$ ${item.price.toFixed(2)} x ${item.quantidade}</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn qtd-btn btn-sm btn-outline-danger me-2" onclick="removeFromCart(${index})">
                            <i class="fas fa-minus"></i>
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

// empacotar e enviar o requisicao para criar pedido
function enviarPedido() {
    const nomeCliente = document.getElementById('customer-name').value;
    const endereco = document.getElementById('customer-address').value;
    const telefone = document.getElementById('customer-phone').value;
    const formaPagamento = document.getElementById('payment-method').value;

    if (cart.length === 0) {
        alert('Adicione itens ao seu pedido antes de finalizar!');
        return false;
    }

    if (!validatePhone(telefone)) {
        alert('Por favor, insira um número de telefone válido no formato (00) 00000-0000');
        return false;
    }

    const pedido = {
        nome_cliente: nomeCliente,
        endereco: endereco,
        telefone: telefone,
        forma_pagamento: formaPagamento,
        itens: cart
    };

    fetch('index.php?pagina=pedido/adicionar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(pedido)
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Resposta do servidor não é JSON válido');
        }
        return response.json();
    })
    .then(data => {
        if (data.sucesso) {
            alert('Pedido criado com sucesso! ID: ' + data.pedido_id);
            cart = [];
            updateCartDisplay();
            document.getElementById('order-form').reset();
        } else {
            alert('Erro: ' + (data.erro || 'Erro desconhecido'));
        }
    })
    .catch(err => {
        console.error('Erro:', err);
        alert('Erro ao processar o pedido. Por favor, tente novamente.');
    });

    return false;
}