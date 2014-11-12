<?php
	/*File:  employerView.php 
	Parent:  login.php 
	Function:  Employer view form, default view when employer logs in.*/
?>

<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$_SESSION['prevPage'] = 'employerView.php';
	
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
	
    <!-- <link href="http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css" rel="stylesheet"> -->
	<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
    
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	
    <!-- Include jQuery and jQuery Mobile CDN, add actual files
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script> -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <!-- Include JS file for our JS -->
    <script src="js/index.js"></script>
    
    <!-- Include LinkedIn Framework, API Key Unique to Us -->
	<!-- <script type="text/javascript" src="http://platform.linkedin.com/in.js"> -->
    <script type="text/javascript" src="js/linkedin.js">
  		api_key: 75a6k7ahbjlrny
  		onLoad: onLinkedInLoad
  		authorize: true
	</script>
	<!-- Include Google Maps API -->
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>
	<script type="text/javascript" src="index.js"></script>

</head>

<?php
		
	include ("data.php");
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
	if (!$conn)
	{
		echo "<br/>An error occurred with connecting to the server.<br/>";
		die();
	}
	
	$empEmail = $_SESSION['employer_loggedin'];

	//use pg_num_rows to get amount of rows. Print that many pages with info.	
	$query = "SELECT DISTINCT ON(email) company FROM careerSchema.employerScannedStudents WHERE employerEmail = '$empEmail'";
	$result = pg_query($query) or die("Query failed: " . pg_last_error());
	$line = pg_fetch_assoc($result)

?> 
				

<body>

    <div data-role="page" data-theme="a" id="home">
    <div data-role="header">
        </br>
        <center><?php echo $line['company']; ?></center>
        </br>
        <a data-direction="reverse" data-icon="home" data-iconpos="notext"
           data-transition="flip" href="index.php">Home</a> <a data-icon="search"
                                                               data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                               href="../nav.html">Search</a>
    </div>

        <div data-role="content">
            
            
            
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Career Fair</li>
				
				<li>
                    <a data-transition="flip" href="#scannedStudents">Students You Have Scanned!</a>
                </li>	
                
				<li>
					<a data-transition="flip" href="#newsFeed">News Feed</a>
				</li>
			</ul>
         
            <a><?php echo "<script type=\"in/Login\">Hello, <?js= firstName ?> <?js= lastName ?>.</script>" ?></a>

	    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
        
		<div data-role="footer" data-position="fixed" style="background: linear-gradient(#E6E6E6,#E6E6E6 )">
			<div data-role="navbar" data-iconpos="top">
				<ul>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="info" href="aboutUs">About Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="edit" href="mailto:mizzoucareerfairs@gmail.com"Subject="Mizzou Career Fairs Support">Contact Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="comment" href="">Anouncements</a></li>
				</ul>
				<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
			</div>
		</div>	
        </div>

    </div>
   
	<!--Start scanned students HTML-->
	<div data-role="page" data-theme="a" id="scannedStudents" data-cache="false">
        <div data-role="header" data-position="fixed">
            <h1>Potential Employees</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" data-transition="flip" href="#home">Home</a> 
        </div>	
				
	<?php
		
		$empEmail = $_SESSION['employer_loggedin'];
		echo '</br></br>';

		include ("data.php");
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
			if (!$conn)
			{
				echo "<br/>An error occurred with connecting to the server.<br/>";
				die();
			}
			
		if ($_SESSION['employer_loggedin'])
		{	 
			//use pg_num_rows to get amount of rows. Print that many pages with info.	
			$query1 = "SELECT DISTINCT ON(email) * FROM careerSchema.employerScannedStudents WHERE employerEmail = '$empEmail'";
			$result = pg_query($query1) or die("Query failed: " . pg_last_error());
			$num_rows = pg_num_rows($result);
			
			//echo '<div data-role="content" data-cache="false">
			echo '<div role="main" class="ui-content jqm-content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview" data-cache="false">
                <li data-role="list-divider">Students you have scanned</li>';
			
			
			$i=0;
			//loop through every student employer has scanned in CF
			while ($line = pg_fetch_assoc($result)) {
					$favorites[$i] = $line['favorite'];
					//prints data by the line
					if ($line['favorite'] == '1'){ 
						echo'<li><a href="employerView.php#student'.$i.'" class="ui-btn ui-icon-star ui-btn-icon-left">'.$line['firstname'].' '.$line['lastname'].'</a></li>';	
					}
					else{
						echo '<li><a href="employerView.php#student'.$i.'">'.$line['firstname'].' '.$line['lastname'].'</a></li>';	
					}
					//makes array of students emails
					$emailStudents[$i] = $line['email'];
					//makes array of students fist and last name
					$namesStudents[$i] = $line['firstname']." ".$line['lastname'];
					$i++;
			}
			
			echo '</ul>';
			echo '</div></div>';	
			
			for ($j=0; $j<$num_rows; $j++){
			
					echo '<div data-role="page" data-theme="a" id="student'.$j.'" data-cache="false">
					<div data-role="header" data-position="fixed">
					<h1>'.$namesStudents[$j].'</h1>
					<a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
					data-transition="flip" href="employerview.php#scannedStudents">Home</a> <a data-icon="search"
					data-iconpos="notext" data-rel="dialog" data-transition="fade"
					href="../nav.html">Search</a>
					</div>

					<div data-role="content">';
				
				$query2 = "SELECT * FROM careerSchema.students WHERE email = '$emailStudents[$j]'";
				$result = pg_query($query2) or die("Query failed: " . pg_last_error());
				
				$line = pg_fetch_array($result, null, PGSQL_ASSOC);
				$student = $line['email'];
				if ($favorites[$j] == '0')
				{
				echo '<form id="fav_'.$j.'" method="post" data-ajax="false">';
				echo '<input type="hidden" name="fav" value="'.$student.'" />';
				echo '</form>';
				echo '<center><a href="employerView.php#scannedStudents" data-role="button" data-theme="b" onclick="document.getElementById(\'fav_'.$j.'\').submit(); window.alert(\'Student has been added to Favorites.\');" data-inline="true" class="ui-btn ui-icon-user ui-btn-icon-left">Favorite This Student!</a></center>';
				}
				else
				{
				echo '<form id="unfav_'.$j.'" method="post" data-ajax="false">';
				echo '<input type="hidden" name="unfav" value="'.$student.'" />';
				echo '</form>';
				echo '<center><a href="employerView.php#scannedStudents" data-role="button" data-theme="b" onclick="document.getElementById(\'unfav_'.$j.'\').submit(); window.alert(\'Student has been removed from Favorites.\');" data-inline="true" class="ui-btn ui-icon-user ui-btn-icon-left">Remove from Favorites!</a></center>';
				}
				
				echo '<form id="delete_'.$j.'" method="post" data-ajax="false">';
				echo '<input type="hidden" name="delete" value="'.$student.'" />';
				echo '</form>';
				echo '<center><a href="employerView.php#scannedStudents" data-role="button" data-theme="b" onclick="document.getElementById(\'delete_'.$j.'\').submit(); window.alert(\'Student has been removed from your list.\');" data-inline="true" class="ui-btn ui-icon-user ui-btn-icon-left">Delete from your list!</a></center>';
				
				
				// Display Profile
				echo '<div class="ui-bar ui-bar-a ui-corner-all" style="padding: 5px;">';
				echo "</br><table>";
				echo '<center><img src="'.$line['picture_url'].'" style=".ui-grid-b img{width:100%; height: auto;}" /></center>';
				foreach($line as $key => $value)
				{
					if ($value != NULL)
					{

						switch($key)
						{
							case 'email':
								echo '<tr><td valign="top" align="left">Email: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'firstname':
								echo '<tr><td valign="top" align="left">First Name: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'lastname':
								echo '<tr><td valign="top" align="left">Last Name: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'phonenumber':
								echo '<tr><td valign="top" align="left">Phone Number: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'location':
								echo '<tr><td valign="top" align="left">Location: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'linkedin_url':
								echo '<tr><td valign="top" align="left">LinkedIn Profile: </td><td valign="top" align="left"><a target="_blank" href="'.$value.'">Click</a></td></tr>';
								break;
							case 'job':
								echo '<tr><td valign="top" align="left">Job: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'graddate':
								echo '<tr><td valign="top" align="left">Graduation Date: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'major':
								echo '<tr><td valign="top" align="left">Major: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							case 'lifeplan':
								echo '<tr><td valign="top" align="left">Career Goals: </td><td valign="top" align="left">'.$value.'</td></tr>';
								break;
							default;
								break;
						}
						
					}
				}
				echo "</table></div>";		
				echo '</div>';
				echo '</div>';			
			}	
		}
		?>	
		
	<?php
		if(isset($_POST['fav'])){

				pg_prepare($conn,"query3",'UPDATE careerSchema.employerScannedStudents SET favorite = $1 WHERE email = $2' );
                pg_execute($conn,"query3",array('1',$_POST['fav']));
				echo '<script type="text/javascript">location.reload();</script>';
			}	
		elseif(isset($_POST['unfav'])){

				pg_prepare($conn,"query4",'UPDATE careerSchema.employerScannedStudents SET favorite = $1 WHERE email = $2' );
                pg_execute($conn,"query4",array('0',$_POST['unfav']));
				echo '<script type="text/javascript">location.reload();</script>';
			}
		elseif(isset($_POST['delete'])){

				pg_prepare($conn,"query5",'DELETE FROM careerSchema.employerScannedStudents WHERE email = $1 AND employeremail = $2' );
                pg_execute($conn,"query5",array($_POST['delete'], $empEmail));
				echo '<script type="text/javascript">location.reload();</script>';
			}	
	?>

<div data-role="page" data-dialog="true" id="newsFeed">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="employerView.php">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>News Feed</h1>
    </div>
    <div data-role="main" class="ui-content ui-grid-a">
        <div class="ui-block-a">
            <a data-role="button" rel="external" data-transition="slidedown" href="newsFeed.php#createPost" data-corners="true">Create Post</a>
        </div>
        <div class="ui-block-b">
            <a data-role="button" rel="external" data-transition="slidedown" href="newsFeed.php#viewPosts" data-corners="true">View All Posts</a>
        </div>
    </div>
    <div data-role="footer">
        </br>
    </div>
</div>

</body>
</html>
