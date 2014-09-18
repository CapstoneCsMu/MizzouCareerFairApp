<?php
	if (!isset($_SESSION))
	{
		session_start();
	}
	$_SESSION['prevPage'] = 'index.php';
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

			function submitFilter()
			{
				document.getElementById("filterForm").submit();
				window.alert("You're Settings have been saved.");
			}

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
<!--JavaScript SDK for facebook login button-->
    <div id="fb-root"></div>
	<script>(function(d, s, id) {
  		var js, fjs = d.getElementsByTagName(s)[0];
  		if (d.getElementById(id)) return;
  		js = d.createElement(s); js.id = id;
  		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=825175967511735&version=v2.0";
  		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

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
                    <a data-transition="flip" href="#companyTest">Test Company/API's this is Static</a>
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
                    <a data-transition="flip" href="#preparation">Preparation</a>
                </li>	
				
                <li>
                    <a data-transition="flip" href="#events">Events</a>
                </li>

                <li>
                    <a data-transition="flip" href="fairSelection.php">Fairs</a>
                </li>
				<li>
                    <a data-transition="flip" href="#aboutECS">Engineering Career Services</a>
                </li>

		<li>
		    <a data-transition="flip" href="support.php">Support</a>
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

	    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
            
        </div>

    </div>
	
    <!-- This page should have a list of all of the companies in the RSS feed 
    
    	 The data in RSS must made useful and unique so we know what companies we are using
    -->

  <div data-role="page" data-theme="a" id="companies">
        <div data-role="header" data-position="fixed">
            <h1>Companies</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext" href="#home">Home</a> 
			<a data-transition="slide" data-icon="bullets" href="companyFilter.php">Filters</a>
        </div>
	
		<form class="ui-filterable">
      		<input id="companyFilter" data-type="search">
    	</form>
		
		
			<div data-role="tabs">
				<div data-role="navbar">
					<ul>
						<li><a href="#companies-1">All</a></li>
						<li><a href="#filtered">Filtered</a></li>
						<li><a href="#following">Following</a></li>
					</ul>
				</div>

			<!-- List all of the companies, each company can be accessed as an individual page via companyLoad.php down below-->
			<div id="companies-1">
			<ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#UNFILTERED" data-autodividers="true">
			 <?php
			//Parse the XML File
			include 'companyParse.php';
			
			//If RSS Feed is down
			if (!$line['rss'])
			{
				echo 'The RSS Feed is broken right now, Sorry about that...';
			}
			else
			{
				//sort names alphabetically and print them as list options
				asort($companyNames);
				$i = 1;
				foreach($companyNames as $companyName => $val)
				{
					echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val.'</a></li>';
					$i++;
				}
			}
            ?>
			</ul>
			</div>
			<div id="filtered">
				<ul data-dividertheme="b" data-inset="true" data-role="listview" data-filter="true" data-input="#FILTERED" data-autodividers="true">
					<?php
					//Parse the XML File
					include 'companyParse.php';
					$succesfulFilterCount = 0;
					$filters = NULL;
					// build $filters Array 
					// NOTE: The value 10 is Static because we will need to possibly implement a dynamic way to load Filter Options
					$x=0;
					for ($y=0; $y <  10; $y++)
					{
						if($_SESSION['filters']['filter_'.$y] ==NULL)
							continue;
						else
						{
							$filters[$x] = $_SESSION['filters']['filter_'.$y];
							$x++;
						}
					}

					if($filters != NULL)
					{
						//If RSS Feed is down
						if (!$line['rss'])
						{
							echo 'The RSS Feed is broken right now, Sorry about that...';
						}
						else
						{
							//Display Filters:
							echo "</br><center><b>Filters: </b>";
							for($m=1; $m <= count($filters); $m++)
							{
								echo $filters[$m-1];
								if ($m != count($filters))
									echo ' & ';
							}
							echo "</center></br>";
							//sort names alphabetically and print them as list options
							//asort RETAINS the previous key, pretty weird, but it helps increase the efficiency.
							asort($companyNames);
							$i = 0;
							foreach($companyNames as $key => $val)
							{
								$i++;
								// Step 1. Exclude companies that didn't list a major
								if ( $company[$i]->Majors == NULL)
									continue;
								else
								{
									// Step 2. Look for Computer Science within this company's majors given
									for ($j=0; $j < count($companyMajor[$i]); $j++)
									{
										for($k=0; $k < count($filters); $k++)
										{
											//echo $company[$i]->MajorArray[$j];
											if ($filters[$k] == $companyMajor[$i][$j])
											{
												echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val.'</a></li>';
												$succesfulFilterCount++;
											}
											else //Skip Listing of this Company
												continue;
										}
									}
								}
							}
						}
						if ($succesfulFilterCount == 0)
							echo "</br><center>Sorry, You're Filters Did Not Return Any Results. Please Try Editing Your Filters.</center>";
						
					}
					else
					{
						echo "</br><center><b>No Filters have been set. Add them Above.</b></center>";
					}
					?>
				</ul>
			</div>
			
			<div id="following">
				<center><p><b>You haven't followed any companies yet.</b></p></center>
			</div>
		</div>
    </div>

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
    </div>

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
	
	<!--Start about ECS HTML-->
	<div data-role="page" data-theme="a" id="aboutECS">
        <div data-role="header" data-position="fixed">
            <h1>About Us</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
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
	<!--End about ECS HTML-->
	
	<!--Start preparation HTML-->
	<div data-role="page" data-theme="a" id="preparation">
        <div data-role="header" data-position="fixed">
            <h1>Career Fair Events</h1>
            <a data-direction="reverse" data-icon="home" data-iconpos="notext"
            data-transition="flip" href="#home">Home</a> <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

        <div data-role="content">
            <ul data-dividertheme="b" data-inset="true" data-role="listview">
                <li data-role="list-divider">Keys to a successful career fair</li>
				
				<li>
                    <a href="#prepare">Preparation</a>
                </li>
				<li>
                    <a href="#resume">Resume</a>
                </li>
				<li>
                    <a href="#dress">Dress Code</a>
                </li>
				<li>
                    <a href="#confidence">Confidence</a>
                </li>
				<li>
                    <a href="#new'n">Placeholder</a>
                </li>
				<li>
                    <a href="#new'n">Placeholder</a>
                </li>
            </ul>
        </div>


        <div data-position="fixed" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="prepare">
        <div data-role="header" data-position="fixed">
            <h1>Preparation Steps</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Home</a> <a data-icon="search"
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
		
        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>	
	
	<div data-role="page" data-theme="a" id="resume">
        <div data-role="header" data-position="fixed">
            <h1>Rules of the Resume</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a> <a data-icon="search"
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


        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	
	<div data-role="page" data-theme="a" id="dress">
        <div data-role="header" data-position="fixed">
            <h1>Dress for Success</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
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

        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="confidence">
        <div data-role="header" data-position="fixed">
            <h1>Confidence</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
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

        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	
	<div data-role="page" data-theme="a" id="new'n'">
        <div data-role="header" data-position="fixed">
            <h1>Dealing with Bad Grades</h1>
            <a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
            data-transition="flip" href="#events">Back</a>  <a data-icon="search"
            data-iconpos="notext" data-rel="dialog" data-transition="fade"
            href="../nav.html">Search</a>
        </div>

		<div data-role="content">
			<h2>Generic title placeholder.</h2>

			
			<p>
			HTML is all done. We will add more content as it becomes available.
			</p>
			
			<ul>
				<li><span style="font-size:11.0pt">Bullet 1<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Bullet 2<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Bullet 3<o:p></o:p></span></li>
				<li><span style="font-size:11.0pt">Bullet 4<o:p></o:p></span></li>
			</ul>
			
			<p>
				Have a question? Send it to "engineering.careers@mail.missouri.edu" with the subject of "HELP!" and we will be glad to answer it and post it to the webpage!
			</p>
		</div>

        <div data-position="fixed" data-role="footer" data-role="footer">
            <input data-mini="true" id="basic" name="name" placeholder=
            "Search the Career Fair" type="text" value="">

            <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
        </div>
    </div>
	<!--End preparation HTML-->
	
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
