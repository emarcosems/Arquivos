CREATE  TABLE dim_institution ( 
	id_institution                  integer PRIMARY KEY ,
	name                 varchar(100)   
  );


CREATE  TABLE dim_scheduler ( 
	id_scheduler      integer   PRIMARY KEY,
	name                 varchar(100)   
);



CREATE  TABLE dim_cluster ( 
	id_cluster           integer PRIMARY KEY  ,
	name                 varchar(255)  ,
	num_cores            integer  
);



CREATE  TABLE dim_queue ( 
	id_queue             integer   PRIMARY KEY ,
	name                 varchar(100) ,
    num_cores_fila       integer
);

CREATE  TABLE dim_platform ( 
	id_platform         integer PRIMARY KEY    ,
	name                 varchar(255)   
 );



CREATE  TABLE dim_algorithm_type ( 
	id_algorithm_type            integer PRIMARY KEY  ,
	algorithm_type       varchar(100)
 );



CREATE  TABLE dim_application ( 
	id_application       integer PRIMARY KEY ,
	name_application varchar (100),
	name_version varchar (100),
    num_cores_requested integer
 );



 CREATE  TABLE dim_gateway ( 
	id_gateway           integer PRIMARY KEY ,
	name                 varchar(255)   
 );
 

CREATE  TABLE dim_country ( 
	id_country                   integer PRIMARY KEY ,
	name                 varchar(100)
 );
 

 
CREATE  TABLE dim_user_bioinfo ( 
	id_user                   integer PRIMARY KEY  ,
	email                varchar(255));


CREATE  TABLE dim_file ( 
	id_file                   integer  PRIMARY KEY ,
	"path"               varchar(500),
	 size                 int,
	input_file           boolean
);



CREATE  TABLE dim_tempo (
id_tempo     bigint  PRIMARY KEY ,
date timestamp without time zone

);


CREATE  TABLE dim_status ( 
	id_status                   bigserial  PRIMARY KEY ,
	status               varchar(500)
);

CREATE  TABLE dim_job ( 
	id_job bigint  PRIMARY KEY,
	id_web               varchar(255),
	id_csgrid            varchar(255)
);


CREATE  TABLE fato_execution ( 
	id_user              integer  NOT NULL,
	id_job 				integer  NOT NULL,
	id_file              integer NOT NULL,
	id_application              integer  NOT NULL,
	id_tempo              integer  NOT NULL,
	id_cluster              integer  NOT NULL,
	id_gateway              integer  NOT NULL,
	id_platform              integer  NOT NULL,
	id_queue              integer  NOT NULL,
	id_scheduler              integer  NOT NULL,
	id_algorithm_type              integer NOT NULL,
	id_country              integer NOT NULL,
	id_institution 	integer  NOT NULL,
	id_status integer  NOT NULL,
	cpu_time int,
	start_time text,
	end_time text,
	parameters        text,
	quantidade integer DEFAULT 1,
	CONSTRAINT fk_dim_user_bioinfo FOREIGN KEY (id_user) REFERENCES dim_user_bioinfo (id_user),
	CONSTRAINT fk_dim_file FOREIGN KEY (id_file) REFERENCES dim_file (id_file),
	CONSTRAINT fk_dim_application FOREIGN KEY (id_application) REFERENCES dim_application (id_application),
	CONSTRAINT fk_dim_tempo FOREIGN KEY (id_tempo) REFERENCES dim_tempo (id_tempo),
	CONSTRAINT fk_dim_cluster FOREIGN KEY (id_cluster) REFERENCES dim_cluster (id_cluster),
	CONSTRAINT fk_dim_gateway FOREIGN KEY (id_gateway) REFERENCES dim_gateway (id_gateway),
	CONSTRAINT fk_dim_platform FOREIGN KEY (id_platform) REFERENCES dim_platform (id_platform),
	CONSTRAINT fk_dim_queue FOREIGN KEY (id_queue) REFERENCES dim_queue (id_queue),
	CONSTRAINT fk_dim_scheduler FOREIGN KEY (id_scheduler) REFERENCES dim_scheduler (id_scheduler),
	CONSTRAINT fk_dim_algorithm_type FOREIGN KEY (id_algorithm_type ) REFERENCES dim_algorithm_type (id_algorithm_type ),
	CONSTRAINT fk_dim_country FOREIGN KEY (id_country) REFERENCES dim_country (id_country),
	CONSTRAINT fk_dim_institution FOREIGN KEY (id_institution ) REFERENCES dim_institution(id_institution ),
	CONSTRAINT fk_dim_status FOREIGN KEY (id_status ) REFERENCES dim_status(id_status ),
	CONSTRAINT fk_dim_job FOREIGN KEY (id_job) REFERENCES dim_job (id_job)
	
);



