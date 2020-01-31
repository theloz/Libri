CREATE TABLE public.libri (
    id int PRIMARY KEY,
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
    disponibilita int
);
CREATE TABLE public.audit_trail(
    id int PRIMARY KEY,
    table_name varchar(50),
    column_name varchar(50),
    row_name int,
    change_dttm datetime,
    change_by varchar(100),
    old_value varchar(255),
    new_value varchar(255)
);