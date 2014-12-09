<!DOCTYPE html>
<html>
<head>
    <title>Mizzou Career Fairs
    </title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <!-- Include CSS and JQM CSS -->
    <link href="css/themes/MizzouCareerFair.css" rel="stylesheet">
    <link href="css/themes/jquery.mobile.icons.min.css" rel="stylesheet">

    <link href="jquery.mobile-1.4.4/jquery.mobile.structure-1.4.4.min.css" rel="stylesheet">

    <link rel="stylesheet" media="screen and (min-device-width: 800px)" href="css/themes/screensize.css"/>

    <!-- Include jQuery and jQuery Mobile CDN, add actual files -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="jquery.mobile-1.4.4/jquery.mobile-1.4.4.min.js"></script>
    <!-- Include JS file for our JS -->
    <script src="js/index.js"></script>

    <!-- Include LinkedIn Framework, API Key Unique to Us -->
    <?php if($_SERVER['HTTP_HOST'] == 'localhost'): ?>
        <script type="text/javascript" src="https://platform.linkedin.com/in.js">
            api_key: 750nr1ytn6d9bz
            onLoad: onLinkedInLoad
            authorize: true
        </script>
    <?php else: ?>
        <script type="text/javascript" src="https://platform.linkedin.com/in.js">
            api_key: 75a6k7ahbjlrny
            onLoad: onLinkedInLoad
            authorize: true
        </script>
    <?php endif; ?>
    <!-- Include Google Maps API -->
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3&sensor=false&language=en"></script>

    <script type="text/javascript" src="index.js"></script>

</head>
<?php
include ("data.php");
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

//$company = "SELECT company FROM careerSchema.newsFeed";
$query = "SELECT * FROM careerSchema.newsFeed ORDER BY entryDate DESC";
$result =  pg_query($query) or die('Query failed: ' . pg_last_error());
$line = pg_fetch_array($result, null, PGSQL_ASSOC);
//$query2 = "SELECT textPost FROM careerSchema.newsFeed";
//$result2 =  pg_query($query2) or die('Query failed: ' . pg_last_error());
//$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
//	$postText = $line["textPost"];
//        $filePath = $line["imgFilePath"];
echo "<br /><br />";
printResults($result);
//	$query2 = "SELECT textPost FROM careerSchema.newsFeed";
//	$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());
//	$line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
?>

<div data-role="header" data-position="fixed">
    <h1>Mizzou Career Fairs News Feed</h1>
    <a data-direction="reverse" data-icon="home" data-iconpos="notext"
       data-transition="flip" href="index.php">Home</a> <a data-icon="search"
                                                           data-iconpos="notext" data-rel="dialog" data-transition="fade"
                                                           href="../nav.html">Search</a>
</div>

<div data-role="footer" data-position="fixed">
    <h4>&copy; 2014 Team X Mizzou Career Fair App</h4>
</div>


<?php
function printResults($result)
{
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
        echo "<div class=newsFeed>";
        // echo "<ul data-dividertheme='b' data-inset='true' data-role='listview'>";
        //echo "<ul data-inset='true' data-role='listview'>";
        //echo "<p data-role='list-divider' style='background-color:#C2C6C6;border-radius:4px;padding:7px;'>$columnData --  Posted by: </p><p style='background-color:#ffcc33;border-radius:4px;padding:7px;height:auto;font-weight:normal;' data-role='list-divider'>$colData</p><br /><br />";
        echo "<div style='background-color:#ffcc33;padding:5px;border-radius:5px 5px 0px 0px;font-weight:bold'>".$line['title']."</div>
        <div style='background-color:#dddddd;padding:5px 0px 10px 10px;border-radius:0px 0px 5px 5px;font-weight:normal'>".$line['textpost']."</div>"
        ;
        //echo "<li data-role='list-divider'>$columnData --  Posted by: </li><li style='background-color:#ffcc33;height:auto;font-weight:normal;'>$colData</li><br /><br />";
        echo "</div>";
        echo" <div data-role='content'><img alt='imagePost' src=\"".$line['imgfilepath']."\"style='width:100%'></div><br /><br />";


    }

    //echo "<table border='1'><br/>\n";

    /*//echo "<tr>\n";
    $numrows = pg_num_fields($result);
    $numrows = pg_num_fields($result2);

    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC))
    {
        foreach ($line as $columnData)
        {
            $line2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
            {
                foreach ($line2 as $colData)
                {
                    echo "<div class=newsFeed>";
                    // echo "<ul data-dividertheme='b' data-inset='true' data-role='listview'>";
                    //echo "<ul data-inset='true' data-role='listview'>";
                    //echo "<p data-role='list-divider' style='background-color:#C2C6C6;border-radius:4px;padding:7px;'>$columnData --  Posted by: </p><p style='background-color:#ffcc33;border-radius:4px;padding:7px;height:auto;font-weight:normal;' data-role='list-divider'>$colData</p><br /><br />";
                    echo "<div style='background-color:#ffcc33;padding:5px;border-radius:5px 5px 0px 0px;font-weight:bold'>$columnData -- Posted by: </div><div style='background-color:#dddddd;padding:5px 0px 10px 10px;border-radius:0px 0px 5px 5px;font-weight:normal'>$colData</div><br /><br />";
                    //echo "<li data-role='list-divider'>$columnData --  Posted by: </li><li style='background-color:#ffcc33;height:auto;font-weight:normal;'>$colData</li><br /><br />";
                    echo "</div></ul>";
                }
            }
        }
    }*/
}
?>