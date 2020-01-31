#port is 5432
FROM postgres:12.1
ENV POSTGRES_PASSWORD my_libri_2020
ENV POSTGRES_USER libridbuser
ENV POSTGRES_DB libri2020
ENV PGDATA /var/lib/postgresql/data/pgdata
VOLUME /var/lib/postgresql/data/pgdata

RUN localedef -i it_IT -c -f UTF-8 -A /usr/share/locale/locale.alias it_IT.UTF-8
ENV LANG it_IT.utf8

COPY init.sql /docker-entrypoint-initdb.d/
