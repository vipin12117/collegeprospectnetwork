<?php

class Category extends AppModel{

	public $name = 'Category';

	public $useTable = 'categories';
	
	//public $belongsTo = array('Language');

	public function __construct(){
		parent::__construct();
		$this->primaryKey = 'id';
	}

	/**
	 * Return all category array
	 * @param Int $language_id [optional]
	 */
	public function getCategories($language_id = false){
		$language_id = (int)$language_id;

		if($language_id){
			$rows = $this->find("all",array("conditions"=>"Category.status = 1 AND Category.language_id = '$language_id'",
											"fields"=>array("Category.id","Category.name","Category.photo","Language.name","Language.code")));
		}
		else{
			$rows = $this->find("all",array("conditions"=>"Category.status = 1",
											"fields"=>array("Category.id","Category.name","Category.photo","Language.name","Language.code")));
		}

		return $rows;
	}

	/**
	 * Return all category list
	 * @param Int $language_id [optional]
	 */
	public function getCategoriesList($language_id = false){
		$language_id = (int)$language_id;

		if($language_id){
			$rows = $this->find("list",array("conditions"=>"Category.status = 1 AND Category.language_id = '$language_id'","fields"=>array("id","name")));
		}
		else{
			$rows = $this->find("list",array("conditions"=>"Category.status = 1","fields"=>array("id","name")));
		}

		return $rows;
	}

	/**
	 * Return category details
	 * @param Int $category_id
	 */
	public function getCategoryById($category_id){
		$row = $this->find("first",array("conditions"=>"Category.status = 1 AND Category.id = '$category_id'",
										 "fields"=>array("Category.id","Category.name","Category.photo","Language.name","Language.code")));
		return $row;
	}
}