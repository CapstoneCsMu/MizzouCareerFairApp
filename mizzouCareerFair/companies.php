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
               <h1>Companies</h1>
				<a href="mobile.php" data-icon="home" data-iconpos="notext" data-direction="reverse">Home</a>
		<a href="../nav.html" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a>
         </div>
		 
         <div data-role="content">      
               <ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Full Time</li> 
                     <li><a href="companies.php">3M</a></li> 
                     <li><a href="option2.html">ABB, Inc.</a></li> 
                     <li><a href="option3.html">Ameren</a></li> 
                     <li><a href="option4.html">Anheuser-Busch</a></li> 
					 <li><a href="option5.html">Burns and McDonnell</a></li>
					 <li><a href="option6.html">Cerner</a></li>
					 <li><a href="option7.html">Commerce Bank</a></li>
					 <li><a href="option8.html">IBM</a></li>
               </ul>

				 <ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Internships</li> 
                     <li><a href="companies.php">3M</a></li> 
                     <li><a href="option2.html">DISH</a></li> 
                     <li><a href="option3.html">Express-Scripts</a></li> 
                     <li><a href="option4.html">Garmin International</a></li> 
					 <li><a href="option5.html">Georgia-Pacific</a></li>
					 <li><a href="option6.html">IBM</a></li>
					 <li><a href="option7.html">Laclede Gas Company</a></li>
					 <li><a href="option8.html">Mindtree Ltd</a></li>
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