<?php session_start();
	
	// Codificacion de cabecera	 
	require_once 'php/connection.php';  
	
	if(array_key_exists("errors", $_SESSION)){	  
		if(sizeof($_SESSION['errors']) > 0){	
			echo "<div class = 'error-alert'>".$_SESSION['errors']."</div>"; 
			$_SESSION['errors'] = null;
		}  
	}
	if(isset($_SESSION['id'])){
		header('Location: index.php');
		exit;  
	}
?>

<!DOCTYPE html> 
<html>
	<head>	
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title> Iniciar sesión	</title>
		
		<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">		
		<link rel="stylesheet" type="text/css" href="css/login.css">		
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,700' rel='stylesheet' type='text/css'>   
		  
		<?php
		$directorio = "./img/artist";   
		$cover = scandir ($directorio);
			do{
				$imgToPick = $cover[mt_rand(0,sizeof($cover)-1)];
			}while($imgToPick == '.' or $imgToPick == '..' or $imgToPick == 'temp'); 
		?> 
			
		<style>	 
			.img-back{
				background-image: url('<?php echo $directorio;?>/<?php echo $imgToPick;?>'); 
			}  
		</style>
		 	
	</head>
	<body>
		
		<div class = "img-back"></div>
		<div class = "img-back-top"></div>
		
		<div class = "card-wrapper">
			<!--Carta --> 
			<div class = "card">			
				
				
				<div class = "info">Crea una cuenta ¡Es gratis!</div>
				<form name = "register" method = "POST" action = "php/registerValidate.php" autocomplete = "off">				
					<div style="display: none;">
						<input type="text" id="PreventChromeAutocomplete" name="PreventChromeAutocomplete" autocomplete="address-level4" />
					</div>
					<input type = "email" name = "email" placeholder = "Email" required>
					
					
					<input type = "name" name = "name" placeholder = "Nombre artístico" required>
					<input type = "password" name = "pass" placeholder = "Contraseña" required>
					<input type = "password" name = "repass" placeholder = "Repite tu contraseña" required>
					<input type = "submit" name = "submit" value = "Registrar">	
				</form> 
			</div>
		
		</div>
		
		<div class = "navbar">
			<div class = "logo"> 
				<div class = "text"><b>DEEP</b>SONG</div>
			</div>  
			<form name = "login" method = "POST" action = "php/loginValidate.php" autocomplete = "off" >			
				<input type = "email" name = "email" placeholder = "Email" required>
				<input type = "password" name = "pass" placeholder = "Contraseña" required>
				<input type = "submit" name = "submit" value = "Inicia Sesión">	
			</form>
			
			<div class = "more"><i class="flaticon-more"></i> </div> 
		</div>
	</body>
</html>