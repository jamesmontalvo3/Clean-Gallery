-- this data is for testing only

INSERT INTO photos (year,month,day,hour,minute,second,album,words,ori_w,ori_h,w_h_ratio) VALUES 
	('2013','08','05','12','00','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','01','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','02','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','03','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','04','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','05','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','06','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','07','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','08','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','09','00','mcaleer/demo','no caption',1200,800,.66667),
	('2013','08','05','12','10','00','mcaleer/demo','no caption',1200,800,.66667);

INSERT INTO blocktext (year,month,day,hour,minute,second,album,words) VALUES 
	('2013','08','05','11','00','00','mcaleer/demo','This is a whole bunch of awesome text'  ),
	('2013','08','05','12','03','01','mcaleer/demo','This is a whole bunch of awesome text 2'),
	('2013','08','05','12','05','00','mcaleer/demo','This is a whole bunch of awesome text 3');

INSERT INTO albums (path, name, description) VALUES
	('mcaleer/demo', 'Demolition', 'Pictures of our house getting done broken');
