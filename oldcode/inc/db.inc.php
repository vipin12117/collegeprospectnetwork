<?php
##******************************************************************
##  Project		:		Sport Social Networking - Admin Panel
##  Done by		:		Narendra Singh
##	Page name	:		db.inc.php
##	Create Date	:		10/06/2011
##  Description :		Database connection Class with all possible functions.
##	Copyright   :       Synapse Communications Private Limited.
## *****************************************************************
include_once("config.inc.php");				//for site configration

class DB {

//  var $Host   = "67.225.142.245";  //teknicks
//  var $Database = "db142079_cpn";	//put the database name here
//  var $User     = "db142079";	//put the user name here
//  var $Password = "cpn1048@!353";	//put passwort here
  
  var $Host   = "localhost";  //teknicks
  var $Database = "db142079_cpn";	//put the database name here
  var $User     = "root";	//put the user name here
  var $Password = "";	//put passwort here
 
   /* public: configuration parameters */
  var $Auto_Free     = 0;     ## Set to 1 for automatic mysql_free_result()
  var $Debug         = 0;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = "yes"; ## "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)
  var $Seq_Table     = "";

  /* public: result array and current row number */
  var $Record   = array();
  var $Row;

  /* public: current error number and error text */
  var $Errno    = 0;
  var $Error    = "";

  /* public: this is an api revision, not a CVS revision. */
  var $type     = "mysql";
  var $revision = "1.2";

  /* private: link and query handles */
  var $Link_ID  = 0;
  var $Query_ID = 0;



  /* public: constructor */
  function DB_Sql($query = "") {
      $this->query($query);
  }

  /* public: some trivial reporting */
  function link_id() {
    return $this->Link_ID;
  }

  function query_id() {
    return $this->Query_ID;
  }

  /* public: connection management */
  function connect($Database = "", $Host = "", $User = "", $Password = "") {
    /* Handle defaults */
    if ("" == $Database)
      $Database = $this->Database;
    if ("" == $Host)
      $Host     = $this->Host;
    if ("" == $User)
      $User     = $this->User;
    if ("" == $Password)
      $Password = $this->Password;

    /* establish connection, select database */
    if ( 0 == $this->Link_ID ) {

      $this->Link_ID=mysql_connect($Host, $User, $Password);
      if (!$this->Link_ID) {
        $this->halt("pconnect($Host, $User, \$Password) failed.");
        return 0;
      }

      if (!@mysql_select_db($Database,$this->Link_ID)) {
        $this->halt("cannot use database ".$this->Database);
        return 0;
      }
    }

    return $this->Link_ID;
  }

  /* public: discard the query result */
  function free() {
      @mysql_free_result($this->Query_ID);
      $this->Query_ID = 0;
  }

  /* public: perform a query */
  function query($Query_String) {

  	//echo $Query_String;
    /* No empty queries, please, since PHP4 chokes on them. */
    if ($Query_String == "")
      /* The empty query string is passed on from the constructor,
       * when calling the class without a query, e.g. in situations
       * like these: '$db = new DB_Sql_Subclass;'
       */
      return 0;

    if (!$this->connect()) {
      return 0; /* we already complained in connect() about that. */
    };

    # New query, discard previous result.
    if ($this->Query_ID) {
      $this->free();
    }

    if ($this->Debug)
      printf("Debug: query = %s<br>\n", $Query_String);

    $this->Query_ID = @mysql_query($Query_String,$this->Link_ID);
    $this->Row   = 0;
    $this->Errno = mysql_errno();
    $this->Error = mysql_error();
    if (!$this->Query_ID) {
      return 0;
      //$this->halt("Invalid SQL: ".$Query_String);
    }

    # Will return nada if it fails. That's fine.
    return $this->Query_ID;
  }
  
  function db_query($query) {
	
	/* No empty queries, please, since PHP4 chokes on them. */
		if ($query == "")
	      /* The empty query string is passed on from the constructor,
	       * when calling the class without a query, e.g. in situations
	       * like these: '$db = new DB_Sql_Subclass;'
	       */
	      return 0;
	
	    if (!$this->connect()) {
	      return 0; /* we already complained in connect() about that. */
	    };
		$result = mysql_query($query, $this->Link_ID) ;
		$this->Row   = 0;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
	return $result;
	}
	
	function tep_db_fetch_array($categories_query) {
		
		return mysql_fetch_array($categories_query);
	}

  /* public: walk result set */
  function next_record() {
    if (!$this->Query_ID) {
      $this->halt("next_record called with no query pending.");
      return 0;
    }

    $this->Record = @mysql_fetch_array($this->Query_ID);
    $this->Row   += 1;
    $this->Errno  = mysql_errno();
    $this->Error  = mysql_error();

    $stat = is_array($this->Record);
    if (!$stat && $this->Auto_Free) {
      $this->free();
    }
    return $stat;
  }

  /* public: position in result set */
  function seek($pos = 0) {
    $status = @mysql_data_seek($this->Query_ID, $pos);
    if ($status)
      $this->Row = $pos;
    else {
      $this->halt("seek($pos) failed: result has ".$this->num_rows()." rows");

      /* half assed attempt to save the day,
       * but do not consider this documented or even
       * desireable behaviour.
       */
      @mysql_data_seek($this->Query_ID, $this->num_rows());
      $this->Row = $this->num_rows;
      return 0;
    }

    return 1;
  }

  /* public: table locking */
  function lock($table, $mode="write") {
    $this->connect();

    $query="lock tables ";
    if (is_array($table)) {
      while (list($key,$value)=each($table)) {
        if ($key=="read" && $key!=0) {
          $query.="$value read, ";
        } else {
          $query.="$value $mode, ";
        }
      }
      $query=substr($query,0,-2);
    } else {
      $query.="$table $mode";
    }
    $res = @mysql_query($query, $this->Link_ID);
    if (!$res) {
      $this->halt("lock($table, $mode) failed.");
      return 0;
    }
    return $res;
  }

  function unlock() {
    $this->connect();

    $res = @mysql_query("unlock tables");
    if (!$res) {
      $this->halt("unlock() failed.");
      return 0;
    }
    return $res;
  }


  /* public: evaluate the result (size, width) */
  function affected_rows() {
    return @mysql_affected_rows($this->Link_ID);
  }

  function num_rows() {
    return @mysql_num_rows($this->Query_ID);
  }

  function insert_id (){
    return @mysql_insert_id($this->Link_ID);
  }
  function num_fields() {
    return @mysql_num_fields($this->Query_ID);
  }

  /* public: shorthand notation */
  function nf() {
    return $this->num_rows();
  }

  function np() {
    print $this->num_rows();
  }

  function f($Name) {
    return $this->Record[$Name];
  }

  function p($Name) {
    print $this->Record[$Name];
  
  }

  /* public: sequence numbers */
  function nextid($seq_name) {
    $this->connect();

    if ($this->lock($this->Seq_Table)) {
      /* get sequence number (locked) and increment */
      $q  = sprintf("select nextid from %s where seq_name = '%s'",
                $this->Seq_Table,
                $seq_name);
      $id  = @mysql_query($q, $this->Link_ID);
      $res = @mysql_fetch_array($id);

      /* No current value, make one */
      if (!is_array($res)) {
        $currentid = 0;
        $q = sprintf("insert into %s values('%s', %s)",
                 $this->Seq_Table,
                 $seq_name,
                 $currentid);
        $id = @mysql_query($q, $this->Link_ID);
      } else {
        $currentid = $res["nextid"];
      }
      $nextid = $currentid + 1;
      $q = sprintf("update %s set nextid = '%s' where seq_name = '%s'",
               $this->Seq_Table,
               $nextid,
               $seq_name);
      $id = @mysql_query($q, $this->Link_ID);
      $this->unlock();
    } else {
      $this->halt("cannot lock ".$this->Seq_Table." - has it been created?");
      return 0;
    }
    return $nextid;
  }

  /* public: return table metadata */
  function metadata($table='',$full=false) {
    $count = 0;
    $id    = 0;
    $res   = array();

    // if no $table specified, assume that we are working with a query
    // result
    if ($table) {
      $this->connect();
      $id = @mysql_list_fields($this->Database, $table);
      if (!$id)
        $this->halt("Metadata query failed.");
    } else {
      $id = $this->Query_ID;
      if (!$id)
        $this->halt("No query specified.");
    }

    $count = @mysql_num_fields($id);

    // made this IF due to performance (one if is faster than $count if's)
    if (!$full) {
      for ($i=0; $i<$count; $i++) {
        $res[$i]["table"] = @mysql_field_table ($id, $i);
        $res[$i]["name"]  = @mysql_field_name  ($id, $i);
        $res[$i]["type"]  = @mysql_field_type  ($id, $i);
        $res[$i]["len"]   = @mysql_field_len   ($id, $i);
        $res[$i]["flags"] = @mysql_field_flags ($id, $i);
      }
    } else { // full
      $res["num_fields"]= $count;

      for ($i=0; $i<$count; $i++) {
        $res[$i]["table"] = @mysql_field_table ($id, $i);
        $res[$i]["name"]  = @mysql_field_name  ($id, $i);
        $res[$i]["type"]  = @mysql_field_type  ($id, $i);
        $res[$i]["len"]   = @mysql_field_len   ($id, $i);
        $res[$i]["flags"] = @mysql_field_flags ($id, $i);
        $res["meta"][$res[$i]["name"]] = $i;
      }
    }

    // free the result only if we were called on a table
    if ($table) @mysql_free_result($id);
    return $res;
  }

  /* private: error handling */
  function halt($msg) {
    $this->Error = @mysql_error($this->Link_ID);
    $this->Errno = @mysql_errno($this->Link_ID);
    if ($this->Halt_On_Error == "no")
      return;

    $this->haltmsg($msg);

    if ($this->Halt_On_Error != "report")
      die("Session halted.");
  }

  function haltmsg($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>MySQL Error</b>: %s (%s)<br>\n",
      $this->Errno,
      $this->Error);
  }

  function table_names() {
    $this->query("SHOW TABLES");
    $i=0;
    while ($info=mysql_fetch_row($this->Query_ID))
     {
      $return[$i]["table_name"]= $info[0];
      $return[$i]["tablespace_name"]=$this->Database;
      $return[$i]["database"]=$this->Database;
      $i++;
     }
   return $return;
  }

  
#Used to update data
function updateRec($table, $dataArr, $where='', $otherDataArr=''){

	if(is_array($dataArr)) {
		$setVal = "";
		foreach($dataArr as $field => $value){
			$setVal .= $field." = '".$value."', ";
		}
	}

	if(is_array($otherDataArr)) {
		foreach($otherDataArr as $field => $value){
			$setVal .= $field." = ".$value.", ";
		}
	}

	if(!empty($where)){
		$where = " where ".$where;
	}

	$setVal = substr($setVal, 0, strlen($setVal)-2);
   	$sql = "update ".$table." set ".$setVal.$where;

	$this->query($sql);
	return $this->affected_rows();
}


#Used to insert data
function insertRec($table, $strDataArr, $otherDataArr=''){

	if(is_array($strDataArr)) {
		$fields = "";
		$values = "";
		foreach($strDataArr as $field => $value){
			$fields .= $field.", ";
			$values .= "'".$value."', ";
			
		}
		$fields = substr($fields, 0, strlen($fields)-2);
		$values = substr($values, 0, strlen($values)-2);
	}

	if(!empty($otherDataArr) && is_array($otherDataArr)) {
		$fld = "";
		$val = "";
		foreach($otherDataArr as $fd => $va){
			$fld .= $fd.", ";
			$val .= $va.", ";
		}
		$fld = substr($fld, 0, strlen($fld)-2);
		$val = substr($val, 0, strlen($val)-2);
	}
	if(!empty($fld)) $fields .= ", ".$fld;
	if(!empty($val)) $values .= ", ".$val;
	
	
	$sql = "insert into ".$table." (".$fields.") values (".$values.")";
	
	$this->query($sql);
	return $this->insert_id();
}
function insertquery($sql1){

	
	
	$sql = $sql1;
	
	$this->query($sql);
	return $this->insert_id();
}

#used for matching
function MatchingRec($tableName, $whereCriteria){
	
	
	$sql = "select count(*) as numRec from ".$tableName." where ".$whereCriteria;	
	$this->query($sql);
    $this->next_record();
	$num = $this->f("numRec");
	//echo $rs['numRec'];
	return  $num;
}
//Return Matching records id
function MatchingRecId($tableName, $whereCriteria, $field){
	
	$sql = "select ".$field." from ".$tableName." where ".$whereCriteria;
	$this->query($sql);
	$this->next_record();
	$recordsId = $this->f($field);
	return $recordsId;
}

function MatchingRecForCatAvailable($tableName, $whereCriteria, $groupType, $field){
	$where = "";
	$where .= " $whereCriteria AND(";
	$i = 1;
	$countGroups = count($groupType);
	foreach ($groupType as $loggedIngroup){
		
		if($i<$countGroups){
			$where .= "$field LIKE '%$loggedIngroup%' OR ";
		}
		
		if(($i==$countGroups)){
			$where .= " $field LIKE '%$loggedIngroup%' )";
		}
		
		
		$i++;
	}
	
	$toShow = true;
	$sql = "select * from ".$tableName." where ".$where;
	
	$this->query($sql);
	$this->next_record();
	if($this->num_rows()>0){
		$toShow = true;
	}else{
			$toShow = false;
	}
	//$num = $this->f("numRec");
	return $toShow;
	
	
}

#used for matching. If matching records found return the value of the fld passed
function MatchingRecAndGetFieldVal($tableName, $whereCriteria, $returnField){
	
	$sql = "select ".$returnField." from ".$tableName." where ".$whereCriteria;

	$this->query($sql);
	$this->next_record();
	if($this->num_rows()>0){
		$retVal = $this->f($returnField);
	}else{
		$retVal = "";
	}
	
	return $retVal;
}

#Insert the records in interest table
function InterestedIn($table, $strDataArr){
	if(is_array($strDataArr)) {
		$fields = "";
		$values = "";
		foreach($strDataArr as $field => $value){
			$fields .= $field.", ";
			$values .= "'".$value."', ";
		}
		$fields = substr($fields, 0, strlen($fields)-2);
		$values = substr($values, 0, strlen($values)-2);
	}
	$sql = "insert into ".$table." (".$fields.") values (".$values.")";
	$this->query($sql);
	return $this->insert_id();
}

#used for matching
function DuplicateRecord($tableName, $whereCriteria1, $whereCriteria12){
	$sql = "SELECT count(*) AS numRec FROM ".$tableName."  WHERE fld_interest_in = '".$whereCriteria1."' and fld_interested_member_idFK = ".$whereCriteria12."";
	$this->query($sql);
	$this->next_record();
	$num = $this->f("numRec");
	return $num;
}
}
?>