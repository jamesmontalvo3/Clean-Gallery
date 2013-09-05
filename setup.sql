-- This was written intending to use postgresql. I'm going to switch mindset to MySQL
-- since that's what I know. Will be using PDO, so should be database agnostic

CREATE TABLE IF NOT EXISTS photos (
	id SERIAL,

	year VARCHAR(4) NOT NULL,
	month VARCHAR(2) NOT NULL,
	day VARCHAR(2) NOT NULL,
	hour VARCHAR(2) NOT NULL,
	minute VARCHAR(2) NOT NULL,
	second VARCHAR(2) NOT NULL,

	-- location varchar(250), -- like "mcaleer/vacation/day_1"
	location VARCHAR(250),

	-- lot real,
	-- long real,

	caption TEXT,

	ori_w SMALLINT UNSIGNED,
	ori_h SMALLINT UNSIGNED,
	w_h_ratio FLOAT,

	PRIMARY KEY (id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS blocktext (

	id SERIAL,

	year VARCHAR(4) NOT NULL,
	month VARCHAR(2) NOT NULL,
	day VARCHAR(2) NOT NULL,
	hour VARCHAR(2) NOT NULL,
	minute VARCHAR(2) NOT NULL,
	second VARCHAR(2) NOT NULL,

	location VARCHAR(250),

	body TEXT,

	PRIMARY KEY (id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS albums (
	location VARCHAR(250),

	-- special name for albums: defaults to folder name, but can be modified to 
	-- accept other characters
	-- if location is "mcaleer/vacation/day_1", name defaults to "day_1" but
	-- could be change do something like "Day 1" or "Vacation Day 1"
	name varchar(250),

	description text,

	PRIMARY KEY (location)

) ENGINE=InnoDB;



