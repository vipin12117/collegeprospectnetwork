<?php

class Network extends AppModel{

	public $name = 'Network';

	public $useTable = 'networks';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	public function isExist($sender_id , $receiver_id , $sender_type , $receiver_type){
		return $this->find("first",array("conditions"=>array("sender_id"=>$sender_id,"receiver_id"=>$receiver_id,"sender_type"=>$sender_type,"receiver_type"=>$receiver_type)));
	}
}