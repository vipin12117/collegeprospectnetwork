<?php
/**
 * Provides Authorize.net payment gateway authentication 
 * credentials and several utility functions
 *
 * @author  Zach Pellman <zpellman@gmail.com>
 */
define("AUTHORIZENET_API_LOGIN_ID",     "24u2SUseP");
define("AUTHORIZENET_TRANSACTION_KEY",  "43U485fA9ySEq38K");
define("AUTHORIZENET_SANDBOX",          false);

/**
 * Gets the Authorize.net customer profile ID for the specified coach
 *
 * The Authorize.net customer profile ID saved with Authorize.net is simply the
 * coach's account ID (tbl_college_coach_register.fldId) prefixed by 'ccr_'
 *
 * @param   int     $coachId    the coach's account ID
 *
 * @return  string  the customer profile ID to be used with Authorize.net
 *
 * @access  public
 */
function ANet_getCustomerProfileId($coachId)
{
    return 'ccr_' . $coachId;
}

/**
 * Gets the result code ('Ok' or 'Error') from an Authorize.net response
 *
 * @param   AuthorizeNetResponse    $response   the AuthorizeNetResponse object
 *
 * @return  string  the result code from the response. Either 'Ok' or 'Error'
 *
 * @access  public
 *
 * @link http://www.authorize.net/support/CIM_XML_guide.pdf CIM XML Guide
 */
function ANet_Response_getResultCode($response)
{
    return $response->xml->messages->resultCode;
}

/**
 * Gets the message code from an Authorize.net response
 *
 * @param   AuthorizeNetResponse    $response   the AuthorizeNetResponse object
 *
 * @return  string  message code from the response
 *
 * @access  public
 *
 * @link http://www.authorize.net/support/CIM_XML_guide.pdf CIM XML Guide
 */
function ANet_Response_getMessageCode($response)
{
    return $response->xml->messages->message->code;
}

/**
 * Gets the descriptive message text from an Authorize.net response
 *
 * @param   AuthorizeNetResponse    $response   the AuthorizeNetResponse object
 *
 * @return  string  descriptive message text from the response
 *
 * @access  public
 *
 * @link http://www.authorize.net/support/CIM_XML_guide.pdf CIM XML Guide
 */
function ANet_Response_getMessageText($response)
{
    return $response->xml->messages->message->text;
}

/**
 * Gets the transaction ID from an Authorize.net transaction response
 *
 * @param   AuthorizeNetAIM_Response    $transactionResponse   
 *      the AuthorizeNetResponse object
 *
 * @return  string  the transaction ID
 *
 * @access  public
 *
 * @link http://www.authorize.net/support/AIM_guide.pdf AIM XML Guide
 */
function ANet_TransactionResponse_getTransactionId($transactionResponse)
{
    return $transactionResponse->transaction_id;
}

