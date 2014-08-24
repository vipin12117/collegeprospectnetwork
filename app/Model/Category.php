<?php

class Category extends AppModel{

	public $name = 'Category';

	public $useTable = 'categories';

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	/**
	 * Return all category list
	 */
	public function getCategoriesList(){
		$rows = $this->find("list",array("conditions"=>"Category.status = 1","fields"=>array("id","name")));
		return $rows;
	}

	/**
	 * Return category details
	 * @param Int $category_id
	 */
	public function getCategoryById($category_id){
		$row = $this->find("first",array("conditions"=>"Category.status = 1 AND Category.id = '$category_id'"));
		return $row;
	}
}