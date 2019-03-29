<?php
//ini_set('display_errors', 1);/// uncomment for on page ERROR LOGGING 
//error_reporting(E_ALL);/// uncomment for on page ERROR LOGGING 

/* 
 * sql host, user, pass, & database located at LINE 25 in bible_to_sql_service.php  
 */
require("bible_to_sql_service.php");

// https://www.php.net/manual/en/migration70.new-features.php#migration70.new-features.null-coalesce-op
// Fetches $_GET['t'] value, else returns 't_kjv' if it does not exist.
$translation = $_GET['t'] ?? 't_kjv';
// Fetches $_GET['b'] value, else returns 'John 3:16'if it does not exist.
$verse_text = $_GET['b'] ?? 'John 3:16';

//split $verse_text at commas [not sure how to do it inline w/ Null coalescing operator]
$references=explode(",", $verse_text);


?>
<html>
<head>
	<title>Bible Search</title>

	<!-- Begin: CSS STYLES -->
	<!-- Delete this section remove page styling -->
	<link href="https://fonts.googleapis.com/css?family=Patua+One|Special+Elite" rel="stylesheet">
	<style type="text/css">
		body{position: relative; min-height: 100%; width: 100%;margin:0; padding-bottom: 40px; }
		header{display:block;box-shadow: 1px 0 3px #4799B0; width: 100%;padding: 10px;border-bottom:1px solid #AAA;}
		h1{color:#0c0c0c;margin-left: 20px;font-family: 'Special Elite', cursive;}
		h2{color:#4799B0;}
		main{padding: 10px;}
		section{ margin: 30px 10px 10px; padding:20px; border: solid 2px #EEE; border-radius:7px; box-shadow: 1px 2px 3px #4799B0;}
		h5{font-size: 2rem; font-family: 'Patua One', cursive;}
		.versetext{font-size: 1.8rem; font-family: 'Special Elite', cursive;}
		footer{display:block;position:absolute;bottom: 0;box-shadow: -1px 0 3px #4799B0; width: 100%; min-height:10px; padding: 10px;border-top:1px solid #AAA; content:"";}
	</style>
	<!-- End: CSS STYLES -->

</head>
<body>
	
	<header>
		<h1>Scripture References</h1>
	</header>
	
	<main>
		<!-- 1. Begin: PHP EXAMPLE -->
		<section>
			<h2>PHP Example</h2>
		
			<form action="index.php" action="GET">
				<label for="b">Enter Reference(s): </label><input type="text" name="b" value="<?php echo $verse_text; // $_GET data if exists, else default data ?>" />
				
				<!-- Bible translation dropdown -->
				<select for="t" id="translation" name="t">
				  <option value="t_kjv">King James Version</option>
				  <option value="t_asv">American Standard Version</option>
				  <option value="t_dby">Darby English Bible</option>
				  <option value="t_bbe">Bible in Basic English</option>
				  <option value="t_web">Webster's Bible</option>
				  <option value="t_web">World English Bible</option>
				  <option value="t_ylt">Young's Literal Translation</option>
				</select>
				<input type="submit" value="submit" /><br/>
			</form>

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

		</section>
		<!-- 1. End: PHP EXAMPLE -->

		
		<!-- 2. Begin AJAX EXAMPLE -->
		<section>
			<h2>AJAX Example</h2>
			<!-- Just an example. Pass text(s) to the showTexts function however you like. -->
			<button onclick="showTexts('John 3:16')">John 3:16 </button>
			<button onclick="showTexts('Revelation 22:12-14')">Revelation 22:12-14</button>
			<!-- AJAX updates these placeholders automatically -->
			<div id="showSubjects">
			    <h6>Click button <span>to see it here.</span></h6>
			</div>	
			<div id="showTexts"></div>

			<script>
				/* MySQL DB Query via AJAX. */

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
		</section>
		<!-- 2. End AJAX EXAMPLE -->

	</main>
	
	<footer></footer>
	
</body>
</html>
