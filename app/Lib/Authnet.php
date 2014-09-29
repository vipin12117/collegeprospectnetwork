<?php

require_once 'sdk-php-master/autoload.php';

class Authnet {

	public function __construct(){
		//define("AUTHORIZENET_API_LOGIN_ID",     "24u2SUseP");
		//define("AUTHORIZENET_TRANSACTION_KEY",  "43U485fA9ySEq38K");
		//define("AUTHORIZENET_SANDBOX",          false);

		define("AUTHORIZENET_API_LOGIN_ID",     "2hfYT85W");
		define("AUTHORIZENET_TRANSACTION_KEY",  "23m2qL9tW7f43TUV");
		define("AUTHORIZENET_SANDBOX",          true);
	}

	public function createProfile($data , $customer_profile_id = false){
		// gets the form field values and sanitizes them

		$subscription_id  = intval($data['subscription_id']);
		$sport_id     = intval($data['sport_id']);
		$firstname    = mysql_real_escape_string($data['firstname']);
		$lastname     = mysql_real_escape_string($data['lastname']);
		$address_1    = mysql_real_escape_string($data['address']);
		$city         = mysql_real_escape_string($data['city']);
		$state        = mysql_real_escape_string($data['state']);
		$zip          = intval($data['zip']);
		$owner_name   = mysql_real_escape_string($data['card_owner']);
		$card_number  = mysql_real_escape_string($data['card_number']);
		$cvv_number   = intval($data['cvv']);
		$subExpMonth  = intval($data['month']);
		$subExpYear   = intval($data['year']);

		App::import("Model","Subscription");
		$Subscription = new Subscription();

		$SubscriptionDetail = $Subscription->find("first",array("conditions"=>array("Subscription.id"=>$subscription_id)));

		// creates a valid expiration date from subExpMonth and
		// subExpYear. The expiration month is left-padded with
		// 0s to make sure it is always 2 digits long

		$subCardExpDate = $subExpYear . '-' .sprintf("%02s", $subExpMonth);
		$subAmount = $SubscriptionDetail['Subscription']['cost'];

		$payment_profile_id = null;
		if (empty($customer_profile_id)) {
			// creates the payment profile object
			$paymentProfile = new AuthorizeNetPaymentProfile;

			$paymentProfile->payment->creditCard->cardNumber = $card_number;
			$paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
			$paymentProfile->payment->creditCard->cardCode = $cvv_number;

			$paymentProfile->billTo->firstName = $firstname;
			$paymentProfile->billTo->lastName  = $lastname;
			$paymentProfile->billTo->address   = $address_1;
			$paymentProfile->billTo->city      = $city;
			$paymentProfile->billTo->state     = $state;
			$paymentProfile->billTo->zip       = $zip;

			// creates the Authorize.net customer profile
			$customerProfile = new AuthorizeNetCustomer;
			$customerProfile->email = $data['email'];
			$customerProfile->paymentProfiles[] = $paymentProfile;

			$request = new AuthorizeNetCIM;
			$response = $request->createCustomerProfile($customerProfile);

			if ($response->xml->messages->resultCode == 'Error') {
				$e = $response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;
				throw new Exception($e);
			}

			// gets the customer profile ID and payment profile ID from the response
			$customer_profile_id = $response->getCustomerProfileId();
			$payment_profile_id  = $response->getCustomerPaymentProfileIds();
		}
		else {
			// gets all existing payment profiles associated with the customer profile
			$request = new AuthorizeNetCIM;
			$response = $request->getCustomerProfile($customer_profile_id);

			if ($response->xml->messages->resultCode == 'Error') {
				$e = $response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;
				throw new Exception($e);
			}

			$paymentProfiles = $response->xml->profile->paymentProfiles;

			// gets the last four digits of the provided card number
			$subLastFour = substr($subCardnumber, -4);

			// compares the last four digits of the provided card number against all
			// card numbers associated with the customer profile. If match is found,
			// the matched payment profile is used for the transaction
			$isMatch = false;

			foreach ($paymentProfiles as $paymentProfile) {
				$profileCard = (string) $paymentProfile->payment->creditCard->cardNumber;
				if ($subLastFour == substr($profileCard, -4)) {
					$isMatch = true;
					$payment_profile_id = (string) $paymentProfile->customerPaymentProfileId;
				}
			}

			// creates a new payment profile if there is not a match
			if (!$isMatch) {
				$paymentProfile->payment->creditCard->cardNumber = $card_number;
				$paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
				$paymentProfile->billTo->firstName = $firstname;
				$paymentProfile->billTo->lastName  = $lastname;
				$paymentProfile->billTo->address   = $address_1;
				$paymentProfile->billTo->city      = $city;
				$paymentProfile->billTo->state     = $state;
				$paymentProfile->billTo->zip       = $zip;

				$response = $request->createCustomerPaymentProfile($customerProfileId,
				$paymentProfile);

				if ($response->xml->messages->resultCode == 'Error') {
					$e = $response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;
					throw new Exception($e);
				}

				$payment_profile_id = (string) $response->xml->customerPaymentProfileId;
			}
		}

		$transaction = new AuthorizeNetTransaction;
		$transaction->amount = $subAmount;
		$transaction->customerProfileId = $customer_profile_id;
		$transaction->customerPaymentProfileId = $payment_profile_id;
		$response = $request->createCustomerProfileTransaction("AuthCapture",$transaction);

		if ($response->xml->messages->resultCode == 'Error') {
			// throws an expception based on the resultCode returned in the response
			$errorMsg = '';

			switch ($response->xml->messages->message->code) {
				case 'E00027':
					$msg = $response->xml->messages->message->text;
					switch ($msg) {
						case 'A duplicate transaction has been submitted.':

							$errorMsg = 'You are submitting orders too rapidly and have triggered the duplicate transaction prevention mechanisms with the payment gateway. We apologize for the inconvenience. Please wait two minutes and try again.';
							break;

						case 'The credit card number is invalid.':

							$errorMsg = 'Your payment information was declined by the payment gateway. Please verify you have entered your information correctly and try again.';
							// deletes the invalid payment profile
							$response = $request->deleteCustomerPaymentProfile($customer_profile_id,$payment_profile_id);
							break;
						default:
							$errorMsg = $response->xml->messages->message->code . ': ' . $msg;
							break;
					}
					break;

				default:
					$errorMsg = $response->xml->messages->message->code . ': ' . $response->xml->messages->message->text;
					break;
			}

			throw new Exception($errorMsg);
		}

		return array($customer_profile_id , $payment_profile_id);
	}

	public function updateProfile($data , $payment_profile_id , $customer_profile_id){
		// updates the payment profile with the new information
		$subscription_id  = intval($data['subscription_id']);
		$sport_id     = intval($data['sport_id']);
		$firstname    = mysql_real_escape_string($data['firstname']);
		$lastname     = mysql_real_escape_string($data['lastname']);
		$address_1    = mysql_real_escape_string($data['address']);
		$city         = mysql_real_escape_string($data['city']);
		$state        = mysql_real_escape_string($data['state']);
		$zip          = intval($data['zip']);
		$owner_name   = mysql_real_escape_string($data['card_owner']);
		$card_number  = mysql_real_escape_string($data['card_number']);
		$cvv_number   = intval($data['cvv']);
		$subExpMonth  = intval($data['month']);
		$subExpYear   = intval($data['year']);

		$paymentProfile = new AuthorizeNetPaymentProfile;

		$paymentProfile->payment->creditCard->cardNumber = $card_number;
		$paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
		$paymentProfile->payment->creditCard->cardCode = $cvv_number;

		$paymentProfile->billTo->firstName = $firstname;
		$paymentProfile->billTo->lastName  = $lastname;
		$paymentProfile->billTo->address   = $address_1;
		$paymentProfile->billTo->city      = $city;
		$paymentProfile->billTo->state     = $state;
		$paymentProfile->billTo->zip       = $zip;

		$request  = new AuthorizeNetCIM;
		$response = $request->updateCustomerPaymentProfile($customer_profile_id,$payment_profile_id,$paymentProfile);

		if ($response->xml->messages->resultCode == 'Error') {
			$e = $response->xml->messages->message->code . ': ' .$response->xml->messages->message->text;
			throw new Exception($e);
		}
	}
}