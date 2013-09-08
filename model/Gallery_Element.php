<?php

class Gallery_Element {

	public $ge_id;
	public $album;
	public $date;

	public $title;
	public $words;

	public $user_id;


	// NOTE: when using this class with PDO, the properties are set BEFORE the 
	// __construct function is run.
	public function __construct () {



	}

	public function get_time_string ($image) {

		$output = '';
		foreach(array('year','month','day','hour','minute','second') as $t)
			$output .= $image[$t]; // TODO: this could probably be done faster w/o loop

		// TODO: should this return the intval?
		// Cannot do regular int, since yyyymmddhhmmss is too big (trillions)
		return $output;

	}

	public function isBefore (BlockText $elem) {
		$this->checkDateTimeInts();
		$elem->checkDateTimeInts();
		if ( $this->date_int <= $elem->date_int && $this->time_int < $elem->time_int )
			return true;
		else
			return false;
	}

	public function isBeforeOrSame (BlockText $elem) {
		$this->checkDateTimeInts();
		$elem->checkDateTimeInts();
		if ( $this->date_int <= $elem->date_int && $this->time_int <= $elem->time_int )
			return true;
		else
			return false;
	}

	protected function checkDateTimeInts () {
		if ( ! $this->date_int ) {
			$this->setDateTimeInts();
		}
	}

	protected function setDateTimeInts () {
		$this->date_int = intval( $this->year . $this->month . $this->day );
		$this->time_int = intval( $this->hour . $this->minute . $this->second );
	}

}