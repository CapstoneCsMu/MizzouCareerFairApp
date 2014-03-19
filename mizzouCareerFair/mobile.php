<!DOCTYPE html> 
<html> 
  <head> 
  <!--
       <meta charset="utf-8"> 
       <title>Mizzou Career Fairs</title>
       <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css">
       <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script> 
       <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
       <meta name="viewport" content="width=device-width, initial-scale=1">
 -->
 
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/themes/MizzouCareerFair.css" />
  <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css" /> 
  <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script> 
  <script src="http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script> 
 
 
 </head> 
 <body> 
    <div data-role="page" data-theme="a"> 
         <div data-role="header"> 
               <h1>Mizzou Career Fair Application</h1>
				<a href="mobile.php" data-icon="home" data-iconpos="notext" data-direction="reverse">Home</a>
		<a href="../nav.html" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a>
         </div>
		 
         <div data-role="content">      
               <ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Options</li> 
                     <li><a href="companies.php">Companies</a></li> 
                     <li><a href="fairmap.php">Fair Map</a></li> 
                     <li><a href="events.php">Events</a></li> 
                     <li><a href="announcements.php">Announcements</a></li> 
					 <li><a href="option5.html">Career Fair Neccessities</a></li>
					 <li><a href="option6.html">Support</a></li>
					 <li><a href="option7.html">Fairs</a></li>
					 <li><a href="option8.html">Updates</a></li>
			   </ul>

				<ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Sign In To Check In With Recruiters</li> 
                     <li><a href="linkedinpop.php">LinkedIn - Sign In!</a></li>
					 <li><a href="tigerspop.php">Mizzou Tigers - Sign In!</a></li>
				</ul>
         </div>

		<div data-role="footer" data-position="fixed">		 
			<div data-role="footer">
				<input type="text" name="name" placeholder="Search the Career Fair"id="basic" value="" data-mini="true" />
         <h4>&copy; 2014 Team X Mizzou Career Fair Web App</h4>
        </div> 
		</div>
		
		<div data-role="page" data-dialog="true" id="linkedinpop">
			<div data-role="header">
				<h1>Log in with LinkedIn</h1>
			</div>
			
			<div data-role="main" class="ui-content">
				<p>You have the ability to Check In at the Employer Booths.  If you would like the Recruiters to have your LinkedIn profile sent to them Sign In Here</p>
				<a href="mobile.php">Back to Home</a>
			</div>
			
			<div data-role="footer">
				<h1>LinkedIn Sign In</h1>
			</div>
		</div>
	</body> 
    </html>