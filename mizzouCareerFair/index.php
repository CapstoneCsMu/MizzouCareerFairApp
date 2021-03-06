<?php
	/*
	File: index.php
	Parent: None
	Function: Home Page. Pretty much everything is called from here.
	*/
	include('check_https.php');
	$_POST['student_loggedin'] = $_SESSION['student_loggedin'];
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Mizzou Career Fairs
    </title> 
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    
    <!--CSS-->
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
	<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	<link rel="stylesheet" href="css/eventStyle.css">
	
    <!--jQuery and jQM JavaScript -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <!-- Include JS file for our JS -->
    <script src="js/index.js"></script>
    
    <!-- AddThisEvent -->
<script type="text/javascript" src="https://addthisevent.com/libs/1.5.8/ate.min.js"></script>
    
    <!-- Include LinkedIn Framework, API Key Unique to Us -->
	<?php if($_SERVER['HTTP_HOST'] == 'localhost'): ?>
		<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  		api_key: 750nr1ytn6d9bz
  		authorize: true
	</script>
	<?php else: ?>
	<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  		api_key: 75a6k7ahbjlrny
  		authorize: true
	</script>
	<?php endif; ?>
	<!-- Include Google Maps API -->
	 <script src="https://maps.google.com/maps/api/js?sensor=false"></script>
</head>

<body style="width: 100%; height: 100%;">
    <div data-role="page" data-theme="a" id="home">
        <div data-role="header" data-position="fixed">
			</br>
			<center><?php print ( isset($_POST['fairname']) ? $_POST['fairname'] : '2014 Engineering Career Fair') ; ?></center>
			</br>
        </div>

        <div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
			<?php
				if (!$_SESSION['student_loggedin'] && !$_SESSION['admin_loggedin'] && !$_SESSION['employer_loggedin'])
				{
					echo '<li data-role="list-divider" >My Account</li>';
					echo'<li><a class="ui-btn ui-icon-user ui-btn-icon-left"  rel="external" href="login.php">Sign In!</a></li>';
				}
				else if($_SESSION['admin_loggedin']){
					echo '<li data-role="list-divider">My Account</li>';
					echo'<li><a rel="external" href="logout.php">Sign Out!</a></li>';
					echo'<li><a rel="external" href="admin.php">Admin Dashboard</a></li>';
				}
				else if($_SESSION['employer_loggedin']){
					echo '<li data-role="list-divider">My Account</li>';
					echo'<li><a rel="external" href="logout.php">Sign Out!</a></li>';
					echo'<li><a rel="external" href="employerView.php">Employer Dashboard</a></li>';	
				}
				else
				{
					echo '<li data-role="list-divider" style="background: linear-gradient(#FFEB99,#FFF0B2 )" >Student Tools</li>';
					echo '<li><a href="#myProfile">View My Profile</a></li>';
					echo '<li><a data-transition="flip" href="#prep">How to Prepare</a></li>';
					echo '<li><a rel="external" href="logout.php">Sign Out!</a></li>';
				}
			?>
			</ul>
			
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Information</li>
                <li>
                    <a data-transition="slideup" href="#companies">List of Companies</a>
                </li>
                <li>
                    <a data-transition="flip" href="#eventCalendar">List of Events </a>
                </li>
				<li>
                    <a data-transition="flip" href="#map">Map of the Career Fair</a>
                </li>	
				<li>
					<a data-transition="flip"  rel="external" href="newsFeedView.php">News Feed</a>
				</li>
			</ul>

        </div>
		<div data-role="footer" data-position="fixed" style="background: linear-gradient(#E6E6E6,#E6E6E6 )">
			<div data-role="navbar" data-iconpos="top">
				<ul>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" rel="external" data-icon="info" href="aboutUs.php">About Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="edit" href="mailto:mizzoucareerfairs@gmail.com"Subject="Mizzou Career Fairs Support">Contact Us</a></li>
					<li><a style="background: linear-gradient(#CCCCCC,#E6E6E6 )" data-icon="gear" href="#fairOptions">Fair Options</a></li>
				</ul>
				<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
			</div>
		</div>
		
		
		<div class="panel left" data-role="panel" id="fairOptions" data-position="left" data-display="overlay">
		
		<a  style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-bars ui-btn-icon-left" href="#fairSelect">Select a Fair</a>
		<a style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-navigation ui-btn-icon-left" data-transition="flip" href="#map_page">Get Directions</a>
		<a href="http://example.com/link-to-your-event" title="Add to Calendar" class="addthisevent" style="width: 80%;">
				<center>Add Fair to Calendar</center>
				<span class="_start">02-10-2015 10:00:00</span>
				<span class="_end">02-10-2015 15:30:00</span>
				<span class="_zonecode">11</span>
				<span class="_summary">Engineering Career Fair</span>
				<span class="_description">Spring 2015 Engineering Career Fair</span>
				<span class="_location">Hearnes Center Columbia, MO</span>
				<span class="_organizer">College of Engineering</span>
				<span class="_facebook_event">https://www.facebook.com/MUEngineering</span>
				<span class="_all_day_event">false</span>
				<span class="_date_format">MM/DD/YYYY</span>
			</a>
		</div>
		
		
		
	<?php include('fairSelection.php');?>
  </div>
  
  <?php include('displayProfile.php'); ?>
  <div data-role="page" data-theme="a" id="companies">
        <div data-role="header" data-position="fixed">
            <h1 onclick="$.mobile.silentScroll(0)">Companies</h1>
            <a data-transition="slidedown" data-icon="arrow-l" data-iconpos="notext" href="#home">Home</a> 
			<a data-transition="slide" data-icon="bullets" href="companyFilter.php">Filters</a>
        </div>
				
		<div data-role="content">
			<div data-role="tabs">
				<div data-role="navbar">
					<ul>
						<li><a href="#unfiltered">All</a></li>
						<li><a href="#filtered">Filtered</a></li>
						<?php
						if($_SESSION['student_loggedin']){
							echo '<li><a href="#visited">Visited</a></li>';
						}
						?>
					</ul>
				</div>

				<!-- List all of the companies, each company can be accessed as an individual page via companyLoad.php down below-->
				<?php include 'companyParse.php' ?>
				<div id="unfiltered">
					<form class="ui-filterable">
						<input id="UNFILTERED" data-type="search">
					</form>
						<ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#UNFILTERED" data-autodividers="true">
						<?php include 'displayWithoutFilters.php'; ?>
						</ul>
				</div>
				<div id="filtered">
					<form class="ui-filterable">
						<input id="FILTERED" data-type="search">
					</form>
					<ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#FILTERED" data-autodividers="true">
					<?php include 'displayWithFilters.php'; ?>
					</ul>
				</div>
				<?php if($_SESSION['student_loggedin']): ?>
				<div id="visited">
					<form class="ui-filterable">
						<input id="VISITED" data-type="search">
					</form>
					<ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#VISITED" data-autodividers="false">
					<?php include 'displayVisited.php'; ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
		</div>
    </div>

	<?php
	//Load a page for each company dynamically
	include('companyLoad.php');
	?>
	
	<!-- Page to add career fair related events as show on 
		http://engineering.missouri.edu/careers/calendar/
	-->

    <div data-role="page" data-theme="a" id="eventCalendar" style="position:fixed;">
        <div data-role="header" data-position="fixed">
            <h1>Events</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>


        
		<div data-role="content" style="height:300px;">
			<div class="addthisevent" style="padding: 0px 0px 0px 13px;">
				<div class="date">
					<span class="mon">NOV</span>
					<span class="day">15</span>
					<div class="bdr1"></div>
					<div class="bdr2"></div>
				</div>
				<div class="desc">
					<p>
					<strong class="hed">2014 Garmin Contest</strong>
					<span class="des">Location: Ketcham, Lafferre<br />When: 8 AM - 5 PM</span>
					</p>
				</div>
				<span class="_start">11-15-2014 8:00:00</span>
				<span class="_end">11-15-2014 17:00:00</span>
				<span class="_zonecode">11</span>
				<span class="_summary">2014 Garmin Programming Showdown</span>
				<span class="_description">Test your programming skills and create your own app, such as a custom watch face, information widget or mobile interactive for Garmin wearable technology devices with our new Connect IQ Software Development Kit.  Compete on your own or with a friend.

Free Food!  Prizes for the Winners!!!!!</span>
				<span class="_location">Ketcham Auditorium/Lafferre Hall</span>
				<span class="_organizer">Engineering Career Services</span>
				<span class="_organizer_email">engcareerservices@gmail.com</span>
				<span class="_all_day_event">false</span>
				<span class="_date_format">MM/DD/YYYY</span>
			</div>    
			
			<br><br>
			<div class="addthisevent" style="padding: 0px 0px 0px 13px;">
				<div class="date">
					<span class="mon">FEB</span>
					<span class="day">10</span>
					<div class="bdr1"></div>
					<div class="bdr2"></div>
				</div>
				<div class="desc">
					<p>
					<strong class="hed">2015 Engineering Fair</strong>
					<span class="des">Hearnes Center Concourse<br />When: 10 AM - 3:30 PM</span>
					</p>
				</div>
				<span class="_start">2-10-2015 8:00:00</span>
				<span class="_end">2-10-2015 17:00:00</span>
				<span class="_zonecode">11</span>
				<span class="_summary">Spring 2015 Engineering Career Fair</span>
				<span class="_description">Explore opportunities in engineering internships and careers.  Bring a resume and dress professionally.  Explore companies and more at :
				babbage.cs.missouri.edu/~cs4970s14grp2/mizzoucareerfairs/
				</span>
				<span class="_location">Hearnes Center Concourse, Columbia, MO</span>
				<span class="_organizer">Engineering Career Services</span>
				<span class="_organizer_email">engcareerservices@gmail.com</span>
				<span class="_all_day_event">false</span>
				<span class="_date_format">MM/DD/YYYY</span>
			</div>
        </div>
        <div data-role="footer" data-position="fixed">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
    <!-- Page for the user to get a google map to the fair, it should attempt to start from geo location -->
	<div data-role="page" id="map_page" style="height: 50% width: 50%">
            <div data-role="header" data-position="fixed">
				<h1>Directions</h1>
				<a data-direction="reverse" data-icon="home" data-iconpos="notext"
				href="#home">Home</a>
			</div>
			</br>
            <div data-role="content" style="height: 100% width: 100%" class="ui-bar-c ui-corner-all ui-shadow" style="padding:1em;">
                   <div id="map_canvas" style="height:400px; width: 100%"></div>
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
                    <a data-icon="navigation" data-role="button" href="" id="submitDirections">Get Directions</a>
                <div id ="directions" style="height: 100%"></div> 
				<!--
			    <div id="results" style="display:none;">
                    <div id="directions"></div>
                </div>
				-->
                    <div id="mapOptions" data-role="fieldcontain" style="display:none;">
						<label for="flip-2">Display Map : </label>
						<select id="toggleMap" data-role="slider">
							<option value="off">Off</option>
							<option value="on">On</option>
						</select>
						<a id="resetSearch" style="float:right;" data-icon="navigation" href="#" data-role="button" data-inline="true" data-theme="b">Reset Search</a>
					</div>
                </br>
				 <div class="ui-bar-c ui-corner-all ui-shadow" style="padding:1em;"><center>
				<a style="background: linear-gradient(#FFCC00,#E6E6E6 )" data-inline="true" data-iconpos="top" data-role="button" href="http://maps.apple.com/maps?daddr=38.933294,-92.330062&saddr=Current%20Location" target="_blank" style="background: linear-gradient(#CCCCCC,#E6E6E6 )" rel="external" data-icon="audio">	Open in Apple Maps App	</a>
				<a style="background: linear-gradient(#FFD119,#E6E6E6 )" data-inline="true" data-iconpos="top" data-role="button" href="http://maps.google.com/maps?daddr=38.933294,-92.330062&saddr=Current%20Location" target="_blank" style="background: linear-gradient(#CCCCCC,#E6E6E6 )" rel="external" data-icon="audio">	Open in Google Maps App	</a>
				</center></div>
            </div>
    </div>
	<!-- End Page for the user to get a google map to the fair, it should attempt to start from geo location -->
	
	<!--Start preparation HTML-->
	<div data-role="page" data-theme="a" id="prepare">
        <div data-role="header" data-position="fixed">
            <h1>Preparation Steps</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>How to prepare</h2>
			
			<p>
			Know which companies want to talk with: 
			</p>
			<ul>
				<li><span style="font-size:11.0pt">The day before the career fair, google each company and learn in a broad sense what they do.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Once you have done this, decide which of your accomplishments fit their scope and focus on those when you talk to their recruiters. <o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Pick which of your traits fit the company best and sell yourself to the company with those traits in mind.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Memorize some questions about the company so the recruiter knows you’ve done some research and you are actually interested in the company. <o:p></o:p></span></li>
			</ul>
		</div>
		<div data-role="footer" data-position="fixed">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>	
	
	<div data-role="page" data-theme="a" id="resume">
        <div data-role="header" data-position="fixed">
            <h1>Rules of the Resume</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>How?</h2>
			
			<p>
			Know which companies want to talk with: 
			</p>
			<ul>
				<li><span style="font-size:11.0pt">Have a clean ONE page resume. With very few exceptions, college students have do not have enough experience to fill more than one page.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Do not staple references or a cover page to your resume. You may bring a reference page, but only give it to the employers if they ask.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Since you are not applying for a specific job, you do not need a cover sheet.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">We strongly recommend taking advantage of the resume builder seminars given by Engineering Career Services.<o:p></o:p></span></li>
			</ul>
		</div>
		<div data-role="footer" data-position="fixed">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	
	<div data-role="page" data-theme="a" id="dressCode">
        <div data-role="header" data-position="fixed">
            <h1>Dress for Success</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
		
		<div data-role="content">
			<h2>Dress like your job depends on it!</h2>

			<p>
			The dress code is business professional.
			</p>
			
			<ul>
				<li><span style="font-size:11.0pt">Students should dress as if they are going to a professional job interview.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Do not wear polos, jeans, shorts, or open toed shoes.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Men should wear a suit and tie.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Women should wear a suit, dress, or knee length skirt.<o:p></o:p></span></li>
			</ul>
		</div>
		<div data-role="footer" data-position="fixed">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="confidence">
        <div data-role="header" data-position="fixed">
            <h1>Confidence</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
		<div data-role="content">
			<h2>Be confident in yourself</h2>

			<p>
			Whether you are graduating at the end of the semester or in two years, you are at the career fair trying to get either a job or an internship.
			</p>
			
			<ul>
				<li><span style="font-size:11.0pt">Walk around the entire arena atleast once before you talk to someone. Get the feel for how everyone is acting, 
				calm yourself down, etc, etc. Plan an exit strategy just in case you get nervous and have a panic attack.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Make yourself stand out – highlight the things you are good at AND enjoy. Pick companies that are looking for just that. If you go to a company and talk about what you know, they are going to know what you are talking about.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Make a small portfolio with some of the work you have done in that area and show it to potential employers.<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Have confidence. Know what you are doing.<o:p></o:p></span></li>
			</ul>
		</div>
		<div data-role="footer" data-position="fixed">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	<!--End preparation HTML-->
	
	<!--Start Job Hunt HTML-->
    <div data-role="page" data-theme="a" id="jobHunt">
        <div data-role="header" data-position="fixed">
            <h1>My Job Hunt</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

        <div data-role="content">
        	<h2>LinkedIn : </h2>
			<?php // echo"<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"></script>
			echo "<script type=\"IN/JYMBII\" data-format=\"inline\"></script>" ?>
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li>
                    <a href="addResume.php">Add a Resume</a>
                </li>
                <li>
                    <a id="hireMizzou">Hire Mizzou Tigers</a>
                </li>
            </ul>
        </div>
    </div>
	<!--End Job Hunt HTML.-->

	<!--Start Success Resume HTML-->
    <div data-role="page" data-theme="a" id="successResume">
        <div data-role="header" data-position="fixed">
            <h1>Success</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
			<h3>Your Resume has been saved!</h3>
        </div>
    </div>
	<!--End Success Resume HTML.-->
	
	<!--Start Success Profile HTML-->
    <div data-role="page" data-theme="a" id="successProfile">
        <div data-role="header" data-position="fixed">
            <h1>Success</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
			<h3><center>Your Profile has been saved!<center></h3>
			<a href="index.php#myProfile" data-role="button">Return to Your Profile</a>
        </div>
    </div>
	<!--End Success Profile HTML.-->
	
	<!--Start Failure file large Resume HTML-->
    <div data-role="page" data-theme="a" id="failureResumeLarge">
        <div data-role="header" data-position="fixed">
            <h1>Failure</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
			<h3>Your file is too large.  Please try again!</h3>
        </div>
    </div>
	<!--End Failure file large Resume HTML.-->
	
	<!--Start Failure file type Resume HTML-->
    <div data-role="page" data-theme="a" id="failureResumeType">
        <div data-role="header" data-position="fixed">
            <h1>Failure</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
			<h3>Your file should be a PDF or DOC.  Please try again!</h3>
        </div>
    </div>
	<!--End Failure file type Resume HTML.-->
	
	<!--Start Failure student registration HTML-->
    <div data-role="page" data-theme="a" id="failureRegistration">
        <div data-role="header" data-position="fixed">
            <h1>Failure</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
        <div data-role="content">
			<h3>You must be a University of Missouri student to register for the Mizzou Career Fair App!</h3>
        </div>
    </div>
	<!--End Failure file type Resume HTML.-->

	<!--Start map HTML-->
    <div data-role="page" data-theme="a" id="map">
        <?
        include ("data.php");
        $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

        $query = "SELECT * FROM careerSchema.mapUploads WHERE inUse = TRUE";
        $result =  pg_query($query) or die('Query failed: ' . pg_last_error());
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
        $filePath = $line["filepath"];
        ?>

        <div data-role="header" data-position="fixed">
            <h1>Mizzou Career Fair App Hearnes Map</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a>
        </div>

        <img alt="Fair Map" src="<?php echo $filePath;?>" style="width:100%" data-elem="pinchzoomer" data-options="scaleMode:full;"/>

        <div data-position="fixed" data-role="footer">
           <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	<!--End map HTML-->

	<!--Start old rewrite code-->
    <div data-role="page" data-theme="a" id="prep">

        <div data-role="header" data-position="fixed">
            <h1>Career Fair Events</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>


       <div data-role="content">
            <!--<ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">How To's and Tutorials</li>
				
				<li>
                    <a href="#questions">Recruiter Questions</a>
                </li>

                <li>
                    <a href="#dress">Dress for Success</a>
                </li>

                <li>
                    <a href="#standOut">Standing Out</a>
                </li>

                <li>
                    <a href="#speech">Making Your Speech Count</a>
                </li>
				
				<li>
                    <a href="#badGrades">Bad Grades?</a>
                </li>
            </ul>-->

            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Keys to a successful career fair</li>
				
				<li>
                    <a href="#prepare">Preparation</a>
                </li>
				<li>
                    <a href="#resume">Resume</a>
                </li>
				<li>
                    <a href="#dressCode">Dress Code</a>
                </li>
				<li>
                    <a href="#confidence">Confidence</a>
                </li>
            </ul>
        </div>


        <div data-position="fixed" data-role="footer">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="dress">
        <div data-role="header" data-position="fixed">
            <h1>How to Dress</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>Dress for Success</h2>
			Dress professionally and conservatively</br></br>
			Ladies: wear conservative suit, dress, or knee length skrit and close toed dress shoes</br></br>
			Gentelmen: wear a suit, tie, and polished dress shoes</br></br>
			Do not wear heavy perfume/cologne</br></br>
			Do not chew gum during the fair</br></br>
		</div>


        <div data-position="fixed" data-role="footer" data-role="footer">
            <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>

    </div>	
	
	<div data-role="page" data-theme="a" id="standOut">
        <div data-role="header" data-position="fixed">
            <h1>Standing Out</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>Making the Best First Impression</h2>
			Bring at least 20 copies of your resume</br></br>
			Bring a pen and a nice folder to carry your resumes</br></br>
			Smile, make eye contact and shake hands firmly and confidently</br></br>
			Be aware of your body language - don't fidget or let your eyes wander</br></br>
			Display interest and enthusiasm</br></br>
			Be confident and pleasent</br></br>
			Create meaningful conversation and be an active listener</br></br>
			Ask questions in order to make the most of your time at each booth</br></br>
			
		</div>


        <div data-position="fixed" data-role="footer">
           <center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	
	<div data-role="page" data-theme="a" id="speech">
        <div data-role="header" data-position="fixed">
            <h1>Practice your speech</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>Practice Presenting to Yourself</h2>
			Have a one-minute or less pitch ready to concisely state what you are looking for in a job, your skills, expertise and related expertise
			and related experience for each company that you visit at the career fair.</br></br>
			
			<h2>Speech Guidelines</h2>
			Be excited about the opportunity to speak to a direct representive of the compnay</br></br>
			Be specific</br></br>
			Target your pitch to the company and role in which you are interested</br></br>
			Keep your pitch conversational and natural, not too heavy on details</br></br>
			Make yourself standout from the crowd</br></br>
			Be excited about the opportunity to speak to a direct representive of the compnay</br></br>
			
			<h2>Create and Revise Your Speech</h2>
			Beging your speech with a breif introduction</br></br>
			Talk about your prior experience clearly, state what you have learned during your work experience</br></br>
			Never speak negatively about any company that you have worked for</br></br>
			Be prepared to be stopped while you are speaking</br></br>
			Discuss your skills and knowledge.  Your resume should clearly highlight your technical skills
			
			
			
		</div>


        <div data-position="fixed" data-role="footer">
			<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="questions">
        <div data-role="header" data-position="fixed">
            <h1>Common Recruiter Questions</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
		<h2>Career Fair Questions</h2>
      What's your GPA?</br></br>
      Tell me about yourself; what type
          of work are you interested in?</br></br>
      What industries interest you?</br></br>
      What do you know about our
          organization?</br></br>
      Have you had an internship?&nbsp;
          If so, what did you learn?</br></br>
    What have you achieved outside of
          the classroom?</br></br>
      What is your favorite class so
          far?</br></br>
      Are you interested in relocating?</br></br>
    
		</div>


        <div data-position="fixed" data-role="footer">
			<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="badGrades">
        <div data-role="header" data-position="fixed">
            <h1>Dealing with Bad Grades</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#prep">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
		<h2>Grade Problems ?</h2>
		
		<p>
		If you are reading
        this
        article, then you are concerned or even worried that your grades
        may affect
        your ability to find a job after your graduation. While it is
        true that students with high grades, along with relevant work
        experience have
        more employment options than those with lower grades and/or no
        work experience,
        you too have options of your own.
		</p></br>
		
		<p>
		The ability to
        find suitable
        employment is a complex task that will rely heavily on your
        ability to convince
        a potential employer that you possess the skills and abilities
        to fill a
        position and to make a significant contribution to the
        organization. It would
        be your responsibility to provide the employer with this needed
        information so
        that he or she can make an informed decision about your
        candidacy for
        employment. While there are all kinds of hints and tips about
        how to interview,
        you will find that you will interview well: 
		</p>
		<ul>
      <li><span style="font-size:11.0pt">If you interview with a company
          that clearly matches your skills and abilities<o:p></o:p></span></li>
      <li><span style="font-size:11.0pt">If you take the time to prepare
          for the interview in advance so that you can
          clearly articulate your marketable skills and abilities<o:p></o:p></span></li>
      <li><span style="font-size:11.0pt">When you prepare a
          reasonable response to questions about your grades <o:p></o:p></span><span
          style="font-size:11.0pt"><o:p>&nbsp;</o:p></span>
      </li>
    </ul>
	
	<p>
	Nothing can be
        done to
        significantly increase your grades when are within a year of
        graduation, but
        you can do the following as you prepare to graduate and enter
        the workforce:
	</p>
	
	<ul>
      <li><span style="font-size:11.0pt">Visit Career Services for
          guidance in focusing your job search.<o:p></o:p></span></li>
      <li><span style="font-size:11.0pt">Sign up for a practice
          interview session at Career Services.<o:p></o:p></span></li>
      <li><span style="font-size:11.0pt">Attend the seminars offered by
          Career Services that cover topics related to
          the employment search.<o:p></o:p></span></li>
      <li><span style="font-size:11.0pt">Have your r&eacute;sum&eacute;
          critiqued
          to highlight your marketable skills. <o:p></o:p></span></li>
    </ul>
	
	<p>
	You&#8217;ve made a
        tremendous
        investment of time and money in your college education. Take
        advantage of all
        of the resources available to you at your university that provide
        personal and
        professional growth. Refuse to let yourself be solely defined by
        your grade
        point average and make some decision now to maximize your
        remaining time at
        school!
	</p>
		</div>

        <div data-position="fixed" data-role="footer">
			<center>&copy; 2014 Mizzou Career Fair App Dev Team</center>
		</div>
    </div>
	<!--End old rewrite HTML-->
	<script type="text/javascript" src="index.js"></script>
</body>
</html>
