<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


require_once './config/conexao.php'; // Ajuste o caminho conforme sua estrutura
require_once './models/Pedido.php';

// Exemplo de instância de teste:
$pedido = new Pedido([]);

$dadosTeste = [
    'id_usuario' => 1, // Ajuste para um usuário válido do seu sistema
    'nome_cliente' => 'Teste Cliente',
    'endereco' => 'Rua Teste, 123',
    'telefone' => '999999999',
    'forma_pagamento' => 'Dinheiro',
    'itens' => [
        ['name' => 'Produto 1', 'price' => 10, 'quantidade' => 2],
        ['name' => 'Produto 2', 'price' => 15, 'quantidade' => 1]
    ]
];

$id = $pedido->inserirPedido($dadosTeste);

if ($id) {
    echo "✅ Pedido inserido com ID: $id";
} else {
    echo "❌ Erro ao inserir pedido.";
}
?>
