
<?php
/*
File: input.php
Parent: adminCompanies.php
Purpose:This inputs the rss information into the database. 
*/
include ("data.php");
include("rssFunctions.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

// This is the URL of the rss feed
if($_POST['function'] == "add") {
    $rssLink = $_POST['rssLink'];

    $name = $_POST['nameField'];

    $city = $_POST['cityField'];

    $state = $_POST['stateField'];

    $majors = $_POST['majorsField'];

    $positionType = $_POST['positionTypeField'];

    $website = $_POST['websiteField'];

    $citizenship = $_POST['citizenshipField'];

    $status = $_POST['statusField'];

    $eventName = $_POST['event'];

    $function = $_POST['function'];

    addRss($rssLink, $name, $positionType, $majors, $city, $state, $website, $citizenship, $eventName);

}

else if($_POST['function'] == "remove"){
    $fairName = $_POST['eventName'];
    removeRss($fairName);
}

header('Location: admin.php');
?>