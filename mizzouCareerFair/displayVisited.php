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
			
			$j=0;
			while ($line = pg_fetch_assoc($result)) {
				asort($companyNames);
				$_SESSION['companies'] = $companyNames;
				$i = 1;
				foreach($companyNames as $companyName => $val)
				{
					if ($val == $line['company']){
	
						echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val.'</a></li>';
				
					}
					$i++;
				}
				$j++;			
			}	
			echo '</ul>';
			echo '</div>';		
			
		}
		else{
			echo '<center><p><b>You have not visited any companies yet. </br>When a company scans your QR Code,  they will appear here.</b></p></center>';
		}	
		
}
echo'</div>
</div>';
?>