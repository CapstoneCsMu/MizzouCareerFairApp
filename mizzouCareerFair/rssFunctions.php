<?php
include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());


// Save the RSS URL fields to DB
function addRss($rssLink, $name, $positionType, $majors, $city, $state, $website, $citizenship, $eventName){
    $query = 'INSERT INTO careerSchema.rssinfo (rss, companyName, positionTypes, majors, city, states, website, citizenship, fairName) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)';
    $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
    $result = pg_execute("myQuery", array($rssLink, $name, $positionType, $majors, $city, $state, $website, $citizenship, $eventName)) or die(pg_last_error());
}

function removeRss($fairName){
    $query = "DELETE FROM careerSchema.rssinfo WHERE rssinfo.fairname = $1";
    $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
    $result = pg_execute("myQuery", array($fairName)) or die(pg_last_error());
}

function authorization(){
    session_start();
    if(!$_SESSION['admin_loggedin']){
        $_SESSION['admin_attempt'] = "yes";
        header('Location: login.php');
    }
}

?>