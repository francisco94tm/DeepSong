
$(function(){


	
	$(".content").width($(window).width() - 300);
	$(".content").css("min-width",$(window).width() - 300);

	$(window).resize(function(){
		$(".content").width($(window).width() - 300);
		$(".content").css("min-width",$(window).width() - 300);
	});

	//Subir canciones mediante AJAX una vez que se hallan seleccionado 
	$("#form-songs").change(function(e){
 
		//if (this.files) { //Verifica que se hallan seleccionado archivos
		e.preventDefault(); 
		$(".submit-material-wrapper").show(); //Muestra el panel de subida

	  	var fd = new FormData(this); //Crear FormData para enviar datos mediante AJAX  

		$.ajax({
			url: "php/uploadSongs.php?function=select",  //Direccion a enviar la informacion
			type: "POST",           //Protocolo usado
			data: fd,  			    //Datos a enviar
			cache: false,     
			contentType: false,         
			processData:false,    
			success: function(data)    
			{     				
				$(".submit-material-window").html(data); 
			}
		});   
	//}
	}); 


	

});
