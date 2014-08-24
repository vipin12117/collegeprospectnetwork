<?php

class Mail extends AppModel{

	public $name = 'Mail';

	public $useTable = 'mails';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}