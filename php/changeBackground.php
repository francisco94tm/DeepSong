<?php

	header("Content-Type: text/html;charset=utf-8");
	
	$directorio = "img/artist";   
	$cover = scandir ($directorio);
	do{
		$imgToPick = $cover[mt_rand(0,sizeof($cover)-1)];
	}while($imgToPick == '.' or $imgToPick == '..' or $imgToPick == 'default.jpg');
	
	echo '
		<style>
		body{
			background-image: linear-gradient(rgba(0,0,0, 0.3), rgba(0, 0, 0, 0.3)), url('.$directorio.'/'.$imgToPick.');	 
		}
	';
?> 

