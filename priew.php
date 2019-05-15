<?php 

$file_name = $_GET['file'];
$file_name = 'upload/docx/'.pathinfo($file_name)['filename'].'.docx';
if(!file_exists($file_name)){
	return "";
}
require_once 'vendor/autoload.php';
require_once 'config.php';
// Creating the new document...
$tmp = new \PhpOffice\PhpWord\TemplateProcessor($file_name);
foreach ($config as $key => $value) {
	foreach ($value as $k => $v) {
	    $tmp->setValue(substr($k,2,-1),$v);
	}
	
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="合同.docx"');
header('Content-Transfer-Encoding: binary');
readfile($tmp->save('php://output'));
