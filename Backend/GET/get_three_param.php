<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/DataBase.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/Backend/DBManage/Crud_Oracle.php';
/***************************************/
$query_par = ['_limit','_page'];
/**************************************/
$parameters = explode('&',$_SERVER['QUERY_STRING']);
$vals = [];
if(count($parameters) == count($query_par)){
	$c = 0;
	foreach($parameters as $key=>$value){
		$val_ex = explode('=',$value);
		if($query_par[$c] == $val_ex[0]){
			array_push($vals,$val_ex[1]);
		}else{
			break;
		}
		$c++;
	}
/*********************************************************************************************/	
    $MYSQL_query_one = "SELECT * FROM $path_arr[1]";
	$MYSQL_query_two = "SELECT * FROM $path_arr[1] LIMIT ? OFFSET ?";
	//two parameters pagination
	if(isset($vals[1])){
		$arr_par = ['1' => $vals[0],'2'=>intval($vals[0])*intval($vals[1])- intval($vals[0])];
	}else{
		$arr_par = ['1' => 0, '2'=> 0];
	}
	
/**********************************************************************************************/
	$db = new DataBase();
	$crud = new Crud_Oracle($db);
	$query = "SELECT po_document FROM $path_arr[1]";
	$recSet = [];
	if($crud->singleRead($query)){
		$num_req = intval($arr_par['1']);
		$from = intval($arr_par['2']);
		$amount = count($crud->getRecordSet()[0]);
		if($from < $amount){
			$top = ($from+$num_req < $amount) ? $from+$num_req : $amount;
			for($i=$from;$i<$top;$i++){
				array_push($recSet,json_decode($crud->getRecordSet()[0][$i]));
			}
		}
		echo json_encode(array(
						"RecSet"=>$recSet,
						"NumSet"=>count($crud->getRecordSet()[0])),JSON_PRETTY_PRINT);
	}
}else{
	Header('HTTP/1.1 404 Not Found');
}

?>