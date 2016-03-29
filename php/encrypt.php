<?php session_start();

	header("Content-Type: text/html;charset=utf-8");
	
	//Encripta la contraseña
	function encrypt($pass){ 
		return base64_encode(~$pass);
	}
	
	function decrypt($pass){
		return base64_decode(~$pass);
	}
?>