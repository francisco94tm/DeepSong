<?php session_start();
	
	header('Content-Type: text/html; charset=UTF-8');  
	if(isset($_POST['files'])){
		
		$files	 = json_decode($_POST['files']); 
		$zipname = $_POST["album"];
		$idcd	 = $_POST["idcd"];
		$idartist= $_POST["idartist"];

		$zipname = str_replace(" ","_", $zipname); 		
		$zipname = str_replace(")","_", $zipname); 
		$zipname = str_replace("(","_", $zipname); 		
		$zipname = str_replace("'","", $zipname); 
		$zipname = str_replace("","", $zipname); 
		$zipname = str_replace("[","_", $zipname); 
		$zipname = str_replace("]","_", $zipname); 
		$zipname = filter_var( $zipname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH ).".zip";
    	
		$path = "../songs/".$idartist."/".$idcd."/";

		$zip = new ZipArchive;
		$zip -> open($zipname, ZipArchive::CREATE);

		foreach ($files as $file) { 
		  $zip -> addFile($path.$file, "../".$file); 
		}

		$zip->close();

		copy($zipname, "../zip/".$zipname);
		unlink($zipname); 

		return $zipname;
	}

?>