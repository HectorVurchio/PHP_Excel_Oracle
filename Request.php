<?php  
class Request {
public $method;
public $uri;
public $protocolo;

	function __construct(){
		$this->paramServer();
	}

    private function paramServer(){

		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->protocolo = $_SERVER['SERVER_PROTOCOL'];
    }
	
	public function excelFiles(){
		$files = $_FILES["files"];
		$fields = json_decode($_POST["fields"]);
		$target_dir = "{$_SERVER['DOCUMENT_ROOT']}/uploads";
		$flag = true;
		require_once $_SERVER['DOCUMENT_ROOT']."/Backend/file_check.php";
		require_once $_SERVER['DOCUMENT_ROOT']."/Backend/POST/add_test_files.php";
		require_once $_SERVER['DOCUMENT_ROOT']."/Backend/save_files.php";
		
	}
	
}
?>