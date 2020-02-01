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
CREATE TABLE public.users(
    id serial PRIMARY KEY,
    username varchar(100),
    saltkey varchar(50),
    userpwd varchar(100),
    userrole varchar(20),
    lastlogin_dttm timestamp,
    userfirstname varchar(100),
    userlastname varchar(100),
    create_dttm timestamp,
    mod_dttm timestamp,
    create_id int,
    mod_id int
);
INSERT INTO public.users (id,username,saltkey,userrole,lastlogin_dttm,userfirstname,userlastname,create_dttm,mod_dttm,create_id,mod_id) 
VALUES (1,'theloz',gen_salt('bf'),'admin',NOW(),'Lorenzo', 'Lombardi',NOW(),NOW(),1,1);
UPDATE public.users SET userpwd = crypt('strong!!password', (SELECT saltkey FROM public.users WHERE id=1))  WHERE id=1;
-- SELECT (userpwd = crypt('entered password', userpwd)) AS userpwd FROM users where id=1 ;