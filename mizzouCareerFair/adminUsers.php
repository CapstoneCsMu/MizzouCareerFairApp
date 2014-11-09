<?php
/*File:  admin.php
Parent:  login.php (redirects here upon admin logging in)
Function:  administrative dashboard to configure application*/
require_once('phpmailer/class.phpmailer.php');
include("rssFunctions.php");
session_start();
if(!$_SESSION['admin_loggedin']){
    $_SESSION['admin_attempt'] = "yes";
    header('Location: login.php');
}
//include ("data.php");
//$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
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

    <!-- Include LinkedIn Framework, API Key Unique to Us -->
    <?php if($_SERVER['HTTP_HOST'] == 'localhost'): ?>
        <script type="text/javascript" src="https://platform.linkedin.com/in.js">
            api_key: 750nr1ytn6d9bz
            onLoad: onLinkedInLoad
            authorize: true
        </script>
 <?php else: ?>
        <script type="text/javascript" src="https://platform.linkedin.com/in.js">
            api_key: 75a6k7ahbjlrny
            onLoad: onLinkedInLoad
            authorize: true
        </script>
    <?php endif; ?>
    <!-- Include Google Maps API -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>

    <script type="text/javascript" src="index.js"></script>

    <script type="text/javascript">
            function submitAdmin()
            {
                document.getElementById("addAdminForm").submit();
            }
   </script>

</head>

<body>

<div data-role="page" data-dialog="true">
        <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php">Back</a>
                <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
                <h1>Administration Options</h1>
        </div>
        <div data-role="main" class="ui-content ui-grid-a">
                <div class="ui-block-a">
                        <a data-role="button" data-transition="slidedown" href="#addAdmin" data-corners="true">Add Admin</a>
                </div>
                <div class="ui-block-b">
                        <a data-role="button" data-transition="slidedown" href="#deleteAdmin" data-corners="true">Delete Admin</a>
                </div>
        </div>
        <div data-role="footer">
                </br>
        </div>
</div>

<div data-role="page" id="addAdmin" data-dialog="true">
        <div data-role="header">
        </br>
                <a data-icon="delete" data-transition="pop" data-iconpos="notext" href="admin.php">Back</a>
                <center>Add Administrative User</center>
        </br>
        </div>
        <div data-role="main" class="ui-content ui-grid-a">

                <form method="post" id="addAdminForm" action="adminUsers.php#addAdmin" data-ajax="false" >
                                        <label for="email"><b>Email:</label>
                                        <input type="text" name="email" id="email">
                                        <label for="firstName"><b>First Name:</label>
                                        <input type="text" name="firstName" id="firstName">
                                        <label for="lastName"><b>Last Name:</label>
                                        <input type="text" name="lastName" id="lastName">
                                        <label for="password"><b>Choose a Password:</label>
                                        <input type="password" name="password" id="password" placeholder="At least 5 characters">
                                        <div class="submitBtn">
                                            <input type="submit" name="submit" value="Submit">
                                        </div>
                </form>

                                <?php if (isset($_POST['submit'])){ handleNewAdmin();} ?>



<div data-role="page" id="deleteAdmin" data-dialog="true">
        <div data-role="header">
        </br>
                <a data-icon="delete" data-transition="pop" data-iconpos="notext" href="admin.php">Back</a>
                <center>Delete Administrative User</center>
        </br>
        </div>
        <div data-role="main" class="ui-content ui-grid-a">
		<?php
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


			if ($_SESSION['admin_loggedin']){
				  $adminEmail = $_SESSION['admin_loggedin'];
                                  $query1 = "SELECT email, firstname, lastname FROM careerSchema.authorizationtable WHERE user_type = 'admin' and email != '$adminEmail'";
                                  $result = pg_query($query1) or die("Query failed: " . pg_last_error());
				  printResults($result); 
			}


		function printResults($result)  //function to display the results we get from each query in a table
		{
			echo "<table border='1'><br/>\n";  //creates table border and another break statement for newline

        		echo "<tr>\n"; //create new row to display the column names
        		$numrows = pg_num_fields($result);  //use function pg_num_fields to get the column fields for each query
			echo "<th>Actions</th>"; //displays column header
                	for($i = 0; $i < $numrows; $i++)  //use for loop to iterate through the columns of each query
                	{
                        	$fieldnames = pg_field_name($result, $i); //set fieldnames to pg_field_name to be able to display the column names
                        	echo "<th>$fieldnames</th>\n"; //will print each column name
                	}

        		echo "</tr>\n"; //end the row
    			
        		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) { //while loop to get all of the information in the array
		//		echo "<tr>\n"; //begin new row
				echo "<td><form method='POST' action='deleteAdmin.php'>";
				echo '<input type="submit" name="action" value="Delete" />'; //creates submit button Remove
				//echo '<input type="submit" data-inline="true" value="Delete" onclick="deleteAdmin();" name="Submit">'
                        //        if (isset($_POST['Submit'])){ deleteAdmin();
				echo "</form></td>\n";

			foreach ($line as $columnData) {
                        	echo "\t\t<td>$columnData</td>\n";  //will print each column value in its own cell
                	}

                		echo "\t</tr>\n";  //closes the row
        		}

        		echo "</table>\n";  //closes the table
		}
		
	/*	if ($_POST['action'] == 'Delete') //if the action is Remove then execute delete queries
        	{
			$query = "DELETE FROM careerschema.authorizationtable WHERE email = $1"; //query to delete country record
                        $stmt = pg_prepare($conn, "delete_0", $query) or die("Could not prepare query." . pg_last_error($conn)); //prepare query for execution - die adn print error message if prepare fials
                        $result = pg_execute($conn, "delete_0", array($_POST['email'])) or die("Could not execute query." . pg_last_error($conn)); //execute delete query - die if query could not be executed
                        echo "Delete was successful"; //if query could be prepared AND executed then print message and return to main page
                        echo '<br />Return to <a href="admin.php">Admin Dashboard</a>'; //a tag to return to main page
		}*/
	/*	function deleteAdmin($email)
		{
                        $query = "DELETE FROM careerschema.authorizationtable WHERE email = $1"; //query to delete country record
                        $stmt = pg_prepare($conn, "delete_0", $query) or die("Could not prepare query." . pg_last_error($conn)); //prepare query for execution - die adn print error message if prepare fials
                        $result = pg_execute($conn, "delete_0", array($_POST['email'])) or die("Could not execute query." . pg_last_error($conn)); //execute delete query - die if query could not be executed
                        echo "Delete was successful"; //if query could be prepared AND executed then print message and return to main page
                        echo '<br />Return to <a href="admin.php">Admin Dashboard</a>'; //a tag to return to main page	
		}*/
                ?>
                        </div>
                </div>

        </div>

	</div>
</div>

</body>
</html>
