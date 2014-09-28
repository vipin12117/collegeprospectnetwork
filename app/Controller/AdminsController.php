<?php

App::uses('CakeEmail', 'Network/Email');
class AdminsController extends AppController{

	public $name = 'Admins';
	
	var $layout = 'admin';
	
	public $components = array('Email','Session');
	
	public function login(){
		$this->layout = 'admin';
		if ($this->request->is('post')) ///////if form is post
		{
			$results = $this->Admin->findByUsername($this->request->data['username']);
			
			///////if username and password are matched/////////////
			if ($results && $results['Admin']['password'] == $this->request->data['password'] && $results['Admin']['status']==1)
			{
				$this->Session->write('Admin.username', $this->request->data['username']);
				$this->Session->write('Admin.usertype', $results['Admin']['user_type']);
				$this->Session->write('Admin.id', $results['Admin']['id']);
				$this->redirect(array('controller' => 'admins', 'action' => 'index'));
			} 
			else 
			{
				$this->Session->setFlash('Incorrect Username/Password', 'flash_error');
			}
		} 	
	}
			
	public function index(){
		if (!$this->checkAdminSession()){
			$this->redirect(array('controller'=>'admins','action'=>'login'));
		} 
	}
	
	public function forgot_password(){
		if ($this->request->is('post'))
		{			
			$email = $this->request->data['email'];
			if(trim($email) == "") {
				$error['email'] = 'Please Enter An Email';
			} elseif ((!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) && !empty($email)){
				$error['email'] = 'Please Enter A Valid Email';
			}
			if(empty($error)) {
				$strNewPassword = $this->getRandId(6);
				// Check if email exists in the database
				$admin = $this->Admin->find('first', array('conditions' => array('Admin.email' => $email)));
				if (!empty($admin)) {
					$this->Admin->id = $admin['Admin']['id'];
					$this->Admin->saveField('password', $strNewPassword);
					
					//Send email for notification
					$this->forgetPasswordAdminEmail($email, $strNewPassword, $admin['Admin']['username']);
					$this->Session->setFlash('Your password has been reset and mailed to you on your registered email id.', 'flash_success');
					$this->redirect(array('controller' => 'admins', 'action' => 'login'));
				} else {
					$this->Session->setFlash('User not found. Please try again.', 'flash_error');
				}
			} else {
				$this->Session->setFlash($error['email'], 'flash_error');
			}
		}
	}
	
	private function forgetPasswordAdminEmail($email, $password, $username){
		$subject = 'Change your password';
		$template = 'forget_password_admin_email';
		$cakeEmail = new CakeEmail('default');
    	try {
			$cakeEmail->template($template);                  	
            $cakeEmail->from(array('admin@collegeprospectnetwork.com' => 'College Prospect Network - Admin'));
            $cakeEmail->to(array($email));
            $cakeEmail->subject($subject);
            $cakeEmail->emailFormat('html');
            $cakeEmail->viewVars(array('username' => $username, 'password' => $password));                        
            // Send email
            $cakeEmail->send();
		} catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}
	
	public function logout(){
		$this->Session->delete('Admin.id');
		$this->Session->destroy();
		$this->redirect(array('controller' => 'admins', 'action' => 'login'));		
	}
	
	public function admin_login(){
		if (!$this->checkAdminSession()){
			$this->redirect('/admins/login');
		} 
	}
	
	private function getRandId($length)
	{
	  	if($length>0) 
	  	{ 
	  		$rand_id="";
		   	for($i=1; $i<=$length; $i++)
		   	{
		   		mt_srand((double)microtime() * 1000000);
		   		$num = mt_rand(1,36);
		   		$rand_id .= $this->assignRandValue($num);
		   	}
	 	}
		return $rand_id;
	} 
	
	private function assignRandValue($num)
	{
		// accepts 1 - 36
		switch($num)
		{
			case "1": $rand_value = "a";		    break; 
		    case "2": $rand_value = "b";		    break;
		    case "3": $rand_value = "c";		    break;
		    case "4": $rand_value = "d";		    break;
		    case "5": $rand_value = "e";		    break;
		    case "6": $rand_value = "f";		    break;
		    case "7": $rand_value = "g";		    break;
		    case "8": $rand_value = "h";		    break;
		    case "9": $rand_value = "i";		    break;
		    case "10": $rand_value = "j";		    break;
		    case "11": $rand_value = "k";		    break;
		    case "12": $rand_value = "l";		    break;
		    case "13": $rand_value = "m";		    break; 
		    case "14": $rand_value = "n";		    break;
		    case "15": $rand_value = "o";		    break;
		    case "16": $rand_value = "p";		    break;
		    case "17": $rand_value = "q";		    break;
		    case "18": $rand_value = "r";		    break;
		    case "19": $rand_value = "s";		    break;
		    case "20": $rand_value = "t";		    break;
		    case "21": $rand_value = "u";		    break;
		    case "22": $rand_value = "v";		    break;
		    case "23": $rand_value = "w";		    break;
		    case "24": $rand_value = "x";		    break;
		    case "25": $rand_value = "y";		    break;
		    case "26": $rand_value = "z";		    break;
		    case "27": $rand_value = "0";		    break;
		    case "28": $rand_value = "1";		    break;
		    case "29": $rand_value = "2";		    break;
		    case "30": $rand_value = "3";		    break;
		    case "31": $rand_value = "4";		    break;
		    case "32": $rand_value = "5";		    break;
		    case "33": $rand_value = "6";		    break;
		    case "34": $rand_value = "7";		    break;
		    case "35": $rand_value = "8";		    break;
		    case "36": $rand_value = "9";		    break;
		}
		return $rand_value;
	}	
}