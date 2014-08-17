 <?php
 include_once("inc/common_functions.php");		//for common function
include_once("inc/page.inc.php");	
include_once("inc/config.inc.php");

$func = new COMMONFUNC;
$db = new DB;

$q=$_GET["q"];

if($q=="other")
 {
     
$college_address_other_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =0 and fldName='".$txtfldName."'");
?>
<div class="yellow">  
<label>College Name:</label><span>	<input type="text" name="txtfldName" id="txtfldName" class="yellow"><?=$txtfldName?><font color="#0000ff">&nbsp;*</font></span><label>Address:</label><span> 	<textarea rows=14 cols=69 name=fldAddress><?=$college_address_other_info[0]['fldAddress']?></textarea><font color="#0000ff">&nbsp;*</font></span><br/><br/><label>City:</label><span>	<input type="text" name="fldCity" id="fldCity" value="<?=$college_address_other_info[0]['fldCity']?>" >	<font color="#0000ff">&nbsp;*</font></span><br/><br/><label>State:</label>    <span>
            <select name="fldState">
               <option value="select">Select State</option>
               <optgroup label="United States">
               <option value='Alaska' <?php if ($college_address_info[0]['fldState'] == 'Alaska') echo 'selected'; ?>>Alaska</option>
               <option value='Alabama' <?php if ($college_address_info[0]['fldState'] == 'Alabama') echo 'selected'; ?>>Alabama</option>
               <option value='Arkansas' <?php if ($college_address_info[0]['fldState'] == 'Arkansas') echo 'selected'; ?>>Arkansas</option>
               <option value='Arizona' <?php if ($college_address_info[0]['fldState'] == 'Arizona') echo 'selected'; ?>>Arizona</option>
               <option value='California' <?php if ($college_address_info[0]['fldState'] == 'California') echo 'selected'; ?>>California</option>
               <option value='Colorado' <?php if ($college_address_info[0]['fldState'] == 'Colorado') echo 'selected'; ?>>Colorado</option>
               <option value='Connecticut' <?php if ($college_address_info[0]['fldState'] == 'Connecticut') echo 'selected'; ?>>Connecticut</option>
               <option value='District of Columbia' <?php if ($college_address_info[0]['fldState'] == 'District of Columbia') echo 'selected'; ?>>District of Columbia</option>
               <option value='Delaware' <?php if ($college_address_info[0]['fldState'] == 'Delaware') echo 'selected'; ?>>Delaware</option>
               <option value='Florida' <?php if ($college_address_info[0]['fldState'] == 'Florida') echo 'selected'; ?>>Florida</option>
               <option value='Georgia' <?php if ($college_address_info[0]['fldState'] == 'Georgia') echo 'selected'; ?>>Georgia</option>
               <option value='Hawaii' <?php if ($college_address_info[0]['fldState'] == 'Hawaii') echo 'selected'; ?>>Hawaii</option>
               <option value='Iowa' <?php if ($college_address_info[0]['fldState'] == 'Iowa') echo 'selected'; ?>>Iowa</option>
               <option value='Idaho' <?php if ($college_address_info[0]['fldState'] == 'Idaho') echo 'selected'; ?>>Idaho</option>
               <option value='Illinois' <?php if ($college_address_info[0]['fldState'] == 'Illinois') echo 'selected'; ?>>Illinois</option>
               <option value='Indiana' <?php if ($college_address_info[0]['fldState'] == 'Indiana') echo 'selected'; ?>>Indiana</option>
               <option value='Kansas' <?php if ($college_address_info[0]['fldState'] == 'Kansas') echo 'selected'; ?>>Kansas</option>
               <option value='Kentucky' <?php if ($college_address_info[0]['fldState'] == 'Kentucky') echo 'selected'; ?>>Kentucky</option>
               <option value='Louisiana' <?php if ($college_address_info[0]['fldState'] == 'Louisiana') echo 'selected'; ?>>Louisiana</option>
               <option value='Massachusetts' <?php if ($college_address_info[0]['fldState'] == 'Massachusetts') echo 'selected'; ?>>Massachusetts</option>
               <option value='Maryland' <?php if ($college_address_info[0]['fldState'] == 'Maryland') echo 'selected'; ?>>Maryland</option>
               <option value='Maine' <?php if ($college_address_info[0]['fldState'] == 'Maine') echo 'selected'; ?>>Maine</option>
               <option value='Michigan' <?php if ($college_address_info[0]['fldState'] == 'Michigan') echo 'selected'; ?>>Michigan</option>
               <option value='Minnesota' <?php if ($college_address_info[0]['fldState'] == 'Minnesota') echo 'selected'; ?>>Minnesota</option>
               <option value='Missouri' <?php if ($college_address_info[0]['fldState'] == 'Missouri') echo 'selected'; ?>>Missouri</option>
               <option value='Mississippi' <?php if ($college_address_info[0]['fldState'] == 'Mississippi') echo 'selected'; ?>>Mississippi</option>
               <option value='Montana' <?php if ($college_address_info[0]['fldState'] == 'Montana') echo 'selected'; ?>>Montana</option>
               <option value='North Carolina' <?php if ($college_address_info[0]['fldState'] == 'North Carolina') echo 'selected'; ?>>North Carolina</option>
               <option value='North Dakota' <?php if ($college_address_info[0]['fldState'] == 'North Dakota') echo 'selected'; ?>>North Dakota</option>
               <option value='Nebraska' <?php if ($college_address_info[0]['fldState'] == 'Nebraska') echo 'selected'; ?>>Nebraska</option>
               <option value='New Hampshire' <?php if ($college_address_info[0]['fldState'] == 'New Hampshire') echo 'selected'; ?>>New Hampshire</option>
               <option value='New Jersey' <?php if ($college_address_info[0]['fldState'] == 'New Jersey') echo 'selected'; ?>>New Jersey</option>
               <option value='New Mexico' <?php if ($college_address_info[0]['fldState'] == 'New Mexico') echo 'selected'; ?>>New Mexico</option>
               <option value='Nevada' <?php if ($college_address_info[0]['fldState'] == 'Nevada') echo 'selected'; ?>>Nevada</option>
               <option value='New York' <?php if ($college_address_info[0]['fldState'] == 'New York') echo 'selected'; ?>>New York</option>
               <option value='Ohio' <?php if ($college_address_info[0]['fldState'] == 'Ohio') echo 'selected'; ?>>Ohio</option>
               <option value='Oklahoma' <?php if ($college_address_info[0]['fldState'] == 'Oklahoma') echo 'selected'; ?>>Oklahoma</option>
               <option value='Oregon' <?php if ($college_address_info[0]['fldState'] == 'Oregon') echo 'selected'; ?>>Oregon</option>
               <option value='Pennsylvania' <?php if ($college_address_info[0]['fldState'] == 'Pennsylvania') echo 'selected'; ?>>Pennsylvania</option>
               <option value='Puerto Rico' <?php if ($college_address_info[0]['fldState'] == 'Puerto Rico') echo 'selected'; ?>>Puerto Rico</option>
               <option value='Rhode Island' <?php if ($college_address_info[0]['fldState'] == 'Rhode Island') echo 'selected'; ?>>Rhode Island</option>
               <option value='South Carolina' <?php if ($college_address_info[0]['fldState'] == 'South Carolina') echo 'selected'; ?>>South Carolina</option>
               <option value='South Dakota' <?php if ($college_address_info[0]['fldState'] == 'South Dakota') echo 'selected'; ?>>South Dakota</option>
               <option value='Tennessee' <?php if ($college_address_info[0]['fldState'] == 'Tennessee') echo 'selected'; ?>>Tennessee</option>
               <option value='Texas' <?php if ($college_address_info[0]['fldState'] == 'Texas') echo 'selected'; ?>>Texas</option>
               <option value='Utah' <?php if ($college_address_info[0]['fldState'] == 'Utah') echo 'selected'; ?>>Utah</option>
               <option value='Virginia' <?php if ($college_address_info[0]['fldState'] == 'Virginia') echo 'selected'; ?>>Virginia</option>
               <option value='Vermont' <?php if ($college_address_info[0]['fldState'] == 'Vermont') echo 'selected'; ?>>Vermont</option>
               <option value='Washington' <?php if ($college_address_info[0]['fldState'] == 'Washington') echo 'selected'; ?>>Washington</option>
               <option value='Wisconsin' <?php if ($college_address_info[0]['fldState'] == 'Wisconsin') echo 'selected'; ?>>Wisconsin</option>
               <option value='West Virginia' <?php if ($college_address_info[0]['fldState'] == 'West Virginia') echo 'selected'; ?>>West Virginia</option>
               <option value='Wyoming' <?php if ($college_address_info[0]['fldState'] == 'Wyoming') echo 'selected'; ?>>Wyoming</option>
               </optgroup>
                <optgroup label="Canada">
               <option value='Alberta' <?php if ($college_address_info[0]['fldState'] == 'Alberta') echo 'selected'; ?>>Alberta</option>
               <option value='British Columbia' <?php if ($college_address_info[0]['fldState'] == 'British Columbia') echo 'selected'; ?>>British Columbia</option>
               <option value='Manitoba' <?php if ($college_address_info[0]['fldState'] == 'Manitoba') echo 'selected'; ?>>Manitoba</option>
               <option value='New Brunswick' <?php if ($college_address_info[0]['fldState'] == 'New Brunswick') echo 'selected'; ?>>New Brunswick</option>
               <option value='Newfoundland' <?php if ($college_address_info[0]['fldState'] == 'Newfoundland') echo 'selected'; ?>>Newfoundland</option>
               <option value='Northwest Territories' <?php if ($college_address_info[0]['fldState'] == 'Northwest Territories') echo 'selected'; ?>>Northwest Territories</option>
               <option value='Nova Scotia' <?php if ($college_address_info[0]['fldState'] == 'Nova Scotia') echo 'selected'; ?>>Nova Scotia</option>
               <option value='Nunavut' <?php if ($college_address_info[0]['fldState'] == 'Nunavut') echo 'selected'; ?>>Nunavut</option>
               <option value='Ontario' <?php if ($college_address_info[0]['fldState'] == 'Ontario') echo 'selected'; ?>>Ontario</option>
               <option value='Prince Edward Island' <?php if ($college_address_info[0]['fldState'] == 'Prince Edward Island') echo 'selected'; ?>>Prince Edward Island</option>
               <option value='Quebec' <?php if ($college_address_info[0]['fldState'] == 'Quebec') echo 'selected'; ?>>Quebec</option>
               <option value='Saskatchewan' <?php if ($college_address_info[0]['fldState'] == 'Saskatchewan') echo 'selected'; ?>>Saskatchewan</option>
               <option value='Yukon Territory' <?php if ($college_address_info[0]['fldState'] == 'Yukon Territory') echo 'selected'; ?>>Yukon Territory</option>
               </optgroup>
            </select><font color="#0000ff">&nbsp;*</font>                                            
        </span><label>Zip Code:</label><span>	<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_other_info[0]['fldZipCode']?>" >	<font color="#0000ff">&nbsp;*</font></span>
	</div><?php
    }
    else if($q!='select'){

    $college_address_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldId=".$q);
    //  print_r($college_address_info);?>
 <div class="greyed">  
<label>Address:</label><span>	<textarea rows=14 cols=69 name=fldAddress readonly><?=$college_address_info[0]['fldAddress']?></textarea><font color="#0000ff">&nbsp;*</font></span><br/><br/><br/><br/><br/><br/><label>City:</label><span>	<input type="text" name="fldCity" id="fldCity" value="<?=$college_address_info[0]['fldCity']?>" readonly>	<font color="#0000ff">&nbsp;*</font></span><br/><br/><label>State:</label>
	<span>
            <select name="fldState" readonly>
               <option value="select">Select State</option>
               <optgroup label="United States">
               <option value='Alaska' <?php if ($college_address_info[0]['fldState'] == 'Alaska') echo 'selected'; ?>>Alaska</option>
               <option value='Alabama' <?php if ($college_address_info[0]['fldState'] == 'Alabama') echo 'selected'; ?>>Alabama</option>
               <option value='Arkansas' <?php if ($college_address_info[0]['fldState'] == 'Arkansas') echo 'selected'; ?>>Arkansas</option>
               <option value='Arizona' <?php if ($college_address_info[0]['fldState'] == 'Arizona') echo 'selected'; ?>>Arizona</option>
               <option value='California' <?php if ($college_address_info[0]['fldState'] == 'California') echo 'selected'; ?>>California</option>
               <option value='Colorado' <?php if ($college_address_info[0]['fldState'] == 'Colorado') echo 'selected'; ?>>Colorado</option>
               <option value='Connecticut' <?php if ($college_address_info[0]['fldState'] == 'Connecticut') echo 'selected'; ?>>Connecticut</option>
               <option value='District of Columbia' <?php if ($college_address_info[0]['fldState'] == 'District of Columbia') echo 'selected'; ?>>District of Columbia</option>
               <option value='Delaware' <?php if ($college_address_info[0]['fldState'] == 'Delaware') echo 'selected'; ?>>Delaware</option>
               <option value='Florida' <?php if ($college_address_info[0]['fldState'] == 'Florida') echo 'selected'; ?>>Florida</option>
               <option value='Georgia' <?php if ($college_address_info[0]['fldState'] == 'Georgia') echo 'selected'; ?>>Georgia</option>
               <option value='Hawaii' <?php if ($college_address_info[0]['fldState'] == 'Hawaii') echo 'selected'; ?>>Hawaii</option>
               <option value='Iowa' <?php if ($college_address_info[0]['fldState'] == 'Iowa') echo 'selected'; ?>>Iowa</option>
               <option value='Idaho' <?php if ($college_address_info[0]['fldState'] == 'Idaho') echo 'selected'; ?>>Idaho</option>
               <option value='Illinois' <?php if ($college_address_info[0]['fldState'] == 'Illinois') echo 'selected'; ?>>Illinois</option>
               <option value='Indiana' <?php if ($college_address_info[0]['fldState'] == 'Indiana') echo 'selected'; ?>>Indiana</option>
               <option value='Kansas' <?php if ($college_address_info[0]['fldState'] == 'Kansas') echo 'selected'; ?>>Kansas</option>
               <option value='Kentucky' <?php if ($college_address_info[0]['fldState'] == 'Kentucky') echo 'selected'; ?>>Kentucky</option>
               <option value='Louisiana' <?php if ($college_address_info[0]['fldState'] == 'Louisiana') echo 'selected'; ?>>Louisiana</option>
               <option value='Massachusetts' <?php if ($college_address_info[0]['fldState'] == 'Massachusetts') echo 'selected'; ?>>Massachusetts</option>
               <option value='Maryland' <?php if ($college_address_info[0]['fldState'] == 'Maryland') echo 'selected'; ?>>Maryland</option>
               <option value='Maine' <?php if ($college_address_info[0]['fldState'] == 'Maine') echo 'selected'; ?>>Maine</option>
               <option value='Michigan' <?php if ($college_address_info[0]['fldState'] == 'Michigan') echo 'selected'; ?>>Michigan</option>
               <option value='Minnesota' <?php if ($college_address_info[0]['fldState'] == 'Minnesota') echo 'selected'; ?>>Minnesota</option>
               <option value='Missouri' <?php if ($college_address_info[0]['fldState'] == 'Missouri') echo 'selected'; ?>>Missouri</option>
               <option value='Mississippi' <?php if ($college_address_info[0]['fldState'] == 'Mississippi') echo 'selected'; ?>>Mississippi</option>
               <option value='Montana' <?php if ($college_address_info[0]['fldState'] == 'Montana') echo 'selected'; ?>>Montana</option>
               <option value='North Carolina' <?php if ($college_address_info[0]['fldState'] == 'North Carolina') echo 'selected'; ?>>North Carolina</option>
               <option value='North Dakota' <?php if ($college_address_info[0]['fldState'] == 'North Dakota') echo 'selected'; ?>>North Dakota</option>
               <option value='Nebraska' <?php if ($college_address_info[0]['fldState'] == 'Nebraska') echo 'selected'; ?>>Nebraska</option>
               <option value='New Hampshire' <?php if ($college_address_info[0]['fldState'] == 'New Hampshire') echo 'selected'; ?>>New Hampshire</option>
               <option value='New Jersey' <?php if ($college_address_info[0]['fldState'] == 'New Jersey') echo 'selected'; ?>>New Jersey</option>
               <option value='New Mexico' <?php if ($college_address_info[0]['fldState'] == 'New Mexico') echo 'selected'; ?>>New Mexico</option>
               <option value='Nevada' <?php if ($college_address_info[0]['fldState'] == 'Nevada') echo 'selected'; ?>>Nevada</option>
               <option value='New York' <?php if ($college_address_info[0]['fldState'] == 'New York') echo 'selected'; ?>>New York</option>
               <option value='Ohio' <?php if ($college_address_info[0]['fldState'] == 'Ohio') echo 'selected'; ?>>Ohio</option>
               <option value='Oklahoma' <?php if ($college_address_info[0]['fldState'] == 'Oklahoma') echo 'selected'; ?>>Oklahoma</option>
               <option value='Oregon' <?php if ($college_address_info[0]['fldState'] == 'Oregon') echo 'selected'; ?>>Oregon</option>
               <option value='Pennsylvania' <?php if ($college_address_info[0]['fldState'] == 'Pennsylvania') echo 'selected'; ?>>Pennsylvania</option>
               <option value='Puerto Rico' <?php if ($college_address_info[0]['fldState'] == 'Puerto Rico') echo 'selected'; ?>>Puerto Rico</option>
               <option value='Rhode Island' <?php if ($college_address_info[0]['fldState'] == 'Rhode Island') echo 'selected'; ?>>Rhode Island</option>
               <option value='South Carolina' <?php if ($college_address_info[0]['fldState'] == 'South Carolina') echo 'selected'; ?>>South Carolina</option>
               <option value='South Dakota' <?php if ($college_address_info[0]['fldState'] == 'South Dakota') echo 'selected'; ?>>South Dakota</option>
               <option value='Tennessee' <?php if ($college_address_info[0]['fldState'] == 'Tennessee') echo 'selected'; ?>>Tennessee</option>
               <option value='Texas' <?php if ($college_address_info[0]['fldState'] == 'Texas') echo 'selected'; ?>>Texas</option>
               <option value='Utah' <?php if ($college_address_info[0]['fldState'] == 'Utah') echo 'selected'; ?>>Utah</option>
               <option value='Virginia' <?php if ($college_address_info[0]['fldState'] == 'Virginia') echo 'selected'; ?>>Virginia</option>
               <option value='Vermont' <?php if ($college_address_info[0]['fldState'] == 'Vermont') echo 'selected'; ?>>Vermont</option>
               <option value='Washington' <?php if ($college_address_info[0]['fldState'] == 'Washington') echo 'selected'; ?>>Washington</option>
               <option value='Wisconsin' <?php if ($college_address_info[0]['fldState'] == 'Wisconsin') echo 'selected'; ?>>Wisconsin</option>
               <option value='West Virginia' <?php if ($college_address_info[0]['fldState'] == 'West Virginia') echo 'selected'; ?>>West Virginia</option>
               <option value='Wyoming' <?php if ($college_address_info[0]['fldState'] == 'Wyoming') echo 'selected'; ?>>Wyoming</option>
               </optgroup>
                <optgroup label="Canada">
               <option value='Alberta' <?php if ($college_address_info[0]['fldState'] == 'Alberta') echo 'selected'; ?>>Alberta</option>
               <option value='British Columbia' <?php if ($college_address_info[0]['fldState'] == 'British Columbia') echo 'selected'; ?>>British Columbia</option>
               <option value='Manitoba' <?php if ($college_address_info[0]['fldState'] == 'Manitoba') echo 'selected'; ?>>Manitoba</option>
               <option value='New Brunswick' <?php if ($college_address_info[0]['fldState'] == 'New Brunswick') echo 'selected'; ?>>New Brunswick</option>
               <option value='Newfoundland' <?php if ($college_address_info[0]['fldState'] == 'Newfoundland') echo 'selected'; ?>>Newfoundland</option>
               <option value='Northwest Territories' <?php if ($college_address_info[0]['fldState'] == 'Northwest Territories') echo 'selected'; ?>>Northwest Territories</option>
               <option value='Nova Scotia' <?php if ($college_address_info[0]['fldState'] == 'Nova Scotia') echo 'selected'; ?>>Nova Scotia</option>
               <option value='Nunavut' <?php if ($college_address_info[0]['fldState'] == 'Nunavut') echo 'selected'; ?>>Nunavut</option>
               <option value='Ontario' <?php if ($college_address_info[0]['fldState'] == 'Ontario') echo 'selected'; ?>>Ontario</option>
               <option value='Prince Edward Island' <?php if ($college_address_info[0]['fldState'] == 'Prince Edward Island') echo 'selected'; ?>>Prince Edward Island</option>
               <option value='Quebec' <?php if ($college_address_info[0]['fldState'] == 'Quebec') echo 'selected'; ?>>Quebec</option>
               <option value='Saskatchewan' <?php if ($college_address_info[0]['fldState'] == 'Saskatchewan') echo 'selected'; ?>>Saskatchewan</option>
               <option value='Yukon Territory' <?php if ($college_address_info[0]['fldState'] == 'Yukon Territory') echo 'selected'; ?>>Yukon Territory</option>
               </optgroup>
            </select><font color="#0000ff">&nbsp;*</font>                                            
        </span>
                                            <label>Zip Code:</label><span>	<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_info[0]['fldZipCode']?>" readonly>	<font color="#0000ff">&nbsp;*</font></span>
	</div><?php
    }?>
