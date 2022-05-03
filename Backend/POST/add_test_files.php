<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/Crud_Oracle.php';

$db = new DataBase();
$crud = new Crud_Oracle($db);
date_default_timezone_set("America/New_York");
$date_time = date("Y-m-d h:m:s");
$sequence = 0;
if($flag){
	$query = "SELECT RAWTOHEX(id) FROM upload";
	if($crud->singleRead($query)){
		$sequence = count($crud->getRecordSet()[0]);
	}else{
		$flag = false;
	}
}


if($flag){
/*********************************************************************************************/	
    $json_vals = "'{
					\"id\"               : \"{$sequence}\",
					\"prefix\"           : \"{$fields->{"prefix"}}\", 
				    \"machine_name\"     : \"{$fields->{"macnam"}}\", 
				    \"test_number\"      : \"{$fields->{"Testnumb"}}\", 
				    \"start_phase\"      : \"{$fields->{"start-phase"}}\", 
				    \"end_phase\"        : \"{$fields->{"end-phase"}}\", 
				    \"start_stroke\"     : \"{$fields->{"start-stroke"}}\", 
				    \"end_stroke\"       : \"{$fields->{"end-stroke"}}\",
				    \"bioethanol\"       : \"{$fields->{"hydrous-bioethanol"}}\",
				    \"note\"             : \"{$fields->{"notes"}}\",
				    \"file_one_name\"    : \"{$files["name"][0]}\",
				    \"file_two_name\"    : \"{$files["name"][1]}\",
				    \"file_three_name\"  : \"{$files["name"][2]}\",
					\"date\"             : \"{$date_time}\"
				   }'";

    $query = "INSERT INTO upload VALUES(SYS_GUID(),SYSTIMESTAMP,{$json_vals})";
									
/**********************************************************************************************/	
	
	if($crud -> insertDataOne($query)){
		echo "Data Successfully Logged \n";
		http_response_code(200);
		$flag = true;
	}else{
		$flag = false;
		echo "Data Faliled to be Logged one \n";
		http_response_code(404);
	}
	
}else{
	//Header('HTTP/1.1 404 Not Found');
	$flag = false;
	echo "Data Faliled to be Logged two \n";
	http_response_code(404);
}





?>