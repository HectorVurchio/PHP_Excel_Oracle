<?php
$arrId = explode("%20",$id);
$final = join(" ",$arrId);
$id = $final;

$service = "objectstorage";
$region = "us-ashburn-1";
$strconn = "K-Cf2cLb_Yr85PWwwKBlKhGTXRboVU_Ct9afu8kvusNEJGMO16ppV0AZ51EVwc78";
$name_space = "id5rfgklarlr";
$bucket_name = "fist_bucket";

$dir_name = $_SERVER["DOCUMENT_ROOT"]."/downloads";
$url="https://{$service}.{$region}.oraclecloud.com/p/{$strconn}/n/{$name_space}/b/{$bucket_name}/o/{$id}";
$filename = "{$dir_name}/{$id}";
$arrContextOptions= [
    'ssl' => [
        'cafile' => 'C:/PHP_8.1.3/extras/ssl/cacert.pem',
        'verify_peer'=> true,
        'verify_peer_name'=> true,
    ],
];
if(file_put_contents($filename, file_get_contents($url),false,stream_context_create($arrContextOptions))){
	$flag = true;
}else{
	$flag = false;
}



?>