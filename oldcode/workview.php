<?php
echo "ty".$hmac=hash_hmac('sha1','hello','59d7e80b775ab1c628f303e7ec8ccaaf7d13829as',true );



			$url = "http://api.elance.com/api/workroom/getWorkviewDetails?bidId=23748420&userId=3007021&oauth_consumer_key=59d7e80b775ab1c628f303e7ec8ccaaf7d13829a&oauth_signature_method=HMAC-SHA1&oauth_signature=".$hmac."&oauth_timestamp=".time()."&oauth_nonce=4b8bf34a8e891";
			if (!($r = @curl_init($url))) {
				die("Cannot initialize cUrl session. Is cUrl enabled for your PHP installation?");
			}
			$curl_options = array (
									CURLOPT_FRESH_CONNECT => 1,
									CURLOPT_RETURNTRANSFER => 1
								  );
			curl_setopt_array($r, $curl_options);
			$json_txt = curl_exec($r);
			$json_txt = json_decode($json_txt,true);
			echo "<pre>";
			print_r($json_txt);
			echo "</pre>";

?>
