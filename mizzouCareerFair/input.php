
<?php
/*
File: input.php
Parent: adminCompanies.php
Purpose:This inputs the rss information into the database. 
*/
include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

// This is the URL of the rss feed
$rssLink = $_POST['rssLink'];

// The field that holds company name
$name = $_POST['nameField'];

$city = $_POST['cityField'];

$state = $_POST['stateField'];
// This is the desired majors field
$majors = $_POST['majorsField'];

// This is the position type field
$positionType = $_POST['positionTypeField'];

$website = $_POST['websiteField'];

$citizenship = $_POST['citizenshipField'];

$status = $_POST['statusField'];

$eventName = $_POST['event'];




// Save the RSS URL and the field for the company name to DB
$query = 'INSERT INTO careerSchema.rssinfo (rss, companyName, positionTypes, majors, city, states, website, citizenship, fairName) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)';
$statement = pg_prepare("myQuery", $query) or die (pg_last_error());
$result = pg_execute("myQuery", array($rssLink, $name, $positionType, $majors, $city, $state, $website, $citizenship, $eventName)) or die(pg_last_error());

header('Location: admin.php');


?>