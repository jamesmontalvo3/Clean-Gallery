<?php


class PhotoUpload {

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

	public static function walk ($path) {

		$dir_handle = opendir( $path );

		echo "<ul>";
		while (false !== ($fname = readdir( $dir_handle ))) {

			echo "<li>";
			
			if ( is_dir($path.'/'.$fname) && $fname != '.' && $fname != '..') {
				echo "Directory: $fname";
				self::walk( $path.'/'.$fname );
			}
			else {
				echo $path.'/'.$fname;
			}

			echo "</li>";

		}
		echo "</ul>";
	}

}


// call createThumb function and pass to it as parameters the path 
// to the directory that contains images, the path to the directory
// in which thumbnails will be placed and the thumbnail's width. 
// We are assuming that the path will be a relative path working 
// both in the filesystem, and through the web for links
//createThumbs("upload/","upload/thumbs/",100);
