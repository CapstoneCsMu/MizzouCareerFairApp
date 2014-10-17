<?php
//Grab the correct fair's rss Feed (could be Engineering, or Business Career Fair, etc.)
if (isset($_POST['fairname']))
	$fairName = $_POST['fairname'];
else
	$fairName = "2014 Fall Engineering Career Fair";
				
//Include Database information
if($_SERVER['HTTP_HOST'] == 'localhost')
	include('data_ryanslocal.php');
else
	include ("data.php");

//get rss info from database
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

$query = "SELECT * FROM careerSchema.rssinfo WHERE fairname='".$fairName."'";

$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);

//load rss feed
$xml=simplexml_load_file($line['rss']);

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
	//Integer for two dimensional Array
	$j = 0;
	//Look at this company's cluster of Data
	foreach($rows as $row)
	{
		$cols = $row->getElementsByTagName('td');
		// FYI: item(0) holds the type of data while item(1) holds the value
		if($cols->item(0)->nodeValue == $line['companyname']){
			$companyNames[$i] = $cols->item(1)->nodeValue; //Needed for Sorting Algorithm
			$company[$i]->Name = $cols->item(1)->nodeValue;
			}
		if($cols->item(0)->nodeValue == $line['positiontypes']){
			$company[$i]->PositionTypes = $cols->item(1)->nodeValue;
			$companyPositions[$i] = explode(", ", $company[$i]->PositionTypes); //Needed for Filtering by Major : Explode parses the line and puts into 2-D Array
			}
		if($cols->item(0)->nodeValue == $line['majors']){
			$company[$i]->Majors = $cols->item(1)->nodeValue;
			$companyMajor[$i] = explode(", ", $company[$i]->Majors); //Needed for Filtering by Major : Explode parses the line and puts into 2-D Array
			}
		if($cols->item(0)->nodeValue == $line['city']){
			$company[$i]->City = $cols->item(1)->nodeValue;
			}
		if($cols->item(0)->nodeValue == $line['states']){
			$company[$i]->States = $cols->item(1)->nodeValue;
			$companyState[$i] = explode(", ", $company[$i]->States); 
			}
		if($cols->item(0)->nodeValue == $line['website']){
			$company[$i]->Website = $cols->item(1)->nodeValue;
			}
		if($cols->item(0)->nodeValue == $line['citizenship']){
			$company[$i]->Citizenship = $cols->item(1)->nodeValue;
			}
		if($cols->item(0)->nodeValue == $line['category']){
			$company[$i]->Category = $cols->item(1)->nodeValue;
			}
			
		//Store this Company's data in a 2-dimensional array. The first dimension holds the company's index, while the second dimension holds all of it's bits of data such as name, city, state, etc.
		$companyDataKey[$i][$j] = $cols->item(0)->nodeValue;
		$companyDataValue[$i][$j] = $cols->item(1)->nodeValue;
		$j++;
	}
}
?>