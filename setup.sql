-- This was written intending to use postgresql. I'm going to switch mindset to MySQL
-- since that's what I know. Will be using PDO, so should be database agnostic

CREATE DATABASE cleangallery CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cleangallery;



CREATE TABLE IF NOT EXISTS gallery_objects (

	id SERIAL,

	album VARCHAR(250),

	date DATETIME NOT NULL,
	-- year VARCHAR(4) NOT NULL,
	-- month VARCHAR(2) NOT NULL,
	-- day VARCHAR(2) NOT NULL,
	-- hour VARCHAR(2) NOT NULL,
	-- minute VARCHAR(2) NOT NULL,
	-- second VARCHAR(2) NOT NULL,

	title VARCHAR(255),
	words TEXT,

	userid BIGINT UNSIGNED NOT NULL,

	PRIMARY KEY (id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS photos (

	gal_obj_id BIGINT UNSIGNED NOT NULL, -- each photo points to a single gallery object

	original_filename VARCHAR(255),
	file_sha1 varchar(40) NOT NULL,
	upload_date DATETIME NOT NULL, -- time uploaded

	ori_w SMALLINT UNSIGNED,
	ori_h SMALLINT UNSIGNED,

	-- photos may be uploaded without a gallery, and need an uploader to do it
	-- in most cases photos and gallery_objects will have the same user
	-- DISREGARD
	-- Photos uploaded via application will get assigned to a gallery_object
	-- automatically. Photos uploaded via FTP will get put in the user's 
	-- "uncategorized" folder and implicitly be owned by the user due to the 
	-- FTP folder they are in.
	-- userid BIGINT UNSIGNED NOT NULL,

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



CREATE TABLE IF NOT EXISTS users (

	id SERIAL,

	username varchar(32) NOT NULL,  -- max username length = 32 characters
	password varchar(40) NOT NULL,  -- sha1

) ENGINE=InnoDB;

