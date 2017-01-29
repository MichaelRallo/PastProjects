DROP SCHEMA IF EXISTS imdb2 CASCADE;
CREATE SCHEMA imdb2;

SET search_path = imdb2, public;

DROP TABLE IF EXISTS actor;
CREATE TABLE actor (
	id integer PRIMARY KEY,
	fname varchar(30),
	lname varchar(30),
	gender varchar(1)
);
\copy actor from 'actor-ascii.txt' with delimiter '|' csv quote E'\n';

DROP TABLE IF EXISTS movie;
CREATE TABLE movie (
	id integer PRIMARY KEY,
	name varchar(150),
	year integer
);
\copy movie from 'movie-ascii.txt' with delimiter '|' csv quote E'\n';
DROP TABLE IF EXISTS directors;
CREATE TABLE directors (
	id integer PRIMARY KEY,
	fname varchar(30),
	lname varchar(30)
);
\copy directors from 'directors-ascii.txt' with delimiter '|' csv quote E'\n';

DROP TABLE IF EXISTS movie_directors;
CREATE TABLE movie_directors (
	did integer REFERENCES directors(id) ON DELETE CASCADE,
	mid integer REFERENCES movie(id) ON DELETE CASCADE
);
\copy movie_directors from 'movie_directors-ascii.txt' with delimiter '|' csv quote E'\n';

DROP TABLE IF EXISTS genres;
CREATE TABLE genres (
	mid integer,
	genre varchar(50)
);
\copy genres from 'genre-ascii.txt' with delimiter '|' csv quote E'\n';


DROP TABLE IF EXISTS ratings;
CREATE TABLE ratings (
	num_voters integer,
	rating float,
	name varchar(150),
	year integer
);

DROP TABLE IF EXISTS casts;
CREATE TABLE casts (
	pid integer REFERENCES actor(id) ON DELETE CASCADE,
	mid integer REFERENCES movie(id) ON DELETE CASCADE,
	role varchar(50)
);
\copy casts from 'casts-ascii.txt' with delimiter '|' csv quote E'\n';


ALTER TABLE movie ADD rating float NOT NULL DEFAULT 0;
ALTER TABLE movie ADD numRatings integer NOT NULL DEFAULT 0;

CREATE OR REPLACE FUNCTION calc_rating(float, integer, float) RETURNS float AS $$
	SELECT (((($2 - 1) * $3) + $1) / ($2)) AS rating;
$$ LANGUAGE SQL;

CREATE OR REPLACE FUNCTION calc_numRatings(integer) RETURNS integer AS $$
	SELECT ($1 + 1) AS numRatings;
$$ LANGUAGE SQL;

CREATE OR REPLACE FUNCTION update_rating() RETURNS trigger AS $$
BEGIN
    new.rating := imdb2.calc_rating(new.rating, new.numRatings, old.rating);
    return new;
END;
$$ LANGUAGE PLPGSQL;

CREATE OR REPLACE FUNCTION update_numRatings() RETURNS trigger AS $$
BEGIN
    new.numRatings := imdb2.calc_numRatings(old.numRatings);
    return new;
END;
$$ LANGUAGE PLPGSQL;

CREATE TRIGGER tr_update_ratings BEFORE INSERT OR UPDATE OF rating ON movie
    FOR EACH ROW EXECUTE PROCEDURE update_rating();

CREATE TRIGGER tr_update_numRatings BEFORE INSERT OR UPDATE OF rating ON movie
    FOR EACH ROW EXECUTE PROCEDURE update_numRatings();
