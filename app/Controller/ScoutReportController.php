<?php

class ScoutReportController extends AppController {

    public $name = 'ScoutReport';

    public $components = array('Email','RequestHandler' , 'Session');

    public $helpers = array('Html','Form','Js' => array('Jquery'));

    public function beforeFilter() {
        parent::beforeFilter();

        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') ////for admin section template
        {
            if ($this->checkAdminSession()) {
                $this->layout = 'admin';
            } else {
                $this->redirect(array('controller'=>'admins','action'=>'login'));
            }
        } else {
            $this->checkSession();
        }
        require_once(APP . 'Vendor' . DS . 'mpdf' . DS . 'mpdf.php');
    }

    public function admin_scoutreportList() {
        $limit = 50;
        $this->loadModel('ScoutReports');
        $this->paginate = array('ScoutReports' => array('limit' => $limit));
        $ScoutReports = $this->paginate('ScoutReports');

        $this->set(compact('ScoutReports', 'limit'));
    }

    public function admin_deleteScoutreport($id) {
        if (isset($id) && $id != 0) {
            $this->loadModel('ScoutReports');
            $db = ConnectionManager::getDataSource('default');
            $db->rawQuery("DELETE FROM scout_report_athletes WHERE scout_report_id=".$id);
            if($this->ScoutReports->delete($id)) {
                $this->Session->setFlash('Scout Report Deleted Successfully!', 'flash_success');
            } else {
                $this->Session->setFlash('Can not delete this Scout Report', 'flash_error');
            }
        } else {
            $this->Session->setFlash('Do not exits this Scout Report', 'flash_error');
        }
        $this->redirect($this->referer());
    }

    public function admin_editScoutreport($id) {
        if (isset($id) && $id != 0) {
            $this->loadModel('ScoutReports');
            $this->loadModel('SpecialEvent');
            $this->loadModel('Athlete');

            $ScoutReports = $this->ScoutReports->findById($id);
            if($ScoutReports) {
                $EventDetail = $this->SpecialEvent->findById($ScoutReports['ScoutReports']['event_id']);
                $ScoutReport = $this->ScoutReport->find("all",array("conditions"=>"scout_report_id = $id"));
                if($EventDetail && $ScoutReport) {


                    if(isset($this->request->data['title']) && isset($this->request->data['event_id']) && $this->request->data['event_id'] != 0 && isset($this->request->data['report']) && !empty($this->request->data['report'])) {
                    //echo '<pre>' ;print_r($this->request->data);exit;
                        $this->ScoutReports->id = $id;
                        $report_main_data = array('title'=>trim($this->request->data['title']) , 'modify_date'=> time()) ;
                        $this->ScoutReports->save($report_main_data) ;
                        $scout_report_id = $id ;
                        if($scout_report_id != 0) {
                            foreach($this->request->data['report'] as $i=>$report) {
                                $report['scout_report_id'] = $scout_report_id ;
                                if(isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                                    if($_FILES['picture']['error'][$i] == 0 && $_FILES['picture']['size'][$i] > 0 && $_FILES['picture']['name'][$i] != '') {
                                        $filename = '' ;
                                        if (!empty($_FILES['picture']['tmp_name'][$i]) && is_uploaded_file($_FILES['picture']['tmp_name'][$i])) {
                                        // Strip path information
                                            $filename = mt_rand() . "_" . $_FILES['picture']['name'][$i] ;
                                            move_uploaded_file( $_FILES['picture']['tmp_name'][$i] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                                            $report['picture'] = $filename ;
                                        }
                                    }
                                }

                                $Athlete = $this->Athlete->find("first",array("conditions"=>array('firstname'=> trim($report['firstname'])),"fields"=>"id"));
                                if($Athlete) {
                                    $report['athlete'] = $Athlete['Athlete']['id'] ;
                                }elseif(!$Athlete && isset($report['athlete']) && ($report['athlete'] == '' || $report['athlete'] == 0)) {
                                    $this->Athlete->create();
                                    $var_athlete = trim($report['firstname']) . mt_rand(100,999) ;
                                    $athlete_data = array(
                                        'username'=> $var_athlete,
                                        'password'=> $var_athlete ,
                                        'email'=>trim($report['email']) ,
                                        'firstname'=>trim($report['firstname']) ,
                                        'lastname'=>trim($report['lastname']) ,
                                        'class'=>trim($report['class']) ,
                                        'status'=> 1 ,
                                        'coach_id'=> 0 ,
                                        'added_date'=> time()
                                        ) ;
                                    $this->Athlete->save($athlete_data) ;
                                    $report['athlete'] = $this->Athlete->getLastInsertID();
                                }

                                if(isset($report['scout_report_athletes_id']) && !empty($report['scout_report_athletes_id']) && $report['scout_report_athletes_id'] != 0) {
                                    $this->ScoutReport->id = $report['scout_report_athletes_id'];
                                    $this->ScoutReport->save($report) ;
                                } else {
                                    $this->ScoutReport->create();
                                    $this->ScoutReport->save($report) ;
                                }

                            }
                            $this->Session->setFlash('Scout Report are updated Successfully', 'flash_success');
                            $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                        }
                        else {
                            $this->Session->setFlash('Sorry , new report can not generate!', 'flash_error');
                            $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                        }
                    }

                    $this->set('ScoutReportMain', $ScoutReports);
                    $this->set('EventDetail', $EventDetail);
                    $this->set('ScoutReports', $ScoutReport);
                }
                else {
                    $this->Session->setFlash('May be Event or atheletes removed of report!', 'flash_error');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                }
            }
            else {
                $this->Session->setFlash('Do not exits any scout report', 'flash_error');
                $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
            }
        } else {
            $this->Session->setFlash('Do not exits this Scout report', 'flash_error');
            $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
        }
    }

    public function admin_addScoutreport() {
        if ($this->request->is('post')) {
            if(isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                if($_FILES['picture']['error'] == 0 && $_FILES['picture']['size'] > 0) {
                    $filename = '' ;
                    if (!empty($_FILES['picture']['tmp_name']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
                    // Strip path information
                        $filename = mt_rand() . "_" . $_FILES['picture']['name'] ;
                        move_uploaded_file( $_FILES['picture']['tmp_name'] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                        $this->request->data['picture'] = $filename ;
                    }
                }
            }
            if($this->request->data['title'] != '' && $this->request->data['event'] != '') {
            //echo '<pre>' ;print_r($this->request->data);exit;
                $this->loadModel('Athlete');
                $this->loadModel('SpecialEvent');
                $event = $this->SpecialEvent->find("first",array("conditions"=>array('event_name'=> trim($this->request->data['event'])),"fields"=>"id,event_name"));
                if($event) {
                    $this->loadModel('ScoutReports');
                    $is_addedReport = $this->ScoutReports->find("first",array("conditions"=>array('event_id'=>$event['SpecialEvent']['id'])),array("fields"=>"id , title"));
                    $Athlete = $this->Athlete->find("first",array("conditions"=>array('firstname'=> trim($this->request->data['firstname'])),"fields"=>"id"));
                    if($Athlete) {
                        $this->request->data['athlete'] = $Athlete['Athlete']['id'] ;
                    }elseif(!$Athlete && isset($this->request->data['athlete']) && $this->request->data['athlete'] == '') {
                        $this->Athlete->create();
                        $var_athlete = trim($this->request->data['firstname']) . mt_rand(100,999) ;
                        $athlete_data = array(
                            'username'=> $var_athlete,
                            'password'=> $var_athlete ,
                            'email'=>trim($this->request->data['email']) ,
                            'firstname'=>trim($this->request->data['firstname']) ,
                            'lastname'=>trim($this->request->data['lastname']) ,
                            'class'=>trim($this->request->data['class']) ,
                            'status'=> 1 ,
                            'coach_id'=> 0 ,
                            'added_date'=> time()
                            ) ;
                        $this->Athlete->save($athlete_data) ;
                        $this->request->data['athlete'] = $this->Athlete->getLastInsertID();
                    }
                    $this->ScoutReports->create();
                    $report_main_data = array('title'=>trim($this->request->data['title']) , 'event_id'=>$event['SpecialEvent']['id'] , 'add_date'=> time()) ;
                    $this->ScoutReports->save($report_main_data) ;
                    $scout_report_id = $this->ScoutReports->getLastInsertID();
                    if($scout_report_id != 0) {
                        $insert = $this->request->data ;
                        unset($insert['title']) ;
                        unset($insert['event']) ;
                        $insert['scout_report_id'] = $scout_report_id ;
                        if($this->ScoutReport->save($insert)) {
                            $this->Session->setFlash('Scout Report is Added Successfully', 'flash_success');
                            $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                        }
                    }


                }else {
                    $this->Session->setFlash('No Such Event found as do you wish for generate report!', 'flash_error');
                }
            }else {
                $this->Session->setFlash('Title And Event Name are required', 'flash_error');
            }
        }
    }

    public function admin_scoutDetails($id) {
        if (isset($id)) {
            $this->loadModel('ScoutReports');
            $this->loadModel('SpecialEvent');
            $ScoutReports = $this->ScoutReports->findById($id);
            if($ScoutReports) {
                $EventDetail = $this->SpecialEvent->findById($ScoutReports['ScoutReports']['event_id']);
                $ScoutReport = $this->ScoutReport->find("all",array("conditions"=>"scout_report_id = $id"));
                if($EventDetail && $ScoutReport) {
                    $this->set('ScoutReportMain', $ScoutReports);
                    $this->set('EventDetail', $EventDetail);
                    $this->set('ScoutReports', $ScoutReport);
                }else {
                    $this->Session->setFlash('Sorry , event or may be atheletes not found!', 'flash_error');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                }

            }else {
                $this->Session->setFlash('Sorry , report not found!', 'flash_error');
                $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
            }
        } else {
            $this->Session->setFlash('Do not exits this Scout Report', 'flash_error');
        }
    }

    public function admin_search() {
        $schools = array() ;
        if ($this->request->is('post')) {
            $this->loadModel('SpecialEvent');
            if(isset($_POST['hsaauteam']) && !empty($_POST['hsaauteam'])) {
                $events = $this->SpecialEvent->find("all",array("conditions"=>array('event_name LIKE '=> "%" . trim($_POST['hsaauteam']) . "%" ),"fields"=>"id,event_name","order"=>"event_name ASC"));
            }
        }
        $this->set('events', $events);
    }

    public function admin_atheletesearch() {
        if ($this->request->is('post')) {
            if(isset($_POST) && !empty($_POST)) {
                $event_id = key($_POST) ;
                $this->loadModel('ScoutReports');
                if($event_id > 0) {
                    $Report = $this->ScoutReports->find("first",array("conditions"=>array('event_id'=>$event_id)),array("fields"=>"id , title"));
                    $this->loadModel('SpecialEvent');
                    $EventDetail = $this->SpecialEvent->findById($event_id);
                    $this->set('EventDetail', $EventDetail);
                    $this->set('event_id', $event_id);
                }
            }
        }
    }

    public function admin_addmultiplereport() {
    //echo '<pre>' ;print_r($this->request->data);exit;
        if(isset($this->request->data['title']) && isset($this->request->data['event_id']) && $this->request->data['event_id'] != 0 && isset($this->request->data['report']) && !empty($this->request->data['report'])) {
            $this->loadModel('ScoutReports');
            $this->loadModel('Athlete');
            $this->ScoutReports->create();
            $report_main_data = array('title'=>trim($this->request->data['title']) , 'event_id'=>$this->request->data['event_id'] , 'add_date'=> time()) ;
            $this->ScoutReports->save($report_main_data) ;
            $scout_report_id = $this->ScoutReports->getLastInsertID();
            if($scout_report_id != 0) {
                foreach($this->request->data['report'] as $i=>$report) {
                    $report['scout_report_id'] = $scout_report_id ;
                    if(isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                        if($_FILES['picture']['error'][$i] == 0 && $_FILES['picture']['size'][$i] > 0 && $_FILES['picture']['name'][$i] != '') {
                            $filename = '' ;
                            if (!empty($_FILES['picture']['tmp_name'][$i]) && is_uploaded_file($_FILES['picture']['tmp_name'][$i])) {
                            // Strip path information
                                $filename = mt_rand() . "_" . $_FILES['picture']['name'][$i] ;
                                move_uploaded_file( $_FILES['picture']['tmp_name'][$i] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                                $report['picture'] = $filename ;
                            }
                        }
                    }
                    //echo '<pre>';print_r($report);exit;

                    $Athlete = $this->Athlete->find("first",array("conditions"=>array('firstname'=> trim($report['firstname'])),"fields"=>"id"));
                    if($Athlete) {
                        $report['athlete'] = $Athlete['Athlete']['id'] ;
                    }elseif(!$Athlete && isset($report['athlete']) && ($report['athlete'] == '' || $report['athlete'] == 0)) {
                        $this->Athlete->create();
                        $var_athlete = trim($report['firstname']) . mt_rand(100,999) ;
                        $athlete_data = array(
                            'username'=> $var_athlete,
                            'password'=> $var_athlete ,
                            'email'=>trim($report['email']) ,
                            'firstname'=>trim($report['firstname']) ,
                            'lastname'=>trim($report['lastname']) ,
                            'class'=>trim($report['class']) ,
                            'status'=> 1 ,
                            'coach_id'=> 0 ,
                            'added_date'=> time()
                            ) ;
                        $this->Athlete->save($athlete_data) ;
                        $report['athlete'] = $this->Athlete->getLastInsertID();
                    }

                    $this->ScoutReport->create();
                    $this->ScoutReport->save($report) ;
                }

                $this->Session->setFlash('Scout Report are Added Successfully', 'flash_success');
                $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
            }
            else {
                $this->Session->setFlash('Sorry , new report can not generate!', 'flash_error');
                $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
            }
        } else {
            $this->Session->setFlash('Sorry , No Data found!', 'flash_error');
            $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
        }
    }

    public function admin_getHSScout() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $schools = array() ;
        $html = '' ;
        $this->loadModel('HsAauTeam');
        if(isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $state_id = $_GET['state_id'] ;
            $schools = $this->HsAauTeam->find("list",array("conditions"=>array('state'=>$state_id),"fields"=>"id,school_name","order"=>"school_name ASC"));
            foreach($schools as $key=>$name) {
                $html .= "<option value=$key >" . $name  . "</option>" ;
            }
        }
        echo $html ;die ;
    }

    public function view() {

        $this->loadModel('ScoutReport');
        $atheletes = array();
        $this->loadModel('CollegeSubscription');
        $user_id = $this->Session->read('user_id');
        $today = date("Y-m-d h:i:s") ;
        $coachsubscription = $this->CollegeSubscription->find('first', array('conditions' => array('CollegeSubscription.college_coach_id' => $user_id ,'CollegeSubscription.status' => 1 ,'CollegeSubscription.next_billdate >=' => "$today")));
        if($coachsubscription) {
            if(isset($_POST['best_game']) && !empty($_POST['best_game'])) {
                $atheletes = $this->ScoutReport->find('all', array('conditions' => array('ScoutReport.best_game' => $_POST['best_game'])));
            }
            if($atheletes) {
                $this->loadModel('Wingspan');
                $this->loadModel('HsAauTeam');
                $this->loadModel('Event');

                $mpdf = new mpdf();

                $html = '<style>@page{style="border: 3px solid blue;}</style>' ;
                $html .= '<h5 style="text-align:center;">College Prospect Networkâ€™s</h5>';
                $html .= '' ;
                $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                $img = WWW_ROOT . DS . 'img/logo.jpg' ;
                $html .= '<br><p style="text-align:center;">' ;
                $html .= '<img src="' . WWW_ROOT .  'img' . DS . 'logo.jpg" alt="test alt attribute" width="200" height="150" border="0" />' ;
                //$pdf->Image('@' . $img, 'C' , '', 30, 30, '', '', 'C', false, 300, 'C', false, false, 1, false, false, false);
                $html .= '</p></br></br>' ;
                $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                $html .= '<p>Note: Most PC users will need to hold â€˜Ctrlâ€™ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search â€œ50 to Follow: (name of the game)â€�. For example, if the player you want to see played best on Court 3 â€“ Game 1, you will go to YouTube and type â€œ50 to Follow: Court 3 â€“ Game 1â€�. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                // output the HTML content
                $mpdf->writeHTML($html);

                if($atheletes) {
                    $mpdf->AddPage();
                    foreach($atheletes as $i=>$athelete) {

                        if($i != 0 && $i%2 == 0) {
                            $mpdf->AddPage();
                        }
                        $school_name = $priaauteam_name = $bestgame_name = $othergame_name = '' ;
                        $school = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['high_school']),"fields"=>"id,school_name"));
                        $priaauteam = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['primary_aau_team']),"fields"=>"id,school_name"));
                        $bestgame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['best_game']),"fields"=>"id,event_name"));
                        $othergame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['other_game']),"fields"=>"id,event_name"));
                        if($school) {
                            $school_name = $school[$athelete['ScoutReport']['high_school']] ;
                        }
                        if($priaauteam) {
                            $priaauteam_name = $priaauteam[$athelete['ScoutReport']['primary_aau_team']] ;
                        }
                        if($bestgame) {
                            $bestgame_name = $bestgame[$athelete['ScoutReport']['best_game']] ;
                        }
                        if($othergame) {
                            $othergame_name = $othergame[$athelete['ScoutReport']['other_game']] ;
                        }
                        if($athelete['ScoutReport']['picture']) {
                            $img1 = WWW_ROOT . 'img' . DS . 'scoutreport'. DS . $athelete['ScoutReport']['picture'] ;
                        }else {
                            $img1 = $img ;
                        }
                        $i = $i +1 ;
                        $athelete_html = "<p># " . $i ."</p>" ;
                        $athelete_html .= '<table border="1" cellspacing="0">' ;
                        //$athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                        $athelete_html .= '<tr>
                                   <td style="text-align:center;"><img src="' .$img1 . '" alt="athelete pic" width="150" height="180" border="0" />';

                        $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$bestgame_name.' <br><b>Other Game:</b>'.$othergame_name.' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                            .'<br><b>Coach Info : </b> ' . $school_name . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $priaauteam_name . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ' .$athelete['ScoutReport']['street_address'] . '</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>' . $school_name .'</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>'.$school_name.' / '.$priaauteam_name . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                        $athelete_html .= '</table>' ;
                        $mpdf->writeHTML($athelete_html);
                    }
                }
                $mpdf->output("scoutreport","D") ;
                exit;

            }else {
                $this->Session->setFlash('No Athelete available under your selected event!', 'flash_error');
                $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Please paid for subscription first!', 'flash_error');
            $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
        }
    }

    public function pdfbyathelete($athlete_id = 0) {
        if($athlete_id != 0) {
            $this->loadModel('ScoutReport');
            $atheletes = array();
            $this->loadModel('CollegeSubscription');
            $user_id = $this->Session->read('user_id');
            $today = date("Y-m-d h:i:s") ;
            $coachsubscription = $this->CollegeSubscription->find('first', array('conditions' => array('CollegeSubscription.college_coach_id' => $user_id ,'CollegeSubscription.status' => 1 ,'CollegeSubscription.next_billdate >=' => "$today")));
            if($coachsubscription) {
                $athelete = $this->ScoutReport->find('first', array('conditions' => array('ScoutReport.athlete' => $athlete_id)));
                //echo'<pre>';print_r($athelete);exit;
                if($athelete) {
                    $this->loadModel('Wingspan');
                    $this->loadModel('HsAauTeam');
                    $this->loadModel('Event');

                    $mpdf = new mpdf();

                    $html = '<style>@page{style="border: 3px solid blue;}</style>' ;
                    $html .= '<h5 style="text-align:center;">College Prospect Networkâ€™s</h5>';
                    $html .= '' ;
                    $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                    $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                    $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                    $img = WWW_ROOT . DS . 'img/logo.jpg' ;
                    $html .= '<br><p style="text-align:center;">' ;
                    $html .= '<img src="' . WWW_ROOT .  'img' . DS . 'logo.jpg" alt="test alt attribute" width="200" height="150" border="0" />' ;
                    //$pdf->Image('@' . $img, 'C' , '', 30, 30, '', '', 'C', false, 300, 'C', false, false, 1, false, false, false);
                    $html .= '</p></br></br>' ;
                    $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                    $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                    $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                    $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                    $html .= '<p>Note: Most PC users will need to hold â€˜Ctrlâ€™ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search â€œ50 to Follow: (name of the game)â€�. For example, if the player you want to see played best on Court 3 â€“ Game 1, you will go to YouTube and type â€œ50 to Follow: Court 3 â€“ Game 1â€�. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                    $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                    // output the HTML content
                    $mpdf->writeHTML($html);

                    $mpdf->AddPage();

                    $school_name = $priaauteam_name = $bestgame_name = $othergame_name = '' ;
                    $school = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['high_school']),"fields"=>"id,school_name"));
                    $priaauteam = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['primary_aau_team']),"fields"=>"id,school_name"));
                    //$bestgame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['best_game']),"fields"=>"id,event_name"));
                    //$othergame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['other_game']),"fields"=>"id,event_name"));
                    if($school) {
                        $school_name = $school[$athelete['ScoutReport']['high_school']] ;
                    }
                    if($priaauteam) {
                        $priaauteam_name = $priaauteam[$athelete['ScoutReport']['primary_aau_team']] ;
                    }
					/*if($bestgame) {
					 $bestgame_name = $bestgame[$athelete['ScoutReport']['best_game']] ;
					 }
					 if($othergame) {
					 $othergame_name = $othergame[$athelete['ScoutReport']['other_game']] ;
					 }*/
                    if($athelete['ScoutReport']['picture']) {
                        $img1 = WWW_ROOT . 'img' . DS . 'scoutreport'. DS . $athelete['ScoutReport']['picture'] ;
                    }else {
                        $img1 = $img ;
                    }
                    $i = 1 ;
                    $athelete_html = "<p># " . $i ."</p>" ;
                    $athelete_html .= '<table border="1" cellspacing="0">' ;
                    //$athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                    $athelete_html .= '<tr>
                                   <td style="text-align:center;"><img src="' .$img1 . '" alt="athelete pic" width="150" height="180" border="0" />';

                    $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$bestgame_name.' <br><b>Other Game:</b>'.$othergame_name.' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                        .'<br><b>Coach Info : </b> ' . $school_name . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $priaauteam_name . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                    $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ' .$athelete['ScoutReport']['street_address'] . '</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                    $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>' . $school_name .'</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                    $athelete_html .= '<tr>
                                   <td>'.$school_name.' / '.$priaauteam_name . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                    $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                    $athelete_html .= '</table>' ;
                    $mpdf->writeHTML($athelete_html);


                    $mpdf->output("scoutreport","D") ;
                    exit;

                } else {
                    $this->Session->setFlash('No reports added for this athelete , please try later.', 'flash_error');
                    $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
                }
            } else {
                $this->Session->setFlash('Please paid for subscription first!', 'flash_error');
                $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
            }

        }else {
            $this->Session->setFlash('Please choose athlete first!', 'flash_error');
            $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
        }
    }

    public function pdfbyatheletegroup() {
        if(isset($_POST['athlete']) && !empty($_POST['athlete'])) {
        //echo '<pre>';print_r($_POST);
            $this->loadModel('ScoutReport');
            $atheletes = array();
            $this->loadModel('CollegeSubscription');
            $user_id = $this->Session->read('user_id');
            $today = date("Y-m-d h:i:s") ;
            $coachsubscription = $this->CollegeSubscription->find('first', array('conditions' => array('CollegeSubscription.college_coach_id' => $user_id ,'CollegeSubscription.status' => 1 ,'CollegeSubscription.next_billdate >=' => "$today")));
            if($coachsubscription) {
                $condition_arr = array() ;
                $condition = '' ;
                foreach($_POST['athlete'] as $athelete) {
                    $condition_arr[] = 'ScoutReport.athlete = ' . $athelete ;
                }
                if($condition_arr) {
                    $condition = implode(" Or " , $condition_arr) ;
                }
                $atheletes = $this->ScoutReport->find('all', array('conditions' => $condition));

                if($atheletes) {
                    $this->loadModel('Wingspan');
                    $this->loadModel('HsAauTeam');
                    $this->loadModel('Event');

                    $mpdf = new mpdf();

                    $html = '<style>@page{style="border: 3px solid blue;}</style>' ;
                    $html .= '<h5 style="text-align:center;">College Prospect Networkâ€™s</h5>';
                    $html .= '' ;
                    $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                    $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                    $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                    $img = WWW_ROOT . DS . 'img/logo.jpg' ;
                    $html .= '<br><p style="text-align:center;">' ;
                    $html .= '<img src="' . WWW_ROOT .  'img' . DS . 'logo.jpg" alt="test alt attribute" width="200" height="150" border="0" />' ;
                    //$pdf->Image('@' . $img, 'C' , '', 30, 30, '', '', 'C', false, 300, 'C', false, false, 1, false, false, false);
                    $html .= '</p></br></br>' ;
                    $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                    $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                    $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                    $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                    $html .= '<p>Note: Most PC users will need to hold â€˜Ctrlâ€™ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search â€œ50 to Follow: (name of the game)â€�. For example, if the player you want to see played best on Court 3 â€“ Game 1, you will go to YouTube and type â€œ50 to Follow: Court 3 â€“ Game 1â€�. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                    $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                    // output the HTML content
                    $mpdf->writeHTML($html);

                    if($atheletes) {
                        $mpdf->AddPage();
                        foreach($atheletes as $i=>$athelete) {

                            if($i != 0 && $i%2 == 0) {
                                $mpdf->AddPage();
                            }
                            $school_name = $priaauteam_name = $bestgame_name = $othergame_name = '' ;
                            $school = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['high_school']),"fields"=>"id,school_name"));
                            $priaauteam = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['primary_aau_team']),"fields"=>"id,school_name"));
                            $bestgame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['best_game']),"fields"=>"id,event_name"));
                            $othergame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['other_game']),"fields"=>"id,event_name"));
                            if($school) {
                                $school_name = $school[$athelete['ScoutReport']['high_school']] ;
                            }
                            if($priaauteam) {
                                $priaauteam_name = $priaauteam[$athelete['ScoutReport']['primary_aau_team']] ;
                            }
							/*if($bestgame) {
							 $bestgame_name = $bestgame[$athelete['ScoutReport']['best_game']] ;
							 }
							 if($othergame) {
							 $othergame_name = $othergame[$athelete['ScoutReport']['other_game']] ;
							 }*/
                            if($athelete['ScoutReport']['picture']) {
                                $img1 = WWW_ROOT . 'img' . DS . 'scoutreport'. DS . $athelete['ScoutReport']['picture'] ;
                            }else {
                                $img1 = $img ;
                            }
                            $i = $i +1 ;
                            $athelete_html = "<p># " . $i ."</p>" ;
                            $athelete_html .= '<table border="1" cellspacing="0">' ;
                            //$athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                            $athelete_html .= '<tr>
                                   <td style="text-align:center;"><img src="' .$img1 . '" alt="athelete pic" width="150" height="180" border="0" />';

                            $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$bestgame_name.' <br><b>Other Game:</b>'.$othergame_name.' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                                .'<br><b>Coach Info : </b> ' . $school_name . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $priaauteam_name . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ' .$athelete['ScoutReport']['street_address'] . '</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>' . $school_name .'</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td>'.$school_name.' / '.$priaauteam_name . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                            $athelete_html .= '</table>' ;
                            $mpdf->writeHTML($athelete_html);
                        }
                    }
                    $mpdf->output("scoutreport","D") ;
                    exit;

                } else {
                    $this->Session->setFlash('No reports added for this athelete , please try later.', 'flash_error');
                    $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
                }
            } else {
                $this->Session->setFlash('Please paid for subscription first.', 'flash_error');
                $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
            }
        }
        else {
            $this->Session->setFlash('Please choose athlete first.', 'flash_error');
            $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
        }
    }

    public function download_report($report_id = 0) {
        if($report_id != 0 && $report_id != '') {

            $this->loadModel('ScoutReports');
            $this->loadModel('ScoutReport');
            $atheletes = array();
            $this->loadModel('CollegeSubscription');
            $user_id = $this->Session->read('user_id');
            $today = date("Y-m-d h:i:s") ;
            $coachsubscription = $this->CollegeSubscription->find('first', array('conditions' => array('CollegeSubscription.college_coach_id' => $user_id ,'CollegeSubscription.status' => 1 ,'CollegeSubscription.next_billdate >=' => "$today")));
            if($coachsubscription) {
                $Report_main = $atheletes = array() ;
                $Report_main = $this->ScoutReports->find('first', array('conditions' => array('id' => $report_id)));
                if($Report_main) {
                    $atheletes = $this->ScoutReport->find('all', array('conditions' => array('ScoutReport.scout_report_id' => $report_id)));
                }
                //echo '<pre>' ;print_r($Report_main);
                //echo '<pre>' ;print_r($atheletes);exit;
                if($Report_main && $atheletes) {
                    $this->loadModel('Wingspan');
                    $this->loadModel('HsAauTeam');
                    $this->loadModel('Event');
                    $mpdf = new mpdf();

                    $html = '<style>@page{style="border: 3px solid blue;}</style>' ;
                    $html .= '<h5 style="text-align:center;">College Prospect Networkâ€™s</h5>';
                    $html .= '' ;
                    $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                    $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                    $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                    $img = WWW_ROOT . DS . 'img/logo.jpg' ;
                    $html .= '<br><p style="text-align:center;">' ;
                    $html .= '<img src="' . WWW_ROOT .  'img' . DS . 'logo.jpg" alt="test alt attribute" width="200" height="150" border="0" />' ;
                    $html .= '</p></br></br>' ;
                    $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                    $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                    $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                    $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                    $html .= '<p>Note: Most PC users will need to hold â€˜Ctrlâ€™ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search â€œ50 to Follow: (name of the game)â€�. For example, if the player you want to see played best on Court 3 â€“ Game 1, you will go to YouTube and type â€œ50 to Follow: Court 3 â€“ Game 1â€�. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                    $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                    // output the HTML content
                    $mpdf->writeHTML($html);

                    if($atheletes) {
                        $mpdf->AddPage();
                        foreach($atheletes as $i=>$athelete) {

                            if($i != 0 && $i%2 == 0) {
                                $mpdf->AddPage();
                            }
                            $school_name = $priaauteam_name = $bestgame_name = $othergame_name = '' ;
                            $school = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['high_school']),"fields"=>"id,school_name"));
                            $priaauteam = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['primary_aau_team']),"fields"=>"id,school_name"));
                            $bestgame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['best_game']),"fields"=>"id,event_name"));
                            $othergame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['other_game']),"fields"=>"id,event_name"));
                            if($school) {
                                $school_name = $school[$athelete['ScoutReport']['high_school']] ;
                            }
                            if($priaauteam) {
                                $priaauteam_name = $priaauteam[$athelete['ScoutReport']['primary_aau_team']] ;
                            }
                            if($bestgame) {
                                $bestgame_name = $bestgame[$athelete['ScoutReport']['best_game']] ;
                            }
                            if($othergame) {
                                $othergame_name = $othergame[$athelete['ScoutReport']['other_game']] ;
                            }
                            if($athelete['ScoutReport']['picture']) {
                                $img1 = WWW_ROOT . 'img' . DS . 'scoutreport'. DS . $athelete['ScoutReport']['picture'] ;
                            }else {
                                $img1 = $img ;
                            }
                            $i = $i +1 ;
                            $athelete_html = "<p># " . $i ."</p>" ;
                            $athelete_html .= '<table border="1" cellspacing="0">' ;
                            //$athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                            $athelete_html .= '<tr>
                                   <td style="text-align:center;"><img src="' .$img1 . '" alt="athelete pic" width="150" height="180" border="0" />';

                            $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$bestgame_name.' <br><b>Other Game:</b>'.$othergame_name.' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                                .'<br><b>Coach Info : </b> ' . $school_name . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $priaauteam_name . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ' .$athelete['ScoutReport']['street_address'] . '</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>' . $school_name .'</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td>'.$school_name.' / '.$priaauteam_name . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                            $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                            $athelete_html .= '</table>' ;
                            $mpdf->writeHTML($athelete_html);
                        }
                    }
                    $mpdf->output("ScoutReport","D") ;
                    exit;

                } else {
                    $this->Session->setFlash('No Athelete available under your selected event!', 'flash_error');
                    $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
                }
            } else {
                $this->Session->setFlash('Please paid for subscription first!', 'flash_error');
                $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
            }
        }
        else {
            $this->Session->setFlash('Not Valid Url Found!', 'flash_error');
            $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
        }
    }

    public function admin_download_report_by_admin($report_id = 0) {
        if($report_id != 0 && $report_id != '') {

            $this->loadModel('ScoutReports');
            $this->loadModel('ScoutReport');
            $atheletes = array();
            $user_id = $this->Session->read('user_id');
            $today = date("Y-m-d h:i:s") ;
            $Report_main = $atheletes = array() ;
            $Report_main = $this->ScoutReports->find('first', array('conditions' => array('id' => $report_id)));
            if($Report_main) {
                $atheletes = $this->ScoutReport->find('all', array('conditions' => array('ScoutReport.scout_report_id' => $report_id)));
            }
            //echo '<pre>' ;print_r($Report_main);
            //echo '<pre>' ;print_r($atheletes);exit;
            if($Report_main && $atheletes) {
                $this->loadModel('Wingspan');
                $this->loadModel('HsAauTeam');
                $this->loadModel('Event');
                $mpdf = new mpdf();

                $html = '<style>@page{style="border: 3px solid blue;}</style>' ;
                $html .= '<h5 style="text-align:center;">College Prospect Networkâ€™s</h5>';
                $html .= '' ;
                $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                $img = WWW_ROOT . DS . 'img/logo.jpg' ;
                $html .= '<br><p style="text-align:center;">' ;
                $html .= '<img src="' . WWW_ROOT .  'img' . DS . 'logo.jpg" alt="test alt attribute" width="200" height="150" border="0" />' ;
                $html .= '</p></br></br>' ;
                $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                $html .= '<p>Note: Most PC users will need to hold â€˜Ctrlâ€™ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search â€œ50 to Follow: (name of the game)â€�. For example, if the player you want to see played best on Court 3 â€“ Game 1, you will go to YouTube and type â€œ50 to Follow: Court 3 â€“ Game 1â€�. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                // output the HTML content
                $mpdf->writeHTML($html);

                if($atheletes) {
                    $mpdf->AddPage();
                    foreach($atheletes as $i=>$athelete) {

                        if($i != 0 && $i%2 == 0) {
                            $mpdf->AddPage();
                        }
                        $school_name = $priaauteam_name = $bestgame_name = $othergame_name = '' ;
                        $school = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['high_school']),"fields"=>"id,school_name"));
                        $priaauteam = $this->HsAauTeam->find("list",array("conditions"=>array('id'=>$athelete['ScoutReport']['primary_aau_team']),"fields"=>"id,school_name"));
                        $bestgame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['best_game']),"fields"=>"id,event_name"));
                        $othergame = $this->Event->find("list",array("conditions"=>array("id"=>$athelete['ScoutReport']['other_game']),"fields"=>"id,event_name"));
                        if($school) {
                            $school_name = $school[$athelete['ScoutReport']['high_school']] ;
                        }
                        if($priaauteam) {
                            $priaauteam_name = $priaauteam[$athelete['ScoutReport']['primary_aau_team']] ;
                        }
                        if($bestgame) {
                            $bestgame_name = $bestgame[$athelete['ScoutReport']['best_game']] ;
                        }
                        if($othergame) {
                            $othergame_name = $othergame[$athelete['ScoutReport']['other_game']] ;
                        }
                        if($athelete['ScoutReport']['picture']) {
                            $img1 = WWW_ROOT . 'img' . DS . 'scoutreport'. DS . $athelete['ScoutReport']['picture'] ;
                        }else {
                            $img1 = $img ;
                        }
                        $i = $i +1 ;
                        $athelete_html = "<p># " . $i ."</p>" ;
                        $athelete_html .= '<table border="1" cellspacing="0">' ;
                        //$athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                        $athelete_html .= '<tr>
                                   <td style="text-align:center;"><img src="' .$img1 . '" alt="athelete pic" width="150" height="180" border="0" />';

                        $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$bestgame_name.' <br><b>Other Game:</b>'.$othergame_name.' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                            .'<br><b>Coach Info : </b> ' . $school_name . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $priaauteam_name . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ' .$athelete['ScoutReport']['street_address'] . '</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>' . $school_name .'</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>'.$school_name.' / '.$priaauteam_name . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                        $athelete_html .= '</table>' ;
                        $mpdf->writeHTML($athelete_html);
                    }
                }
                $mpdf->output("ScoutReport","D") ;
                exit;

            } else {
                $this->Session->setFlash('No Athelete available under your selected event!', 'flash_error');
                $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
            }
        }
        else {
            $this->Session->setFlash('Not Valid Url Found!', 'flash_error');
            $this->redirect(array('controller' => 'Profile', 'action' => 'index'));
        }
    }

    public function admin_getEvents() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $response = array() ;
        $this->loadModel('SpecialEvent');
        if(isset($_GET['q'])) {
            $term = addslashes($_GET['q']);
            $athletes = $this->SpecialEvent->find("all",array("conditions"=>"Lower(SpecialEvent.event_name) LIKE Lower('%$term%')"));
        }

        if($athletes) {
            foreach($athletes as $i=>$athlete) {
                $response[$i]['label'] = $athlete['SpecialEvent']['event_name'] ;
                $response[$i]['other'] = $athlete['SpecialEvent']['id'] ;
            }
        }
        echo json_encode($response); die;
    }

    public function admin_autoComplete_scout() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $response = array() ;
        $this->loadModel('Athlete');
        if(isset($_GET['q'])) {
            $term = $_GET['q'] ;
            $athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.firstname LIKE '%$term%' and Athlete.status = 1"));
        //$athletes = $this->Athlete->find("first",array("conditions"=>array('status'=>1 ,'firstname LIKE '=> "%$term%" ),"fields"=>"id,firstname","order"=>"firstname ASC"));
        }else {
            $athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.status = 1"));
        //$athletes = $this->Athlete->find("first",array("conditions"=>array('status'=>1),"fields"=>"id,firstname","order"=>"firstname ASC"));
        }
        if($athletes) {
            foreach($athletes as $i=>$athlete) {
                $response[$i]['label'] = $athlete['Athlete']['firstname'] ;
                $response[$i]['other'] = $athlete['Athlete']['id'] ;
            }
        }
        echo json_encode($response); die;
    }

    public function admin_autoComplete_scout_multiple() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $response = array() ;
        $this->loadModel('Athlete');
        if(isset($_GET['q'])) {
            $term = $_GET['q'] ;
            $athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.firstname LIKE '%$term%' and Athlete.status = 1"));
        //$athletes = $this->Athlete->find("first",array("conditions"=>array('status'=>1 ,'firstname LIKE '=> "%$term%" ),"fields"=>"id,firstname","order"=>"firstname ASC"));
        }else {
            $athletes = $this->Athlete->find("all",array("conditions"=>"Athlete.status = 1"));
        //$athletes = $this->Athlete->find("first",array("conditions"=>array('status'=>1),"fields"=>"id,firstname","order"=>"firstname ASC"));
        }
        if($athletes) {
            foreach($athletes as $i=>$athlete) {
                $response[$i]['label'] = $athlete['Athlete']['firstname'] ;
                $response[$i]['other'] = $athlete['Athlete']['id'] ;
                $response[$i]['tag'] = $_GET['tag'] ;
            }
        }
        echo json_encode($response); die;
    }

    public function admin_getAthleteInfo() {
        $this->autoLayout = false;
        $this->autoRender = false;

        if(isset($_GET['athlete']) && !empty($_GET['athlete'])) {
            $this->loadModel('Athlete');
            $athlete = $_GET['athlete'] ;
            $athleteDetail = $this->Athlete->find("first",array("conditions"=>"Athlete.id = '$athlete'"));
            $response = json_encode($athleteDetail);
            echo $response ;die;
        }
    }

    public function admin_getAthleteInfo_multiple() {
        $this->autoLayout = false;
        $this->autoRender = false;

        if(isset($_GET['athlete']) && !empty($_GET['athlete'])) {
            $this->loadModel('Athlete');
            $athlete = $_GET['athlete'] ;
            $athleteDetail = $this->Athlete->find("first",array("conditions"=>"Athlete.id = '$athlete'"));
            $response = json_encode(array("athleteDetail"=>$athleteDetail , "tag"=>$_GET['tag']));
            echo $response ;die;
        }
    }

    public function admin_getAddMoreHtml() {
        $this->autoLayout = false;
        $this->autoRender = false;
        if(isset($_POST['index']) && !empty($_POST['index'])) {
            $this->set('i' , $_POST['index']) ;
            $this->render("/ScoutReport/getAddFormHtml","ajax");
        }
        else {
            echo "No Data found" ;
            die;
        }
    }
}