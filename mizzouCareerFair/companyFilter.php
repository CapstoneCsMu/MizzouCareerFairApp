<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Filter Companies
</title> 
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1" name="viewport">

<!-- Include CSS and JQM CSS -->
<link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
<link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">

<link href=
"http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css"
rel="stylesheet">

<!-- Include jQuery and jQuery Mobile CDN, add actual files -->
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src=
"http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script>

<!-- Include JS file for our JS -->
<script src="js/index.js"></script>

<div data-role="page" data-theme="a" id="Filter">
	<div data-role="header" data-position="fixed">
		<h1>Add a Filter</h1>
		<a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="index.php#companies">Back</a> 
	</div>
	<div data-role="content">
		<ul data-dividertheme="b" data-inset="true" data-role="listview">
		<li data-role="list-divider">Submit After you're Selections</li>
		<?php
			//Include Database information
			include ("data.php");
			
			echo '<div class="ui-field-contain"><form action="index.php" method="post">';
			echo '<fieldset data-role="controlgroup">';
			echo '<legend>Choose From:</legend>';
			
			//Trial
			echo '<input type="checkbox" id="filter_0" name="filter_0" value="Computer Science" checked/>';
			//echo '<input type="hidden" id="filter_0" value="Computer Science">';
			echo '<label for="filter_0">Major:Computer Science</label>';			
			//For Loop needs editing: Add more Filters Here...
			for( $i=1; $i < 6; $i++)
			{
				echo '<input type="checkbox" id="filter_'.$i.'">';
				echo '<label for="filter_'.$i.'">Add Something</label>';
			}
			echo '</br><input type="submit" value="Submit"/>';
			echo '</fieldset></form>';
		?>
	</div>
</div>