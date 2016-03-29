		//Agrega el color extraido de la portada a los componentes
		function setColors(rgb){
			
			//Consigue el fondo del color obtenido 
			$(".getBackColor").css("background-color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");

			//Consigue el color de texto del color obtenido
			$(".getForeColor").css("color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");				

			//Consigue el color de los bordes del color obtenido
			$(".getBorderColor").css("border","solid 1px "+"rgb("+rgb.r+","+rgb.g+","+rgb.b+")");

			//Consigue el color de la letra en efecto Hover
			$(".getForeColorHover").hover(function(){
					$(this).css("color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
				},function(){
					$(this).css("color","#888");
				}				
			);
			
			//Consigue el color del fondo en efecto Hover
			$(".getBackColorHover").hover(function(){
					$(this).css("background-color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
				},function(){
					$(this).css("background-color","transparent");
				}				
			);

			//Consigue el color del fondo en efecto Hover
			$(".getBackColorHoverBlack").hover(function(){
					$(this).css("background-color","rgb("+rgb.r+","+rgb.g+","+rgb.b+")");
				},function(){
					$(this).css("background-color","rgba(50,50,50,0.8)");
				}				
			);
		}