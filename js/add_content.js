$(function(){
	
	 
	function updateCover(){
		//Agrega caratula a cada CD
		$(".cover").each(function(){
			var url_cover = "img/cd-cover/" + $(this).attr("src"); 
			$(this).css("background-image","url(" + url_cover + ")"); 
		});
	}
	
	//Agrega imagen de artista
	$(".artistImg").each(function(){
 
		var url_cover = "img/artist/" + $(this).attr("src");   
		$(this).css("background-image","url(" + url_cover + ")"); 
	});
	 
	updateCover();
	
});