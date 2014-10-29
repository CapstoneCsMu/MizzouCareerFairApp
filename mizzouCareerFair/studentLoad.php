<?php
	/*
	File: studentLoad.php
	Parent: employerView.php (approx. line 242)
	Purpose: Generates pages for employer view students
	*/
	$i=1;
	foreach($studentEmails as $keyZ => $val)
	{

		echo '
			<div data-role="page" data-theme="a" id="student'.$i.'">
				<div data-role="header" data-position="fixed">
					<h1>'.$val.'</h1>
					<a data-transition="slide" data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="#companies">Back</a> 
					<a data-transition="slide" data-direction="reverse" data-icon="home" data-iconpos="notext" href="#home">Home</a> 
				</div>
				';

		// select* from studnts where email= ;
		

	}
?>