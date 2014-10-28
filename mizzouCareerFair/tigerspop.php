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
    header("Location: employerView.php");
}
?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login</title>
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
    <div data-role="page" data-dialog="true">
        <div data-role="header">
            <a data-icon="delete" data-transition="slideup" data-iconpos="notext" href="index.php">Back</a>
            </br><center>Login</center></br>
        </div>
        <div>
            <?php
           // handle_login();
            ?>
        </div>
        <div data-role="main" class="ui-content">
            <form id="loginForm" method="post" action="tigerspop.php" data-ajax="false">
                <div class="ui-field-contain">
				Disclaimer:  We ask you to enter your pawprint and password to check if you are a current University of Missouri student.  We will not store this information at all!<br><br>
				
                    <label for="pawprint">Pawprint:</label>
                    <input type="text" name="pawprint" id="pawprint">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <center><input type="submit" data-inline="true" name="Submit" value="Submit"></center>
            </form>
            <center>

                <!-- <a href="tigerspop.php" data-inline="true" data-role="button" value="Submit" onclick="submitLogin();">Submit</a> -->
            </center>
        </div>
        <center>
            <div data-role="footer">
                <p>Don't have an account?</p>
                <!--<center><a href="registration.php" data-role="button" data-transition="pop" rel="external" onclick="redirect();">Register</a></center>-->
				<center><a href="tigerspop.php" data-role="button" data-transition="pop" rel="external" onclick="redirect();">Register</a></center>
          
            </div>
        </center>
    </div>
    </body>
    </html>
<?php

if(isset($_POST['Submit']))
{
	 $pawprint = htmlspecialchars($_POST['pawprint']);
	 $password = htmlspecialchars($_POST['password']);
	 $identified = true;
	 $identified = authenticateToUMLDAP($pawprint, $password);
	if($identified !== true){
		
		if($identified == false){
			header("Location: index.php#failureRegistration");
			//might be good to add a session variable to avoid registration of non-student in db due to 
			//hardtyped URL (.../registration.php#student).  I'll do it later - Cecilia
			//$_SESSION['active_student'] = "no";
			exit();	
		}
		else{		
			header("Location: registration.php#student");
			//$_SESSION['active_student'] = "yes";
			exit();	
		}
	}
	else 
	{
		echo "Your code doesn't work";
		exit();
	}
}