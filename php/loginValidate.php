<?php  

	header("Content-Type: text/html;charset=utf-8");
	require_once 'connection.php'; 
	include ("encrypt.php");
	 	
	//Este array guardará los errores de validación que surjan.
	$_SESSION['errors'] = array(); 
	
	//Pregunta si está llegando una petición por POST, lo que significa que el usuario envió el formulario.
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		$pass = isset($_POST['pass']) ? $_POST['pass'] : null; 
		
		//echo $pass."<br>";
		$pass = encrypt($pass); 
		//echo $pass."<br>"; 
		
		$_SESSION['errors'] = $pass;
		
		
		//Verificar si el correo ya se registró en la BD
		$sql = "SELECT 
					artist_id,
					artist_name,
					artist_img,
					artist_description,
					artist_country
				FROM artist 
				WHERE 
					artist_email = '$email' AND 
					artist_pass = '$pass'";
					
		$result = $GLOBALS['con']->query($sql); 	
		
		if ($result->num_rows > 0){
			$_SESSION['errors'] = 'Ya se ha registrado una cuenta con el correo ingresado';  
			   
			$row = $result->fetch_assoc();
			
			$_SESSION['email'] 			= $email;
			$_SESSION['id'] 			= $row["artist_id"];	
			$_SESSION['name'] 			= $row["artist_name"];
			$_SESSION['img'] 			= $row["artist_img"];	
			$_SESSION['description'] 	= $row["artist_description"];	
			$_SESSION['country'] 		= $row["artist_country"];	
			
			 
			header('Location: ../artist.php?profile=0'); 
			exit; 
		}
		//La cuenta no esta registrada
		else{
			
			$_SESSION['errors'] = 'El correo o la contraseña son incorrectos, intente de nuevo.'; 
			echo $_SESSION['errors'];
			header('Location: ../login.php'); 
			exit; 
		}
		
		
	}
	
?>