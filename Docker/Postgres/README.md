## Running instance sample
docker run -p 5432:5432 -d --name="postgreslibri" -v /home/loz/volumes/libri-psql:/var/lib/postgresql/data/pgdata --restart=unless-stopped  pgsql-libri -d postgres
