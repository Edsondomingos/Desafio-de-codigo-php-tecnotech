CREATE DATABASE anuidade_associados;

use anuidade_associados;

CREATE TABLE associado (
    id_associado INT not null AUTO_INCREMENT PRIMARY key,
    nome_associado VARCHAR(70) not null,
    email_associado VARCHAR(100) not null,
    cpf_associado VARCHAR(15) not null,
    data_afiliacao_associado DATE not null
);

CREATE TABLE anuidade (
    id_anuidade INT not null AUTO_INCREMENT PRIMARY key,
    ano_anuidade VARCHAR(70) not null,
    valor_anuidade DECIMAL(7,2) not null
);

CREATE TABLE anuidade_associado (
    id_anuidade_associado INT not null AUTO_INCREMENT PRIMARY key,
    ano_anuidade_associado VARCHAR(70) not null,
    situacao_anuidade_associado TINYINT(1) not null,
    id_associado INT,
    FOREIGN KEY (id_associado) REFERENCES associado(id_associado)
);
    