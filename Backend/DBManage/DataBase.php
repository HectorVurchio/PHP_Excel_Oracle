<?php
class DataBase{
	private $myDB = 'hectoronedb_high';
    private $username = 'ADMIN';
	private $password = 'C0rch0l0c01012*';
    private $conn = false;
	
	
    public function getConnection(){
		$this->conn = oci_pconnect($this->username, $this->password, $this->myDB);
		if (!$this->conn) {
			$e = oci_error();
			trigger_error('can not connect', E_USER_ERROR);
			http_response_code(404); //Bad Request
			return $this->conn;
		}
		return $this->conn;
    }
}

?>