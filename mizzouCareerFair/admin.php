<?php
/*File:  admin.php
Parent:  tigerspop.php (redirects here upon admin logging in)
Function:  administrative dashboard to configure application*/
session_start();
if(!$_SESSION['admin_loggedin']){
    $_SESSION['admin_attempt'] = "yes";
    header('Location: tigerspop.php');
}
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

</head>

<body>
<div data-role="page" data-theme="a" id="home">
    <div data-role="header" >
        </br>
        <center>Administrator</center>
        </br>
        <a data-direction="reverse" data-icon="home" data-iconpos="notext"
           data-transition="flip" href="index.php">Home</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div>
    <div data-role="navbar">
        <ul>
            <li><a href="adminCompanies.php">RSS Feed</a></li>
            <li><a href="#uploadMap">Upload Map</a></li>
            <li><a href="#anylink">Add/Edit Users</a></li>
            <li><a href="#anylink">News Feed</a></li>
        </ul>
    </div>

    <div data-role="content">
        <h2>Admin</h2>

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
        else if(file_exists("images/Maps/" . $_FILES["file"]["name"]))
            echo"<script>alert(\"File already exists\")</script>";
        else {
            //save file and insert path into database
            move_uploaded_file($_FILES["file"]["tmp_name"], $path);
            $query = 'INSERT INTO careerSchema.mapUploads(imgName, filePath) VALUES ($1, $2)';
            $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
            $result = pg_execute("myQuery", array($fileName, $path)) or die(pg_last_error());
        }


    }?>
</body>
</html>
