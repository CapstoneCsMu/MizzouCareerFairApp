<?php
/*
	File: updateProfile.php
	Parent: addResume.php , updateProfileForm.php
	Purpose: the forms inside parents files post to this page, to upload resume and insert or update student info.
	*/

include('check_https.php');
	
if($_SERVER['HTTP_HOST'] == 'localhost')
	include('data_ryanslocal.php');
else
	include ("data.php");
		
if (isset($_POST['Upload'])){
	
	$email = $_POST['email'];
	if (is_uploaded_file($_FILES['resume']['tmp_name']) )
	{
		if ($_FILES['resume']['error'] !== UPLOAD_ERR_OK) 
		{
			die("Upload failed with error " . $_FILES['resume']['error']);
		}
		else{
		
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			//grabing the mime type (server side)
			$mime = finfo_file($finfo, $_FILES['resume']['tmp_name']);
			
			//exit();
			$ok = false;
			$max_size = 300000;
			$destination = "uploads/";
			//allowed mime types
			$valid_mime_types = array('text/plain', 'application/msword', 'application/zip', 'application/doc', 'application/pdf', 'application/x-pdf',
			'application/acrobat', 'applications/vnd.pdf', 'text/pdf', 'text/x-pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.template', 'application/vnd.ms-word.document.macroenabled.12', '.doc', '.pdf');
			
			//checking file's mime type is inside allowed mime types
			if(in_array($mime, $valid_mime_types)){
				//checking size less than 292KB
				if($_FILES['resume']['size'] < $max_size)
				{
					echo "I like your file\n";
					//UPLOADING RESUME
					$d=date ("d");
					$m=date ("m");
					$y=date ("Y");
					$t=time();
					$dmt=$d+$m+$y+$t;    
					$ran= rand(0,10000000);
					$dmtran= $dmt+$ran;
					$un=  uniqid();
					$dmtun = $dmt.$un;
					$newPath = md5($dmtran.$un);
					$destination = $destination . $newPath;
					
					move_uploaded_file($_FILES['resume']['tmp_name'], $destination);
					//might want to add the "http://babbage.cs.missouri.edu/~cs4970grp..." 
					//to insert the entire path to the db but for now the path is uploads/[filename]
					//echo $destination;
					$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
					if (!$conn) 
					{
						echo "<br/>An error occurred with connecting to the server.<br/>";
						die();
					}

					//Run variables against dB
					$query = array( 0 =>"SELECT * FROM careerschema.students WHERE email=$1");
					//Search the three tables for authentication success
					$userWasFound = FALSE;
							
					for ($p = 0 ; $p < count($query) ; $p++)
					{
						$stmt = pg_prepare($conn, "check_".$p, $query[$p])  or die( "ERROR:". pg_last_error() );
						$result = pg_execute($conn, "check_".$p, array($email))  or die( "ERROR:". pg_last_error() );
						
						if(pg_num_rows($result) > 0)
						{
							$userWasFound = TRUE;
							$row = pg_fetch_assoc($result);
							//update_student($conn);
							$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
							if (!$dbconn) 
							{
								echo "<br/>An error occurred with connecting to the server.<br/>";
								die();
							}
							$query1 ="UPDATE careerschema.students SET resume = $1 WHERE email = $2";
							
							$stmt1 = pg_prepare($dbconn, "update", $query1)  or die( "ERROR:". pg_last_error());
							$result1 = pg_execute($dbconn, "update", array($destination, $email))  or die( "ERROR:". pg_last_error() );	
							pg_close($dbconn);
							echo "nice update resume";
							
						}
						else
						{
							echo "yeallo";
							//insert_student($firstname, $lastname, $gradDate, $major, $phone, $lifePlan, $linkedIn, $email);
							$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
							if (!$dbconn) 
							{
								echo "<br/>An error occurred with connecting to the server.<br/>";
								die();
							}
							$query1 ="INSERT INTO careerschema.students (email, resume) VALUES($1, $2)";
							
							$stmt1 = pg_prepare($dbconn, "insert", $query1)  or die( "ERROR:". pg_last_error());
							$result1 = pg_execute($dbconn, "insert", array($resume, $email))  or die( "ERROR:". pg_last_error() );	

							pg_close($dbconn);
						}		
					}
					pg_close($conn);
					//Shows message "Your resume has been saved"	
					header("Location: index.php#successResume");
					exit();
				}
				else
				{
					//Show message "Your file is too large.  Please try again!"	
					echo "Your file is too large.  Please try again!";
					header("Location: index.php#failureResumeLarge");
					exit();				
				}		
			}
			else
			{
				
				//Show message "Your file should be a  PDF or DOC.  Please try again!"
				header("Location: index.php#failureResumeType");
				exit();					
			}	
		}
	}
	//do this after the file is saved in the server
	header("Location: updateProfileForm.php");
}

if(isset($_POST['Next'])){
	header ("Location: updateProfileForm.php");
}

if(isset($_POST['Update'])){
	
	$firstname = htmlspecialchars($_POST['firstname']);
	$lastname = htmlspecialchars($_POST['lastname']);
	$phone = htmlspecialchars($_POST['phone']);
	$major = htmlspecialchars($_POST['major']);
	$gradDate = htmlspecialchars($_POST['gradDate']);
	$lifePlan = htmlspecialchars($_POST['lifePlan']);
	$job = htmlspecialchars($_POST['job']);
	$linkedinURL = htmlspecialchars($_POST['linkedInURL']);
	$pictureURL = htmlspecialchars($_POST['picture']);
	$location = htmlspecialchars($_POST['location']);
	$linkedIn = htmlspecialchars($_POST['linkedIn']);
	$student_loggedin = $_POST['student_loggedin'];
	$email = $_SESSION['student_loggedin'];
	
	//Make sure the person logged in is the same person who submitted the form!
	if ($email == $student_loggedin)
	{
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
		if (!$conn) 
		{
			echo "<br/>An error occurred with connecting to the server.<br/>";
			die();
		}

		//Run variables against dB
		$query = array( 0 =>"SELECT * FROM careerschema.students WHERE email=$1");
		//Search the three tables for authentication success
		$userWasFound = FALSE;
				
		for ($p = 0 ; $p < count($query) ; $p++)
		{
			$stmt = pg_prepare($conn, "check_".$p, $query[$p])  or die( "ERROR:". pg_last_error() );
			$result = pg_execute($conn, "check_".$p, array($email))  or die( "ERROR:". pg_last_error() );
			
			if(pg_num_rows($result) > 0)
			{
				$userWasFound = TRUE;
				$row = pg_fetch_assoc($result);
				//update_student($conn);
				$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
				if (!$dbconn) 
				{
					echo "<br/>An error occurred with connecting to the server.<br/>";
					die();
				}
				$query1 ="UPDATE careerschema.students SET firstname = $1, lastname = $2, graddate = $3, major = $4, phonenumber = $5, lifeplan = $6, linkedin_id = $7, picture_url = $8, location = $9, linkedin_url = $10, job = $11 WHERE email = $12";
				
				$stmt1 = pg_prepare($dbconn, "update", $query1)  or die( "ERROR:". pg_last_error());
				$result1 = pg_execute($dbconn, "update", array($firstname, $lastname, $gradDate, $major, $phone, $lifePlan,
					$linkedIn, $pictureURL, $location, $linkedinURL, $job, $email))  or die( "ERROR:". pg_last_error() );	
					
				pg_close($dbconn);
				header("Location: index.php#successProfile");		
			}
			else
			{
				//insert_student($firstname, $lastname, $gradDate, $major, $phone, $lifePlan, $linkedIn, $email);
				$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
				if (!$dbconn) 
				{
					echo "<br/>An error occurred with connecting to the server.<br/>";
					die();
				}
				$query1 ="INSERT INTO careerschema.students (email, firstname, lastname,  graddate, major, phonenumber, lifeplan, linkedin_id, picture_url, location, linkedin_url, job) VALUES($12, $1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
				
				$stmt1 = pg_prepare($dbconn, "insert", $query1)  or die( "ERROR:". pg_last_error());
				$result1 = pg_execute($dbconn, "insert", array($firstname, $lastname, $gradDate, $major, $phone, $lifePlan,
				$linkedIn, $pictureURL, $location, $linkedinURL, $job, $email))  or die( "ERROR:". pg_last_error() );	

				pg_close($dbconn);
				header("Location: index.php#successProfile");
			}		
		}
		pg_close($conn);
	}
	else
		header("Location: index.php");
}

?>
