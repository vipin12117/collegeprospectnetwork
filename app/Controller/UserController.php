<?php

App::uses('CakeEmail', 'Network/Email');

class UserController extends AppController {

    public $name = "User";

    public $components = array('Email','RequestHandler','Captcha');

    public $helpers = array('Html','Form','Js' => array('Jquery'));

    public $uses = array("Athlete","HsAauTeam","HsAauCoach","CollegeCoach","HsAauCoachSportposition");

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $this->set("title_for_layout","College Prospect Network - Home | CPN");
    }

    public function register() {
        $this->set("title_for_layout","User Registration");

        if(isset($this->request->data['Athlete'])) {
            $user_type = $this->request->data['Athlete']['user_type'];
            $action = "register$user_type";

            $this->redirect(array("controller"=>"User","action"=>$action));
            exit;
        }
    }

    public function getAddressInfo($state_id = false) {
        $this->autoLayout = false;
        $this->autoRender = false;

        $hs_aau_team_id = @$this->request->query['data']['Athlete']['hs_aau_team_id'];
        if(!$hs_aau_team_id) {
            $hs_aau_team_id = @$this->request->query['data']['HsAauCoach']['hs_aau_team_id'];
        }

        if($hs_aau_team_id != 'Other') {
            $hs_aau_team_id = (int)$hs_aau_team_id;
        }

        if(!$hs_aau_team_id) {
            return false;
        }

        if(!$this->RequestHandler->isAjax()) {
            $this->redirect(array("controller"=>"Home","action"=>"index"));
            exit;
        }

        $this->set("state_id",$state_id);
        $this->set("hs_aau_team_id",$hs_aau_team_id);

        if($hs_aau_team_id != 'Other') {
            $this->loadModel('HsAauTeam');

            $hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.id = '$hs_aau_team_id'"));
            $this->set("hsAauTeamDetail",$hsAauTeamDetail);
        }

        $this->render("/User/getAddressInfo","ajax");
    }

    public function getCollegeInfo($state_id=false) {
        $this->autoLayout = false;
        $this->autoRender = false;

        $college_id = @$this->request->query['data']['CollegeCoach']['college_id'];
        if($college_id != 'Other') {
            $college_id = (int)$college_id;
        }

        if(!$college_id) {
            return false;
        }

        if(!$this->RequestHandler->isAjax()) {
            $this->redirect(array("controller"=>"Home","action"=>"index"));
            exit;
        }

        if($college_id != 'Other') {
            $this->loadModel('College');
            $CollegeDetail = $this->College->find("first",array("conditions"=>"College.id = '$college_id'"));
        }
        else {
            $CollegeDetail['College']['state'] = $state_id;
        }

        $this->set("college_id",$college_id);

        $this->set("CollegeDetail",$CollegeDetail);
        $this->render("/User/getCollegeInfo","ajax");
    }

    public function getHsAauSchools() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $state_id = @$this->request->query['data']['Athlete']['state_id'];
        if(!$state_id) {
            $state_id = @$this->request->query['data']['HsAauCoach']['state_id'];
        }

        if(!$state_id) {
            return false;
        }

        if(!$this->RequestHandler->isAjax()) {
            $this->redirect(array("controller"=>"Home","action"=>"index"));
            exit;
        }

        $this->loadModel('HsAauTeam');
        $this->set("state_id",$state_id);

        $colleges = $this->HsAauTeam->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,school_name","order"=>"school_name ASC"));
        $colleges['Other'] = array("Other"=>"Add your school");
        $this->set("colleges",$colleges);

        $this->render("/User/getSchools","ajax");
    }

    public function getColleges() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $state_id = @$this->request->query['data']['CollegeCoach']['state_id'];
        if(!$state_id) {
            return false;
        }

        if(!$this->RequestHandler->isAjax()) {
            $this->redirect(array("controller"=>"Home","action"=>"index"));
            exit;
        }

        $this->set("state_id",$state_id);
        $this->loadModel('College');

        $colleges = $this->College->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,name","order"=>"name ASC"));
        $colleges['Other'] = array("Other"=>"Add your college");
        $this->set("colleges",$colleges);

        $this->render("/User/getColleges","ajax");
    }

    public function registerAthlete() {
        $this->set("title_for_layout","Athlete Registration");

        if(isset($this->request->data['Athlete'])) {
            if($this->request->data['Athlete']['code'] == $this->Session->read('Captcha.code')) {
                $username = strtolower($this->request->data['Athlete']['username']);
                $email = strtolower($this->request->data['Athlete']['email']);

                $checkUsernameExist = $this->Athlete->find("first",array("conditions"=>"Lower(Athlete.username) = Lower('$username')"));
                $checkEmailExist = $this->Athlete->find("first",array("conditions"=>"Lower(Athlete.email) = Lower('$email')"));

                if($checkUsernameExist) {
                    $this->Session->setFlash("This username is already exist, please try another one");
                }
                elseif($checkEmailExist) {
                    $this->Session->setFlash("This email is already assigned to another user");
                }
                else {
                    $newSchool = false;

                    $this->loadModel('HsAauTeam');
                    $school = $this->request->data['Athlete']['team'] ;
                    $hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.school_name = '$school'"));
                    if($hsAauTeamDetail) {
                        $hs_aau_team_id = $hsAauTeamDetail['HsAauTeam']['id'];
                        $this->request->data['Athlete']['hs_aau_team_id'] = $hs_aau_team_id ;
                        $this->athleteCoachApproval($hs_aau_team_id, $this->request->data['Athlete']['firstname'],$this->request->data['Athlete']['lastname']);
                    }else{
                        $this->request->data['HsAauTeam']['athlete_username'] = $username;
                        $this->request->data['HsAauTeam']['sport_id'] = $this->request->data['Athlete']['sport_id'];
                        $this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
                        $this->request->data['HsAauTeam']['status'] = 0;
                        $this->HsAauTeam->save($this->request->data);
                        $hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
                        $this->request->data['Athlete']['hs_aau_team_id'] = $hs_aau_team_id;
                        $newSchool = 1;
                    }

                    /*
                     if($this->request->data['Athlete']['hs_aau_team_id'] == 'Other') {
                        $this->request->data['HsAauTeam']['athlete_username'] = $username;
                        $this->request->data['HsAauTeam']['sport_id'] = $this->request->data['Athlete']['sport_id'];
                        $this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
                        $this->request->data['HsAauTeam']['status'] = 0;

                        $this->HsAauTeam->save($this->request->data);
                        $hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
                        $this->request->data['Athlete']['hs_aau_team_id'] = $hs_aau_team_id;
                        $newSchool = 1;
                    }
                    else {
                        $hs_aau_team_id = $this->request->data['Athlete']['hs_aau_team_id'];
                        $this->athleteCoachApproval($hs_aau_team_id, $this->request->data['Athlete']['firstname'],$this->request->data['Athlete']['lastname']);
                    }
                    */

                    $this->Athlete->save($this->request->data);
                    $message = "Thank you for submitting your application. Your profile will be reviewed by the College Prospect Network staff and you will be notified via email whether you are approved. Please allow 10 business days for us to process your request before contacting us.<br /><br />
								Please print this page and take it to your coach. We will need him/her to answer two quick questions as part of your application process.			
								<br /><br />From, <br />College Prospect Network.";
                    $message .= '<h2>Download Flyers</h2>
								<a href="'.Router::url("/files/Flyer for Coaches to Give to Players.pdf",true).'">Flyer for Coaches to Give to Players</a>
								<br /><br />
								<a href="'.Router::url("/files/Flyer for Players to Give to Coaches.pdf",true).'">Flyer for Players to Give to Coaches</a>
								<br /><br /><br />';

                    $this->Session->setFlash($message);

                    $this->athleteRegisterEmail($this->request->data['Athlete'],$this->request->data['HsAauTeam'],$newSchool);
                    $this->redirect(array("controller"=>"Home","action"=>"login"));
                    exit;
                }
            }
            else {
                $this->Session->setFlash("Please enter the correct code.");

                unset($this->request->data['Athlete']['state_id']);
            }
        }

        $this->Captcha->create(
            array(
            'images_url'=>'/img/captcha/',
            'images_path'=>WWW_ROOT.DS.'img/captcha/',
            'assets_path'=>WWW_ROOT.DS.'img/'));
        $this->Session->write('Captcha.code',$this->Captcha->code());
        $this->set('captcha_url',$this->Captcha->store());

        $this->render("/User/registerAthlete");
    }

    public function registerHSCoach() {
        $this->set("title_for_layout","High School / AAU Coach Registration");

        if(isset($this->request->data['HsAauCoach'])) {
            if($this->request->data['HsAauCoach']['code'] == $this->Session->read('Captcha.code')) {
                $username = strtolower($this->request->data['HsAauCoach']['username']);
                $email = strtolower($this->request->data['HsAauCoach']['email']);

                $checkUsernameExist = $this->HsAauCoach->find("first",array("conditions"=>"Lower(HsAauCoach.username) = Lower('$username')"));
                $checkEmailExist = $this->HsAauCoach->find("first",array("conditions"=>"Lower(HsAauCoach.email) = Lower('$email')"));

                if($checkUsernameExist) {
                    $this->Session->setFlash("This username is already exist, please try another one.");
                }
                elseif($checkEmailExist) {
                    $this->Session->setFlash("This email is already assigned to another user.");
                }
                else {
                    $newSchool = false;

                    $this->loadModel('HsAauTeam');
                    $school = $this->request->data['HsAauCoach']['team'] ;
                    $hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.school_name = '$school'"));
                    if($hsAauTeamDetail) {
                        $hs_aau_team_id = $hsAauTeamDetail['HsAauTeam']['id'];
                        $this->request->data['HsAauCoach']['hs_aau_team_id'] = $hs_aau_team_id ;
                    }else{
                        $this->request->data['HsAauTeam']['coach_name'] = $username;
                        $this->request->data['HsAauTeam']['sport_id'] = $this->request->data['Athlete']['sport_id'];
                        $this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
                        $this->request->data['HsAauTeam']['status'] = 0;
                        $this->HsAauTeam->save($this->request->data);
                        $hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
                        $this->request->data['HsAauCoach']['hs_aau_team_id'] = $hs_aau_team_id;
                        $newSchool = 1;
                    }
                    /*
                    if($this->request->data['Athlete']['hs_aau_team_id'] == 'Other') {
                        $this->request->data['HsAauTeam']['coach_name'] = $username;
                        $this->request->data['HsAauTeam']['sport_id'] = $this->request->data['HsAauCoach']['sport_id'][0];
                        $this->request->data['HsAauTeam']['added_date'] = date('Y-m-d H:i:s');
                        $this->request->data['HsAauTeam']['status'] = 0;

                        $this->HsAauTeam->save($this->request->data);
                        $hs_aau_team_id = $this->HsAauTeam->getLastInsertID();
                        $this->request->data['HsAauCoach']['hs_aau_team_id'] = $hs_aau_team_id;
                        $newSchool = 1;
                    }
                    else {
                        $hs_aau_team_id = $this->request->data['Athlete']['hs_aau_team_id'];
                        $this->request->data['HsAauCoach']['hs_aau_team_id'] = $hs_aau_team_id;
                    }
                    */

                    $sports = $this->request->data['HsAauCoach']['sport_id'];
                    $positions = $this->request->data['HsAauCoach']['position'];

                    $this->request->data['HsAauCoach']['sport_id'] = $this->request->data['HsAauCoach']['sport_id'][0];
                    $this->request->data['HsAauCoach']['position'] = $this->request->data['HsAauCoach']['position'][0];

                    $this->request->data['HsAauCoach']['status'] = 1;
                    $this->HsAauCoach->save($this->request->data);
                    $hs_aau_coach_id = $this->HsAauCoach->getLastInsertID();

                    $this->loadModel('Sport');
                    $sportsList = $this->Sport->getSportList();

                    $sportPositions = array();
                    //insert all sports
                    foreach($sports as $i => $value) {
                        $sportPosition = array();
                        $sportPosition['sport_id'] = $value;
                        $sportPosition['position'] = $positions[$i];
                        $sportPosition['hs_aau_coach_id'] = $hs_aau_coach_id;

                        try {
                            $this->HsAauCoachSportposition->create();
                            $this->HsAauCoachSportposition->save(array("HsAauCoachSportposition"=>$sportPosition));
                        }
                        catch(Exception $e ) {

                        }

                        $sportPosition['sport_name'] = $sportsList[$value];
                        $sportPositions[] = $sportPosition;
                    }

                    $this->hSCoachAdminNotifiction($this->request->data['HsAauCoach'],$this->request->data['HsAauTeam'],$sportPositions,$newSchool);

                    $message = "Thank you for your Registration.";
                    $this->Session->setFlash($message);

                    $this->Session->write("name",$this->request->data['HsAauCoach']['firstname']);
                    $this->Session->write("username",$this->request->data['HsAauCoach']['username']);
                    $this->Session->write("user_id",$hs_aau_coach_id);
                    $this->Session->write("user_type","coach");

                    $this->redirect(array("controller"=>"Profile","action"=>"index"));
                    exit;
                }
            }
            else {
                $this->Session->setFlash("Please enter the correct code.");
                unset($this->request->data['HsAauCoach']['state_id']);
            }
        }

        $this->Captcha->create(
            array(
            'images_url'=>'/img/captcha/',
            'images_path'=>WWW_ROOT.DS.'img/captcha/',
            'assets_path'=>WWW_ROOT.DS.'img/'));
        $this->Session->write('Captcha.code',$this->Captcha->code());
        $this->set('captcha_url',$this->Captcha->store());

        $this->render("/User/registerHSCoach");
    }

    public function registerCollegeCoach() {
        $this->set("title_for_layout","College Coach Registration");

        $this->loadModel('College');

        if(isset($this->request->data['CollegeCoach'])) {
            if($this->request->data['CollegeCoach']['code'] == $this->Session->read('Captcha.code')) {
                $username = strtolower($this->request->data['CollegeCoach']['username']);
                $email = strtolower($this->request->data['CollegeCoach']['email']);

                $checkUsernameExist = $this->CollegeCoach->find("first",array("conditions"=>"Lower(CollegeCoach.username) = Lower('$username')"));
                $checkEmailExist = $this->CollegeCoach->find("first",array("conditions"=>"Lower(CollegeCoach.email) = Lower('$email')"));

                if($checkUsernameExist) {
                    $this->Session->setFlash("This username is already exist, please try another one.");
                }
                elseif($checkEmailExist) {
                    $this->Session->setFlash("This email is already assigned to another user.");
                }
                else {
                    $newCollege = false;
                    $this->loadModel('College');
                    $college = $this->request->data['CollegeCoach']['college'] ;
                    $collegeDetail = $this->College->find("first",array("conditions"=>"College.name = '$college'"));
                    if($collegeDetail) {
                        $this->request->data['CollegeCoach']['college_id'] = $collegeDetail['College']['id'] ;
                        $college_id = $collegeDetail['College']['id'] ;
                    }else{
                        $this->request->data['College']['username']  = $username;
                        $this->request->data['College']['join_date'] = date('Y-m-d H:i:s');
                        $this->request->data['College']['status'] = 0;

                        $this->College->save($this->request->data);
                        $college_id = $this->College->getLastInsertID();
                        $this->request->data['CollegeCoach']['college_id'] = $college_id;
                        $newCollege = 1;
                    }
                    /*
                    if($this->request->data['CollegeCoach']['college_id'] == 'Other') {
                        $this->request->data['College']['username']  = $username;
                        $this->request->data['College']['join_date'] = date('Y-m-d H:i:s');
                        $this->request->data['College']['status'] = 0;

                        $this->College->save($this->request->data);
                        $college_id = $this->College->getLastInsertID();
                        $this->request->data['CollegeCoach']['college_id'] = $college_id;
                        $newCollege = 1;
                    }
                    else {
                        $college_id = $this->request->data['CollegeCoach']['college_id'];
                    }
                    */
                    
                    $this->CollegeCoach->save($this->request->data);
                    $message = "Thank you for your registration.";
                    $this->Session->setFlash($message);

                    $this->collegeCoachAdminNotifiction($this->request->data['CollegeCoach'],$this->request->data['College'],$newCollege);
                    $this->redirect(array("controller"=>"Home","action"=>"login"));
                    exit;
                }
            }
            else {
                $this->Session->setFlash("Please enter the correct code.");

                $state_id = $this->request->data['CollegeCoach']['state_id'];
                $colleges = $this->College->find("list",array("conditions"=>"state='$state_id'","fields"=>"id,name","order"=>"name ASC"));
                $colleges['Other'] = array("Other"=>"Add your college");
                $this->set("colleges",$colleges);

                $college_id = $this->request->data['CollegeCoach']['college_id'];
                $this->set("college_id",$college_id);
                $this->set("state_id",$state_id);
            }
        }

        unset($this->request->data['CollegeCoach']['state_id']);

        $this->Captcha->create(
            array(
            'images_url'=>'/img/captcha/',
            'images_path'=>WWW_ROOT.DS.'img/captcha/',
            'assets_path'=>WWW_ROOT.DS.'img/'));
        $this->Session->write('Captcha.code',$this->Captcha->code());
        $this->set('captcha_url',$this->Captcha->store());

        $this->render("/User/registerCollegeCoach");
    }

    /**
     * Send register email to athelete.
     * @param array $data
     * @param array $address
     * @param boolean $newSchool
     */
    private function athleteRegisterEmail($data,$address,$newSchool) {
        $subject = "College Prospect Network - Athlete Welcome";
        if($newSchool) {
            $subjectStre = "[CPN] - New Athlete ". $data['firstname']." ".$data['lastname']. " Registration + New School";
        }
        else {
            $subjectStre = "[CPN] - New Athlete ". $data['firstname']." ".$data['lastname']. " Registration";
        }

        // HS/AAU Name
        $this->loadModel('HsAauTeam');
        $hsAauTeam = $this->HsAauTeam->find('first',array('conditions'=>array('HsAauTeam.id' => $data['hs_aau_team_id']),
            array('fields'=>'HsAauTeam.school_name')));
        $highSchoolName = $hsAauTeam['HsAauTeam']['school_name'];

        // Get Sport Name
        $this->loadModel('Sport');
        $sport = $this->Sport->find('first',array('conditions'=>array('Sport.id' => $data['sport_id']),array('fields'=>'Sport.name')));
        $sportName = $sport['Sport']['name'];
        $httpUserAgent = $_SERVER['HTTP_USER_AGENT'];

        $template = 'athlete_registerer_mail';
        $cakeEmail = new CakeEmail();
        try {
            $cakeEmail->template($template);
            $cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
            $cakeEmail->to(array($data['email'] => $data['firstname']));
            $cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
            $cakeEmail->subject($subject);
            $cakeEmail->emailFormat('html');
            $cakeEmail->viewVars(array('newSchool' => $newSchool, 'data' => $data, 'address' => $address,
                'sportName' => $sportName, 'httpUserAgent' => $httpUserAgent,'highSchoolName' =>$highSchoolName));
            // Send email
            $cakeEmail->send();
        }
        catch (Exception $e) {
        //$this->Session->setFlash('Error while sending email');
        }
    }

    private function athleteCoachApproval($hs_aau_team_id , $first_name , $last_name) {
        $this->loadModel('HsAauCoach');
        $hsAauCoaches = $this->HsAauCoach->find('all',array('conditions'=>array('HsAauCoach.hs_aau_team_id' => $hs_aau_team_id)));
        if(!$hsAauCoaches) {
            return false;
        }

        $cakeEmail = new CakeEmail();
        $subject = "College Prospect Network - Athlete $first_name $last_name Pending Approval";
        $template = 'athlete_coach_approval';
        foreach($hsAauCoaches as $hsAauCoach) {
            try {
                $cakeEmail->template($template);
                $cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
                $cakeEmail->to(array($hsAauCoach['HsAauCoach']['email'] => $hsAauCoach['HsAauCoach']['firstname']));
                $cakeEmail->subject($subject);
                $cakeEmail->emailFormat('html');
                $cakeEmail->viewVars(array('hsAauCoach' => $hsAauCoach, 'first_name' => $first_name, 'last_name' => $last_name));
                // Send email
                $cakeEmail->send();
            }
            catch (Exception $e) {
            //$this->Session->setFlash('Error while sending email');
            }
        }
    }

    private function hSCoachAdminNotifiction($data , $address , $sportPositions, $newSchool) {
        if($newSchool) {
            $subject = "[CPN] - New HS Coach Registration + New School";
        }
        else {
            $subject = "[CPN] - New HS Coach Registration";
        }

        //HS/AAU Name
        $this->loadModel('HsAauTeam');
        $hsAauTeam = $this->HsAauTeam->find('first',array('conditions'=>array('HsAauTeam.id' => $data['hs_aau_team_id']),'fields' => array('HsAauTeam.school_name')));
        $highSchoolName = $hsAauTeam['HsAauTeam']['school_name'];

        $httpUserAgent = $_SERVER['HTTP_USER_AGENT'];

        $template = 'hs_coach_admin_notifiction';
        $cakeEmail = new CakeEmail();
        try {
            $cakeEmail->template($template);
            $cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
            $cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
            $cakeEmail->subject($subject);
            $cakeEmail->emailFormat('html');
            $cakeEmail->viewVars(array('newSchool' => $newSchool, 'data' => $data, 'address' => $address, 'sportPositions' => $sportPositions,
                'httpUserAgent' => $httpUserAgent , 'highSchoolName' =>$highSchoolName));
            // Send email
            $cakeEmail->send();
        }
        catch (Exception $e) {
        //$this->Session->setFlash('Error while sending email');
        }
    }

    private function collegeCoachAdminNotifiction($data , $address , $newCollege) {
        if ($newCollege) {
            $subject = "[CPN] - New College Coach Registration + New College";
        }
        else {
            $subject = "[CPN] - New College Coach Registration";
        }

        // Get College Name
        $this->loadModel('College');
        $college = $this->College->find("first",array("conditions"=>"College.id = '".$data['college_id']."'","fields"=>"College.name"));
        $collegeName = $college['College']['name'];

        // Get Sport Name
        $this->loadModel('Sport');
        $sport = $this->Sport->find("first",array("conditions"=>"Sport.id = '".$data['sport_id']."'","fields"=>"Sport.name"));
        $sportName = $sport['Sport']['name'];

        $httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
        $template = 'college_coach_admin_notifiction';
        $cakeEmail = new CakeEmail();
        try {
            $cakeEmail->template($template);
            $cakeEmail->from(array('no-reply@collegeprospectnetwork.com' => 'College Prospect Network'));
            $cakeEmail->to(array("admin@collegeprospectnetwork.com" => "Admin"));
            $cakeEmail->subject($subject);
            $cakeEmail->emailFormat('html');
            $cakeEmail->viewVars(array('newCollege' => $newCollege, 'data' => $data, 'address' => $address, 'collegeName' => $collegeName, 'sportName' => $sportName, 'httpUserAgent' => $httpUserAgent));
            // Send email
            $cakeEmail->send();
        }
        catch (Exception $e) {
        //$this->Session->setFlash('Error while sending email');
        }
    }

    public function checkUsername($username,$type='Athlete') {
        $this->layout = false;
        $this->autoRender = false;

        $isExist = false;

        if($type == 'Athlete') {
            $this->loadModel('Athlete');
            $isExist = $this->Athlete->getByUsername($username);
        }
        elseif($type == 'CollegeCoach') {
            $this->loadModel('CollegeCoach');
            $isExist = $this->CollegeCoach->getByUsername($username);
        }
        elseif($type == 'HsAauCoach') {
            $this->loadModel('HsAauCoach');
            $isExist = $this->HsAauCoach->getByUsername($username);
        }

        if($isExist) {
            echo "Yes";
        }
        else {
            echo "No";
        }
    }

    public function autoCompleteHS() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $response = array() ;
        $colleges = array() ;
        $this->loadModel('HsAauTeam');
        if(isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $term = $_GET['q'] ;
            $state_id = $_GET['state_id'] ;
            $colleges = $this->HsAauTeam->find("list",array("conditions"=>array('state'=>$state_id ,'school_name LIKE '=> "%$term%" ),"fields"=>"id,school_name","order"=>"school_name ASC"));
        }else {
            $term = $_GET['q'] ;
            $colleges = $this->HsAauTeam->find("list",array("conditions"=>array('school_name LIKE '=> "%$term%"),"fields"=>"id,school_name","order"=>"school_name ASC"));
        }
        echo json_encode($colleges); die;
    }

    public function getAddressInfoHs() {
        $this->autoLayout = false;
        $this->autoRender = false;
        if(isset($_GET['schoolname']) && !empty($_GET['schoolname']) && isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $this->loadModel('HsAauTeam');
            $school = $_GET['schoolname'] ;
            $hsAauTeamDetail = $this->HsAauTeam->find("first",array("conditions"=>"HsAauTeam.school_name = '$school'"));
            $this->set("state_id",$_GET['state_id']);
            if($hsAauTeamDetail) {
                $this->set("hs_aau_team_id",$hsAauTeamDetail['HsAauTeam']['id']);
                $this->set("hsAauTeamDetail",$hsAauTeamDetail);
            }
            $this->render("/User/getAddressInfo","ajax");
        }

    }

    public function autoCompleteCollege() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $response = array() ;
        $colleges = array() ;
        $this->loadModel('College');
        if(isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $term = $_GET['q'] ;
            $state_id = $_GET['state_id'] ;
            $colleges = $this->College->find("list",array("conditions"=>array("state='$state_id'",'name LIKE '=> "%$term%"),"fields"=>"id,name","order"=>"name ASC"));
        }else {
            $term = $_GET['q'] ;
            $colleges = $this->College->find("list",array("conditions"=>array('name LIKE '=> "%$term%"),"fields"=>"id,name","order"=>"name ASC"));
        }
        echo json_encode($colleges); die;
    }

    function getCollegeInfoHtml(){

        $this->autoLayout = false;
        $this->autoRender = false;
        if(isset($_GET['collegename']) && !empty($_GET['collegename']) && isset($_GET['state_id']) && !empty($_GET['state_id'])) {
            $this->loadModel('College');
            $college = $_GET['collegename'] ;
            $CollegeDetail = $this->College->find("first",array("conditions"=>array("College.name" => "$college" , "College.state" => $_GET['state_id'] )));
            $this->set("state_id",$_GET['state_id']);
            if($CollegeDetail) {
                $this->set("college_id",$CollegeDetail['College']['id']);
                $this->set("CollegeDetail",$CollegeDetail);
            }
            $this->render("/User/getCollegeInfo","ajax");
        }
    }
}