$(function(){
	
	addImg();
	
	function addImg(){
		 
		//Agrega al DOM el child "img"
		var artist_img = "img/artist/"+$(".left-bar .circle").attr("src");
		setColors(getImgColor(artist_img));
	}
});	