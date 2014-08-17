<?php

require_once 'inc/common_functions.php';
require_once 'inc/db.inc.php';
require_once 'zipcode.class.php';

class AthleteSearchHelper
{
    public static function get40YardDashCond($time)
    {
        if (empty($time)) {
            return '';
        }
        
        return " AND `fld40_yardDash`!='' AND `fld40_yardDash`<=" . 
               mysql_real_escape_string($time);
    }
    
    public static function getACTCond($act)
    {
        if (empty($act)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch ($act) {
            case '10-15':
                $cond .= "`fldACTScore`='10-15' OR ";
            case '16-20':
                $cond .= "`fldACTScore`='16-20' OR ";
            case '21-25':
                $cond .= "`fldACTScore`='21-25' OR ";
            case '26-30':
                $cond .= "`fldACTScore`='26-30' OR ";
            case 'Above30':
                $cond .= "`fldACTScore`='Above30'";
        }
        
        return $cond . ')';
    }
    
    public static function getACTScoreList()
    {
        $actList = array();
        
        $actList['10-15']   = '10 - 15';
        $actList['16-20']   = '16 - 20';
        $actList['21-25']   = '21 - 25';
        $actList['26-30']   = '26 - 30';
        $actList['Above30'] = 'Above 30';
        
        return $actList;
    }
    
    public static function getBenchPressCond($weight)
    {
        if (empty($weight)) {
            return '';
        }
        
        return " AND `fldBenchPressMax`!='' AND `fldBenchPressMax`>=" .
               mysql_real_escape_string($weight);
    }
    
    public static function getClassCond($class)
    {
        if (empty($class)) {
            return '';
        }
        
        return " AND `fldClass`='" . mysql_real_escape_string($class) . "'";
    }
    
    public static function getClassList()
    {
        $func = new COMMONFUNC;
        $classList = array();
        
        $classes = $func->selectTableOrder(TBL_CLASS, 'fldClass', 'fldClass');
        
        foreach ($classes as $class) {
            $classList[$class['fldClass']] = $class['fldClass'];
        }

        return $classList;
    }
    
    public static function getClassRankCond($rank)
    {
        if (empty($rank)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch ($rank) {
            case 'Not in Top 50% of Class':
                $cond .= "`fldClassRank`='Not in Top 50% of Class' OR ";
            case 'Top 50% - Top 26%':
                $cond .= "`fldClassRank`='Top 50% - Top 26%' OR ";
            case 'Top 25% - Top 11%':
                $cond .= "`fldClassRank`='Top 25% - Top 11%' OR ";
            case 'Top 10% - Top 6%':
                $cond .= "`fldClassRank`='Top 10% - Top 6%' OR ";
            case 'Top 5% or better':
                $cond .= "`fldClassRank`='Top 5% or better'";
        }
        
        return $cond . ')';
    }
    
    public static function getClassRankList()
    {
        $classRankList = array();
        
        $classRankList['Not in Top 50% of Class'] = 'Not in Top 50% of Class';
        $classRankList['Top 50% - Top 26%']       = 'Top 50% - Top 26%';
        $classRankList['Top 25% - Top 11%']       = 'Top 25% - Top 11%';
        $classRankList['Top 10% - Top 6%']        = 'Top 10% - Top 6%';
        $classRankList['Top 5% or better']        = 'Top 5% or better';

        return $classRankList;
    }
    
    public static function getDistanceList()
    {
        $distanceList = array();
        
        $distanceList['0']   = '0';
        $distanceList['10']  = '10';
        $distanceList['25']  = '25';
        $distanceList['50']  = '50';
        $distanceList['100'] = '100';

        return $distanceList;
    }
    
    public static function getDivisionCond($division)
    {
        if (empty($division)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch ($division) {
            case 'JUCO':
                $cond .= "`fldDivision`='JUCO' OR ";
            case 'NAIA':
                $cond .= "`fldDivision`='NAIA' OR ";
            case 'DivisionIII':
                $cond .= "`fldDivision`='DivisionIII' OR ";
            case 'DivisionII':
                $cond .= "`fldDivision`='DivisionII' OR ";
            case 'DivisionI':
                $cond .= "`fldDivision`='DivisionI'";
        }
        
        return $cond . ')';
    }
    
    public static function getDivisionList()
    {
        $divisionList = array();
               
        $divisionList['DivisionI'] = 'Division I';
        $divisionList['DivisionII'] = 'Division II';
        $divisionList['DivisionIII'] = 'Division III';
        $divisionList['NAIA'] = 'NAIA';
        $divisionList['JUCO'] = 'JUCO';
        
        return $divisionList;
    }
    
    public static function getGPACond($gpa)
    {
        if (empty($gpa)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch ($gpa) {
            case 'under2.0':
                $cond .= "`fldGPA`='under2.0' OR ";
            case '2.0-2.5':
                $cond .= "`fldGPA`='2.0-2.5' OR ";
            case '2.6-3.0':
                $cond .= "`fldGPA`='2.6-3.0' OR ";
            case '3.1-3.5':
                $cond .= "`fldGPA`='3.1-3.5' OR ";
            case '3.6-4.0':
                $cond .= "`fldGPA`='3.6-4.0' OR ";
            case 'Above4.0':
                $cond .= "`fldGPA`='Above4.0'";
        }
        
        return $cond . ')';
    }
    
    public static function getGPAList()
    {
        $gpaList = array();
        
        $gpaList['under2.0'] = 'Under 2.0';
        $gpaList['2.0-2.5']  = '2.0 - 2.5';
        $gpaList['2.6-3.0']  = '2.6 - 3.0';
        $gpaList['3.1-3.5']  = '3.1 - 3.5';
        $gpaList['3.6-4.0']  = '3.6 - 4.0';
        $gpaList['Above4.0'] = 'Above 4.0';
        
        return $gpaList;
    }
    
    public static function getHeightCond($min, $max)
    {
        if (empty($min) && empty($max)) {
            return '';
        }
        
        // parses the value of min into inches for comparison
        $minInches = 0;
        if (!empty($min)) {
            $minInches = ((int) substr($min, 0, 1)) * 12
                       + ((int) substr($min, 2));
        }
        
        // parses the value of max into inches for comparison
        $maxInches = 1000; // no one should be taller than 1000 inches
        if (!empty($max)) {
            $maxInches = ((int) substr($max, 0, 2)) * 12
                       + ((int) substr($max, 2));
        }
        
        // creates a query that converts the height (in the format FEET-INCHES)
        // of each athlete into inches for comparison with the search
        // parameters. The query ignores null (empty) athlete heights
        return " AND `fldHeight` IS NOT NULL AND `fldHeight` != '' " .
               "AND (SELECT SUBSTR(`fldHeight`,1,1)*12+" .
               "(SELECT SUBSTR(`fldHeight`,3))) " .
               "BETWEEN $minInches AND $maxInches";
    }
    
    public static function getHeightList()
    {
        $heightList = array();
        
        for ($i = 60; $i <= 86; $i++) {
            $ft = floor($i / 12);
            $in = $i % 12;
            
            $heightList[$ft . '-' . $in] = $ft . "' " . $in;
        }
        
        return $heightList;
    }
    
    public static function getMajorCond($major)
    {
        if (empty($major)) {
            return '';
        }
        
        return " AND `fldIntendedMajor`='" . 
               mysql_real_escape_string($major) . "'";
    }
    
    public static function getMajorList()
    {
        $majorList = array();
        
        $major = 'Undecided / General Studies';
        $majorList[$major] = $major;

        $majorList['Agriculture']    = 'Agriculture';
        $majorList['Architecture']   = 'Architecture';
        $majorList['Arts']           = 'Arts';
        $majorList['Business']       = 'Business';
        $majorList['Communications'] = 'Communications';

        $major = 'Computers / Information Technology';
        $majorList[$major] = $major;

        $majorList['Education']      = 'Education';
        $majorList['Engineering']    = 'Engineering';
        $majorList['Liberal Arts']   = 'Liberal Arts';
        $majorList['Math']           = 'Math';
        $majorList['Science']        = 'Science';
        $majorList['Other']          = 'Other';
        
        return $majorList;
    }
    
    public static function getPositionList($sport)
    {
        $func = new COMMONFUNC;
        $positionList = array();
        
        $table = NULL;
        
        switch ($sport) {
            case '10':
                $table = TBL_POSITION_FOOTBALL;
                break;
            
            case '11':
            case '12':
                $table = TBL_POSITION_BASKETBALL;
                break;
        }
        
        $positions = $func->selectTableOrder($table, 'Position', 'Position');

        foreach ($positions as $position) {
            $positionList[$position['Position']] = $position['Position'];
        }
        
        return $positionList;
    }
    
    public static function getPositionCond($order, $position)
    {
        if (empty($position)) {
            return '';
        }
        
        switch ($order) {
            case 'primary':
                $field = 'fldPrimaryPosition';
                break;
            case 'secondary':
                $field = 'fldSecondaryPosition';
                break;
        }
        
        return " AND `$field`='" . mysql_real_escape_string($position) . "'";
    }
    
    public static function getSATCond($sat)
    {
        if (empty($sat)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch ($sat) {
            case '400-600':
                $cond .= "`fldSATScore`='400-600' OR ";
            case '601-800':
                $cond .= "`fldSATScore`='601-800' OR ";
            case '801-1000':
                $cond .= "`fldSATScore`='801-1000' OR ";
            case '1001-1200':
               $cond .= "`fldSATScore`='1001-1200' OR ";
            case '1201-1400':
                $cond .= "`fldSATScore`='1201-1400' OR ";
            case '1401-1600':
                $cond .= "`fldSATScore`='1401-1600' OR ";
            case '1601-1800':
                $cond .= "`fldSATScore`='1601-1800' OR ";
            case '1801-2000':
                $cond .= "`fldSATScore`='1801-2000' OR ";
            case '2001-2200':
                $cond .= "`fldSATScore`='2001-2200' OR ";
            case '2201-2400':
                $cond .= "`fldSATScore`='2201-2400'";
        }
        
        return $cond . ')';
    }
    
    public static function getSATScoreList()
    {
        $satList = array();
        
        $satList['400-600'] = '400-600';

        for ($i = 601, $j = 800; $j <= 2400; $i += 200, $j += 200) {
            $satList[$i . '-' . $j] = $i . '-' . $j;
        }
        
        return $satList;
    }
    
    public static function getSchoolCond($school)
    {
        if (empty($school)) {
            return '';
        }
        
        return ' AND `fldSchool`=' . intval($school);
    }
    
    public static function getSchoolList()
    {
        $func = new COMMONFUNC;
        $schoolList = array();
        
        $groups = $func->selectTableOrdergroupby(
            TBL_HS_AAU_TEAM, 
            "fldState", 
            "fldState", 
            "WHERE fldStatus='ACTIVE'"
        );

        for ($i = 0; $i < count($groups); $i++) {
            $groupLabel = '========' . $groups[$i]['fldState'] . '========';
            $schoolList[$groupLabel] = array();

            //School Loop (in state)
            
            $where = "WHERE fldState='" . $groups[$i]['fldState'] . "'";
            
            $schools = $func->selectTableOrder(
                TBL_HS_AAU_TEAM,
                "fldId,fldSchoolname",
                "fldSchoolname", 
                $where
            );
            
            for ($j = 0; $j < count($schools); $j++) {
                $key   = $schools[$j]['fldId'];
                $value = $schools[$j]['fldSchoolname'];
                
                $schoolList[$groupLabel][$key] = $value;
            }
        }
        
        return $schoolList;
    }
    
    public static function getSchoolsInDistance($zip, $distance)
    {
        if (empty($zip)) {
            return '';
        }
        
        if ($distance === 'any') {
            return " AND `fldSchool` != ''";
        }
        
        if (empty($distance)) {
            $query = 'SELECT `fldId` FROM ' . TBL_HS_AAU_TEAM . 
                     " WHERE `fldZipcode`='" . mysql_real_escape_string($zip) . 
                     "' AND `fldStatus`='ACTIVE'";
        } else {
            $z = new zipcode_class;
            
            $zips = $z->get_zips_in_range(
                mysql_real_escape_string($zip),
                intval($distance),
                _ZIPS_SORT_BY_DISTANCE_ASC,
                true
            );
            
            $fldzip_code = implode(',', $zips);
            
            $query = 'SELECT `fldId` FROM ' . TBL_HS_AAU_TEAM . 
                     ' WHERE `fldZipcode` IN (' . $fldzip_code . 
                     ") AND `fldStatus`='ACTIVE'";
        }
        
        $db = new DB;
            
        if (!$db->query($query)) {
            die(mysql_error());
        }
        
        $schools = array(0);
        
        while ($db->next_record()) {
            $schools[] = $db->f('fldId');
        }
        
        return ' AND `fldSchool` IN (' . implode(',', $schools) . ')';
    }
    
    public static function getShuttleRunCond($time)
    {
        if (empty($time)) {
            return '';
        }
        
        return " AND `fldShuttleRun`!='' and `fldShuttleRun`<=" . 
               mysql_real_escape_string($time);
    }
    
    public static function getSportCond($sport)
    {
        if (empty($sport)) {
            return '';
        }
        
        return " AND `fldSport`=" . mysql_real_escape_string($sport);
    }
    
    public static function getSquatCond($weight)
    {
        if (empty($weight)) {
            return '';
        }
        
        return " AND `fldSquatMax`!='' AND `fldSquatMax`>=" .
               mysql_real_escape_string($weight);
    }
    
    public static function getStateCond($state)
    {
        if (empty($state)) {
            return '';
        }
        
        return " AND `fldState`='" . mysql_real_escape_string($state) . "'";
    }
    
    public static function getStateList()
    {
        $stateList = array();
        
        $stateList['United States'] = array(
            'Alaska' => 'Alaska',
            'Alabama' => 'Alabama',
            'Arkansas' => 'Arkansas',
            'Arizona' => 'Arizona',
            'California' => 'California',
            'Colorado' => 'Colorado',
            'Connecticut' => 'Connecticut',
            'District of Columbia' => 'District of Columbia',
            'Delaware' => 'Delaware',
            'Florida' => 'Florida',
            'Georgia' => 'Georgia',
            'Hawaii' => 'Hawaii',
            'Iowa' => 'Iowa',
            'Idaho' => 'Idaho',
            'Illinois' => 'Illinois',
            'Indiana' => 'Indiana',
            'Kansas' => 'Kansas',
            'Kentucky' => 'Kentucky',
            'Louisiana' => 'Louisiana',
            'Massachusetts' => 'Massachusetts',
            'Maryland' => 'Maryland',
            'Maine' => 'Maine',
            'Michigan' => 'Michigan',
            'Minnesota' => 'Minnesota',
            'Missouri' => 'Missouri',
            'Mississippi' => 'Mississippi',
            'Montana' => 'Montana',
            'North Carolina' => 'North Carolina',
            'North Dakota' => 'North Dakota',
            'Nebraska' => 'Nebraska',
            'New Hampshire' => 'New Hampshire',
            'New Jersey' => 'New Jersey',
            'New Mexico' => 'New Mexico',
            'Nevada' => 'Nevada',
            'New York' => 'New York',
            'Ohio' => 'Ohio',
            'Oklahoma' => 'Oklahoma',
            'Oregon' => 'Oregon',
            'Pennsylvania' => 'Pennsylvania',
            'Puerto Rico' => 'Puerto Rico',
            'Rhode Island' => 'Rhode Island',
            'South Carolina' => 'South Carolina',
            'South Dakota' => 'South Dakota',
            'Tennessee' => 'Tennessee',
            'Texas' => 'Texas',
            'Utah' => 'Utah',
            'Virginia' => 'Virginia',
            'Vermont' => 'Vermont',
            'Washington' => 'Washington',
            'Wisconsin' => 'Wisconsin',
            'West Virginia' => 'West Virginia',
            'Wyoming' => 'Wyoming'
        );

        $stateList['Canada'] = array(
            'Alberta' => 'Alberta',
            'British Columbia' => 'British Columbia',
            'Manitoba' => 'Manitoba',
            'New Brunswick' => 'New Brunswick',
            'Newfoundland' => 'Newfoundland',
            'Northwest Territories' => 'Northwest Territories',
            'Nova Scotia' => 'Nova Scotia',
            'Nunavut' => 'Nunavut',
            'Ontario' => 'Ontario',
            'Prince Edward Island' => 'Prince Edward Island',
            'Quebec' => 'Quebec',
            'Saskatchewan' => 'Saskatchewan',
            'Yukon Territory' => 'Yukon Territory'
        );
        
        return $stateList;
    }
    
    public static function getSubscribedSports($id)
    {
        $db = new DB;
        $func = new COMMONFUNC;
        
        $sports = array();
        
        if (empty($id)) {
            return $sports;
        }
        
        $query = 'SELECT ' . TBL_SPORTS . '.fldId, ' .
                 TBL_SPORTS . '.fldSportsname ' .
                 'FROM ' . TBL_SPORTS .
                 ' INNER JOIN ' . TBL_COLLEGE_SUBSCRIPTION .
                 ' ON ' . TBL_SPORTS . '.fldId=' .
                 TBL_COLLEGE_SUBSCRIPTION . '.fldSport ' .
                 'WHERE ' . TBL_COLLEGE_SUBSCRIPTION . '.fldCoach=' . $id .
                 ' AND ' . TBL_COLLEGE_SUBSCRIPTION . '.fldActive=1';
        
        if (!$db->query($query)) {
            die(mysql_error());
        }
        
        while ($db->next_record()) {
            $sports[$db->f('fldId')] = $db->f('fldSportsname');
        }
        
        // TODO: Delete the following code when the free trial is ended
        // Adds the sport they registered for if
        // the coach has no active subscriptions
        if (count($sports) == 0) {
            $query = 'SELECT ' . TBL_SPORTS . '.fldId, ' .
                     TBL_SPORTS . '.fldSportsname ' .
                     'FROM ' . TBL_SPORTS .
                     ' INNER JOIN ' . TBL_COLLEGE_COACH_REGISTER .
                     ' ON ' . TBL_SPORTS . '.fldId=' .
                     TBL_COLLEGE_COACH_REGISTER . '.fldSport ' .
                     'WHERE ' . TBL_COLLEGE_COACH_REGISTER . '.fldId=' . $id;
            
            if (!$db->query($query)) {
                die(mysql_error());
            }
            
            while ($db->next_record()) {
                $sports[$db->f('fldId')] = $db->f('fldSportsname');
            }
        } // end delete
        
        return $sports;
    }
    
    public static function getVerticalJumpCond($height)
    {
        if (empty($height)) {
            return '';
        }
        
        return " AND `fldVertical` != '' AND `fldVertical`>=" . 
               mysql_real_escape_string($height);
    }
    
    public static function getWeightCond($min, $max)
    {
        if (empty($min) && empty($max)) {
            return '';
        }
        
        $cond = ' AND (';
        
        switch (!empty($min) ? $min : 'under140') {
            case 'under140':
                $cond .= "`fldWeight`='under140'";
                
                if (!empty($max) && $max == 'under140') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '141-155':
                $cond .= "`fldWeight`='141-155'";
                
                if (!empty($max) && $max == '141-155') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '156-170':
                $cond .= "`fldWeight`='156-170'";
                
                if (!empty($max) && $max == '156-170') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '171-185':
                $cond .= "`fldWeight`='171-185'";
                
                if (!empty($max) && $max == '171-185') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '186-200':
                $cond .= "`fldWeight`='186-200'";
                
                if (!empty($max) && $max == '186-200') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '201-215':
                $cond .= "`fldWeight`='201-215'";
                
                if (!empty($max) && $max == '201-215') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '216-230':
                $cond .= "`fldWeight`='216-230'";
                
                if (!empty($max) && $max == '216-230') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '231-245':
                $cond .= "`fldWeight`='231-245'";
                
                if (!empty($max) && $max == '231-245') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case '246-260':
                $cond .= "`fldWeight`='246-260'";
                
                if (!empty($max) && $max == '246-260') {
                    break;
                } else {
                    $cond .= ' OR ';
                }
            case 'Over260':
                $cond .= "`fldWeight`='Over260'";
                break;
        }
        
        return $cond . ')';
    }
    
    	public static function getPointCond($min, $max)
    {
        if (empty($min)) {
            return '';
        }
        else
		{
			$cond = ' AND (';
			
			if($min == 'under100')
			{
				 $cond .= "`fldTotal_points`<'100'";
			}
			else if($min == 'Over1000')
			{
				 $cond .= "`fldTotal_points`>='1000'";
			}
			else
			{
				$minval = explode("-",$min);
				$cond .= "`fldTotal_points`>='".$minval[0]."'";
				$cond .= ' AND ';
				$cond .= "`fldTotal_points`<'".$minval[1]."'";
			}
			return $cond . ')';
		}       
        return '';
    }
	public static function getRatingCond($min, $max)
    {
        if (empty($min)) {
            return '';
        }
        else
		{
			$minval = explode("-",$min);
			$cond = ' AND (';
			$cond .= "`fldIntangible_rating`>='".$minval[0]."'";
			$cond .= ' AND ';
			$cond .= "`fldIntangible_rating`<'".$minval[1]."'";

			return $cond . ')';
		}       
        return '';
    }
    
    
    public static function getWeightList()
    {
        $weightList = array();
        
        $weightList['under140'] = 'Under 140';

        for ($i = 127; $i < 245; $i++) {
            $i = $i + 14;
            $j = $i + 14;
            
            $weightList[$i . '-' . $j] = $i . '-' . $j;
        }

        $weightList['Over260'] = 'Over 260';
        
        return $weightList;
    }
    	public static function getPointList()
    {
        $weightList = array();
        
        $weightList['under100'] = 'Under 100';

        for ($i = 1; $i < 10; $i++) {
		$k = $i;
		
            $k = $k * 100;
            $j = ($i+1) * 100;
            
            $weightList[$k . '-' . $j] = $k . '-' . $j;
        }

        $weightList['Over1000'] = 'Over 1000';
        
        return $weightList;
    }
	public static function getRatingList()
    {
        $weightList = array();
        
       // $weightList['under100'] = 'Under 100';

        for ($i = 1; $i < 10; $i++) {
		$k = $i;
		
            $k = $k ;
            $j = ($i+1);
            
            $weightList[$k . '-' . $j] = $k . '-' . $j;
        }

       // $weightList['Over1000'] = 'Over 1000';
        
        return $weightList;
    }
}
