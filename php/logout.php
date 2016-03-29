<?php session_start();

	header("Content-Type: text/html;charset=utf-8");
	
	// remove all session variables
	session_unset(); 

	// destroy the session 
	session_destroy(); 
	
	header('Location: ../login.php');
?>