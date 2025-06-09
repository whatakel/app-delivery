<?php

class PedidoController {
    private $pdo;

    public function __construct(PDO $pdoConnection) {
        $this->pdo = $pdoConnection;
    }

    public function listar() {
        try {
            $sql = "SELECT id, nome_cliente, status, forma_pagamento, data_pedido FROM pedidos ORDER BY data_pedido DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erro ao listar pedidos: " . $e->getMessage());
            return [];
        }
    }

    public function pegarPedido($id) {
        try {
            $sql = "SELECT id, nome_cliente, status, forma_pagamento, data_pedido FROM pedidos WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna como array associativo para formulários
        } catch (PDOException $e) {
            error_log("Erro ao pegar pedido: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarPedido($id, $nome_cliente, $status, $forma_pagamento, $data_pedido) {
        try {
            $sql = "UPDATE pedidos SET
                        nome_cliente = :nome_cliente,
                        status = :status,
                        forma_pagamento = :forma_pagamento,
                        data_pedido = :data_pedido
                    WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':nome_cliente', $nome_cliente);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':forma_pagamento', $forma_pagamento);
            $stmt->bindParam(':data_pedido', $data_pedido);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erro ao atualizar pedido: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Altera apenas o status de um pedido.
     * @param int $id O ID do pedido.
     * @param string $novoStatus O novo status.
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public function alterarStatusPedido($id, $novoStatus) {
        try {
            $sql = "UPDATE pedidos SET status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':status', $novoStatus);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao alterar status do pedido: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Exclui um pedido do banco de dados.
     * @param int $id O ID do pedido a ser excluído.
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public function excluirPedido($id) {
        try {
            $sql = "DELETE FROM pedidos WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao excluir pedido no banco de dados: " . $e->getMessage());
            return false;
        }
    }
}
?>