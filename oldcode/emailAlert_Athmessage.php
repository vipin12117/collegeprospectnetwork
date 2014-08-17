<!-- Email Alert Notification -->
<?php

	$toName = $coachlist[$i]['fldName'] . ' ' .  $coachlist[$i]['fldLastName'] ;
	$toEmailAddress = $coachlist[$i]['fldEmail'];
	$to = " $toName < $toEmailAddress >";

	$subject = "Mail Alert at ".strftime("%T", time());

	$msg = "Email Alert Testing.";
	$msg = wordwrap($msg,70); //in case long string be clipped 
	
	$fromName = "CPN Notification";
	//$fromEmailAddress = $college_coach_info[0]['fldEmail'];

	$from = "$fromName < notifications@collegeprospectnetwork.com >";
	$headers = "From: {$from}\n";
	$headers .= "Reply-To: {$from}\n";
	
	mail($to, $subject, $msg, $headers);
  
?>