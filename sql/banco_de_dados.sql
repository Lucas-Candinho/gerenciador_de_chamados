CREATE DATABASE gerenciador_de_chamados;
USE gerenciador_de_chamados;

CREATE TABLE cliente (
	id_cliente INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome_cliente VARCHAR(115) NOT NULL,
    senha_cliente VARCHAR(115) NOT NULL,
    ultimo_nome_cliente VARCHAR(115) NOT NULL,
    cpf_cliente VARCHAR(11) NOT NULL,
    telefone_cliente VARCHAR(13) NOT NULL, -- 5547987654321
    email_cliente VARCHAR(115) NOT NULL
);

CREATE TABLE colaborador (
	id_colaborador INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nome_colaborador VARCHAR(115) NOT NULL,
	ultimo_nome_colaborador VARCHAR(115) NOT NULL,
    matricula_colaborador VARCHAR(45) NOT NULL,
    email_colaborador VARCHAR(115) NOT NULL,
    senha_colaborador VARCHAR(115) NOT NULL,
    nivel_controle_colaborador ENUM('normal', 'gerencia', 'administracao')
);

CREATE TABLE chamado (
	id_chamado INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_cliente_chamado INT NOT NULL,
    FOREIGN KEY (id_cliente_chamado) REFERENCES cliente(id_cliente) ON DELETE CASCADE,
    descricao_chamado VARCHAR(500) NOT NULL,
    criticidade_chamado ENUM('baixa', 'média', 'alta') NOT NULL,
    status_chamado ENUM('aberto', 'em andamento', 'resolvido') NOT NULL,
    data_abertura_chamado DATETIME NOT NULL,
    id_colaborador_responsavel_chamado INT, -- Opcional
	FOREIGN KEY (id_colaborador_responsavel_chamado) REFERENCES colaborador(id_colaborador) ON DELETE SET NULL
);

/*
INSERT INTO colaborador 
VALUES (1, "João", "Magalhães", "3X84K", "j_magalhaes@wtech.com", "#Arcane2Temporada", "administracao"),
(2, "Arthur", "dos Santos", "8J72B", "a_dosSantos@wtech.com", "@piririm12", "gerencia"),
(3, "Otávio", "Soares", "3P41M", "o_soares@wtech.com", "72kEhPouco!", "normal");
*/
