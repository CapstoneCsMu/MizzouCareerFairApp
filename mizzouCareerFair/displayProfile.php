  <div data-role="page" data-theme="a" id="myProfile">
        <div data-role="header" data-position="fixed">
            <h1 onclick="$.mobile.silentScroll(0)">My Profile</h1>
            <a data-transition="slidedown" data-icon="arrow-l" data-iconpos="notext" href="#home" rel="external">Home</a> 
			<a data-transition="slide" data-icon="edit" href="#Edit">Edit</a>
        </div>
				
		<div data-role="content">
			<div data-role="tabs">
				<div data-role="navbar">
					<ul>
						<li><a href="#profile">Profile</a></li>
						<li><a href="#code">QR Code</a></li>
						<li><a href="#jobHunt">Job Hunt</a></li>
					</ul>
				</div>
				<div id="profile">
				<?php displayProfile(); ?>
				</div>
				<div id="jobHunt">
					<?php echo"</br><center><script type=\"IN/JYMBII\" data-format=\"inline\"></script></center>" ?>
				</div>
				<div id="code">
				    <h4><center>Have employers scan your QR Code and they will have your information!<center></h4>
					<?php
					echo '<center><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=https://babbage.cs.missouri.edu/~cs4970s14grp2/mizzoucareerfairs/CodeScanned.php?email='.$_SESSION['student_loggedin'].'"&choe=UTF-8"/><center>';
					?>
				</div>
			</div>
		</div>
		<div class="panel left" data-role="panel" id="Edit" data-position="left" data-display="overlay">
			<ul data-dividertheme="b" data-inset="true" data-role="listview">
				<li data-role="list-divider">Edit Profile</li>
				<li><a  style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-edit ui-btn-icon-left" href="updateProfileForm.php">Edit Info</a></li>
				<li><a  style="text-overflow: ellipsis; overflow: visible; white-space: normal" class="ui-btn ui-icon-cloud ui-btn-icon-left" href="addResume.php">Upload Resume</a></li>
			</ul>
		</div>
	</div>
<?php
function displayProfile()
{
    // include ("data.php");
    $conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
	$query = "SELECT * FROM careerschema.students WHERE EMAIL = $1";
	$stmt = pg_prepare($conn, "profile", $query) or die("ERROR: ".pg_last_error() ); 
	$result = pg_execute($conn, "profile", array($_SESSION['student_loggedin'])) or die("ERROR: ".pg_last_error() );
	// $row = pg_fetch_assoc($result);
	// var_dump($row);
	if(pg_num_rows($result) > 0)
	{
		echo "</br><table>";
		$row = pg_fetch_assoc($result);
		// display picture

		echo '<center><img src="'.$row['picture_url'].'" style=".ui-grid-b img{width:100%; height: auto;}" /></center>';
		foreach($row as $key => $value)
		{
			if ($value != NULL)
			{

				switch($key)
				{
					case 'email':
						echo '<tr><td valign="top" align="left">Email: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'firstname':
						echo '<tr><td valign="top" align="left">First Name: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'lastname':
						echo '<tr><td valign="top" align="left">Last Name: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'phonenumber':
						echo '<tr><td valign="top" align="left">Phone Number: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'location':
						echo '<tr><td valign="top" align="left">Location: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'linkedin_url':
						echo '<tr><td valign="top" align="left">LinkedIn Profile: </td><td valign="top" align="left"><a target="_blank" href="'.$value.'">Click</a></td></tr>';
						break;
					case 'job':
						echo '<tr><td valign="top" align="left">Job: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'graddate':
						echo '<tr><td valign="top" align="left">Graduation Date: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'major':
						echo '<tr><td valign="top" align="left">Major: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					case 'lifeplan':
						echo '<tr><td valign="top" align="left">Career Goals: </td><td valign="top" align="left">'.$value.'</td></tr>';
						break;
					default;
						break;
				}
				
			}
		}
		echo "</table>";
	}
	else
	{
	    echo "\n</br><div style='color:#468847; background-color: #dff0d8; border-color: #d6e9c6;'>";
        echo "\n\t<center></br>Thank you for joining us. please Edit Your Profile!</center></br>";
        echo "\n</div>";
	}
}
?>