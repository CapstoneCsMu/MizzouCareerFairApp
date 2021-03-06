<?php
	/*
	File: addResume.php 
	Parent: index.php
	Purpose: Form to upload resume. Calls updateProfile.php when Upload button is pressed.
	*/

include('check_https.php');
	session_start();
	$_POST['student_loggedin'] = $_SESSION['student_loggedin'];
	$email = $_POST['student_loggedin'];
	
function check_resume()
{
		//Include Database information
		if($_SERVER['HTTP_HOST'] == 'localhost')
			include('data_ryanslocal.php');
		else
			include ("data.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not emaiconnect:'. pg_last_error());
		if (!$conn) 
		{
			echo "<br/>An error occurred connecting to the server.<br/>";
			die();
		}

		//Run variables against dB
		$query = array( 0 =>"SELECT * FROM careerschema.students WHERE email=$1");

		//Search the three tables for authentication success
		$userWasFound = FALSE;
			
		for ($p=0; $p<count($query);$p++)
		{
			$stmt = pg_prepare($conn, "check_".$p, $query[$p])  or die( "ERROR:". pg_last_error() );
			$result = pg_execute($conn, "check_".$p, array($email))  or die( "ERROR:". pg_last_error() );
			if(pg_num_rows($result) > 0)
			{
				$userWasFound = TRUE;
				$row = pg_fetch_assoc($result);
				if (($row['resume']) != ""){
					//$resume = "Resume on file";
					echo "<div class ='alert alert-danger'>";
					echo "<center>Resume on file!</center>";
					echo "\n\t</div>";
				}
			}
		}
		pg_close($conn);	
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
	
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <!-- Include JS file for our JS -->
    <script src="js/index.js"></script>
    
    <!-- Include LinkedIn Framework, API Key Unique to Us -->
	<?php if($_SERVER['HTTP_HOST'] == 'localhost'): ?>
		<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  		api_key: 750nr1ytn6d9bz
  		onLoad: onLinkedInLoad
  		authorize: true
	</script>
	<?php else: ?>
	<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  		api_key: 75a6k7ahbjlrny
  		onLoad: onLinkedInLoad
  		authorize: true
	</script>
	<?php endif; ?>
	<!-- Include Google Maps API -->
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>

	<script type="text/javascript" src="index.js"></script>

</head>

<body>
	<div data-role="page" data-dialog="true">
		<div data-role="header">
				<a data-icon="delete" data-transition="slideup" data-iconpos="notext" href="index.php">Back</a> 
				<h1>Add your Resume</h1>
				
		</div>
			
		<div data-role="main" class="ui-content">
		
			<div class="ui-field-contain">
			<?php check_resume(); ?>
				<form id="uploadResume" method="post" enctype ="multipart/form-data" action="updateProfile.php" data-ajax="false">
					
					<div data-role="fieldcontain">	
							
						<label for="resume">Resume:</label>
						<input type="file" name="resume" id="resume" value="<?php echo $resume; ?>"data-mini="true">
						<input type="hidden" name="email" id ="email" value="<?php echo $email; ?>">
					</div>
					<div data-role="fieldcontain">		
						<center><input type="submit" data-inline="true" data-mini="true" data-icon="plus" name="Upload" value="Upload Resume">
									
						<input type="submit" data-inline="true" data-mini="true" data-icon="arrow-r" name="Next" value="Update Profile"></center>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>