<?php


class PhotoUpload {

	// sha1, original_filename, file_sha1, upload_date, user_id
	public static $insert = array();

	function make_thumb ($src, $dest, $desired_width) {

		/* read the source image */
		$source_image = imagecreatefromjpeg($src);
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		
		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height * ($desired_width / $width));
		
		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		
		/* create the physical thumbnail image to its destination */
		imagejpeg($virtual_image, $dest);
	}


	public static function createResizedImage () {


		$image = new Imagick( $filename );

		$imageprops = $image->getImageGeometry();

		if ($imageprops['width'] <= 200 && $imageprops['height'] <= 200) {
			// don't upscale
		} else {
			$image->resizeImage(200,200, imagick::FILTER_LANCZOS, 0.9, true);
		}


		// convert to jpg 
		$im->setImageColorspace(255); 
		$im->setCompression(Imagick::COMPRESSION_JPEG); 
		$im->setCompressionQuality(60); 
		$im->setImageFormat('jpeg'); 

		//resize 
		$im->resizeImage(290, 375, imagick::FILTER_LANCZOS, 1);  

		//write image on server 
		$im->writeImage('thumb.jpg'); 
		$im->clear(); 
		$im->destroy(); 



	}


	public static function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth ) {
		// open the directory
		$dh = opendir( $pathToImages );

		// loop through it, looking for any/all JPG files:
		while (false !== ($fname = readdir( $dh ))) {

            echo "filename: $fname : filetype: " . filetype($pathToImages . $fname) . "\n";


			// parse path for the extension
			$info = pathinfo($pathToImages . $fname);

			// continue only if this is a JPEG image
			if ( strtolower($info['extension']) == 'jpg' ) 
			{
				echo "Creating thumbnail for {$fname} <br />";

				// load image and get image size
				$img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
				$width = imagesx( $img );
				$height = imagesy( $img );

				// calculate thumbnail size
				$new_width = $thumbWidth;
				$new_height = floor( $height * ( $thumbWidth / $width ) );

				// create a new temporary image
				$tmp_img = imagecreatetruecolor( $new_width, $new_height );

				// copy and resize old image into new image 
				imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

				// save thumbnail into a file
				imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
			}
		}
		// close the directory
		closedir( $dh );
	}




	public static function walk ( $path, $user="", $album="" ) {

		$dir_handle = opendir( $path );

		$output .= "<ul>";
		while (false !== ($fname = readdir( $dir_handle ))) {

			if ( $fname == '.' || $fname == '..' )
				continue;

			$filepath = $path.'/'.$fname;

			$output .= "<li>";
			
			if ( is_dir($filepath) ) {
				$output .= "Album: $fname";
				self::walk( $filepath );
			}
			else {
				$output .= self::handle_file($filepath);
			}

			$output .= "</li>";

		}
		$output .= "</ul>";

		return $output;
	}


	public static function handle_file ( $filepath ) {
		global $media_directory;

		// step 1: get info on file, make sure it's safe???
		$sha1 = sha1_file( $filepath );
		$sha1_char1 = substr( $sha1, 0, 1 );
		$sha1_char12 = substr( $sha1, 0, 2 );

		$original_filename = substr( strrchr($filepath, '/'), 1);
		$extension = strrchr($original_filename, '.');
		$new_filename = 'ori' . $extension;

		// DO I NEED TO MAKE EACH OF THE DIRECTORIES FIRST?


		// step 2: move file to media directory
		$new_filepath = implode('/', array($sha1_char1, $sha1_char12, $sha1, $new_filename);
		$success = rename($filepath, $new_filepath);

		// step 3: add file info to pending_media DB table
		if ($success) {

			$insert_string = 

		}
		else {
			return "ERROR: could not move file to media directory";
		}




	}


	public static function process () {




		$stmt->prepare(
			"INSERT INTO pending_files ()
			VALUES ()"
		);

	}


	/**
	
	1) hit http://example.com/cg/upload
	2) Check for files, add to pending_files table
	3) Check for image_addition process (is this possible?)
		1) init if doesn't exist
		2) get status if there's issues????
	4) Output pending_files info to page
		1) Create AJAX request for regular updates on status
	5) Output "upload file" forms (do this later)

	Cron job to check for files requiring addition?


	**/

}


// call createThumb function and pass to it as parameters the path 
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width. 
// We are assuming that the path will be a relative path working 
// both in the filesystem, and through the web for links
//createThumbs("upload/","upload/thumbs/",100);
