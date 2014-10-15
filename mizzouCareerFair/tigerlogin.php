<?php
	
	include ("data.php");
	
	if(isset($_POST['submit'])) {
		$pawprint = htmlspecialchars($_POST['pawprint']);
		$password = htmlspecialchars($_POST['password']);
		$email = htmlspecialchars($_POST['email']);
		
		$dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'.pg_last_error());
		
		$query='SELECT * FROM careerSchema.authorizationTable WHERE username = $1 ';
		$result=pg_prepare($dbconn,'query1',$query);
		$result=pg_execute($dbconn,'query1',array($username));
		
		$ct=pg_num_rows($result);
		if($ct>0)
		{
			while($row=pg_fetch_array($result,NULL,PGSQL_ASSOC))
			{
			   $localhash = sha1(trim($row['salt']).trim($password));//hash input password with salt on db
				if($localhash == $row['hash'])
				{
					session_start();
					echo "You logged in!";
					//$ip=$_SERVER["REMOTE_ADDR"];//gets ip
					insert_db($row['username'],$ip);//function to feed the log table
					$_SESSION['username']=$row['username'];
					$_SESSION['password']=$row['password_hash'];
					
					//if user is an admin, direct them to admin page
					
					echo $row["user_type"];
					exit();
				}
				if($localhash != $row['hash'])
				{
					echo "Invalid login information\n";
					header('Location: index.php');
				}
			}
		}
		else 
		{
			echo "\tSomething went wrong.  Try to login with Facebook or LinkedIn\t";
		}
	}
	function insert_db($username,$ip)
{
    $dbconn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die ('Could not connect:'.pg_last_error());
	    
    $query_insert='INSERT INTO careerSchema.log (ip_address,log_date,action,username) VALUES($1,DEFAULT,$2,$3)';
//inserts login info	
    pg_prepare($dbconn,'insert3',$query_insert)or die ('Could not connect 5:'.pg_last_error());
    pg_execute($dbconn,'insert3',array($ip,"login",$username))or die ('Could not connect 6:'.pg_last_error());
    
    return 0;
}

?>