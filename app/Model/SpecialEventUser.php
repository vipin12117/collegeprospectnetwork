<?php

class SpecialEventUser extends AppModel{

	public $name = 'SpecialEventUser';

	public $useTable = 'special_event_users';

	public function specialEventReport(){
		
		$sql = 	"SELECT *						 
				FROM 
					special_event_users sr,
					special_events se					 
				WHERE 
					sr.payment_status = '1' AND  
					sr.special_event_id !='' AND 
					se.status = '1' 
				ORDER BY sr.id";
		return $this->query($sql);
	}
}