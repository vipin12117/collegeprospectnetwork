<?php

class RegisterHelper extends AppHelper{

	public $name = "Register";

	public function getHeights(){
		$heights = array();

		for ($i = 5; $i < 7; $i++) {
			for ($j = 0; $j < 12; $j++) {
				$heights[$i . "-" . $j] = $i . "' " . $j;
			}
		}

		for ($kcount = 0; $kcount < 3; $kcount++) {
			$heights["7" . "-" . $kcount] = "7" . "' " . $kcount;
		}
		return $heights;
	}

	public function getWeights(){
		$weights = array("under140"=>"Under 140");

		for ($i = 127; $i < 245; $i++) {
			$i = $i + 14;
			$j = $i + 14;
			$weights[$i . "-" . $j] = $i . "-" . $j;
		}

		$weights["Over260"] = "Over 260";
		return $weights;
	}

	public function getIntendedMajor(){
		$options = array("Undecided / General Studies",
						 "Agriculture","Architecture",
						 "Arts",
						 "Business",
						 "Communications",
						 "Computers / Information Technology",
						 "Education",
						 "Engineering",
						 "Liberal Arts",
						 "Science",
						 "Other",
		);

		$options = array_combine($options,$options);
		return $options;
	}

	public function getClasses(){
		App::import("Model","Classes");
		$this->Classes = new Classes();

		$options = $this->Classes->find("list",array("fields"=>"name,name"));
		return $options;
	}

	public function getSports(){
		App::import("Model","Sport");
		$this->Sport = new Sport();

		$options = $this->Sport->find("list",array("fields"=>"id,name"));
		return $options;
	}

	public function getSchools(){
		App::import("Model","Sport");
		$this->Sport = new Sport();

		$options = $this->Sport->find("list",array("fields"=>"id,name"));
		return $options;
	}

	public function getHsAauSchools(){
		App::import("Model","HsAauTeam");
		$this->HsAauTeam = new HsAauTeam();

		$options = array();

		$states = $this->HsAauTeam->find("list",array("fields"=>"state,state","order"=>"state ASC","group"=>"state"));
		foreach($states as $state){
			$options[$state] = $this->HsAauTeam->find("list",array("conditions"=>"state='$state'","fields"=>"id,school_name","order"=>"school_name ASC"));
		}

		$options['Other'] = array("Other"=>"Add your school");
		return $options;
	}

	public function getColleges(){
		App::import("Model","College");
		$this->College = new College();

		$options = array();

		$states = $this->College->find("list",array("fields"=>"state,state","order"=>"state ASC","group"=>"state"));
		foreach($states as $state){
			$options[$state] = $this->College->find("list",array("conditions"=>"state='$state'","fields"=>"id,name","order"=>"name ASC"));
		}

		$options['Other'] = array("Other"=>"Add your college");
		return $options;
	}

	public function getStates(){
		App::import("Model","HsAauTeam");
		$this->HsAauTeam = new HsAauTeam();

		$states = $this->HsAauTeam->find("list",array("fields"=>"state,state","order"=>"state ASC","group"=>"state"));
		return $states;
	}

	public function getDivisions(){
		$options = array('Division I','Division II','Division III','NAIA','JUCO');
		$options = array_combine($options,$options);
		return $options;
	}

	public function getClassRank(){
		$options = array('Not in Top 50% of Class','Top 50% - Top 26%','Top 25% - Top 11%','Top 10% - Top 6%','Top 5% or better');
		$options = array_combine($options,$options);
		return $options;
	}

	public function getActScore(){
		$options = array('Under 10','10-15','16-20','21-25','26-30','Above 30');
		$options = array_combine($options,$options);
		return $options;
	}

	public function getSatScore(){
		$options = array();
		$options['400-600'] = '400-600';

		for ($i = 601, $j = 800; $j <= 2400; $i += 200, $j += 200) {
			$options[$i . '-' . $j] = $i . '-' . $j;
		}
		return $options;
	}

	public function getPoints(){
		$options = array();
		$options['under100'] = 'Under 100';

		for ($i = 1; $i < 10; $i++) {
			$k = $i;
			$k = $k * 100;
			$j = ($i+1) * 100;
			$options[$k . '-' . $j] = $k . '-' . $j;
		}

		$options['Over1000'] = 'Over 1000';
		return $options;
	}

	public function getRatings(){
		$options = array();
		for ($i = 1; $i < 10; $i++) {
			$k = $i;
			$k = $k ;
			$j = ($i+1);
			$options[$k . '-' . $j] = $k . '-' . $j;
		}
		return $options;
	}

	public function getGPA(){
		$options = array('Under 2.0','2.0-2.5','2.6-3.0','3.1-3.5','3.6-4.0','Above 4.0');
		$options = array_combine($options,$options);
		return $options;
	}

	public function getPositions($sport_id  = 10){
		if($sport_id == 10){
			App::import("Model","FootballPosition");
			$this->FootballPosition = new FootballPosition();

			$options = $this->FootballPosition->find("list",array("fields"=>"position,position","order"=>"position ASC","group"=>"position"));
			return $options;
		}
		else{
			App::import("Model","BasketballPosition");
			$this->BasketballPosition = new BasketballPosition();

			$options = $this->BasketballPosition->find("list",array("fields"=>"position,position","order"=>"position ASC","group"=>"position"));
			return $options;
		}
	}

	public function getDistanceList(){
		$distanceList = array();

		$distanceList['0']   = '0';
		$distanceList['10']  = '10';
		$distanceList['25']  = '25';
		$distanceList['50']  = '50';
		$distanceList['100'] = '100';

		return $distanceList;
	}

	public function getStatsCategories(){
		App::import("Model","AthleteStatCategory");
		$this->AthleteStatCategory = new AthleteStatCategory();

		$options = $this->AthleteStatCategory->find("list",array("fields"=>"id,name","order"=>"name ASC","group"=>"name"));
		return $options;
	}

	public function getSubscription(){
		App::import("Model","Subscription");
		$this->Subscription = new Subscription();

		$options = $this->Subscription->find("list",array("fields"=>"id,name","order"=>"name ASC","group"=>"name"));
		return $options;
	}

	public function getSubcribeMonths(){
		$months = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		
		$options = array();
		for ($month = 1; $month <= 12; $month++){
			$options[$month] = $months[$month];
		}

		return $options;
	}

	public function getSubcribeYears(){
		$options = array();
		for ($year = 2011; $year <= 2031; $year++){
			$options[$year] = $year;
		}

		return $options;
	}
}