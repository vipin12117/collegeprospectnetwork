<?php

require_once 'anet_php_sdk/AuthorizeNet.php';
require_once 'AuthorizeNetMerchantAccount.php';

// gets the form field values and sanitizes them
$subType       = intval($_POST['x_amount']);
$subSport      = intval($_POST['fldSport']);
$subFName      = mysql_real_escape_string($_POST['x_first_name']);
$subLName      = mysql_real_escape_string($_POST['x_last_name']);
$subAddress    = mysql_real_escape_string($_POST['x_address']);
$subCity       = mysql_real_escape_string($_POST['x_city']);
$subState      = mysql_real_escape_string($_POST['x_state']);
$subZip        = intval($_POST['x_zip']);
$subCardholder = mysql_real_escape_string($_POST['x_card_owner']);
$subCardnumber = intval($_POST['x_card_num']);
$subExpMonth   = intval($_POST['month']);
$subExpYear    = intval($_POST['year']);

// creates a valid expiration date from subExpMonth and
// subExpYear. The expiration month is left-padded with
// 0s to make sure it is always 2 digits long
$subCardExpDate = $subExpYear . '-' .
                sprintf("%02s", $subExpMonth);

// loops through the list of subscriptions and gets 
// the amount matching the select subscription ID
// costList is initialized in subscribe.php
$subAmount = null;

foreach ($costList as $cost) {
    if ($cost['fldId'] == $subType) {
        $subAmount = $cost['fldCost'];
    }
}

/*
 * checks that the user does not already have
 * an active subscription for the specified sport
 */

$queryString = 'SELECT fldId FROM %s WHERE ' .
               'fldSport=%s AND fldCoach=%s AND fldActive=1';

// fldId is provided by subscribe.php
$query = sprintf($queryString, TBL_COLLEGE_SUBSCRIPTION, $subSport, $fldId);
$db1->query($query);
$db1->next_record();

if ($db1->num_rows() != 0) {
    throw new Exception('An active subscription for that sport already exists!');
}

/*
 * gets the Authorize.net customer profile ID stored in the database 
 * for the current user, creating one with Authorize.net if one does 
 * not exist. Also retrieves the payment profile matching the payment
 * information provided, creating a new payment profile if none exist
 * or a new customer profile is also being created. The payment profile
 * ID is stored in paymentProfileId. customerProfileId is provided by
 * subscribe.php
 */

$paymentProfileId = null;

if (empty($customerProfileId)) {
    // creates the payment profile object
    $paymentProfile = new AuthorizeNetPaymentProfile;
    $paymentProfile->payment->creditCard->cardNumber = $subCardnumber;
    $paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
    $paymentProfile->billTo->firstName = $subFName;
    $paymentProfile->billTo->lastName = $subLName;
    $paymentProfile->billTo->address = $subAddress;
    $paymentProfile->billTo->city = $subCity;
    $paymentProfile->billTo->state = $subState;
    $paymentProfile->billTo->zip = $subZip;
    
    // creates the Authorize.net customer profile
    $customerProfile = new AuthorizeNetCustomer;
    $customerProfile->email = $fldEmail; // fldEmail initiated in subscribe.php
    $customerProfile->paymentProfiles[] = $paymentProfile;
    
    $request = new AuthorizeNetCIM;
    $response = $request->createCustomerProfile($customerProfile);
    
    if (ANet_Response_getResultCode($response) == 'Error') {
        $e = ANet_Response_getMessageCode($response) . ': ' .
             ANet_Response_getMessageText($response);
        
        throw new Exception($e);
    }
    
    // gets the customer profile ID and payment profile ID from the response
    $customerProfileId = $response->getCustomerProfileId();
    $paymentProfileId  = $response->getCustomerPaymentProfileIds();
    
    // updates the database with the new Authorize.net customer profile ID
    $tbl   = TBL_COLLEGE_COACH_REGISTER;
    $data  = array('fldANetCustomerProfileId' => $customerProfileId);
    $where = 'fldId=' . $fldId;
    
    $affectedRows = $db1->updateRec($tbl, $data, $where);
} else {
    // gets all existing payment profiles associated with the customer profile
    $request = new AuthorizeNetCIM;
    $response = $request->getCustomerProfile($customerProfileId);
    
    if (ANet_Response_getResultCode($response) == 'Error') {
        $e = ANet_Response_getMessageCode($response) . ': ' .
             ANet_Response_getMessageText($response);
        
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
            $paymentProfileId = (string) $paymentProfile->customerPaymentProfileId;
        }
    }
    
    // creates a new payment profile if there is not a match
    if (!$isMatch) {
        $paymentProfile = new AuthorizeNetPaymentProfile;
        $paymentProfile->payment->creditCard->cardNumber = $subCardnumber;
        $paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
        $paymentProfile->billTo->firstName = $subFName;
        $paymentProfile->billTo->lastName = $subLName;
        $paymentProfile->billTo->address = $subAddress;
        $paymentProfile->billTo->city = $subCity;
        $paymentProfile->billTo->state = $subState;
        $paymentProfile->billTo->zip = $subZip;
        
        $response = $request->createCustomerPaymentProfile($customerProfileId,
                                                           $paymentProfile);
        if (ANet_Response_getResultCode($response) == 'Error') {
            $e = ANet_Response_getMessageCode($response) . ': ' .
                 ANet_Response_getMessageText($response);
            
            throw new Exception($e);
        }
        
        $paymentProfileId = (string) $response->xml->customerPaymentProfileId;
    }
}

/*
 * creates a new "Auth & Capture" transaction with the customer
 * profile ID and payment profile ID selected or created above.
 * An "Auth & Capture" transaction completes both the authorization
 * of the payment information and the transfer of funds in one call.
 */

$transaction = new AuthorizeNetTransaction;
$transaction->amount = $subAmount;
$transaction->customerProfileId = $customerProfileId;
$transaction->customerPaymentProfileId = $paymentProfileId;

$response = $request->createCustomerProfileTransaction(
    "AuthCapture", 
    $transaction
);

if (ANet_Response_getResultCode($response) == 'Error') {
    // throws an expception based on the resultCode returned in the response
    $errorMsg = '';
    
    $code = ANet_Response_getMessageCode($response);
    
    switch ($code) {
        case 'E00027':
            $msg = ANet_Response_getMessageText($response);
            
            switch ($msg) {
                case 'A duplicate transaction has been submitted.':
                    // Authorize.net will deny transactions for identical
                    // amounts that are submitted within two minutes of
                    // each other
                    $errorMsg = 'You are submitting orders too rapidly and have ' .
                                'triggered the duplicate transaction prevention ' .
                                'mechanisms with the payment gateway. We ' .
                                'apologize for the inconvenience. Please wait ' .
                                'two minutes and try again.';
                    break;
                case 'The credit card number is invalid.':
                    $errorMsg = 'Your payment information was declined by ' .
                                'the payment gateway. Please verify you ' .
                                'have entered your information correctly ' .
                                'and try again.';
                    
                    // deletes the invalid payment profile
                    $response = $request->deleteCustomerPaymentProfile(
                        $customerProfileId,
                        $paymentProfileId
                    );
                    
                    break;
                default:
                    $errorMsg = $code . ': ' . $msg;
                    break;
            }
            
            break;
        default:
            $errorMsg = $code . ': ' . ANet_Response_getMessageText($response);
            break;
    }
    
    
    throw new Exception($errorMsg);
}

// gets the transaction ID to save in the subscription table
$transactionResponse = $response->getTransactionResponse();
$transactionId = $transactionResponse->transaction_id;
error_log(print_r($transactionResponse, true));

if (empty($transactionId)) {
    throw new Exception('There was an error processing your transaction. Try again in a few minutes.');
}

// send a confirmation email to the user and the site admin
$toStre      = $fldEmail;
$subjectStre = "College Prospect Network - Subscription Confirmation";

$bodyTpl  = 'Dear %s %s' .
            '<br /><br />' .
            'Your payment has been received and your Subscription is now active.' .
            '<br /><br />' .
            'Order ID: %s' .
            '<br />' .
            'Order Date: %s' .
            '<br /><br />' .
            'College Prospect Network' .
            '<br />' .
            '<a href="http://www.collegeprospectnetwork.com">www.CollegeProspectNetwork.com</a>';

$bodyStre = sprintf($bodyTpl, $fldFirstName, 
                              $fldLastName, 
                              $transactionId, 
                              date('y-m-d'));

$func->sendEmail($toStre, $subjectStre, $bodyStre, ADMIN_EMAIL);
$func->sendEmail(ADMIN_EMAIL, $subjectStre, $bodyStre, ADMIN_EMAIL);

// updates the user account to indicate an active subscrption
$data = array('fldSubscribe' => 1);
$db1->updateRec(TBL_COLLEGE_COACH_REGISTER, $data, 'fldId=' . $fldId);

// calculates the expiration date for the subscription
$startDate = date('Y-m-d');
$endDate = null;

switch ($subType) {
    case 16:
        $endDate = date('Y-m-d', strtotime('+1 month'));
        break;
    case 17:
        $endDate = date('Y-m-d', strtotime('+1 year'));
        break;
    case 18:
        $endDate = date('Y-m-d', strtotime('+3 years'));
        break;
}

// adds the subscription information to the subscription table
$subscription = array(
    'fldType' => $subType,
    'fldSport' => $subSport,
    'fldCoach' => $fldId,
    'fldAmount' => $subAmount,
    'fldDate' => $startDate,
    'fldNextBillDate' => $endDate,
    'fldPaymentProfileId' => $paymentProfileId,
    'fldActive' => 1
);

$db1->insertRec(TBL_COLLEGE_SUBSCRIPTION, $subscription);
$subId = $db1->insert_id();

// adds record of the payment for the payment history table
$payment = array(
    'fldSubId' => $subId,
    'fldCoachId' => $fldId,
    'fldDate' => $startDate,
    'fldAmount' => $subAmount,
    'fldTransactionId' => $transactionId
);

$db1->insertRec(TBL_PAYMENT_HISTORY, $payment);
