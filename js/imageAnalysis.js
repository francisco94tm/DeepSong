  
		//Consigue el color principal de la portada
		function getImgColor(cover){ 
			
			$("body").append("<img id = 'test' src = '"+cover+"'/>");		
			$("img#test").on('load', function(){  
				var rgb = getAverageRGB(document.getElementById('test'));
				
				if(isTooLight(rgb)){
					rgb = ColorLuminance(rgb,-0.3);
				}
 
				setColors(rgb);
				
			});
		}
		
		
		//Detecta si el color extraido de la portada no es muy claro{
		function isTooLight(rgb){
			var r = parseInt(rgb.r,10);
			var g = parseInt(rgb.g,10);
			var b = parseInt(rgb.b,10);	 
			var yiq = ((r*299)+(g*587)+(b*114))/1000; 	  
			return yiq >= 170;
		} 
		
		//Obscurece o aclara el color extraido de la portada
		function ColorLuminance(rgb, lum) {
			 
			var r = parseInt(rgb.r,10).toString(16).toUpperCase();;
			var g = parseInt(rgb.g,10).toString(16).toUpperCase();;
			var b = parseInt(rgb.b,10).toString(16).toUpperCase();; 
			 
			
			hex = "#"+r+g+b; 
			
			/**validate hex string*/
			hex = String(hex).replace(/[^0-9a-f]/gi, '');
			if (hex.length < 6) {
				hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
			}
			lum = lum || 0;
			/** convert to decimal and change luminosity **/
			var rgb_alt = "#", c, i;
			for (i = 0; i < 3; i++) {
				c = parseInt(hex.substr(i*2,2), 16);
				c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
				rgb_alt += ("00"+c).substr(c.length);
			}
			 
			
			rgb.r = parseInt(rgb_alt.slice(1,-4),16);
			rgb.g = parseInt(rgb_alt.slice(3,-2),16);
			rgb.b = parseInt(rgb_alt.slice(5),16);   
			
			return rgb;
		} 