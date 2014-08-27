<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Immediately send back the 304 Not Modified header if this js is cached, don't load again
if ((!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) OR !empty($_SERVER['HTTP_IF_NONE_MATCH'])))
{
	$sapi_name = php_sapi_name();
	if ($sapi_name == 'cgi' OR $sapi_name == 'cgi-fcgi')
	{
		header('Status: 304 Not Modified');
	}
	else
	{
		header('HTTP/1.1 304 Not Modified');
	}
	// remove the content-type and X-Powered headers to emulate a 304 Not Modified response as close as possible
	header('Content-Type:');
	header('X-Powered-By:');
	exit;
}

$cssfiles = array();
$cssfiles = explode(",",$_REQUEST['file']);

$output = '';
if($cssfiles){
	foreach($cssfiles as $cssfile){
		if(file_exists("css/$cssfile")){
			$output .= file_get_contents("css/$cssfile") . "\r\n";
		}
	}
	
	include 'CSSMin.php';
	$CSSMin = new CSSMin();
	$returntext = $CSSMin->run($output);

	$output = $returntext;
}

header('Content-Type: text/css');
header('Cache-control: max-age=31536000, private');
header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 31536000) . ' GMT');
header('Pragma:');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $style['dateline']) . ' GMT');
header('Content-Length: ' . strlen($output));
echo $output;