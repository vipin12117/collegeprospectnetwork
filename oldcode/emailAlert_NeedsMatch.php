<!--Send email to ATHLETE if match the posted Needs-->
<?php
				//$selquery = 'select fldEmail, fldFirstname as name, fldLastname as name from ' . TBL_ATHELETE_REGISTER . ' where fldSportId = ' . $fldSport . 'and fldClass = ' . $fldGradClass .'and fldBenchPressMax = ' . $fldMinBenchPress . 'and fld40_yardDash = ' . $fldMax40YardDash .'and fldShuttleRun = ' . $fldMaxShuttleRun.'and fldVertical = ' . fldMinVertical. 'and fldGPA = ' . $fldGPA;

               //$selquery = 'first.fldPassword as HSCoachPassword from ' . TBL_HS_AAU_COACH . ' first,' . TBL_HS_AAU_COACH_SPORT_POSITION . ' second  where second.fldCoachNameId = first.fldId and second.fldSportId =' . $sportid . ' and first.fldSchool =' . $schoolid;
				//(latin1_general_cs,IMPLICIT) and (latin1_swedish_ci,IMPLICIT) '=' for 2 DB
				$selquery = 'select a.fldFirstname as name, a.fldLastname as lname from ' . TBL_ATHELETE_REGISTER . ' a,'. TBL_COLLEGE_NEEDS . ' c where a.fldSport = c.fldSportId OR a.fldClass = c.fldGradClass';
                
                if (!$db->query($selquery)) {
					die(mysql_error());
				}

                $db -> query($selquery);

               $db -> next_record();
                if ($db -> num_rows() > 0) {

                    for ($i = 0; $i < $db -> num_rows(); $i++) {

                        $name = $func -> output_fun($db -> f('name'));

                        $lname = $func -> output_fun($db -> f('lname'));
                        #Login Info
                        //$HSCoachUsername = $func -> output_fun($db -> f('HSCoachUsername'));
                        //$HSCoachPassword = $func -> output_fun($db -> f('HSCoachPassword'));
                        

                        $db -> next_record();

                    }
                        
                        ######################## EMAIL to HS COACH - Need Match Notification ########################
                        #Subject

                        $subjectStre = "College Prospect Network - We've found an athlete who matches your needs!";
                        
                        #Intro

                        $bodyStre = "Hi Coach" . ucfirst($collegeLname);                        
                        #Main Body

                       $bodyStre .= "We have an athlete who matches one or more of the \"Needs\" you posted on CollegeProspectNetwork.com. This athlete is attempting to connection with you. Please log on to the website to view their profile and accept/deny their request to be added to your network.\n\n";
                        
                        $bodyStre .= "Thank you,\n";
                        $bodyStre .= "College Prospect Network";
                        
                        $from = "notifications@collegeprospectnetwork.com";
                        #SEND EMAL
                        $func -> sendEmail($collegeEmail, $subjectStre, $bodyStre, $from);
                        ########## ///END EMAIL/// ##########
                    
                }
?>