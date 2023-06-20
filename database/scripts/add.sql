-- use crmmarketing;

create table importaciones
(
idimportacion int not null auto_increment,
nombrearchivo varchar(150) not null collate utf8mb4_unicode_ci,
fecharegistro timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
cantregistros int not null default 0,
iduser int not null,
uuidimportacion char(36) collate utf8mb4_unicode_ci,
estado char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',

userinsert varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'sistemas@padinsolutions.com',
dateinsert timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
userupdate varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
dateupdate timestamp NULL ON UPDATE CURRENT_TIMESTAMP,

constraint pk_importaciones primary key (idimportacion),
constraint fk_iduser_importaciones FOREIGN KEY (iduser) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
