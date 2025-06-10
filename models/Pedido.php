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
    public $itens;
    public $total;

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
        $this->itens = [];
        $this->total = $dados['total'] ?? 0;
    }

    public function inserirPedido($dados)
    {
        try {
            $conn = Conexao::conectar();
            if (!$conn) {
                throw new Exception("Erro ao conectar ao banco de dados");
            }

            // Inserir o pedido
            $sql = "INSERT INTO pedidos (id_usuario, nome_cliente, endereco, telefone, forma_pagamento, status, data_pedido)
                VALUES (?, ?, ?, ?, ?, 'Pendente', NOW())";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erro ao preparar a query do pedido");
            }

            $stmt->execute([
                $dados['id_usuario'],
                $dados['nome_cliente'],
                $dados['endereco'],
                $dados['telefone'],
                $dados['forma_pagamento']
            ]);

            $pedidoId = $conn->lastInsertId();
            if (!$pedidoId) {
                throw new Exception("Erro ao obter o ID do pedido inserido");
            }

            // Inserir os itens
            $sqlItem = "INSERT INTO itens_pedido (id_pedido, id_produto, nome_produto, preco_unitario, quantidade)
                    VALUES (?, ?, ?, ?, ?)";
            $stmtItem = $conn->prepare($sqlItem);
            if (!$stmtItem) {
                throw new Exception("Erro ao preparar a query dos itens");
            }

            foreach ($dados['itens'] as $item) {
                $stmtItem->execute([
                    $pedidoId,
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['quantidade']
                ]);
            }

            return $pedidoId;
        } catch (PDOException $e) {
            error_log("Erro ao inserir pedido: " . $e->getMessage());
            throw new Exception("Erro ao inserir pedido no banco de dados: " . $e->getMessage());
        }
    }

    public function listarPedidosCliente(PDO $pdo, int $idUsuario): array
    {
        try {
            $sql = "SELECT p.*, 
                    GROUP_CONCAT(CONCAT(ip.nome_produto, ':', ip.quantidade) SEPARATOR '|') as itens_info
                    FROM pedidos p
                    LEFT JOIN itens_pedido ip ON p.id = ip.id_pedido
                    WHERE p.id_usuario = :id_usuario
                    GROUP BY p.id
                    ORDER BY p.data_pedido DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id_usuario' => $idUsuario]);
            
            $pedidos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Processar os itens do pedido
                $itens = [];
                if (!empty($row['itens_info'])) {
                    $itensArray = explode('|', $row['itens_info']);
                    foreach ($itensArray as $item) {
                        list($nome, $quantidade) = explode(':', $item);
                        $itens[] = [
                            'nome' => $nome,
                            'quantidade' => $quantidade
                        ];
                    }
                }
                
                $pedidos[] = [
                    'id' => $row['id'],
                    'data_pedido' => $row['data_pedido'],
                    'status' => $row['status'],
                    'total' => $row['total'] ?? 0,
                    'forma_pagamento' => $row['forma_pagamento'],
                    'itens' => $itens
                ];
            }
            
            return $pedidos;
        } catch (PDOException $e) {
            error_log("Erro ao listar pedidos do cliente: " . $e->getMessage());
            return [];
        }
    }

    public function listarTodos(PDO $pdo): array
    {
        try {
            $sql = "SELECT p.*, 
                    GROUP_CONCAT(CONCAT(ip.nome_produto, ':', ip.quantidade) SEPARATOR '|') as itens_info,
                    SUM(ip.preco_unitario * ip.quantidade) as total
                    FROM pedidos p
                    LEFT JOIN itens_pedido ip ON p.id = ip.id_pedido
                    GROUP BY p.id
                    ORDER BY p.data_pedido DESC";
            
            $stmt = $pdo->query($sql);
            $pedidos = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Processar os itens do pedido
                $itens = [];
                if (!empty($row['itens_info'])) {
                    $itensArray = explode('|', $row['itens_info']);
                    foreach ($itensArray as $item) {
                        list($nome, $quantidade) = explode(':', $item);
                        $itens[] = [
                            'nome' => $nome,
                            'quantidade' => $quantidade
                        ];
                    }
                }
                
                $pedido = new Pedido($row);
                $pedido->itens = $itens;
                $pedido->total = $row['total'] ?? 0;
                $pedidos[] = $pedido;
            }

            return $pedidos;
        } catch (PDOException $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId(PDO $pdo, int $id): ?Pedido
    {
        try {
            $sql = "SELECT * FROM pedidos WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ? new Pedido($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro ao pegar pedido: " . $e->getMessage());
            return null;
        }
    }

    public function atualizar(PDO $pdo): bool
    {
        try {
            $sql = "UPDATE pedidos SET 
                        nome_cliente = :nome_cliente,
                        status = :status,
                        forma_pagamento = :forma_pagamento,
                        data_pedido = :data_pedido
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':nome_cliente' => $this->nome_cliente,
                ':status' => $this->status,
                ':forma_pagamento' => $this->forma_pagamento,
                ':data_pedido' => $this->data_pedido,
                ':id' => $this->id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar pedido: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarStatus(PDO $pdo, int $id, string $novoStatus): bool
    {
        try {
            $sql = "UPDATE pedidos SET status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':status' => $novoStatus, ':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao alterar status do pedido: " . $e->getMessage());
            return false;
        }
    }

    public function excluir(PDO $pdo, int $id): bool
    {
        try {
            $stmt = $pdo->prepare("DELETE FROM pedidos WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir pedido: " . $e->getMessage());
            return false;
        }
    }
}
