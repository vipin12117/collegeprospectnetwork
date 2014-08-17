<?php
    ############ Add Network Request ############                                                         
    if ($_REQUEST['mode'] == "request") {
        
        //Get Globals
        $Page = $GLOBALPage; 
        $ReceiverUserType = $GLOBALProfileType;  //Type set in Inherited Page
        
        //Set Local Variables
        $SenderID = "";  //Requester UserId (athlete, hs coach, college coach)
        $SenderUserType = $_SESSION['mode'];  //Sender's User Type         
        $ReceiverID = $_REQUEST['fldId'];  //This Receivers's ID    
        
                
        //Add Network Request based on User Type
         switch ($SenderUserType) {
            case 'athlete':
                //AthleteID
                $SenderID = $_SESSION['Athlete_id'];
                break;
            case 'coach':
                //HS Coach ID
                $SenderID = $_SESSION['Coach_id']; 
                break;
            case 'college':
                //College Coach ID
                $SenderID = $_SESSION['College_Coach_id'];   
                break;
        }                
        
        //Build Insert Array
        $strDataArr = array('fldSenderid' => $SenderID, 'fldSenderType' => $SenderUserType, 'fldReceiverid' => $ReceiverID, 'fldReceiverType' => $ReceiverUserType, 'fldStatus' => "Pending");        
        
        //Build WhereClause
        $whereClause = "(fldSenderid='" . $SenderID . "' AND fldSenderType='" . $SenderUserType . "' AND fldReceiverid='" . $ReceiverID . "' AND fldReceiverType='" . $ReceiverUserType . "') ";
        $whereClause .= " OR (fldSenderid='" . $ReceiverID . "' AND fldSenderType='" . $ReceiverUserType . "' AND fldReceiverid='" . $SenderID . "' AND fldReceiverType='" . $SenderUserType . "') ";
        
        //Check if Network Request already exists
        if ($db -> MatchingRec(TBL_NETWORK, $whereClause) > 0) {
            //Request Already Exists
            $msg = 'Sorry, there is already an Active or Pending Network Request with this user.';
            header("Location: " . $GLOBALPage . "$ReceiverID&errormsg=$msg");
        } else {
            
            ##INSERT
            $db -> insertRec(TBL_NETWORK, $strDataArr);
            
            ##SENT EMAIL to USER                  
            $subjectStrek = "College Prospect Network - New Network Request";            
            
             #Login Info & Directions              
             $EmailUsername = "";
             $EmailPassword = "";
             $EmailTo = "";
             $EmailUserID = $ReceiverID; //Set Email User ID
             $EmailUserType = $ReceiverUserType;  //Set Email User Type, manual or by var
  
             switch ($EmailUserType) {
                case 'athlete':
                    //AthleteID
                    $Loginquery = "select * from tbl_athelete_register where fldId='".$EmailUserID."' ";
                    $db2 -> query($Loginquery);
                    $db2 -> next_record();
                    $EmailUsername = $func -> output_fun($db2 -> f('fldUsername'));
                    $EmailPassword = $func -> output_fun($db2 -> f('fldPassword'));
                    $EmailTo = $func -> output_fun($db2 -> f('fldEmail'));
                    $EmailFirstname = $func -> output_fun($db2 -> f('fldFirstname'));
                    $EmailLastname = $func -> output_fun($db2 -> f('fldLastname'));
                    $EmailUserType = "Athlete";
                    break;
                case 'coach':
                    //HS Coach ID
                    $Loginquery = "select * from tbl_hs_aau_coach where fldId='".$EmailUserID."' ";
                    $db2 -> query($Loginquery);
                    $db2 -> next_record();
                    $EmailUsername = $func -> output_fun($db2 -> f('fldUsername'));
                    $EmailPassword = $func -> output_fun($db2 -> f('fldPassword'));
                    $EmailTo = $func -> output_fun($db2 -> f('fldEmail'));
                    $EmailFirstname = $func -> output_fun($db2 -> f('fldName'));
                    $EmailLastname = $func -> output_fun($db2 -> f('fldLastName'));
                    $EmailUserType = "HS/AAU Coach";
                    break;
                case 'college':
                    //College Coach ID
                    $Loginquery = "select * from tbl_college_coach_register where fldId='".$EmailUserID."' ";
                    $db2 -> query($Loginquery);
                    $db2 -> next_record();
                    $EmailUsername = $func -> output_fun($db2 -> f('fldUserName'));
                    $EmailPassword = $func -> output_fun($db2 -> f('fldPassword'));
                    $EmailTo = $func -> output_fun($db2 -> f('fldEmail'));
                    $EmailFirstname = $func -> output_fun($db2 -> f('fldFirstName'));
                    $EmailLastname = $func -> output_fun($db2 -> f('fldLastName'));
                    $EmailUserType = "College Coach";
                    break;
            }      

            $bodyStrek = "Hi " . $EmailFirstname . " " . $EmailLastname . ",<br /><br />";
            $bodyStrek .= "You have been sent a new Network Request.  Please login to your account to Approve/Deny at 'My Account > Users In My Network' <br /><br />";
                                       
            $bodyStrek .= "-------------------------------------------------------- <br />";
            $bodyStrek .= "Login: <a href=http://www.collegeprospectnetwork.com/login.php>http://www.collegeprospectnetwork.com/login.php</a><br />";
            $bodyStrek .= "Username: " . $EmailUsername . "<br />";
            $bodyStrek .= "Password: " . $EmailPassword ."<br />";
            $bodyStrek .= "User Type: " . $EmailUserType ."<br />";
            $bodyStrek .= "-------------------------------------------------------- <br />";
            $bodyStrek .= "<br />";                        
                        
            $bodyStrek .= "Please do not respond to this email. If you have any questions, use the Contact Us page on the website.<br /><br />";
            $bodyStrek .= "Thank you,<br />";
            $bodyStrek .= "College Prospect Network";
            $func -> sendEmail($EmailTo, $subjectStrek, $bodyStrek, "notifications@collegeprospectnetwork.com");
            #//End EMAIL
            
            ##DISPLAY SUCCESS
            $msg = "Thank you, your Network Request has been successfully sent.  You will be notified when they accept or deny request.";
            header("Location: " . $GLOBALPage . "$ReceiverID&msg=$msg");
        }
        
    }
    ##### //END Add Network Request #####
?>