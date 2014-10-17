<?php
	// To access $_SESSION, we have to call session_start()
	if (!isset($_SESSION))
	{
		session_start();
	}
	// check https and FORCE https on bad guys
	if ($_SERVER['HTTPS'] != "on" && $_SERVER['HTTP_HOST'] != 'localhost') 
	{
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	}
?>