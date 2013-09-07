-- this data is for testing only

INSERT INTO gallery_objects (go_id,album,title, words, `date`, user_id) VALUES 
	(1, 'mcaleer/demo','First demo pictures', 'Some words of introduction', '2013-08-02 12:00:00', 3),
	(2, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:02:00', 3),
	(3, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:04:00', 3),
	(4, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:06:00', 3),
	(5, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:08:00', 3),
	(6, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:10:00', 3),
	(7, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:12:00', 3),
	(8, 'mcaleer/demo','Second demo pictures','More introduction words', '2013-08-02 12:14:00', 3),
	(9, 'mcaleer/demo','',                    'no caption', '2013-08-02 12:16:00', 3),
	(10,'mcaleer/demo','',                    'no caption', '2013-08-02 12:18:00', 3),
	(11,'mcaleer/demo','',                    'no caption', '2013-08-02 12:20:00', 3),
	(12,'mcaleer/demo','',                    'no caption', '2013-08-02 12:22:00', 3),
	(13,'mcaleer/demo','',                    'no caption', '2013-08-02 12:24:00', 3);

INSERT INTO photos (gal_obj_id, original_filename, file_sha1, upload_date, ori_w, ori_h) VALUES 
	(2, 'IMG_1.jpg', SHA1('IMG_1.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(3, 'IMG_2.jpg', SHA1('IMG_2.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(4, 'IMG_3.jpg', SHA1('IMG_3.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(5, 'IMG_4.jpg', SHA1('IMG_4.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(6, 'IMG_5.jpg', SHA1('IMG_5.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(7, 'IMG_6.jpg', SHA1('IMG_6.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(9, 'IMG_7.jpg', SHA1('IMG_7.jpg'), '2013-08-04 15:00:00', 800, 1200),
	(10,'IMG_8.jpg', SHA1('IMG_8.jpg'), '2013-08-04 15:00:00', 1200, 800),
	(11,'IMG_9.jpg', SHA1('IMG_9.jpg'), '2013-08-04 15:00:01', 1200, 800),
	(12,'IMG_10.jpg',SHA1('IMG_10.jpg'),'2013-08-04 15:00:01', 1200, 800),
	(13,'IMG_11.jpg',SHA1('IMG_11.jpg'),'2013-08-04 15:00:01', 1200, 800);


INSERT INTO albums (path, name, description) VALUES 
	('mcaleer/demo', 'Demolition', 'Pictures of our house getting done broken');

INSERT INTO users (username, password) VALUES
	('James',SHA1('jamespass')),
	('Megan',SHA1('meganpass')),
	('Alex', SHA1('alexpass'));