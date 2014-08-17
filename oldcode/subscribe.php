<?php

include_once 'inc/common_functions.php';
include_once 'inc/page.inc.php';

// TODO: Add a form token to make sure people aren't spoofing form data

session_start();

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
$query = "SELECT * FROM tbl_college_coach_register " .
         "WHERE fldUserName='$_SESSION[FRONTEND_USER]'";
$db1->query($query);
$db1->next_record();

$fldId          = $db1->f('fldId');
$fldFirstName   = $db1->f('fldFirstName');
$fldLastName    = $db1->f('fldLastName');
$fldEmail       = $db1->f('fldEmail');
$fldCollegeId   = $db1->f('fldCollegename');
$customerProfileId = $db1->f('fldANetCustomerProfileId'); // used in subscription_create.php

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

// gets available subscription types for the form
$costList = $func->selectTableOrder(TBL_SUBSRIPTION, "fldId,fldCost,fldName,fldPeriod", "fldId");
$listCount = count($costList);

// gets available sports for the form
$sportlist = $func->selectTableOrder(TBL_SPORTS, "fldId,fldSportsname", "fldSportsname");
$listCount = count($sportlist);

// process form submission
if ($_POST['isSubmit'] == 'save') {
    $isError = false;
    $errorMsg = '';
    
    try {
        require_once 'subscription_create.php';
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
        
        <?php if ($isError === false): ?>
            <script type="text/javascript">
                // redirects the user to a thank you page if the transaction was successful
                document.location.href = 'thankyou.php';
            </script>
        <?php endif; ?>
        
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
            
            function validate(form) {
                // initiates an array of validation errors
                var errors = new Array();
                
                // gets the fields that need to be validated
                var subType       = form['x_amount'].value;
                var subSport      = form['fldSport'].value;
                var subFName      = form['x_first_name'].value;
                var subLName      = form['x_last_name'].value;
                var subAddress    = form['x_address'].value;
                var subCity       = form['x_city'].value;
                var subState      = form['x_state'].value;
                var subZip        = form['x_zip'].value;
                var subCardholder = form['x_card_owner'].value;
                var subCardnumber = form['x_card_num'].value;
                var subExpMonth   = form['month'].value;
                var subExpYear    = form['year'].value;
                
                // validates the subscription type. Value must be numerical
                if (!isNumerical(subType)) {
                    errors.push('Please select a valid subscription');
                }
                
                // validates the subscription sport. Value must be numerical
                if (!isNumerical(subSport)) {
                    errors.push('Please select a valid sport');
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
        <!-- Header starts here -->
        <?php include ('header.php'); ?>
        <!--Header ends here -->
        
        <!--middle panel starts from here -->
        <!--content panel starts from here -->
        <div class="container">
            <div class="innerWraper">
                <div class="middle-bg">
                    <div class="boxmsg" style="display:none;">
                        This section is currently under Maintenance
                    </div>
                    <div class="cantener">
                        <div class="register-main">
                            <div class="registerPage subscribe " style="position:relative;">
                                <div style="position:absolute;top:93px;right:10px;background:#fff;border:12px solid #e4e4e4;padding:8px 15px 12px 15px;">
                                    <div class="listhead" style="margin-bottom:10px">Subscription Pricing:</div>

                                        <div class="pricing" style="margin-bottom:0px;">
                                            <span class="price-large">$14.99</span><span class="duration"> / month</span>
                                        </div>
                                        <hr class="priceline" />
                                        <div class="pricing" style="margin-bottom:0px;">
                                            <span class="price-or">or</span> <span class="price-med-black">$158.88</span><span class="duration"> / year</span><span class="savings" style="margin-left:45px;">Save $21.00</span>
                                        </div>
                                        <hr class="priceline" />
                                        <div class="pricing"style="margin-bottom:0px">
                                            <span class="price-or">or</span> <span class="price-med-black">$359.64</span><span class="duration"> / 3-years</span><span class="savings2">Save $180.00</span>
                                        </div>                                                        
                                </div>
                                <form name="frmAthReg" action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this)">
                                    <h1>Add New Subscription </h1>
                                    <div id="error" style="color: #ff0000; width: 510px;">
                                        <?php if ($isError): ?>
                                        <div class="listhead" style="color: #ff0000; margin-bottom: 10px;">There was an error processing your subscription.</div>
                                        <ul>
                                            <li style="color: #ff0000;"><?php echo $errorMsg; ?></li>
                                        </ul>
                                        <?php endif; ?>
                                        
                                    </div>
                                    <p>
                                        <h2>Subscription Info</h2>
                                        <div style="width:510px;line-height:20px;margin-bottom:12px;">
                                            A Single Subscription lets you gain access to all Athletes of the Sport
                                            you select below.  If you require multiple sports, you must purchase a
                                            separate Subscription for each additional sport.
                                        </div>
                                    </p>
                                    <p>
                                        <label>Subscription:</label>
                                        <span>
                                            <select name="x_amount">
                                                <option value="select" class="selectgrey">Select Subscription</option>

                                                <?php for ($i = 0; $i < $listCount; $i++): ?>
                                                <option value="<?php echo $costList[$i]['fldId'] ?>">

                                                    <?php echo $costList[$i]['fldName'] . " - $" .
                                                               $costList[$i]['fldCost'] . "&nbsp;(" .
                                                               $costList[$i]['fldPeriod'] . ")";?>

                                                </option>
                                                <?php endfor; ?>
                                                
                                            </select>
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Sport:</label>
                                        <input type="hidden" name="schoolid" id="schoolid" value="">
                                        <span>
                                            <select name="fldSport" >
                                                <option value = "select" class="selectgrey">Select Sport</option>

                                                <?php
                                                for ($i = 0; $i < $listCount; $i++) {
                                                    echo '<option value ="' . $sportlist[$i]['fldId'] . '"';

                                                    if (isset($_REQUEST['sportid']) && $_REQUEST['sportid'] == $sportlist[$i]['fldId']) {
                                                        echo ' selected="selected" ';
                                                    }

                                                    echo '>' . $sportlist[$i]['fldSportsname'] . '</option>';
                                                }
                                                ?>
                                                
                                            </select>
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p style="margin-top:20px;">
                                        <h2>Billing Information</h2>
                                    </p>
                                    <p>
                                        <label>First Name:</label>
                                        <span>
                                            <input type="text" name="x_first_name" value="<?php echo $fldFirstName; ?>" />
                                        </span>
                                        <font color="#0000ff">&nbsp;*</font>
                                    </p>
                                    <p>
                                        <label>Last Name:</label>
                                        <span>
                                            <input type="text" name="x_last_name" value="<?php echo $fldLastName; ?>" />
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
                                    <p style="margin-top:20px;">
                                        <h2>Payment Details</h2>
                                    </p>
                                    <p>
                                        <label>Credit Card Owner:</label>
                                        <span>
                                            <input type="text" name="x_card_owner"  />
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
                                            <select name="month" style="width:140px;">
                                                <option value="month" class="selectgrey">Select Month</option>

                                                <?php for ($month = 1; $month <= 12; $month++): ?>
                                                    <option value="<?php echo $month; ?>">
                                                        <?php echo $month; ?>
                                                    </option>
                                                <?php endfor; ?>

                                            </select>
                                            <font style="font-size:22px;margin-left:3px;margin-right:3px;color:#999;">/</font>	
                                            <select name="year" style="width:122px;">
                                                <option value="select" class="selectgrey">Select year</option>

                                                <?php for ($year = 2011; $year <= 2031; $year++): ?>
                                                    <option value="<?php echo $year; ?>">
                                                        <?php echo $year; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </span>
                                    </p>
                                    <p style="margin-top:30px;">
                                        <label>&nbsp;</label>
                                        <input type="hidden" name="fldEmail" value="<?php echo $fldEmail; ?>" />
                                        <span>
                                            <input type="hidden" name="isSubmit" value="save" />
                                            <input type="submit" name="submit" value="Checkout" />
                                            <input type="BUTTON" value="Back" onclick="history.go(-1)" />
                                        </span>
                                    </p>
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
