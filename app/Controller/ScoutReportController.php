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
                require_once(APP . 'Vendor' . DS . 'tcpdf' . DS . 'tcpdf.php');

                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                //        $pdf->SetAuthor('Nicola Asuni');
                //        $pdf->SetTitle('TCPDF Example 006');
                //        $pdf->SetSubject('TCPDF Tutorial');
                //        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                // set default header data
                //        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray($l);
                }
                // set font
                $pdf->SetFont('helvetica', '', 10);


                $pdf->AddPage();

                $html = '<h5 style="text-align:center;">College Prospect Network’s</h5>';
                $html .= '<br><br>' ;
                $html .= '<h1 style="text-align:center;">50 to Follow Showcase</h1>';
                $html .= '<h2 style="text-align:center;">October 20, 2013</h2>';
                $html .= '<h3 style="text-align:center;">Houston, TX</h3>';
                $img = file_get_contents(WWW_ROOT . DS . 'img/logo.jpg');
                $html .= '<br><p>' ;
                $pdf->Image('@' . $img, '' , 50, 30, 30, '', '', '', false, 300, '', false, false, 0, false, false, false);
                $html .= '</p>' ;
                $html .= '<h5><strong>Full Scouting Report: Complete with Video Links, Contact Information and Stats</strong></h5>' ;
                $html .= '<p>You can see the highlight tape from the event here: http://www.youtube.com/watch?v=pgnexlqQNPU</p>' ;
                $html .= '<p>For more information about players or videos, please email our Vice President, Jacob Harris, at </p>' ;
                $html .= '<p>jharris@collegeprospectnetwork.com or call him at 832-439-4858.</p>' ;
                $html .= '<p>Note: Most PC users will need to hold ‘Ctrl’ on their keyboard while clicking the provided links in order for them to work. If you have printed this sheet and want to watch the videos, simply look at the name of the best game for the given player, then go to YouTube and search “50 to Follow: (name of the game)”. For example, if the player you want to see played best on Court 3 – Game 1, you will go to YouTube and type “50 to Follow: Court 3 – Game 1”. The jersey numbers are listed above the game links so it should be easy to identify the desired player. </p>' ;
                $html .= '<p>We hope you enjoy the report and we look forward to helping you in any way we can.</p>';
                // output the HTML content
                $pdf->writeHTML($html, true, false, true, false, '');

                // reset pointer to the last page
                $pdf->lastPage();

                if($atheletes) {
                    $pdf->AddPage();
                    foreach($atheletes as $i=>$athelete) {
                        if($athelete['ScoutReport']['picture']) {
                            $img1 = file_get_contents(WWW_ROOT .  '/img/scoutreport/'. $athelete['ScoutReport']['picture']);
                        }else {
                            $img1 = $img ;
                        }
                        $i = $i +1 ;
                        $athelete_html = '<table border="1">' ;
                        $athelete_html .= '<tr><th colspan="4">#'.$i.'</th></tr>';
                        $athelete_html .= '<tr>
                                   <td>';
                        $pdf->Image('@' . $img1, 20, '', 30, 30, '', '', '', false, 300, '', false, false, 1, false, false, false) ;
                        $athelete_html .=  '</td>
                                   <td>' . $athelete['ScoutReport']['description'] . '</td>
                                   <td><b>Strengths: </b>' . $athelete['ScoutReport']['strengths'] .'<br><b>Weakness : </b> ' . $athelete['ScoutReport']['weakness'] . '<br><b>HM :</b> <br><b>MM :</b> <br><b>LM :</b><br><b>Other :</b> </td>
                                   <td><b>Jersy Number :</b>'.$athelete['ScoutReport']['jersey_number'].' <br><b>Best Game:</b>'.$athelete['ScoutReport']['best_game'].' <br><b>Other Game:</b>'.$athelete['ScoutReport']['other_game'].' <br><b>Academics: </b> <br><b>GPA:</b> '.$athelete['ScoutReport']['gpa'].'<b>Sat :</b>'.$athelete['ScoutReport']['sat_score'] .'<b>Act : </b>'.$athelete['ScoutReport']['act_score']
                            .'<br><b>Coach Info : </b> ' . $athelete['ScoutReport']['high_school'] . ' : ' . $athelete['ScoutReport']['high_school_coach_name'] . ' , ' . $athelete['ScoutReport']['high_school_coach_phone']  .' <br> ' . $athelete['ScoutReport']['primary_aau_team'] . ' : ' . $athelete['ScoutReport']['primary_aau_coach_name'] . ' , ' . $athelete['ScoutReport']['primary_aau_coach_phone']  .' </td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td><b>' .$athelete['ScoutReport']['firstname'] . " " . $athelete['ScoutReport']['lastname'] . '</b></td>
                                   <td>Ht: ' .$athelete['ScoutReport']['height'] . ' &nbsp; Wt : ' . $athelete['ScoutReport']['weight'] .'</td>
                                   <td> ? Feet road</td>
                                   <td><b>Twitter :</b>'.$athelete['ScoutReport']['twitter'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>Class: ' .$athelete['ScoutReport']['class'] . ' &nbsp; Pos : ' . $athelete['ScoutReport']['primary_position'] .' , ' . $athelete['ScoutReport']['secondary_position'] .'</td>
                                   <td>Reach : ' .$athelete['ScoutReport']['reach'] . ' &nbsp; Wingspan : ' . $athelete['ScoutReport']['wingspan_id'] .'</td>
                                   <td>Coming soon</td>
                                   <td><b>Facebook :</b>'.$athelete['ScoutReport']['facebook'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td>'.$athelete['ScoutReport']['high_school'].' / '.$athelete['ScoutReport']['primary_aau_team'] . '</td>
                                   <td>Agility : ' .$athelete['ScoutReport']['lane_agility'] . ' &nbsp; 0:60 3s : ' . $athelete['ScoutReport']['60_seconds_of_threes'] .'</td>
                                   <td>'.$athelete['ScoutReport']['phone_number'].'</td>
                                   <td><b>Email :</b>'.$athelete['ScoutReport']['email'].'</td>
                                   </tr>' ;
                        $athelete_html .= '<tr>
                                   <td colspan="2">Interest:' . $athelete['ScoutReport']['colleges_shown_interest'] .' </td>
                                   <td colspan="2">Offers:' . $athelete['ScoutReport']['colleges_offered_scholarship'] .'</td>
                                   </tr>' ;
                        $athelete_html .= '</table>' ;
                        $pdf->writeHTML($athelete_html, true, false, true, false, '');
                    }
                }

                // reset pointer to the last page
                $pdf->lastPage();

                //Close and output PDF document
                $pdf->Output('scoureport.pdf', 'I');
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