<?php 
if ( ! isset( $obj ) && get_class($obj) !== 'Album' ) {
	// replace this with an HTML_Builder::get404(); or something
	die ("whoops...include an album variable for this guy");
}
?>
<div style="font-size:12px;"><?php echo $obj->getBreadcrumbs(); ?></div>
<h1><?php echo $obj->name; ?></h1>
<div id="container"></div>