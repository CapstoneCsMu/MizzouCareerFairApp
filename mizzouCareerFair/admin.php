<?php
/*File:  admin.php
Parent:  login.php (redirects here upon admin logging in)
Function:  administrative dashboard to configure application*/
session_start();
if(!$_SESSION['admin_loggedin']){
    $_SESSION['admin_attempt'] = "yes";
    header('Location: login.php');
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
        <center>Mizzou Career Fairs Site Administrator</center>
        </br>
        <a data-direction="reverse" data-icon="home" data-iconpos="notext"
           data-transition="flip" href="index.php">Home</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div>
    <div data-role="content">
		<h2>Welcome</h2> <?php echo $_SESSION['admin_loggedin']; ?>
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider"></li>
                  <li>
                    <a data-transition="slideup" href="#changePass">Change Password</a>
                </li>
		 <li>
                    <a data-transition="slideup" href="adminCompanies.php">RSS Feed</a>
                </li>
                <li>
                    <a data-transition="slide" data-direction="reverse" href="#uploadMap">Upload Map</a>
                </li>
                <li>
                    <a data-transition="flip" href="adminUsers.php">Manage Users</a>
                </li>
		<li>
		    <a data-transition="flip" href=#newsFeed">News Feed</a>
			</ul>
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
				<li data-role="list-divider"></li>
	   </ul>
	</div>
</div>

    <div data-role="page" id="changePass" data-dialog="true">
        <div data-role="header">
        </br>
                <a data-icon="delete" data-transition="pop" data-iconpos="notext" href="admin.php">Back</a>
                <center>Change Password</center>
        </br>
        </div>
        <div data-role="main" class="ui-content ui-grid-a">

                <form method="post" id="changeAdminPass" action="admin.php#changePass" data-ajax="false" >
                                        <label for="currPassword"><b>Current Password:</label>
                                        <input type="password" name="currPassword" id="currPassword">
                                        <label for="newPassword"><b>New Password:</label>
                                        <input type="password" name="newPassword" id="newPassword" placeholder="At least 5 characters">
                                        <label for="confPassword"><b>Confirm New Password:</label>
                                        <input type="password" name="confPassword" id="confPassword" placeholder="At least 5 characters">
                </form>
                        <center>

                                <input type="submit" data-inline="true" value="Update" onclick="submitAdmin();" name="Submit">
                                <?php if (isset($_POST['Submit'])){ changePass();} ?>
                        </center>


        </div>
        <div data-role="footer">
                </br>
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

<div data-role="page" data-theme="a" id="adminCompanies">
    <div data-role="header" data-position="fixed">
        <h1>RSS Feed Configuration</h1>
        <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
           data-transition="flip" href="admin.php">Back</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div><br><br>
<form method="post" action="" id="link" data-ajax="false">
    <label for="year"><h4>Year For This Career Fair:</h4></label>
    <select name="year" id="year">
        <?php
        for($i = 2014; $i < 2050; $i++)
            echo "<option value=\"".$i."\">".$i."</option>";
        ?>
    </select>

    <label for="semester"><h4>Semester Of This Career Fair:</h4></label>
    <select name="semester" id="semester">
        <option value="Fall">"Fall"</option>
        <option value="Spring">"Spring"</option>
    </select>

    <label for="college"><h4>College For This Career Fair:</h4></label>
    <select name="college" id="college">
        <option value="Engineering">Engineering</option>
        <option value="Business">Business</option>
        <option value="Journalism">Journalism</option>
        <option value="CAFNR">CAFNR</option>
    </select>

    <input type="text" name="link" placeholder="RSS Link"></input>
	<div class="submitBtn">
       <input type="submit" name="submitLink" value="Submit">
    </div>
</form>
</center>

<?php
	include ("data.php");
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

	if(isset($_POST['submitLink'])){
		//Get rss link and all data fields in rss link and put them into database
		$rssLink = $_POST['link'];
        $eventName = $_POST['year']." ".$_POST['semester']." ".$_POST['college']." Career Fair";
		if($xml = simplexml_load_file($rssLink)){
			$content = $xml->channel->item->children("http://purl.org/rss/1.0/modules/content/");
			$data = $content->encoded;

			echo "<br>";
			echo "<fieldset>";
			echo "<h3><ul>Example of item in feed:</ul></h3>";
			echo $data;
			echo "</fieldset>";
			echo "<br>";

			$dom = new DOMDocument();
			$table = $dom->loadHTML($data);
			$dom->preserveWhiteSpace = false;
			$tables = $dom->getElementsByTagName('table');
			$rows = $tables->item(0)->getElementsByTagName('tr');

			foreach($rows as $row){
				$cols = $row->getElementsByTagName('td');
				$fields[] = $cols->item(0)->nodeValue;
				}
            ?>



				<!-- Select the field that contains company name -->
                <form method="post" action="input.php" id="fields" data-ajax="false">";
                <input type="hidden" name="rssLink" id="rssLink" value="<?php echo $rssLink;?>">
                    <input type="hidden" name="event" id="event" value="<?php echo $eventName;?>">

				<fieldset class="ui-field-contain">
    				<label for="nameField">Field For Company Name:</label><br>
    				<select name="nameField" id="nameField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

  				<!-- Select the field that contains the company address -->
  				<fieldset class="ui-field-contain">
    				<label for="cityField">Field For Company City:</label><br>
    				<select name="cityField" id="cityField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

                <fieldset class="ui-field-contain">
                    <label for="stateField">Field For Company State:</label><br>
                    <select name="stateField" id="stateField">
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                </fieldset>

  				<!-- Select the field that contains the desired majors -->
  				<fieldset class="ui-field-contain">
    				<label for="majorsField">Field For Desired Majors:</label><br>
    				<select name="majorsField" id="majorsField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

  				<!-- Select the field that contains the position types -->
  				<fieldset class="ui-field-contain">
    				<label for="positionTypeField">Field For Position Types:</label><br>
    				<select name="positionTypeField" id="positionTypeField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

				<fieldset class="ui-field-contain">
    				<label for="websiteField">Field For Company Website:</label><br>
    				<select name="websiteField" id="websiteField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

				<fieldset class="ui-field-contain">
    				<label for="citizenshipField">Field For Citizenship:</label><br>
    				<select name="citizenshipField" id="citizenshipField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
				</fieldset>

				<fieldset class="ui-field-contain">
    				<label for="citizenshipField">Field For Company Status:</label><br>
    				<select name="statusField" id="statusField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>

  				<input type="submit" value="Submit" name="fieldSubmit"></input>
  			</form>

			<?php

			}
		else
			echo "invalid link";
		}

//get most recent rss info
?>
</div>
</body>
</html>
