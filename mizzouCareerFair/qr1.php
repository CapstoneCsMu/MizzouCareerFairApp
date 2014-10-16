<!DOCTYPE html>

<html>
<head>
</head>
<body>
 <form method="POST">
	<div>
			<label for="email">Enter student email:</label>
			<input type="text" id="email" name="email">
	</div>
</form>

<?php

include ("data.php");

if(isset($_POST['submit'])) {
	
	
		
	$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'. pg_last_error());
	if (!$conn) 
	{
		echo "<br/>An error occurred with connecting to the server.<br/>";
		die();
	}

	 //select all info based on email
	$query = "SELECT * FROM careerschema.students WHERE email = $1";
	$stmt = pg_prepare($conn, "qrQuery", $query);
	//sends query to database
	$result = pg_execute($conn, "qrQuery", array($_POST['email']));
	//if database doesnt return results print this
	if(!$result) {
			echo 'I didnt work<br />';
	}

}
?>
<img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo $result; ?>&choe=UTF-8" title="<?php echo $name; ?>'s QR Code" />
</body>
</html>



	