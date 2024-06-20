CREATE TABLE plantilla(
	id SERIAL PRIMARY KEY,
	pla_cod VARCHAR,
	pla_tit VARCHAR,
	pla_tip VARCHAR(13) NOT NULL,
	pla_des TEXT,
	pla_glo BOOL,
	pla_por INTEGER,
	pla_gpr INTEGER,
	pla_mod SMALLINT DEFAULT 0,
	CHECK (pla_tip IN ('lista', 'escala', 'rubrica', 'lista+escala', 'diferencial', 'argumentario', 'mixto'))
);


CREATE TABLE mixtopla(
	id SERIAL PRIMARY KEY,
	mip_mix INTEGER,
	mip_pla INTEGER,
	mip_pos SMALLINT,
	FOREIGN KEY (mip_mix) REFERENCES plantilla(id) ON DELETE CASCADE,
	FOREIGN KEY (mip_pla) REFERENCES plantilla(id) ON DELETE CASCADE
);


CREATE TABLE dimen(
	id SERIAL PRIMARY KEY,
	dim_nom VARCHAR,
	dim_pla INTEGER,
	dim_glo BOOL,
	dim_sub INTEGER DEFAULT 0,
	dim_por INTEGER,
	dim_gpr INTEGER,
	dim_com BOOLEAN DEFAULT FALSE,
	dim_pos INTEGER,
	FOREIGN KEY (dim_pla) REFERENCES plantilla(id) ON DELETE CASCADE,
	CHECK (dim_por BETWEEN 0 AND 100)
);


CREATE TABLE subdimension(
	id SERIAL PRIMARY KEY,
	sub_cod VARCHAR,
	sub_nom VARCHAR,
	sub_dim INTEGER,
	sub_por INTEGER,
	sub_pos INTEGER,
	FOREIGN KEY (sub_dim) REFERENCES dimen(id) ON DELETE CASCADE,
	CHECK (sub_por BETWEEN 0 AND 100)
);


CREATE TABLE atributo(
	id SERIAL PRIMARY KEY,
	atr_des TEXT,
	atr_sub INTEGER,
	atr_por INTEGER,
	atr_com BOOLEAN DEFAULT FALSE,
	atr_pos INTEGER,
	FOREIGN KEY (atr_sub) REFERENCES subdimension(id) ON DELETE CASCADE,
	CHECK (atr_por BETWEEN 0 AND 100)
);

CREATE TABLE atrdiferencial(
	id SERIAL PRIMARY KEY,
	atf_atn INTEGER,
	atf_atp INTEGER,
	FOREIGN KEY (atf_atn) REFERENCES atributo(id) ON DELETE CASCADE,
	FOREIGN KEY (atf_atp) REFERENCES atributo(id) ON DELETE CASCADE
);

CREATE TABLE valoracion(
	id SERIAL PRIMARY KEY,
	val_cod VARCHAR(100) UNIQUE
);

CREATE TABLE rango(
	id SERIAL PRIMARY KEY,
	ran_cod INTEGER UNIQUE
);

CREATE TABLE atribdes(
	id SERIAL PRIMARY KEY,
	atd_atr INTEGER,
	atd_val VARCHAR(100),
	atd_des TEXT,
	FOREIGN KEY(atd_atr) REFERENCES atributo(id) ON DELETE CASCADE,
	FOREIGN KEY(atd_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE
);


CREATE TABLE dimval(
	id SERIAL PRIMARY KEY,
	div_dim INTEGER,
	div_val VARCHAR(100),
	div_ran INTEGER,
	div_pos INTEGER,
	FOREIGN KEY (div_dim) REFERENCES dimen(id) ON DELETE CASCADE,
	FOREIGN KEY (div_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE
);


CREATE TABLE ranval(
	id SERIAL PRIMARY KEY,
	rav_dim INTEGER,
	rav_val VARCHAR(100),
	rav_ran INTEGER,
	rav_pos INTEGER,
	FOREIGN KEY (rav_dim) REFERENCES dimen(id) ON DELETE CASCADE,
	FOREIGN KEY (rav_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE,
	FOREIGN KEY (rav_ran) REFERENCES rango(ran_cod) ON DELETE CASCADE
);

CREATE TABLE plaval(
	id SERIAL PRIMARY KEY,
	plv_pla INTEGER,
	plv_val VARCHAR(100),
	plv_pos INTEGER DEFAULT 0,
	FOREIGN KEY (plv_pla) REFERENCES plantilla(id) ON DELETE CASCADE,
	FOREIGN KEY (plv_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE
);


CREATE TABLE assessment(
	id SERIAL PRIMARY KEY,
	ass_id VARCHAR,
	ass_com TEXT,
	ass_grd VARCHAR,
	ass_mxg VARCHAR,
	ass_pla INTEGER,
	FOREIGN KEY (ass_pla) REFERENCES plantilla(id) ON DELETE CASCADE
);

CREATE TABLE plaeva(
	id SERIAL PRIMARY KEY,
	ple_eva INTEGER,
	ple_pla INTEGER,
	ple_val VARCHAR(100),
	ple_obs TEXT,
	FOREIGN KEY (ple_eva) REFERENCES assessment(id) ON DELETE CASCADE,
	FOREIGN KEY (ple_pla) REFERENCES plantilla(id) ON DELETE CASCADE,
	FOREIGN KEY (ple_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE
);

CREATE TABLE dimeva(
	id SERIAL PRIMARY KEY,
	die_eva INTEGER,
	die_dim INTEGER,
	die_val VARCHAR(100),
	die_ran INTEGER,
	die_obs TEXT,
	FOREIGN KEY(die_eva) REFERENCES assessment(id) ON DELETE CASCADE,
	FOREIGN KEY(die_dim) REFERENCES dimen(id) ON DELETE CASCADE,
	FOREIGN KEY(die_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE,
	FOREIGN KEY(die_ran) REFERENCES rango(ran_cod) ON DELETE CASCADE
);


CREATE TABLE atreva(
	id SERIAL PRIMARY KEY,
	ate_eva INTEGER,
	ate_atr INTEGER,
	ate_val VARCHAR(100),
	ate_ran INTEGER,
	FOREIGN KEY(ate_eva) REFERENCES assessment(id) ON DELETE CASCADE,
	FOREIGN KEY(ate_atr) REFERENCES atributo(id) ON DELETE CASCADE,
	FOREIGN KEY(ate_val) REFERENCES valoracion(val_cod) ON DELETE CASCADE,
	FOREIGN KEY(ate_ran) REFERENCES rango(ran_cod) ON DELETE CASCADE
);

CREATE TABLE atrcomment(
	id SERIAL PRIMARY KEY,
	atc_eva INTEGER,
	atc_atr INTEGER,
	atc_obs TEXT,
	FOREIGN KEY (atc_eva) REFERENCES assessment(id) ON DELETE CASCADE,
	FOREIGN KEY (atc_atr) REFERENCES atributo(id) ON DELETE CASCADE
);

CREATE TABLE dimcomment(
	id SERIAL PRIMARY KEY,
	dic_eva INTEGER,
	dic_dim INTEGER,
	dic_obs TEXT,
	FOREIGN KEY (dic_eva) REFERENCES assessment(id) ON DELETE CASCADE,
	FOREIGN KEY (dic_dim) REFERENCES dimen(id) ON DELETE CASCADE
);

CREATE TABLE config (
	id SERIAL PRIMARY KEY,
	name VARCHAR(255),
	value TEXT
);

CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	usr_nam VARCHAR(100) NOT NULL,
	usr_pss VARCHAR(255) NOT NULL,
	usr_fnm VARCHAR(100),
	usr_lnm VARCHAR(100),
	usr_eml VARCHAR(100),
	usr_phn VARCHAR(20),
	usr_enb BOOLEAN,
	usr_del BOOLEAN,
	usr_lgn BIGINT,
	usr_com TEXT,
	usr_tct BIGINT,
	usr_tmd BIGINT
);

CREATE TABLE lms (
	id SERIAL PRIMARY KEY,
	lms_nam VARCHAR(100),
	lms_des TEXT,
	lms_url TEXT,
	lms_tkn TEXT,
	lms_enb BOOLEAN
);
	
INSERT INTO config(name, value) VALUES('version', '2021062400');