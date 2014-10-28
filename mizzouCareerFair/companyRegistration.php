<?php
	/*File:  companyRegistration.php 
	Parent:  Registration.php (calls companyRegistration at line 223)
	Function:  Employer Registration form, register employer company, email and password*/
	pre_process();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title> 
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    
    <!-- Include CSS and JQM CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
	<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	
    <!-- Include jQuery and jQuery Mobile CDN, add actual files  -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
	<script type="text/javascript">

	//Prevent Page Refresh
	var submitForm = false;
	window.onbeforeunload = function() {
		if (!submitForm)
			return "If you reload some information may be lost.";
    }
	</script>
</head>
</body>
<div data-role="page" id="employer" data-dialog="true">
	<div data-role="header">
		<a rel="external" data-icon="arrow-l" data-iconpos="notext" href="registration.php#employer">Back</a> 
		<a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a> 
		<h1>Employer Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
			<?php handleRegistration(); ?>
		<form id="employerForm" name="employerForm" method="post" action="companyRegistration.php" >
					<label for="company"><b>You are registering for:</label>
					<input type="text" name="company" id="company" value="<?php print $_SESSION['coReg']; ?>" readonly> 
					<label for="email"><b>Email (<a href="#emailpop" data-rel="popup"><b>?</a>):</label>
					<div data-role="popup" id="emailpop">
						<p>This email will be used if you forget your password and can be shared for students to contact you upon request.</p>
					</div>
					<input type="text" name="email" id="email" value="<?php print $_SESSION['coEmail']; ?>" > 
					<!--<label for="username"><b>Choose a Username:</label>
					<input type="text" name="username" id="username" placeholder="At least 5 characters">    --->   
					<label for="password"><b>Choose a Password:</label>
					<input type="password" name="password" id="password" placeholder="At least 5 characters">
			</form>
			<center>
				<input type="submit" data-inline="true" name="Submit" onClick="submitForm=true;" value="Submit">
			</center>

	</div>
	<div data-role="footer" class="ui-bar">
		<br>
	</div>	
</div>
</body>
</html>
<?php
//Function to Redirect or Force HTTPS 
function pre_process()
{
	include('check_https.php');
	// If logged in, don't let anyone RE-register COMMENTED JUST FOR TESTING PURPOSES, FOR PRODUCTION UNCOMMENT THIS

	if (isset($_SESSION['student_loggedin']) )
	{
		header("Location: index.php");
		exit();
	}
		/*
	if(isset($_SESSION['admin_loggedin']))
	{
		header("Location: index_admin.php");
		exit();
	}
	if(isset($_SESSION['employer_loggedin']))
	{
		header("Location: index_employer.php");
		exit();
	}
	if ($_SESSION['registered'])
	 {
		header("Location: tigerspop.php");
		exit();
	}
	*/
}
//Function to Handle employer Login
function handleRegistration()
{
	$_SESSION['coEmail'] = $_POST['email'];
	if( $_POST['Submit'])
	{
		if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['company']))
		{
			//Validate Email
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				echo "<div class ='alert alert-danger'>";
				echo "<center>Invalid Email.</center>";
				echo "\n\t</div>";	
			}
			else
			{
				//Include Database information
				if($_SERVER['HTTP_HOST'] == 'localhost')
					include('data_ryanslocal.php');
				else
					include ("data.php");
				$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
				if (!$conn) 
				{
					echo "<div class ='alert alert-danger'>";
					echo "<center>An error occured during connection to our server.</center>";
					echo "\n\t</div>";	
				}
				echo pg_last_error($conn);
				
				$email = htmlspecialchars($_POST['email']);
				$company = htmlspecialchars($_POST['company']);

				//Run username against employer Database
				$query = "SELECT * FROM careerschema.authorizationTable WHERE email =$1" ;
				
				$stmt = pg_prepare($conn, "register_0", $query)  or die( pg_last_error() );
				$result = pg_execute($conn, "register_0" ,array($email) ) ;
				
				//Check to see if login user exists, if not do nothing
				if(pg_num_rows($result) > 0)
				{
					echo "<div class ='alert alert-danger'>";
					echo "<center>User already exists.</center>";
					echo "\n\t</div>";
				}
				else
				{
					mt_srand(); //Seed number generator
					$salt = mt_rand(); //generate salt
					$salt = sha1($salt);
					$pass = htmlspecialchars($_POST['password']);
					$passHashed = sha1($salt.$pass);

					for ($i=0; $i<10000; $i++) //Slow Hashing
					{
						$passHashed = sha1($passHashed);
					}
					//Insert user into the employerinfo table
					/*$query = "INSERT INTO careerschema.authorizationTable (email) VALUES ($1)";
					$state = pg_prepare($conn,"insert_0",$query) ;
					$queryInsert = pg_execute($conn,"insert_0",array($_POST['email']));*/
					
					//Then we can add their authentication information
					$query = "INSERT INTO careerschema.authorizationTable (email, hashed_pass, salt, user_type,company) VALUES ($1,$2,$3,$4,$5)";
					$state = pg_prepare($conn,"insert_employer",$query) ;
					$queryInsert = pg_execute($conn,"insert_employer",array($email,$passHashed,$salt,"employer",$company) )  ;

					if ($queryInsert)
					{
						$_SESSION['registered'] = TRUE;
						echo '<script type="text/javascript"> window.location = "login.php"; </script>';
					}
					else
						echo pg_last_error($conn);
				}
			}
		}
		else
		{
			echo "<div class ='alert alert-danger'>";
			echo "<center>All Fields must be filled out.</center>";
			echo "\n\t</div>";	
		}
	}
	else
		$_SESSION['coReg'] = $_GET['company'];
}
?>