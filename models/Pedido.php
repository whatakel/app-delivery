<?php

class Pedido {
    public $id;
    public $nome_cliente;
    public $status;
    public $forma_pagamento;
    public $data_pedido;

    public function __construct($dados) {
        $this->id = $dados['id'] ?? null;
        $this->nome_cliente = $dados['nome_cliente'] ?? '';
        $this->status = $dados['status'] ?? '';
        $this->forma_pagamento = $dados['forma_pagamento'] ?? '';
        $this->data_pedido = $dados['data_pedido'] ?? '';
    }

    public function inserirPedido($dados)
{
    $conn = Conexao::conectar();

    // Inserir o pedido
    $sql = "INSERT INTO pedidos (nome_cliente, endereco, forma_pagamento) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $dados['cliente'],
        $dados['endereco'],
        $dados['pagamento']
    ]);

    $pedidoId = $conn->lastInsertId();

    // Inserir os itens
    $sqlItem = "INSERT INTO itens_pedido (id_pedido, nome_produto, preco_unitario, quantidade) VALUES (?, ?, ?, ?)";
    $stmtItem = $conn->prepare($sqlItem);

    foreach ($dados['itens'] as $item) {
        $stmtItem->execute([
            $pedidoId,
            $item['nome'],
            $item['preco'],
            $item['quantidade']
        ]);
    }
}

}
?>