<?
	include_once("../inc/common_functions.php");

		include_once("../inc/config.inc.php");	// for admin login

        include_once("../inc/db.inc.php");

        include_once("connection.class.php");
		$func = new COMMONFUNC;	//Create an instance of class COMMONFUNC

		$db=new DB();
		$connObj = new Connection($db->Host,$db->User,$db->Password,$db->Database);
	hb_set_payment_mode("FALSE");
	?>
		<script language="javascript">
			alert("Authorize.net payment mode is in LIVE mode now.");
			window.location.href='ADmain.php';
		</script>
	<?
?>