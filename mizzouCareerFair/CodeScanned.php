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
	    include ("data.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
        if (!$conn)
        {
            echo "<br/>An error occurred with connecting to the server.<br/>";
            die();
        }
		echo "before loop";
		
		if ($_SESSION['employer_loggedin'])
		{
			echo "after loop";
			//add email into employer table first
			$query = "INSERT INTO careerschema.employerScannedStudents(email, employerEmail) VALUES=($1,$2)";
			$stmt = pg_prepare($conn, "store_info", $query);
			//sends query to database
			$result = pg_execute($conn, "store_info", array($_GET['email'], $_SESSION['employer_loggedin']));
			//if database doesnt return results print this
			if(!$result) {
					die("Unable to execute: " . pg_last_error($conn));
			}
			
			echo "Thank you for scanning this students QR code. Their email is now stored on your page." 
		}
	?>
</body>
</html>