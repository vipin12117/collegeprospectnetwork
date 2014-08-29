<?php

class HomeController extends AppController{

	public $name = 'Home';

	public function beforeFilter(){
		parent::beforeFilter();

		App::import("Model","Page");
		$this->Page = new Page();
	}

	public function index(){
		$this->set("title_for_layout","College Prospect Network - Home | CPN");
	}

	public function features(){
		$this->set("title_for_layout","College Prospect Network - Features | CPN");
	}

	public function aboutus(){
		$page_detail = $this->Page->getPageDetails('aboutus');

		$this->set("title_for_layout",$page_detail['Page']['meta_title']);
		$this->set("title_for_keywords",$page_detail['Page']['meta_keywords']);
		$this->set("title_for_description",$page_detail['Page']['meta_desc']);

		$this->set("page_detail",$page_detail);
	}

	public function contactus(){
		$page_detail = $this->Page->getPageDetails('contactus');

		$this->set("title_for_layout",$page_detail['Page']['meta_title']);
		$this->set("title_for_keywords",$page_detail['Page']['meta_keywords']);
		$this->set("title_for_description",$page_detail['Page']['meta_desc']);

		$this->set("page_detail",$page_detail);
	}

	public function privacyPolicy(){
		$page_detail = $this->Page->getPageDetails('privacy_policy');

		$this->set("title_for_layout",$page_detail['Page']['meta_title']);
		$this->set("title_for_keywords",$page_detail['Page']['meta_keywords']);
		$this->set("title_for_description",$page_detail['Page']['meta_desc']);

		$this->set("page_detail",$page_detail);
		$this->render("/Home/privacyPolicy");
	}

	public function termsConditions(){
		$page_detail = $this->Page->getPageDetails('terms_conditions');

		$this->set("title_for_layout",$page_detail['Page']['meta_title']);
		$this->set("title_for_keywords",$page_detail['Page']['meta_keywords']);
		$this->set("title_for_description",$page_detail['Page']['meta_desc']);

		$this->set("page_detail",$page_detail);
		$this->render("/Home/termsConditions");
	}

	public function refundPolicy(){
		$page_detail = $this->Page->getPageDetails('refund_policy');

		$this->set("title_for_layout",$page_detail['Page']['meta_title']);
		$this->set("title_for_keywords",$page_detail['Page']['meta_keywords']);
		$this->set("title_for_description",$page_detail['Page']['meta_desc']);

		$this->set("page_detail",$page_detail);
		$this->render("/Home/refundPolicy");
	}

	public function login(){

	}

	public function forgotPassword(){

	}

	public function logout(){
		$this->Session->destory();
		$this->redirect(array("controller"=>"Home","action"=>"index"));
		exit;
	}
}