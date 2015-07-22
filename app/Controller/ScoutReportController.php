<?php

class ScoutReportController extends AppController {

    public $name = 'ScoutReport';

    public $components = array('Email','RequestHandler');

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
                    }else {
                        $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                    }
                }
                $this->ScoutReport->id = $id;
                if ($this->ScoutReport->save($this->request->data)) {
                    $this->Session->setFlash('Scout Report Updated Successfully!', 'flash_success');
                    $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
                } else {
                    $this->Session->setFlash('Can not update this Scout Report', 'flash_error');
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
                }else {
                    $this->Session->setFlash('Picture Not Uploaded due to some error', 'flash_error');
                }
            }

            if ($this->ScoutReport->save($this->request->data)) {
                $this->Session->setFlash('Scout Report is Added Successfully', 'flash_success');
                $this->redirect(array('controller' => 'ScoutReport', 'action' => 'scoutreportList'));
            } else {
                $this->Session->setFlash('Can not add this Scout Report', 'flash_error');
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
    //echo'<pre>';print_r($html);exit;
    // echo json_encode($colleges); die;
    }

    public function view() {
        require_once(APP . 'Vendor' . DS . 'mpdf' . DS . 'mpdf.php');

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

}