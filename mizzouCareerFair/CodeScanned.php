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
			//add student email and employer email into employer
			$query = "INSERT INTO careerschema.employerScannedStudents(email, employerEmail) VALUES($1,$2)";
			$stmt = pg_prepare($conn, "insert_email", $query) or die(pg_last_error());
			//sends query to database
			$result = pg_execute($conn, "insert_email", array($_GET['email'], $empEmail)) or die(pg_last_error());
			//if database doesnt return results print this
			if(!$result) {
					die("Unable to execute: " . pg_last_error($conn));
			}
			
			echo "Thank you for scanning this students QR code. Their information is now stored on your page."; 
		}
	?>
</body>
</html>