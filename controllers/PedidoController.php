<?php

require_once 'models/Pedido.php';

class PedidoController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listar(): array
    {
        try {
            $sql = "SELECT * FROM pedidos ORDER BY data_pedido DESC";
            $stmt = $this->pdo->query($sql);
            $pedidos = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $pedidos[] = new Pedido($row);
            }

            return $pedidos;
        } catch (PDOException $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function pegarPedido(int $id): ?Pedido
    {
        try {
            $sql = "SELECT * FROM pedidos WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $dados = $stmt->fetch(PDO::FETCH_ASSOC);
            return $dados ? new Pedido($dados) : null;
        } catch (PDOException $e) {
            error_log("Erro ao pegar pedido: " . $e->getMessage());
            return null;
        }
    }

    public function atualizarPedido(Pedido $pedido): bool
    {
        try {
            $sql = "UPDATE pedidos SET 
                        nome_cliente = :nome_cliente,
                        status = :status,
                        forma_pagamento = :forma_pagamento,
                        data_pedido = :data_pedido
                    WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':nome_cliente' => $pedido->nome_cliente,
                ':status' => $pedido->status,
                ':forma_pagamento' => $pedido->forma_pagamento,
                ':data_pedido' => $pedido->data_pedido,
                ':id' => $pedido->id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar pedido: " . $e->getMessage());
            return false;
        }
    }

    public function alterarStatusPedido(int $id, string $novoStatus): bool
    {
        try {
            $sql = "UPDATE pedidos SET status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':status' => $novoStatus, ':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao alterar status do pedido: " . $e->getMessage());
            return false;
        }
    }

    public function excluirPedido(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM pedidos WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erro ao excluir pedido: " . $e->getMessage());
            return false;
        }
    }

    public function adicionarPedido()
    {
        // Verifica se o usuário está logado e pega o id
        if (!isset($_SESSION['usuario']['id'])) {
            http_response_code(401);
            echo json_encode(['erro' => 'Usuário não autenticado']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);


        // Validação básica dos dados recebidos
        if (empty($input['nome_cliente']) || empty($input['endereco']) || empty($input['telefone']) || empty($input['forma_pagamento']) || empty($input['itens'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Dados incompletos']);
            exit;
        }

     

        $dadosPedido = [
            'id_usuario' => $_SESSION['usuario']['id'],
            'nome_cliente' => $input['nome_cliente'],
            'endereco' => $input['endereco'],
            'telefone' => $input['telefone'],
            'forma_pagamento' => $input['forma_pagamento'],
            'itens' => $input['itens']
        ];


        $pedidoId = $pedido->inserirPedido($dadosPedido);

        if ($pedidoId) {
            echo json_encode(['sucesso' => true, 'pedido_id' => $pedidoId]);
        } else {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao inserir pedido']);
        }
    }
}
