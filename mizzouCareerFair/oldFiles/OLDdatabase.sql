-- mizzouCareerFair.sql for Mizzou Career Fair Application
-- creates tables in database for careerSchema

-- team x

DROP SCHEMA IF EXISTS careerSchema;
CREATE SCHEMA careerSchema;


SET search_path = careerSchema, public;


DROP TABLE IF EXISTS careerSchema.students CASCADE;
CREATE TABLE careerSchema.students (
	username	varchar(50) PRIMARY KEY,
	firstName 	varchar(50),
	lastName	varchar(50),
	degree		varchar(50),
	degreeCode	int,
	linkedIn	varchar(50),
	phoneNumber	varchar(20)
);


INSERT INTO careerSchema.graduates VALUES ('mcwrmd','Matthew','Weiner','IT',1, 'mcwrmd@mail.missouri.edu','3148008151'),('kedxw3','Kristi','Decker','IT', 1,'kedxw3@mail.missouri.edu','6183632676'),('ajlfh7', 'Adam','Lyons', 'IT', 1, 'ajlfh7@mail.missouri.edu','5739344352'),('sosb8d', 'Steven', 'Schroeder', 1, 'sosb8d@mail.missouri.edu','7089039113');


-- Table: careerSchema.graduateAuthentication
-- Columns:
--    username      - The username tied to the authentication info.
--    password_hash - The hash of the user's password + salt. Expected to be SHA1.
--    salt          - The salt to use. Expected to be a SHA1 hash of a random input.
DROP TABLE IF EXISTS careerSchema.graduateAuthentication CASCADE;
CREATE TABLE careerSchema.graduateAuthentication (
	username 		VARCHAR(30) PRIMARY KEY,
	--password_hash 	CHAR(40) NOT NULL,
	--salt 			CHAR(40) NOT NULL,
	FOREIGN KEY (username) REFERENCES careerSchema.graduates(username)
);


INSERT INTO careerSchema.graduateAuthentication VALUES ('mcwrmd'),('kedxw3');


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

INSERT INTO careerSchema.companies 
VALUES 	('3M', '3M is a global innovation company that never stops inventing. Over the years, our innovations have improved daily life for hundreds of millions of people all over the world. We have made driving at night easier, made buildings safer, and made consumer electronics lighter, less energy-intensive and less harmful to the environment. We even helped put a man on the moon. Every day at 3M, one idea always leads to the next, igniting momentum to make progress possible around the world.', 'Location: Columbia & Nevada, MO','Website: http://www.mmm.com','Bio-Medical Engineers, Chemical Engineers, Industrial Engineers, Electrical Engineers, Manufacturing Engineer, Process Engineer, Product Engineer', 'Industrial & Manufacturing Systems Engineering, Chemical Engineering, Mechanical & Aerospace Engineering', 'Full-time', 'U.S. Citizen or National'),
		('ABB, Inc.','ABB Inc.s Jefferson City facility is a major supplier of distribution transformers for the North American market. The factory includes significant production, engineering and marketing resources, as well as a full complement of operational support including supply management, quality, finance & accounting and human resources. ABB Group is a global company based in Zurich, Switzerland with over 140,000 employees worldwide. ABB is one of the worlds leading power and automation technology companies.', 'location', 'www.ABB.com', 'Electrical Engineering, Mechanical Engineering, Process Engineering, Sales Engineers, Marketing', 'Engineering, Business', 'Full-time, Internship/Coop','TBD'),			
		('Ameren', 'Ameren Corporation (NYSE:AEE) is among the nation’s largest investor-owned and gas utilities, with about $24 billion in assets. The largest electric utility in Missouri and the second largest in Illinois, Ameren companies provide energy services to 2.4 million electric and one million natural gas customers throughout its 64,000-square-mile territory.', 'St. Louis, MO', 'www.ameren.com/careers', 'Co-op/Intern Electrical Engineer (Illinois), Co-op/Intern Mechancial/Civil Engineer (Illinois) Majors: Engineering','Full-time, Internship/Coop', 'U.S. Citizen or National'),
		('Anheuser-Busch','Anheuser-Busch operates 12 breweries in the United States and several others overseas. Anheuser-Buschs operations and resources are focused on adding to lifes enjoyment not only through the responsible consumption of beer by adults, but through theme park entertainment and packaging.', 'St. Louis, MO','www.anheuser-busch.com', 'Brewery Development Program (Group Manager/Process Engineer) Co-op (May-Dec 2014 or Jan-Aug 2015)', 'Chemical Engineering, Computer Engineering, Electrical Engineering, Mechanical & Aerospace Engineering, Industrial & Manufacturing Systems Engineering','Full-time, Internship/Coop', 'U.S. Citizen or National')
		('APAC','Highway Contractor in the areas of asphalt, concrete, bridge and quarry.', 'Columbia, MO', 'apac.com', 'Summer Internship, Full-time Internship', 'Engineering')
		--INSERT INTO careerSchema.companies VALUES (1,'IBM','2810 Lemone Industrial','Columbia', 'MO', 65201),(2,'Carfax', '2301 Maguire Blvd', 'Columbia', 'MO',65201),(3, 'ATT', '909 Chestnut St', 'St.Louis', 'MO', 63101),(4, 'Xerox', '4740 Forge Rd', 'Colorado Springs', 'CO', 80907),(5, '3M Columbia', '5400 Route B', 'Columbia','MO', 65202),(6, 'Dish Network', '9601 S Meridian Blvd', 'Englewood', 'CO', 80112), (7, 'Veterans United', '1700 East Pointe Dr. Suite 201', 'Columbia', 'MO', 65201),(8, 'University of Missouri Division of IT', '615 Locust St.', 'Columbia', 'MO', 65201),(9, 'Ricoh Americas', '6300 Diagonal Hwy', 'Boulder', 'CO', 80301),(10, 'Dept. of Defense', '2700 Hercules Road', 'Annapolis Junction', 'MD', 20701),(11, 'Union Pacific', '1400 Douglas St.', 'Omaha', 'NE', 68102 ),(12,'Microsoft', '1 Microsoft Way', 'Redmond', 'WA', 98052);


--DROP TABLE IF EXISTS careerSchema.company_jobs;
--CREATE TABLE careerSchema.company_jobs (
	
--);

DROP TABLE IF EXISTS careerSchema.jobs CASCADE;
CREATE TABLE careerSchema.jobs (
	jobID		int,
	jobTitle	varchar(50),
	company		varchar(50),
	PRIMARY KEY (jobID)
);


INSERT INTO careerSchema.jobs VALUES (1, 'Entry Level Intel Analyst', 'IBM'),(2, 'Entry Software Systems Development', 'Carfax');


DROP TABLE IF EXISTS careerSchema.admin_info CASCADE;
CREATE TABLE careerSchema.admin_info (
	username			varchar(50),
	firstName			varchar(50),
	lastName			varchar(50),
	description			varchar(50),
	PRIMARY KEY (username)
);

INSERT INTO careerSchema.admin_info VALUES ('admin', 'Matt', 'Weiner', 'Original Admin to Assign Next Admin'), ('thunderkiss', 'Steven', 'Schroeder', 'Admin2'), ('littlejon', 'Adam', 'Lyons', 'Admin3');


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


INSERT INTO careerSchema.adminAuthentication VALUES ('admin'), ('thunderkiss'), ('littlejon');


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
	username 	VARCHAR(30) NOT NULL REFERENCES lab8.user_info,
	ip_address 	VARCHAR(15) NOT NULL,
	log_date 	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	action 		VARCHAR(50) NOT NULL
);

CREATE INDEX log_log_id_index ON careerSchema.log (username);
