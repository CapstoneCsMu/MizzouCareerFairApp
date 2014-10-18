<?php
	/*
	File: check_https.php
	Parent: This file is called multiple times in order to prevent users from accessing our page without HTTPS
	*/
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