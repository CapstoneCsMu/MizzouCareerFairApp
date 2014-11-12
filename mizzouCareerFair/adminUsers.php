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
	    function deleteAdmins()
	    {
		document.getElementById("deleteAdmin").submit();
	    }
   </script>

</head>

<body>

<div data-role="page" data-dialog="true">
        <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php">Back</a>
                <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
                <h1>Admin User Options</h1>
        </div>
        <div data-role="main" class="ui-content ui-grid-a">
                <div class="ui-block-a">
                        <a data-role="button" data-transition="flip" href="#addAdmin" data-corners="true">Add Admin</a>
                </div>
                <div class="ui-block-b">
                        <a data-role="button" data-transition="flip" href="#deleteAdmin" data-corners="true">Delete Admin</a>
                </div>
        </div>
        <div data-role="footer">
                </br>
        </div>
</div>

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
                                    ?>
                                    <form method="post" action="" data-ajax="false" id="deleteAdmin">
                                        <label for="eventName"><h4>Select Admin You Would Like To Remove:</h4></label>
                                            <select name="adminRemove" id="adminRemove">
                                                <?php
                                                while ($admins = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                                                    echo "<option value=\"" . $admins["email"] . "\">" . $admins["email"] . "</option>";
                                                    $admins++;
                                                }
                                                ?>
                                                <br>
                                            </select>
                                            <div class="submitBtn">
                                                <input type="submit" value="Submit" name="deleteSubmit">
                                            </div>
                                        </form>
                            <?if (isset($_POST['deleteSubmit'])){ deleteAdmin($_POST["adminRemove"]);}
                            }?>


        </div>
</div>

<div data-role="page" data-theme="a" id="deleteSuccess">
        <div data-role="header" data-position="fixed">
            <h1>Success</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
                        <h3><center>Administrator Has Been Deleted!<center></h3>
                        <a href="admin.php" data-role="button">Return to Your Admin Dashboard</a>
        </div>
</div>

<div data-role="page" data-theme="a" id="deleteFailure">
        <div data-role="header" data-position="fixed">
            <h1>Failure</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
                        <h3><center>Administrator Has Not Been Deleted.<center></h3>
                        <a href="admin.php" data-role="button">Return to Your Admin Dashboard</a>
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
                                            <input type="submit" name="addSubmit" value="Submit">
                                        </div>
                </form>

                                <?php if (isset($_POST['addSubmit'])){ handleNewAdmin();} ?>
<!--
<div data-role="page" data-theme="a" id="deleteSuccess">
        <div data-role="header" data-position="fixed">
            <h1>Success</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
                        <h3><center>Administrator Has Been Deleted!<center></h3>
                        <a href="admin.php" data-role="button">Return to Your Admin Dashboard</a>
        </div>
</div>

<div data-role="page" data-theme="a" id="deleteFailure">
        <div data-role="header" data-position="fixed">
            <h1>Failure</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
                        <h3><center>Administrator Has Not Been Deleted.<center></h3>
                        <a href="admin.php" data-role="button">Return to Your Admin Dashboard</a>
        </div>
</div>
-->


<?php
function printResults($result)
{
        echo "<div data-role=\"table\" id=\"userstable\" >";

        echo "<tr>\n";
        $numrows = pg_num_fields($result);
        echo "<th>Actions</th>";
        for($i = 0; $i < $numrows; $i++)
        {
                $fieldnames = pg_field_name($result, $i);
                echo "<th>$fieldnames</th>\n";
        }

        echo "</tr>\n";

        while ($line = pg_fetch_array($result, null, PGSQL_ASSOC))
        {
                echo "<tr>\n";
                echo '<input type="submit" name="submit" value="Delete" />';
                if (isset($_POST['submit'])){ deleteAdmin();}
                foreach ($line as $columnData)
                {
                        echo "\t\t<td>$columnData</td>\n";
                }

                echo "\t</tr>\n";
        }

    echo "</div>";
}
?>

</body>
</html>
