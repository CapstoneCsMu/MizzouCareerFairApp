<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$page = $_SERVER['PHP_SELF'];
	$sec = "6";
	
	//Reset Session to Accept POST Variables from this form.
	//$_SESSION = NULL;
	if($_SESSION['prevPage'] != 'index.php')
		$_SESSION['filters'] = $_POST;
	else
		$_SESSION['prevPage'] = 'companyFilter.php';
	
?>
<!DOCTYPE html>
<html>
<head>
<title>Filter Companies
</title> 
<!--Force the page to refresh-->

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
<!--Script to get off this page-->
<script type="text/javascript">
	function submitFilter()
	{
		document.getElementById("filterForm").submit();
		window.alert("You're Settings have been saved.");
	}
</script>
</head>

<div data-role="page" data-theme="a">
	<div data-role="header" data-position="fixed">
		<h1>Add a Filter</h1>
		<a data-direction="reverse" data-icon="home" data-iconpos="notext" href="index.php">Back</a> 
	</div>
	<div data-role="content">
		<ul data-dividertheme="b" data-inset="true" data-role="listview">
		<li data-role="list-divider">Submit After you're Selections</li>
		<?php
			echo '<div class="ui-field-contain">';
			echo '<form id="filterForm" method="post" action="companyFilter.php">';
			echo '<fieldset data-role="controlgroup">';
			echo '<legend>Choose From:</legend>';
			
			//Filters are Added Statically**************************************** (Maybe add the ability for Admin to be able to add new Filters if we have time?)
			//OR We may have to find a way to load these dynamically
			echo '<input type="checkbox" id="filter_0" name="filter_0" value="Computer Science"';
			if (isset($_SESSION['filters']['filter_0'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_0">Major:	Computer Science</label>';
			
			echo '<input type="checkbox" id="filter_1" name="filter_1" value="Chemical Engineering"';
			if (isset($_SESSION['filters']['filter_1'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_1">Major:	Chemical Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_2" name="filter_2" value="Civil/Environmental Engineering"';
			if (isset($_SESSION['filters']['filter_2'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_2">Major:	Civil/Environmental Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_3" name="filter_3" value="Electrical Engineering"';
			if (isset($_SESSION['filters']['filter_3'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_3">Major:	Electrical Engineering</label>';
			
			echo '<input type="checkbox" id="filter_4" name="filter_4" value="Computer Engineering"';
			if (isset($_SESSION['filters']['filter_4'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_4">Major:	Computer Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_5" name="filter_5" value="Mechanical & Aerospace Engineering"';
			if (isset($_SESSION['filters']['filter_5'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_5">Major:	Mechanical & Aerospace Engineering</label>';

			echo '<input type="checkbox" id="filter_6" name="filter_6" value="Nuclear Engineering"';
			if (isset($_SESSION['filters']['filter_6'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_6">Major:	Nuclear Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_7" name="filter_7" value="Business Administration"';
			if (isset($_SESSION['filters']['filter_7'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_7">Major:	Business Administration</label>';
			
			echo '<input type="checkbox" id="filter_8" name="filter_8" value="MO" ';
			if (isset($_SESSION['filters']['filter_8'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_8">State:	Missouri</label>';
			
			echo '<input type="checkbox" id="filter_9" name="filter_9" value="IL"';
			if (isset($_SESSION['filters']['filter_9'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_9">State:	Illinois</label>';
			
			echo '<input type="checkbox" id="filter_10" name="filter_10" value="KS"';
			if (isset($_SESSION['filters']['filter_10'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_10">State:	Kansas</label>';
			
			echo '</fieldset></form></div>';
			echo '<li><a data-transition="slide" href="companyFilter.php" onclick="submitFilter();"><center>Submit</center></a></li>';
			
		?>
	</div>
</div>