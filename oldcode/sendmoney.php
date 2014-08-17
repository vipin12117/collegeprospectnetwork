<?php include_once ("inc/common_functions.php");
    //for common function
    include_once ("inc/page.inc.php");
    include_once ("inc/config.inc.php");
    //for paging
    session_start();
    $func = new COMMONFUNC;
    $func2 = new COMMONFUNC;
    $db = new DB;
    //$flag=1;
    $lnb = "2";
	//if(isset($_REQUEST['register'])){
	//$fld_id=$_REQUEST['fld_id'];
	$fld_id=$_SESSION['fld_id'];
	$totalres=$db->query("select * from ".TBL_SPECIAL_EVENT_REGISTER." where fldId='".$fld_id."'");
	$totalrow=mysql_fetch_object($totalres);
	//echo $totalrow->fldprice;exit;
	//echo $totalrow->zip; exit;
	//$x_Test_Request = hb_get_payment_mode();
	
	include("authorizenet.php");
	$ac = new AuthorizenetClass(); 
	$ac->setParameter("x_Login", "24u2SUseP");
	$x_Test_Request = hb_get_payment_mode(); //eb78tx
	$ac->setParameter("x_Test_Request", $x_Test_Request);
	//$ac->setParameter("x_First_Name", $totalrow->fname); 
	//$ac->setParameter("x_Last_Name", $totalrow->lname); 
	$ac->setParameter("x_First_Name",$_SESSION['fldFirstName']); 
	$ac->setParameter("x_Last_Name",$_SESSION['fldLastName']);  
	$ac->setParameter("x_amount", $totalrow->fldprice); //"$totalrow->finaltotal");
	$ac->setParameter("x_currency_code", "USD"); 
	$ac->setParameter("x_Card_Num",$_SESSION['cardno']); 
	$ac->setParameter("x_Card_Type",$_SESSION['cardtype']); 
	$ac->setParameter("x_Card_Code", $_SESSION['securitycode']); 
	
	$expirydate=$_SESSION['expmonth'].$_SESSION['expyear'];

	$ac->setParameter("x_Exp_Date", $expirydate); 
	$ac->setParameter("x_Invoice_Num", $totalrow->fldId); 
	$ac->setParameter("x_description", $product_name); 
	$ac->setParameter("x_Address", $_SESSION['fldBSAddress']); 
	$ac->setParameter("x_City", $_SESSION['fldBSCity']); 
	$ac->setParameter("x_State", $_SESSION['fldBSState']); 
	$ac->setParameter("x_zip", $_SESSION['fldBSZipCode']);
	$ac->setParameter("x_phone",$_SESSION['fldPhone']); 
	$ac->setParameter("x_email",$totalrow->fldEmail);

	$result_code = $ac->process();    // 1 = accepted, 2 = declined, 3 = error 
	$result_array = $ac->getResults();    // return results array 

$Error="Transaction Fail";
if(count($result_array)>0)
	$Error="";
foreach($result_array as $key => $value) {
	if($key=="x_response_code")
	{
		if($value==1)
		{
			$_SESSION['PAYSTATUS']="PAID";
			header("Location:Event_Payment_confirmation.php?fld_id=".$_SESSION['fld_id']."");
			exit;
		}
	}
	if($key=="x_response_reason_text")
	{
		$Error=$value;
	}
}	
if($Error)
{
	$response_text=$Error;
	$_SESSION["SESS_CartId"] = $ssid;
	header("Location:Event_confirmation.php?response_text=".$response_text."&fld_id=".$_SESSION['fld_id']);
	exit;
}
  header("Location: Event_confirmation.php?response_text=Trasaction Fail&fld_id=".$_SESSION['fld_id']);
exit;
//}
?>