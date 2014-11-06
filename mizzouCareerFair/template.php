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
				<a href="search.php" data-icon="search" data-iconpos="notext" data-rel="dialog" data-transition="fade">Search</a>
         </div>
		 
         <div data-role="content">      
               <ul data-role="listview" data-inset="true" data-dividertheme="b"> 
                     <li data-role="list-divider">Options</li> 
                     <li><a href="1" data-transition="flip">1</a></li> 
                     <li><a href="2" data-transition="flip">2</a></li> 
                   
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