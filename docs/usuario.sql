
--
-- TABLE: usuario
-- 
--  

CREATE TABLE usuario (
  id_usuario integer NOT NULL ,
  nome varchar(100) NOT NULL ,
  login varchar(20) NOT NULL ,
  n_acesso integer NOT NULL default 2 ,
  senha varchar(255) NOT NULL 
);
CREATE SEQUENCE usuario_id_usuario_seq START 1 INCREMENT 1 ;
ALTER TABLE usuario ALTER COLUMN id_usuario SET DEFAULT nextval('usuario_id_usuario_seq');

-- 
ALTER TABLE usuario ADD CONSTRAINT pk_usuario_id_usuario PRIMARY KEY (id_usuario);

-- 
ALTER TABLE usuario ADD CONSTRAINT fk_usuario_permissao_usuario_n_acesso FOREIGN KEY (n_acesso) REFERENCES permissao_usuario(id_permissao) ON UPDATE NO ACTION ON DELETE NO ACTION;

CREATE INDEX usuario_id_usuario_index  ON usuario(id_usuario);

insert into usuario (nome, login, n_acesso, senha) values ('Administrador do Sistema','admin',1,'704b037a97fa9b25522b7c014c300f8a');
insert into usuario (nome, login, senha) values ('Usuário do Sistema','usuario','f103fe68c2605040a73ed8dbeb1b65dd');
