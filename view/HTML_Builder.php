<?php


class HTML_Builder {

	public $head_content = "";
	public $body_content = "";
	public $html_master;

	public function __construct ($html_master="view/main.php") {
		global $IP;
		$this->html_master = $IP.'/'.$html_master;
	}

	public function headAppend ($html) {
		$this->head_content .= $html;
	}

	public function bodyAppend ($html) {
		$this->body_content .= $html;
	}

	public function headAppendFile ($file, $obj=false) {
		global $IP;

		ob_start();
		include $IP.'/'.$file;
		$this->head_content .= ob_get_clean();

	}

	public function bodyAppendFile ($file, $obj=false) {
		global $IP;

		ob_start();
		include $IP.'/'.$file;
		$this->body_content .= ob_get_clean();

	}

	public function getHTML () {

		ob_start();
		$head_content = $this->head_content;
		$body_content = $this->body_content;
		include $this->html_master;
		return ob_get_clean();

	}

}