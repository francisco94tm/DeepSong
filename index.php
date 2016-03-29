
<?php session_start();	
	require_once 'php\connection.php'; 	
?>

<!DOCTYPE html> 
<html>
	<head>	
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title> Crema de Elote	</title>
		
		<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">		
		<link rel="stylesheet" type="text/css" href="css/index.css">	 
		<link rel="stylesheet" type="text/css" href="css/navbar.css">
			
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,900' rel='stylesheet' type='text/css'> 
		  
 		
		<script type = "text/javascript" src = "js/jquery-1.11.3.js"></script> 	
		<!--<script src = "js/setCDSize.js"></script>-->
		<script src = "js/default.js"></script>		
		<script src = "js/add_content.js"></script>
		<script src = "js/visor.js"></script>
		<script src = "js/navbarInteraction.js"></script> 		
		<script src = "js/getColor.js"></script>  
		<script src = "js/setColor.js"></script>
		<script src = "js/imageAnalysis.js"></script> 

		<script>
		$(function(){
			$(".btn").removeClass("selected_btn");
			$("#home").addClass("selected_btn"); 			
		});
		</script>
			
	</head>
	<body>
		<!-------------------------------------------------------------------------------------------------->
				
		<!--Barra de navegación -->
		<div class = "navbar"> 
			<div class = "navbar-wrapper"> 				
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
		<div class = "side-menu"> 		

			<div class = "top"></div>
			<!--Boton para cerrar Menu -->
			<div class = "close-btn"><i class="flaticon-cancel"></i></div>		
			
			<!--Conenedor de opciones -->
			<div class = "btn-container">
				<div class = "top-btn">					
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
		
		<!-------------------------------------------------------------------------------------------------->
		
		
		<!--Cover principal con artistas nuevos -->
		<div class = "main-cover">
			<div class = "cover-img"></div> 
			<div class = "top"></div> 
			
			<!--COntenedor de artistas nuevos -->
			<div class = "artist-wrapper">
				<h1>Nuevos Artistas </h1>  
				
				<div class = "artist-inner-wrapper">				
					<?php
						$sql = "SELECT 
								artist_id, 
								artist_name, 
								artist_img
								FROM artist ORDER BY artist_id DESC LIMIT 3";
						$result = $GLOBALS['con']->query($sql);
						
						//Verifica que haya artistas
						if ($result->num_rows > 0)				 				 
							while($row = $result->fetch_assoc()) {	
								echo '<div class = "artist" id = "artist-'.$row["artist_id"].'">'.
										'<div class = "artistImg circle" src = "'.$row["artist_img"].'"></div>'.
										'<div class = "name"> '.$row["artist_name"].' </div>'.
									 '</div>';
							} 
					?>  
				</div>
				
			</div>
		</div>
		
		
		
		<!-------------------------------------------------------------------------------------------------->
		
		<!-- Contenedor de VER ARTISTAS -->
		<div class = "artist-container">
			<div class = "inner-container">
				<div class = "letter-wrapper">
					
					<?php  
						for($i=65; $i<=90; $i++){
							echo '<div class = "letter" id = "'.chr($i).'">'.chr($i).'</div>'; 
						}
					?>  
					<div class = "letter" id = "other">@</div>
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
							if ($result->num_rows > 0)				 				 
								while($row = $result->fetch_assoc()) {	
									echo '<div class = "artist" id = "artist-'.$row["artist_id"].'">'.
											'<div class = "artistImg circle" src = "'.$row["artist_img"].'"></div>'.
											'<div class = "name"> '.$row["artist_name"].' </div>'.
										 '</div>';
								} 
						?>  
					</div>	 
				</div>
			</div>
		</div>
		<!------------------------------------------------------------------------------------------------->
		
		<!-- Contenedor FAVORITOS -->
		
		<div class = "favorite-container">
			<div class = "options"> Más descargados esta semana</div>
			
			<div class = "favorite-inner-wrapper">
			 
				<!-- Favorito -->
				<div class = "favorite"> 
					<div class = "cd">								
						<div class = "number">1</div>
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
		
		<!-- Contenido principal -->	 
		<div class = "content">
		 
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
					FROM album as al  
					ORDER BY al.album_id   
					DESC LIMIT 15";
					 
				$result = $GLOBALS['con']->query($sql); 

				//Verifica que haya discos del artista
				if ($result->num_rows > 0){				 				 
					while($row = $result->fetch_assoc()) {
						
					//Obtiene los generos del disco
					$sql2 = "SELECT genre_name FROM album as a INNER JOIN album_genre as ag ON a.album_id = ag.album_album_id INNER JOIN genre as g ON ag.genre_genre_id = g.genre_id";
					$result2 = $GLOBALS['con']->query($sql2);

					$sql3 = "SELECT 
						ar.artist_id,
						ar.artist_name,
						ar.artist_img 
						FROM artist as ar
						JOIN artist_album as aa ON ar.artist_id = aa.artist_artist_id
						JOIN album as al ON (aa.album_album_id = al.album_id && al.album_id = ".$row['album_id'].")";
 					$result3 = $GLOBALS['con']->query($sql3);
 					$row3 = $result3->fetch_assoc();

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
									
							echo '</div>'.
								'</div>';

							echo '<div class = "info">
									<div class = "year">'.$row["album_year"].'</div>
									<div class = "name">'.$row["album_name"].'</div>									
									<div class = "artist" idartist = "'.$row3["artist_id"].'" src = "'.$row3["artist_img"].'">'.$row3["artist_name"].'</div>
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
											echo '<div class = "song" id = "song-'.$row5["song_id"].'"  price = "'.$row5["song_price"].'" src = "'.$row5["song_url"].'">'.$row5["song_name"].'</div>';
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
							echo '<div class = "no-cds"> :C </div>';
					 
					
				}

			echo '</div>';

			?> 
			
			<div class = "loadMore-wrapper">
				<div class = "loadMore">Cargar más</div>				
			</div>
			
		</div>
		<!--- fin contenedor principal -->
	
	
	
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
			 
	</body>
</html>