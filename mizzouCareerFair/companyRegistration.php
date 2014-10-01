<?php
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
	function submitEmployer()
	{
		document.getElementById("employerForm").submit();
	}
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
		<h1>Employer Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
			<?php handleRegistration(); ?>
		<form id="employerForm" method="post" action="companyRegistration.php" >
					<label for="company"><b>You are registering for:</label>
					<input type="text" name="company" id="company" value="<?php print $_GET['company']; ?>" readonly> 
					<label for="email"><b>Enter your Contact Email:</label>
					<input type="text" name="email" id="email" placeholder="In case you forget your credentials"> 
					<label for="username"><b>Choose a Username:</label>
					<input type="text" name="username" id="username" placeholder="At least 5 characters">       
					<label for="password"><b>Choose a Password:</label>
					<input type="password" name="password" id="password" placeholder="At least 5 characters">
			</form>
			<center>
				<!-- <a href="companyRegistration.php" data-inline="true" data-role="button" value="Submit" onclick="submitEmployer()">Submit</a> -->
				<input type="submit" data-inline="true" value="Submit" onClick="submitForm=true;" OnSubmit="submitEmployer();" value="Submit">
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
	// If logged in, don't let anyone RE-register
	if (isset($_SESSION['student_loggedin']) )
	{
		header("Location: index.php");
		exit();
	}
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
}
//Function to Handle employer Login
function handleRegistration()
{
	if( isset($_POST['username']) )
	{
		//Include Database information
		if($_SERVER['HTTP_HOST'] == 'localhost')
			include('data_ryanslocal.php');
		else
			include ("data.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
		if (!$conn) 
		{
			echo "\n<div class='container'>\n\t<div class ='alert alert-danger'>";
			echo "<center>An Error occurred during connection.</center>";
			echo "\n\t</div>\n</div>";
			exit();
		}
		echo pg_last_error($conn);
		$user = htmlspecialchars($_POST['username']);

		//Run username against employer Database
		$query = "SELECT * FROM careerschema.employerauthentication WHERE username =$1" ;
		
		$stmt = pg_prepare($conn, "register_0", $query)  or die( pg_last_error() );
		$result = pg_execute($conn, "register_0" ,array($user) ) ;
		
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
			$query = "INSERT INTO careerschema.employerinfo (username, contact_email) VALUES ($1,$2)";
			$state = pg_prepare($conn,"insert_0",$query) ;
			$queryInsert = pg_execute($conn,"insert_0",array($user,$_POST['email']));
			
			//Then we can add their authentication information
			$query = "INSERT INTO careerschema.employerauthentication (username,salt,password_hash) VALUES ($1,$2,$3)";
			$state = pg_prepare($conn,"insert_employer",$query) ;
			$queryInsert = pg_execute($conn,"insert_employer",array($user,$salt,$passHashed ) )  ;

			if ($queryInsert)
			{
				$_SESSION['registered'] = TRUE;
				header("Location: tigerspop.php");
				exit();
			}
			else
				echo pg_last_error($conn);
		}
	}
}
?>