<?php

require_once './config/conexao.php';

class Pedido
{
    public $id;
    public $id_usuario;
    public $nome_cliente;
    public $endereco;
    public $telefone;
    public $forma_pagamento;
    public $status;
    public $data_pedido;

    public function __construct($dados)
    {
        $this->id = $dados['id'] ?? null;
        $this->id_usuario = $dados['id_usuario'] ?? null;
        $this->nome_cliente = $dados['nome_cliente'] ?? '';
        $this->endereco = $dados['endereco'] ?? '';
        $this->telefone = $dados['telefone'] ?? '';
        $this->forma_pagamento = $dados['forma_pagamento'] ?? '';
        $this->status = $dados['status'] ?? 'Pendente'; // default
        $this->data_pedido = $dados['data_pedido'] ?? date('Y-m-d H:i:s');
    }

    public function inserirPedido($dados)
    {
        try {
            $conn = Conexao::conectar();

            // Inserir o pedido
            $sql = "INSERT INTO pedidos (id_usuario, nome_cliente, endereco, telefone, forma_pagamento, status, data_pedido)
                VALUES (?, ?, ?, ?, ?, 'Pendente', NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $dados['id_usuario'],
                $dados['nome_cliente'],
                $dados['endereco'],
                $dados['telefone'],
                $dados['forma_pagamento']
            ]);

            $pedidoId = $conn->lastInsertId();

            // Inserir os itens
            $sqlItem = "INSERT INTO itens_pedido (id_pedido, nome_produto, preco_unitario, quantidade)
                    VALUES (?, ?, ?, ?)";
            $stmtItem = $conn->prepare($sqlItem);

            foreach ($dados['itens'] as $item) {
                $stmtItem->execute([
                    $pedidoId,
                    $item['name'],
                    $item['price'],
                    $item['quantidade']
                ]);
            }

            return $pedidoId;
        } catch (PDOException $e) {
            echo "Erro ao inserir pedido: " . $e->getMessage();
            return false;
        }
    }
}
