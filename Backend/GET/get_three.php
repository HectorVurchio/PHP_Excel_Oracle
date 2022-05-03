<?php
//require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/Config.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/Database_PDO.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/Crud_PDO.php';

$id = $path_arr[2];
if(isset($path_arr[1]) && $path_arr[1]=="excel-files"){
	//require_once $_SERVER['DOCUMENT_ROOT']."/Backend/getBucketsObj.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/Backend/downloadFile.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/Backend/file_retrieve.php";
}else{
	$MYSQL_query = "SELECT * FROM $param[1] WHERE id= ? LIMIT 1";
	$arr_par = [1 => $id];
	$config = new Config();
	$c = $config -> getVariables();
	$database = new Database_PDO($c[0],$c[1],$c[2],$c[3]);
	$db = $database->getConnection();
	$crud = new Crud_PDO($db);
	if($crud -> singleReadOne($MYSQL_query,$arr_par)){
		echo json_encode($crud -> getRecordset());
		http_response_code(200);
	}else{
		echo json_encode($crud -> getErrorInfo()());
		http_response_code(400);
	}
}

	
?>