
--
-- TABLE: cadastro_cliforn
-- 
--  

CREATE TABLE cadastro.cadastro_cliforn (
  id serial ,
  nome varchar(200) NOT NULL ,
  endereco varchar(255) NOT NULL ,
  cpf_cnpj varchar(15) NOT NULL ,
  tipo integer NOT NULL  DEFAULT 0
);
CREATE SEQUENCE cadastro_cliforn_id_seq START 1 INCREMENT 1 ;
ALTER TABLE cadastro_cliforn ALTER COLUMN id SET DEFAULT nextval('cadastro_cliforn_id_seq');

-- 
ALTER TABLE cadastro_cliforn ADD CONSTRAINT pk_cadastro_cliforn_id PRIMARY KEY (id);

-- 
ALTER TABLE cadastro_cliforn ADD CONSTRAINT u_cadastro_cliforn_cpf_cnpj UNIQUE (cpf_cnpj);

CREATE INDEX cadastro_cliforn_id_index  ON cadastro_cliforn(id);

CREATE INDEX cadastro_cliforn_cpf_cnpj_index  ON cadastro_cliforn(cpf_cnpj);
