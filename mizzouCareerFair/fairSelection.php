<!--
File: fairSelection.php
Parent: index.php (approx line 129)
Purpose: This file is a standalone page which allows the user to select a career fair: Either Egr, or Business, or CAFNR, etc.
-->

<div class="panel left" data-role="panel" id="fairSelect" data-position="left" data-display="overlay">
		<ul data-dividertheme="b" data-inset="true" data-role="listview">
		<li data-role="list-divider">Select a Career Fair</li>
		<?php
			//Include Database information
			if($_SERVER['HTTP_HOST'] == 'localhost')
				include('data_ryanslocal.php');
			else
				include ("data.php");

			//get rss info from database
			$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
			$query = 'SELECT fairName FROM careerSchema.rssinfo ORDER BY fairName ASC';
			$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
			//counter
			$numOfFeeds=0;
			while ($fair = pg_fetch_array($result, null, PGSQL_ASSOC))
			{
				echo '<li><a style="text-overflow: ellipsis; overflow: visible; white-space: normal" href="index.php" onclick="submitForm_'.$numOfFeeds.'()">'.$fair['fairname'].'</a></li>';
				// echo '<li id="form_'.$numOfFeeds.'"><a data-transition="slidedown" href="">'.$fair['fairname'].'</a></li>';
				$fairForm[$numOfFeeds] = $fair['fairname'];
				
			
				//Javascript to input the info and then submit the User-Specified form
				echo'<script type="text/javascript">
							function submitForm_'.$numOfFeeds.'(){
								document.getElementById("myForm'.$numOfFeeds.'").submit();
							}
							</script>';

				/*
				// jQuery to submit the form without having to submit to index.php and refreshing the page
				echo "<script type='text/javascript'>
					$(document).ready(function(){
						$(document).on('click', '#form_".$numOfFeeds."', function(){
							$.post('fairSelect.php',
							{
								fair: \"".$fair['fairname']."\"
							},
							function(fair){
								alert('You chose: ' + fair);
							});
						});
					});
					</script>";
				*/
				$numOfFeeds++;
			}

			//Dynamically creates a form for each RSS Feed, so that the right form can be submitted by the user.
			for ($j=0; $j<$numOfFeeds; $j++)
			{
				echo '<form id="myForm'.$j.'" method="post" action="index.php">';
				echo '<input type="hidden" name="fairname" value="'.$fairForm[$j].'">';
				echo '</form>';
			}
			
		?>
	</div>
