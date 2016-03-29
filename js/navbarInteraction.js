$(function(){
	  
	
	$(".artist-container").hide();
	$(".favorite-container").hide();
	
	// Accion al presionar boton de la sidebar
		$(".side-menu .btn").click(function(){
			 $(".close-btn").click(); 
			 
			 $(".btn").removeClass("selected_btn");
			 $(this).addClass("selected_btn");
			 
			 /**  Boton artistas **/
			 if($(this).is($("#artists"))){  
				 setTimeout(function(){
					$(".artist-container").show();
					$(".favorite-container").hide();
				 },500);
			 }
			 
			  /**  Boton favoritos **/
			 else  if($(this).is($("#favorites"))){  
				 setTimeout(function(){
					$(".favorite-container").show();
					$(".artist-container").hide();
					
				 },500);
			 }
			 
			 /** Boton Home **/
			 else if($(this).is($("#home"))){  
				 setTimeout(function(){
					$(".artist-container").hide();
					$(".favorite-container").hide();
					window.location.href = "index.php";
				 },500);
			 }
			 
			 else if($(this).is($("#logout"))){  
				 setTimeout(function(){
					window.location.replace("php/logout.php");
				 },500);
			 }
			 
			 else if($(this).is($("#login"))){  
				 setTimeout(function(){
					window.location.replace("login.php");
				 },500);
			 }
			 
			 else if($(this).is($("#profile"))){  
				 setTimeout(function(){
					window.location.href = "artist.php?profile=0";
				 },500);
			 }

			  else if($(this).is($("#current_profile"))){  
				 setTimeout(function(){
					$(".artist-container").hide();
					$(".favorite-container").hide();
				 },500);
			 }
			 
		});
		 
		//Accion al presionar letra del menu de artistas
		$(".letter").click(function(){
			$(".letter").removeClass("selectLetter");
			$(this).addClass("selectLetter");  
		});  

	//Side menu ****************************************************************************+
	$(".navbar-wrapper .menu").click(function(){		 
		$(".side-menu").addClass("expand_menu");
		$("body").addClass("body_expand_menu"); 
		$(".artist-container").addClass("body_expand_menu"); 
		$(".favorite-container").addClass("body_expand_menu"); 
		$(".navbar-wrapper").addClass("navbar_expand_menu");
		
	});
	
	$(".close-btn").click(function(){		 
		$(".side-menu").removeClass("expand_menu");
		$("body").removeClass("body_expand_menu"); 
		$(".navbar-wrapper").removeClass("navbar_expand_menu");
		$(".artist-container").removeClass("body_expand_menu"); 
		$(".favorite-container").removeClass("body_expand_menu"); 
	});
	
	/*cerrar menu si se da clic fuera de foco*/
	$(document).on('click', function (e) {   
		//Verificar que el menu este abierto
		if($(".side-menu").hasClass("expand_menu")){  
			//Se da clic fuera del menu
			if ($(e.target).closest($(".side-menu")).length === 0 && $(e.target).closest($(".navbar-wrapper .menu")).length === 0){ 				 
				$(".close-btn").click();	
			}
		}
	});
	
	
	//ir hacia perfil
	$("div[id |= artist]").click(function(){ 
		var id = $(this).attr("id").replace("artist-", ""); 
		window.location.href = "artist.php?profile=" + id;		
	});
	
	$("#profile").click(function(){
		window.location.href = "artist.php?profile=0";
	});
	
	
	
});