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
}