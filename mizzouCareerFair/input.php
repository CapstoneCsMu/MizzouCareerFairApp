<?php
include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

// The field that holds company name
$name = $_POST['nameField'];

// This is the URL of the rss feed
$rsslink = $_POST['rssLink'];

// This is the field of available positions
$positions = $_POST['positionsField'];

// This is the field of the company address
$address = $_POST['addressField'];

// This is the desired majors field
$majors = $_POST['majorsField'];

// This is the position type field
$positionType = $_POST['positionTypeField'];




// Save the RSS URL and the field for the company name to DB
$query = 'INSERT INTO careerSchema.rssinfo (rss, name) VALUES ($1, $2)';
$statement = pg_prepare("myQuery", $query) or die (pg_last_error());
$result = pg_execute("myQuery", array($rsslink, $name)) or die(pg_last_error());

echo "SUCCESS";

?>