<!-- Email Alert Notification -->
<?php

	$toName = $HS_Coach_information[0]['fldName'] . ' ' .  $HS_Coach_information[0]['fldLastName'] ;
	$toEmailAddress = $HS_Coach_information[0]['fldEmail'];
	$to = " $toName < $toEmailAddress >";

	$subject = "College Prospect Network - Game Tape Request ";

	$msg = "Hi $toName, 
	        You have been sent a new Game Tape Request.Please login to your account to update.";
	$msg = wordwrap($msg,70); //in case long string be clipped 

	$from = "notifications@collegeprospectnetwork.com";
	$headers = "From: {$from}\n";
	$headers .= "Reply-To: {$from}\n";
	
	mail($to, $subject, $msg, $headers);
  
?>