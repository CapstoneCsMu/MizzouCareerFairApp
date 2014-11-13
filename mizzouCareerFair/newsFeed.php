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
    <form action="" method="post" enctype="multipart/form-data" data-ajax="false">
        <div class="chooseFile">
            <label for="title"><b>Subject:</b></label>
            <input type="text" name="title" id="title">
            <label for="post"><b>Post:</b></label>
            <textarea rows="20" cols="10" name="post"></textarea><br /><br />
            <label for="image"><b>Upload Image:</b></label>
	    <input type="file" name="file" id="file"><br>
            <div class="submitBtn">
                  <input type="submit" name="submit" value="Post">
            </div>
	<br /><br />
        </form>
        <center>
    </div>
  </div>

	    <? if(isset($_POST['submit'])) {

		//Include Database information
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

	 $employerEmail = $_SESSION['employer_loggedin'];
//         $query1 = "SELECT email, company FROM careerSchema.authorizationtable WHERE email = $employerEmail";
  //       $result = pg_query($query1) or die("Query failed: " . pg_last_error());
    //             while ($userss = pg_fetch_array($result, null, PGSQL_ASSOC)) {
      //                       echo "<option value=\"" . $users["email"] . "\">" . $users["email"] . "</option>";
   
echo "$employerEmail";              //                              $users++;


	//$query = "SELECT company FROM careerschema.authorizationTable WHERE email = $_SESSION['employer_loggedin']";
	//echo $query;
        //check for file type
         $allowedExts = array("gif", "jpeg", "jpg", "png");
         $temp = explode(".", $_FILES["file"]["name"]);
         $extension = end($temp);

        //get filename and set path
         $fileName =  $_FILES["file"]["name"];
         $path = "images/Posts/".$_FILES["file"]["name"];

        //check for errors and correct file type
         if($_FILES["file"]["error"] != 0)
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
         else if (!in_array($extension, $allowedExts))
            echo"<script>alert(\"Invalid File\")</script>";
       
       // else{
            //save file and insert path into database
            move_uploaded_file($_FILES["file"]["tmp_name"], $path);
         //   $query = "INSERT INTO careerSchema.newsFeed(email, textPost, company, title) VALUES ($1, $2, $3, $4)";
           // $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
           // $result = pg_execute("myQuery", array($email, $_POST['post'], $_SESSION['company'], $_POST['title'])) or die(pg_last_error());
        
       	    $query = "INSERT INTO careerSchema.newsFeed(email, imageName, textPost, imgFilePath, company, title) VALUES ($1, $2, $3, $4, $5, $6)";
            $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
            $result = pg_execute("myQuery", array($_SESSION['email'], $fileName, $_POST['post'], $path, $_SESSION['company'], $_POST['title'])) or die(pg_last_error());
//	}


    }?>
	
<!--
    <div data-role="page" data-theme="a" id="viewPosts" data-ajax="false">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="employerView.php">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>View All News Feed Posts</h1>
    </div><br><br>
   
    <div data-role="footer">
        </br>
    </div>
    </div>
-->

   <div data-role="page" data-theme="a" id="posts">
        <?php
        include ("data.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

	$company = "SELECT company FROM careerSchema.newsFeed";
        $query = "SELECT title FROM careerSchema.newsFeed";
        $result =  pg_query($query) or die('Query failed: ' . pg_last_error());
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$query2 = "SELECT textPost FROM careerSchema.newsFeed";
        $result2 =  pg_query($query2) or die('Query failed: ' . pg_last_error());
        $line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
//	$postText = $line["textPost"];
//        $filePath = $line["imgFilePath"];
	echo "<br /><br />";
	printResults($result, $result2, $company);
//	$query2 = "SELECT textPost FROM careerSchema.newsFeed";
//	$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
//	$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
        ?>

        <div data-role="header" data-position="fixed">
            <h1>Mizzou Career Fairs News Feed</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="index.php">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

	<div data-role="footer" data-position="fixed">
            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    

<?php
function printResults($result, $result2, $company)
{
        //echo "<table border='1'><br/>\n";

        //echo "<tr>\n";
        $numrows = pg_num_fields($result);
	$numrows = pg_num_fields($result2);

          while ($line = pg_fetch_array($result, null, PGSQL_ASSOC))
        {
		 foreach ($line as $columnData)
                        {

	                while ($line2 = pg_fetch_array($result2, null, PGSQL_ASSOC))
        	        {
                	        foreach ($line2 as $colData)
                        	{
                                        echo "<div class=newsFeed>";
                                       // echo "<ul data-dividertheme='b' data-inset='true' data-role='listview'>";
					echo "<ul data-inset='true' data-role='listview'>";
                                        //echo "<p data-role='list-divider' style='background-color:#C2C6C6;border-radius:4px;padding:7px;'>$columnData --  Posted by: </p><p style='background-color:#ffcc33;border-radius:4px;padding:7px;height:auto;font-weight:normal;' data-role='list-divider'>$colData</p><br /><br />";
                                        echo "<li data-role='list-divider'>$columnData --  Posted by: </li><li style='background-color:#ffcc33;height:auto;font-weight:normal;'>$colData</li><br /><br />";
					echo "</div></ul>";
                                }
                        }
                }
        }
}
?>

</body>
</html>

