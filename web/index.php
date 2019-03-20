<?php
ini_set('display_errors', 1);/// ERROR LOGGING 
error_reporting(E_ALL);/// ERROR LOGGING 
$default_text = "John 3:16";

/*** DO NOT EDIT BELOW THIS LINE (Unless you know what you are doing :) ) ***/
require("servant.php");

//split at commas
$references = explode(",",$_GET['b']);
//get translation 
$translation=($_GET['t']);

?>
<html>
<head>
<title>Bible Search</title>
<link href="https://fonts.googleapis.com/css?family=Patua+One|Special+Elite" rel="stylesheet">
<style type="text/css">
	h5{font-size: 2rem; font-family: 'Patua One', cursive;}
	.versetext{font-size: 1.8rem; font-family: 'Special Elite', cursive;}
</style>
</head>
<body style="height: 100%; width: 100%;margin:0;">
<header  style="display:block;background: #4799B0; width: 100%;padding: 10px;border-bottom:1px solid #AAA;margin: 0 0 10px;">
	<h1 style="color:#FFF;">Bible Search</h1>
	
</header>
<main style="padding: 10px;">
	<h2>Via PHP</h2>
	<!-- Form -->
	<form action="index.php" action="GET">
		<!-- verse(s) -->
		<label for="b">Reference(s): </label><input type="text" name="b" value="<?php if ($_GET['b']) { echo $_GET['b']; } else { echo $default_text; } ?>" />
		<!-- translation -->
		<select for="t" id="translation" name="t">
		  <option value="t_kjv">King James Version</option>
		  <option value="t_asv">American Standard Version</option>
		  <option value="t_dby">Darby English Bible</option>
		  <option value="t_bbe">Bible in Basic English</option>
		  <option value="t_web">Webster's Bible</option>
		  <option value="t_web">World English Bible</option>
		  <option value="t_ylt">Young's Literal Translation</option>
		</select>
		<!-- submit -->
		<input type="submit" value="submit" /><br />
	</form>
	<!-- End Form -->

	<?php 
	//return results
	
	foreach ($references as $r) {
		//stripslashes if any from manual input
		$verse = stripslashes($r);
		// create new object for making query
		$getverse = new Librarian;
		// if its really a bible verse this will not error
		$getverse ->prepare($verse);
		// make the mysqli query with specified translation
		// only starts if prepare was successful
		$getverse->translation($translation);
	}
	?>
	<hr><hr>

	<h2>Via AJAX</h2>
	<button onclick="showTexts('John 3:16')">John 3:16 </button>
	<button onclick="showTexts('Revelation 22:12')">Revelation 22:12</button>

	<div id="showSubjects">
	    <h6>Click button <span>to see it here.</span></h6>
	</div>	
	<div id="showTexts"></div>
</main>
<footer style="display:block;position:absolute;bottom: 0;background: #4799B0; width: 100%;padding: 10px;border-top:1px solid #AAA;">
	<form>

</form>

</footer>
<script>
	/* MySQL DB Query via AJAX */

	// receives a human readable string. ie: "Job 32:8"
	function showTexts(verse) {
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("showTexts").innerHTML = this.responseText;
	            }
	        };
	        // prepare to query the ajax.php page
	        xmlhttp.open("GET","./ajax.php?b="+verse,true);
	        // send query
	        xmlhttp.send();
	        // remove the "click on" prompt
	        document.getElementById("showSubjects").style.display = "none";
	}

	
</script>
</body>
</html>
