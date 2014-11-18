<?php
/* File: tigerspop.php
Parent: registration.php (approx. line 58)
Purpose: This file is used to verify the user is actually a Mizzou Student.

*/
include('check_https.php');
include('ldap.php');
// If logged in, don't let anyone RE-register
if (isset($_SESSION['student_loggedin']) )
{
    session_start();
    header("Location: index.php");
}
if(isset($_SESSION['admin_loggedin']))
{
    session_start();
    header("Location: admin.php");
}

if(isset($_SESSION['employer_loggedin']))
{
    session_start();
	header("Location: employerView.php");
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Registration</title>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <!-- Include CSS and JQM CSS -->
        <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
        <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
        <link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
        <link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
        <script src="js/jquery-1.11.1.min.js"></script>
        <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
    </head>
    <body>
    <div data-role="page" data-dialog="true">
        <div data-role="header">
            <a data-icon="delete" data-transition="slideup" data-iconpos="notext" href="registration.php" rel="external">Back</a>
            </br><center>Student Verification</center></br>
        </div>

        <div data-role="main" class="ui-content">
            <form id="loginForm" method="post" action="tigerspop.php" data-ajax="false">
                <div class="ui-field-contain">
	
		<div class ='alert alert-info alert-dismissable'>
		<center><b>Disclaimer:</b> To register, you must be an MU student. We will not store your official password.</center>
		</div>
                    <label for="pawprint">Pawprint:</label>
                    <input type="text" name="pawprint" id="pawprint">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <center><input type="submit" data-inline="true" name="Submit" value="Submit"></center>
            </form>
        </div>
    </div>
    </body>
    </html>
<?php

if(isset($_POST['Submit']))
{
	 $pawprint = htmlspecialchars($_POST['pawprint']);
	 $_SESSION['pawprint'] = $pawprint;
	 $password = htmlspecialchars($_POST['password']);
	 $identified = true;
	 $identified = authenticateToUMLDAP($pawprint, $password);
	if($identified !== true){
		
		if($identified == false){
			$_SESSION['student_authenticated'] = false;
			header("Location: login.php");
			exit();	
		}
		else{	
			$_SESSION['student_authenticated'] = true;
			header("Location: registration.php#student");
			exit();	
		}
	}
}
