<?php
include_once("../inc/common_functions.php");		//for common function
$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC
	$query ="Select * from ".TBL_SPECIAL_EVENT_REGISTER." sr,".TBL_SPECIAL_EVENT. " se where sr.fldpaymentstatus='PAID' AND sr.fldSpecialEvent !='' AND se.fldEventStatus='1' order by sr.fldId";
		$res=$db->query($query);
		$c=0;
		$n= mysql_num_rows($res);
		$content = "No.,Special Event,First Name,Last Name,Email,Address,City,State,Phone,Referred By,Event Location,Start Date,Price,PaymentStatus,Register Date \n";
		if($n>0)
		{
		   while($arr=mysql_fetch_array($res))
			{
			$c++;
			$no = $c.",";
			$fldEventName=	str_replace(","," ",$arr['fldEventName']).",";		
			$fldFirstName = str_replace(","," ",$arr['fldFirstName']).",";
			$fldLastName = str_replace(","," ",$arr['fldLastName']).",";
			$fldEmail = str_replace(","," ",$arr['fldEmail']).",";
			$fldAddress = str_replace(","," ",$arr['fldAddress']).",";
			$fldCity = str_replace(","," ",$arr['fldCity']).",";
			$fldState = str_replace(","," ",$arr['fldState']).",";
			$fldPhone = str_replace(","," ",$arr['fldPhone']).",";
			$fldReferredBy = str_replace(","," ",$arr['fldReferredBy']).",";
			$fldEventLocation = str_replace(","," ",$arr['fldEventLocation']).",";
			$fldEventStartDate = str_replace(","," ",$arr['fldEventStartDate']).",";
			$fldprice = str_replace(","," ",$arr['fldprice']).",";			
			$fldpaymentstatus = str_replace(","," ",$arr['fldpaymentstatus']).",";
			$fldAddDate = str_replace(","," ",date("m-d-Y", strtotime($arr['fldAddDate'])))."\n";
			
			$content = $content.$no.$fldEventName.$fldFirstName.$fldLastName.$fldEmail.$fldAddress.$fldCity.$fldState.$fldPhone.$fldReferredBy.$fldEventLocation.$fldEventStartDate.$fldprice.$fldpaymentstatus.$fldAddDate;
			
			}
			@mysql_free_result($res);
		}
		else
		{
		$content = "No Data Found !";
		}
		$tmp_file = "Exported_Special_Event_".date('m_d_Y').".csv";
		header("Content-Disposition: attachment; filename=$tmp_file");
echo $content;
exit();
?>