<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="description" content="Simple Image Gallery">
		<meta name="keywords" content="Images,Photos">
		<meta name="author" content="James Montalvo - https://github.com/jamesmontalvo3">
		<meta charset="UTF-8">
		<?php 
			global $IP;
			include "$IP/view/html-head.php";
			if ( isset($head_content) )
				echo $head_content;
		?>
	</head>
	<body>
		<?php 
			if ( isset($body_content) )
				echo $body_content;
			else
				die("No content supplied for body of page.");

			include "$IP/view/footer.php"; 
		?>
	</body>
</html>