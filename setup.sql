-- This was written intending to use postgresql. I'm going to switch mindset to MySQL
-- since that's what I know. Will be using PDO, so should be database agnostic

CREATE TABLE photos (
	id serial PRIMARY KEY,
	

	year smallint,
	month smallint,
	day smallint,
	hour smallint,
	minute smallint,
	second smallint,

	-- location varchar(250), -- like "mcaleer/vacation/day_1"
	location references albums(location),

	lot real,
	long real,

	caption text,

	ori_w smallint,
	ori_h smallint,
	w_h_ratio real

);

CREATE TABLE blocktext (

	id serial PRIMARY KEY,

	year smallint,
	month smallint,
	day smallint,
	hour smallint,
	minute smallint,
	second smallint,

	location references albums(location),

	body text
);


CREATE TABLE albums (
	location varchar(250) PRIMARY KEY,

	-- special name for albums: defaults to folder name, but can be modified to 
	-- accept other characters
	-- if location is "mcaleer/vacation/day_1", name defaults to "day_1" but
	-- could be change do something like "Day 1" or "Vacation Day 1"
	name varchar(250),

	description text

);



