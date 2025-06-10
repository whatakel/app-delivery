# app-delivery
Trabalho materia Desenvolvimento de software - Positivo

# Documentação do Sistema de Delivery

## Estrutura do Banco de Dados

### Tabelas

1. **usuarios**
   - `id`: INT (PK, Auto Increment)
   - `nome`: VARCHAR(100)
   - `email`: VARCHAR(100) UNIQUE
   - `senha`: VARCHAR(255)
   - `tipo`: ENUM('cliente', 'adm')

2. **produtos**
   - `id`: INT (PK, Auto Increment)
   - `nome`: VARCHAR(100)
   - `descricao`: TEXT
   - `preco`: DECIMAL(10,2)
   - `imagem`: VARCHAR(255)

3. **pedidos**
   - `id`: INT (PK, Auto Increment)
   - `id_usuario`: INT (FK)
   - `nome_cliente`: VARCHAR(100)
   - `endereco`: TEXT
   - `telefone`: VARCHAR(20)
   - `forma_pagamento`: ENUM('Dinheiro', 'Cartão', 'Pix')
   - `status`: ENUM('Pendente', 'Preparando', 'Saiu para entrega', 'Entregue')
   - `data_pedido`: TIMESTAMP

4. **itens_pedido**
   - `id`: INT (PK, Auto Increment)
   - `id_pedido`: INT (FK)
   - `id_produto`: INT (FK)
   - `quantidade`: INT
   - `preco_unitario`: DECIMAL(10,2)

## Controllers

### 1. UsuarioController
- Gerencia operações relacionadas aos usuários
- Métodos:
  - Cadastro de usuários
  - Listagem de usuários
  - Atualização de dados
  - Exclusão de usuários

### 2. LoginController
- Controla autenticação e sessões
- Métodos:
  - Login
  - Logout
  - Verificação de sessão
  - Redirecionamento baseado em perfil

### 3. PedidoController
- Gerencia pedidos do sistema
- Métodos:
  - Criação de pedidos
  - Listagem de pedidos
  - Atualização de status
  - Visualização de detalhes

### 4. ProdutoController
- Gerencia produtos do cardápio
- Métodos:
  - Cadastro de produtos
  - Listagem de produtos
  - Atualização de produtos
  - Exclusão de produtos

## Views

### 1. template.php
- Template base do sistema
- Estrutura HTML comum
- Menu de navegação
- Área de conteúdo dinâmico

### 2. login.php
- Interface de login
- Formulário de autenticação
- Mensagens de erro/sucesso

### 3. cardapio.php
- Exibição do cardápio
- Lista de produtos
- Preços e descrições
- Opções de pedido

### 4. adm_pedidos.php
- Painel administrativo de pedidos
- Lista de pedidos
- Gerenciamento de status
- Filtros e busca

### 5. clientes_pedido.php
- Interface do cliente para pedidos
- Histórico de pedidos
- Status dos pedidos
- Detalhes do pedido

### 6. usuarios.php
- Gerenciamento de usuários
- Lista de usuários
- Formulários de cadastro/edição

## Rotas (router.php)

O sistema utiliza um roteador para gerenciar as requisições:

- `/login`: Autenticação
- `/cardapio`: Visualização do cardápio
- `/pedidos`: Gerenciamento de pedidos
- `/usuarios`: Gerenciamento de usuários
- `/produtos`: Gerenciamento de produtos

## Estrutura de Diretórios

```
app-delivery/
├── config/         # Configurações do sistema
├── controllers/    # Controladores da aplicação
├── models/         # Modelos de dados
├── routes/         # Definição de rotas
├── view/           # Arquivos de visualização
├── _public/        # Arquivos públicos (CSS, JS, imagens)
├── bd.sql          # Script do banco de dados
└── index.php       # Ponto de entrada da aplicação
```

## Funcionalidades Principais

1. **Autenticação**
   - Login para clientes e administradores
   - Controle de sessão
   - Redirecionamento baseado em perfil

2. **Gerenciamento de Pedidos**
   - Criação de pedidos
   - Acompanhamento de status
   - Histórico de pedidos
   - Detalhes do pedido

3. **Cardápio**
   - Visualização de produtos
   - Preços e descrições
   - Imagens dos produtos

4. **Administração**
   - Gerenciamento de usuários
   - Controle de pedidos
   - Atualização de status
   - Relatórios

## Requisitos do Sistema

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- Extensões PHP:
  - PDO
  - MySQLi
  - GD (para manipulação de imagens)

## Instalação

1. Clone o repositório
2. Importe o arquivo `bd.sql` para criar o banco de dados
3. Configure as credenciais do banco de dados
4. Acesse o sistema através do navegador
