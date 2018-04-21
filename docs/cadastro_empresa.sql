
--
-- TABLE: cadastro_empresa
-- 
--  

CREATE TABLE cadastro_empresa (
  id integer NOT NULL ,
  razao_social varchar(200) NOT NULL ,
  denominacao_social varchar(200) NOT NULL ,
  endereco varchar(255) NOT NULL ,
  cpf_cnpj varchar(15) NOT NULL 
);
CREATE SEQUENCE cadastro_empresa_id_seq START 1 INCREMENT 1 ;
ALTER TABLE cadastro_empresa ALTER COLUMN id SET DEFAULT nextval('cadastro_empresa_id_seq');

-- 
ALTER TABLE cadastro_empresa ADD CONSTRAINT pk_cadastro_empresa_id PRIMARY KEY (id);

CREATE INDEX cadastro_empresa_id_index  ON cadastro_empresa(id);

CREATE INDEX cadastro_empresa_razao_social_index  ON cadastro_empresa(razao_social);

CREATE INDEX cadastro_empresa_cpf_cnpj_index  ON cadastro_empresa(cpf_cnpj);

Insert into cadastro_empresa (razao_social, denominacao_social, endereco, cpf_cnpj) values ('Teste','Teste','Rua X','11111111000191');
