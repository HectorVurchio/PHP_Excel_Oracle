<?php
	/*
		print_r($fields);
		foreach($files as $key => $value){
			print_r($key);
		}
		*/
		
	//what is its name
	foreach($files["name"] as $name){
		$target_file = "{$target_dir}/{$name}";
		// has the file an xlsx extension
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType == "xlsx"){
			//echo " The file {$name} meet the Extension Requirements. \n";
			$flag = true;
		}else{
			$flag = false;
			echo " The File {$name} Do Not Comply. \n";
			http_response_code(404);
			break;
		}
		// Check if any file already exists
		/*
		if (file_exists($target_file)) {
			echo " Sorry, file {$name} already exists. \n";
		}else{
			echo " Go Ahead with {$name}. \n";
		}
		*/
	}
	/*
	//What is its type
	foreach($files["type"] as $type){
		echo $type."\n";
	}
	//what is its size
	foreach($files["size"] as $size){
		echo $size."\n";
	}
    */
?>