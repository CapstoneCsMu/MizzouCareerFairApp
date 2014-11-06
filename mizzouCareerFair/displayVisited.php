<?php
/*
File: displayVisited.php
Parent: index.php (approx. line 163)
Purpose: To display companies students had visited.
*/

echo '<div class="ui-bar ui-bar-a">';
if ($_SESSION['student_loggedin']){
	
		$stuEmail = $_SESSION['student_loggedin'];
		
		//select distinct on company 
		$query1 = "SELECT DISTINCT ON(company) * FROM careerSchema.employerScannedStudents WHERE email = '$stuEmail'";
		$result = pg_query($query1) or die("Query failed: " . pg_last_error());
		
		$num_rows = pg_num_rows($result);
		if ($num_rows > 0){
			echo '<div data-role="content">
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
			<li data-role="list-divider">Companies You Visited</li>';
			
			$i=0;
			while ($line = pg_fetch_assoc($result)) {
				echo '<li><a href="index.php#company'.$i.'">'.$line['company'].'</a></li>';
				$company = $line['company'];
				$i++;
			}
			
			echo '</ul>';
			echo '</div>';
			
			/*for ($j=0; $j<$i; $j++){
				echo '<div data-role="page" data-theme="a" id="company'.$j.'">
				<div data-role="header" data-position="fixed">
				<h1>'.$company.'</h1>
				<a data-direction="reverse" data-icon="arrow-l" data-iconpos="notext"
				data-transition="flip" href="index.php#companies">Home</a> <a data-icon="search"
				data-iconpos="notext" data-rel="dialog" data-transition="fade"
				href="../nav.html">Search</a>
				</div></div>';
			}*/
		}
		else{
			echo '<center><p><b>You have not visited any companies yet. </br>When a company scans your QR Code,  they will appear here.</b></p></center>';
		}	
		
}
echo'</div>
</div>';
?>