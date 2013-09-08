<?php

class Album {

	public $path;
	public $name;
	public $description;
	public $path_parts;

	public function __construct ($album_path) {
		global $sql;

		$sql_stmt = $sql->conn()->prepare(
			"SELECT * FROM albums WHERE path=:path;"
		);
		$sql_stmt->execute( array('path'=>$album_path) );

		if( $album = $sql_stmt->fetch(PDO::FETCH_OBJ) ) { 
			$this->path = $album_path;
			$this->name = $album->name;
			$this->description = $album->description;
		}
		else {
			echo "<pre>";
			print_r($album);
			echo "</pre>";
			die("Specified album does not exist");
		}
		$this->path_parts = explode('/',$this->path);

	}

	public function getBreadcrumbs () {
		global $base_path, $script_path;

		$sub_path = $base_path.$script_path;

		$bc=array();
		$last = count($this->path_parts) - 1;
		foreach($this->path_parts as $i => $part ) {
			if ($i == $last)
				array_push($bc, "<span style='font-weight:bold;'>$part</span>");
			else {
				$sub_path .= $part.'/';
				array_push($bc, "<a href='$sub_path'>$part</a>");
			}
		}
		array_push($bc, "<a href='#'>+</a>");

		return implode(' / ', $bc);

	}



	// creates array of Gallery_Elements from this album
	public function populateElements () {
		global $sql;

		$sql_stmt = $sql->conn()->prepare(
			"SELECT 
				gallery_elements.ge_id, gallery_elements.date, gallery_elements.title, 
				gallery_elements.words, gallery_elements.user_id,
				photos.p_id, photos.original_filename, photos.file_sha1, 
				photos.upload_date, photos.ori_w, photos.ori_h
			FROM gallery_elements LEFT OUTER JOIN photos 
				ON gallery_elements.ge_id = photos.gal_elem_id
			WHERE album =:album
			ORDER BY `date` ASC;"
		);
		$sql_stmt->execute( array('album'=>$this->path) );

		$g_elems = $sql_stmt->fetchAll(PDO::FETCH_ASSOC);

		$elements = array();

		for ($i=0; $i<count($g_elems); $i++) {

			$elements[$i] = new Gallery_Element();
			$elements[$i]->ge_id   = $g_elems[$i]['ge_id'];
			$elements[$i]->album   = $g_elems[$i]['album'];
			$elements[$i]->date    = $g_elems[$i]['date'];
			$elements[$i]->title   = $g_elems[$i]['title'];
			$elements[$i]->words   = $g_elems[$i]['words'];
			$elements[$i]->user_id = $g_elems[$i]['user_id'];

			if ( isset($g_elems[$i]['p_id']) ) {
				$elements[$i]->photo = new Photo();
				$elements[$i]->photo->p_id        = $g_elems[$i]['p_id'];
				$elements[$i]->photo->original_filename = $g_elems[$i]['original_filename'];
				$elements[$i]->photo->file_sha1   = $g_elems[$i]['file_sha1'];
				$elements[$i]->photo->upload_date = $g_elems[$i]['upload_date'];
				$elements[$i]->photo->ori_w       = $g_elems[$i]['ori_w'];
				$elements[$i]->photo->ori_h       = $g_elems[$i]['ori_h'];
			}
			else
				$elements[$i]->photo = false;

		}

		$this->elements = $elements;
		return $elements;

	}

}