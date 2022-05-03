<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Expose-Headers: *');
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: -1"); // Date in the past

require_once 'Request.php';
require_once 'Router.php';
$request = new Request();
$router = new Router($request);

$request_method = $_SERVER['REQUEST_METHOD'];
if(strtoupper($request_method) == 'GET'){
	$router->get($_SERVER['REQUEST_URI'],function(){
		require_once 'Backend/back.php';	
	});
}

if(strtoupper($request_method) == 'POST'){
	$router->post('/excel-files',function($request){
		$request->excelFiles();
	});
}


?>