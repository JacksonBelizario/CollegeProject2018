CREATE TABLE cadastro.fluxo_caixa (
	id serial NOT NULL,
	descricao varchar(100) NULL,
	tipo char(1) NOT NULL,
	valor float8 NOT NULL,
	cliforn_id int4 NOT NULL,
	CONSTRAINT fluxo_caixa_cadastro_cliforn_fk FOREIGN KEY (cliforn_id) REFERENCES cadastro.cadastro_cliforn(id) ON DELETE SET NULL ON UPDATE CASCADE
)
WITH (
	OIDS=FALSE
) ;
CREATE INDEX fluxo_caixa_id_idx ON cadastro.fluxo_caixa (id) ;
COMMENT ON COLUMN cadastro.fluxo_caixa.tipo IS '0=receita; 1=despesa' ;
