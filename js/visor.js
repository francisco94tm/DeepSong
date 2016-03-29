	
	$(function(){	 
	

		//Consigue la direccion de las canciones
		var url_songs = [];
		var cdname;
		var idcd;
		var idartist;
		

		function addVideo(){		
			//Inserta video de youtube 
			$(".video").each(function(){
				var url_video = $(".video").attr("src");		
				$(this).html(
					"<iframe width='600' height='100' src='https://www.youtube.com/embed/"+url_video+"?rel=0&amp;showinfo=0&amp;theme=light&amp;color=white&amp;autoplay=1' frameborder='0' allowfullscreen></iframe>"
				);
			});
		}
  
		$(window).resize(function(){
			setSizeVideo(400);
		}); 
		
		$(".viewer").hide();
		$(".viewer-container").addClass("viewer-container1");
		$(".close").addClass("close1");
	
		//Abrir visor ----------------------------------------------------------------------------------------------------------------------------------------------------
		$(".cd-wrapper .cd").click(function(){ 
			 
			/************* CONSIGUE VALORES ***********************************/
		
				 //Consigue portada del disco
				 var cover = "img/cd-cover/" + $(this).find(".cover").attr("src");
				 
				 //Consigue nombre del disco
				 cdname = $(this).find(".name").text();
				 
				 //Consigue nombre del artista
				 var artistname = $(this).find(".artist").text();
				 
				 //consigue imagen del artista
				 var artistimg = "img/artist/" +$(this).find(".artist").attr("src");   
				 
				 //Consigue descripción del CD
				 var description = $(this).find(".description").text(); 
				 
				 //Consigue url del video
				 var video = $(this).find(".video_url").attr("src"); 
			  
				//Consigue el tracklist
				var tracklist = $(this).find(".tracklist");

				//Consigue el precio del disco
				var price = $(this).find(".price").text(); 
				
				//Consigue el id del CD
				idcd = $(this).attr("idcd");  

				//Consigue el id del artista del CD
				idartist = $(this).find(".artist").attr("idartist");   

				//COnsigue las canciones del album 
				/**Analiza cada CD**/
				 $(this).find(".cd-songs").each(function(ncd, elementcd){
					  
					 $(".viewer .tracklist-container").append("<div class = 'tracklist-cd'></div>");
					 
					/**Analiza las canciones de cada CD**/
					 $(this).find(".song").each(function(nsong, elementsong){  
						$(".viewer .tracklist-container .tracklist-cd").append('<div class = "song"><div class = "number getForeColor">'+(nsong+1)+'</div><div class = "name">'+elementsong.innerHTML+'</div></div>');
						url_songs.push($(this).attr("src"));
					});
					 
				});
				 
			  
			/************* AGREGA VALORES *************************************/
					
				// Agrega los géneros.
				$(".viewer .genre-wrapper").append('<div class = "outline"></div>');			 
				$.each($(this).find(".genre"),function(index, value){	 
					$(".viewer .genre-wrapper .outline").append("<div class = 'genre "+value.className.substring(6)+"'>"+value.innerHTML+"</div>"); 
				 	
				 }); 
				  
				//Agrega portada del disco  
				$(".cover-container .cover").css("background-image","url(" + cover + ")");  
			 
				//Agrega nombre del artista
				$(".viewer .artist-name .text").html(artistname);
				$(".viewer .artist-name-tooltip").html(artistname);
					
				//Agrega descripción del CD
				$(".viewer .description").html(description);

				//Agrega boton de compra
				$(".viewer .buy-btn").text(price);

				//Agrega nombre del CD
				$(".viewer .cd-name").html(cdname);

				//Consigue el valor principal de la portada
				getImgColor(cover);
			
			    //Consigue la imagen del artista
				$(".viewer .artist-circle").css("background-image","url("+artistimg+")");
				$(".viewer .artist-tooltip  .img-container").css("background-image","url("+artistimg+")"); 
				 
				 
						/**Obtiene la posicion del cursor**/
						function getPos(){ 
							$(".artist-tooltip").css("margin-left",($(".viewer .artist-name").width()/2) - 75); 
						}
				 
				
						setTimeout(function(){					 
							$(".viewer .img-container").height($(".tooltip-subcontainer").height());
							$(".viewer .img-container-top").height($(".tooltip-subcontainer").height());
						}, 300);
				 
				  
			//Abrir y reproducir video si se presiona el boton del video
			$(".video-btn").click(function(){	
				$(".tracklist-container .tracklist-cd").removeClass("tracklist-animation");	
				$(".tracklist-popup").hide();
				$(".viewer .video-container").html("<div class = 'video' src = '"+video+"'></div>");  
				showBigVideo();				
				addVideo();	 
				
			});
			 
			 
			//Reducir tamaño del video si se da clic en el boton reduce-video
			$(".reduce").click(function(){
				$(".tracklist-container .tracklist-cd").removeClass("tracklist-animation");	
				$(".tracklist-popup").hide();
				showLittleVideo();		
			});
			
			
			//Expandir video si se da clic en boton expand-video
			$(".expand").click(function(){
				$(".tracklist-container .tracklist-cd").removeClass("tracklist-animation");	
				$(".tracklist-popup").hide();
				showBigVideo();				 
			});
			
			$(".viewer .tracklist-btn").click(function(){ 				
				$(".tracklist-popup").show();
				setTimeout(function(){
					$(".tracklist-container .tracklist-cd").addClass("tracklist-animation");					
				},50);
			}); 
			 
			$(".viewer").fadeTo(300, 1.0);   
			$("body").addClass("stop-scrolling");   
			$(".viewer .main-section").scrollTop(0);   
			 
			 
		});
		 
		
		

		function close_viewer(){

			url_songs = [];
			idcd = "";
			$(".viewer").fadeTo(300, 0);  
			$(".viewer .video").remove();
			$(".viewer .outline").remove();
			$("img#test").remove();
			$(".tracklist-popup").hide();
			$(".tracklist-container .tracklist-cd").removeClass("tracklist-animation");
			$(".viewer .tracklist-container .tracklist-cd").remove(); 
			
			setTimeout(function(){
				
				$(".viewer .viewer-container").addClass("viewer-container1").removeClass("viewer-container2"); 
				$(".viewer .video-container").removeClass("video-container-min");  
				$(".close").removeClass("close2").addClass("close1");				
				$(".viewer-container .reduce").hide();
				$(".viewer-container .expand").hide();
				$(".viewer").hide(); 
				 
				$(".info-container").show();
				$(".cover-container").show();
				$(".video-container").hide();
				$(".video-btn").show(); 
				
			},300); 
			$("body").removeClass("stop-scrolling");   
		}

		//Cerrar visor ----------------------------------------------------------------------------------------------------------------------------------------------------
		$(".viewer .close").click(function(){
			close_viewer();
		}); 

		
	  	/*cerrar menu si se da clic fuera de foco*/
		$(document).on('click', function (e) {   
			//Verificar que el menu este abierto

			if($(".viewer").css("display")!="none"){   
				//Se da clic fuera del menu
				if ($(e.target).closest($(".viewer-container")).length === 0 &&
					$(e.target).closest($(".viewer-container .close")).length === 0 &&
					$(e.target).closest($(".cd-wrapper .cd")).length === 0){ 				 
					close_viewer();
					//alert();
				}
			}
		});

		//Muestra visor pequeño
		function showLittleVideo(){ 
			$(".viewer .video-container").addClass("video-container-min"); 			
				 
			/**Muestra el boton para expandir video**/
			$(".expand").show();
			$(".info-container").show();
			$(".cover-container").show();
			$(".viewer-container .reduce").fadeOut(300);
			$(".viewer .viewer-container").addClass("viewer-container1").removeClass("viewer-container2");
			$(".close").removeClass("close2").addClass("close1"); 				
			$(".video-btn").hide(); 
		}
		
		
		
		//Muestra visor grandre
		function showBigVideo(){ 
		  
			$(".viewer .viewer-container").removeClass("viewer-container1").addClass("viewer-container2");
			$(".close").addClass("close2").removeClass("close1");
			$(".viewer-container .reduce").show();	
			$(".expand").hide();
			$(".viewer .video-container").addClass("video-left");  	 
			$(".viewer .video-container").removeClass("video-container-min");  	  
			$(".info-container").fadeOut(300);
			$(".cover-container").fadeOut(300);
			$(".video-container").fadeIn(300);
			
		}
		
		 
		 
		//Cambia el tamaño de los componentes si la ventana cambia de tamaño
		$(window).resize(function(){	 
			if(window.matchMedia("screen and (max-width: 900px)").matches){  
				$(".viewer-container").width($(window).width());
				$(".viewer .main-content").width($(window).width());
			}
			else		
				$(".viewer-container").width($(window).width()*0.9);
				setTimeout(function(){
				$(".viewer .main-content").width( $(window).width()*0.9 - $(window).height()*0.9);
				},50);
		});
		 
		
		$(".buy-btn").click(function(){  

			//$("body").css("cursor","progress");

			$.ajax({
				url: "php/zipFiles.php", 
				type: "POST",             
				data: 
				{
					album: 		cdname,
					idcd:    	idcd,
					idartist: 	idartist,
					files: 		JSON.stringify(url_songs)
				},  
				success: function(data) 
				{     				
					$("body").append(data);
					close_viewer();
				},
				error: function (request, status, error) {
        			$(body).append(request.responseText);
				}
			}); 		

		});
	});