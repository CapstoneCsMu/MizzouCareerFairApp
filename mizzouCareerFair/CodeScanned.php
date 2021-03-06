<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$_SESSION['prevPage'] = 'employerView.php';
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
</head>
<body>
	<?php
		//query db for ip address
		$query = "SELECT ip_address FROM careerschema.authorizationTable WHERE ip_address=($1)";
		$stmt = pg_prepare($conn, "grab_ip", $query);
		//sends query to database
		$result = pg_execute($conn, "grab_ip", array($_SERVER['REMOTE_ADDR']));

		//if database doesnt return results make them log in
		if(!$result) {
			
			echo "<script type=\"text/javascript\">";
			echo "window.location='login.php'";
			echo "</script>";
		}
		//if there is a result, log them in with that ip address
		if($_SERVER['REMOTE_ADDR'] == $result){
                                
			$ip_address = $result;
			
			$query = "SELECT email FROM careerschema.authorizationTable(email) WHERE ip_address=($1)";
			$stmt = pg_prepare($conn, "grab_email", $query);
			//sends query to database
			$result = pg_execute($conn, "grab_email", array($ip_address));
			//if database doesnt return results print this
			if(!$result) {
				die("Unable to execute: here" . pg_last_error($conn));
				
			}
			
		$_SESSION['employer_loggedin'] == $result;
		};
		
		$empEmail = $_SESSION['employer_loggedin'];
		
		echo $empEmail;
		echo '</br>';
	    include ("data.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
        if (!$conn)
        {
            echo "<br/>An error occurred with connecting to the server.<br/>";
            die();
        }
		
		if ($_SESSION['employer_loggedin'])
		{
			//Grab first and last name of the email
			$query = "select firstname, lastname from careerschema.students where email =$1";
			$stmt = pg_prepare($conn, "grab_student_info", $query) or die(pg_last_error());
			$result = pg_execute($conn, "grab_student_info", array($_GET['email'])) or die(pg_last_error());
			$row = pg_fetch_assoc($result);
			echo "firstname: ".$row['firstname'];
			echo "</br>";
			echo "lastname: ".$row['lastname'];
			
			//add student email and employer email into employer
			$query = "INSERT INTO careerschema.employerScannedStudents(email, employerEmail, firstname, lastname) VALUES($1,$2, $3, $4)";
			$stmt = pg_prepare($conn, "insert_email", $query) or die(pg_last_error());
			//sends query to database
			$result = pg_execute($conn, "insert_email", array($_GET['email'], $empEmail, $row['firstname'], $row['lastname'])) or die(pg_last_error());
			//if database doesnt return results print this
			if(!$result) {
					die("Unable to execute: " . pg_last_error($conn));
			}
			else
			{
				echo "<script type=\"text/javascript\">";
				echo "window.location='employerView.php'";
				echo "</script>";
			}
		}
	?>
</body>
</html>