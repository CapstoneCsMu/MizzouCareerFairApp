<?php
	include('check_https.php');
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
	
	<!--Start Employer View HTML-->
	
	<div data-role="page" data-theme="a" id="home">
        <div data-role="header" data-position="fixed">
            <h1 class="no-ellipses">Company Page</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="index.php">Home</a> <a data-icon="search" data-iconpos=
            "notext" data-rel="dialog" data-transition="fade" href=
            "search.php">Search</a>
        </div>

		

        <div data-role="content">
            
            
            
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Career Fair</li>


                <li>
                    <a data-transition="flip" href="#qrReader">QR Code Reader</a>
                </li>

				<li>
                    <a data-transition="flip" href="#scannedStudents">Students You Have Scanned!</a>
                </li>	
                
                <li>
                    <a data-transition="flip" href="#map_page">Directions to Fair-In Progress</a>
                </li>
				
                <li>
                    <a data-transition="flip" href="#map">Fair Map - Coming soon</a>
                </li>

				<li>
					<a data-transition="flip" href="announcements.php">Announcements</a>
				</li>
				
				<li>
                    <a data-transition="flip" href="#aboutECS">Engineering Career Services</a>
                </li>

				<li>
					<a data-transition="flip" href="support.php">Support</a>
				</li>
			</ul>
            
            <a><?php echo "<script type=\"in/Login\">Hello, <?js= firstName ?> <?js= lastName ?>.</script>" ?></a>

	    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
            
        </div>

    </div>
	
	<!--Start QR Reader HTML-->
  <div data-role="page" data-theme="a" id="qrReader">
        <div data-role="header" data-position="fixed">
            <h1>Scan your potential employees to save their information!</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext" href="#home">Home</a> 
			<a data-transition="slide" data-icon="bullets" href="qrReader.php">Filters</a>
        </div>
	
		<p>
			Coming Soon! A QR Reader will open now!
		</p>
	</div>
	<!--End QR Reader HTML-->
	
	<!--Start scanned students HTML-->
	<div data-role="page" data-theme="a" id="scannedStudents">
        <div data-role="header" data-position="fixed">
            <h1>Potential Employees</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

        <div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Students you have scanned</li>
				
				<li>
                    <a href="#one">Fred Bird</a>
                </li>
				<li>
                    <a href="#two">Bernie Brewer</a>
                </li>
				<li>
                    <a href="#three">DJ Kitty</a>
                </li>
				<li>
                    <a href="#four">Rosie Red</a>
                </li>
				<li>
					<a href="#five">T.C. Bear</a>
                </li>
				<li>
                    <a href="#six">Pirate Parrot</a>
                </li>
            </ul>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="one">
        <div data-role="header" data-position="fixed">
            <h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>	
    </div>	
	
	<div data-role="page" data-theme="a" id="two">
        <div data-role="header" data-position="fixed">
            <h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>
    </div>
	
	
	<div data-role="page" data-theme="a" id="three">
        <div data-role="header" data-position="fixed">
            <h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
		
		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>
    </div>
	
	<div data-role="page" data-theme="a" id="four">
        <div data-role="header" data-position="fixed">
            <h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>
    </div>
	
	<div data-role="page" data-theme="a" id="five">
        <div data-role="header" data-position="fixed">
            <h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a> 
        </div>

		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>
    </div>
	<div data-role="page" data-theme="a" id="six">
		<div data-role="header" data-position="fixed">
			<h1>Blanks Information</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#scannedStudents">Back</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
		</div>

		<div data-role="content">
			<p>
			He is a good employee. 
			</p>
		</div>
    </div>
	<!--End scanned students HTML-->

	<!--End Employer View HtmL-->
	</body>
	</html>