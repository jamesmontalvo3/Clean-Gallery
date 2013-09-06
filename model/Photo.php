<?php
require_once "BlockText.php";

class Photo extends BlockText {

	public static $db_table = "photos";

	public $id;
	
	// public $year;
	// public $month;
	// public $day;
	// public $hour;
	// public $minute;
	// public $second;

	// public $album;
	// public $words;
	
	public $ori_w;
	public $ori_h;
	public $w_h_ratio;

	public $type = "photo";


	// public function __construct () {

	// }

}