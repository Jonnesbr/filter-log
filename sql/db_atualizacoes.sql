# Alterações realizadas no dia 19/11

# Alterações Cadatro de Usuário
ALTER TABLE usuario MODIFY cpf CHAR(11) DEFAULT NULL;
ALTER TABLE usuario MODIFY data_nascimento DATE DEFAULT NULL;

# Alterações Cadastro de Cliente
ALTER TABLE cliente ADD COLUMN status TINYINT(1) NOT NULL DEFAULT '1' AFTER ip;
ALTER TABLE cliente ADD COLUMN data_cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

