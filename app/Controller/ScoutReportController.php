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
        if ($this->request->is('post')) {
            $searchName =  $this->request->data['searchname'];

            if (!empty($searchName)) {
                $conditions = array('ScoutReport.name LIKE ' => '%'.$searchName.'%');
            } else {
                $conditions = array();
            }
            $limit = 100;
            $this->loadModel('ScoutReport');
            $this->paginate = array('ScoutReport'=>array('conditions' => $conditions,  'limit' => $limit));

            $ScoutReports = $this->paginate('ScoutReport');
            $this->set(compact('ScoutReports', 'limit'));
        } else {
            $limit = 50;
            $this->loadModel('ScoutReport');
            $this->paginate = array('ScoutReport' => array('limit' => $limit));
            $ScoutReports = $this->paginate('ScoutReport');

            $this->set(compact('ScoutReports', 'limit'));
        }
    }

    public function admin_deleteScoutreport($id) {
        if (isset($id)) {
            if($this->ScoutReport->delete($id)) {
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
        if (isset($id)) {
            if ($this->request->is('post') && isset($this->request->data['athlete']) && !empty($this->request->data['athlete'])) {

                if(isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                    if($_FILES['picture']['error'] == 0 && $_FILES['picture']['size'] > 0) {
                        $filename = '' ;
                        if (!empty($_FILES['picture']['tmp_name']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
                        // Strip path information
                            $filename = mt_rand() . "_" . $_FILES['picture']['name'] ;
                            move_uploaded_file( $_FILES['picture']['tmp_name'] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                            $this->request->data['picture'] = $filename ;
                        }
                    }else {
                        $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                    }
                }
                $this->ScoutReport->id = $id;

                $report = $this->request->data ;
                $athelete_id = $report['athlete'] ;
                $is_added = $this->ScoutReport->find("first",array("conditions"=>"athlete = $athelete_id" ));
                //echo '<pre>';print_r($is_added);exit;
                if($is_added) {
                    //$this->ScoutReport->id = $is_added['ScoutReport']['id'] ;
                    $report['best_game'] = $is_added['ScoutReport']['best_game'] . "," . $report['best_game'] ;
                    $report['other_game'] = $is_added['ScoutReport']['other_game'] . "," . $report['other_game'] ;
                    $report['60_seconds_of_threes'] = $is_added['ScoutReport']['60_seconds_of_threes'] . "," . $report['60_seconds_of_threes'] ;
                    $report['ncca_elite_high_major_score'] = $is_added['ScoutReport']['ncca_elite_high_major_score'] . "," . $report['ncca_elite_high_major_score'] ;
                    $report['ncca_high_major_score'] = $is_added['ScoutReport']['ncca_high_major_score'] . "," . $report['ncca_high_major_score'] ;
                    $report['ncca_mid_major_score'] = $is_added['ScoutReport']['ncca_mid_major_score'] . "," . $report['ncca_mid_major_score'] ;
                    $report['ncca_low_major_score'] = $is_added['ScoutReport']['ncca_low_major_score'] . "," . $report['ncca_low_major_score'] ;
                    $report['ncca_division_II_score'] = $is_added['ScoutReport']['ncca_division_II_score'] . "," . $report['ncca_division_II_score'] ;
                    $report['ncca_division_III_score'] = $is_added['ScoutReport']['ncca_division_III_score'] . "," . $report['ncca_division_III_score'] ;
                    $report['junior_college_division_I_score'] = $is_added['ScoutReport']['junior_college_division_I_score'] . "," . $report['junior_college_division_I_score'] ;
                    $report['junior_college_division_II_score'] = $is_added['ScoutReport']['junior_college_division_II_score'] . "," . $report['junior_college_division_II_score'] ;
                    $report['naia_division_I_score'] = $is_added['ScoutReport']['naia_division_I_score'] . "," . $report['naia_division_I_score'] ;
                    $report['naia_division_II_score'] = $is_added['ScoutReport']['naia_division_II_score'] . "," . $report['naia_division_II_score'] ;
                    $report['naia_division_III_score'] = $is_added['ScoutReport']['naia_division_III_score'] . "," . $report['naia_division_III_score'] ;
                    $report['nccaa_score'] = $is_added['ScoutReport']['nccaa_score'] . "," . $report['nccaa_score'] ;
                    $report['club_level_score'] = $is_added['ScoutReport']['club_level_score'] . "," . $report['club_level_score'] ;
                    if($this->ScoutReport->save($report)){
                        $this->Session->setFlash('Scout Report Updated Successfully!', 'flash_success');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                    }else{
                         $this->Session->setFlash('Can not update this Scout Report', 'flash_error');
                    }
                }else{
                     $this->Session->setFlash('Can not update this Scout Report due to athlete info not found', 'flash_error');
                }

            } else {
                $ScoutReport = $this->ScoutReport->findById($id);
                $this->set('ScoutReport', $ScoutReport);
            }
        } else {
            $this->Session->setFlash('Do not exits this Scout report', 'flash_error');
        }
    }

    public function admin_addScoutreport() {
        if ($this->request->is('post') && isset($this->request->data['athlete']) && !empty($this->request->data['athlete'])) {

            if(isset($_FILES['picture']) && !empty($_FILES['picture'])) {
                if($_FILES['picture']['error'] == 0 && $_FILES['picture']['size'] > 0) {

                    $filename = '' ;
                    if (!empty($_FILES['picture']['tmp_name']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
                    // Strip path information
                        $filename = mt_rand() . "_" . $_FILES['picture']['name'] ;
                        move_uploaded_file( $_FILES['picture']['tmp_name'] , WWW_ROOT . DS . 'img/scoutreport' . DS . $filename);
                        $this->request->data['picture'] = $filename ;
                    }
                }else {
                    $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                }
            }
            $scout_data = $this->request->data ;
            $athlete = $scout_data['athlete'] ;
            $is_added = $this->ScoutReport->find("first",array("conditions"=>"athlete =  $athlete"));
            if(!$is_added) {
                if ($this->ScoutReport->save($this->request->data)) {
                    $this->Session->setFlash('Scout Report is Added Successfully', 'flash_success');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                } else {
                    $this->Session->setFlash('Can not add this Scout Report', 'flash_error');
                }

            }else {
                $this->Session->setFlash('Can not add this Scout Report , use edit report for already added athletes report', 'flash_error');
            }

        }
    }

    public function admin_scoutDetails($id) {
        if (isset($id)) {
            $ScoutReport = $this->ScoutReport->findById($id);
            $this->set('ScoutReport', $ScoutReport);
        } else {
            $this->Session->setFlash('Do not exits this Scout Report', 'flash_error');
        }
    }

    public function admin_search() {
        $schools = array() ;
        if ($this->request->is('post')) {
            $this->loadModel('HsAauTeam');
            if(isset($_POST['hsaauteam']) && !empty($_POST['hsaauteam'])) {
                $schools = $this->HsAauTeam->find("all",array("conditions"=>array('school_name LIKE '=> "%" . trim($_POST['hsaauteam']) . "%" ),"fields"=>"id,school_name","order"=>"school_name ASC"));
            }
        }
        $this->set('schools', $schools);
    }

    public function admin_atheletesearch() {
        $athelets = array();
        $limit = 5 ;
        $this->loadModel('Athlete');
        $hsaauteamid = $this->Session->read('ScoutReport.hsaauteamid');
        $athlete_condn = $this->Session->read('ScoutReport.athlete_condn');
        if ($this->request->is('post')) {
            if(isset($_POST) && !empty($_POST)) {
                $hsaauteamid = key($_POST) ;
                if($hsaauteamid > 0) {
                    $this->Session->write('ScoutReport.hsaauteamid', $hsaauteamid);
                    $athelets = $this->Athlete->find("all",array("conditions"=>"hs_aau_team_id = $hsaauteamid"));
                    if(count($athelets)<5){
                     $this->Session->write('ScoutReport.total_report_add', $limit);
                    }else{
                        $this->Session->write('ScoutReport.total_report_add', count($athelets));
                    }
                    
                    $this->paginate = array('Athlete' => array("conditions"=>"hs_aau_team_id = $hsaauteamid", 'limit' => $limit));
                    $athelets = $this->paginate('Athlete');
                }
            }
        }else if(!empty($athlete_condn)) {
                $this->paginate = array('Athlete' => array("conditions"=>$athlete_condn , 'limit' => $limit));
                $athelets = $this->paginate('Athlete');
            } else {
                if($hsaauteamid > 0 && $hsaauteamid != '') {
                    $this->paginate = array('Athlete' => array("conditions"=>array("hs_aau_team_id" => $hsaauteamid) , 'limit' => $limit));
                    $athelets = $this->paginate('Athlete');
                }
            }
        $Reports = $this->ScoutReport->find("list",array("fields"=>"id , athlete","order"=>" id desc"));
        $this->set(compact('athelets','limit'));
        $this->set('Reports', $Reports);
    }

    public function admin_addmultiplereport() {
        $athelte_conditions =array();
        $total_reports_add = $this->Session->read('ScoutReport.total_report_add');
        $hsaauteamid = $this->Session->read('ScoutReport.hsaauteamid');
        if ($this->request->is('post') && $total_reports_add > 0) {
            if(isset($this->request->data['report']) && !empty($this->request->data['report'])) {
                $now_reports_remain = $total_reports_add - count($this->request->data['report']) ;
                $this->Session->write('ScoutReport.total_report_add', $now_reports_remain);
                $athelte_conditions = array("hs_aau_team_id" => $hsaauteamid);

                foreach($this->request->data['report'] as $i=>$report) {
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
                    $athelete_id = 0 ;
                    if($report['athlete'] != ''){
                    $athelte_conditions['Athlete.id != '] = $report['athlete'] ;
                    $athelete_id = $report['athlete'] ;
                    }
                    
                    $is_added = $this->ScoutReport->find("first",array("conditions"=>"athlete = $athelete_id" ));
                    //echo '<pre>';print_r($is_added);exit;
                    if($is_added) {
                        $this->ScoutReport->id = $is_added['ScoutReport']['id'] ;
                        $report['best_game'] = $is_added['ScoutReport']['best_game'] . "," . $report['best_game'] ;
                        $report['other_game'] = $is_added['ScoutReport']['other_game'] . "," . $report['other_game'] ;
                        $report['60_seconds_of_threes'] = $is_added['ScoutReport']['60_seconds_of_threes'] . "," . $report['60_seconds_of_threes'] ;
                        $report['ncca_elite_high_major_score'] = $is_added['ScoutReport']['ncca_elite_high_major_score'] . "," . $report['ncca_elite_high_major_score'] ;
                        $report['ncca_high_major_score'] = $is_added['ScoutReport']['ncca_high_major_score'] . "," . $report['ncca_high_major_score'] ;
                        $report['ncca_mid_major_score'] = $is_added['ScoutReport']['ncca_mid_major_score'] . "," . $report['ncca_mid_major_score'] ;
                        $report['ncca_low_major_score'] = $is_added['ScoutReport']['ncca_low_major_score'] . "," . $report['ncca_low_major_score'] ;
                        $report['ncca_division_II_score'] = $is_added['ScoutReport']['ncca_division_II_score'] . "," . $report['ncca_division_II_score'] ;
                        $report['ncca_division_III_score'] = $is_added['ScoutReport']['ncca_division_III_score'] . "," . $report['ncca_division_III_score'] ;
                        $report['junior_college_division_I_score'] = $is_added['ScoutReport']['junior_college_division_I_score'] . "," . $report['junior_college_division_I_score'] ;
                        $report['junior_college_division_II_score'] = $is_added['ScoutReport']['junior_college_division_II_score'] . "," . $report['junior_college_division_II_score'] ;
                        $report['naia_division_I_score'] = $is_added['ScoutReport']['naia_division_I_score'] . "," . $report['naia_division_I_score'] ;
                        $report['naia_division_II_score'] = $is_added['ScoutReport']['naia_division_II_score'] . "," . $report['naia_division_II_score'] ;
                        $report['naia_division_III_score'] = $is_added['ScoutReport']['naia_division_III_score'] . "," . $report['naia_division_III_score'] ;
                        $report['nccaa_score'] = $is_added['ScoutReport']['nccaa_score'] . "," . $report['nccaa_score'] ;
                        $report['club_level_score'] = $is_added['ScoutReport']['club_level_score'] . "," . $report['club_level_score'] ;
                        $this->ScoutReport->save($report) ;
                    }else {
                        $this->ScoutReport->create();
                        $this->ScoutReport->save($report) ;
                    }
                }
                if($now_reports_remain > 0) {
                    if($hsaauteamid > 0 && $hsaauteamid != '' && $athelte_conditions) {
                        $this->Session->write('ScoutReport.athlete_condn', $athelte_conditions);
                        $this->Session->setFlash('Scout Reports are Added Successfully , and now add remain ones ', 'flash_success');
                        $this->redirect(array('controller' => 'ScoutReport', 'action' => 'atheletesearch'));
                    } else {
                        $this->Session->setFlash('Sorry Team Information lost , So you can`t allow to add more reports !', 'flash_error');
                        $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                    }
                }else {
                    $this->Session->delete('ScoutReport.hsaauteamid');
                    $this->Session->delete('ScoutReport.total_report_add');
                    $this->Session->delete('ScoutReport.athlete_condn');
                    $this->Session->setFlash('All Scout Reports are Added Successfully', 'flash_success');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                }
            }
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
                $html .= '<h5 style="text-align:center;">College Prospect Network’s</h5>';
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
                $html .= '<p>Note: Most PC users will need to hold ‘Ctrl’ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search “50 to Follow: (name of the game)”. For example, if the player you want to see played best on Court 3 – Game 1, you will go to YouTube and type “50 to Follow: Court 3 – Game 1”. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
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
                    $html .= '<h5 style="text-align:center;">College Prospect Network’s</h5>';
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
                    $html .= '<p>Note: Most PC users will need to hold ‘Ctrl’ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search “50 to Follow: (name of the game)”. For example, if the player you want to see played best on Court 3 – Game 1, you will go to YouTube and type “50 to Follow: Court 3 – Game 1”. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
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
                    $html .= '<h5 style="text-align:center;">College Prospect Network’s</h5>';
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
                    $html .= '<p>Note: Most PC users will need to hold ‘Ctrl’ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search “50 to Follow: (name of the game)”. For example, if the player you want to see played best on Court 3 – Game 1, you will go to YouTube and type “50 to Follow: Court 3 – Game 1”. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
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

        }else {
            $this->Session->setFlash('Please choose athlete first.', 'flash_error');
            $this->redirect(array('controller' => 'Athlete', 'action' => 'search'));
        }
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



}