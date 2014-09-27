<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Mizzou Career Fairs
</title> 
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1" name="viewport">

    <!-- Include CSS and JQM CSS -->
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
	<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
</head>

<div data-role="page" data-theme="a" id="fairs">
	<div data-role="header" data-position="fixed">
		<h1>Fairs</h1>
		<a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="index.php">Home</a> 
	</div>
	<div data-role="content">
		<ul data-dividertheme="b" data-inset="true" data-role="listview">
		<li data-role="list-divider">Select a Career Fair</li>
		<?php
			//Include Database information
			if($_SERVER['HTTP_HOST'] == 'localhost')
				include('data_ryanslocal.php');
			else
				include ("data.php");

			//get rss info from database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
			$query = 'SELECT fairName FROM careerSchema.rssinfo ORDER BY fairName ASC';
			$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
			//counter
			$numOfFeeds=0;
			while ($fair = pg_fetch_array($result, null, PGSQL_ASSOC))
			{
				echo '<li><a data-transition="slide" href="index.php" onclick="submitForm_'.$numOfFeeds.'()">'.$fair['fairname'].'</a></li>';
				$fairForm[$numOfFeeds] = $fair['fairname'];
				
				//Javascript to input the info and then submit the User-Specified form
				echo'<script type="text/javascript">
							function submitForm_'.$numOfFeeds.'(){
								document.getElementById("myForm'.$numOfFeeds.'").submit();
							}
							</script>';
							
				$numOfFeeds++;
			}
			
			//Dynamically creates a form for each RSS Feed, so tha the right form can be submitted by the user.
			for ($j=0; $j<$numOfFeeds; $j++)
			{
				echo '<form id="myForm'.$j.'" method="post" action="index.php">';
				echo '<input type="hidden" name="fairname" value="'.$fairForm[$j].'">';
				echo '</form>';
			}
			
		?>
	</div>
</div>