<?php
include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

$name = $_POST['nameField'];
$rsslink = $_POST['rssLink'];

$query = 'INSERT INTO careerSchema.rssinfo (rss, name) VALUES ($1, $2)';
$statement = pg_prepare("myQuery", $query) or die (pg_last_error());
$result = pg_execute("myQuery", array($rsslink, $name)) or die(pg_last_error());

echo "SUCCESS";

?>