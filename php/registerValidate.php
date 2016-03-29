<?php session_start();

	header("Content-Type: text/html;charset=utf-8");
	include ("encrypt.php");
 
	require_once 'connection.php'; 	
	
	//Este array guardará los errores de validación que surjan.
	$_SESSION['errors'] = array(); 	
	
	//Pregunta si está llegando una petición por POST, lo que significa que el usuario envió el formulario.
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
		
		/**Variables **/
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		$name = isset($_POST['name']) ? $_POST['name'] : null;
		$pass = isset($_POST['pass']) ? $_POST['pass'] : null;
		$repass = isset($_POST['repass']) ? $_POST['repass'] : null;
		
		
		//Verificar si contraseñas no se repiten
		if($pass != $repass) 
			$_SESSION['errors'] = 'Las contraseñas no coinciden.'; 
		
		//Verificar si el correo ya se registró en la BD
		$sql = "SELECT artist_email FROM artist WHERE artist_email = '$email'"; 
		$result = $GLOBALS['con']->query($sql); 	
		
		if ($result->num_rows > 0) 
			$_SESSION['errors'] = 'Ya se ha registrado una cuenta con el correo ingresado';  
		
		//No se encontró ningun error, registrar usuario en la BD.
		if(!($_SESSION['errors']))   
			createUser($email, $pass, $name); 
		
		//Hay errores regresar a pagina inicial
		header('Location: ../login.php'); 
		exit;		
	}
	
	
	//Da de alta a un usuario en la BD
	function createUser($email, $pass, $name) { 
		
		$pass = encrypt($pass);  		
		$sql = "INSERT INTO artist (
					artist_email, 
					artist_pass, 
					artist_name
				) 
					VALUES ( 
					'$email',
					'$pass', 
					'$name'
				)"; 
					
		$result = $GLOBALS['con']->query($sql);  
		
		if ($result > 0) {
			echo "New record created successfully";
			
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $name;	
			
			header('Location: ../configuration.php'); 
			exit; 
			
			
		} else {
			$_SESSION['errors'] = 'Estamos teniendo dificultades, Intenta registrarte más tarde'; 
		} 
	}
	

	
?>