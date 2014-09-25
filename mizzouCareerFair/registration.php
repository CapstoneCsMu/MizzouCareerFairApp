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
	
    <link href="http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script>
	<script type="text/javascript">
	function submitStudent()
	{
		document.getElementById("studentForm").submit();
	}
	function submitEmployer()
	{
		document.getElementById("employerForm").submit();
	}
	</script>
</head>
<body>
<div data-role="page" data-dialog="true" >
	<div data-role="header">
		<h1>Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
		<div class="ui-block-a">
			<a data-role="button" data-transition="fade" href="#student" data-corners="true">Student</a>
		</div>
		<div class="ui-block-b">
			<a data-role="button" data-transition="fade" href="#employer" data-corners="true">Employer</a>
		</div>
	</div>
	<div data-role="footer">
		</br>
	</div>		
</div>

<div data-role="page" id="student" data-dialog="true">
	<div data-role="header">
		<h1>Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
	<?php
		handleStudentRegistration();
	?>
		<form id="studentForm" method="post" action="registration.php#student" >
					<label for="email"><b>Email:</label>
					<input type="text" name="email" id="email" placeholder="In case you forget your credentials"> 
					<label for="username"><b>Choose a Username:</label>
					<input type="text" name="username" id="username" placeholder="At least 5 characters">       
					<label for="password"><b>Choose a Password:</label>
					<input type="password" name="password" id="password" placeholder="At least 5 characters" onblur="submitStudent();">
			</form>
			<center>
				<a href="registration.php" data-inline="true" data-role="button" value="Submit" onclick="submitStudent();">Submit</a>
			</center>
	</div>
	<div data-role="footer">
		</br>
	</div>		
</div>

<div data-role="page" id="employer" data-dialog="true">
	<div data-role="header">
		<h1>Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
	</div>
	<div data-role="footer">
		</br>
	</div>	
</div>
</body>
</html>
<?php
//Function to Redirect or Force HTTPS on bad guys
function pre_process()
{
	// To access $_SESSION, we have to call session_start()
	if (!isset($_SESSION))
	{
		session_start();
	}
	// check https and FORCE https on bad guys
	if ($_SERVER['HTTPS'] != "on" && $_SERVER['HTTP_HOST'] != 'localhost') 
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	}
	// If logged in, don't let anyone RE-register
	if (isset($_SESSION['student_loggedin']) )
	{
		header("Location: index.php");
	}
	if(isset($_SESSION['admin_loggedin']))
	{
		header("Location: index_admin.php");
	}
	if(isset($_SESSION['employer_loggedin']))
	{
		header("Location: index_employer.php");
	}
}
//Function to Handle Student Login
function handleStudentRegistration()
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
		$user = htmlspecialchars($_POST['username']);

		//Run username against student Database
		$query = "SELECT * FROM careerschema.students WHERE username =$1" ;
		$stmt = pg_prepare($conn, "register_0", $query)  or die( pg_last_error() );
		$result = pg_execute($conn, "register_0" ,array($user) ) ;
		//Check to see if login user exists, if not do nothing
		if(pg_num_rows($result) == 1)
		{
			echo "<div class ='alert alert-danger'>";
			echo "<center>User already exists.</center>";
			echo "\n\t</div>";
		}
		mt_srand(); //Seed number generator
		$salt = mt_rand(); //generate salt
		$salt = sha1($salt);
		$pass = htmlspecialchars($_POST['pass1']);
		$passHashed = sha1($salt.$pass);

		for ($i=0; $i<10000; $i++) //Slow Hashing
		{
			$passHashed = sha1($passHashed);
		}
		//Insert user into the database
		$query = "INSERT INTO careerschema.students (username,firstname,lastname, degreecode, email) VALUES ($1,$2,$3, $4, $5)";
		$state = pg_prepare($conn,"insert_0",$query) ;
		//or die( "Error:". pg_last_error() ); Need a better way to error check. WE may need to error check using Javascript / Ajax XMLHttpRequests first
		$queryInsert = pg_execute($conn,"insert_0",array($user,$_POST['firstname'],$_POST['lastname'], 1 , $_POST['email']) )  ;
		//or die( "Error:". pg_last_error() ); Need a better way to error check
		//Then we can add their authentication information
		$query = "INSERT INTO careerschema.studentauthentication (username,salt,password_hash) VALUES ($1,$2,$3)";
		$state = pg_prepare($conn,"insert_1",$query) ;
		//or die( "Error:". pg_last_error() ); Need a better way to error check
		$queryInsert = pg_execute($conn,"insert_1",array($user,$salt,$passHashed ) )  ;
		//or die( "Error:". pg_last_error() ); Need a better way to error check

		if ($queryInsert)
		{
			$_SESSION['registered'] = TRUE;
			header("Location: tigerspop.php");
		}
	}
}
//Function to Handle Employer Login

?>