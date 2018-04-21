
--
-- TABLE: permissao_usuario
-- 
--  

CREATE TABLE permissao_usuario (
  id_permissao integer NOT NULL ,
  descricao varchar(100) NOT NULL ,
  permissoes char(10) NOT NULL 
);
CREATE SEQUENCE permissao_usuario_id_permissao_seq START 1 INCREMENT 1 ;
ALTER TABLE permissao_usuario ALTER COLUMN id_permissao SET DEFAULT nextval('permissao_usuario_id_permissao_seq');

-- 
ALTER TABLE permissao_usuario ADD CONSTRAINT pk_permissao_usuario_id_permissao PRIMARY KEY (id_permissao);

CREATE INDEX permissao_usuario_id_permissao_index  ON permissao_usuario(id_permissao);

insert into permissao_usuario (descricao,permissoes) values ('Administrador','1111111111');
insert into permissao_usuario (descricao,permissoes) values ('Usuário','0000000000');
