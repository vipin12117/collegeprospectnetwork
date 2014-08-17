<?php

include_once ("inc/common_functions.php");
include_once ("inc/page.inc.php");

session_start();

$func = new COMMONFUNC;
$db = new DB;
$flag = 0;

/*
 * checks all active subscriptions in the database
 * to see if they need to be billed again
 */

require_once 'anet_php_sdk/AuthorizeNet.php';
require_once 'AuthorizeNetMerchantAccount.php';

// gets today's date
$today = date('Y-m-d');

// gets all active records with a next bill date equal to today
$query = "SELECT * FROM " . TBL_COLLEGE_SUBSCRIPTION . 
         " WHERE fldActive=1 AND fldNextBillDate='$today'";
$db->query($query);

// loops through all matching records, gets the customer's customer profile ID, the payment profile ID, and bills them for the subscription renewal. If the transaction faisl, the subscription is canceled
while ($db->next_record()) {
    $fldId     = $db->f('fldId');
    $fldType   = $db->f('fldType');
    $fldCoach  = $db->f('fldCoach');
    $fldAmount = $db->f('fldAmount');
    $fldPaymentProfileId = $db->f('fldPaymentProfileId');
    
    // gets the customer profile Id
    $query = "SELECT fldFirstName,fldLastName," .
             "fldANetCustomerProfileId,fldEmail FROM " . 
             TBL_COLLEGE_COACH_REGISTER . " WHERE fldId=$fldCoach";
    $db1->query($query);
    $db1->next_record();
    
    $fldFirstName = $db1->f('fldFirstName');
    $fldLastName = $db1->f('fldLastName');
    $fldCustomerProfileId = $db1->f('fldANetCustomerProfileId');
    $fldEmail = $db1->f('fldEmail');
    
    // attempts to charge the user for the subscription
    $transaction = new AuthorizeNetTransaction;
    $transaction->amount = $fldAmount;
    $transaction->customerProfileId = $fldCustomerProfileId;
    $transaction->customerPaymentProfileId = $fldPaymentProfileId;

    $request = new AuthorizeNetCIM;
    $response = $request->createCustomerProfileTransaction(
        "AuthCapture", 
        $transaction
    );
    
    // if the transaction fails, cancel the subscription
    if (ANet_Response_getResultCode($response) == 'Error') {
        $data = array(
            'fldActive' => 0,
            'fldCancelDate' => $today,
            'fldCancelReasonOther' => 'Automatic renewal failed (' .
                                 ANet_Response_getMessageCode($response) . ': ' .
                                 ANet_Response_getMessageText($response) . ')'
        );
        
        $db1->updateRec(TBL_COLLEGE_SUBSCRIPTION, $data, 'fldId=' . $fldId);
        
        // gets the active number of subscriptions for the current coach
        $query = "SELECT COUNT(*) AS subsCount FROM " . TBL_COLLEGE_SUBSCRIPTION . 
                 " WHERE fldActive=1 AND fldCoach=" . $fldCoach;
        
        $db1->query($query);
        $db1->next_record();
        
        $subsCount = $db1->f('subsCount');
        
        // increments the coach's cancel count by 1. If the
        // coach has no subscriptions now that this subscription
        // is canceled, set fldSubscribe to 0
        $query = "SELECT fldCancelCount FROM " . TBL_COLLEGE_COACH_REGISTER .
                 " WHERE fldId=" . $fldCoach;
        $db1->query($query);
        $db1->next_record();
        $fldCancelCount = $db1->f('fldCancelCount');
        
        $new_fldSubscribe   = ($subsCount > 0) ? 1 : 0;
        $new_fldCancelCount = $fldCancelCount + 1;
        
        // updates the record in tbl_college_coach_register
        $data = array('fldSubscribe' => $new_fldSubscribe,
                      'fldCancelCount' => $new_fldCancelCount);
        $rows = $db1->updateRec(TBL_COLLEGE_COACH_REGISTER,
                                $data, 'fldId=' . $fldCoach);
    } else {
        // gets the transaction ID to save in the subscription table
        $transactionResponse = $response->getTransactionResponse();
        $transactionId = $transactionResponse->transaction_id;
        
        // send a confirmation email to the user and the site admin
        $toStre      = $fldEmail;
        $subjectStre = "College Prospect Network - Subscription Renewal";

        $bodyTpl  = 'Dear %s %s' .
                    '<br /><br />' .
                    'Your subscription was automatically renewed and is currently active.' .
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
                                      date('Y-m-d'));

        $func->sendEmail($toStre, $subjectStre, $bodyStre, ADMIN_EMAIL);
        $func->sendEmail(ADMIN_EMAIL, $subjectStre, $bodyStre, ADMIN_EMAIL);
        
        // update the subscriptions table with a new next bill date
        $fldNextBillDate = null;
        
        switch (intval($fldType)) {
            case 16:
                $fldNextBillDate = date('Y-m-d', strtotime('+1 month'));
                break;
            case 17:
                $fldNextBillDate = date('Y-m-d', strtotime('+1 year'));
                break;
            case 18:
                $fldNextBillDate = date('Y-m-d', strtotime('+3 years'));
                break;
        }
        
        $db1->updateRec(
            TBL_COLLEGE_SUBSCRIPTION, 
            array('fldNextBillDate' => $fldNextBillDate), 
            'fldId=' . $fldId
        );
        
        // update the payment history table with the subscription id, coach id, bill date, bill amount, transaction id
        $data = array(
            'fldSubId' => $fldId,
            'fldCoachId' => $fldCoach,
            'fldDate' => $today,
            'fldAmount' => $fldAmount,
            'fldTransactionId' => $transactionId
        );
        
        $db1->insertRec(TBL_PAYMENT_HISTORY, $data);
    }
}
