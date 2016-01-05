<?php

class ScoutReport extends AppModel{

	public $name = 'ScoutReport';

	public $useTable = 'scout_report_athletes';

	public function getValues(){
		$rows = $this->find("list",array("fields"=>"id,firstname"));
		return $rows;
	}

        public function Savescoutreportteam($name=''){
            $db = ConnectionManager::getDataSource('default');
            $is_exist = $db->execute('Select id from scout_report_team where name = "'.$name.'" limit 1');
            $is_exist_arr = $is_exist->fetch(PDO::FETCH_ASSOC) ;
            if($is_exist_arr){
                return $is_exist_arr['id'] ;
            }else{
                $result = $db->execute('INSERT INTO scout_report_team (name, add_date, status) values ("'.$name.'", '.time().', 1) ');
                if($result){
                    $last_entry = $db->execute('Select id from scout_report_team order by id desc limit 1');
                    $last_entryarr = $last_entry->fetch(PDO::FETCH_ASSOC) ;
                    return $last_entryarr['id'] ;
                }
            }
            return false;
        }
}