<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##	Page name	:		common_functions.php
##	Create Date	:		23/06/2009
##  Description :		These functions fetch the data from database and other won define function.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("db.inc.php");	//for database connection
$db = new DB;	//Create an instance of class DB
$db1 = clone $db;	//Create an instance of class DB
$db2 = clone $db;	//Create an instance of class DB
$db3 = clone $db;
//$db4 = clone $db;

class COMMONFUNC {
	
	
	
	//This function checks whether the username & password are registered with the session If not registered, it will redirect index page to the Login Page.
	function checkLoggedIn()
	{
		if(!$_SESSION["USER_ID"] && !$_SESSION["USER_EMAIL"] && !$_SESSION["USER_TYPE"])
		{
			header("Location:./index.php");
			
			exit;
		}
	}
	
	
   // Return Trial Mode - 1=true, 0 = false
   function IsTrialMode()
   {
        if ($_SESSION['fldSubscribe'] == 2) {
            //Trial
            $returnVal = 1;
        }
        else if ($_SESSION['fldSubscribe'] == 1) {
            //Valid Subscription
            $returnVal = 0;
        }   
        else if ($_SESSION['fldSubscribe'] == 0) {
            //Inactive
            $returnVal = 0;
        }
         
        return $returnVal;
    }
   
   
   
    // Subscription - Time Left In Trial
   function GetTrialTimeLeft($fldAddDate)
   {
        $SubscriptionStartDate= $fldAddDate;
        $SubscriptionStartDatePlus5 = strtotime ( '+5 day' , strtotime ( $SubscriptionStartDate ) ) ;
        $SubscriptionEndDateFormatted = date ( 'F j, Y' , $SubscriptionStartDatePlus5 );
        
        $now = strtotime(date("now")); // or your date as well
        $your_date = $SubscriptionStartDatePlus5;

        $datediff = $your_date - $now;
        $days =  (floor($datediff/(60*60*24))) + 1;        
       
        $strReturn = $SubscriptionEndDateFormatted . ' - <span class="trial_daysleft">' . $days . ' Days Left</span>';
         
        return $strReturn;
    }
   
      // Subscription - Time Left in Subscription
   function GetSubscriptionTimeLeft()
   {
        $date = "1995-08-14";
        $newdate = strtotime ( '-5 day' , strtotime ( $date ) ) ;
        $newdate = date ( 'm-j-Y' , $newdate );
         
        return $newdate;
    }
    
   
   // Subscription - Get Subscriptions
   function GetValidSubscriptions($CollegeCoachId)
   {
        $date = "1998-08-14";
        $newdate = strtotime ( '-3 day' , strtotime ( $date ) ) ;
        $newdate = date ( 'Y-m-j' , $newdate );
         
        return $newdate;
    }
   
   // Subscription - Get Subscriptions
   function GetAllSubscriptionsByDate($CollegeCoachId)
   {
        $date = "1998-08-14";
        $newdate = strtotime ( '-3 day' , strtotime ( $date ) ) ;
        $newdate = date ( 'Y-m-j' , $newdate );
         
        return $newdate;
    }
   
 
		
    function sportmenu()
	{
		
		$sid=$_GET["q"];
	
	 $selquery = 'select s.fldSportsname as name,s.fldId as id from tbl_sports s,tbl_school_sport_coach ts where s.fldId=ts.sportid and ts.schoolid ='.$sid;
	$objquery = mysql_query($selquery);
	$numquery = mysql_num_rows($objquery);
	
	$strcombo = '';
		while($resquery=mysql_fetch_array($objquery))
		{
			if($resquery['id']==$_REQUEST['cid'])
			{
				
					$strcombo .='<option value="'.$resquery['id'].'" selected="selected">';
					$strcombo .= $resquery['name'].'</option>';
			}
			
			else
			 {
				
					$strcombo .='<option value="'.$resquery['id'].'">';
					$strcombo .= $resquery['name'].'</option>';
			}
		}
	return $strcombo;
	}
	
	// used to calculate latitude and longitude
function getLatLong($code,$mapkey){
 $mapsApiKey = $mapkey;
 $query = "http://maps.google.co.uk/maps/geo?q=".urlencode($code)."&output=json&key=".$mapsApiKey;
 $data = file_get_contents($query);
 
 if($data){
  // convert into readable format
  $data = json_decode($data);
  $long = $data->Placemark[0]->Point->coordinates[0];
  $lat = $data->Placemark[0]->Point->coordinates[1];
  return array('Latitude'=>$lat,'Longitude'=>$long);
 }else{
  return false;
 }
}




	
	
	
	
	
	//This Function Checks whether the username/password supplied by the admin is correct/valid
	function check_login($login,$password)
	{
		global $db;
		$sql="select ".ADMINID.",".FNAME.",".LNAME.",".EMAILID." from ".TBL_ADMIN." where ".USERNAME."='$login' and ".PASS."='$password' and ".LOGINSTATUS."='A'";
		$db->query($sql);
		$db->next_record();
		$nums[ADMINID]     = $db->f(ADMINID);
		$nums[FNAME]       = $db->f(FNAME);
		$nums[LNAME]       = $db->f(LNAME);
		$nums[EMAILID]     = $db->f(EMAILID);
		$nums["rows"]      = $db->num_rows(); 
		return $nums;
	}
	
	//Update admin table for New IP & Current Datetime
	//Parameters: IP address
	function updateAdmin($MyIP)
	{
		global $db;
		$sql = "update ".TBL_ADMIN." set ".LOGINIP."='".$MyIP."', ".LASTACCESS."=now()";
		$db->query($sql);
	}

	//This function converts the date of format YYYY-mm-dd to 25th June 2007 returns: $string
	//Parameters: date
	function dateFormatFrontEnd($date){
	    $formatedDate = "";
	       if($date!=""){
	           list($Y,$m,$d) = explode("-",$date);
        	    $formatedDate = date("jS F Y", mktime(0,0,0,$m,$d,$Y));
	       }    
	    return $formatedDate;
	}
	
	//FOR SHOWING DATE AS UK FORMAT
	//Parameters:date
	function  sHOW_DATE($dATE)
	{
		$EXPLODE_DATE	=	explode("-",$dATE);	
		$TAKE_MONTH		=	$this->sHOW_MONTH($EXPLODE_DATE[1]);
		$RETURN_VALUE	=	$EXPLODE_DATE[2]."-".$TAKE_MONTH."-".$EXPLODE_DATE[0];
		return $RETURN_VALUE;
	}
	
	//FOR SHOWING MONTH AS UK FORMAT
	function  sHOW_MONTH($dATE)
	{
		$TAKE_ALL_MONTH	=	array("01"=>"Jan","02"=>"Feb","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
		foreach ($TAKE_ALL_MONTH as $key=>$value)
		{
			if($key	==	$dATE)
			{
				return $value;
			}
		}
	}	
	
	
	function selectTable($table,$fields)
	{
		global $db;
		$Array_Fields = explode(',',$fields);
		$sql = "select * from ".$table;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		return $result_info;
	}
	
	
	function selectTableOrder($table,$fields,$order,$where="")
	{
		global $db;
		$Array_Fields = explode(',',$fields);
	     $sql = "select * from ".$table ." ".$where." order by ".$order;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	
	
        function selectTableOrderGroup($table,$fields,$groupby,$where)
    {
        global $db;
        $Array_Fields = explode(',',$fields);
         $sql = "select * from ".$table ." ".$where." group by ".$groupby;
        $db->query($sql);
        $db->next_record();
        
        for($k=0;$k<$db->num_rows();$k++)
        {
            for($i=0;$i<=count($Array_Fields);$i++)
            {
                $result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
            }
            $db->next_record();
        }
        
        return $result_info;
    }
    
	function selectTableOrdergroupby($table,$fields,$groupby,$where)
	{
		global $db;
		$Array_Fields = explode(',',$fields);
	     $sql = "select * from ".$table ." ".$where." group by ".$groupby;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	// to find location
	function findDefaultLocation($table,$fields,$order)
	{
		global $db;
		$Array_Fields = explode(',',$fields);
		$sql = "select * from ".$table." order by ".$order;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	// used to find list of school according to the list of sports item
	function selectSchool($id)
	{
		global $db;
		
		$sql="select *from tbl_HS_AAU_team as sc join tbl_HS_AAU_team_coach as sp on sc.fldid=sp.schoolid
and sp.sportid=".$id;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			
			$result_info[$k]['fldId'] = $db->f("fldId");
			$result_info[$k]['fldSchoolname'] = $db->f("fldSchoolname");
			$result_info[$k]['fldSchoolname'] = $db->f("fldSchoolname");
			$db->next_record();
		}
		
		return $result_info;
	}
	function school_sport_coach($id)
	{
		global $db;
		
		$sql="select * from tbl_HS_AAU_team_coach where schoolid=".$id;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			
				//$result_info[$k]['fldId'] = $db->f("fldId");
				$result_info[$k]['sportid'] = $db->f("sportid");
			$result_info[$k]['coachnameid'] = $db->f("coachnameid");
			$db->next_record();
		}
		
		return $result_info;
	}
	function collage_sport_coach($id)
	{
		global $db;
		
		$sql="select * from tbl_college_sport_coach where collegeid='".$id."'";
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			
				//$result_info[$k]['fldId'] = $db->f("fldId");
				$result_info[$k]['sportid'] = $db->f("sportid");
			$result_info[$k]['coachnameid'] = $db->f("coachnameid");
			$db->next_record();
		}
		
		return $result_info;
	}
	
	function selectTableLimit($table,$fields,$offset,$order)
	{
		global $db;
		$Array_Fields = explode(',',$fields);

		$sql = "select * from ".$table ." order by ".$order." limit ".$offset.",".TOTAL_RECORDS;
		
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	
	
	function selectTableLimitCon($table,$fields,$offset,$order,$con)
	{
		global $db;
		$Array_Fields = explode(',',$fields);

		  $sql = "select * from ".$table ."  where ".$con." order by ".$order." limit ".$offset.",".TOTAL_RECORDS;
		  $db->query($sql);
		  $db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
				
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	

	function selectTableCon($table,$fields,$con)
	{
		global $db;
		$Array_Fields = explode(',',$fields);
		
		$sql = "select * from ".$table." where ".$con;
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	
	
	function selectTableConGroup($table,$fields,$con,$group)
	{
		global $db;
		$Array_Fields = explode(',',$fields);
		
		$sql = "select * from ".$table." where ".$con." group by ".$group;
	
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}
	
	//Select from table with condition->parameter required : Table Name, & Fields required to get seperated by comma (,) & where clause conditions and group by clause and order by clause
	function selectTableConGroupOrderby($table,$fields,$con,$group,$order)
	{
		global $db;
		$Array_Fields = explode(',',$fields);			
		
		$sql = "select * from ".$table." where ".$con." group by ".$group." order by ".$order;
	
		$db->query($sql);
		$db->next_record();
		
		for($k=0;$k<$db->num_rows();$k++)
		{
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info[$k]["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		}
		
		return $result_info;
	}	

	//Select one record from table with condition->parameter required : Table Name, & Fields required to get seperated by comma (,) & where clause conditions
	function selectTableOnce($table,$fields,$con)
	{
		global $db;
		$Array_Fields = explode(',',$fields);

		$sql = "select * from ".$table." where ".$con;
		
		$db->query($sql);
		$db->next_record();
		
		
			for($i=0;$i<=count($Array_Fields);$i++)
			{
				$result_info["".$Array_Fields[$i].""] = $db->f("".$Array_Fields[$i]."");
			}
			$db->next_record();
		
		
		return $result_info;
	}

	//This function calculates the count of rows in a TABLE
	function totalRows($table)
	{
		global $db;
		$sql = "select count(*) as count from ".$table;
		$db->query($sql);
		$db->next_record();
		return $db->f('count');
	}
	
	//This function calculates the count of rows in a table with condition
	function totalRows1($table,$con)
	{
		global $db;
		$sql = "select count(*) as count from ".$table." where ".$con;
		$db->query($sql);
		$db->next_record();
		return $db->f('count');
	}

	//This function calculates the count of rows in a table
	function totalnumberRows($table,$field)
	{
		global $db;
		$sql = "select ".$field." from ".$table;
		$db->query($sql);
		$db->next_record();
		return $db->num_rows();
	}
	
	//This function calculates the count of rows in a TABLE whith condition
	function  totalRowsCondition($table,$con,$fieldName)
	{
		global $db;
		$sql = "select * from ".$table." where ".$fieldName."=".$con;
		$db->query($sql);
		$db->next_record();
		return $db->num_rows();
	 }

	 function  totalRowsCondition1($table,$con,$fieldName)
	 {
		global $db;
		$sql = "select * from ".$table." where ".$fieldName."=".$con;
		$db->query($sql);
		$db->next_record();
		return $db->num_rows();
	 }
	 
	//Update table
	//Parameters: Table name, Set Value & Condition
	function updateTable($table,$set,$con)
	{
		global $db;
		 $sql = "update ".$table." set ".$set." where ".$con;
		
		$db->query($sql);
	}	 
	 
	//Update table
	//Parameters: Table name, Set Value & Condition
	function update_tbl($table,$set)
	{
		global $db;
		 $sql = "update ".$table." set ".$set."";
		
		$db->query($sql);
	}
	
	//Add table
	//Parameters: Table name, Fields & value
	function addTable($table,$fields,$value)
	{
		global $db;
		 $sql = "insert into ".$table." (".$fields.") values (".$value.")";
		
		$db->query($sql);
	}
	
	//check the value exist or not
	//Parameters: Table name, Fields & value
	function checkExist($table,$where)
	{
		global $db;
		$sql = "select count(*) as count from ".$table." where ".$where;
		$db->query($sql);
		$db->next_record();
		return $db->f('count');
	}
	
	//Delete Record
	//Parameter : Table Name, $ Where clause
	function delete($table,$where)
	{
		global $db;
		$SQL = "DELETE FROM ".$table." WHERE ".$where;
		$db->query($SQL);	
	}

	
		
	 function upload_image($var, $field_name, $tbl_name,$newID, $field_id)
		{	
			if (!empty($_FILES[$var]['tmp_name']))
			 {
			   $upload_image		=	$_FILES[$var]['tmp_name'];
			   $imagefile_name		=	$_FILES[$var]['name'];
			   $imagefile_type		=	$_FILES[$var]['type'];
			   $imagefile_size		=   $_FILES[$var]['size'];
			  
			   $error="";
			   if (!empty($upload_image))
			   {
					$tname = explode(".",$imagefile_name);

					$newSmallImage = $var."_".$newID.".".$tname[1];
					if(is_uploaded_file($upload_image))
					{
						 if(($imagefile_type == "image/gif") || ($imagefile_type == "image/jpeg") || ($imagefile_type == "image/png") || ($imagefile_type == "image/pjpeg") || ($imagefile_type == "image/bmp"))
						 {
							 if(!is_dir("../image/".$var))
							 {
								 mkdir("../image/".$var,777);
							 }
							  $upfile = "../image/".$var."/".$newSmallImage;
							  //echo 
							  umask(0000);
							  copy($upload_image,$upfile);
							 
						 }
						 else {
							  $msg="1";
							 $newSmallImage = ""; }
					 }
					else { $newSmallImage = ""; }
				}
				else { $newSmallImage = ""; }
			}
			else { $newSmallImage = ""; }
			
			if($newSmallImage!="")
			{
			$update_sql="update ".$tbl_name." set `".$field_name."` = '".$newSmallImage."' where ".$field_id." = '".$newID."'";
		
			mysql_query($update_sql);
			return $msg;
			}
		}

	//Function for Exporting database into CSV file
	function export_csv($tablename,$filename,$field)
		 { 
		 	global $db;
			$sql = "select ".$field." from ".$tablename;
			$rs=$db->query($sql);
			$count = $db->num_fields();
			
					
			$str="";
			while ($info=mysql_fetch_row($rs))
			{
			for($i=0;$i<$count;$i++)
			$str .= "\"".stripslashes($info[$i])."\","; 
			 $str = substr($str,0,strlen($str)-1);
			 $str .="\n";						
			}
	
			 $file = "$filename.csv";
			 $fp = fopen($file,'w');
			 fwrite($fp,$str,strlen($str));
			 fclose($fp);
			 
			header('Content-type: application/vnd.ms-excel');
			header ("Content-disposition: attachment; filename=".basename($file).";");
			header("Content-Length: ".filesize($file));
			readfile($file);
			
	 }
	 
		
	//Function for Exporting database into CSV file having where clause
	function export_csvCon($tablename,$filename,$field,$con)
		 { 
		 	global $db;
			$sql = "select ".$field." from ".$tablename." where ".$con;
			$rs=$db->query($sql);
			$count = $db->num_fields();
			
					
			$str="";
			while ($info=mysql_fetch_row($rs))
			{
			for($i=0;$i<$count;$i++)
			$str .= "\"".stripslashes($info[$i])."\","; 
			 $str = substr($str,0,strlen($str)-1);
			 $str .="\n";						
			}
	
			 $file = "$filename.csv";
			 $fp = fopen($file,'w');
			 fwrite($fp,$str,strlen($str));
			 fclose($fp);
			 
			header('Content-type: application/vnd.ms-excel');
			header ("Content-disposition: attachment; filename=".basename($file).";");
			header("Content-Length: ".filesize($file));
			readfile($file);
			
	 }	 
		
	function displayorder_next($x)
	{
		global $db;
		$sql = "select fld_display_order from ".TBL_CLASS."  where fld_deleted='N' order by fld_display_order limit ".$x.", 1";			
		$db->query($sql);	
       	$db->next_record();       	
		return $db->f("fld_display_order");
	}	

	function orderClass()
	{
          global $db;
		  $sql = "select fld_class_id from ".TBL_CLASS." where fld_display_order='".$_REQUEST['newposition']."' and fld_deleted='N'";
          $db->query($sql);
		  $db->next_record();
  		  $new_fld_id= $db->f("fld_class_id");
		  
		  $sql = "select fld_class_id from ".TBL_CLASS." where fld_display_order='".$_REQUEST['position']."' and fld_deleted='N'";
          $db->query($sql);
		  $db->next_record();
  		  $old_fld_id= $db->f("fld_class_id");

		  $sql1 = "update ".TBL_CLASS." set fld_display_order='".$_REQUEST['position']."' where fld_class_id='".$new_fld_id."' and fld_deleted='N'";
		  $db->query($sql1);
		  
		  $sql2 = "update ".TBL_CLASS." set fld_display_order='".$_REQUEST['newposition']."' where fld_class_id='".$old_fld_id."' and fld_deleted='N'";
		  $db->query($sql2); 
	  }	
	
	
	//Page wise function
	//This function is use to display the record with paging standered
	function pagewise($numrows,$limit,$currenthit,$offset,$lnkScr,$lnkParam="")
	{
		    global $action,$cr,$lnkscr;
			$pages=intval($numrows/$limit);
			if ($numrows % $limit)
			{ 
				$pages++;
			}
	
			print "<table width=70% border=0 cellpadding=1 cellspacing=1>";
			print "<tr><td width=60% valign=top align=center class=normalgrey_12><B>Page:</B> ";
	
	
			if ($offset == 1) { $currenthit = $offset; }
			else { $currenthit = $offset + 1; }
	
			if (($numrows - $currenthit) >= $limit ) { $lasthit = $currenthit + ($limit - 1); }
			else { $lasthit = $numrows; }
	
			$selectedPg = sprintf("%.0f", (($currenthit/$limit) + 1));
			$j= 1;
			for ($i=1; $i<=$pages; $i++)
			{
				$newoffset = $limit * ($i - 1);
	
				if($selectedPg == $i) 
				{
					 print "<FONT  class=white_txt>$i</FONT>|"; 
				}
				else 
				{
					 print "<a href=".$lnkScr."?offset=$newoffset".$lnkParam." class=linkblue_12>$i</a>|"; 
				}
				$j++;
				if ($j == 30)
				{
				echo "<br>";
				$j = 1;
				}
			}
	
	
			echo "</td><td class=midtxt width=40% align=right>";
	
			if($offset!=0)
			{
				$cr=$offset-$limit;
			
			echo "<a href=".$lnkscr."?offset=$cr".$lnkParam." class=linkblue_12>Previous</a>";
	
	           if ($offset+($offset) >= $numrows)
	           {
	           		echo "&nbsp; &nbsp;";
	           }
	           else
	           {
	           		echo "&nbsp; &nbsp;";
	           }
			}
	
			if($offset<$numrows && (($numrows-$offset)>$limit))
			{
			
			   echo "<a href=".$lnkscr."?offset=$lasthit".$lnkParam." class=linkblue_12>Next</a>";
	
			}
	
	
			print "</td></tr>";
	
			print "</table>";
	}
	
	//this function is use to send mail.
	function mail_send($email_from,$subject,$sendto_email,$html_body,$plain_body,$randpath,$randfile)
	{
		
		$file = 
			$html_mime_mail = new htmlMimeMail();
			$html_mime_mail->setFrom($email_from);
			$html_mime_mail->setSubject($subject);
			$html_mime_mail->setHtml($html_body, $plain_body);
			if($randpath!='' && $randfile!=''){
			$html_mime_mail->addAttachment($html_mime_mail->getFile($randpath.$randfile),$randfile);
			}
			$success = $html_mime_mail->send(array($sendto_email),'smtp');
			return $success;
	
	}
	
	//Send Email via php Email function
	function sendEmail($toStr,$subjectStr,$bodyStr,$fromStr) {
	    
		//$from_email= $fromStr;
        
        $from_email = "notifications@collegeprospectnetwork.com";
        
        $to_email = $toStr;
        
        $headers  = "From: $from_email\r\n";
        
        $headers .= "Content-type: text/html\r\n";     
		
		if(!mail($to_email,$subjectStr,$bodyStr,$headers) ) {
		    
			die("Email can not be sent to specified email ID!");
            
		}
		else
		{
			return true;
		}
        
	}
	
	
	function input_fun($str){
		$output = trim(str_replace(chr(34),"&#34;",str_replace(chr(39),"&#39;",str_replace(chr(92),"&#92;",stripslashes($str) ))));
		return $output;
	}

	//use this function to use stripslashes, trim functions functionality
	function output_fun($str){
		$output = trim(str_replace("&#34;",chr(34),str_replace("&#39;",chr(39),str_replace("&#92;",chr(92),$str) )));
		return $output;
	}

	//Write a file the parameters are:	1)directory name 2)filename with file extension 3)contents  to write a file
	function writeFile($dirName,$filename,$contentStr) {

		$fullPath = $dirName."/".$filename;
		$fileStatus = 1;
		if (!$handle = fopen($fullPath, 'w')) {
			echo "Cannot open file ($filename)";
			exit;
		}
		// Write $somecontent to our opened file.
		if (fwrite($handle, $contentStr) === FALSE) {
			$fileStatus = 0;
		}
		@fclose($handle);
		return $fileStatus;
	}

	//Create a email template fot text mail format
	function  createEmailFormat($strArr,$NameArr) {
		$emailStr = "";
		global $userStatusArr;
		foreach ($NameArr as $key => $value)	 {
			if($value == 'Status: ' ) {
				$strArr[$key] = $userStatusArr[$strArr[$key]];
			}
			$emailStr .= $value.output_fun( $strArr[$key]) ." \r\n";
		}
		return 	$emailStr;
	}

	//This function is used to know whether the array passed as parameter is completely empty or not
	function isEmptyArray($arr) {
		for ($i=0;$i<count($arr);$i++) {
			if( trim( $arr[$i] ) != "" ) {
				break;
			}
		}
		if ($i==count($arr)) {
			return 1;
		} else {
			return 0;
		}
	}

	//No values in an array should be empty
	function isEmptyValueInArray($arr) {
		for ($i=0;$i<count($arr);$i++) {
			if( trim( $arr[$i] ) == "" ) {
				break;
			}
		}
		if ($i==count($arr)) {
			return 0;
		} else {
			return 1;
		}
	}

	//Function used to know whether a value is integer or not
	function str_is_int($str) {
		$var=intval($str);
		return ("$str"=="$var");
	}

	//Function checks whether array contains all integer values or empty
	function isIntegerValue( $arr ) {
		for ($i=0;$i<count($arr);$i++) {
			if( trim( $arr[$i] ) != ""  && (!str_is_int($arr[$i]) ) ) {
				break;
			}
		}
		if ($i==count($arr)) {
			return 1;
		} else {
			return 0;
		}
	}


	//create a combobox with the parameters
	//1)array string 2)name of combo box 3) selected value 4) css class
	//calling way is
	//createCombo($monthArr,"month",$month,"class=\"normalbodytxt\"");
	function createCombo($arr,$comboName,$sltValue,$cssClass='') 
	{
		$comboStr = "<select name=\"$comboName\" $cssClass>";
		foreach ($arr as $key => $value) {
			$sel = "";
			if( $sltValue == $key ){
				$sel = " selected ";
			}
			$comboStr .= "<option value=\"$key\" $sel>$value</option>";
		}
		$comboStr .= "</select>";
		return $comboStr;
	}
	
	//This function returns the image width and height
	function imageResize($imagePath){

		$thumbnail_small_width = 150;
        $thumbnail_small_height = 150;
           			
		$imgDimArr=array();
		list($height,$width) = @getimagesize($imagePath);
     			 
		if ($width > $height) {
		
			$thumb_s_w=$thumbnail_small_width;
			$thumb_s_h=$height*($thumbnail_small_height/$width);
		}
		if ($width < $height) {
			$thumb_s_w=$width*($thumbnail_small_width/$height);
			$thumb_s_h=$thumbnail_small_height;
		}
		if ($width == $height) {
			$thumb_s_w=$thumbnail_small_width;
			$thumb_s_h=$thumbnail_small_height;
		}

		$imgDimArr = array('width'=>$thumb_s_w, 'height'=>$thumb_s_h);
		return $imgDimArr;
	}
	
	function doRecurse($tableName, $fieldName, $parent=0, $separator=" ",$intCatLevel)
	{
		
		/*global $db;*/
		
	$SQL = "SELECT * FROM ".$tableName." WHERE ".$fieldName." = '".$parent."'"; 		
	
	$cat_items = mysql_query($SQL);
		
		WHILE ($cat_item = mysql_fetch_array($cat_items))
		{ 
            $cat_id  = $cat_item['fldId']; 
            $cat_name  = $cat_item['fldName']; 
            
            if (((int)$cat_id)==((int)$intCatLevel))
            {
				echo "<option value=\"$cat_id\" Selected>";
				echo $separator;
				echo $cat_name;
				echo "</option>\n"; 
            }
			else {
					echo "<option value=\"$cat_id\">";
					echo $separator;
					echo $cat_name;
					echo "</option>\n"; 
			}  
			        
			$this->doRecurse($tableName, $fieldName,$cat_id , $separator . " - ",$intCatLevel);
			
	    }
	    
	}
	
	function tep_get_categories($categories_array = '', $parent_id = '0', $indent = '') 
	{
	    global $db;
	    		
	    if (!is_array($categories_array)) $categories_array = array();
	    
	    $SQL = "SELECT * FROM ". TBL_ATHLETE_STATS_CATAGORY." WHERE fldParentId ='".(int)$parent_id."' ORDER BY fld_cat_name";
	     
	    $categories_query = $db->db_query($SQL);
	    	    
	    while ($categories = $db->tep_db_fetch_array($categories_query)) 
	    {
	    	$categories_array[] = array('id' => $categories['fld_cat_idPK'],
		                                'text' => $indent . $categories['fldName']);		                                
	      	if ($categories['fldId'] != $parent_id) {
	        	$categories_array = $this->tep_get_categories($categories_array, $categories['fldId'] , $indent . ' - ');
	      	}
	    }
	    
	    return $categories_array;
	}	
	
	function createmenu($parent_id, $i)
	{
		global $db;
		
		global $ids;
		
		static $k = 1;
		
		$SQL = "SELECT * FROM ".TBL_CATEGORY." WHERE fld_cat_parent_id ='".$parent_id."' ORDER BY fld_cat_idPK";
		
		$rec = $db->db_query($SQL);			
		
		while($row = $db->tep_db_fetch_array($rec)) 
		{
		?>
			d.add(<?=$k;?>,<?=$i?>,'<?=addslashes($row['fld_cat_name']);?>','','','','','','','<?=$row['fld_cat_idPK'];?>','0');
		<?
				if($row['fld_cat_idPK'] == $_REQUEST['ctg_id'])
				{
		?>
					selID = '<?php echo $k;?>';
		<?php
				}	
			$k++;
			
			$title_id = $row['fld_cat_idPK'];
			
			$count = $this->totalRowsCondition(TBL_CATEGORY, $title_id,"fld_cat_parent_id");		
			
			if($count > 0) {
				
				$this->createmenu($title_id, $k-1);
			}
		}
	}
	
	##############################	
	//delete category and subcategory start from here
	//deleting categories / subcategories records...
	function delete_cat_n_subcat($id, $offset)
	{	
		global $db;
		$this->delete_Category(TBL_CATEGORY, $id);
		 	
		$_REQUEST['msg']= "Category/Subcategory successfully deleted.";
	 	$count=$this->totalRows(TBL_CATEGORY);
	 	$offset=$_REQUEST['page']*10;
	 	if($count<=$offset)
	 	{
	 		$offset=$offset-$count;
	 		$_REQUEST['page'] =$offset/10;
	 	}	
    }
	
	
	//Deleting Category
	function delete_Category($tableName, $catID)
	{
		global $db;	
		$count = $this->totalRowsCondition($tableName, 'fldParentId',$catID);
		if($count > 0)
		{	# If child exists...
			$catinfo = $this->selectTableCon($tableName, "fld_cat_idPK,fld_cat_name", "fld_cat_parent_id=".$catID);
			
			foreach($catinfo as $cat) {
				
				$this->delete_posting($cat['fld_cat_idPK']);
				
				$this->delete($tableName, "fld_cat_idPK=".$cat['fld_cat_idPK']);
				
				$this->delete_Category($tableName, $cat['fld_cat_idPK']);				
			}
		}
		
		$this->delete_posting($catID);
		
		$this->delete($tableName, "fld_cat_idPK=".$catID);
	}
	
	//delete Posting and user registration with respect of cat id
	function delete_posting($catID){
		
		global $db;
		$postinfo = $this->selectTableCon(TBL_POSTING, "fld_user_idFK,fld_teacher_image", "fld_cat_idFK=".$catID);
		
		$count = $this->totalRowsCondition(TBL_POSTING, 'fld_cat_idFK',$catID);
		
		if($count > 0){
		foreach($postinfo as $post) {
				
				$oldPhototxt = $post['fld_teacher_image'];
				$userid 	 = $post['fld_user_idFK'];
				
				if($oldPhototxt){
					
					$oldPhoto = explode(",", $oldPhototxt);
					for($k=0; $k< count($oldPhoto); $k++){
						$unlinkFile = "../".USER_PHOTO_PATH.$oldPhoto[$k];
						unlink($unlinkFile);
					}
				}
			
				$this->delete(TBL_POSTING, "fld_cat_idFK=".$catID);
				$this->delete(TBL_USER, "fld_user_idPK=".$userid);
			}
		}
	}
	
	
	//delete category and subcategory end from here
	###############################################
	
	
	//This function is use to create static page 
	function NewPage($id,$filenamestr){
		
		$output1 = trim(str_replace(chr(34),"",str_replace(chr(39),"",str_replace(chr(92),"",$filenamestr))));
		$FileStr=strtolower(str_replace(" ","-",$output1)).".php";
		$filename=strtolower("../".$FileStr);

		#Content of the file
		$filecontent='<?php '.
		'$'."pgid=$id;
		"."include_once('./cmseditorpages.php');
		".'?>';
		$filehendler=fopen("$filename",wb);
		fwrite($filehendler,$filecontent);
		fclose($filehendler); #Close the file
		return $FileStr;
	}
	
	
	function tep_get_staticpage($categories_array = '', $parent_id = '0', $indent = '') 
	{
	    global $db;
	    		
	    if (!is_array($categories_array)) $categories_array = array();
	    
	   $SQL = "SELECT * FROM ". TBL_STATICPAGES." WHERE fld_parent_page_id ='".(int)$parent_id."' ORDER BY fld_page_name";
	     
	    $categories_query = $db->db_query($SQL);
	    	    
	    while ($categories = $db->tep_db_fetch_array($categories_query)) 
	    {
	    	$categories_array[] = array('id' => $categories['fld_pageidPK'],
		                                'text' => $indent . $categories['fld_page_name']);
	      	if ($categories['fld_pageidPK'] != $parent_id) {
	        	$categories_array = $this->tep_get_staticpage($categories_array, $categories['fld_pageidPK'] , $indent . ' - ');
	      	}
	    }
	    
	    return $categories_array;
	}
	
	#################################
    //delete static page start here
	//this function is use to delete the static page and its child page

	function delete_staticpage_nLevel($id, $offset)
	{	
		global $db;
		$this->delete_StaticPage(TBL_STATICPAGES, $id);
		 	
		$_REQUEST['msg']= "Static page successfully deleted.";
 		$count= $this->totalRows(TBL_STATICPAGES);
 		$offset=$_REQUEST['page']*10;
 		if($count<=$offset)
 		{
 			$offset=$offset-$count;
 			$_REQUEST['page'] =$offset/10;
 		}	
    }


	function delete_StaticPage($tableName, $catID)
	{
		global $db;	
		$count = $this->totalRowsCondition($tableName, 'fld_parent_page_id',$catID);
		if($count > 0)
		{	# If child exists...
			$catinfo = $this->selectTableCon($tableName, "fld_pageidPK,fld_page_name,fld_page_file_name", "fld_parent_page_id='".$catID."'");
			
			foreach($catinfo as $cat) {
				
				@unlink("../".$cat['fld_page_file_name']);
				
				$this->delete($tableName, "fld_pageidPK=".$cat['fld_pageidPK']);
				
				$this->delete_StaticPage($tableName, $cat['fld_pageidPK']);
				
			}
		}
		
		$catinfo2 = $this->selectTableCon($tableName, "fld_pageidPK,fld_page_name,fld_page_file_name", "fld_pageidPK='".$catID."'");
		
		@unlink("../".$catinfo2[0]['fld_page_file_name']);
		
		$this->delete($tableName, "fld_pageidPK=".$catID);
	}


	//delete static page end here
	##############################
	

	//this function use to get the Series of subcategory/ sub sub category.
	 function get_cat_series($categories_array = '', $cat_id){
	   
	 	global $db;
	    		
	    if (!is_array($categories_array)) $categories_array = array();
	  
	    	$SQL ="SELECT fld_cat_idPK, fld_cat_parent_id, fld_cat_name, fld_cat_status FROM ".TBL_CATEGORY." WHERE fld_cat_idPK='".(int)$cat_id."'";
	    	$categories_query = $db->db_query($SQL);
	    	    
	    	while ($categories = $db->tep_db_fetch_array($categories_query)){
	    	
	    		$categories_array[] = array('id' => $categories['fld_cat_idPK'], 'name' => $categories['fld_cat_name']);
	    	
	      			if ($categories['fld_cat_parent_id'] !=0){
	      		
	        			$categories_array = $this->get_cat_series($categories_array, $categories['fld_cat_parent_id']);
	      			}
	    	}
	    
	    return $categories_array;
	}	
	
	//this function is used to get country details.
	//Parameters: countryid
	function getCountry($countryID=""){
	    global $db;	
		$countryDetailsArr = array();
			if($countryID!=""){
		    	$wherePlus = " where fld_CountriesPK ='$countryID'";
			}
        $select_users = "select fld_CountriesPK, fld_CountryID, fld_CountryName from ".TBL_COUNTRY." $wherePlus";
        $db->query($select_users);
        $db->next_record();
        
        	if($db->num_rows()>0){
            	for($i=0; $i<$db->num_rows(); $i++){
                	$countryID = $db->f('fld_CountriesPK');
                	$countryCode = $db->f('fld_CountryID');
                	$countryName = $db->f('fld_CountryName');
                	
            		$countryDetailsArr[$countryID] = $countryName;
                	$db->next_record();
            	}
        	}
        	return $countryDetailsArr;
	}
	
	//this function is used to delete the image.
	//Parameters: image path ,Table, Fields & condition
	function deleteImage($path, $table, $field, $conditon){
	    global $db;	
        $sqldel = "select ".$field." from ".$table." where  ".$conditon;
        $db->query($sqldel);
        $db->next_record();
        if($db->num_rows()>0){
        	$fieldreuslt = $db->f($field);
        	if($fieldreuslt !=''){
        		$updateArr = array($field => '');
        		$db->updateRec($table,$updateArr, $conditon);
        		unlink($path.$fieldreuslt);
             }
           $db->next_record();
       }
	}
	
	
	//this function is used to get the vendor details.
	function getUserDetails($memberID=""){
	    global $db1;	
		$userDetailsArr = array();
			if($memberID!=""){
		    	$wherePlus = " fld_user_idPK='$memberID'";
			}
        $select_users = "select fld_user_idPK, fld_user_name, fld_user_email from ".TBL_USER_PROFILE." where $wherePlus ";
        
        $db1->query($select_users);
        $db1->next_record();
        
        	if($db1->num_rows()>0){
            	for($i=0; $i<$db1->num_rows(); $i++){
                	$userID    = $db1->f('fld_user_idPK');
                	$userName  = $db1->f('fld_user_name');
                	$useremail = $db1->f('fld_user_email');
                    $userDetailsArr[$i]['id']    = $userID;
            		$userDetailsArr[$i]['name']  = $userName;
            		$userDetailsArr[$i]['email'] = $useremail;
            		$db1->next_record();
            	}
        	}
        	return $userDetailsArr;
	}
	

}	
?>