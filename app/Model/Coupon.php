<?php

class Coupon extends AppModel{

	public $name = 'Coupon';

	public $useTable = 'coupons';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}
}