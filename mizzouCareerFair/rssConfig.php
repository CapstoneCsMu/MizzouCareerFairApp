<?php include("rssFunctions.php");
authorization();
?>

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
</head>

<div data-role="page" data-theme="a" id="add">
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php#option">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>RSS Configuration</h1>
    </div><br><br>

    <?if(!isset($_POST['submitLink'])) { ?>
        <form method="post" action="rssConfig.php" id="link" data-ajax="false">
            <div class="chooseFile">
                <label for="year"><h4>Year For This Career Fair:</h4></label>
                <select name="year" id="year">
                    <?php
                    for ($i = 2014; $i < 2050; $i++)
                        echo "<option value=\"" . $i . "\">" . $i . "</option>";
                    ?>
                </select>

                <label for="semester"><h4>Semester Of This Career Fair:</h4></label>
                <select name="semester" id="semester">
                    <option value="Fall">"Fall"</option>
                    <option value="Spring">"Spring"</option>
                </select>

                <label for="college"><h4>College For This Career Fair:</h4></label>
                <select name="college" id="college">
                    <option value="Engineering">Engineering</option>
                    <option value="Business">Business</option>
                    <option value="Journalism">Journalism</option>
                    <option value="CAFNR">CAFNR</option>
                </select>
                <br/>
                <input type="text" name="link" placeholder="RSS Link"></input>

                <div class="submitBtn">
                    <input type="submit" name="submitLink" value="Submit">
                </div>
            </div>
        </form>
        </center>

    <?php
    }
    include ("data.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

    if(isset($_POST['submitLink'])){
        //Get rss link and all data fields in rss link and put them into database
        $rssLink = $_POST['link'];
        $eventName = $_POST['year']." ".$_POST['semester']." ".$_POST['college']." Career Fair";
        if($xml = simplexml_load_file($rssLink)){
            $content = $xml->channel->item->children("http://purl.org/rss/1.0/modules/content/");
            $data = $content->encoded;

            /*echo "<data-role = \"fieldset\">";
            echo "<h3><ul>Example of item in feed:</ul></h3>";
            echo $data;
            echo "</fieldset>";*/

            $dom = new DOMDocument();
            $table = $dom->loadHTML($data);
            $dom->preserveWhiteSpace = false;
            $tables = $dom->getElementsByTagName('table');
            $rows = $tables->item(0)->getElementsByTagName('tr');

            foreach($rows as $row){
                $cols = $row->getElementsByTagName('td');
                $fields[] = $cols->item(0)->nodeValue;
            }
            ?>



            <div data-role="content" class="ui-grid-b">
            <form method="post" action="input.php" id="fields" data-ajax="false">
                <input type="hidden" name="rssLink" id="rssLink" value="<?php echo $rssLink;?>">
                <input type="hidden" name="event" id="event" value="<?php echo $eventName;?>">
                <input type="hidden" name="function"  value="add">

                    <ul data-dividertheme="b" data-inset="true" >
                    <li>
                         <select name="nameField" id="nameField"><option selected disabled>Field For Company Name</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                    </li>

                <!-- Select the field that contains the company address -->

                    <li>
                    <select name="cityField" id="cityField"><option selected disabled>Field For Company's City</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                    </li>


                <li>
                    <select name="stateField" id="stateField"><option selected disabled>Field For Company's State</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                </li>

                <!-- Select the field that contains the desired majors -->
                <li>
                    <select name="majorsField" id="majorsField"><option selected disabled>Field For Desired Majors</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                </li>

                <!-- Select the field that contains the position types -->

                    <select name="positionTypeField" id="positionTypeField"><option selected disabled>Field For Position Types</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>


                <li>
                    <select name="websiteField" id="websiteField"><option selected disabled>Field Company Website</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
               </li>

                <li>
                    <select name="citizenshipField" id="citizenshipField"><option selected disabled>Field Citizenship</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                </li>

                <li>
                    <select name="statusField" id="statusField"><option selected disabled>Field For Company Status</option>
                        <?php
                        for($i = 0; $i < sizeof($fields); $i++)
                            echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
                        ?>
                    </select>
                </li>
                        <div class="submitBtn">
                            <input type="submit" value="Submit" name="fieldSubmit"></input>
                        </div>
                </ul>
            </form>
                </div>

        <?php

        }
        else
            echo "invalid link";
    }
    //get most recent rss info
    ?>
</div>
</html>
<div data-role="page" data-theme="a" id="remove">
    <?
    $query = 'SELECT fairName FROM careerSchema.rssinfo ORDER BY fairName ASC';
    $result =  pg_query($query) or die('Query failed: ' . pg_last_error());
    ?>
    <div data-role="header">
        <a rel="external" data-icon="arrow-l" data-iconpos="notext" href="admin.php#option">Back</a>
        <a rel="external" data-icon="home" data-iconpos="notext" href="index.php">Home</a>
        <h1>RSS Configuration</h1>
    </div><br><br>

    <form method="post" action="input.php" data-ajax="false">
        <input type="hidden" name="function" value="remove">
    <div class="chooseFile">
    <label for="eventName"><h3>Select The Fair You Would Like To Remove:</h3></label><br>
    <select name="eventName" id="eventName">
        <?php
        while ($fair = pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "<option value=\"" . $fair["fairname"] . "\">" . $fair["fairname"] . "</option>";
            $fair++;
        }
        ?>
    <br>
    </select>
        <div class="submitBtn">
        <input type="submit" value="Submit" name="fieldSubmit"></input>
        </div>
	</div>
    </form>
</div>


</html>

