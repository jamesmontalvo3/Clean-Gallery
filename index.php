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

require_once "model/Gallery_Element.php";
require_once "model/Photo.php";
require_once "model/Album.php";
require_once "model/User.php";

$sql = new PDO_Connection( $appConfig['database'] );
$sql->connect();


/**
 *	A lot of this stuff needs to be included into an "environment setup" file
 *  or something like that.
 *
 **/

$application_name = "Clean Gallery";
$application_url  = "https://github.com/jamesmontalvo3/Clean-Gallery";

// trim off the filename from SCRIPT_NAME, leaving just the path 
// Note: has leading and trailing slash
// Where SCRIPT_NAME like "/photos/index.php", returns path like: /photos/
$script_path = substr( $_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/')+1 );

// protocol relative base path
$base_path = '//'.$_SERVER['HTTP_HOST'];

$lib_path = $base_path.$script_path.'lib/';


// return only the REQUEST_URI after the script_path
// Where REQUEST_URI = "/photos/my/album/", album = "my/album/"
$album_path = substr( $_SERVER["REQUEST_URI"], strlen($script_path) );
$album_path = rtrim( strtolower($album_path), '/' ); // remove the trailing slash



$album = new Album($album_path);

$elements = $album->populateElements();

$elements = str_replace( '"', '\"', json_encode($elements) );
// echo $elements;
$head_content = 
'<script type="text/javascript">
	$(document).ready(function(){

		var album = JSON.parse("' . $elements . '");
		console.log(album);

		$("#container").cleangallery(album);
	});
</script>';

$body_content = '<div style="font-size:12px;">' . $album->getBreadcrumbs() . '</div>';
$body_content .= '<h1>' . $album->name . '</h1>';
$body_content .= '<div id="container"></div>';

require_once "view/main.php";
