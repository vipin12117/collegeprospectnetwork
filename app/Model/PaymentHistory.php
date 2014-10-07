<?php

class PaymentHistory extends AppModel{

	public $name = 'PaymentHistory';

	public $useTable = 'payment_history';
	
	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}