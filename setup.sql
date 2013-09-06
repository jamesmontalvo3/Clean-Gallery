-- This was written intending to use postgresql. I'm going to switch mindset to MySQL
-- since that's what I know. Will be using PDO, so should be database agnostic

CREATE DATABASE cleangallery CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cleangallery;

CREATE TABLE IF NOT EXISTS photos (
	id SERIAL,

	year VARCHAR(4) NOT NULL,
	month VARCHAR(2) NOT NULL,
	day VARCHAR(2) NOT NULL,
	hour VARCHAR(2) NOT NULL,
	minute VARCHAR(2) NOT NULL,
	second VARCHAR(2) NOT NULL,

	-- location varchar(250), -- like "mcaleer/vacation/day_1"
	album VARCHAR(250),

	words TEXT,

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

	album VARCHAR(250),

	words TEXT,

	PRIMARY KEY (id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS albums (
	path VARCHAR(250),

	-- special name for albums: defaults to folder name, but can be modified to 
	-- accept other characters
	-- if location is "mcaleer/vacation/day_1", name defaults to "day_1" but
	-- could be change do something like "Day 1" or "Vacation Day 1"
	name varchar(250),

	description text,

	PRIMARY KEY (path)

) ENGINE=InnoDB;



