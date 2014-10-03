-- mizzouCareerFair.sql for Mizzou Career Fair Application
-- creates tables in database for careerSchema

-- team 4

DROP SCHEMA IF EXISTS careerSchema CASCADE;
CREATE SCHEMA careerSchema;

--User Type : Student, Employer, Admin
-- Change to careerSchema and public schema
SET search_path = careerSchema, public;

DROP TABLE IF EXISTS careerSchema.authorizationTable
CREATE TABLE careerSchema.authorizationTable(
	email varchar(50) PRIMARY KEY NOT NULL,
        	hashed_pass            varchar(40) NOT NULL,
        	salt                    varchar(50) NOT NULL,
	ip_address varchar(40),
	user_type varchar(40),
	linkedin_id varchar(40)
);


-- possibly change column name name because SQL uses that
-- Table: careerSchema.rssInfo
-- This is where RSS retrieval data is stored, company data comes from RSS
-- Columns:
--      fairID: index for RSS feed
--      rss: The URL of the RSS feed
--      fairName: name of the event Input by Admin
-- eventName: name of the event GIVEN by the XML File
--  companyName: The key/label of the RSS field that holds the company name
--  positionTypes: the key/label of the RSS field that holds the positions types
--      majors : the key/label of the RSS field that holds the majors being hired
--      location : the key/label of the RSS field that holds the location of the company
--      entryTime : timestamp from when the admin function was run to update RSS
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


-- Table to hold student information.
DROP TABLE IF EXISTS careerSchema.students CASCADE;
CREATE TABLE careerSchema.students (
        email       varchar(50) PRIMARY KEY,
        firstName       varchar(50),
        lastName        varchar(50),
        degree          varchar(50),
        major		 varchar(50),
        phoneNumber     varchar(20),
        resume 		varchar(50),
        gradDate 	varchar(30),
        resume 		varchar(5),
        lifePlan 		varchar(200),
        linkedin_id 	varchar(50),
        FOREIGN KEY (email) REFERENCES careerSchema.authorizationTable(email)

);







































