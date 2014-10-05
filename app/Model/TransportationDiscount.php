<?php

class TransportationDiscount extends AppModel{

	public $name = 'TransportationDiscount';

	public $useTable = 'transportation_discounts';
	
	public $virtualFields = array('discount' => 'CONCAT(TransportationDiscount.departure_city, " - ", TransportationDiscount.departure_time, " - $" ,TransportationDiscount.transport_charge)');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}