<?php
// PhpSpreadSheet Library
require $_SERVER["DOCUMENT_ROOT"]."/libraries/phpspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	$message = "";
	$filename = $_SERVER["DOCUMENT_ROOT"]."/downloads/{$id}";
	$worksheetNames = [];
	if($flag){
		//open the file
		$reader = new Xlsx();
		$spreadsheet = $reader->load($filename);	
		$sheetnames = $spreadsheet->getSheetNames();
		//load the first sheet of the book
		$worksheet0 = $spreadsheet->getSheetByName($sheetnames[0]);
		$worksheet0Array = $worksheet0->toArray(null, true, true, true);
		//delete the temp file
		if (file_exists($filename)){
			unlink($filename);
		}

        http_response_code(200);		
		echo json_encode($worksheet0Array);
	}else{
		$object1 = new stdClass();
		$object2 = new stdClass();
        $object1 -> Error = "File Exception";
		$object2 -> Error = $message;
		echo json_encode((object)array("1"=>$object1,"2"=>$object2));
		http_response_code(400);
	}
	
?>