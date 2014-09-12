<?php
	$i=1;
	foreach($companyNames as $companyName => $val)
	{
		echo '
			<div data-role="page" data-theme="a" id="company'.$i.'">
				<div data-role="header" data-position="fixed">
					<h1>'.$val.'</h1>
					<a data-transition="slide" data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="#companies">Back</a> 
					<a data-transition="slide" data-direction="reverse" data-icon="home" data-iconpos="notext" href="#home">Home</a> 
				</div>
				';
				
				//Find this company's Data
				$indexOfCompany = 0;
				foreach($companeeNames as $key => $value)
				{
					if($val == $value)
					{
						$indexOfCompany = $key;
					}
				}

				//Display the correct Data for this Company
				echo '<center><table>';
				for($j=0; $j < count($companyDataKey[0]); $j++)
				{
					print "<tr>";
					echo "<td valign='top'><b>".$companyDataKey[$indexOfCompany][$j]."</b></td><td valign='top'>".$companyDataValue[$indexOfCompany][$j]."</td>";
					print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
				}
				echo '</table></center>';
				
		echo'
			</div>
				';
			$i++;
	}
?>