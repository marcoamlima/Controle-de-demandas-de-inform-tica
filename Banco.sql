CREATE DATABASE atendimentos_informatica;
USE atendimentos_informatica;
CREATE TABLE usuarios (
	id_usuario INT PRIMARY KEY NOT NULL IDENTITY,
	nome VARCHAR(128) NOT NULL,
	id_setor INT NOT NULL
);

CREATE TABLE setores (
	id_setor INT PRIMARY KEY NOT NULL IDENTITY,
	setor VARCHAR(128) NOT NULL
);

CREATE TABLE atendentes (
	id_atendente INT PRIMARY KEY NOT NULL IDENTITY,
	nome VARCHAR(128) NOT NULL,
);

CREATE TABLE atendimentos (
	id_demanda INT PRIMARY KEY NOT NULL IDENTITY,
	descricao_demanda VARCHAR(128) NOT NULL,
	custo FLOAT NOT NULL,
	id_usuario INT NOT NULL,
	id_atendente INT NOT NULL,
	data_cadastro DATE,
	data_previsao_atendimento DATE,
	data_termino_atendimento DATE,
	observacoes VARCHAR(500),
	status INT NOT NULL
);

INSERT INTO atendentes 
(nome)
VALUES ('Jéssica Torres'),
('Caio Mendes'),
('Maria Mendonça'),
('Cristina Machado'),
('Axel Silva'),
('Adam Lima'),
('Ana Ribeiro'),
('Isabela Monteiro'),
('Robson Peralta');

INSERT INTO setores 
(setor)
VALUES ('Almoxarifado'),
('Contabilidade'),
('Laboratório'),
('Diretoria'),
('Projeto'),
('Recursos Humanos'),
('Departamento Pessoal');

INSERT INTO usuarios 
(nome, id_setor)
VALUES 
('Maria', 3),
('Fábio',4),
('Fernando',5),
('Amanda',1),
('Luiz',2),
('Ciro',6),
('Luciana',7),
('Madalena',1),
('Rita',2),
('Safira',3),
('Silvio',4),
('João',5),
('Narciso',6),
('Marco',7),
('Luiz Augusto',1),
('Marcela',2),
('Gordiana',3),
('Geraldo',4);