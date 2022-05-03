<?php
require $_SERVER['DOCUMENT_ROOT']."/libraries/aws/vendor/autoload.php";
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
/*
date ==> 2022-04-19
name ==>
par-bucket-20220419-1653
url ==>
https://objectstorage.us-ashburn-1.oraclecloud.com/p/K-Cf2cLb_Yr85PWwwKBlKhGTXRboVU_Ct9afu8kvusNEJGMO16ppV0AZ51EVwc78/n/id5rfgklarlr/b/fist_bucket/o/
id ==>
d9rZRwwUDAGqLXgEUrg+8T2mEz7VNn0bMiR4nPzpZF27IoYMvNOJLt7VtcU20xqx
*/
define('ORACLE_ACCESS_KEY', 'd7bf5934fc6338b99226976950b6ae34560162c4'); //key
define('ORACLE_SECRET_KEY', 'QpxY9ZX7EkIe2RYvcIf2yP9G/aqPY4cg78IRAvsuFE4='); //password
define('ORACLE_REGION', 'us-ashburn-1');
define('ORACLE_NAMESPACE', 'id5rfgklarlr');

if($flag){
	$flag2 = true;
	for($i = 0; $i < count($files["tmp_name"]); $i++){
		$PATHINFO_FILENAME = trim(strtolower(pathinfo($files["name"][$i],PATHINFO_FILENAME)));
		$PATHINFO_EXTENSION = trim(strtolower(pathinfo($files["name"][$i],PATHINFO_EXTENSION)));
		$file_name = "{$PATHINFO_FILENAME}.{$PATHINFO_EXTENSION}";
		$target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads";
		$target_file = "{$target_dir}/{$file_name}";
		$objStorMsg = [];
		$locDeleMsg = [];
		if(move_uploaded_file($files["tmp_name"][$i],"{$target_file}")){
			$upl = upload_file_oracle("fist_bucket","",$target_file);
			if($upl['success']){
				array_push($objStorMsg,$upl['message']);
				$unlk = unlink($target_file);
				if($unlk){
					array_push($locDeleMsg,"Deleted localy {$file_name}.");
				}else{
					array_push($locDeleMsg,"{$file_name} Failed to be localy deleted.");
				}
			}else{
				array_push($objStorMsg,$upl['message']);
				$flag2 = false;
				break;
			}
		}else{
			echo "Error Uploading Locally {$file_name} File. \n";
			$flag2 = false;
			break;
		}	
	}
	var_dump(["Object_Storage"=>$objStorMsg,"Local_Deletion"=>$locDeleMsg]);
	if($flag2){
		http_response_code(200);
	}else{
		http_response_code(404);
	}
}

function get_oracle_client($endpoint){
    $endpoint = "https://".ORACLE_NAMESPACE.".compat.objectstorage.".ORACLE_REGION.".oraclecloud.com/{$endpoint}";

    return new Aws\S3\S3Client(array(
        'credentials' => [
            'key' => ORACLE_ACCESS_KEY,
            'secret' => ORACLE_SECRET_KEY,
        ],
        'version' => 'latest',
        'region' => ORACLE_REGION,
        'bucket_endpoint' => true,
        'endpoint' => $endpoint,
		'http'    => [
						'verify' => 'C:/PHP_8.1.3/extras/ssl/cacert.pem' //http://curl.haxx.se/ca/cacert.pem
					 ]
    ));
}

function upload_file_oracle($bucket_name, $folder_name, $file_name){
	
    if (empty(trim($bucket_name))) {
        return array('success' => false, 'message' => 'Please provide valid bucket name!');
    }

    if (empty(trim($file_name))) {
        return array('success' => false, 'message' => 'Please provide valid file name!');
    }

    if ($folder_name !== '') {
        $keyname = $folder_name . '/' . trim(strtolower(pathinfo($file_name,PATHINFO_BASENAME)));
        $endpoint =  "{$bucket_name}/";
    } else {
        $keyname = trim(strtolower(pathinfo($file_name,PATHINFO_BASENAME)));
        $endpoint =  "{$bucket_name}/{$keyname}";
    }

    $s3 = get_oracle_client($endpoint);
    $s3->getEndpoint();
    $file_url = "https://objectstorage.".ORACLE_REGION.".oraclecloud.com/n/".ORACLE_NAMESPACE."/b/{$bucket_name}/o/{$keyname}";
    try {
        $s3->putObject(array(
            'Bucket' => $bucket_name,
            'Key' => $keyname,
            'SourceFile' => $file_name, //C:/path/to/file.ext
            'StorageClass' => 'REDUCED_REDUNDANCY'
        ));
        return array('success' => true, 'message' => $file_url);
    } catch (S3Exception $e) {
		var_dump($e->getMessage());
        return array('success' => false, 'message' => $e->getMessage());
    } catch (Exception $e) {
		var_dump($e->getMessage());
        return array('success' => false, 'message' => $e->getMessage());
    }
}

function upload_folder_oracle($bucket_name, $folder_name)
{
    if (empty(trim($bucket_name))) {
        return array('success' => false, 'message' => 'Please provide valid bucket name!');
    }

    if (empty(trim($folder_name))) {
        return array('success' => false, 'message' => 'Please provide valid folder name!');
    }

    $keyname = $folder_name;
    $endpoint =  "{$bucket_name}/{$keyname}";
    $s3 = get_oracle_client($endpoint);

    try {
        $manager = new \Aws\S3\Transfer($s3, $keyname, 's3://' . $bucket_name . '/' . $keyname);
        $manager->transfer();
        return array('success' => true);
    } catch (S3Exception $e) {
        return array('success' => false, 'message' => $e->getMessage());
    } catch (Exception $e) {
        return array('success' => false, 'message' => $e->getMessage());
    }
}


?>