<?php

$file      = 'receipt.png';       // image file to read and upload
$picNameIn = 'feedItemFileUpload';
$handle = fopen($file,'r');         // do a binary read of image
$multiPartImageData = fread($handle,filesize($file));
fclose($handle);

$data["body"] = array("messageSegments"=>array("type"=>"text","text"=>"Please accept this receipt."));
$data["attachment"] = array("attachmentType"=>"NewFile","description"=>"Receipt for expenses","title"=>"receipt.png");
$data["feedElementType"] = "FeedItem";
$data["subjectId"] = "a0Eo00000019X2jEAE";
$requestJson = "[".json_encode($data)."]";

$requestJson = '{"body": {"messageSegments": [{"type": "Text","text": "Please accept this receipt."}]},
 				 "attachment": {"attachmentType": "NewFile","description": "Receipt for expenses","title": "receipt.png"},
  				 "feedElementType": "FeedItem", "subjectId": "a0Eo00000019X2jEAE"}';

$boundary = "MIME_boundary";
$CRLF = "\r\n";

// The complete POST consists of an XML request plus the binary image separated by boundaries
$firstPart   = '';
$firstPart  .= "--" . $boundary . $CRLF;
$firstPart  .= 'Content-Disposition: form-data; name="json"' . $CRLF;
$firstPart  .= 'Content-Type: application/json;charset=utf-8' . $CRLF . $CRLF;
$firstPart  .= $requestJson;
$firstPart  .= $CRLF;

$firstPart .= "--" . $boundary . $CRLF;
$firstPart .= 'Content-Disposition: form-data; name="feedItemFileUpload"; filename="receipt.png"' . $CRLF;
$firstPart .= "Content-Transfer-Encoding: binary" . $CRLF;
$firstPart .= "Content-Type: application/octet-stream;charset=ISO-8859-1" . $CRLF . $CRLF;
$firstPart .= $multiPartImageData;
$firstPart .= $CRLF;
$firstPart .= "--" . $boundary . "--" . $CRLF;

$fullPost = $firstPart;

$ch  = curl_init();
$url = "https://na17.salesforce.com/services/data/v27.0/chatter/feeds/record/a07o000000097sG/feed-items";

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_TIMEOUT,60);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$fullPost);

$headers = array();
$headers[] = 'Content-Type: multipart/form-data; boundary=' . $boundary;
$headers[] = 'Host: na17.salesforce.com';
$headers[] = 'Content-Length: ' . strlen($fullPost);
$headers[] = 'Authorization: OAuth 00Do0000000Hb0Q!ARkAQKHrWK6vUrI_lGvTXaDhtzRMCz1wbaZ8kj4iEBSRmxrDBDtSRubIGH5b0JwQJGJlaaJhDXqSJqrd9MR2nul6n_VDiDGo';
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);

$response = curl_exec($ch);
$error    = curl_error($ch);

print "<pre>";
print_r($error);
print_r(($response));