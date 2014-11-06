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

<body>

    <div data-role="page" data-theme="a" id="home">
        <div data-role="header" data-position="fixed">
            <h1 class="no-ellipses">Company Page</h1>
        </div>

		

        <div data-role="content">
            
            
            
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Career Fair</li>
				
				<li>
                    <a data-transition="flip" href="#scannedStudents">Students You Have Scanned!</a>
                </li>	
                
                <li>
                    <a data-transition="flip" href="#map_page">Directions to Fair</a>
                </li>
				
                <li>
                    <a data-transition="flip" href="#map">Map of Career Fair</a>
                </li>

				<li>
					<a data-transition="flip" href="logout.php">Logout</a>
				</li>
			</ul>
            
            <a><?php echo "<script type=\"in/Login\">Hello, <?js= firstName ?> <?js= lastName ?>.</script>" ?></a>

	    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
        
		<div data-role="footer" data-position="fixed" style="background: linear-gradient(#E6E6E6,#E6E6E6 )">
			<div data-role="navbar" data-iconpos="top">
				<ul>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="info" href="aboutUs">About Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="edit" href="mailto:kristi.decker347@gmail.com?Subject=TEST">Contact Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="comment" href="">Anouncements</a></li>
				</ul>
				<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
			</div>
		</div>	
        </div>

    </div>
    <!-- Page for the user to get a google map to the fair, it should attempt to start from geo location -->
    <div data-role="page" id="map_page">
            <div data-role="header" data-position="fixed">
            <h1>Directions</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="#home">Home</a> <a data-icon="search" data-iconpos="notext"
            data-rel="dialog" data-transition="fade" href=
            "../nav.html">Search</a>
        </div>
            <div data-role="content">
                <div class="ui-bar-c ui-corner-all ui-shadow" style="padding:1em;">
                    <div id="map_canvas" style="height:300px;"></div>
                    <div id="fromDirection" data-role="fieldcontain">
                        <label for="from">From</label> 
                        <input type="text" id="from"/>
                    </div>
                    <div id="toDirection" data-role="fieldcontain">
                        <label for="to">To</label> 
                        <input type="text" id="to" value="Hearnes Center 600 E Stadium Blvd, Columbia, MO 65203"/>
                    </div>
                    <div id="dirSpecs" data-role="fieldcontain">
                        <label for="mode" class="select">Transportation method:</label>
                        <select name="select-choice-0" id="mode">
                            <option value="DRIVING">Driving</option>
                            <option value="WALKING">Walking</option>
                            <option value="BICYCLING">Bicycling</option>
                        </select>
                    </div>
                    <a data-icon="navigation" data-role="button" href="#" id="submitDirections">Get Directions</a>
                    
                    <div data-role="fieldcontain">
						<label for="flip-2">Display Map : </label>
						<select id="toggleMap" data-role="slider">
							<option value="off">Off</option>
							<option value="on">On</option>
						</select> 
						
						<a id="resetSearch" style="float:right;" data-icon="navigation" href="#" data-role="button" data-inline="true" data-theme="b">Reset Search</a>
						
					</div>
                    
                    
                </div>
                
                <div id="results" style="display:none;">
                    <div id="directions"></div>
                </div>
            </div>
    </div>
	<!-- End Page for the user to get a google map to the fair, it should attempt to start from geo location -->
	
	<!--Start scanned students HTML-->
	<div data-role="page" data-theme="a" id="scannedStudents" data-cache="false">
        <div data-role="header" data-position="fixed">
            <h1>Potential Employees</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
		
		<?php
		
		include ("data.php");
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
			if (!$conn)
			{
				echo "<br/>An error occurred with connecting to the server.<br/>";
				die();
			}
		
		?> 
					
				
	<?php
		
		$empEmail = $_SESSION['employer_loggedin'];
		echo $empEmail;
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
			
			//echo $line['email'];
			//echo $emailStudents[$j];
			
			//$email = $line['email'];
			
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
				//echo $student;
				//echo "seee";
				
				echo '<form name="favorite_student" method="post">';
				echo"<input type=\"hidden\" name=\"fav\" value=\"".$student."\"/>";
				echo '<input type="submit" data-icon="star" name="fav_me" value="Favorite This Student!" />
				</form>';
			
				//Grab each individual field
				$k=0;
				foreach ($line as $col_value) {
					switch($k){
					
						case 0:
							echo '<b>Email Address: <b>';
							echo $col_value."</br>";
							$email = $col_value;
							break;
						case 1:
							echo 'First Name: ';
							echo $col_value."</br>";
							break;
						case 2:
							echo 'Last Name: ';
							echo $col_value."</br>";
							break;
						case 3:
							echo 'Graduation Date: ';
							echo $col_value."</br>";
							break;
						case 4:
							echo 'Major: ';
							echo $col_value."</br>";
							break;
						case 5:
							echo 'Resume: ';
							echo $col_value."</br>";
							break;
						case 6:
							echo 'Phone Number: ';
							echo $col_value."</br>";
							break;
						case 7:
							echo 'Life Plan: ';
							echo $col_value."</br>";
							break;
						case 8:
							echo 'LinkedIn ID: ';
							echo $col_value."</br>";
							break;	
					}
					$k++;
				}			
				echo '</div>';
				echo '</div>';			
			}	
		}
		?>	
		<?php
		if(isset($_POST['fav_me'])){
				
			//	$query3 = "UPDATE careerSchema.employerScannedStudents SET favorite=1 WHERE email = '$student'";
				//$result = pg_query($query3) or die("Query failed: " . pg_last_error());
				$result=pg_prepare($conn,"query3",'UPDATE careerSchema.employerScannedStudents SET favorite = $1 WHERE email = $2' );
                $result=pg_execute($conn,"query3",array('1',$_POST['fav']));
				$result=pg_execute($conn,"query3",array('1',$_POST['fav']));
				header('Location: '.$_SERVER['PHP_SELF']);  
			//	header('Location: '.$_SERVER['REQUEST_URI']);
					
			}	
	?>
	
</body>
</html>