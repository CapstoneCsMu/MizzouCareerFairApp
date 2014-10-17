<?php
include('check_https.php');
	//session_start();
	//$_POST['student_loggedin'] = $_SESSION['student_loggedin'];
	
if (isset($_POST['Upload'])){
	//print_r($_POST);
	//print_r($_FILES['resume']['tmp_name']);
	//exit();
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
					echo $destination;
					
									
					header("Location: updateProfileForm.php");
					exit();
				}
				else
				{
					echo "Your file is too large.  Please try again!";
					header("Location: addResume.php");
					exit();				
				}		
			}
			else
			{
				echo "Please submit a .pdf or .doc";	
				header("Location: updateForm.php");
				exit();					
			}	
		}
	}
	//do this after the file is saved in the server
	header("Location: updateProfileForm.php");
}

if(isset($_POST['Update'])){
	print_r($_POST);
	exit();
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$gradDate = $_POST['gradDate'];
	$major = $_POST['major'];
	$resume =  $_POST['resume'];
	$phone = $_POST['phone'];
	$lifePlan = $_POST['lifePlan'];
	$linkedIn = $_POST['linkedIn'];
	$student_loggedin = $_POST['student_loggedin'];
	
}

?>
