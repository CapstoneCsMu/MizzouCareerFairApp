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
	<div data-role="page" data-theme="a" id="aboutECS">
        <div data-role="header" data-position="fixed">
            <h1>About Us</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext" rel="external"
            data-transition="flip" href="index.php">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>
			<div data-role="content">
			<center><h2>Engineering Career Services</h2></center>
				<p>
				Engineering Career Services provides information, guidance and resources to empower Mizzou 
				Engineering students to develop and achieve their career goals.
				</p>
			<center><h2>The Development Team</h2></center>
			<div align="center">
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/matthew-weiner/48/21a/286" data-format="inline" data-related="false"></script>
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/ryan-pliske/94/6b9/341" data-format="inline" data-related="false"></script>
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/kristi-decker/62/453/b47" data-format="inline" data-related="false"></script>
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/adam-lyons/73/72/691" data-format="inline" data-related="false"></script>
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/stephen-schroeder/96/b44/817" data-format="inline" data-related="false"></script>
			<script type="IN/MemberProfile" data-id="https://www.linkedin.com/pub/cecilia-martinez/57/727/973" data-format="inline" data-related="false"></script>
			</div>
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
</body>
</html>