$(window).load(function(){
	$(function() { 
		
		
		var img = null;
		var path = "img/artist/temp/";
		
		// Change pic dynamicly --------------------------------------------------------------
		
		$('#form-file').change(function(e){			
			e.preventDefault();
			
			var fd = new FormData(this); 
			
			$.ajax({
				url: "php/modifyInfo.php?function=select", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: fd, // Data sent to server, a set of key/value pairs (i.e. form fields and values) 
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{     				
					img = data;
					$(".img-card").css("background-image","url("+path+img+")");
					$(".img-card").addClass("withImg");
					$(".cover").css("background-image","url("+path+img+")");
					$(".cover-top").addClass("cover-top-withImg"); 
					$(".header").css("background-color","#555"); 	 
				}
			}); 			 
		});

		// Send info from form --------------------------------------------------------------
		
		$("#send").click(function(){ 
		 
			var description = $("#description").val();
			var country = $("#country").val();
			
			if(country == null){ 
				$('html,body').animate({
					scrollTop: $("#country").offset().top - 150
				}, 500);
				return;
			}
			
			if(img == null){ 
				$('html,body').animate({
					scrollTop: $("#form-file").offset().top - 150
				}, 500);
				return;
			} 
			
			$.ajax({
				url: "php/modifyInfo.php?function=upload", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: {
					img: img,
					description: description,
					country: country 					
				}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)  
				cache: false,             // To unable request pages to be cached 
				success: function(data)   // A function to be called if request succeeds				     
				{
					$("body").append(data);
					window.location.replace("artist.php?profile=0");
				}
			}); 
			
		 });
		

			
	});
});