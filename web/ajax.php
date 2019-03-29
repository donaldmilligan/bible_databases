<?php
//ini_set('display_errors', 1);/// prints ERROR LOGGING to the page
//error_reporting(E_ALL);/// prints ERROR LOGGING to the page

/* 
 *
 * this page is basic because it returns all HTML on the page after the query 
 *
 */

require("bible_to_sql_service.php");


$references = explode(",",$_GET['b']);

?>
<div>
	<?php 

	//return results
	foreach ($references as $r) {
		$sanitized = stripslashes($r);
		$lib = new Librarian;
		$lib->prepare($sanitized);
		// see index for dynamic translations
		$lib->translation('t_kjv');
	}

	?>
</div>
