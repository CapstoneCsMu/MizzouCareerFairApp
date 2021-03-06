<?php
/*File:  admin.php
Parent:  login.php (redirects here upon admin logging in)
Function:  administrative dashboard to configure application*/
include("rssFunctions.php");
//empAuthorization();

include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

//if(isset($_SESSION['employer_loggedin']))
//{
    session_start();
 //       header("Location: employerView.php");
//}

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

  <div data-role="page" data-theme="a" id="createPost" data-ajax="false">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="employerView.php">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>Create News Feed Posts</h1>
    </div><br><br>
    <form action="feedPost.php" method="post" enctype="multipart/form-data" data-ajax="false">
        <div class="chooseFile">
            <label for="title"><b>Subject:</b></label>
            <input type="text" name="title" id="title">
            <label for="post"><b>Post:</b></label>
            <textarea rows="20" cols="10" name="post"></textarea><br /><br />
            <label for="image"><b>Upload Image:</b></label>
	    <input type="file" name="file" id="file"><br>
            <div class="submitBtn">
                  <input type="submit" name="submitFeedPost" value="Post">
            </div>
	<br /><br />
        </form>
        <center>
    </div>
  </div>


</body>
</html>

