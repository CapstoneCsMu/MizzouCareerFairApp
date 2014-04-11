<html>
<title>Company Data</title>

<?php

include ("data.php");

//get rss info from database
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
$query = 'SELECT * FROM careerSchema.rssinfo ORDER BY entryTime DESC LIMIT 1';
$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);

$link = $line['rss'];
$name = $line['name'];

//load rss feed
$xml=simplexml_load_file($link);
//get number of items in feed
$length = sizeof($xml->channel->item);

//get content of each item
for($i = 0; $i<$length; $i++){
	$content  = $xml->channel->item[$i]->children("http://purl.org/rss/1.0/modules/content/");
	$companyData = $content->encoded;
	
	$dom = new DOMDocument();
	$table = $dom->loadHTML($companyData);
	$dom->preserveWhiteSpace = false;
	$tables = $dom->getElementsByTagName('table');
	$rows = $tables->item(0)->getElementsByTagName('tr');
	
	
	foreach($rows as $row){
		$cols = $row->getElementsByTagName('td');
		if($cols->item(0)->nodeValue == $name){
			$companyNames[$i] = $cols->item(1)->nodeValue;
			}
		}
	
}

/*for($i=0; $i<sizeof($companyNames); $i++){

	echo $companyNames[$i]."<br>";
}
*/

?>
</html>