$(function(){
	
	$(window).on('beforeunload', function() {
		 $(window).scrollTop(0);
	});
	
	$(".viewer").hide(); 
	 
	
	var animation = false; /** Trigger de la animación **/
	var windowH = $(window).height(); /**Altura de la ventana */
	 
	$(".content").addClass("content1");
	
	 //Opciones accionadas mediante scroll 	   
	$(window).scroll(function(){ 		
		if(!animation)
			notBegginning(); 
	});
	 
	 $(".nav-buttons .btn").click(function(){
		 if(!animation){
			 notBegginning();
		 }
	 });
	  
	  
	 //Reducir tamaño de barra de navegación
	 function notBegginning(){
		$(window).scrollTop(0);		 
		$(".content").addClass("content2").removeClass("content1");
		animation = true;
	 }
	
	
	//Cover main page
	var cover_url = "img/artist/" + $(".main-cover .artist:nth-child(2) .circle").attr("src"); 
	$(".main-cover .cover-img").css("background-image","url("+cover_url+")"); 
	 
	
});