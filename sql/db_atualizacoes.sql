# Alterações realizadas no dia 19/11

# Alterações Cadatro de Usuário
ALTER TABLE usuario MODIFY cpf CHAR(11) DEFAULT NULL;
ALTER TABLE usuario MODIFY data_nascimento DATE DEFAULT NULL;

# Alterações Cadastro de Cliente
ALTER TABLE cliente ADD COLUMN status TINYINT(1) NOT NULL DEFAULT '1' AFTER ip;
ALTER TABLE cliente ADD COLUMN data_cadastro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

# Alterações de Cadastro de Cliente - Longitude e Latitude
ALTER TABLE cliente ADD COLUMN latitude VARCHAR(20) DEFAULT NULL AFTER ip;
ALTER TABLE cliente ADD COLUMN longitude VARCHAR(20) DEFAULT NULL AFTER latitude;

# Novas regras de ACL Monitoramento
INSERT INTO `perfil_regra` (`regra`,`contexto`,`descricao`) VALUES
  ('admin_monitoramento_index','Monitoramento','Listar clientes em monitoramento'),
  ('admin_monitoramento_eventos','Monitoramento','Listagem de eventos por cliente'),
  ('admin_monitoramento_resolucao','Monitoramento','Definir uma resolucao para para os eventos');