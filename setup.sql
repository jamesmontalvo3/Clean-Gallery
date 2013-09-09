-- This was written intending to use postgresql. I'm going to switch mindset to MySQL
-- since that's what I know. Will be using PDO, so should be database agnostic

CREATE DATABASE cleangallery CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cleangallery;



CREATE TABLE IF NOT EXISTS gallery_elements (

	ge_id SERIAL,

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

	user_id BIGINT UNSIGNED NOT NULL,

	PRIMARY KEY (ge_id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS photos (

	p_id SERIAL,

	gal_elem_id BIGINT UNSIGNED NOT NULL, -- each photo points to a single gallery object

	original_filename VARCHAR(255),
	file_sha1 varchar(40) NOT NULL,
	upload_date DATETIME NOT NULL, -- time uploaded


	ori_w SMALLINT UNSIGNED,
	ori_h SMALLINT UNSIGNED,

	-- For now, just small thumb best fit on small-ish screen, and original
	h160_w SMALLINT UNSIGNED,
	fit1280x800_w SMALLINT UNSIGNED,

	-- other possible sizes
	-- h240
	-- h320
	-- best fit in 1280 x 800 ?
	-- best fit in 1600 x 1200 ? 
	-- best fit in 1024 x 758

	-- photos may be uploaded without a gallery, and need an uploader to do it
	-- in most cases photos and gallery_objects will have the same user
	-- DISREGARD
	-- Photos uploaded via application will get assigned to a gallery_object
	-- automatically. Photos uploaded via FTP will get put in the user's 
	-- "uncategorized" folder and implicitly be owned by the user due to the 
	-- FTP folder they are in.
	-- userid BIGINT UNSIGNED NOT NULL,

	PRIMARY KEY (p_id)

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

	u_id SERIAL,

	username varchar(32) NOT NULL,  -- max username length = 32 characters
	password varchar(40) NOT NULL,  -- sha1

	PRIMARY KEY (u_id)

) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS pending_media (

	id SERIAL,

	original_filename VARCHAR(255),
	file_sha1 varchar(40) NOT NULL,
	upload_date DATETIME NOT NULL, -- time uploaded

	user_id BIGINT UNSIGNED NOT NULL,

	PRIMARY KEY (id)

) ENGINE=InnoDB;
