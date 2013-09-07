<?php

class Photo {

	public static $db_table = "photos";

	public $id;

	public $gal_obj_id;

	public $original_filename;
	public $file_sha1;
	public $upload_date;
		
	public $ori_w;
	public $ori_h;

	public $type = "photo";


	// public function __construct () {

	// }

}