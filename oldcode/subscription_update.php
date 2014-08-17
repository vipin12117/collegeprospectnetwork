<?php

require_once 'anet_php_sdk/AuthorizeNet.php';
require_once 'AuthorizeNetMerchantAccount.php';

// gets the Authorize.net payment profile ID created
// for the subscription from the database
$queryString = "SELECT `%s` FROM `%s` WHERE fldId='%s'";
$query = sprintf($queryString, 'fldPaymentProfileId', 
                 TBL_COLLEGE_SUBSCRIPTION, $subId);

$db1->query($query);
$db1->next_record();

$paymentProfileId = $db1->f('fldPaymentProfileId');

// updates the payment profile with the new information
$paymentProfile = new AuthorizeNetPaymentProfile;
$paymentProfile->payment->creditCard->cardNumber = $subCardnumber;
$paymentProfile->payment->creditCard->expirationDate = $subCardExpDate;
$paymentProfile->billTo->firstName = $subFName;
$paymentProfile->billTo->lastName = $subLName;
$paymentProfile->billTo->address = $subAddress;
$paymentProfile->billTo->city = $subCity;
$paymentProfile->billTo->state = $subState;
$paymentProfile->billTo->zip = $subZip;

$request = new AuthorizeNetCIM;

$response = $request->updateCustomerPaymentProfile(
    $customerProfileId,
    $paymentProfileId,
    $paymentProfile
);

if (ANet_Response_getResultCode($response) == 'Error') {
    $e = ANet_Response_getMessageCode($response) . ': ' .
         ANet_Response_getMessageText($response);
    
    throw new Exception($e);
}

