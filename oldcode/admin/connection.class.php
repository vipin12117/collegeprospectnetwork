<?php
	########################################################################
	##															
	##	File Name		: connection.class.php												
	##	Created By		: Nishant Sood
	##	Created On		: 29 July, 2009
	##	Company		    : Synapse Communications Pvt. Ltd., India
	##	Purpose			: Database Connection Class
	##
	########################################################################
?>

<?php

	class Connection {
		private $host_name = '';
		private $db_username = '';
		private $db_password = '';
		private $database = '';
		private $conn = '';
		public $query = '';
		public $result	= '';
		
		function __construct($Host,$User,$Password,$Database) {
			$this->host_name = $Host;
			$this->database = $Database;
			$this->db_username = $User;
			$this->db_password = $Password;
			
			
			$this->conn = mysql_connect($this->host_name, $this->db_username, $this->db_password) or die(mysql_error());
			mysql_select_db($this->database, $this->conn);
		}
		
		function executeQuery() {
			$this->result = mysql_query($this->query) or die(mysql_error());
		}
		
		function getTotalPages($table,$itemonpage,$where_clause="") {
			$num_rows = $this->getNumRows($table,$where_clause);
			$total_pages = ceil($num_rows/$itemonpage);
			return $total_pages;
		}
		
	function getNumRows($table, $where_clause) {
			$this->query = $this->createQuery($table, $where_clause);	
			$this->executeQuery(); 
			$num=mysql_num_rows($this->result);
			$this->freeResult();
			return $num;
		}
		
		function createQuery($table, $where_clause) {
			$SelectQuery = "SELECT * FROM `$table` ";
			if($where_clause) {
				$SelectQuery.=$where_clause;
			}
			return $SelectQuery;
		}
		
		function getMultipleRows($table, $where_clause="") {
			$this->query = $this->createQuery($table, $where_clause);
			$this->executeQuery();
			while($row = mysql_fetch_array($this->result)) {
				$row_val[] = $row;
			}
			$this->freeResult();
			return $row_val;
		}	
		
		function getMultipleRowsJoin($query) {
			$this->query = $query;
			$this->executeQuery();
			while($row = mysql_fetch_array($this->result)) {
				$row_val[] = $row;
			}
			$this->freeResult();
			return $row_val;
		}
		
		function freeResult() {
			mysql_free_result($this->result);
		}
		
		function getmaxID($table,$where_clause="") {
			$this->query = "SELECT ifnull(max(id),0) as id FROM `$table` ".$where_clause;
			$this->executeQuery();
			while($row = mysql_fetch_array($this->result)) {
				$max_id = $row["id"]+1;
			}
			return $max_id;
		}
		
		function getSingleRow($table, $where_clause) {
			$this->query = $this->createQuery($table, $where_clause);
			$this->executeQuery($SelectQuery);
			while($row = mysql_fetch_array($this->result)) {
				$row_val = $row;
			}
			return $row_val;
		}
		function lastInsertId() {
			return mysql_insert_id($this->conn);
		}
	}
?>
