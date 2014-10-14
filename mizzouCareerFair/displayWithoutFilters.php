 <?php

//If RSS Feed is down
if (!$line['rss'])
{
	echo 'The RSS Feed is broken right now, Sorry about that...';
}
else
{
	//sort names alphabetically and print them as list options
	asort($companyNames);
	$_SESSION['companies'] = $companyNames;
	$i = 1;
	foreach($companyNames as $companyName => $val)
	{
		echo '<li><a data-transition="slide" href="#company'.$i.'">'.$val.'</a></li>';
		$i++;
	}
}
?>