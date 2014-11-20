<?php
/*
File: displayWithFilters.php
Parent: index.php (approx. line 163)
Purpose: To filter the company list with the user's chosen filters.
*/
$succesfulFilterCount = 0;
$Majorfilters = NULL;
// build $Majorfilters Array 
// NOTE: The value 8 is Static because we will need to possibly implement a dynamic way to load Filter Options
$x=0;
for ($y=0; $y <  8; $y++)
{
	if($_SESSION['filters']['filter_'.$y] ==NULL)
		continue;
	else
	{
		$Majorfilters[$x] = $_SESSION['filters']['filter_'.$y];
		$x++;
	}
}

if($Majorfilters != NULL)
{
	//If RSS Feed is down
	if (!$line['rss'])
	{
		echo 'The RSS Feed is broken right now, Sorry about that...';
	}
	else
	{
		//Display Filters:
		echo "</br><center><b>Selected Filters: </b>";
		for($m=1; $m <= count($Majorfilters); $m++)
		{
			echo $Majorfilters[$m-1];
			if ($m != count($Majorfilters))
				echo ', ';
		}
		if (isset($_SESSION['filters']['group_state']))
			echo ", ".$_SESSION['filters']['group_state'];
		if (isset($_SESSION['filters']['group_type']))
			echo ", ".$_SESSION['filters']['group_type'];
		echo "</center></br>";
		//sort names alphabetically and print them as list options
		//asort RETAINS the previous key, it helps increase the efficiency.
		// asort($companyNames);
		$i = 0;
		foreach($companyNames as $key => $val)
		{
			$i++;
			// Step 1. Exclusions
			//Exclude if User's selected state does not equal the state of the company
			if (  isset($_SESSION['filters']['group_state']) )
			{
				if ($_SESSION['filters']['group_state'] != $company[$key]->States)
					continue;
			}
			//Exclude if User's selected type does not match the categories offered by the company
			$positionFlag = FALSE;
			if (  isset($_SESSION['filters']['group_type']) )
			{
				for ($z = 0; $z < count($companyPositions[$key]); $z++)
				{
					if ($_SESSION['filters']['group_type'] == $companyPositions[$key][$z])
						$positionFlag = TRUE;
				}
				if (!$positionFlag)
					continue;
			}
			// Exclude companies that didn't list a major
			if ( $company[$key]->Majors == NULL )
				continue;

			// Exclude company if User's Major filters aren't listed in the company's majors
			$majorFlag = FALSE;
			for ($j=0; $j < count($companyMajor[$key]); $j++)
			{
				for($k=0; $k < count($Majorfilters); $k++)
				{
					if ($Majorfilters[$k] == $companyMajor[$key][$j] )
					{
						$majorFlag = TRUE;
					}
				}
			}
			if (!$majorFlag)
				continue;
				
			// Step 2. If it's made it this far then print out the company name
			echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val."   (".$company[$key]->City.')</a></li>';
			$succesfulFilterCount++;
		}
	}
	if ($succesfulFilterCount == 0)
	{
		echo '</br><div class="ui-bar ui-bar-a">';
		echo "</br><center><b>Sorry, you're filters did not return any results. They may be too strict. Try editing them.</b></center>";
		echo '</div>';
	}
	
}
else
{
	echo '</br><div class="ui-bar ui-bar-a">';
	echo "<center><b>No Filters have been set. Add them Above.</b></center>";
	echo '</div>';
}
?>