<?php
##******************************************************************
##  Project		:		Reusable Component- Synapse - Admin Panel
##  Done by		:		Manish Arora
##  Page name	:		mysql_functions.php
##	Create Date	:		23/06/2009
##  Description :		These functions fetch the data from database and other own define function in Questionnaire.
##  Copyright   :       Synapse Communications Private Limited.
## *****************************************************************

include_once("db.inc.php");	//for database connection
$db = new DB;	//Create an instance of class DB
$db1 = clone $db;	//Create an instance of class DB
$db2 = clone $db;	//Create an instance of class DB

class QUESTIONFUNC {
	
#Used to Fetch ResultSet as Row
function sqlGet($QUERY) 
{
	global $db1;
	$DetailsArr = array();
	$SQL=$db1->query($QUERY);
    $DetailsArr=$this->sqlFetchRow($SQL);
    $this->sqlFree($SQL);
    return $DetailsArr;
}	
  
#Used to Fetch ResultSet as Array
#Parameters: ResultSet
function sqlFetchRow( $handle ) {
    if( !$handle || ($handle==0) ) {
	return;
    }
    return mysql_fetch_array( $handle );
}

#Used to Free ResultSet
#Parameters: ResultSet
function sqlFree( $handle ) {
    mysql_free_result( $handle );
}

function sqlInsId($h=0) {
    return mysql_insert_id();
}

#Used to update data by passing query
#Parameters: query
function upRecord($QUERY){
	global $db1;
	$SQL=$db1->query($QUERY);
	
}

#Used to update data y passing Table,set value,condition
function upDataRecord($table,$set,$con)
	{
		global $db;
		$sql = "update ".$table." set ".$set." where ".$con;
		
		$db->query($sql);
	}	

function sqlTransaction() {
	global $db1;
    list($mysql_version)=$this->sqlGet("select version()");
    list($major,$minor,$pl)=split("\.",$mysql_version);
    if($major>=3 && $minor>=23 && $pl>=34) {
	$this->upRecord('begin');
    }
}

function sqlCommit() {
	global $db1;
    list($mysql_version)=$this->sqlGet("select version()");
    list($major,$minor,$pl)=split("\.",$mysql_version);
    if($major>=3 && $minor>=23 && $pl>=34) {
	$this->upRecord('commit');
    }
}

function sqlRollback() {
	global $db1;
    list($mysql_version)=$this->sqlGet("select version()");
    list($major,$minor,$pl)=split("\.",$mysql_version);
    if($major>=3 && $minor>=23 && $pl>=34) {
	$this->upRecord('rollback');
    }
}
#Used to return mysql error
function sqlError() {
    return mysql_error();
}	
	

}	
?>