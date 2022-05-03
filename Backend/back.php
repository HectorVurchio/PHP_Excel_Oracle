<?php

//how long is the url?
$url_path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$path_arr = explode('/',$url_path);
$url_length = count($path_arr);
//has parameters? 
$param = explode('?',$_SERVER['REQUEST_URI']);


switch($url_length){
	case 2:
		if(isset($param[1])){ //   http://localhost/events?_limit=2&_page=1
			include_once 'GET/get_three_param.php';
		}else{
			
		}
	break;
	case 3:
		if(isset($param[1])){ // has param   http://localhost/events/123?_limit=2&_page=1
			Header('HTTP/1.1 404 Not Found');
		}else{ //no param   http://localhost/events/123
			require_once 'GET/get_three.php';
		}
	break;
	default:
		$table = "";
	break;
		//Header('HTTP/1.1 404 Not Found');
	
}

?>