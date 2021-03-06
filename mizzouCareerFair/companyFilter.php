<?php
	/*
	File: companyFilter.php
	Parent: index.php (approx line 135)
	Purpose: This file is a landing page for users to be able to select Filters when viewing the list of Companies.
	*/
	include('check_https.php');
	
	//Reset Session to Accept POST Variables from this form.
	if (!empty($_POST) && $_SESSION['prevPage'] != 'index.php')
	{
		$_SESSION['filters'] = $_POST;
		print("prev: ".$_SESSION['prevPage']);
	}
	else
		$_SESSION['prevPage'] = 'companyFilter.php';
	
	if(!empty($_GET))
		$_SESSION['filters'] = NULL;

?>
<!DOCTYPE html>
<html>
<head>
<title>Filter Companies</title> 

<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1" name="viewport">

<!-- Include CSS and JQM CSS -->
<link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
<link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">

<!-- Include jQuery and jQuery Mobile CDN, add actual files -->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>

<!-- Include JS file for our JS -->
<script src="js/index.js"></script>
<!--Script to get off this page-->
<script type="text/javascript">
	function submitFilter()
	{
		//Check to make sure a major has been selected
		var filter = new Array();
		for (i=0; i < 8 ; i++)
		{
			filter[i] = document.getElementById('filter_'+i);
		}
		//Submit Form
		if (filter[0].checked || filter[1].checked || filter[2].checked || filter[3].checked || 
		filter[4].checked || filter[5].checked || filter[6].checked || filter[7].checked)
		{
			document.getElementById("filterForm").submit();
			window.alert("You're Settings have been saved.");
		}
		else {
		alert("Error: Please Select a Major");
		}
	}
	function Reset()
	{
		document.getElementById("reset").submit();
	}
</script>
</head>
<body>
<div data-role="page" data-theme="a">
	<div data-role="header" data-position="fixed">
		<h1>Select Filters</h1>
		<a rel="external" data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="index.php#companies">Back</a> 
	</div>
	<div data-role="content">
		<ul data-dividertheme="b" data-inset="true" data-role="listview">
		<div class="ui-field-contain">
		<?php
			echo '<form id="filterForm" method="post" action="companyFilter.php">';
			
			//Filters are Added Statically**************************************** (Maybe add the ability for Admin to be able to add new Filters if we have time?)
			//OR We may have to find a way to load these dynamically
			echo '<div data-role="collapsible"><h3>Major(s) <font color="red">*</font></h3>';
			echo '<input type="checkbox" id="filter_0" name="filter_0" value="Computer Science"';
			if (isset($_SESSION['filters']['filter_0'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_0">Computer Science</label>';
			
			echo '<input type="checkbox" id="filter_1" name="filter_1" value="Chemical Engineering"';
			if (isset($_SESSION['filters']['filter_1'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_1">Chemical Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_2" name="filter_2" value="Civil/Environmental Engineering"';
			if (isset($_SESSION['filters']['filter_2'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_2">Civil/Environmental Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_3" name="filter_3" value="Electrical Engineering"';
			if (isset($_SESSION['filters']['filter_3'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_3">Electrical Engineering</label>';
			
			echo '<input type="checkbox" id="filter_4" name="filter_4" value="Computer Engineering"';
			if (isset($_SESSION['filters']['filter_4'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_4">Computer Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_5" name="filter_5" value="Mechanical & Aerospace Engineering"';
			if (isset($_SESSION['filters']['filter_5'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_5">Mechanical & Aerospace Engineering</label>';

			echo '<input type="checkbox" id="filter_6" name="filter_6" value="Nuclear Engineering"';
			if (isset($_SESSION['filters']['filter_6'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_6">Nuclear Engineering</label>';	
			
			echo '<input type="checkbox" id="filter_7" name="filter_7" value="Information Technology"';
			if (isset($_SESSION['filters']['filter_7'])) echo ' checked/>'; else echo '/>';
			echo '<label for="filter_7">Information Technology</label>';
			echo '</div>';	
			
			echo '<div data-role="collapsible"><h3>State</h3>';
			echo '<input type="radio" id="filter_8" name="group_state" value="MO" ';
			if ($_SESSION['filters']['group_state']== 'MO') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_8">Missouri</label>';
			
			echo '<input type="radio" id="filter_9" name="group_state" value="IL"';
			if ($_SESSION['filters']['group_state']=='IL') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_9">Illinois</label>';
			
			echo '<input type="radio" id="filter_10" name="group_state" value="KS"';
			if ($_SESSION['filters']['group_state']=='KS') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_10">Kansas</label>';
			
			echo '<input type="radio" id="filter_11" name="group_state" value="IA"';
			if ($_SESSION['filters']['group_state']=='IA') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_11">Iowa</label>';
			
			echo '<input type="radio" id="filter_12" name="group_state" value="CO"';
			if ($_SESSION['filters']['group_state']=='CO') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_12">Colorado</label>';
			echo '</div>';

			echo '<div data-role="collapsible"><h3>Position</h3>';
			echo '<input type="radio" id="filter_13" name="group_type" value="Full Time" ';
			if ($_SESSION['filters']['group_type']== 'Full Time') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_13">Full Time</label>';
			
			echo '<input type="radio" id="filter_14" name="group_type" value="Internship/Coop"';
			if ($_SESSION['filters']['group_type']=='Internship/Coop') echo ' checked/>'; else echo '/>';
			echo '<label for="filter_14">Internship/Coop</label>';
			echo '</div>';
			echo '</fieldset></form>';
			?>
		</div>
	</div>
	
	<form id="reset" method="get" action="companyFilter.php">
		<input type="hidden" name="reset" value="true">
	</form>
	
	<div data-role="footer" data-position="fixed">
		<center>
		<a data-role="button" data-theme="b" onclick="submitFilter();" data-inline="true">Save</a>
		<a data-role="button" data-theme="b" onclick="Reset();" data-inline="true">Reset</a>
        </center><center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
	</div>
</div>
</body>
</html>