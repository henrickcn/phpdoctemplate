<?php

$file = $_FILES['file'];

$dir = "upload/docx/";
if(!is_dir($dir)){
	mkdir($dir,0777,true);
}

if($file['type']!='application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
	echo json_encode(['errcode'=>1,'errmsg'=>'上传文件不允许']);
	exit;
}

$file_name = md5(time().rand(100000,9999999));

$path = $file_name.'.docx';

move_uploaded_file($file['tmp_name'],$dir.$path);

require_once 'vendor/autoload.php';
require_once 'config.php';
// Creating the new document...
$tmp = new \PhpOffice\PhpWord\TemplateProcessor($dir.$path);
foreach ($config as $key => $value) {
	foreach ($value as $k => $v) {
	    $tmp->setValue(substr($k,2,-1),$v);
	}
}
$tmp->saveAs($dir.$file_name.'_test.docx');

echo json_encode(['path'=>$dir.$file_name.'_test.docx']);