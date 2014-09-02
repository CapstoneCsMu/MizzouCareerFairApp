-- mizzouCareerFair.sql for Mizzou Career Fair Application
-- creates tables in database for careerSchema

-- team x

DROP SCHEMA IF EXISTS careerSchema;
CREATE SCHEMA careerSchema;

-- Change to careerSchema and public schema
SET search_path = careerSchema, public;

-- possibly change column name name because SQL uses that
-- Table: careerSchema.rssInfo
-- This is where RSS retrieval data is stored, company data comes from RSS
-- Columns:
--	rss: The URL of the RSS feed
--  name: The key/label of the RSS field that holds the company name
--  positionsAvailable: the key/label of the RSS field that holds the positions available
--	majors : the key/label of the RSS field that holds the majors being hired
--  position types : the key/label of the RSS field that holds the position types
-- 	location : the key/label of the RSS field that holds the location of the company
-- 	entryTime : timestamp from when the admin function was run to update RSS
DROP TABLE IF EXISTS careerSchema.rssinfo;
CREATE TABLE careerSchema.rssinfo(
	rss varchar(2000),
	name varchar(50),
	positionsAvailable varchar(300),
	majors varchar(300),
	positionTypes varchar(50),
	location varchar(50),
	entryTime timestamp NOT NULL default CURRENT_TIMESTAMP
);


-- NOT IMPLEMENTED
-- Table to hold student information.
DROP TABLE IF EXISTS careerSchema.students CASCADE;
CREATE TABLE careerSchema.students (
	username	varchar(50) PRIMARY KEY,
	firstName 	varchar(50),
	lastName	varchar(50),
	degree		varchar(50),
	degreeCode	int,
	email		varchar(50),
	phoneNumber	varchar(20),
	
	-- Personal Account ID from linkedin login
	linkedIn	varchar(50)
);

-- test student data
INSERT INTO careerSchema.students VALUES ('mcwrmd','Matthew','Weiner','IT',1, 'mcwrmd@mail.missouri.edu','3148008151'),('kedxw3','Kristi','Decker','IT', 1,'kedxw3@mail.missouri.edu','6183632676'),('ajlfh7', 'Adam','Lyons', 'IT', 1, 'ajlfh7@mail.missouri.edu','5739344352'),('sosb8d', 'Steven', 'Schroeder', 'CS', 2, 'sosb8d@mail.missouri.edu','7089039113');


-- NOT IMPLEMENTED 
-- Table: careerSchema.graduateAuthentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
DROP TABLE IF EXISTS careerSchema.studentAuthentication CASCADE;
CREATE TABLE careerSchema.studentAuthentication (
	username 		VARCHAR(30) PRIMARY KEY,
	--password_hash 	CHAR(40) NOT NULL,
	--salt 			CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES careerSchema.students(username)
);

-- test student authentication data
INSERT INTO careerSchema.studentAuthentication VALUES ('mcwrmd'),('kedxw3');


-- NOT IMPLEMENTED 
-- store company data to DB
DROP TABLE IF EXISTS careerSchema.companies CASCADE;
CREATE TABLE careerSchema.companies (
	companyID 	SERIAL,
	name 		varchar(50),
	description	varchar(500),
	location 	varchar(50),
	--city 		varchar(50),
	--state		varchar(20),
	--zipcode 	int,
	--recruiter	varchar(50),
	website		varchar(50),
	positions	varchar(250),
	majors		varchar(250),
	posType		varchar(50),
	citizenReq	varchar(50),
	--booth		varchar(50),
	PRIMARY KEY (companyID)
);



-- NOT IMPLEMENTED
DROP TABLE IF EXISTS careerSchema.jobs CASCADE;
CREATE TABLE careerSchema.jobs (
	jobID		int,
	jobTitle	varchar(50),
	company		varchar(50),
	PRIMARY KEY (jobID)
);


-- NOT IMPLEMENTED
-- Table to hold admin account data
DROP TABLE IF EXISTS careerSchema.admin_info CASCADE;
CREATE TABLE careerSchema.admin_info (
	username			varchar(50),
	firstName			varchar(50),
	lastName			varchar(50),
	description			varchar(50),
	PRIMARY KEY (username)
);

-- test Admin data
INSERT INTO careerSchema.admin_info VALUES ('admin', 'Matt', 'Weiner', 'Original Admin to Assign Next Admin'), ('thunderkiss', 'Steven', 'Schroeder', 'Admin2'), ('littlejon', 'Adam', 'Lyons', 'Admin3');


-- NOT IMPLEMENTED
-- Table: careerSchema.adminAuthentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
DROP TABLE IF EXISTS careerSchema.adminAuthentication CASCADE;
CREATE TABLE careerSchema.adminAuthentication (
	username 		VARCHAR(30) PRIMARY KEY,
--	password_hash 	CHAR(40) NOT NULL,
--	salt 			CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES careerSchema.admin_info(username)
);

-- test admin authentication data
INSERT INTO careerSchema.adminAuthentication VALUES ('admin'), ('thunderkiss'), ('littlejon');


-- NOT IMPLEMENTED
-- Table: careerSchema.log
-- Columns:
--    log_id     - A unique ID for the log entry. Set by a sequence.
--    username   - The user whose action generated this log entry.
--    ip_address - The IP address of the user at the time the log was entered.
--    log_date   - The date of the log entry. Set automatically by a default value.
--    action     - What the user did to generate a log entry (i.e., "logged in").
DROP TABLE careerSchema.log CASCADE;
CREATE TABLE careerSchema.log (
	log_id  	SERIAL PRIMARY KEY,
	username 	VARCHAR(30) NOT NULL,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL
);

CREATE INDEX log_log_id_index ON careerSchema.log (username);