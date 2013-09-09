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

// return only the REQUEST_URI after the script_path
// Where REQUEST_URI = "/photos/my/album/", $control_path = "MY/Album/"
$control_path = substr( $_SERVER["REQUEST_URI"], strlen($script_path) );
// lower case and remove trailing slash, $control_path = "my/album"
$control_path = rtrim( strtolower($control_path), '/' );

$IP = __DIR__;

$full_script_path = $base_path.$script_path;
$lib_path = $full_script_path.'lib/';

if ( ! isset($media_directory) ) {
	$media_directory = $IP.'/media';
}


$control = explode('/', $control_path);

if ( ! isset($control[0]) ) {

	// when someone navigates to app root, e.g. http://example.com/cg
	echo "The application main page will be here";
	exit();

}
else if ($control[0] == 'media') {

	echo "media will be here";
	exit();

	// access images and videos through here...
	// this will be a URL like:
	// http://example.com/cg/media/1f07c5d5175c0c79fd75f9255c50013a48891fe0/h160.jpg
	$image_hash = $control[1];
	$image_size = $control[2]; // this should probably be like "h160.jpg"

}
else if ($control[0] == 'upload') {

	// upload images through web interface here
	// echo "uploading will happen here";
	// exit();

	require_once "$IP/PhotoUpload.php";

	echo PhotoUpload::walk("/Library/WebServer/Documents/test");

}
else if ($control[0] == 'api') {

	// API calls...
	echo "API calls will happen here";
	exit();

}
else {
	
	require_once "model/Album.php";
	require_once "model/Gallery_Element.php";
	require_once "model/Photo.php";
	require_once "model/User.php";
	require_once "view/HTML_Builder.php";

	$album = new Album($control_path);
	$album->populateElements();

	$html = new HTML_Builder();
	$html->headAppend( $album->getInitCleanGalleryJS() );
	$html->bodyAppendFile( "view/album_view.php", $album );

	echo $html->getHTML();
}