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
}