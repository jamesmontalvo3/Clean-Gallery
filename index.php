<?php

/**

1) Upload images to ftp://.../photos/your/gallery
2) Navigate to your gallery at http://montalvo.us/photos/your/gallery
	1) Generate webpage:
		1) Loop through table group_captions with `location`=="your/gallery", create JSON-ready object
		2) Loop through table images with `location`=="your/gallery", pin images to group_captions object
		3) On $(document).ready(), show first caption and images
		3) Load more captions/images on demand
	2) Init subprocess to scan /photos/your/gallery:
		1) Any zip files: unzip, then delete zip file
		2) Any jpg (png? tiff?) files: 
			1) Move original to /originals
			2) Create small versions; put in subdirs (.h120, .h160, .h500, .w500, ...)
			3) Add image data to database

How to move images?
How to add 

Include ToC? Jump to section?

ridiculously
simple
photo
image
site
gallery

no
bull
shit
photo
site

NoBis
 **/

require_once "PDO_Connection.php";
require_once "LocalSettings.php"

function get_time_string ($image) {

	$output = '';
	foreach(array('year','month','day','hour','minute','second') as $t)
		$output .= $image[$t]; // TODO: this could probably be done faster w/o loop

	// TODO: should this return the intval?
	return $output;

}

$sql = new PDO_Connection( $appConfig['database'] );

$group_captions = $sql->conn()->prepare( "SELECT * FROM group_captions WHERE location=:location" );
$group_captions->execute( array('location'=>$gallery) );

$images = $sql->conn()->prepare( "SELECT * FROM images WHERE location=:location" );
$images->execute( array('location'=>$gallery) );


/*	 
	while($row = $stmt->fetch()) {
		print_r($row);
	}
*/


foreach($images as &$img)
	$img['type'] = 'image'; //to distguish captions from images

$img_index = 0;
$img_count = count($images);

// this loops through all captions, and inserts a caption into the $images
// array before the first image it finds that is LATER than it. Thus,  
foreach($group_captions as &$gc) {

	$gc['type'] = 'caption'; // to distinguish captions from images

	// TODO: should this be converted to intval?
	$gc_time_string = get_time_string($gc); // like 20130902125959

	for($i=$img_index; $i<$img_count; $i++) {

		// if this image is later chronologically than the caption
		if ( get_time_string($images[$i]) > $gc_time_string) {

			// if $images[$i] has a later date/time than $gc, insert $gc before
			// $images[$i] so the caption will appear above it
			array_splice($images, $i, 0, array( $gc ));

			// $i will now be the caption. $i+1 will be the same image. Check
			// the next caption against this same image in case multiple 
			// captions in a row (is multiple in a row desirable?)
			$img_index = $i + 1;

			// break out of images loop, go to next group_caption
			break;

		}
		// else move on to next image

		// set $gc to 0, to limit it's memory footprint?
		// this is only useful if using &$gc (by ref) in foreach()
		// $gc = 0; // can it be unset instead? seems like that would break things
	}

}

$images = json_encode($images);

?>

<script type="text/javascript">
	$(document).ready(function(){

		var images = JSON.parse("<?php echo $images; ?>");

	});
</script>