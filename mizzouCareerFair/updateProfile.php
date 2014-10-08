<?php
	include('check_https.php');
	session_start();
	$_POST['student_loggedin'] = $_SESSION['student_loggedin'];
		//Include Database information
		if($_SERVER['HTTP_HOST'] == 'localhost')
			include('data_ryanslocal.php');
		else
			include ("data.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
		if (!$conn) 
		{
			echo "<br/>An error occurred with connecting to the server.<br/>";
			die();
		}

		//Run variables against dB
		$query = array( 0 =>"SELECT * FROM careerschema.students WHERE email=$1");

		//Search the three tables for authentication success
		$userWasFound = FALSE;
			
		for ($p=0; $p<count($query);$p++)
		{
			$stmt = pg_prepare($conn, "check_".$p, $query[$p])  or die( "ERROR:". pg_last_error() );
			$result = pg_execute($conn, "check_".$p, array(htmlspecialchars($_POST['email'])))  or die( "ERROR:". pg_last_error() );
			if(pg_num_rows($result) > 0)
			{
				$userWasFound = TRUE;
				break;
			}
		}
		if (!$userWasFound)
		{
			//code here 
		}
		else
		{	
			$row = pg_fetch_assoc($result);
			
			$firstname = $row['firstame'];
			$lastname = $row['lastname'];
			$email = $row['email'];
			$gradDate = $row['graddate'];
			$major = $row['major'];
			if (($row['resume']) != ""){
				$resume = "Resume on file";
			}
			$phone = $row['phone'];
			$goals = $row['lifeplan'];
			$linkedin = $row['linkedin_id'];
			//Cecilia: Left here 10/7/14 will finish the db insertion and update
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
				<h1>Update Profile</h1>
			</div>
			
			<div data-role="main" class="ui-content">
				<form id="updateInfoForm" method="post" action="updateProfile.php" data-ajax="false">
					<div class="ui-field-contain">
						<div data-role="fieldcontain">
							<label for="firstname">Firstname:</label>
							<input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>"data-mini="true">
						</div>
						<div data-role="fieldcontain">
							<label for="lastname">Lastname:</label>
							<input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" data-mini="true">
						</div>
						<div data-role="fieldcontain">
							<label for="email">E-mail:</label>
							<input type="email" name="email" id="email" value="<?php echo $email; ?>"data-mini="true">
						</div>
						<div data-role="fieldcontain">
							<label for="gradDate">Grad. Date:</label>
							<input type="text" name="gradDate" id="gradDate" value="<?php echo $gradDate; ?>"placeholder="Dec-2015" data-mini="true">
						</div>
						<div data-role="fieldcontain">
							<label for="major">Major:</label>
							<input type="text" name="major" id="major" value="<?php echo $major; ?>"data-mini="true">
						</div>
						<div data-role="fieldcontain">	
							<label for="resume">Resume:</label>
							<input type="file" name="resume" id="resume" value="<?php echo $resume; ?>"data-mini="true">
						</div>
						<div data-role="fieldcontain">	
							<label for="phone">Phone:</label>
							<input type="text" name="phone" id="phone" value="<?php echo $phone; ?>"placeholder="(xxx)xxx-xxxx" data-mini="true">
						</div>
						<div data-role="fieldcontain">	
							<label for="lifePlan">Career Goals:</label>
							<textarea rows="5" name="lifePlan" wrap="physical" maxlength="200" data-mini="true"id ="textarea"value="<?php echo $goals; ?>"></textarea>
						</div>
						<div data-role="fieldcontain">
							<label for="linkedIn">LinkedIn Email:</label>
							<input type="text" name="linkedIn" id="linkedIn" value="<?php echo $linkedin; ?>" data-mini="true">
						</div>	
					</div>
					<center><input type="submit" data-inline="true" value="Submit"></center>
				</form>
			</div>
	</div>
</body>
</html>