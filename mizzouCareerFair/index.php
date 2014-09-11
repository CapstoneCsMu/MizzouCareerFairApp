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
	
    <link href=
    "http://code.jquery.com/mobile/1.4.1/jquery.mobile.structure-1.4.1.min.css"
    rel="stylesheet">
    
    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src=
    "http://code.jquery.com/mobile/1.4.1/jquery.mobile-1.4.1.min.js"></script>
    
    <!-- Include JS file for our JS -->
    <script src="js/index.js"></script>
    
    <!-- Include LinkedIn Framework, API Key Unique to Us -->
    <script type="text/javascript" src="http://platform.linkedin.com/in.js">
  		api_key: 75a6k7ahbjlrny
  		onLoad: onLinkedInLoad
  		authorize: true
	</script>
	
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>
	
	 <script type="text/javascript">
            $(document).on("pageinit", "#map_page", function() {
                initialize();
            });

            $(document).on('click', '#submit', function(e) {
                e.preventDefault();
                calculateRoute();
            });

            var directionDisplay,
                directionsService = new google.maps.DirectionsService(),
                map;

            function initialize() 
            {
                directionsDisplay = new google.maps.DirectionsRenderer();
                var mapCenter = new google.maps.LatLng(38.9343, -92.3306);

                var myOptions = {
                    zoom:10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    center: mapCenter
                }

                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById("directions"));

				
				
				navigator.geolocation.getCurrentPosition(showPosition);
				var latlon;
				
				function showPosition(pos) {
					var latlon = pos.coords.latitude+","+pos.coords.longitude;
					console.log(latlon);
					
					$('#from').val(latlon);
				};
            }

			
			
			
            function calculateRoute() 
            {
				var x = document.getElementById("map_canvas");
				
				navigator.geolocation.getCurrentPosition(showPosition);
				var latlon;
				
				function showPosition(pos) {
					var latlon = pos.coords.latitude+","+pos.coords.longitude;
					console.log(latlon);
					
				};
					
			
			
                var selectedMode = $("#mode").val(),
                    start = $("#from").val(),
                    end = $("#to").val();

                if(start == '' || end == '')
                {
                    // cannot calculate route
                    $("#results").hide();
                    return;
                }
                else
                {
                    var request = {
                        origin:start, 
                        destination:end,
                        travelMode: google.maps.DirectionsTravelMode[selectedMode]
                    };

                    directionsService.route(request, function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response); 
                            $("#results").show();
                            /*
                                var myRoute = response.routes[0].legs[0];
                                for (var i = 0; i < myRoute.steps.length; i++) {
                                    alert(myRoute.steps[i].instructions);
                                }
                            */
                        }
                        else {
                            $("#results").hide();
                        }
                    });

                }
            }
        </script>
   
</head>

<body>
    <div data-role="page" data-theme="a" id="home">
        <div data-role="header" data-position="fixed">
            <h1 class="no-ellipses">Mizzou Careers</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="index.php">Home</a> <a data-icon="search" data-iconpos=
            "notext" data-rel="dialog" data-transition="fade" href=
            "search.php">Search</a>
        </div>

		

        <div data-role="content">
            
            
            
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Career Fair</li>


                <li>
                    <a data-transition="flip" href="#companies">Companies</a>
                </li>


                <li>
                    <a data-transition="flip" href="#companyTest">Test
                    Company/API's this is Static</a>
                </li>
                
                <li>
                    <a data-transition="flip" href="#map_page">Directions to Fair-In Progress</a>
                </li>


                <li>
                    <a data-transition="flip" href="#map">Fair Map - Coming soon</a>
                </li>


                <li>
                    <a data-transition="flip" href="#events">Events and Preparation</a>
                </li>

                <li>
                    <a data-transition="flip" href="#">Fairs</a>
                </li>
            </ul>


            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Sign In and Reach Out</li>

                <li>
                    <a href="tigerspop.php">Mizzou Tigers - Sign In!</a>
                </li>
                
                <li>
                    <a href="#jobHunt">My Job Hunt</a>
                </li>
                
                
            </ul>
            
            <a><?php echo "<script type=\"in/Login\">
Hello, <?js= firstName ?> <?js= lastName ?>.
</script>" ?></a>
            
        </div>

    </div>


    <!-- This page should have a list of all of the companies in the RSS feed 
    
    	 The data in RSS must made useful and unique so we know what companies we are using
    -->

    <div data-role="page" data-theme="a" id="companies">
        <div data-role="header" data-position="fixed">
            <h1>Companies</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="#home">Home</a> <a data-icon="search" data-iconpos="notext"
            data-rel="dialog" data-transition="fade" href=
            "../nav.html">Search</a>
        </div>
	
		<form class="ui-filterable">
      		<input id="companyFilter" data-type="search">
    	</form>


		<!-- List all of the companies at the career fair
		As list populates each company becomes href=#company(i) so that each company can be accessed as an individual page -->

        <ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#companyFilter" data-autodividers="true">
            <li data-role="list-divider">Full Time</li>
            <?php
                            include 'companyParse.php';
                                                         
                            //sort names alphabetically and print them as list options
                            asort($companyNames);
                            $i = 1;
                            foreach($companyNames as $companyName => $val)
                            {
								echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val.'</a></li>';
                            	$i++;
                            }
            ?>
        </ul>
    </div>

	<!--  
		The company details should be built up into a html string using JS or PHP and appended
		to the content div on this page
		
		You can add the data by doing something like 
		
		$("#details-page").data("info", info[this.id]);
		$.mobile.changePage("#company Details");
		
		$(document).on("pagebeforeshow", "#companyDetails", function () {
			var info = $(this).data("info");
			var info_view = "";
			
			 for (var key in info) {
				info_view += '<div class="ui-grid-a"><div class="ui-block-a">
				<div class="ui-bar field" style="font-weight : bold; text-align: left;">' + key + '</div></div>
				<div class="ui-block-b"><div class="ui-bar value" style="width : 75%">' 
				+ info[key] + '</div></div></div>'
			}
			
			//add this to html
			$(this).find("[data-role=content]").html(info_view)
	-->
	<div data-role="page" data-theme="a" id="companyDetails">
        <div data-role="header" data-position="fixed">
            <h1>Company Details</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="#home">Home</a> <a data-icon="search" data-iconpos="notext"
            data-rel="dialog" data-transition="fade" href=
            "../nav.html">Search</a>
        </div>
	
		<div data-role="content"></div>
	
    </div>

	<?php
	//Load a page for each company dynamically
	include('companyLoad.php');
	?>

	<!-- Static Data, Just to test what we can do with some APIs-->
    <div data-role="page" data-theme="a" id="companyTest">
        <div data-role="header" data-position="fixed">
            <h1>Companies</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="#home">Home</a> <a data-icon="search" data-iconpos="notext"
            data-rel="dialog" data-transition="fade" href=
            "../nav.html">Search</a>
        </div>


        <ul data-dividertheme="b" data-inset="true" data-role="listview">
            <li data-role="list-divider">Full Time</li>


            <li>
                <a href="#ibm">IBM</a>
            </li>

        </ul>
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
                    <div data-role="fieldcontain">
                        <label for="from">From</label> 
                        <input type="text" id="from"/>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="to">To</label> 
                        <input type="text" id="to" value="Hearnes Center 600 E Stadium Blvd, Columbia, MO 65203"/>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="mode" class="select">Transportation method:</label>
                        <select name="select-choice-0" id="mode">
                            <option value="DRIVING">Driving</option>
                            <option value="WALKING">Walking</option>
                            <option value="BICYCLING">Bicycling</option>
                        </select>
                    </div>
                    <a data-icon="navigation" data-role="button" href="#" id="submit">Get directions</a>
                </div>
                <div id="results" style="display:none;">
                    <div id="directions"></div>
                </div>
            </div>
        </div>>
    
    
    
    <!-- Testing what we can do for a company -->
    <div data-role="page" data-theme="a" id="ibm">
    	<div data-role="header" data-position="fixed">
            <h1>IBM</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            href="#home">Home</a> <a data-icon="search" data-iconpos="notext"
            data-rel="dialog" data-transition="fade" href=
            "../nav.html">Search</a>
        </div>
        
        <div data-role="content">
        	<h3>Company Information:
        	</h3>
        	The International Business Machines Corporation (IBM) is an American multinational technology and consulting corporation, with headquarters in Armonk, New York, United States. IBM manufactures and markets computer hardware and software, and offers infrastructure, hosting and consulting services in areas ranging from mainframe computers to nanotechnology.
        <br>
        <?php echo "<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"></script>
<script type=\"IN/CompanyProfile\" data-id=\"1009\" data-format=\"inline\"></script>" ?>
        </div>	
        
        
        
    </div>


    <div data-role="page" data-theme="a" id="map">
        <div data-role="header" data-position="fixed">
            <h1>Mizzou Career Fair App Hearnes Map</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>


        <div data-role="content"><img alt="Fair Map" src="images/fairmap.jpg"
        style="width:100%">
        </div>


        <div data-position="fixed" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>


    <div data-role="page" data-theme="a" id="events">
        <div data-role="header" data-position="fixed">
            <h1>Career Fair Events</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>


        <div data-role="content">
			<!-- Uncomment when content added
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">On Campus Preparation</li>


                <li>
                    <a href="option">Resume Review</a>
                </li>


                <li>
                    <a href="option2.html">Planning Your Career Fair</a>
                </li>


                <li>
                    <a href="option3.html">How To Act Proffesional</a>
                </li>
            </ul>
			-->

            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">How To's and Tutorials</li>
				
				<li>
                    <a href="#questions">REWRITE ME Recruiter Questions</a>
                </li>

                <li>
                    <a href="#dress">REWRITE ME Dress for Success</a>
                </li>


                <li>
                    <a href="#standOut">REWRITE ME Standing Out</a>
                </li>


                <li>
                    <a href="#speech">REWRITE ME Making Your Speech Count</a>
                </li>
				
				<li>
                    <a href="#badGrades">REWRITE ME Bad Grades?</a>
                </li>
            </ul>
        </div>


        <div data-position="fixed" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="dress">
        <div data-role="header" data-position="fixed">
            <h1>How to Dress</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Home</a> <a data-icon="search"
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
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>

	
	<div data-role="page" data-theme="a" id="standOut">
        <div data-role="header" data-position="fixed">
            <h1>Standing Out</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a> <a data-icon="search"
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


        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	
	<div data-role="page" data-theme="a" id="speech">
        <div data-role="header" data-position="fixed">
            <h1>Practice your speech</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
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


        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="questions">
        <div data-role="header" data-position="fixed">
            <h1>Common Recruiter Questions</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
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


        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="badGrades">
        <div data-role="header" data-position="fixed">
            <h1>Dealing with Bad Grades</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
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


        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	

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
			<?php echo"<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"></script>
<script type=\"IN/JYMBII\" data-format=\"inline\"></script>" ?>

			<ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li>
                    <a href="#">Add a Resume</a>
                </li>


                <li>
                    <a id="hireMizzou">Hire Mizzou Tigers</a>
                </li>

            </ul>
        </div>
    </div>
</body>
</html>