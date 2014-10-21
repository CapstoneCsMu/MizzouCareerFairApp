-- mizzouCareerFair.sql for Mizzou Career Fair Application
-- creates tables in database for careerSchema

-- team 4

DROP SCHEMA IF EXISTS careerSchema CASCADE;
CREATE SCHEMA careerSchema;

-- Change to careerSchema and public schema
SET search_path = careerSchema, public;

-- possibly change column name name because SQL uses that
-- Table: careerSchema.rssInfo
-- This is where RSS retrieval data is stored, company data comes from RSS
-- Columns:
--	fairID: index for RSS feed
--	rss: The URL of the RSS feed
--	fairName: name of the event Input by Admin
-- eventName: name of the event GIVEN by the XML File
--  companyName: The key/label of the RSS field that holds the company name
--  positionTypes: the key/label of the RSS field that holds the positions types
--	majors : the key/label of the RSS field that holds the majors being hired
--	location : the key/label of the RSS field that holds the location of the company
--	entryTime : timestamp from when the admin function was run to update RSS
DROP TABLE IF EXISTS careerSchema.rssinfo;
CREATE TABLE careerSchema.rssinfo(
	fairID SERIAL,
	rss varchar(2000),
	fairName varchar(200),
	eventName varchar(20),
	companyName varchar(200),
	positionTypes varchar(100),
	majors varchar(300),
	city varchar(100),
	states varchar(10),
	website varchar(150),
	citizenship varchar(100),
	category varchar(100),
	entryTime timestamp NOT NULL default CURRENT_TIMESTAMP
);

INSERT INTO rssinfo VALUES (default, 'https://rss.myinterfase.com/rss/umcolumbia_Fall_2014_Engineering_Career_Fair_-_Mobile_App_RSS_Feed.xml', '2014 Fall Engineering Career Fair','Career Event Name:', 'Organization Name:', 'Position Types:', 'Majors (click Add):', 'City:', 'State:', 'Website:', 'Citizenship:', 'Employer Category:', default);

INSERT INTO rssinfo VALUES (default, 'https://rss.myinterfase.com/rss/umcolumbia_Capstone_Project_Fall_2014_Engineering_Career_Fair_-_Copy_-_Copy.xml', '2014 Fall Engineering Career Fair-Copy', 'Career Event Name:', 'Organization Name:', 'Position Types:', 'Majors (click Add):', 'City:', 'State:', 'Website:', 'Citizenship:', 'Employer Category:', default);


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
	hash 		VARCHAR(40) NOT NULL,
	salt 			VARCHAR(50) NOT NULL,
	FOREIGN KEY (username) REFERENCES careerSchema.students(username)
);

-- test student authentication data
INSERT INTO careerSchema.studentAuthentication VALUES ('mcwrmd','826763918','58e06579e9985016bfe35caf52516ffd6038d945'),('kedxw3','826763918','33f42ae9da78e80bbb509a9af75a27b099f5574e'),('dcm53f','826763918','90f4486f60d7154516509713c2a66bc048b44891');

-- NOT IMPLEMENTED
DROP TABLE IF EXISTS careerSchema.fairs CASCADE;
CREATE TABLE careerSchema.fairs (
        careerFairID    SERIAL PRIMARY KEY,
        name            varchar(50),
        colleges        varchar(250),
        dateOf          varchar(50),
        description     varchar(500)
);

-- NOT IMPLEMENTED 
-- store company data to DB
DROP TABLE IF EXISTS careerSchema.companies CASCADE;
CREATE TABLE careerSchema.companies (
	companyID 	SERIAL PRIMARY KEY,
	careerFairID	int,
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
	contact_email   varchar(50),
	--booth		varchar(50),
	FOREIGN KEY (careerFairID) REFERENCES careerSchema.fairs(careerFairID)
);



-- NOT IMPLEMENTED
DROP TABLE IF EXISTS careerSchema.jobs CASCADE;
CREATE TABLE careerSchema.jobs (
	jobID		int PRIMARY KEY,
	companyID	int,
	careerFairID	int,
	jobTitle	varchar(50),
	company		varchar(50),
	majors		varchar(250),
	description	varchar(500),
	FOREIGN KEY (companyID) REFERENCES careerSchema.companies(companyID),
	FOREIGN KEY (careerFairID) REFERENCES careerSchema.fairs(careerFairID)
);

--NOT IMPLEMENTED
--Table to hold information on employers about their career fair information
DROP TABLE IF EXISTS careerSchema.employerInfo CASCADE;
CREATE TABLE careerSchema.employerInfo (
	username			varchar(50) PRIMARY KEY,
	booth		varchar(25),
	companyID       int,
    careerFairID    int,
	contact_name	varchar(100),
	contact_phone	varchar(25),
	contact_email	varchar(50),
	check_in	varchar(50),
	FOREIGN KEY 	(companyID) REFERENCES careerSchema.companies(companyID),
	FOREIGN KEY (careerFairID) REFERENCES careerSchema.fairs(careerFairID)
);

DROP TABLE IF EXISTS careerSchema.employerAuthentication CASCADE;
CREATE TABLE careerSchema.employerAuthentication (
	username 		VARCHAR(30) PRIMARY KEY,
	password_hash 		CHAR(40) NOT NULL,
	salt 			CHAR(40) NOT NULL,
	email varchar(50),
	ip_address varchar(40)
);

DROP TABLE IF EXISTS careerSchema.employerScannedStudents CASCADE;
CREATE TABLE careerSchema.employerScannedStudents (
	email		varchar(50) PRIMARY KEY
	
--INSERT INTO careerSchema.employerAuthentication VALUES ('a
-- NOT IMPLEMENTED
-- Table to hold admin account data
DROP TABLE IF EXISTS careerSchema.admin_info CASCADE;
CREATE TABLE careerSchema.admin_info (
	username			varchar(50) PRIMARY KEY,
	firstName			varchar(50),
	lastName			varchar(50),
	description			varchar(50)
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
	password_hash 		CHAR(40) NOT NULL,
	salt 			CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES careerSchema.admin_info(username)
);

-- test admin authentication data
--INSERT INTO careerSchema.adminAuthentication VALUES ('admin'), ('thunderkiss'), ('littlejon');


-- NOT IMPLEMENTED
-- Table: careerSchema.log
-- Columns:
--    log_id     - A unique ID for the log entry. Set by a sequence.
--    username   - The user whose action generated this log entry.
--    ip_address - The IP address of the user at the time the log was entered.
--    log_date   - The date of the log entry. Set automatically by a default value.
--    action     - What the user did to generate a log entry (i.e., "logged in").
DROP TABLE IF EXISTS careerSchema.log CASCADE;
CREATE TABLE careerSchema.log (
	log_id  	SERIAL PRIMARY KEY,
	username 	VARCHAR(30) NOT NULL,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL
);

CREATE INDEX log_log_id_index ON careerSchema.log (username);
