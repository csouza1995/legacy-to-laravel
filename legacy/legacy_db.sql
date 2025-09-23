CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cnpj VARCHAR(14) NOT NULL,
    email VARCHAR(255) NULL,
    criado_em DATETIME NOT NULL
);
CREATE UNIQUE INDEX ux_fornecedores_cnpj ON fornecedores(cnpj);