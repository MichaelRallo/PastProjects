DROP TABLE IF EXISTS userTables.log;
DROP TABLE IF EXISTS userTables.authentication;
DROP TABLE IF EXISTS userTables.user_info;
DROP TABLE IF EXISTS userTables.userRatings;
DROP TABLE IF EXISTS userTables.userComments;
DROP SCHEMA IF EXISTS userTables;



CREATE SCHEMA userTables;

-- Table: userTables.user_info
-- Columns:
--    username          - The username for the account, supplied during registration.
--    registration_date - The date the user registered. Set automatically.
--    description       - A user-supplied description.
CREATE TABLE userTables.user_info (
	username 		VARCHAR(30) PRIMARY KEY,
	registration_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	description 		VARCHAR(500),
	is_admin 			boolean DEFAULT false
);

-- Table: userTables.authentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
CREATE TABLE userTables.authentication (
	username 	VARCHAR(30) PRIMARY KEY,
	password_hash 	CHAR(40) NOT NULL,
	salt 		CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES userTables.user_info(username)
);

-- Table: userTables.log
-- Columns:
--    log_id     - A unique ID for the log entry. Set by a sequence.
--    username   - The user whose action generated this log entry.
--    ip_address - The IP address of the user at the time the log was entered.
--    log_date   - The date of the log entry. Set automatically by a default value.
--    action     - What the user did to generate a log entry (i.e., "logged in").
CREATE TABLE userTables.log (
	log_id  	SERIAL PRIMARY KEY,
	username 	VARCHAR(30) NOT NULL REFERENCES userTables.user_info,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP, -- NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL
);



CREATE INDEX log_log_id_index ON userTables.log (username);


CREATE TABLE userTables.userComments (
	username 	VARCHAR(30),
	userComment	   VARCHAR(250), 
	section   	VARCHAR(250),
	log_date 	TIMESTAMP, -- NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL,
    log_id  	SERIAL,
	primary key(username, section, log_id)
);





