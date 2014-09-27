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
    <!-- Include CSS and JQM CSS -->
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">
	<link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">
	<link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
 
 </head> 
 <body> 
    <div data-role="page" data-theme="a"> 
         <div data-role="header"> 
               <h1>Announcements</h1>
				<a href="index.php" data-icon="home" data-iconpos="notext" data-direction="reverse" data-transition="flip">Home</a>
		<a href="../nav.html" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a>
         </div>
		 
         <div data-role="content">      
               <ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Career Fair Announcements </li> 
                     <li><a href="option">New Companies</a></li> 
                     <li><a href="option2.html">Changed Booth Locations</a></li> 
					 <li><a href="option8.html">Updates</a></li>
               </ul>           
         </div>

<div data-role="footer" data-position="fixed">		 
        <div data-role="footer">
		
		<input type="text" name="name" placeholder="Search the Career Fair"id="basic" value="" data-mini="true" />
         <h4>&copy; 2014 Team X Mizzou Career Fair Web App</h4>
        </div> 
    </div> 
    </body> 
    </html>