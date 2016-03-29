<?php
	DEFINE("DB_HOST","localhost");
	DEFINE("DB_USER","root");
	DEFINE("DB_PASS","");
	DEFINE("DB_NAME","cremadeelote");
	
	// Codificacion de cabecera
	header("Content-Type: text/html;charset=utf-8");
	
	/* Conexión con la BD */
	$GLOBALS['con']	=	new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	 if(!$GLOBALS['con']) { 
		die(mysqli_error()); //Manejo de error si no hay conexión;
	}	
	/* COnexión realizada con exito*/
	$acentos = $GLOBALS['con']-> query('SET NAMES utf8');  
?>