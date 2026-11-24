CREATE DATABASE IF NOT EXISTS imagem_db;
USE imagem_db;

CREATE TABLE IF NOT EXISTS produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(100),
    valor DECIMAL(10,2),
    descricao TEXT
);

CREATE TABLE IF NOT EXISTS imagens (
    id_imagem INT AUTO_INCREMENT PRIMARY KEY,
    nome_imagem VARCHAR(100),
    fk_id_produto INT,
    FOREIGN KEY (fk_id_produto) REFERENCES produtos(id_produto) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Usuário padrão para teste (E-mail: admin@email.com | Senha: 123)
INSERT INTO usuarios (nome, email, senha) 
VALUES ('Administrador', 'admin@email.com', MD5('123'));