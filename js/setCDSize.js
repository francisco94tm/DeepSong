$(function(){
	
	adjustCDsize();  
	
	 //Acciones realizadas al redimensionar ventana
	 $(window).resize(function(){		
		adjustCDsize();  
		
	}); 	
		
	//Ajustar el tamaño de los CDs al ancho de la ventana
	 function adjustCDsize(){
		 		
		var percentContainer = 0.9; 
		var altoDescripcion = 80;
		var spacebetweenCDs = 30;
		 
		
		var wrapper_width = Math.round(($(window).width() - spacebetweenCDs) * percentContainer * 100) / 100; //Tamaño del contenedor de CDs
		$(".cd-wrapper .cd").width(250);
		$(".cd-wrapper .cd").height($(".cd-wrapper .cd").width() + altoDescripcion) //Ajusta el alto del CD 
		 
		 
		var cd_width = $(".cd-wrapper .cd").width()+spacebetweenCDs;	//Ancho de cada CD	 
		var num_cds = Math.floor(wrapper_width/cd_width); //Numero de CDs en cada fila del contenedor		
		var wasted_space_per_cd = (Math.round((wrapper_width - (num_cds * cd_width))* 100 * percentContainer) / 100) / num_cds; //Espacio desperdiciado en en contenedor
		 
		$(".cd-wrapper .cd").width( $(".cd-wrapper .cd").width() + wasted_space_per_cd);
		$(".cd-wrapper .cd").height( $(".cd-wrapper .cd").height() + wasted_space_per_cd) //Ajusta el alto del CD 
		
	 }
});