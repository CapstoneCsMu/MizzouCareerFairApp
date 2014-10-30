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
	<div data-role="page" data-theme="a" id="scannedStudents">
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

			echo '<div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Students you have scanned</li>';
			
			$i=0;
			while ($line = pg_fetch_assoc($result)) {
					//prints data by the line
					// if favorited 
					// echo'<li><a href="employerView.php#student'.$i.'" class="ui-btn ui-icon-star ui-btn-icon-left">'.$line['firstname'].' '.$line['lastname'].'</a></li>';	
					// else if not favorited
					echo '<li><a href="employerView.php#student'.$i.'">'.$line['firstname'].' '.$line['lastname'].'</a></li>';	
					$emailList[$i] = $line['email'];
					$namesList[$i] = $line['firstname']." ".$line['lastname'];
					$i++;
			}
			echo '</ul>';
			echo '</div></div>';
			
				
			
			for ($j=0; $j<$i; $j++){
			
					echo '<div data-role="page" data-theme="a" id="student'.$j.'">
					<div data-role="header" data-position="fixed">
					<h1>'.$namesList[$j].'</h1>
					<a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
					data-transition="flip" href="employerview.php#scannedStudents">Home</a> <a data-icon="search"
					data-iconpos="notext" data-rel="dialog" data-transition="fade"
					href="../nav.html">Search</a>
					</div>

					<div data-role="content">';
					
				
				$query2 = "SELECT * FROM careerSchema.students WHERE email = '$emailList[$j]'";
				$result = pg_query($query2) or die("Query failed: " . pg_last_error());
				
				$line = pg_fetch_array($result, null, PGSQL_ASSOC);
				
				//Grab each individual field
				$k=0;
				foreach ($line as $col_value) {
					switch($k){
					
						case 0:
							echo '<b>Email Address: <b>';
							echo $col_value."</br>";
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
	/*?>	
				
	<!--End scanned students HTML-->

	<!--Start map HTML-->
    <div data-role="page" data-theme="a" id="map">
        <?
        include ("data.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

        $query = "SELECT * FROM careerSchema.mapUploads ORDER BY entryTime LIMIT 1";
        $result =  pg_query($query) or die('Query failed: ' . pg_last_error());
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
        $filePath = $line["filepath"];
        ?>

        <div data-role="header" data-position="fixed">
            <h1>Mizzou Career Fair App Hearnes Map</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>


        <div data-role="content"><img alt="Fair Map" src="<?php echo $filePath;?>"
        style="width:100%">
        </div>


        <div data-position="fixed" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	<!--End map HTML-->

	<!--Start about ECS HTML-->
	<div data-role="page" data-theme="a" id="aboutECS">
        <div data-role="header" data-position="fixed">
            <h1>About Us</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#employerView.php">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
			<div data-role="content">
				<p>
				Engineering Career Services provides information, guidance and resources to empower Mizzou 
				Engineering students to develop and achieve their career goals.
				</p>
				
				<h2>Typical Career Events</h2>
				<ul>
					<li><span style="font-size:11.0pt">Career fairs (2 a year)<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">Professional development workshops with employers<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">Company visits to Mizzou for on-campus interviews and networking opportunites<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">Special targeted events with employers<o:p></o:p></span></li>
				</ul>
				
				<h2>Employer Access to Students</h2>
				<p>
				In addition to professional development activities offered to students, 
				Engineering Career Services also develops corporate partnerships that increase access to students.
				</p>
				<p>
				If you have questions about Engineering Career Services, feel free to contact us.
				</p>
				
				<h3>Mission</h3>
				<p>In all our work these beliefs and values will guide us:</p>
				<ul>
					<li><span style="font-size:11.0pt">Career development is a lifelong learning process consisting of the following components:<o:p></o:p></span></li>
						<ul>
							<li><span style="font-size:9.0pt">self-assessment<o:p></o:p></span></li>
							<li><span style="font-size:9.0pt">occupational exploration<o:p></o:p></span></li>
							<li><span style="font-size:9.0pt">career decision making<o:p></o:p></span></li>
							<li><span style="font-size:9.0pt">career planning<o:p></o:p></span></li>
							<li><span style="font-size:9.0pt">acting on options<o:p></o:p></span></li>
						</ul>
					<li><span style="font-size:11.0pt">Each student has diverse experiences, interests and goals, and deserves to be respected as an individual.<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">Each student deserves to be assisted with her/his individual needs in a caring manner that also allows the student to develop individual responsibility.<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">Services and programs need to be evaluated and redirected as academic environment and employment trends dictate.<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">The needs of external and internal constituents drive what we do. These constituents include students, alumni, employers, faculty and staff, as well as parents, prospective students and other external populations.<o:p></o:p></span></li>
					<li><span style="font-size:11.0pt">A supportive environment is provided in which people from a wide variety of backgrounds and traditions may encounter each other in a spirit of cooperation, openness and mutual respect.<o:p></o:p></span></li>
				</ul>	
		</div>
	</div>
	<!--End about ECS HTML-->
	
	<!--Start announcements HTML-->
    <div data-role="page" data-theme="a" id="announcements">
        <div data-role="header" data-position="fixed">
            <h1>Announcements</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Career Fair Announcements</li>
                <li>
                    <a href="option">New Companies</a>
                </li>
                <li>
                    <a href="option2.html">Changed Booth Locations</a>
                </li>
                <li>
                    <a href="option8.html">Updates</a>
                </li>
            </ul>
        </div>
        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
    <!--End announcements HTML-->

</body>
</html>