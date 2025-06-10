<?php

require_once 'models/Pedido.php';

class PedidoController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listarPedidosCliente(): array
    {
        if (!isset($_SESSION['usuario']['id'])) {
            return [];
        }

        $pedido = new Pedido([]);
        return $pedido->listarPedidosCliente($this->pdo, $_SESSION['usuario']['id']);
    }

    public function listar(): array
    {
        $pedido = new Pedido([]);
        return $pedido->listarTodos($this->pdo);
    }

    public function pegarPedido(int $id): ?Pedido
    {
        $pedido = new Pedido([]);
        return $pedido->buscarPorId($this->pdo, $id);
    }

    public function atualizarPedido(Pedido $pedido): bool
    {
        return $pedido->atualizar($this->pdo);
    }

    public function alterarStatusPedido(int $id, string $novoStatus): bool
    {
        $pedido = new Pedido([]);
        return $pedido->atualizarStatus($this->pdo, $id, $novoStatus);
    }

    public function excluirPedido(int $id): bool
    {
        $pedido = new Pedido([]);
        return $pedido->excluir($this->pdo, $id);
    }

    public function adicionarPedido()
    {
        header('Content-Type: application/json');
        
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

        // Validação do telefone
        if (!preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $input['telefone'])) {
            http_response_code(400);
            echo json_encode(['erro' => 'Formato de telefone inválido']);
            exit;
        }

        try {
            $dadosPedido = [
                'id_usuario' => $_SESSION['usuario']['id'],
                'nome_cliente' => $input['nome_cliente'],
                'endereco' => $input['endereco'],
                'telefone' => $input['telefone'],
                'forma_pagamento' => $input['forma_pagamento'],
                'itens' => $input['itens']
            ];

            $pedido = new Pedido($dadosPedido);
            $pedidoId = $pedido->inserirPedido($dadosPedido);

            if ($pedidoId) {
                echo json_encode(['sucesso' => true, 'pedido_id' => $pedidoId]);
            } else {
                http_response_code(500);
                echo json_encode(['erro' => 'Erro ao inserir pedido']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao processar pedido: ' . $e->getMessage()]);
        }
    }

    public function gerenciarPedidosAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'])) {
            $id = (int)$_POST['pedido_id'];
            if (isset($_POST['status'])) {
                $sucesso = $this->alterarStatusPedido($id, $_POST['status']);
                $_SESSION['msg_' . ($sucesso ? 'sucesso' : 'erro')] = "Status do pedido " . ($sucesso ? "atualizado" : "não pôde ser atualizado") . "!";
            } else {
                $sucesso = $this->excluirPedido($id);
                $_SESSION['msg_' . ($sucesso ? 'sucesso' : 'erro')] = "Pedido " . ($sucesso ? "excluído" : "não pôde ser excluído") . "!";
            }
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        return [
            'pedidos' => $this->listar(),
            'mensagem' => $this->getMensagem()
        ];
    }

    private function getMensagem()
    {
        if (!empty($_SESSION['msg_sucesso'])) {
            $mensagem = "<div class='alert alert-success'>{$_SESSION['msg_sucesso']}</div>";
            unset($_SESSION['msg_sucesso']);
            return $mensagem;
        } elseif (!empty($_SESSION['msg_erro'])) {
            $mensagem = "<div class='alert alert-danger'>{$_SESSION['msg_erro']}</div>";
            unset($_SESSION['msg_erro']);
            return $mensagem;
        }
        return '';
    }
}
