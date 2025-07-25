CREATE DATABASE avaliacao_sodre;

USE avaliacao_sodre;

CREATE TABLE cargos_funcionarios (
    id_cargo INT AUTO_INCREMENT PRIMARY KEY,
    nome_cargo VARCHAR(100) NOT NULL
);

CREATE TABLE funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome_funcionario VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    salario DECIMAL(10, 2) NOT NULL,
    cargo_id INT NOT NULL,
    FOREIGN KEY (cargo_id) REFERENCES cargos_funcionarios (id_cargo)
);