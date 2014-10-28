<?php
/*
	File: registration.php
	Parent: index.php
	Purpose: Register a new student or employer. Employer registration call function to display employers
	*/
	
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
	function submitStudent()
	{
		document.getElementById("studentForm").submit();
	}
	function hideHelp()
	{
		var help = document.getElementById('help');
		help.style.display = "none";
	}
	function showHelp()
	{
		var help = document.getElementById('help');
		help.style.display = "block";
	}
	</script>

</head>
<body>

<div data-role="page" data-dialog="true">
	<div data-role="header">
	<a rel="external" data-icon="arrow-l" data-iconpos="notext" href="login.php">Back</a> 
		<a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a> 
		<h1>Registration</h1>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
		<div class="ui-block-a">
			<a data-role="button" data-transition="slidedown" href="tigerspop.php" data-corners="true">Student</a>
		</div>
		<div class="ui-block-b">
			<a data-role="button" data-transition="slidedown" href="#employer" data-corners="true">Employer</a>
		</div>
	</div>
	<div data-role="footer">
		</br>
	</div>	
</div>	

<div data-role="page" id="employer" data-dialog="true"]>
	<div data-role="header">
	<a data-icon="delete" data-transition="pop" data-iconpos="notext" href="registration.php">Back</a> 
		</br><center>Employer Registration</center></br>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
		<form class="ui-filterable">
			Select a Company:
			<input id="pre-rendered-filterable" data-type="search" placeholder="Which company?">
		</form>
		<div class="ui-controlgroup ui-controlgroup-vertical ui-corner-all"
				data-role="controlgroup"
				data-filter="true"
				data-input="#pre-rendered-filterable"
				data-filter-reveal="true"
				data-enhanced="true"> <!-- enhanced filtering resource: http://api.jquerymobile.com/filterable/ -->
		
			<div class="ui-controlgroup-controls">
			<?php displayCompanies(); ?>
			</div>
		</div>
		<div id="help" style="display:block">
			<center>
				<HR><h6>If you do not find your company, please register with <a target="_blank" href="https://www.myinterfase.com/umcolumbia/contactregco.aspx">HireMizzouTigers</a></h6>
			</center>
		</div>
	</div>
	<div data-role="footer" class="ui-bar">
		<br>
	</div>	
</div>

<div data-role="page" id="student" data-dialog="true">
	<div data-role="header">
	</br>
		<a data-icon="delete" data-transition="pop" data-iconpos="notext" href="registration.php">Back</a> 
		<center>Student Registration</center>
	</br>
	</div>
	<div data-role="main" class="ui-content ui-grid-a">
	<?php handleStudentRegistration(); ?>
		<form id="studentForm" method="post" action="registration.php#student">
					<label for="email"><b>Email:</label>
					<input type="text" name="email" id="email"> 
					<!--<label for="username"><b>Choose a Username:</label>
					<input type="text" name="username" id="username" placeholder="At least 5 characters">   --->    
					<label for="password"><b>Choose a Password:</label>
					<input type="password" name="password" id="password" placeholder="At least 5 characters">
		</form>
			<center>
				<a href="login.php" data-inline="true" data-role="button" value="Submit" onclick="submitStudent()">Submit</a> 
				<!-- <input type="submit" data-inline="true" value="Submit" OnSubmit="submitStudent();" value="Submit"> -->
			</center>
	</div>
	<div data-role="footer">
		</br>
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
	
	if( isset($_POST['email']) )
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
		$email = htmlspecialchars($_POST['email']);

		//Run email against student Database
		$query = "SELECT * FROM careerschema.students WHERE email =$1" ;
		
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
			$salt = trim($salt);
			$pass = htmlspecialchars($_POST['password']);
			$passHashed = sha1($salt.$pass);

			for ($i=0; $i<10000; $i++) //Slow Hashing
			{
				$passHashed = sha1($passHashed);
			}
			
			//Insert user into the students table
			$query = "INSERT INTO careerschema.students (email) VALUES ($1)";
			$state = pg_prepare($conn,"insert_0",$query) ;
			$queryInsert = pg_execute($conn,"insert_0",array($_POST['email']));
			
			//Then we can add their authentication information
			$query = "INSERT INTO careerschema.authorizationTable (email, hashed_pass, salt, user_type) VALUES ($1,$2,$3,$4)";
			$state = pg_prepare($conn,"insert_1",$query) ;
			$queryInsert = pg_execute($conn,"insert_1",array($email,$passHashed,$salt,"student") )  ;

			if ($queryInsert)
			{
				$_SESSION['registered'] = TRUE;
				header("Location: login.php");
			}
			else
				echo pg_last_error($conn);
		}
	}
}

function displayCompanies()
{
	session_start();
	foreach($_SESSION['companies'] as $index => $val)
	{
		$url = str_replace( '&', "%26", $val);
		echo '<a rel="external" data-transition="fade" data-role="button" class="ui-screen-hidden" href="companyRegistration.php?company='.htmlentities($url).'">'.$val.'</a>';
	}
}
?>