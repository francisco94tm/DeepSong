<?php session_start();
	
	header('Content-Type: text/html; charset=UTF-8');  

 	

 	// CARGAR ARCHIVOS A SUBIR TEMPORALMENTE -------------------------------
	function select(){ 
 
	    //print_r($_FILES); //Imprime el arbol del array de canciones 

		//Si existen canciones proceder a analizarlas
		if (isset($_FILES["songs"]["name"])) 
		{ 
			
			echo '<div id = "top">'.
					' <div id = "title">Verifica que todo este en order</div>'.
					' <div id = "close"><i class = "flaticon-cancel"></i></div>'.
				 '</div>';
			echo '<div id = "send"><i class = "flaticon-next-arrow"></i></div>';

			$path_temp_songs = "../songs/__temp__/"; 			// Directorio donde se almacenaran las canciones temporalmente
			$path_temp_cover = "../img/cd-cover/__temp__/";			// Directorio donde se almacenaran las portadas de los albums
 
			if($path_temp_songs[strlen($path_temp_songs)-1]!='/') // Completa con una diagonal la direccion en caso necesario
            	$path_temp_songs = $path_temp_songs.'/';

			$validextensions = array("mp3", "m4a", "png", "aac", ".wma"); 	// Extensiones validas

			$count = 0; // Contador

			// Variables principales del album
			$album_title = NULL;
			$album_genre = NULL;
			$album_year = NULL;
			$album_cover = NULL;
			$isAlbumPasted = false;
			$isTitlePasted = false;
			$isGenrePasted = false;
			$isYearPasted  = false;
			$isPricePasted  = false;
			$isDescriptionPasted  = false;
			$isVideoPasted  = false;

			$isHeaderPasted = false;

			echo '<form name ';

			//Recorre cada archivo del arreglo
			foreach ($_FILES['songs']['name'] as $name) {

				$name = str_replace(" ","_", $name); 		
				$name = str_replace(")","_", $name); 
				$name = str_replace("(","_", $name); 		
				$name = str_replace("'","", $name); 

		 		$temporary = explode(".", $name);			// Variable temporal
		 		$name_without_extension = $temporary[0];	// Extrae la extensión del nombre del archivo
				$extension = end($temporary);				// Extrae la extensión del nombre del archivo
				$type = $_FILES["songs"]["type"][$count];	// Tipo de archivo
				$size = $_FILES["songs"]["size"][$count];	// Tamaño del archivo

				//Valida que la extension pertenezca a un archivo válido
				if (($type == "audio/*") || ($size < 32000000) && 	//Approx. 32MB files can be uploaded.
					in_array($extension, $validextensions)) {

					try{

						// Ocurrió un error inesperado
						if ($_FILES["songs"]["error"][$count] > 0)
							echo "Return Code: " . $_FILES["songs"]["error"][$count] . "<br/><br/>";
	 					
						$original_name = $name;
						$i = 0;

	 
						//Crear carpeta del usuario sino existe
						$folder_songs = $path_temp_songs."".$_SESSION["id"];
						if (!file_exists($folder_songs)) 
	    					mkdir($folder_songs, 0777, true);

	    				$folder_cover = $path_temp_cover."".$_SESSION["id"];
						if (!file_exists($folder_cover)) 
	    					mkdir($folder_cover, 0777, true);
						
						//Cambia el nombre en caso de que exista un archivo con el mismo nombre en la carpeta temporal				 
						while(file_exists($path_temp_songs.$_SESSION["id"]."/".basename($name))){  
							$name = $name_without_extension."_".$i.".".$extension;
							++$i;
						}
						
						//Subir la canción al servidor 
						$sourcePath = $_FILES['songs']['tmp_name'][$count]; 		// Directorio origen temporal
						$targetPath = $path_temp_songs.$_SESSION["id"]."/".$name; 	// Directorio destino temporal
						move_uploaded_file($sourcePath, $targetPath) ; 				// Subir archivo


						//Carga librerias para obtener metadatos
						require_once('Zend/Media/Id3v1.php');
						require_once 'Zend/Media/Id3v2.php'; // or using autoload
						require_once 'Zend/Media/Id3/Exception.php';
						require_once 'Zend/Media/Mpeg/Abs.php';

						//Directorio completo del archivo incluyendo su nombre
						$full_temp_path  = $path_temp_songs.$_SESSION["id"]."/".$name;

						
							//  Archivos contenedores de las etiquetas ID3v1 de la cancion
							$id3 = new Zend_Media_Id3v1($full_temp_path);

							try{
								$abs = new Zend_Media_Mpeg_Abs($full_temp_path);
								$duration    = $abs ->	getFormattedLengthEstimate(); 	//Consigue la duración de la cancion
								preg_match('/^([0-9|:]+)/',$duration,$dur);  
								$song_length = $dur[0]; 
							}
							catch(Zend_Media_Mpeg_Exception $e){
								$song_length = "-";
							} 

							// Información por canción --------------------------------
							$song_track  = $id3	->	getTrack(); 					//Consigue el track de la canción
							$song_title  = $id3	->	getTitle(); 					//Consigue el nombre de la cancion					 
							


							//Información por disco ------------------------------------
							if(is_null($album_title))
								$album_title = $id3	->	getAlbum();	//Consigue el album de la cancion

							if(is_null($album_genre))
								$album_genre = $id3	->	getGenre(); //Consigue el genero de la canción	

							if(is_null($album_year))		
								$album_year  = $id3	->	getYear();	//Consigue el año de la canción

							//Consigue la portada del album
							if(is_null($album_cover)){

								//  Archivo contenedor de la ruta de la portada
								$id3v2 = new Zend_Media_Id3v2($full_temp_path);
								if (isset($id3v2->apic)) {
									 
									//Guarda la imagen encontrada en el archivo							
									$img_extension = explode("/", $id3v2->apic->mimeType, 2)[1]; 

									//Se puede abrir la direccion donde se guardara la imagen
									if (($handle = fopen($image = $path_temp_cover.$_SESSION["id"]."/".$name.".". $img_extension, "wb")) !== false) {
										$album_cover = $name.".". $img_extension;	//Consigue la portada del album
										
										//No se puede guardar la imagen en la direccion solicitada				
										if (fwrite($handle, $id3v2->apic->imageData,$id3v2->apic->imageSize) != $id3v2->apic->imageSize)
											 fclose($handle);
									}	

									//Error desconocido
									else echo "  Found a cover image, but unable to open image file for writing: " . $image . "\n";
								}
							}


							//Pega la portada al visor
							if(!is_null($album_cover) && !$isAlbumPasted){ 


								echo '<div class = "cover" src = "img/'.$path_temp_cover.$_SESSION["id"]."/".$album_cover.'"></div>';
								echo '<div class = "cover-top"></div>';
								echo '<script>'.
 
										'var cover_img = $(".submit-material-window .cover").attr("src");'. 									
										'$(".submit-material-window .cover").css("background-image","url("+cover_img+")");'.
							 
									  '</script>';
								$isAlbumPasted = true;
							}
 
							//Pega el titulo del disco al visor
							if(!is_null($album_title) && !$isTitlePasted){ 
								echo '<input type = "text" id = "album-title" value = "'.$album_title.'"></input>';							 
								$isTitlePasted = true;
							}

							//pega el año del disco al visor
							if(!$isYearPasted){ 
								echo '<div class = "tag">AÑO</div>';
								echo '<div class = "tag">GÉNERO</div>';
								echo '<div class = "tag">PRECIO ($ MXN)</div>';
							}

							//Pega el año de lanzamiento al visor
							if(!is_null($album_year) && !$isYearPasted){ 
								echo '<input type = "text" id = "album-year" value = "'.$album_year.'" maxlength="4"></input>';							 
								$isYearPasted = true;
							}

							//Pega el genero del disco al visor
							if(!is_null($album_genre) && !$isGenrePasted){ 
								echo '<input type = "text" id = "album-genre" value = "'.$album_genre.'"></input>';							 
								$isGenrePasted = true;
							}

							//Pega el precio del disco al visor
							if(!$isPricePasted){ 
								echo '<input type = "text" id = "album-price" value = "0"></input>';							 
								$isPricePasted = true;
							}

							//Pega el video del disco al visor
							if(!$isVideoPasted){ 
								echo '<div class = "ico tag"><span class = "flaticon-video"></span></div>';
								echo '<div class = "tag tag-video">ULTIMOS 11 CARACTERES DEL VIDEO DE YOUTUBE</div>';
								echo '<input type = "text" id = "album-video" placeholder = "EJ: mQfFVuNssuQ" maxlength="11"></input>';							 
								$isVideoPasted = true;
							}

							//Pega descripcion del disco al visor
							if(!$isDescriptionPasted){ 
								echo '<textarea = "text" id = "album-description" placeholder = "Escribe algo breve sobre el disco" maxlength="2000"></textarea>';							 
								$isDescriptionPasted = true;
							}

							

							//Pega el precio del disco al visor
							if(!$isHeaderPasted){ 
								echo '<div class = "song_header">
						   				<input disabled type = "text" value = "#"/>
						   				<input disabled type = "text" value = "CANCIÓN"/>
						   				<input disabled type = "text" value = ""/>
						   				<input disabled type = "text" value = "$ MXN"/>
					   				</div>'; 							 
								$isHeaderPasted = true;
							}

							//Pega cada track al visor
					   		echo '<div class = "song" src = "'.$name.'">'.
					   				'<input type = "text" class = "track" value = "'. $song_track.'"/>'.
					   				'<input type = "text" class = "name" 	value = "'. $song_title.'"/>'.
					   				'<input type = "text" class = "length" 	value = "'. $song_length.'"/>'.
					   				'<input type = "text" class = "price" 	value = "0"/>'.
					   			'</div>'; 

					}catch (Zend_Media_Id3_Exception $e) { //Excepcion de la extension para conseguir metadatos 
						die ($e->getMessage());
					}   
					
				}

				$count++; 
			}



			//Conseguir el color de la portada 
			echo '<img id = "test2" src = "img/'.$path_temp_cover.$_SESSION["id"]."/".$album_cover.'"/>';	

			echo '<script>

				$("img#test2").on("load", function(){  
					var rgb = getAverageRGB(document.getElementById("test2"));
					if(isTooLight(rgb)){
						rgb = ColorLuminance(rgb,-0.3);
					}  
					$(".tag").css("color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")"); 
					 

					$("#send").css("background-color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
					$("input").focus(function(){
						$(this).css("border-bottom","solid 1px rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
					}).focusout(function(){
						$(this).css("border-bottom","solid 1px transparent");
					}); 

				});';


			/*cerrar menu si se da clic fuera de foco*/
 				 
			echo '$(document).on("click", function (e) {'.  
					'if($(".submit-material-wrapper").css("display") != "none")'. 
						'if ($(e.target).closest($(".submit-material-window")).length === 0)'.
							'$("#close").click();'.						 
					'});';

			echo '$("#close").click(function(){'. 
					'$.ajax({ url: "php/uploadSongs.php?function=delete" });'.  					
					'$(".submit-material-wrapper").hide();'.   
					'$(".submit-material-window").html(""+$(".loader-wrapper").html());'.  
				'});'; 

			echo '$("#send").click(function(){'.

					'$(this).fadeOut();'.
					

					'var album_name 	= $("#album-title").val();'.
					'var album_genre 	= $("#album-genre").val();'.
					'var album_year 	= $("#album-year").val();'.
					'var album_price 	= $("#album-price").val();'.
					'var album_video 	= $("#album-video").val();'.
					'var album_description = $("#album-description").val();'. 
					'var album_cover 	= "'.$album_cover.'";'.

					'var song_file	 	= [];'.
					'var song_track 	= [];'.
					'var song_name 		= [];'.
					'var song_length 	= [];'.
					'var song_price 	= [];'.

					'$(".song").each(function(){'.
						'song_file.push($(this).attr("src"));'.
						'song_track.push($(this).find(".track").val());'.
						'song_name.push( $(this).find(".name").val());'. 
						'song_length.push($(this).find(".length").val());'. 
						'song_price.push($(this).find(".price").val());'.   
					'});'; 
					 

					echo '$.ajax({'.
						'url: "php/uploadSongs.php?function=upload",'.  
						'type: "POST",'. 
						'data:  {'.
							'titles: JSON.stringify(song_name),'.
							'files:  JSON.stringify(song_file),'. 
							'tracks: JSON.stringify(song_track),'.
							'lengths: JSON.stringify(song_length),'.
							'prices: JSON.stringify(song_price),'.

							'album:  album_name,'.
							'cover:  album_cover,'.
							'genre:  album_genre,'.
							'year:   album_year,'.
							'price:  album_price,'.
							'video:  album_video,'.
							'description:   album_description'.

						'},'.  
						'success: function(data)'.   
						'{'.  				
							'location.reload();'.

						'}'.
					'});'.
  

				'});'.


				'</script>'; 
		}

		else
			echo '<script> $("#close").click(); </script>';
	}
 
	// CARGAR ARCHIVOS A SUBIR TEMPORALMENTE -------------------------------
	function rrmdir($dir) {  
		if (is_dir($dir)) {
	    	$objects = scandir($dir);
	     	foreach ($objects as $object) {
		       	if ($object != "." && $object != "..") {
		        	if (filetype($dir."/".$object) == "dir"){
		            	rrmdir($dir."/".$object);
		         	}else{ 
		            	unlink($dir."/".$object);
		         	}
		        }
	    	}
	     	reset($objects);
	     	rmdir($dir);
	  	}
	}

	function delete(){  

		if(isset($_POST)){
			// Directorio donde se almacenan las canciones temporalmente
			$path_temp_songs = "../songs/__temp__/".$_SESSION["id"]; 			

			// Directorio donde se almacenaran las portadas de los albums
			$path_temp_cover = "../img/cd-cover/__temp__/".$_SESSION["id"];			
			
	 
			rrmdir($path_temp_songs); 
			rrmdir($path_temp_cover);		
		}
	}

	// CARGAR ARCHIVOS A SUBIR TEMPORALMENTE -------------------------------
	function upload(){
		if(isset($_POST['files'])){
			$titles 	= json_decode($_POST['titles']); 
			$files 		= json_decode($_POST['files']); 
			$tracks 	= json_decode($_POST['tracks']); 
			$lengths 	= json_decode($_POST['lengths']); 
			$prices 	= json_decode($_POST['prices']);

			$album 		= $_POST['album'];
			$genre 		= $_POST['genre'];
			$year 		= $_POST['year'];
			$cover 		= $_POST['cover'];
 			$price 		= $_POST['price'];
 			$video 		= $_POST['video'];
 			$description= $_POST['description'];

			//Subir imagen a carpeta permanente del servidor  
			$source = '../img/cd-cover/__temp__/'.$_SESSION["id"].'/'.$cover;
			$target = '../img/cd-cover/'.$cover;				
			copy($source, $target);  
 
 			require_once 'connection.php'; 

 			//Obtener id maximo de CDs
		 	$sql = "SELECT MAX(album_id) FROM album"; 
		 	$result =  $GLOBALS['con']->query($sql); 
		 	$record = mysqli_fetch_array($result,MYSQLI_NUM);				 
		 	$max_id = $record[0];
		 	$max_id += 1; 


		 	//Crear carpeta para el artista en el servidor 
			$folder_songs = '../songs/'.$_SESSION["id"];
			if (!file_exists($folder_songs)) 
				mkdir($folder_songs, 0777, true);

			//Crear carpeta para el album a subir al servidor 
			$folder_songs = '../songs/'.$_SESSION["id"]."/".$max_id;
			if (!file_exists($folder_songs)) 
				mkdir($folder_songs, 0777, true);

 
			foreach ($files as $songfile) {
				$temppath = "../songs/__temp__/".$_SESSION["id"]."/".$songfile;
				$finalpath = $folder_songs."/".$songfile;
				copy($temppath, $finalpath);
			}
 				
 			//Registrar album -------------------------------------
			
			$sql = "INSERT INTO album (
					album_id, album_name, album_year, album_cover, album_video, album_description) 
					VALUES ( 
					$max_id, '$album', $year, '$cover', '$video', '$description')";
			$GLOBALS['con']->query($sql);
 

			$sql = "INSERT INTO artist_album (artist_artist_id, album_album_id)	VALUES ($_SESSION[id], $max_id)";
			$GLOBALS['con']->query($sql);

			$sql = "INSERT INTO cd (cd_part, cd_price, album_album_id)	VALUES (1, $price, $max_id)";
			$GLOBALS['con']->query($sql);
			
			
			//Regitrar canciones --------------------------------- 
			for($i=0; $i < sizeof($titles); $i++){
				
				$sql = "INSERT INTO song(
							song_name,
							song_track,
							song_price,
							song_url,
							song_length,
							cd_cd_part,
							cd_album_album_id)
						VALUES(
							'$titles[$i]',
							 $tracks[$i],
							 $prices[$i],
							 '$files[$i]',
							 '$lengths[$i]',
							 1,
							 $max_id
						)"; 
				$GLOBALS['con']->query($sql);
			}
		
		}
	}

	
	/// ------------------------------------------------------------------

	$action = $_GET["function"];		
	switch($action) {
		case 'select'	: select(); break; 
		case 'upload'	: upload(); break;
		case 'delete'	: delete(); break;  
	} 
?>