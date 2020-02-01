CREATE EXTENSION btree_gist;
CREATE EXTENSION pgcrypto;

CREATE TABLE public.libri (
    id serial PRIMARY KEY,
    codice varchar(10),
    ean13 varchar(20),
    titolo varchar(255),
    autore varchar(100),
    editore varchar(100),
    prezzo_copertina varchar(100),
    codice_collana varchar(10),
    collana varchar(100),
    argomento varchar(30),
    linea_prodotto varchar(50),
    disponibilita int,
    create_dttm timestamp,
    mod_dttm timestamp,
    create_id int,
    mod_id int
);
CREATE TABLE public.audit_trail(
    id serial PRIMARY KEY,
    table_name varchar(50),
    column_name varchar(50),
    row_name int,
    change_dttm timestamp,
    change_by varchar(100),
    old_value varchar(255),
    new_value varchar(255)
);
CREATE TABLE public.user (
    id serial PRIMARY KEY ,
    first_name varchar(250) ,
    last_name varchar(250) ,
    phone_number varchar(30) ,
    username varchar(250) UNIQUE,
    useractive varchar(5) ,
    email varchar(500) ,
    password varchar(250) ,
    authKey varchar(250) ,
    password_reset_token varchar(250) ,
    user_image varchar(500) ,
    user_level varchar(15),
    last_login timestamp,
    create_dttm timestamp,
    mod_dttm timestamp,
    create_id int,
    mod_id int
);
INSERT INTO public.user (id, first_name, last_name, phone_number, username, useractive, email, password, authKey, password_reset_token, user_image, user_level, last_login, create_dttm, mod_dttm, create_id, mod_id) 
VALUES (1, 'Lorenzo', 'Lombardi', '3283240933', 'theloz', 'yes','thelozspot@gmail.com', encode(digest('mystrongpassword', 'sha1'), 'hex'), '', '', '', 'admin', now(), now(), now(), 1, 1);
-- UPDATE public.users SET userpwd = crypt('strong!!password', (SELECT saltkey FROM public.users WHERE id=1))  WHERE id=1;
-- SELECT (userpwd = crypt('entered password', userpwd)) AS userpwd FROM users where id=1 ;