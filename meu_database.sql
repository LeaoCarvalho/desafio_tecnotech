CREATE DATABASE IF NOT EXISTS desafio_tecnotech;
USE desafio_tecnotech;

CREATE TABLE anuidades (
    id INT NOT NULL AUTO_INCREMENT,
    ano INT NOT NULL,
    valor INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE associados (
    id INT AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    cfp VARCHAR(25) NOT NULL UNIQUE,
    data_filiacao TIMESTAMP NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE pagamentos (
    id INT AUTO_INCREMENT,
    associado INT NOT NULL,
    anuidade INT NOT NULL,
    situacao BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id),
    FOREING KEY (associado) REFERENCES associados (id) ON DELETE CASCADE,
    FOREING KEY (anuidade) REFERENCES anuidades (id) ON DELETE CASCADE
);
