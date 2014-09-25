<!DOCTYPE html>
<html>
<head>
    <title>Login</title> 
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <!-- Include CSS and JQM CSS -->
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
    <link href="http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script>
	<script type="text/javascript">
		function submitLogin()
		{
			document.getElementById("loginForm").submit();
		}
		function redirect()
		{
			window.location = "registration.php";
		}
		function notify()
		{
			// Prompt User for Email 
			prompt("Please enter your email address");
			// Alert on Success (To be implemented later)
			alert("An email has been sent to you.");
		}
	</script>
</head>
<body>
		<div data-role="page" data-dialog="true" id="index.php">
			<div data-role="header">
				<h1>Login</h1>
			</div>
			<div>
			<?php
				// To access $_SESSION, we have to call session_start()
				if (!isset($_SESSION))
				{
					session_start();
				}
				// check https
				if ($_SERVER['HTTPS'] == "on") 
				{
					handle_login();
				}
				// For local hosted purposes
				else if ($_SERVER['HTTP_HOST'] == 'localhost')
				{
					handle_login();
				}
				// Else force user to login through HTTPS
				else
				{
						header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
						exit();
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
				
				function handle_login()
				{
					if ($_SESSION['registered'])
					{
						echo "\n<div class ='alert alert-success alert-dismissable'>";
						echo "\n\t<center>Thank you for Registering.</center>"; 
						echo "\n</div>";
					}
					if( isset($_POST['username']) )
					{
						if (!isset($_COOKIE['firsttime']))
						{
							setcookie("firsttime", "no", 0 );// Set Cookie to expire at close of browser
							$_SESSION['login_attempts'] == 0; //keep Track of Visits
						}

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
						$query = array(
										0 =>"SELECT salt, password_hash FROM careerschema.studentauthentication WHERE username =$1",
										1 =>"SELECT salt, password_hash FROM careerschema.adminauthentication WHERE username =$1",
										2 =>"SELECT salt, password_hash FROM careerschema.employerauthentication WHERE username =$1"
										);

						//Search the three tables for authentication success
						$userWasFound = FALSE;
						
						for ($p=0; $p<count($query);$p++)
						{
							$stmt = pg_prepare($conn, "check_".$p, $query[$p])  or die( "ERROR:". pg_last_error() );
							$result = pg_execute($conn, "check_" .$p,array(htmlspecialchars($_POST['username'])))  or die( "ERROR:". pg_last_error() );
							if(pg_num_rows($result) > 0)
								{
									$userWasFound = TRUE;
									break;
								}
						}
						if (!$userWasFound)
						{
							echo "\n<div class ='alert alert-danger alert-dismissable'>";
							echo "\n\t<center>User does not exist.</center>"; 
							echo "\n</div>";
						}
						else
						{
							$row = pg_fetch_assoc($result);
							$salt = $row['salt'];
							$salty = sha1($salt);
							$salty = trim($salt);
							$password = htmlspecialchars($_POST['password_hash']);
							$localHash = sha1($salty.$password);

							for ($i=0; $i<10000; $i++) //Slow Hashing
							{
								$localHash = sha1($localHash);
							}
							if ($localHash === $row['password_hash'] ) //if entered password equals stored password
							{
								// Conditional Handling
								if ($p ==0)
								{
									$_SESSION['student_loggedin'] = htmlspecialchars($_POST['username']);
									header("Location: index.php");
									exit;
								}
								if ($p ==1)
								{
									$_SESSION['admin_loggedin'] = htmlspecialchars($_POST['username']);
									header("Location: admin.php");
									exit;
								}
								if ($p ==2)
								{
									$_SESSION['employer_loggedin'] = htmlspecialchars($_POST['username']);
									header("Location: employer.php");
									exit;
								}
							}
							else
							{
								$_SESSION['login_attempts']++;
								echo "\n<div class ='alert alert-danger alert-dismissable'>";
								if ($_SESSION['login_attempts'] > 4)
								{
									echo '<center>Have you forgotten your password?';
									echo '</br><input type="button" data-inline="true" value="Click to reset" onclick="notify();"></center>';
								}
								else
									echo"\n\t<center>Incorrect Password</center>";
								echo "\n</div>";
							}
						}
					}
				}
			?>
			</div>
			<div data-role="main" class="ui-content">
				<form id="loginForm" method="post" action="tigerspop.php">
					<div class="ui-field-contain">
						<label for="username">Username:</label>
							<input type="text" name="username" id="username">       
						<label for="password">Password:</label>
							<input type="password" name="password" id="password" onblur="submitLogin()">
					</div>
					</form>
					<center>
						<a href="tigerspop.php" data-inline="true" data-role="button" value="Submit" onclick="submitLogin();">Submit</a>
					</center>
			</div>
			<center>
			<div data-role="footer">
				<p>Don't have an account?</p>
				<input type="button" value="Register" onclick="redirect();">
			</div>
			</center>
		</div>
</body>
</html>