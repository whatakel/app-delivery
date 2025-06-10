CREATE DATABASE delivery;
USE delivery;

-- Tabela de usuários (clientes e admins)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'adm') NOT NULL
);

-- Tabela de produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255) -- caminho da imagem (opcional)
);

-- Tabela de pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    nome_cliente VARCHAR(100),
    endereco TEXT,
    telefone VARCHAR(20),
    forma_pagamento ENUM('Dinheiro', 'Cartão', 'Pix') NOT NULL,
    status ENUM('Pendente', 'Preparando', 'Saiu para entrega', 'Entregue') DEFAULT 'Pendente',
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Itens de cada pedido (relacionamento muitos para muitos)
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_produto INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);

-- Inclusão de pedidos;
INSERT INTO pedidos (nome_cliente, endereco, telefone, forma_pagamento, data_pedido)
VALUES
('Camila', 'Rua Carlos Gomes, Centro', '41 99564-6865', 'Dinheiro', '2025-06-08'),
('Lucas Pereira', 'Av. Paraná, 123 - Jardim América', '41 99812-3344', 'Cartão de Crédito', '2025-06-07'),
('Mariana Silva', 'Rua das Flores, 450 - Centro', '41 98456-7823', 'Pix', '2025-06-07'),
('João Costa', 'Rua XV de Novembro, 85 - Centro', '41 99632-1122', 'Dinheiro', '2025-06-06'),
('Fernanda Oliveira', 'Av. das Nações, 999 - Centro', '41 99123-9988', 'Cartão de Débito', '2025-06-06'),
('Carlos Henrique', 'Rua Alfredo Bufren, 789 - Alto da Glória', '41 99991-1234', 'Pix', '2025-06-05'),
('Ana Paula', 'Rua Dom Pedro II, 456 - Boa Vista', '41 98877-6655', 'Dinheiro', '2025-06-04');