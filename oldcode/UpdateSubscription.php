<?php
include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");

session_start();

// TODO: add a form token for security

if (($_SESSION['mode'] == "") or ($_SESSION['FRONTEND_USER'] == "")) {
    header("Location:index.php");
}

$func = new COMMONFUNC;
$db = new DB;
$flag = 0;

/*
 * gets coach information. This is used to pre-fill form fields 
 * and provide necessary data for the Authorize.net transaction
 */
$query = 'SELECT * FROM ' . TBL_COLLEGE_COACH_REGISTER .
         " WHERE fldUserName='" . $_SESSION[FRONTEND_USER] . "'";
$db->query($query);
$db->next_record();

$fldCoach          = $db->f('fldId');
$fldFirstName      = $db->f('fldFirstName');
$fldLastName       = $db->f('fldLastName');
$fldCollegeId      = $db->f('fldCollegename');

// used in subscription_update.php
$customerProfileId = $db->f('fldANetCustomerProfileId');

/*
 * gets college information for the coach. This is used to pre-fill 
 * form fields and provides necessary data for the Authorize.net transaction
 */
$query = "SELECT * FROM tbl_college WHERE fldId='$fldCollegeId'";
$db1->query($query);
$db1->next_record();

$fldAddress     = $db1->f('fldAddress');
$fldCity        = $db1->f('fldCity');
$fldState       = $db1->f('fldState');
$fldZipCode     = $db1->f('fldZipCode');

// gets all active subscriptions for the current user
$table  = TBL_COLLEGE_SUBSCRIPTION;
$fields = 'fldId,fldType,fldSport';
$where  = 'WHERE fldCoach=' . $fldCoach . ' AND fldActive=1';
$subsList = $func->selectTableOrder($table, $fields, 'fldId', $where);
$subsCount = count($subsList);

// creates a human-readable version of the active subscriptions
$activeSubs = array();
for ($i = 0; $i < $subsCount; $i++) {
    $key = $subsList[$i]['fldId'];
    
    // gets the name of the subscription type
    $query = 'SELECT fldName FROM ' . TBL_SUBSCRIPTION . 
             ' WHERE fldId=' . $subsList[$i]['fldType'];
    $db->query($query);
    $db->next_record();
    
    $typeName = $db->f('fldName');
    
    // gets the name of the subscribed sport
    $query = 'SELECT fldSportsname FROM ' . TBL_SPORTS .
             ' WHERE fldId=' . $subsList[$i]['fldSport'];
    $db->query($query);
    $db->next_record();
    
    $sportName = $db->f('fldSportsname');
    
    $value = $typeName . ' (' . $sportName .')';
    $activeSubs[$key] = $value;
}

if ($_POST['isSubmit'] == 'save') {
    $isError  = false;
    $errorMsg = null;
    
    // gets the form field values and sanitizes them
    $subId         = intval($_POST['fldSubId']);
    $subFName      = mysql_real_escape_string($_POST['x_first_name']);
    $subLName      = mysql_real_escape_string($_POST['x_last_name']);
    $subAddress    = mysql_real_escape_string($_POST['x_address']);
    $subCity       = mysql_real_escape_string($_POST['x_city']);
    $subState      = mysql_real_escape_string($_POST['x_state']);
    $subZip        = mysql_real_escape_string($_POST['x_zip']);
    $subCardholder = mysql_real_escape_string($_POST['x_card_owner']);
    $subCardnumber = intval($_POST['x_card_num']);
    $subExpMonth   = intval($_POST['x_exp_month']);
    $subExpYear    = intval($_POST['x_exp_year']);
    
    // creates a valid expiration date from subExpMonth and
    // subExpYear. The expiration month is left-padded with
    // 0s to make sure it is always 2 digits long
    $subCardExpDate = $subExpYear . '-' .
                    sprintf("%02s", $subExpMonth);
    
    try {
        require_once 'subscription_update.php';
    } catch (Exception $e) {
        $isError = true;
        $errorMsg = $e->getMessage();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>College Prospect Network</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
		    // trims leading and trailing whitespace
            function trims(str) {
                return str.replace(/^\s+|\s+$/g, '');
            }
            
            // tests if a string is alphabetical, i.e, contains only the 
            // characters a-z, A-Z, and " ". Leading and trailing spaces are ignored.
            function isAlpha(str) {
                var pattern = new RegExp('^[a-zA-Z ]+$', 'i');
                return pattern.test(trims(str));
            }
            
            // tests if a string is alphanumerical, i.e., contains only the characters 
            // a-z, A-Z, 0-9, and " ". Leading and trailing spaces are ignored
            function isAlphaNum(str) {
                var pattern = new RegExp('^[0-9a-zA-Z ]+$', 'i');
                return pattern.test(trims(str));
            }
            
            // tests if a string is numerical, i.e., contains only the 
            // characters 0-9. Leading and trailing spaces are ignored.
            function isNumerical(str) {
                var pattern = new RegExp('^[0-9]+$', 'i');
                return pattern.test(trims(str));
            }
            
            function validate(form)
		    {
		        // initiates an array of validation errors
                var errors = new Array();
                
                // gets the fields that need to be validated
                var subId         = form['fldSubId'].value;
                var subFName      = form['x_first_name'].value;
                var subLName      = form['x_last_name'].value;
                var subAddress    = form['x_address'].value;
                var subCity       = form['x_city'].value;
                var subState      = form['x_state'].value;
                var subZip        = form['x_zip'].value;
                var subCardholder = form['x_card_owner'].value;
                var subCardnumber = form['x_card_num'].value;
                var subExpMonth   = form['x_exp_month'].value;
                var subExpYear    = form['x_exp_year'].value;
                
                // validates the subscription type. Value must be numerical
                if (!isNumerical(subId)) {
                    errors.push('Please select a valid subscription');
                }
                
                // validates the subscriber's first name. Value must be alphabetical
                if (!isAlpha(subFName)) {
                    errors.push('Please enter a first name containing only alphabetical characters');
                }
                
                // validates the subscriber's last name. Value must be alphabetical
                if (!isAlpha(subLName)) {
                    errors.push('Please enter a last name containing only alphabetical characters');
                }
                
                // validates the subscriber's address. Value must be alphanumerical
                var pattern = new RegExp('^[0-9a-zA-Z -.]+$');
                if (!pattern.test(trims(subAddress))) {
                    errors.push('Please enter an address containing only alphabetical character, numbers, and spaces');
                }
                
                // validates the subscriber's city. Value must be alphabetical
                if (!isAlpha(subCity)) {
                    errors.push('Please enter a city containing only alphabetical characters');
                }
                
                // validates the subscriber's state. Value must be alphabetical
                if (!isAlpha(subState)) {
                    errors.push('Please enter a state containing only alphabetical characters');
                }
                
                // validates the subscriber's ZIP code. Value must be 5 digits
                var pattern = new RegExp('^[0-9]{5}$');
                if (!pattern.test(trims(subZip))) {
                    errors.push('Please enter a ZIP code containing only five numbers');
                }
                
                // validates the subscriber's card holder name. Value must be alphabetical
                if (!isAlpha(subCardholder)) {
                    errors.push('Please enter a cardholder name containing only alphabetical characters');
                }
                
                // validates the subscriber's card number. Value must be numerical
                if (!isNumerical(subCardnumber)) {
                    errors.push('Please enter a credit card number containing only numerical characters');
                }
                
                // validates the subscriber's card expiration month. Value must be 1-12
                if (subExpMonth === 'month') {
                    errors.push('Please select a valid expiration month');
                }
                
                // validates the subscriber's card expiration year. Value must be 2011-2031
                if (subExpYear === 'select') {
                    errors.push('Please select a valid expiration year');
                }
                
                // returns false if any errors were encountered
                if (errors.length > 0) {
                    // creates a div element for the error heading
                    var d = document.createElement('div');
                    
                    // creates the class attribute node for the div element
                    var dClass = document.createAttribute('class');
                    dClass.value = 'listhead';
                    
                    d.setAttributeNode(dClass);
                    
                    // creates the style attribute node for the div element
                    var dStyle = document.createAttribute('style');
                    dStyle.value = 'color: #ff0000; margin-bottom: 10px; width: 510px;';
                    
                    d.setAttributeNode(dStyle);
                    
                    // creates the title text for the div element
                    errorTitle = document.createTextNode('Please correct the following errors and try again:');
                    d.appendChild(errorTitle);
                    
                    // creates a list of errors
                    var list = document.createElement('ul');
                    var p = document.getElementById('error');
                    
                    for (i in errors) {
                        var listItem = document.createElement('li');
                        var error = document.createTextNode(errors[i]);
                    
                        // creates the style attribute node for the listItem
                        itemStyle = document.createAttribute('style');
                        itemStyle.value = 'color: #ff0000;';
                        
                        listItem.setAttributeNode(itemStyle);
                        
                        listItem.appendChild(error);
                        list.appendChild(listItem);
                    }
                    
                    // adds the div element and error list to the page
                    var error = document.getElementById('error');
                    error.appendChild(d);
                    error.appendChild(list);
                    
                    window.scrollTo(0, 0);
                    
                    return false;
                }
                
                return true;
		    }
		</script>
	</head>
	<body>
		<!--header link starts from here -->
		<?php include ('header.php'); ?>
		<!--Header ends from here -->
		<!--middle panel starts from here -->
		<!--content panel starts from here -->
		<div class="container">
			<div class="innerWraper">
				<div class="middle-bg">
					<div class="cantener">
						<div class="register-main">
							<div class="registerPage">
								<form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
									<h1>Edit Subscription</h1>
									
									<?php if ($subsCount > 0): ?>
									
									<div id="error" style="color: #ff0000; width: 510px;">
                                        <?php if ($isError): ?>
                                        <div class="listhead" style="color: #ff0000; margin-bottom: 10px;">There was an error updating your subscription.</div>
                                        <ul>
                                            <li style="color: #ff0000;"><?php echo $errorMsg; ?></li>
                                        </ul>
                                        <?php endif; ?>
                                        
                                    </div>
									
									<?php if ($isError === false): ?>
								    <p class="thankyoumessage" style="color: #0000ff;">
	    							    Your subscription has been successfully updated.
								    </p>
    							    <?php endif; ?>
									
									<h2>Subscription Information</h2>
									<p>
                                        <label>Subscription:</label>
                                        <span>
                                            <select name="fldSubId">
                                                <option value="select">
                                                    Please Select Subscription
                                                </option>
                                                
                                                <?php foreach ($activeSubs as $id => $name): ?>
                                                <option value="<?php echo $id; ?>">
                                                    <?php echo $name; ?>
                                                </option>
                                                <?php endforeach; ?>
                                                
                                            </select>
                                        </span>
                                    </p>
									<p>
                                        <h2>Billing Information</h2>
                                    </p>
                                    <p>
                                        <label>First Name:</label>
                                        <span>
                                            <input type="text" name="x_first_name" value="<?php echo $fldFirstName ?>"/>
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Last Name:</label>
                                        <span>
                                            <input type="text" name="x_last_name" value="<?php echo $fldLastName ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Address:</label>
                                        <span>
                                            <input type="text" name="x_address" value="<?php echo $fldAddress; ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>City:</label>
                                        <span>
                                            <input type="text" name="x_city" value="<?php echo $fldCity; ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>State:</label>
                                        <span>
                                            <input type="text" name="x_state" value="<?php echo $fldState; ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Zip Code:</label>
                                        <span>
                                            <input type="text" name="x_zip" value="<?php echo $fldZipCode; ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>                                
                                    <p style="margin-top: 15px;">
                                        <h2>Card Details</h2>
                                    </p>
                                    <p>
                                        <label>Credit Card Owner:</label>
                                        <span>
                                            <input type="text" name="x_card_owner" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Card Number:</label>
                                        <span>
                                            <input type="text" name="x_card_num" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Card Expire Date:</label>
                                        <span>
                                            <select name="x_exp_month" style="width: 140px;">
                                                <option value="month" class="selectgrey">Select Month</option>
                                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <font style="font-size:22px;margin-left:3px;margin-right:3px;color:#999;">/</font>  
                                            <select name="x_exp_year" style="width:122px;">
                                                <option value="select" class="selectgrey">Select year</option>
                                                <?php for ($i = 2011; $i <= 2031; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </span>
                                    </p>
									<p style="margin-top: 30px;">
										<label>&nbsp;</label>
										<span>
											<input type="hidden" name="isSubmit" value="save" />
											<input type="submit" name="submit" value="Update" />
											<input type="button" value="Back" onclick="history.go(-1)" />
										</span>
									</p>
									
									<?php else: ?>
									
									<div class="thankyoumessage">You have No Active Subscriptions</div>
                                    <p>
                                        <label>&nbsp;</label>
                                        <span>                                    
                                            <input type="button" value="Bback" onclick="history.go(-1)" />
                                        </span>
                                    </p>
                                    
									<?php endif; ?>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include ('footer.php'); ?>
	</body>
</html>
