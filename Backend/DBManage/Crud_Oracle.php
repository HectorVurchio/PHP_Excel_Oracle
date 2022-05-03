<?php
class Crud_Oracle{
	private $connection;
	private $recordsNumber;
	private $recordSet;
	public function __construct($db){
		$this->connection = $db->getConnection();
	}
	public function getRecordsNumber(){
		return $this->recordsNumber;
	}
	
	public function getRecordSet(){
		return $this->recordSet;
	}
	
	public function singleRead($query){
		$stid = oci_parse($this->connection,$query);
		
		if(oci_execute($stid)){
			$this->recordsNumber = oci_fetch_all($stid,$resSet);
			$this->recordSet = [];
			foreach($resSet as $key=>$value){
				array_push($this->recordSet,$value);
			}
			return true;
		}else{
			//failure
			return false;
		}
	}
	
	public function insertDataOne($query){
		$stid = oci_parse($this->connection,$query);
		//print_r($query);
		//http_response_code(404);
		$exec = oci_execute($stid);
		return $exec;
	}
}

?>