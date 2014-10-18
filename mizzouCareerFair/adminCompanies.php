<!--
File: AdminCompanies.php
Parent: None yet
Purpose: The purpose of this file is to add additional RSS feeds into the database. It will be implemented into admin.php (I think)
-->
<!DOCTYPE html> 
<html> 
<head> 
 </head> 
 <body>
 <center>In order to populate a new RSS field, please enter the URL to the RSS field and click submit.</center></br>
 <center>
<form method="post" action="" id="link">
	<input type="text" name="link" placeholder="RSS Link"></input>
	<input type="submit" name="submitLink"></input>
</form>
</center>

<?php
	include ("data.php");
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());

	if(isset($_POST['submitLink'])){
		//Get rss link and all data fields in rss link and put them into database
		$rssLink = $_POST['link'];
		if($xml = simplexml_load_file($rssLink)){
			$content = $xml->channel->item->children("http://purl.org/rss/1.0/modules/content/");
			$data = $content->encoded;
			
			echo "<br>";
			echo "<fieldset>";
			echo "<h3><ul>Example of item in feed:</ul></h3>";
			echo $data;
			echo "</fieldset>";
			echo "<br>";
			
			$dom = new DOMDocument();
			$table = $dom->loadHTML($data);
			$dom->preserveWhiteSpace = false;
			$tables = $dom->getElementsByTagName('table');
			$rows = $tables->item(0)->getElementsByTagName('tr');
			
			foreach($rows as $row){
				$cols = $row->getElementsByTagName('td');
				$fields[] = $cols->item(0)->nodeValue;
				}
			
			echo "<form method=\"post\" action=\"input.php\" id=\"fields\">";
				echo "<input type=\"hidden\" name=\"rssLink\" value=".$rssLink.">";
				?>
				
				<!-- Select the field that contains company name -->
				
				<fieldset class="ui-field-contain">
    				<label for="nameField">Field For Company Name:</label><br>
    				<select name="nameField" id="nameField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>
  				
  				<!-- Select the field that contains the available positions -->
  				
  				<fieldset class="ui-field-contain">
    				<label for="positionsField">Field For Available Positions:</label><br>
    				<select name="positionsField" id="positionsField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>
  				
  				<!-- Select the field that contains the company address -->
  				<fieldset class="ui-field-contain">
    				<label for="addressField">Field For Company Address:</label><br>
    				<select name="addressField" id="addressField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>
  				
  				<!-- Select the field that contains the desired majors -->
  				<fieldset class="ui-field-contain">
    				<label for="majorsField">Field For Desired Majors:</label><br>
    				<select name="majorsField" id="majorsField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>
  				
  				<!-- Select the field that contains the position types -->
  				<fieldset class="ui-field-contain">
    				<label for="positionTypeField">Field For Position Types:</label><br>
    				<select name="positionTypeField" id="positionTypeField">
      				<?php
      					for($i = 0; $i < sizeof($fields); $i++)
      						echo "<option value=\"".$fields[$i]."\">".$fields[$i]."</option>";
    				?>
    			</select>
  				</fieldset>
  				
  				
  				<input type="submit" value="submit" name="fieldSubmit"></input>
  			</form>

			<?php
			
			}
		else
			echo "invalid link";
		}

//get most recent rss info	
?>
 
 </body>