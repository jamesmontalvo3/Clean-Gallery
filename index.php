<?php

/**

1) Upload photos to ftp://.../photos/your/album
2) Navigate to your album at http://montalvo.us/photos/your/album
	1) Generate webpage:
		1) Loop through table block_text with `location`=="your/album", create JSON-ready object
		2) Loop through table photos with `location`=="your/album", pin photos to block_text object
		3) On $(document).ready(), show first caption and photos
		3) Load more captions/photos on demand
	2) Init subprocess to scan /photos/your/album:
		1) Any zip files: unzip, then delete zip file
		2) Any jpg (png? tiff?) files: 
			1) Move original to /originals
			2) Create small versions; put in subdirs (.h120, .h160, .h500, .w500, ...)
			3) Add image data to database

How to move photos?
How to add 

Include ToC? Jump to section?
 **/



require_once "PDO_Connection.php";
require_once "LocalSettings.php";

require_once "model/BlockText.php";
require_once "model/Photo.php";
require_once "model/Album.php";


// trim off the filename from SCRIPT_NAME, leaving just the path 
// Note: has leading and trailing slash
// Where SCRIPT_NAME like "/photos/index.php", returns path like: /photos/
$script_path = substr( $_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1 );


// return only the REQUEST_URI after the script_path
// Where REQUEST_URI = "/photos/my/album/", album = "my/album/"
$album = substr( $_SERVER["REQUEST_URI"], strlen($script_path) );
$album = rtrim( strtolower($album), '/' );
echo "<h1>$album</h1>";



$sql = new PDO_Connection( $appConfig['database'] );
$sql->connect();



$blocktext = $sql->conn()->prepare( 
	"SELECT * FROM " . BlockText::$db_table .
	" WHERE album=:album 
	ORDER BY year, month, day, hour, minute, second ASC"
);
$blocktext->execute( array('album'=>$album) );
$blocktext = $blocktext->fetchAll(PDO::FETCH_CLASS, "BlockText");



$photos = $sql->conn()->prepare(
	"SELECT * FROM " . Photo::$db_table .
	" WHERE album=:album
	ORDER BY year, month, day, hour, minute, second ASC"
);
$photos->execute( array('album'=>$album) );
$photos = $photos->fetchAll(PDO::FETCH_CLASS, "Photo");




$img_index = 0;
$img_count = count($photos);

// this loops through all captions, and inserts a caption into the $photos
// array before the first image it finds that is LATER than it. Thus,  
foreach($blocktext as &$bt) {

	for($i=$img_index; $i<$img_count; $i++) {

		// if this image is later chronologically than the caption
		if ( $bt->isBefore( $photos[$i] ) ) {

			// if $photos[$i] has a later date/time than $bt, insert $bt before
			// $photos[$i] so the caption will appear above it
			array_splice($photos, $i, 0, array($bt) );

			// $i will now be the caption. $i+1 will be the same image. Check
			// the next caption against this same image in case multiple 
			// captions in a row (is multiple in a row desirable?)
			$img_index = $i + 1;

			// break out of photos loop, go to next group_caption
			break;

		}
		// else move on to next image

		// set $bt to 0, to limit it's memory footprint?
		// this is only useful if using &$bt (by ref) in foreach()
		// $bt = 0; // can it be unset instead? seems like that would break things
	}

}

echo "<h2>Photos Var</h2>";
print_r ($photos);
echo "<br /><br />";


$photos = str_replace( "\"", "\\\"", json_encode($photos) );

echo $photos;

$body_content = '<script type="text/javascript">
	$(document).ready(function(){

		var photos = JSON.parse("' . $photos . '");
		console.log("test");
		console.log(photos);
	});
</script>';
require_once "view/main.php";

