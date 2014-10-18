<?php
	/*
	File: companyLoad.php
	Parent: Index.php (approx. line 190)
	Purpose: This file acts as multiple standalone pages. Each company gets a single page which is dynamically created.
	*/
	$i=1;
	foreach($companyNames as $keyZ => $val)
	{

		echo '
			<div data-role="page" data-theme="a" id="company'.$i.'">
				<div data-role="header" data-position="fixed">
					<h1>'.$val.'</h1>
					<a data-transition="slide" data-direction="reverse" data-icon="arrow-l" data-iconpos="notext" href="#companies">Back</a> 
					<a data-transition="slide" data-direction="reverse" data-icon="home" data-iconpos="notext" href="#home">Home</a> 
				</div>
				';

				//Display the correct Data for this Company [ALL of it]
				echo '</br><center><div><table>';
				for($j=0; $j < count($companyDataKey[0]); $j++)
				{
					if ($companyDataValue[$keyZ][$j] == NULL)
					{
						continue;
					}
					if ($companyDataKey[$keyZ][$j] == "Event Id:" || $companyDataKey[$keyZ][$j] == "Career Event Name:" || 
					$companyDataKey[$keyZ][$j] == "Registration ID:" || $companyDataKey[$keyZ][$j] == "Registration Date:") 
					{
						continue;
					}
					if ($companyDataKey[$keyZ][$j] == "Website:")
					{
						if ($companyDataValue[$keyZ][$j][0] != 'h') //Some of the links were messing up so I had to make sure they were leaving our domain
						{
							print "<tr><td valign='top' align='left'><b>".$companyDataKey[$keyZ][$j]."</b></td><td valign='top'><a target='_blank' href='http://".$companyDataValue[$keyZ][$j]."'>".$companyDataValue[$keyZ][$j]."</td>";
							print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
							continue;						
						}
						else
						{
							print "<tr><td valign='top' align='left'><b>".$companyDataKey[$keyZ][$j]."</b></td><td valign='top'><a target='_blank' href='".$companyDataValue[$keyZ][$j]."'>".$companyDataValue[$keyZ][$j]."</td>";
							print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
							continue;
						}
					}
				   
					if ($companyDataKey[$keyZ][$j] == "Majors (click Add):")
					{
						print "<tr><td valign='top' align='left'><b>Majors: </b></td><td valign='top'>".$companyDataValue[$keyZ][$j]."</td>";
						print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
						continue;
					}
					
					else
					{
						print "<tr><td valign='top' align='left'><b>".$companyDataKey[$keyZ][$j]."</b></td><td valign='top'>".$companyDataValue[$keyZ][$j]."</td>";
						print "</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
					}
				}
				echo '</table></div></center>';
				echo '</br>';
				
				//Does the company have a linked In?
				//echo "<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"></script><script type=\"IN/CompanyProfile\" data-id=\"1009\" data-format=\"inline\"></script>" ;
				
		echo '</div>';
			$i++;
	}
?>