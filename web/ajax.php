<?php
//ini_set('display_errors', 1);/// ERROR LOGGING 
//error_reporting(E_ALL);/// ERROR LOGGING 
require("servant.php");

$references = explode(",",$_GET['b']);

?>
<main>
	<?php 

	//return results
	foreach ($references as $r) {
		$sanitized = stripslashes($r);
		$lib = new Librarian;
		$lib->prepare($sanitized);
		$lib->translation('t_kjv');
	}

	?>
</main>

