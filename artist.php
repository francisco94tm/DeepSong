<?php session_start();
	
	require_once 'php\connection.php';
   
	//------------------------------------------------------------
	// Ya se logueo
	 if(array_key_exists("id", $_SESSION)){
		 
		//Ingreso numero de perfil
		if(isset($_GET["profile"])){
			
			//Ingreso a su perfil de usuario
			 if($_GET["profile"] == 0 || $_GET["profile"] == $_SESSION["id"]){
				 ownProfile();
			 }
			 
			 //Ingreso a un perfil ajeno
			 else otherProfile($_GET["profile"]);
		}
		// No ingreso perfil
		else{
			header('Location: artist.php?profile=0');
			exit;  
		}    
	 }
	//No se ha logueado	
	else{
		//Ingreso numero de perfil
		if(isset($_GET["profile"])){
			
			//Ingreso al perfil cero, no esta logueado
			 if($_GET["profile"] == 0){
				 notLogged();
			 }
			 
			 //Ingreso a un perfil ajeno
			 else otherProfile($_GET["profile"]);
		}
		//No ingreso perfil
		else notLogged();
	}	
 
	 
	//###########################
	
	function notLogged(){
		header('Location: index.php');
		exit;  	
	}
	
	//###########################
	
	function  ownProfile(){
		$GLOBALS["email"] 		= $_SESSION['email'];
		$GLOBALS["id"]			= $_SESSION["id"];
		$GLOBALS["name"]		= $_SESSION["name"];
		$GLOBALS["img"]			= $_SESSION["img"];
		$GLOBALS["country"] 	= $_SESSION["country"];
		$GLOBALS["description"] = $_SESSION["description"];
	}
	
	//###########################
	//ENtro en un perfil ajeno
	
	function otherProfile($var){
		
		$GLOBALS["id"] = $var;
		$id = $GLOBALS['id'];
		$sql = "SELECT
				artist_name,				
				artist_img,				
				artist_description,
				artist_country 
				FROM artist WHERE artist_id = $id
				"; 

		$result = $GLOBALS['con']->query($sql);
							
		//Verifica que exista el artista
		if ($result->num_rows > 0){				 				 
			$row = $result->fetch_assoc();	
			  
			$GLOBALS["name"] 		= $row["artist_name"];
			$GLOBALS["img"]	 		= $row["artist_img"];
			$GLOBALS["country"] 	= $row["artist_country"];
			$GLOBALS["description"]	= $row["artist_description"];	

		}
		
		else{
			notLogged();
		}
	}
	
?>


<!DOCTYPE html> 
<html>
	<head>	
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title> Crema de Elote	</title>
		
		<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">		
		<link rel="stylesheet" type="text/css" href="css/artist.css">
		<link rel="stylesheet" type="text/css" href="css/navbar.css">
		<link rel="stylesheet" type="text/css" href="css/loader.css"> 
		<link rel="stylesheet" type="text/css" href="css/viewer.css"> 
		
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,900' rel='stylesheet' type='text/css'>   		
		<script type = "text/javascript" src = "js/jquery-1.11.3.js"></script> 
		<script type = "text/javascript" src = "js/artistJS.js"></script> 
		<script type = "text/javascript" src = "js/visor.js"></script> 
		
		 
		<?php 
			if(array_key_exists("id", $_SESSION)){
				if($_GET["profile"] != 0 && $_GET["profile"] != $_SESSION["id"])
					setButton("current_profile"); 
				else setButton("profile");
			}
			else setButton("profile");

			function setButton($button){
				echo'
					<script>
					$(function(){
						$(".btn").removeClass("selected_btn");
						$("#'.$button.'").addClass("selected_btn"); 			
					});


					</script>
				'; 
			}

		?>		

		<script src = "js/navbarInteraction.js"></script> 
		<script src = "js/add_content.js"></script>
		<script src = "js/artistBackground.js"></script>		
		<script src = "js/imageAnalysis.js"></script>
		<script src = "js/getColor.js"></script>
		<script src = "js/setColor.js"></script>
		

		
	</head>
	<body> 
	
	  
		<!-------------------------------------------------------------------------------------------------->
		
		<!--Barra de navegación -->
		<div class = "navbar"> 
			<div class = "navbar-wrapper getBackColor"> 
				
				<!-- Logo y boton de menu -->
				<div class = "top"> 
					<div class = "back-logo"></div>
					<div class = "menu"><span class ="flaticon-burguer"></span></div>  
					<div class = "text"><b>DEEP</b>SONG</div>
				</div> 
				 
				 <!--Boton de busqueda -->
				<div class = "nav-buttons">					
					<div class = "btn" id = "search"><i class="flaticon-search"></i></div>					
				</div> 
			</div> 
		</div>
		
		<!-------------------------------------------------------------------------------------------------->
	 
		<!-- Menu oculto izquierdo -->
		<div class = "side-menu getBackColor"> 

			<div class = "top"></div>
			<!--Boton para cerrar Menu -->
			<div class = "close-btn"><i class="flaticon-cancel"></i></div>		
			
			<!--Conenedor de opciones -->
			<div class = "btn-container">
				<div class = "top-btn">

					<?php
						if(array_key_exists("id", $_SESSION)){
							if($_GET["profile"] != 0 && $_GET["profile"] != $_SESSION["id"]){
								actualState();
							}							
						}
						else{
							actualState();
						}

						function actualState(){
							echo'
								<div class = "btn" id = "current_profile">
									<div class = "circle artistImg" src = "'.$GLOBALS["img"].'"></div>
									<div>'.$GLOBALS["name"].'</div>
								</div> 
							';
						}
					?>					
					<div class = "btn" id= "artists"><i class="flaticon-artists"></i>Ver Artistas</div>
					<div class = "btn" id = "favorites"><i class="flaticon-like-empty"></i>Ranking</div>
					<div class = "btn" id= "home"><i class="flaticon-home"></i>Inicio</div>
				</div>
				<div class = "bottom-btn">
					<?php
					
					if(array_key_exists("id", $_SESSION)){
						echo ' 
						
						<div class = "btn" id = "profile">
							<div class = "circle artistImg" src = "'.$_SESSION["img"].'"></div>
							<div>Mi Perfil</div>
						</div> 
						<div class = "btn" id = "configuration"><i class="flaticon-settings"></i>Configuración</div> 
						<div class = "btn" id = "logout"><i class="flaticon-logout"></i>Cerrar sesión</div>';
					}
					else{
						echo ' 
						<div class = "btn" id = "login"><i class="flaticon-login"></i>Inicia sesión</div>'; 
					} 
					?>
				</div>
			</div>
		</div>
	 
	
		<!--Panel profile-->
		<section class = "left-bar artistImg" src = "<?php echo $GLOBALS["img"]?>"> 
			<div class = "circle artistImg" src = "<?php echo $GLOBALS["img"]?>"></div>
			<div class = "top"></div> 
			<div class = "name" ><?php echo $GLOBALS["name"]?></div> 
			<div class = "country"><?php echo $GLOBALS["country"]?></div>
			<div class = "description"><?php echo $GLOBALS["description"]?></div>
		</section>
		
		
		<!-------------------------------------------------------------------------------------------------->
		
		<!-- Contenedor de VER ARTISTAS -->
		<div class = "artist-container">
			<div class = "inner-container">
				<div class = "letter-wrapper getBackColor">
					<div class = "letter" id = "other">@</div>
					<?php  
						for($i=65; $i<=90; $i++){
							echo '<div class = "letter" id = "'.chr($i).'">'.chr($i).'</div>'; 
						}
					?>  
				</div>
				
				<div class = "artist-wrapper">  
					<div class = "artist-inner-wrapper">
						<?php
							$sql = "SELECT 
									artist_id, 
									artist_name, 
									artist_img
									FROM artist ORDER BY 
									replace(
										replace(artist_name, 'Б', '_')
									, '†', '_')";
							$result = $GLOBALS['con']->query($sql);
							
							//Verifica que haya artistas
							if ($result->num_rows > 0){				 				 
								while($row = $result->fetch_assoc()) {	
									echo '<div class = "artist" id = "artist-'.$row["artist_id"].'">'.
											'<div class = "artistImg circle" src = "'.$row["artist_img"].'"></div>'.
											'<div class = "name"> '.$row["artist_name"].' </div>'.
										 '</div>';
								}
							}
						?> 	 
					</div>	 
				</div>
			</div>
		</div>
		<!------------------------------------------------------------------------------------------------->
		
		<!-- Contenedor FAVORITOS -->
		
		<div class = "favorite-container">
			<div class = "options getBackColor" > Más descargados esta semana</div>
			
			<div class = "favorite-inner-wrapper">
			 
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number getForeColor">1</div>
						<div class = "info">
							<div class = "name">We Slept At Last</div>
							<div class = "artist">Maricka Hackman</div> 
						</div>	
					</div> 
					<div class = "cover" src = "slept.jpg"></div>
				</div>
				
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number">2</div>
						<div class = "info">
							<div class = "name">Vacuum EP</div>
							<div class = "artist">IC3PEAK</div> 
						</div>	
					</div> 
					<div class = "cover" src = "vacuum.jpg"></div>
				</div>
				
				
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number">3</div>
						<div class = "info">
							<div class = "name">King And Them</div>
							<div class = "artist">Evian Christ</div> 
						</div>	
					</div> 
					<div class = "cover" src = "evian.jpg"></div>
				</div>
				
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number">4</div>
						<div class = "info">
							<div class = "name">Bounty</div>
							<div class = "artist">Iamamiwhoami</div> 
						</div>	
					</div> 
					<div class = "cover" src = "bounty.jpg"></div>
				</div>
				
				
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number">5</div>
						<div class = "info">
							<div class = "name">Jenny Death</div>
							<div class = "artist">Death Grips</div> 
						</div>	
					</div> 
					<div class = "cover" src = "money.jpg"></div>
				</div>	 
			</div> 
		</div>
		
		<!-------------------------------------------------------------------------------------------------->
		
		
	 
		<!--Cd container -->
		<section class = "content">		 
			<?php
			/// Subir material
			if(array_key_exists("id", $_SESSION)){
				if($_GET["profile"] == $_SESSION["id"] || $_GET["profile"] == '0'){
					echo ' 
						<form name = "form-songs" enctype="multipart/form-data" id = "form-songs">
							<input type = "file" name = "songs[]" id = "songs" class = "input-songs" accept="audio/*" multiple/>
							<label for = "songs" class = "label-songs getForeColor getBorderColor getBackColorHover" >Subir material</label>
						</form>  
					';
				}
			}
			?> 
			
			<?php 

				echo '<div class = "cd-wrapper">';

				$sql = "SELECT
					al.album_id,				
					al.album_name,
					al.album_cover,
					al.album_description,
					al.album_downloads,
					al.album_year,
					al.album_video
					FROM artist as ar JOIN artist_album as aa ON ar.artist_id = aa.artist_artist_id && ar.artist_id = $id
					JOIN album as al ON aa.album_album_id = al.album_id ORDER BY al.album_year DESC LIMIT 12";   
					//ORDER BY album_id DESC LIMIT 15
					 
				$result = $GLOBALS['con']->query($sql); 

				//Verifica que haya discos en la BD
				if ($result->num_rows > 0){				 				 
					while($row = $result->fetch_assoc()) {
						
					//Obtiene los generos del disco
					$sql2 = "SELECT genre_name FROM album as a INNER JOIN album_genre as ag ON a.album_id = ag.album_album_id INNER JOIN genre as g ON ag.genre_genre_id = g.genre_id";
					$result2 = $GLOBALS['con']->query($sql2);
 
					// Hay contenido 
					  echo '<div class = "cd" idcd = "'.$row["album_id"].'">'.
								'<div class = "cover" src = "'.$row["album_cover"].'">'.
									'<div class = "cover-top"></div>'.
									'<div class = "genre-wrapper"> ';
									
										if ($result2->num_rows > 0)
										{
											while($row2 = $result2->fetch_assoc()) 
											{
												echo '<div class = "genre '.$row2["genre_name"].'">'.$row2["genre_name"].'</div>';
											}
										}
									
								echo '</div>
								</div>';

							echo '<div class = "info">
									<div class = "year">'.$row["album_year"].'</div>
									<div class = "name">'.$row["album_name"].'</div>
									<div class = "artist" idartist = "'.$GLOBALS["id"].'" src = "'.$GLOBALS["img"].'">'.$GLOBALS["name"].'</div>
									<div class = "description">'.$row["album_description"].'</div>
									<div class = "video_url" src = "'.$row["album_video"].'"></div>
									<div class = "tracklist">
										<div class = "cd-songs">';
											$sql5 = "SELECT 
														song_name, 
														song_id,
														song_price,
														song_url,
														song_length,
														song_downloads

													FROM song as s JOIN cd as c 
													ON (s.cd_album_album_id = c.album_album_id && c.album_album_id = ".$row['album_id'].")";
											$result5 = $GLOBALS['con']->query($sql5); 											
											while($row5 = $result5->fetch_assoc()) 
											{
											$precio = ($row5["song_price"] == 0) ? "Gratis":"$ ".$row5["song_price"]." MXN";
											echo '<div class = "song" id = "song-'.$row5["song_id"].'"  price = "'.$precio.'" src = "'.$row5["song_url"].'">'.$row5["song_name"].'</div>';
											}

										echo '</div>'.
									'</div>';

									$sql4 = "SELECT c.cd_price FROM cd as c JOIN album as a 
											ON c.album_album_id = a.album_id && a.album_id = ".$row["album_id"]."";
									$result4 = $GLOBALS['con']->query($sql4); 
									$row4 = $result4->fetch_assoc();
									$precio = ($row4["cd_price"] == 0) ? "GRATIS":"$ ".$row4["cd_price"]." MXN";
								echo '<div class = "price">'.$precio.'</div>
								</div>
							</div>';
								
					}
				}
				else{
						if(array_key_exists("id", $_SESSION)){
					 		if($_GET["profile"] == $_SESSION["id"] || $_GET["profile"] == '0'){
							echo '<div class = "no-cds"> No tienes material, ¿que tal si subes algunos discos?</div>';
						}
					}
				}

			echo '</div>';

			?> 
			
				
	 		<!-------------------------------------------------------------------------------------------------->
			
	 		

			<!-- Ventana para subir material -->
			<div class = "submit-material-wrapper">
				<div class = "submit-material-window">
					<div class = "loader-wrapper">
					    <div class ="loader"></div> 
					</div>
				</div>
			</div>

			<div class = "loader-wrapper">
			    <div class = "loader"></div> 
			</div>

			<!-------------------------------------------------------------------------------------------------->
		

			<!-- Artistas recomendados -->
			<div class = "artist-wrapper2">
				<h1 class = "getForeColor">Artistas Recomendados </h1>  
				
				<div class = "artist-inner-wrapper">
				
				<?php
					$sql = "SELECT 
							artist_id, 
							artist_name, 
							artist_img
							FROM artist 
							WHERE artist_id <> $id
							ORDER BY RAND() LIMIT 3";
					$result = $GLOBALS['con']->query($sql);
					
					//Verifica que haya artistas
					if ($result->num_rows > 0){				 				 
						while($row = $result->fetch_assoc()) {	
							echo '<div class = "artist" id = "artist-'.$row["artist_id"].'">'.
									'<div class = "artistImg circle" src = "'.$row["artist_img"].'"></div>'.
									'<div class = "name"> '.$row["artist_name"].' </div>'.
								 '</div>';
						}
					}
				?> 	  
				</div>
			</div>
	 		
	 	<!-------------------------------------------------------------------------------------------------->
		
		<!-- Visor de entradas -->
		<div class = "viewer"> 
			<div class = "viewer-container">
			 
			 
				<!-- Botones de navegación -->
				<div class = "close getBackColorHoverBlack">
					<span class="flaticon-cancel"></span>
				</div>				
				<div class = "reduce getBackColorHoverBlack">
					<span class="flaticon-reduce"></span>
				</div> 
				<div class = "expand getBackColor">
					<span class="flaticon-expand"></span>
				</div>
				
				<!-- Contenedor de la portada del CD -->
				<div class = "cover-container">
					<div class = "cover"></div>
				</div> 
				
				<!-- COntenedor de la información del CD -->
				<div class = "info-container">
				
					<div class = "top-section"> 
						<div class = "genre-wrapper"></div>						
					</div>
					
					
					<div class = "main-section">
						<div class = "artist-circle"></div>
						<div class = "info"> 
								<div class = "cd-name"></div>
								<div class = "artist-name getForeColor">
									<div class = "text"></div> 
								</div>  
						</div>
						<div class = "description"></div>
					</div>
					
					<div class = "bottom-section">
						<div class = "controls">
							<div class = "artist-btn"></div>
							<div class = "video-btn getForeColorHover"><span class = "flaticon-video"></span></div>
							<div class = "tracklist-btn ">
								<span class = "flaticon-tracklist getForeColorHover"></span> 
								
								<!-- Contenedor del popup de tracklist -->
								<div class = "tracklist-popup"> 
									<div class = "tracklist-container"></div>
								</div>							
							</div>
							<div class = "buy-btn getBackColor"></div>
						</div>
					</div>
				</div>
				
				<!-- Contenedor del video del CD -->
				<div class = "video-container">					
				</div>
				 
			</div>
		</div>
		<!--Fin del Visor de entradas -->

				
			
		</section>
	
	</body>
</html>