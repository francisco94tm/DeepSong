<?php session_start();

	header("Content-Type: text/html;charset=utf-8");
	require_once 'connection.php';

	/* ----------------------------------------------------------------*/
 
	//// Selecciona la imagen y almacenala en carpeta temporal
		function select(){ 					
							
						
			if(isset($_FILES["file"]["type"])){
				 			
				$_FILES["file"]["name"] = str_replace(" ", "_", $_FILES["file"]["name"]); 				
				$validextensions = array("jpeg", "jpg", "png");
				$temporary = explode(".", $_FILES["file"]["name"]);
				$file_extension = end($temporary);
				$directory = "../img/artist/temp/";
				
				//$_FILES["file"]["name"] = $_SESSION["id"].".".$file_extension;				
				
				//Validation
				if ((($_FILES["file"]["type"] == "image/png") || 
					 ($_FILES["file"]["type"] == "image/jpg") || 
					 ($_FILES["file"]["type"] == "image/jpeg")) && 
					 ($_FILES["file"]["size"] < 3000000) && 	//Approx. 3000kb files can be uploaded.
					 in_array($file_extension, $validextensions)) {
					
					/** An error happened **/
					if ($_FILES["file"]["error"] > 0)
						echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
					
					/** Exist an image with the same name, delete the old one */
					if (file_exists($directory . $_FILES["file"]["name"])) 
						unlink($directory . $_FILES["file"]["name"]); 
					
					//Everything is ok, let's upload that pic 
					$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
					$targetPath = "../img/artist/temp/".$_FILES['file']['name']; // Target path where file is to be stored
					move_uploaded_file($sourcePath, $targetPath) ; // Moving Uploaded file 
					
					echo $_FILES['file']['name']; 
				}
				
				/** The file is bigger than expected or the extension does not match **/
				else		
					echo "<span id='invalid'>***Invalid file Size or Type***<span>";
			}
			
		}
		
	/* ----------------------------------------------------------------*/
		
		function upload(){
			
			//Copiar la imagen al directorio correcto
			$temp_img = $_POST["img"];  
			$temporary = explode(".", $temp_img);
			$extension = end($temporary); 
			
			$temp_path = "../img/artist/temp/";
			$final_path = "../img/artist/";
			 
			if (file_exists($temp_path . $temp_img)) {
				
				$final_img = $_SESSION["id"].".".$extension;	 
				
				$sourcePath = $temp_path . $temp_img;
				$targetPath = $final_path . $final_img;
 
				copy($sourcePath, $targetPath); 
				
				//Borrar archivos temporales
				$files = glob($temp_path . '*'); // get all file names
				foreach($files as $file){ // iterate files
				  if(is_file($file))
					unlink($file); // delete file
				}				
				 
				
				$country = $_POST["country"];
				$_SESSION["country"] = $country;
				
				$description = $_POST["description"];
				$_SESSION["description"] = $description;
				$_SESSION["img"] = $final_img;
				
				$id = $_SESSION["id"];
				
				$sql = "UPDATE artist 
						SET artist_country = '$country',
						artist_description = '$description',
						artist_img = '$final_img'
						WHERE artist_id = '$id'";
						
				$result = $GLOBALS['con']->query($sql);  
		 
			}
			
		}
	
	/* ----------------------------------------------------------------*/
	 		
		$action = $_GET["function"];		
		switch($action) {
			case 'select'	: select(); break; 
			case 'upload'	: upload(); break; 
		} 
	
?> 