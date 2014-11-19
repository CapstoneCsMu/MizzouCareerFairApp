<?
//Include Database information
/*if($_SERVER['HTTP_HOST'] == 'localhost')
         include('data_ryanslocal.php');
 else
         include ("data.php");
*/
include("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
if (!$conn)
{
echo "\n<div class='container'>\n\t<div class ='alert alert-danger'>";
        echo "<center>An Error occurred during connection.</center>";
        echo "\n\t</div>\n</div>";
exit();
}

 if(isset($_POST['submitFeedPost'])) {

    //Include Database information
    /*if($_SERVER['HTTP_HOST'] == 'localhost')
             include('data_ryanslocal.php');
     else
             include ("data.php");
   */

    $employerEmail = $_SESSION['employer_loggedin'];


    //$query = "SELECT company FROM careerschema.authorizationTable WHERE email = $_SESSION['employer_loggedin']";
    //echo $query;
    //check for file type
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    //get filename and set path
    $fileName =  $_FILES["file"]["name"];
    $path = "images/Posts/".$_FILES["file"]["name"];

    //check for errors and correct file type
    if($_FILES["file"]["error"] != 0)
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    else if (!in_array($extension, $allowedExts))
        echo"<script>alert(\"Invalid File\")</script>";

    else{
        //save file and insert path into database
        move_uploaded_file($_FILES["file"]["tmp_name"], $path);

        $query = "INSERT INTO careerSchema.newsFeed(email, imageName, textPost, imgFilePath, company, title) VALUES ($1, $2, $3, $4, $5, $6)";
        $statement = pg_prepare("myQuery", $query) or die (pg_last_error());
        $result = pg_execute("myQuery", array($_SESSION['email'], $fileName, $_POST['post'], $path, $_SESSION['company'], $_POST['title'])) or die(pg_last_error());
        header("Location: employerView.php");
    }

}?>
