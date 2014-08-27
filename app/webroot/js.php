<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Immediately send back the 304 Not Modified header if this js is cached, don't load again
if ((!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) OR !empty($_SERVER['HTTP_IF_NONE_MATCH'])))
{
	$sapi_name = php_sapi_name();
	if ($sapi_name == 'cgi' OR $sapi_name == 'cgi-fcgi'){
		header('Status: 304 Not Modified');
	}
	else{
		header('HTTP/1.1 304 Not Modified');
	}
	// remove the content-type and X-Powered headers to emulate a 304 Not Modified response as close as possible
	header('Content-Type:');
	header('X-Powered-By:');
	exit;
}

$jsfiles = array();
$jsfiles = explode(",",$_REQUEST['file']);

$output = '';
if($jsfiles){
	foreach($jsfiles as $jsfile){
		if(file_exists("js/$jsfile")){
			$output .= file_get_contents("js/$jsfile") . "\r\n";
		}
	}
		
	include 'JSMin.php';
	$JSMin = new JSMin();
	$returntext = $JSMin->minify($output);

	$output = $returntext;
}

header('Content-Type: text/javascript');
header('Cache-control: max-age=31536000, private');
header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 31536000) . ' GMT');
header('Pragma:');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $style['dateline']) . ' GMT');
header('Content-Length: ' . strlen($output));
echo $output;