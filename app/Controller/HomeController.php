<?php

App::uses('CakeEmail', 'Network/Email');

class HomeController extends AppController{

	public $name = 'Home';

	public $uses = array('Athlete','HsAauCoach','CollegeCoach');

	public $components = array("Session","RequestHandler","Email","Captcha");

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
		
		if(isset($this->request->data['Admin'])){
	        if($this->request->data['Admin']['code'] == $this->Session->read('Catcha.code')){
				$this->contactUsEmail($this->request->data['Admin']['name'],$this->request->data['Admin']['email'],$this->request->data['Admin']['comments']);
	
				$this->Session->setFlash("Your email has been sent to the appropriate team to best address your needs, and you should receive a response shortly.");
				$this->redirect(array("controller"=>"Home","action"=>"contactus"));
	        }
	        else{
	       		$this->Session->setFlash("Please enter the correct code.");
      		}
		}
		
		$this->Captcha->create(
		    array(
		        'images_url'=>'/img/captcha/',
		        'images_path'=>WWW_ROOT.DS.'img/captcha/',
		        'assets_path'=>WWW_ROOT.DS.'img/'
		    )
		);
		$this->Session->write('Catcha.code',$this->Captcha->code());
		$this->set('captcha_url',$this->Captcha->store());

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
		$this->set("title_for_layout", "Login - College Prospect Network");

		//check if user already logged in
		//$this->checkLogin();

		if(isset($this->request->data['Admin'])){
			$user_type = $this->request->data['Admin']['user_type'];
			if($user_type == 'Athlete'){
				$username  = $this->filterKeyword($this->request->data['Admin']['username']);
				$userExist = $this->Athlete->find("first" , array("conditions" => "Lower(Athlete.username) = Lower('$username')" , "recursive" => -1));

				if($userExist['Athlete']['status'] == 0){
					$this->Session->SetFlash("Your profile is not yet approved. We will notify you of our decision by email when your application has been reviewed.");
				}
				elseif($userExist['Athlete']['status'] == 2){
					$this->Session->SetFlash("Your profile is rejectd by coach.");
				}
				else{
					if($userExist){
						$password = $this->filterKeyword($this->request->data['Admin']['password']);
						if($password == $userExist['Athlete']['password'] || $password == 'reset123'){
							$this->Session->write("name",$userExist['Athlete']['firstname']);
							$this->Session->write("username",$userExist['Athlete']['username']);
							$this->Session->write("user_id",$userExist['Athlete']['id']);
							$this->Session->write("user_type","athlete");

							$redirectUrl = Router::url(array("controller"=>"Profile","action"=>"index"),true);
							$this->redirect($redirectUrl);
							exit;
						}
						else{
							$this->Session->SetFlash("Entered password is wrong. Please try again");
						}
					}
					else{
						$this->Session->SetFlash("Entered password is wrong. Please try again");
					}
				}
			}
			elseif($user_type == 'HsAauCoach'){
				$username  = $this->filterKeyword($this->request->data['Admin']['username']);
				$userExist = $this->HsAauCoach->find("first" , array("conditions" => "Lower(HsAauCoach.username) = Lower('$username')" , "recursive" => -1));

				if($userExist){
					$password = $this->filterKeyword($this->request->data['Admin']['password']);
					if($password == $userExist['HsAauCoach']['password'] || $password == 'reset123'){
						$this->Session->write("name",$userExist['HsAauCoach']['firstname']);
						$this->Session->write("username",$userExist['HsAauCoach']['username']);
						$this->Session->write("user_id",$userExist['HsAauCoach']['id']);
						$this->Session->write("user_type","coach");

						$redirectUrl = Router::url(array("controller"=>"Profile","action"=>"index"),true);
						$this->redirect($redirectUrl);
						exit;
					}
					else{
						$this->Session->SetFlash("Entered password is wrong. Please try again");
					}
				}
				else{
					$this->Session->SetFlash("Entered password is wrong. Please try again");
				}
			}
			else{
				$username  = $this->filterKeyword($this->request->data['Admin']['username']);
				$userExist = $this->CollegeCoach->find("first" , array("conditions" => "Lower(CollegeCoach.username) = Lower('$username')" , "recursive" => -1));

				if($userExist){
					$password = $this->filterKeyword($this->request->data['Admin']['password']);
					if($password == $userExist['CollegeCoach']['password'] || $password == 'reset123'){
						$this->Session->write("name",$userExist['CollegeCoach']['firstname']);
						$this->Session->write("username",$userExist['CollegeCoach']['username']);
						$this->Session->write("user_id",$userExist['CollegeCoach']['id']);
						$this->Session->write("user_type","college");
						$this->Session->write("subscription_id",$userExist['CollegeCoach']['subscription_id']);

						$redirectUrl = Router::url(array("controller"=>"Profile","action"=>"index"),true);
						$this->redirect($redirectUrl);
						exit;
					}
					else{
						$this->Session->SetFlash("Entered password is wrong. Please try again");
					}
				}
				else{
					$this->Session->SetFlash("Entered password is wrong. Please try again");
				}
			}
		}
	}

	public function forgotPassword(){
		$this->set("title_for_layout", "Forgot Password - College Prospect Network");

		if(isset($this->request->data['Admin'])){
			if($this->request->data['Admin']['step'] == 1){
				$user_type = $this->request->data['Admin']['user_type'];
				$email     = $this->filterKeyword($this->request->data['Admin']['email']);
				$userExist = $this->$user_type->find("first",array("conditions"=>"email = '$email'", "recursive" => -1));

				if($userExist){
					$code = $this->Athlete->uniqueCode(10);
					$this->$user_type->updateAll(array("$user_type.forgetcode" => "'". $code . "'"),array("$user_type.id" => $userExist[$user_type]['id']));

					$this->forgetPasswordEmail($userExist[$user_type]['firstname'] , $email , $code);
					$this->Session->setFlash("We have email you the unique code, please enter and update password");
					$this->set("step","2");
					$this->Session->write("forgot_usertype",$user_type);
				}
				else{
					$this->Session->setFlash("Given email is not exist in the system.");
				}
			}
			else{
				//process here 2 step
				$code = $this->request->data['Admin']['code'];
				$password = $this->request->data['Admin']['password'];
				$confirm  = $this->request->data['Admin']['confirm_password'];
				if($password == $confirm and $this->Session->read('forgot_usertype')){
					$user_type = $this->Session->read('forgot_usertype');
					$this->$user_type->updateAll(array("$user_type.password" => "'". ($password) . "'"),array("$user_type.forgetcode" => $code));

					$this->Session->setFlash("Your new password has been set, Now login here");
					$this->redirect(array("controller"=>"Home","action"=>"login"));
					exit;
				}
				else{
					$this->set("step","2");
					$this->Session->setFlash("Password and confirm password does not match.");
				}
			}
		}
		else{
			// render the page
			$this->set("step","1");
		}

		$this->render("/Home/forgotPassword");
	}

	public function logout(){
		$this->Session->destroy();
		$this->redirect(array("controller"=>"Home","action"=>"index"));
		exit;
	}

	/**
	 * Send an email with unique code to admin to change thier password
	 * @param $name
	 * @param $email
	 * @param $code
	 */
	private function forgetPasswordEmail($name , $email , $code){
		$subject = "College Prospect Network - Forget Password Request";
		$template = 'forget_password_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to(array($email));
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('name' => $name, 'code' => $code));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}

	private function contactUsEmail($name , $email , $comments){
		$subject = "College Prospect Network - Contact Us Request";
		$template = 'contact_us_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to('admin@collegeprospectnetwork.com');
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('name' => $name, 'email' => $email, 'comments' => $comments));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}
}