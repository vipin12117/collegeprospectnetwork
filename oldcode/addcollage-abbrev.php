<div class="yellow">
    
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
    
<label>College Name:</label><span>	<input type="text" name="txtfldName" id="txtfldName" class="yellow"><?=$txtfldName?><font color="#0000ff">&nbsp;*</font></span><label>Address:</label><span style="padding-bottom:10px;"> 	<textarea rows=14 cols=69 name=fldAddress><?=$college_address_other_info[0]['fldAddress']?></textarea><font color="#0000ff">&nbsp;*</font></span><br/><br/><label>City:</label><span>	<input type="text" name="fldCity" id="fldCity" value="<?=$college_address_other_info[0]['fldCity']?>" >	<font color="#0000ff">&nbsp;*</font></span><br/><br/><label>State:</label>    <span>
            <select name="fldState">
               <option value="select">Select State</option>
               <optgroup label="United States">
               <option value='AK' <?php if ($college_address_info[0]['fldState'] == 'AK') echo 'selected'; ?>>Alaska</option>
               <option value='AL' <?php if ($college_address_info[0]['fldState'] == 'AL') echo 'selected'; ?>>Alabama</option>
               <option value='AR' <?php if ($college_address_info[0]['fldState'] == 'AR') echo 'selected'; ?>>Arkansas</option>
               <option value='AZ' <?php if ($college_address_info[0]['fldState'] == 'AZ') echo 'selected'; ?>>Arizona</option>
               <option value='CA' <?php if ($college_address_info[0]['fldState'] == 'CA') echo 'selected'; ?>>California</option>
               <option value='CO' <?php if ($college_address_info[0]['fldState'] == 'CO') echo 'selected'; ?>>Colorado</option>
               <option value='CT' <?php if ($college_address_info[0]['fldState'] == 'CT') echo 'selected'; ?>>Connecticut</option>
               <option value='DC' <?php if ($college_address_info[0]['fldState'] == 'DC') echo 'selected'; ?>>District of Columbia</option>
               <option value='DE' <?php if ($college_address_info[0]['fldState'] == 'DE') echo 'selected'; ?>>Delaware</option>
               <option value='FL' <?php if ($college_address_info[0]['fldState'] == 'FL') echo 'selected'; ?>>Florida</option>
               <option value='GA' <?php if ($college_address_info[0]['fldState'] == 'GA') echo 'selected'; ?>>Georgia</option>
               <option value='HI' <?php if ($college_address_info[0]['fldState'] == 'HI') echo 'selected'; ?>>Hawaii</option>
               <option value='IA' <?php if ($college_address_info[0]['fldState'] == 'IA') echo 'selected'; ?>>Iowa</option>
               <option value='ID' <?php if ($college_address_info[0]['fldState'] == 'ID') echo 'selected'; ?>>Idaho</option>
               <option value='IL' <?php if ($college_address_info[0]['fldState'] == 'IL') echo 'selected'; ?>>Illinois</option>
               <option value='IN' <?php if ($college_address_info[0]['fldState'] == 'IN') echo 'selected'; ?>>Indiana</option>
               <option value='KS' <?php if ($college_address_info[0]['fldState'] == 'KS') echo 'selected'; ?>>Kansas</option>
               <option value='KY' <?php if ($college_address_info[0]['fldState'] == 'KY') echo 'selected'; ?>>Kentucky</option>
               <option value='LA' <?php if ($college_address_info[0]['fldState'] == 'LA') echo 'selected'; ?>>Louisiana</option>
               <option value='MA' <?php if ($college_address_info[0]['fldState'] == 'MA') echo 'selected'; ?>>Massachusetts</option>
               <option value='MD' <?php if ($college_address_info[0]['fldState'] == 'MD') echo 'selected'; ?>>Maryland</option>
               <option value='ME' <?php if ($college_address_info[0]['fldState'] == 'ME') echo 'selected'; ?>>Maine</option>
               <option value='MI' <?php if ($college_address_info[0]['fldState'] == 'MI') echo 'selected'; ?>>Michigan</option>
               <option value='MN' <?php if ($college_address_info[0]['fldState'] == 'MN') echo 'selected'; ?>>Minnesota</option>
               <option value='MO' <?php if ($college_address_info[0]['fldState'] == 'MO') echo 'selected'; ?>>Missouri</option>
               <option value='MS' <?php if ($college_address_info[0]['fldState'] == 'MS') echo 'selected'; ?>>Mississippi</option>
               <option value='MT' <?php if ($college_address_info[0]['fldState'] == 'MT') echo 'selected'; ?>>Montana</option>
               <option value='NC' <?php if ($college_address_info[0]['fldState'] == 'NC') echo 'selected'; ?>>North Carolina</option>
               <option value='ND' <?php if ($college_address_info[0]['fldState'] == 'MD') echo 'selected'; ?>>North Dakota</option>
               <option value='NE' <?php if ($college_address_info[0]['fldState'] == 'ME') echo 'selected'; ?>>Nebraska</option>
               <option value='NH' <?php if ($college_address_info[0]['fldState'] == 'NH') echo 'selected'; ?>>New Hampshire</option>
               <option value='NJ' <?php if ($college_address_info[0]['fldState'] == 'NJ') echo 'selected'; ?>>New Jersey</option>
               <option value='NM' <?php if ($college_address_info[0]['fldState'] == 'NM') echo 'selected'; ?>>New Mexico</option>
               <option value='NV' <?php if ($college_address_info[0]['fldState'] == 'NV') echo 'selected'; ?>>Nevada</option>
               <option value='NY' <?php if ($college_address_info[0]['fldState'] == 'NY') echo 'selected'; ?>>New York</option>
               <option value='OH' <?php if ($college_address_info[0]['fldState'] == 'OH') echo 'selected'; ?>>Ohio</option>
               <option value='OK' <?php if ($college_address_info[0]['fldState'] == 'OK') echo 'selected'; ?>>Oklahoma</option>
               <option value='OR' <?php if ($college_address_info[0]['fldState'] == 'OR') echo 'selected'; ?>>Oregon</option>
               <option value='PA' <?php if ($college_address_info[0]['fldState'] == 'PA') echo 'selected'; ?>>Pennsylvania</option>
               <option value='PR' <?php if ($college_address_info[0]['fldState'] == 'PR') echo 'selected'; ?>>Puerto Rico</option>
               <option value='RI' <?php if ($college_address_info[0]['fldState'] == 'RI') echo 'selected'; ?>>Rhode Island</option>
               <option value='SC' <?php if ($college_address_info[0]['fldState'] == 'SC') echo 'selected'; ?>>South Carolina</option>
               <option value='SD' <?php if ($college_address_info[0]['fldState'] == 'SD') echo 'selected'; ?>>South Dakota</option>
               <option value='TN' <?php if ($college_address_info[0]['fldState'] == 'TN') echo 'selected'; ?>>Tennessee</option>
               <option value='TX' <?php if ($college_address_info[0]['fldState'] == 'TX') echo 'selected'; ?>>Texas</option>
               <option value='UT' <?php if ($college_address_info[0]['fldState'] == 'UT') echo 'selected'; ?>>Utah</option>
               <option value='VA' <?php if ($college_address_info[0]['fldState'] == 'VA') echo 'selected'; ?>>Virginia</option>
               <option value='VT' <?php if ($college_address_info[0]['fldState'] == 'VT') echo 'selected'; ?>>Vermont</option>
               <option value='WA' <?php if ($college_address_info[0]['fldState'] == 'WA') echo 'selected'; ?>>Washington</option>
               <option value='WI' <?php if ($college_address_info[0]['fldState'] == 'WI') echo 'selected'; ?>>Wisconsin</option>
               <option value='WV' <?php if ($college_address_info[0]['fldState'] == 'WV') echo 'selected'; ?>>West Virginia</option>
               <option value='WY' <?php if ($college_address_info[0]['fldState'] == 'WY') echo 'selected'; ?>>Wyoming</option>
               </optgroup>
                <optgroup label="Canada">
               <option value='AB' <?php if ($college_address_info[0]['fldState'] == 'AB') echo 'selected'; ?>>Alberta</option>
               <option value='BC' <?php if ($college_address_info[0]['fldState'] == 'BC') echo 'selected'; ?>>British Columbia</option>
               <option value='MB' <?php if ($college_address_info[0]['fldState'] == 'MB') echo 'selected'; ?>>Manitoba</option>
               <option value='NB' <?php if ($college_address_info[0]['fldState'] == 'NB') echo 'selected'; ?>>New Brunswick</option>
               <option value='NF' <?php if ($college_address_info[0]['fldState'] == 'NF') echo 'selected'; ?>>Newfoundland</option>
               <option value='NT' <?php if ($college_address_info[0]['fldState'] == 'NT') echo 'selected'; ?>>Northwest Territories</option>
               <option value='NS' <?php if ($college_address_info[0]['fldState'] == 'NS') echo 'selected'; ?>>Nova Scotia</option>
               <option value='NU' <?php if ($college_address_info[0]['fldState'] == 'NU') echo 'selected'; ?>>Nunavut</option>
               <option value='ON' <?php if ($college_address_info[0]['fldState'] == 'ON') echo 'selected'; ?>>Ontario</option>
               <option value='PE' <?php if ($college_address_info[0]['fldState'] == 'PE') echo 'selected'; ?>>Prince Edward Island</option>
               <option value='QC' <?php if ($college_address_info[0]['fldState'] == 'QC') echo 'selected'; ?>>Quebec</option>
               <option value='SK' <?php if ($college_address_info[0]['fldState'] == 'SK') echo 'selected'; ?>>Saskatchewan</option>
               <option value='YT' <?php if ($college_address_info[0]['fldState'] == 'YT') echo 'selected'; ?>>Yukon Territory</option>
               </optgroup>
            </select><font color="#0000ff">&nbsp;*</font>                                            
        </span><label>Zip Code:</label><span>	<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_other_info[0]['fldZipCode']?>" >	<font color="#0000ff">&nbsp;*</font></span><?php
    }
    else if($q!='select'){

    $college_address_info=$func->selectTableOrder(TBL_COLLEGE,"fldId,fldName,fldAddress,fldCity,fldState,fldZipCode","fldId","where fldStatus =1 and fldId=".$q);
    //  print_r($college_address_info);?>
<label>Address:</label><span>	<textarea rows=14 cols=69 name=fldAddress><?=$college_address_info[0]['fldAddress']?></textarea><font color="#0000ff">&nbsp;*</font></span><br/><br/><br/><br/><br/><br/><label>City:</label><span>	<input type="text" name="fldCity" id="fldCity" value="<?=$college_address_info[0]['fldCity']?>" >	<font color="#0000ff">&nbsp;*</font></span><br/><br/><label>State:</label>
	<span>
            <select name="fldState">
               <option value="select">Select State</option>
               <optgroup label="United States">
               <option value='AK' <?php if ($college_address_info[0]['fldState'] == 'AK') echo 'selected'; ?>>Alaska</option>
               <option value='AL' <?php if ($college_address_info[0]['fldState'] == 'AL') echo 'selected'; ?>>Alabama</option>
               <option value='AR' <?php if ($college_address_info[0]['fldState'] == 'AR') echo 'selected'; ?>>Arkansas</option>
               <option value='AZ' <?php if ($college_address_info[0]['fldState'] == 'AZ') echo 'selected'; ?>>Arizona</option>
               <option value='CA' <?php if ($college_address_info[0]['fldState'] == 'CA') echo 'selected'; ?>>California</option>
               <option value='CO' <?php if ($college_address_info[0]['fldState'] == 'CO') echo 'selected'; ?>>Colorado</option>
               <option value='CT' <?php if ($college_address_info[0]['fldState'] == 'CT') echo 'selected'; ?>>Connecticut</option>
               <option value='DC' <?php if ($college_address_info[0]['fldState'] == 'DC') echo 'selected'; ?>>District of Columbia</option>
               <option value='DE' <?php if ($college_address_info[0]['fldState'] == 'DE') echo 'selected'; ?>>Delaware</option>
               <option value='FL' <?php if ($college_address_info[0]['fldState'] == 'FL') echo 'selected'; ?>>Florida</option>
               <option value='GA' <?php if ($college_address_info[0]['fldState'] == 'GA') echo 'selected'; ?>>Georgia</option>
               <option value='HI' <?php if ($college_address_info[0]['fldState'] == 'HI') echo 'selected'; ?>>Hawaii</option>
               <option value='IA' <?php if ($college_address_info[0]['fldState'] == 'IA') echo 'selected'; ?>>Iowa</option>
               <option value='ID' <?php if ($college_address_info[0]['fldState'] == 'ID') echo 'selected'; ?>>Idaho</option>
               <option value='IL' <?php if ($college_address_info[0]['fldState'] == 'IL') echo 'selected'; ?>>Illinois</option>
               <option value='IN' <?php if ($college_address_info[0]['fldState'] == 'IN') echo 'selected'; ?>>Indiana</option>
               <option value='KS' <?php if ($college_address_info[0]['fldState'] == 'KS') echo 'selected'; ?>>Kansas</option>
               <option value='KY' <?php if ($college_address_info[0]['fldState'] == 'KY') echo 'selected'; ?>>Kentucky</option>
               <option value='LA' <?php if ($college_address_info[0]['fldState'] == 'LA') echo 'selected'; ?>>Louisiana</option>
               <option value='MA' <?php if ($college_address_info[0]['fldState'] == 'MA') echo 'selected'; ?>>Massachusetts</option>
               <option value='MD' <?php if ($college_address_info[0]['fldState'] == 'MD') echo 'selected'; ?>>Maryland</option>
               <option value='ME' <?php if ($college_address_info[0]['fldState'] == 'ME') echo 'selected'; ?>>Maine</option>
               <option value='MI' <?php if ($college_address_info[0]['fldState'] == 'MI') echo 'selected'; ?>>Michigan</option>
               <option value='MN' <?php if ($college_address_info[0]['fldState'] == 'MN') echo 'selected'; ?>>Minnesota</option>
               <option value='MO' <?php if ($college_address_info[0]['fldState'] == 'MO') echo 'selected'; ?>>Missouri</option>
               <option value='MS' <?php if ($college_address_info[0]['fldState'] == 'MS') echo 'selected'; ?>>Mississippi</option>
               <option value='MT' <?php if ($college_address_info[0]['fldState'] == 'MT') echo 'selected'; ?>>Montana</option>
               <option value='NC' <?php if ($college_address_info[0]['fldState'] == 'NC') echo 'selected'; ?>>North Carolina</option>
               <option value='ND' <?php if ($college_address_info[0]['fldState'] == 'MD') echo 'selected'; ?>>North Dakota</option>
               <option value='NE' <?php if ($college_address_info[0]['fldState'] == 'ME') echo 'selected'; ?>>Nebraska</option>
               <option value='NH' <?php if ($college_address_info[0]['fldState'] == 'NH') echo 'selected'; ?>>New Hampshire</option>
               <option value='NJ' <?php if ($college_address_info[0]['fldState'] == 'NJ') echo 'selected'; ?>>New Jersey</option>
               <option value='NM' <?php if ($college_address_info[0]['fldState'] == 'NM') echo 'selected'; ?>>New Mexico</option>
               <option value='NV' <?php if ($college_address_info[0]['fldState'] == 'NV') echo 'selected'; ?>>Nevada</option>
               <option value='NY' <?php if ($college_address_info[0]['fldState'] == 'NY') echo 'selected'; ?>>New York</option>
               <option value='OH' <?php if ($college_address_info[0]['fldState'] == 'OH') echo 'selected'; ?>>Ohio</option>
               <option value='OK' <?php if ($college_address_info[0]['fldState'] == 'OK') echo 'selected'; ?>>Oklahoma</option>
               <option value='OR' <?php if ($college_address_info[0]['fldState'] == 'OR') echo 'selected'; ?>>Oregon</option>
               <option value='PA' <?php if ($college_address_info[0]['fldState'] == 'PA') echo 'selected'; ?>>Pennsylvania</option>
               <option value='PR' <?php if ($college_address_info[0]['fldState'] == 'PR') echo 'selected'; ?>>Puerto Rico</option>
               <option value='RI' <?php if ($college_address_info[0]['fldState'] == 'RI') echo 'selected'; ?>>Rhode Island</option>
               <option value='SC' <?php if ($college_address_info[0]['fldState'] == 'SC') echo 'selected'; ?>>South Carolina</option>
               <option value='SD' <?php if ($college_address_info[0]['fldState'] == 'SD') echo 'selected'; ?>>South Dakota</option>
               <option value='TN' <?php if ($college_address_info[0]['fldState'] == 'TN') echo 'selected'; ?>>Tennessee</option>
               <option value='TX' <?php if ($college_address_info[0]['fldState'] == 'TX') echo 'selected'; ?>>Texas</option>
               <option value='UT' <?php if ($college_address_info[0]['fldState'] == 'UT') echo 'selected'; ?>>Utah</option>
               <option value='VA' <?php if ($college_address_info[0]['fldState'] == 'VA') echo 'selected'; ?>>Virginia</option>
               <option value='VT' <?php if ($college_address_info[0]['fldState'] == 'VT') echo 'selected'; ?>>Vermont</option>
               <option value='WA' <?php if ($college_address_info[0]['fldState'] == 'WA') echo 'selected'; ?>>Washington</option>
               <option value='WI' <?php if ($college_address_info[0]['fldState'] == 'WI') echo 'selected'; ?>>Wisconsin</option>
               <option value='WV' <?php if ($college_address_info[0]['fldState'] == 'WV') echo 'selected'; ?>>West Virginia</option>
               <option value='WY' <?php if ($college_address_info[0]['fldState'] == 'WY') echo 'selected'; ?>>Wyoming</option>
               </optgroup>
                <optgroup label="Canada">
               <option value='AB' <?php if ($college_address_info[0]['fldState'] == 'AB') echo 'selected'; ?>>Alberta</option>
               <option value='BC' <?php if ($college_address_info[0]['fldState'] == 'BC') echo 'selected'; ?>>British Columbia</option>
               <option value='MB' <?php if ($college_address_info[0]['fldState'] == 'MB') echo 'selected'; ?>>Manitoba</option>
               <option value='NB' <?php if ($college_address_info[0]['fldState'] == 'NB') echo 'selected'; ?>>New Brunswick</option>
               <option value='NF' <?php if ($college_address_info[0]['fldState'] == 'NF') echo 'selected'; ?>>Newfoundland</option>
               <option value='NT' <?php if ($college_address_info[0]['fldState'] == 'NT') echo 'selected'; ?>>Northwest Territories</option>
               <option value='NS' <?php if ($college_address_info[0]['fldState'] == 'NS') echo 'selected'; ?>>Nova Scotia</option>
               <option value='NU' <?php if ($college_address_info[0]['fldState'] == 'NU') echo 'selected'; ?>>Nunavut</option>
               <option value='ON' <?php if ($college_address_info[0]['fldState'] == 'ON') echo 'selected'; ?>>Ontario</option>
               <option value='PE' <?php if ($college_address_info[0]['fldState'] == 'PE') echo 'selected'; ?>>Prince Edward Island</option>
               <option value='QC' <?php if ($college_address_info[0]['fldState'] == 'QC') echo 'selected'; ?>>Quebec</option>
               <option value='SK' <?php if ($college_address_info[0]['fldState'] == 'SK') echo 'selected'; ?>>Saskatchewan</option>
               <option value='YT' <?php if ($college_address_info[0]['fldState'] == 'YT') echo 'selected'; ?>>Yukon Territory</option>
               </optgroup>
            </select><font color="#0000ff">&nbsp;*</font>                                            
        </span>
                                            <label>Zip Code:</label><span>	<input type="text" name="fldZipCode" id="fldZipCode" value="<?=$college_address_info[0]['fldZipCode']?>" >	<font color="#0000ff">&nbsp;*</font></span><?php
    }?></div>
