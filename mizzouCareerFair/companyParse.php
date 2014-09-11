<html>
<title>Company Data</title>

<?php
//Include Database information
include ("data.php");

//get rss info from database
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
$query = 'SELECT * FROM careerSchema.rssinfo ORDER BY entryTime DESC LIMIT 1';
$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);

// RSS URL
$link = $line['rss'];

// Location of 
$name = $line['name'];

//load rss feed
$xml=simplexml_load_file($link);

//get number of items in feed
$length = sizeof($xml->channel->item);

//Read the XML File Company by Company
for($i = 0; $i<$length; $i++){
	$content  = $xml->channel->item[$i]->children("http://purl.org/rss/1.0/modules/content/");
	$companyData = $content->encoded;
	
	$dom = new DOMDocument();
	$table = $dom->loadHTML($companyData);
	$dom->preserveWhiteSpace = false;
	$tables = $dom->getElementsByTagName('table');
	$rows= $tables->item(0)->getElementsByTagName('tr');

	$j = 0;
	//Look at this company's cluster of Data
	foreach($rows as $row)
	{
		$cols = $row->getElementsByTagName('td');
		// FYI: item(0) holds the type of data while item(1) holds the value
		if($cols->item(0)->nodeValue == $name){
			$companyNames[$i] = $cols->item(1)->nodeValue;
			}

		//Store this Company's data in a 2-dimensional array. The first dimension holds the company's index, while the second dimension holds all of it's bits of data such as name, city, state, etc.
		$companyDataKey[$i][$j] = $cols->item(0)->nodeValue;
		$companyDataValue[$i][$j] = $cols->item(1)->nodeValue;
		$j++;
	}
	// Used for Looking up Company's rank after the names are sorted alphabetically so we can grab the rest of the company's data
	$companeeNames = $companyNames;
}
?>
</html>