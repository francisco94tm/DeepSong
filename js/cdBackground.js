$(function(){
	
	addImg();
	
	function addImg(){
		  
		 
		$(".cd-wrapper .cd").each(function(index){
			//Agrega al DOM el child "img"
			var cover_img = "img/cd-cover/"+$(this).find(".cover").attr("src");			
			var id_img = "test-"+index;
			
			
			$(this).find(".info").append("<img id = '"+id_img+"' src = '"+cover_img+"'/>"); 
			
			var rgb;
			
			$("#"+id_img).on('load', function(){ 
				rgb = getAverageRGB(document.getElementById(id_img));  
				$(this).parent().css("background-color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
			}); 
		});
		
	}
});	