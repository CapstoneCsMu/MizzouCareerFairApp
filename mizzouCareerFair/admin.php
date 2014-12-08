<?php
/*File:  admin.php
Parent:  login.php (redirects here upon admin logging in)
Function:  administrative dashboard to configure application*/
include("rssFunctions.php");
authorization();

include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
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
                document.getElementById("changeAdminPass").submit();
            }
    </script>

</head>

<body>
<div data-role="page" data-theme="a" id="home">
    <div data-role="header" >
        </br>
        <center>Admin Dashboard</center>
        </br>
        <a data-direction="reverse" data-icon="home" data-iconpos="notext"
           data-transition="flip" href="index.php" rel="external">Home</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div>

    <div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
		</ul>

                        <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Welcome, <?php echo $_SESSION['admin_loggedin']; ?></li>
                <li>
                    <a data-transition="flip" href="#option">Manage Fairs</a>
                </li>
                <li>
                    <a data-transition="flip" href="#uploadMap">Upload Map</a>
                </li>
                <li>
                    <a data-transition="flip" href="adminUsers.php" rel="external">Manage Users</a>
                </li>
                <li>
                    <a data-transition="flip" href="newsFeed.php">News Feed</a>
                </li>
                <li>
                    <a data-transition="flip" href="#changePass">Change Password</a>
                </li>
                </ul>

   </div>

</div>

<div data-role="page" data-theme="a" id="uploadMap">
    <div data-role="header" data-position="fixed">
        <h1>Upload a Map</h1>
        <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
           data-transition="flip" href="admin.php">Back</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div><br><br>



    <div>
        <form action="" method="post" enctype="multipart/form-data" data-ajax="false">
            <div class="chooseFile">
                <input type="file" name="file" id="file"><br>
            </div><br><br><br>
            <div class="submitBtn">
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>
    <?if(isset($_POST['submit'])){

        //check for file type
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        //get filename and set path
        $fileName =  $_FILES["file"]["name"];
        $path = "images/Maps/".$_FILES["file"]["name"];

        //check for errors and correct file type
        if($_FILES["file"]["error"] != 0)
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
        else if (!in_array($extension, $allowedExts))
            echo"<script>alert(\"Invalid File\")</script>";
        //If file already exists, update it to be in use without posting to database
        else if(file_exists("images/Maps/" . $_FILES["file"]["name"])) {
            $upQuery = 'UPDATE careerSchema.mapUploads SET inUse = CASE WHEN filePath = $1 THEN TRUE ELSE FALSE END';
            $statement = pg_prepare("uQuery", $upQuery) or die (pg_last_error());
            $upResult = pg_execute("uQuery", array($path)) or die(pg_last_error());
        }
        else {
            //set all images to not be in use
            $upQuery = 'UPDATE careerSchema.mapUploads SET inUse = FALSE';
            $upResult = pg_query($conn, $upQuery);

            //save file and insert path into database
            move_uploaded_file($_FILES["file"]["tmp_name"], $path);
            $query = 'INSERT INTO careerSchema.mapUploads(imgName, filePath, inUse) VALUES ($1, $2, $3)';
            $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
            $result = pg_execute("myQuery", array($fileName, $path, 'true')) or die(pg_last_error());
        }


    }?>
</div>

<div data-role="page" data-dialog="true" id="option">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>RSS Configuration</h1>
    </div>
    <div data-role="main" class="ui-content ui-grid-a">
        <div class="ui-block-a">
            <a data-role="button" rel="external" data-transition="slidedown" href="rssConfig.php#add" data-corners="true">Add An Event</a>
        </div>
        <div class="ui-block-b">
            <a data-role="button" rel="external" data-transition="slidedown" href="rssConfig.php#remove" data-corners="true">Remove An Event</a>
        </div>
    </div>
    <div data-role="footer">
        </br>
    </div>
</div>

<div data-role="page" data-dialog="true" id="changePass">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>Change Password</h1>
    </div>
    <div data-role="main" class="ui-content ui-grid-a">

        <form method="post" id="changeAdminPass" action="admin.php#changePass" data-ajax="false" >
            <label for="currPassword"><b>Current Password:</label>
            <input type="password" name="currPassword" id="currPassword">
            <label for="newPassword"><b>New Password:</label>
            <input type="password" name="newPassword" id="newPassword" placeholder="At least 5 characters">
            <label for="confPassword"><b>Confirm New Password:</label>
            <input type="password" name="confPassword" id="confPassword" placeholder="At least 5 characters">
	    <div class="submitBtn">
                  <input type="submit" name="submitPass" value="Submit">
            </div><br /><br />
        </form>
        <center>
           <!-- <input type="submit" data-inline="true" value="Update" onclick="submitAdmin();" name="Submit">-->
            <?php if (isset($_POST['submitPass'])) {
                $currPass = $_POST['currPassword'];
                $newPass = $_POST['newPassword'];
                $confPass = $_POST['confPassword'];
                changePass($currPass, $newPass, $confPass);
            }?>
        </center>


        </div>
        <div data-role="footer">
        </br>
        </div>
</div>


</body>
</html>
