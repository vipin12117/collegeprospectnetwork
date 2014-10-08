<?php

class CronController extends AppController{

	public $name = "Cron";

	public $uses = array("CollegeSubscription","Subscription","CollegeCoach");

	public function beforeFilter(){
		parent::beforeFilter();

		$this->autoLayout = false;
		$this->autoRender = false;
	}

	public function index(){
		exit;
	}

	public function renewSubscription(){
		$today = date('Y-m-d H:i:s');
		$subscriptions = $this->CollegeSubscription->find("all",array("conditions"=>"CollegeSubscription.status = 1 AND CollegeSubscription.nextbill_date <= '$today'"));

		foreach($subscriptions as $subscription){
			// attempts to charge the user for the subscription
			$transaction = new AuthorizeNetTransaction;
			$transaction->amount = $subscription['Subscription']['cost'];
			$transaction->customerProfileId = $subscription['CollegeSubscription']['transaction_id'];
			$transaction->customerPaymentProfileId = $subscription['CollegeSubscription']['payment_profile_id'];

			$request = new AuthorizeNetCIM;
			$response = $request->createCustomerProfileTransaction("AuthCapture",$transaction);

			$subscription_id = $subscription['CollegeSubscription']['subscription_id'];
			$user_id = $subscription['CollegeSubscription']['college_coach_id'];

			// if the transaction fails, cancel the subscription
			if($response->xml->messages->resultCode == 'Error') {
				$errorMessage = "Automatic renewal failed.".$response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;

				$this->CollegeSubscription->updateAll(array("status"=>0,"cancel_date"=>date('Y-m-d'),"cancel_reason"=>"'".$errorMessage."'"),array("college_coach_id"=>$user_id,"CollegeSubscription.subscription_id"=>$subscription_id));
			}
			else{
				// gets the transaction ID to save in the subscription table
				$transactionResponse = $response->getTransactionResponse();
				$transactionId = $transactionResponse->transaction_id;
				
				//insert payment history
				$paymentHistory = array();
				$paymentHistory['college_coach_id'] = $user_id;
				$paymentHistory['transaction_id'] = $transactionId;
				$paymentHistory['profile_id'] = $transactionId;
				$paymentHistory['amount'] = $subscription['Subscription']['cost'];
				$paymentHistory['date_added'] = date('Y-m-d H:i:s');
				
				$this->loadModel('PaymentHistory');
				$this->PaymentHistory->save(array("PaymentHistory"=>$paymentHistory));

				$this->renewSubscriptionEmail($subscription['CollegeCoach']['first_name'],$subscription['CollegeCoach']['last_name'],$subscription['CollegeCoach']['email'],$transactionId);

				switch($subscription['Subscription']['period']){
					case '3-Year':
						$next_billdate = date('Y-m-d H:i:s',time()+(3*12*30*24*60*60));
						break;
					case 'Yearly':
						$next_billdate = date('Y-m-d H:i:s',time()+(12*30*24*60*60));
						break;
					default:
						$next_billdate = date('Y-m-d H:i:s',time()+(30*24*60*60));
						break;
				}

				$this->CollegeSubscription->id = $subscription['CollegeSubscription']['id'];
				$this->CollegeSubscription->saveField("next_billdate",$next_billdate);
			}
		}
	}

	private function renewSubscriptionEmail($first_name , $last_name , $email , $transaction_id){
		$subject = "College Prospect Network - Subscription Renewal";
		$template = 'renew_subscription_email';
		$cakeEmail = new CakeEmail('default');
		try {
			$cakeEmail->template($template);
			$cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
			$cakeEmail->to($email);
			$cakeEmail->subject($subject);
			$cakeEmail->emailFormat('html');
			$cakeEmail->viewVars(array('first_name' => $first_name, 'last_name' => $last_name, 'transaction_id' => $transaction_id));
			// Send email
			$cakeEmail->send();
		}
		catch (Exception $e){
			$this->Session->setFlash('Error while sending email');
		}
	}
}