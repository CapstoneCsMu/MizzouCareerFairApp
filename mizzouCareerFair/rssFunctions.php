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

function handleNewAdmin()
{
    //print_r($_POST);
    //exit();
    if($_SERVER['HTTP_HOST'] == 'localhost')
        include('data_ryanslocal.php');
    else
        include ("data.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
    if (!$conn)
    {
        echo "\n<div class='container'>\n\t<div class ='alert alert-danger'>";
        echo "<center>An Error occurred during connection.</center>";
        echo "\n\t</div>\n</div>";
        exit();
    }
    mt_srand(); //Seed number generator
    $salt = mt_rand(); //generate salt
    $salt = sha1($salt);
    $salt = trim($salt);
    $pass = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $passHashed = sha1($salt.$pass);
    for ($i=0; $i<10000; $i++) //Slow Hashing
    {
        $passHashed = sha1($passHashed);
    }
    $query = "INSERT INTO careerschema.authorizationtable (email, firstname, lastname, hashed_pass, salt, user_type) VALUES ($1,$2,$3,$4,$5,$6)";
    $state = pg_prepare($conn,"insert_1",$query) ;
    $queryInsert = pg_execute($conn,"insert_1",array($email, $_POST['firstName'], $_POST['lastName'], $passHashed, $salt,"admin") )  ;
    if ($queryInsert)
    {
        //Kristi:  change to the appropiate action if the admin is inserted successfully
        header("Location: admin.php");//change this line
        exit();
    }
    else{
        //Kristi:  change to the appropiate action if the admin is not inserted
        header("Location: admin.php#failure");//change this line
        exit();
    }
}

function deleteAdmin($email)
{
    if($_SERVER['HTTP_HOST'] == 'localhost')
        include('data_ryanslocal.php');
    else
        include ("data.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
    if (!$conn)
    {
        echo "\n<div class='container'>\n\t<div class ='alert alert-danger'>";
        echo "<center>An Error occurred during connection.</center>";
        echo "\n\t</div>\n</div>";
        exit();
    }
    $query = "DELETE FROM careerschema.authorizationtable WHERE authorizationtable.email = $1"; 
    $state = pg_prepare($conn, "delete_0", $query) or die("Could not prepare query." . pg_last_error($conn));
    $result = pg_execute($conn, "delete_0", array($email)) or die("Could not execute query." . pg_last_error($conn));
    if ($result)
    {
	header("Location: adminUsers.php#deleteSuccess");
        exit();

    }
    else    
    {
	header("Location: adminUsers.php#deleteFailure");
	exit();
    }
}


function changePass ($currPassword, $newPassword, $confPassword)
{
    if ($_SERVER['HTTP_HOST'] == 'localhost')
        include('data_ryanslocal.php');
    else
        include("data.php");
    $conn = pg_connect(HOST . " " . DBNAME . " " . USERNAME . " " . PASSWORD) or die('Could not connect:' . pg_last_error());
    if (!$conn) {
        echo "\n<div class='container'>\n\t<div class ='alert alert-danger'>";
        echo "<center>An Error occurred during connection.</center>";
        echo "\n\t</div>\n</div>";
        exit();
    }
    $user = $_SESSION['admin_loggedin'];
    $currentPassword = htmlspecialchars($currPassword);

    $query = "SELECT * FROM careerschema.authorizationTable WHERE email=$1";
    $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
    $result = pg_execute("myQuery", array($user)) or die(pg_last_error());
    $row = pg_fetch_assoc($result);

    $salt = $row['salt'];
    $salty = sha1($salt);
    $salty = trim($salt);


    $localHash = sha1($salty . $currentPassword);
    for ($i=0; $i<10000; $i++) //Slow Hashing
    {
        $localHash = sha1($localHash);
    }

    if ($localHash == $row['hashed_pass'] ){
        if($newPassword == $confPassword ){
            if(strlen($newPassword) >= 5) {
                mt_srand(); //Seed number generator
                $salt = mt_rand(); //generate salt
                $salt = sha1($salt);
                $salt = trim($salt);
                $pass = htmlspecialchars($confPassword);
                $passHashed = sha1($salt . $pass);
                for ($i = 0; $i < 10000; $i++) //Slow Hashing
                {
                    $passHashed = sha1($passHashed);
                }
                $query = "UPDATE careerschema.authorizationtable SET hashed_pass = $1, salt = $2 WHERE email = $3";
                $state = pg_prepare($conn, "update_1", $query) or die (pg_last_error());
                $queryInsert = pg_execute($conn, "update_1", array($passHashed, $salt, $user)) or die (pg_last_error());
                if ($queryInsert) {
                    header("Location: admin.php");
                    exit();
                }
            }
            else
                echo"<script>alert(\"Password is too short\")</script>";
        }
        else
            echo"<script>alert(\"Confirmed Password doesn't match\")</script>";

    }
    else
        echo"<script>alert(\"Incorrect current password\")</script>";
}

?>
