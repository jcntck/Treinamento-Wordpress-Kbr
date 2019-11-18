create table wp_inscritos (
ID bigint(20) unsigned auto_increment not null,
nome_completo varchar(50) not null,
data_nascimento date not null,
cpf varchar(11) not null,
email varchar(128) not null,
telefone varchar(10) not null,
celular varchar(11) not null,
cep varchar(8) not null,
endereco varchar(128) not null,
numero int not null,
complemento varchar(20),
bairro varchar(128) not null,
cidade varchar(128) not null,
estado varchar(128) not null,
treinamento_id bigint(20) unsigned,
code_transacao varchar(255),
status_transacao int,
created_at timestamp not null default now(),
primary key (ID)
);

ALTER TABLE wp_inscritos ADD CONSTRAINT fk_inscritos_treinamentos FOREIGN KEY ( treinamento_id ) REFERENCES wp_posts ( ID ) ON DELETE CASCADE;

desc wp_users;