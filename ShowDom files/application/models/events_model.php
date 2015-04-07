<?php  
class Events_model extends CI_Model {  
	function Events_model()  
	{  
		parent::__construct();  
		$this->load->library(array('session','geocode'));
	}  
	
	
	function getAllEvents($searchTerm='',$offset=0,$limit=6){
		$today = date('Y-m-d');
        $time = date('H:i:s');
/*
        $query = "
            SELECT *,((ACOS(SIN(".$lat." * PI() / 180) *
            SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
            COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
            * 180 / PI()) * 60 * 1.1515)
            AS distance
            FROM tbl_events
            LEFT JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)

            INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )
            GROUP BY tbl_events.event_id
            HAVING distance<=".$distance."
            ORDER BY event_type ASC
        ";
*/
		if($searchTerm != ''){
			$query = "SELECT * FROM tbl_events 
			INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
			LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)

			INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )

			WHERE event_title LIKE '%".$searchTerm."%'
			GROUP BY event_id
			ORDER BY event_start_date ASC LIMIT ".$limit." OFFSET ".$offset.""; 
		}else{
			$query = "SELECT * FROM tbl_events 
			INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
			LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)

			INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )
            GROUP BY event_id
			ORDER BY event_start_date ASC LIMIT ".$limit." OFFSET ".$offset."";
		}
		
		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function getAllReportedEvents($searchTerm='',$offset=0,$limit=6){
		$today = date('Y-m-d');
        $time = date('H:i:s');
		if($searchTerm != ''){
			$query = "SELECT * FROM tbl_events 
			INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
			LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
			INNER JOIN tbl_event_reports ON(tbl_event_reports.event_id = tbl_events.event_id)

			INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )

			WHERE event_title LIKE '%".$searchTerm."%'
			GROUP BY tbl_events.event_id
			ORDER BY event_start_date ASC 
			LIMIT ".$limit." 
			OFFSET ".$offset.""; 
		}else{
			$query = "SELECT * FROM tbl_events 
			INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
			LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
			INNER JOIN tbl_event_reports ON(tbl_event_reports.event_id = tbl_events.event_id)

			INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )

			GROUP BY tbl_events.event_id
			ORDER BY event_start_date ASC 
			LIMIT ".$limit."
			OFFSET ".$offset."";
		}


		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function getAllClaimedEvents(){
		$today = date('Y-m-d');		
		$query = "SELECT * FROM tbl_events 
		INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
		LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
		INNER JOIN tbl_claims ON(tbl_claims.event_id = tbl_events.event_id)
		ORDER BY event_start_date ASC";

		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function claimEventApprove($claimId){
		$getEventId = mysql_query('SELECT * FROM tbl_claims WHERE claim_id = '.$claimId.'');
		$row = mysql_fetch_array($getEventId);
		$eventId = $row['event_id'];
		$showdom_id = $row['showdom_id'];
		$user_id = $this->getUserIdFromShowdomId($showdom_id);
		
		$query = mysql_query('UPDATE tbl_events SET user_id = '.$user_id.', event_claim = 0 WHERE event_id = '.$eventId.'');
		$query = mysql_query('DELETE FROM tbl_claims WHERE event_id = '.$eventId.'');
	}

    function claimEventRemove($claimId){
        $query = mysql_query('DELETE FROM tbl_claims WHERE claim_id = '.$claimId.'');
    }
	
	function getUserIdFromShowdomId($showdom_id){
		$query = mysql_query('SELECT * FROM tbl_users WHERE showdom_id = "'.$showdom_id.'"');
		$row = mysql_fetch_array($query);
		return $row['user_id'];
	}
	
	function countEvents(){  	
		$today = date('Y-m-d');
        $time = date('H:i:s');

		$query = $this->db->query("SELECT COUNT(event_id) AS numEvents FROM tbl_events
		    INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )
		");
		$row = $query->row();  
		return $row->numEvents;
	}
	
	function countReportedEvents(){  	
		$today = date('Y-m-d');		 	
		$query = $this->db->query("SELECT COUNT(Distinct tbl_event_reports.event_id) AS numEvents FROM tbl_event_reports
		    INNER JOIN tbl_events ON(
		        tbl_events.event_id = tbl_event_reports.event_id
		        AND tbl_events.event_end_date >= '".$today."'
		    )
		");
		$row = $query->row();  
		return $row->numEvents;
	}
	
	function getEvents($lat,$lng,$distance=100){
		$today = date('Y-m-d');
        $time = date('H:i:s');

        $query = "
            SELECT *,((ACOS(SIN(".$lat." * PI() / 180) *
            SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
            COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
            * 180 / PI()) * 60 * 1.1515)
            AS distance
            FROM tbl_events
            LEFT JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)

            INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_end_time)  >= '".$today." ".$time."'
            )";

            //$query .= "AND CONCAT(eventDates.start_date_time_start_date,' ',eventDates.start_date_time_start_time) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 12 HOUR)";
            //$query .= "AND CONCAT(eventDates.start_date_time_start_date,' ',eventDates.start_date_time_start_time) BETWEEN DATE_SUB(NOW(), INTERVAL 12 HOUR) AND DATE_ADD(NOW(), INTERVAL 12 HOUR)";

            $query .= " AND eventDates.start_date_time_end_date <= '".$today."'";

            $query .= "GROUP BY tbl_events.event_id
            HAVING distance<=".$distance."
            ORDER BY event_type ASC
        ";

        //print_r($query);

		$query = $this->db->query($query);
		return $query->result();  
	}

    function getMostViewedEvents($lat,$lng){
        $today = date('Y-m-d');
        $time = date('H:i:s');
        $distance = '1000';
        //----SELECT COUNT(*) as total FROM tbl_stats WHERE id = ".$id." AND stat_type = '".$statType."'"
        $query = "
            SELECT *,((ACOS(SIN(".$lat." * PI() / 180) *
            SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
            COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
            * 180 / PI()) * 60 * 1.1515)
            AS distance,
            (SELECT count(stat_id) as numViews FROM tbl_stats WHERE id = tbl_events.event_id AND stat_type = 'event-full-view') AS numViews
           FROM tbl_events
            LEFT JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)
            LEFT JOIN tbl_event_categories_sub AS subCats ON(subCats.sub_cat_id = tbl_events.event_sub_cat)
            INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
            )
            GROUP BY event_id
            HAVING distance<=".$distance."
            AND numViews != 0
            ORDER BY numViews DESC LIMIT 50
        ";
        $query = $this->db->query($query);
        return $query->result();
    }
	
	function searchEvents($lat,$lng,$distance=35,$searchString,$startDate,$endDate,$anyDate,$cats,$twelvehour,$featured,$subCats='All'){
		$today = date('Y-m-d');
        $time = date('H:i:s');

        $query = "
            SELECT *,((ACOS(SIN(".$lat." * PI() / 180) *
            SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
            COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
            * 180 / PI()) * 60 * 1.1515)
            AS distance
            FROM tbl_events
            LEFT JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)
            LEFT JOIN tbl_event_categories_sub AS subCats ON(subCats.sub_cat_id = tbl_events.event_sub_cat)

            INNER JOIN tbl_event_start_date_time AS eventDates ON (
                 eventDates.start_date_time_event = tbl_events.event_id
                 AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_end_time)  >= '".$today." ".$time."'
            )";

        if($twelvehour == 1){
            $query .= "AND CONCAT(eventDates.start_date_time_start_date,' ',eventDates.start_date_time_start_time) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 12 HOUR)";
        }elseif($anyDate == 0){
            $query .= " AND ((eventDates.start_date_time_start_date BETWEEN '".$startDate."' AND '".$endDate."')
            ||
            ('".$startDate."' BETWEEN eventDates.start_date_time_start_date AND eventDates.start_date_time_end_date))
            ";
        }

        if($featured == 1){
            $query .= " AND event_type=1 ";
        }

        if($cats != 0){
            $query .= "AND tbl_events.event_cat IN(".$cats.")";
        }

        if(isset($subCats) && ($subCats != 'All' && $subCats != 'undefined')){
            $query .= " AND tbl_events.event_sub_cat = ".$subCats." ";
        }

        $query .= "AND (MATCH(event_title,event_description) AGAINST ('".$searchString."')
			|| (cats.cat_name LIKE '%".$searchString."%')
			|| (subCats.sub_cat_name LIKE '%".$searchString."%')
			|| (venue_name LIKE '%".$searchString."%'))";

        $query .= "GROUP BY tbl_events.event_id
            HAVING distance<=".$distance."
            ORDER BY event_type ASC";

       // print_r($query);

		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function getEvents_old(){
		$today = date('Y-m-d');
		$query = $this->db->query("SELECT * FROM tbl_events 
		INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)
		WHERE event_end_date >= '".$today."'
		");
		return $query->result();  
	}
	
	function getEventContent($id){
        $today = date('Y-m-d');
        $time = date('H:i:s');

		$query = $this->db->query("SELECT * FROM tbl_events 
		INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
		LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
		INNER JOIN tbl_event_start_date_time AS eventDates ON (
             eventDates.start_date_time_event = tbl_events.event_id
        )
		WHERE event_id = ".$id."
		GROUP BY tbl_events.event_id
		ORDER BY eventDates.start_date_time_end_date DESC
		");
/*
        $query = $this->db->query("SELECT * FROM tbl_events
		INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)
		LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
		INNER JOIN tbl_event_start_date_time AS eventDates ON (
             eventDates.start_date_time_event = tbl_events.event_id
             AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
        )
		WHERE event_id = ".$id."
		GROUP BY tbl_events.event_id
		ORDER BY eventDates.start_date_time_end_date DESC
		");
*/
		return $query->result();   
	}

    function getEventDates($eventId){
        $today = date('Y-m-d');
        $query = $this->db->query('
            SELECT * FROM tbl_event_start_date_time
            WHERE start_date_time_event = '.$eventId.'
            AND start_date_time_end_date  >= "'.$today.'"
            ORDER BY start_date_time_end_date ASC
            LIMIT 5
        ');
        return $query->result();
    }
	
	function getEventCategoryInfo($eventId){
		$query = $this->db->query("SELECT * FROM tbl_events INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) WHERE event_id = ".$eventId."");
		return $query->result();  
	}
	
	function getEventUpdates($eventId,$limit=3){
		if($limit == 0){
			$query = $this->db->query("SELECT * FROM tbl_event_meta WHERE meta_key = 'event_update' AND event_id = ".$eventId." ORDER BY meta_id DESC");
		}else{
			$query = $this->db->query("SELECT * FROM tbl_event_meta WHERE meta_key = 'event_update' AND event_id = ".$eventId." ORDER BY meta_id DESC LIMIT ".$limit."");
		}
		return $query->result();  
	}
	
	function getRecentEventUpdates($featured=0,$key){
		$today = date('Y-m-d');		
		$query = "SELECT *,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) * 
		SIN(event_lat * PI() / 180) + COS(".$this->session->userdata('userLat')." * PI() / 180) * 
		COS(event_lat * PI() / 180) * COS((".$this->session->userdata('userLng')." - event_lon) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_events 
		INNER JOIN tbl_event_meta AS emet ON (
			emet.event_id = tbl_events.event_id
			AND emet.meta_key = '".$key."'
			AND emet.meta_timestamp BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND NOW()
		)
		HAVING distance<=100
		AND event_end_date >= '".$today."'
		AND event_type = ".$featured."
		ORDER BY emet.meta_timestamp DESC
		";
		$query = $this->db->query($query);
		return $query->result();  
	}

    function getFeaturedEvents(){
        $today = date('Y-m-d');
        $time = date('H:i:s');
        
        $query = "SELECT *,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) *
		SIN(event_lat * PI() / 180) + COS(".$this->session->userdata('userLat')." * PI() / 180) *
		COS(event_lat * PI() / 180) * COS((".$this->session->userdata('userLng')." - event_lon) * PI() / 180))
		* 180 / PI()) * 60 * 1.1515)
		AS distance,
		CONCAT(event_end_date,' ',event_end_time) AS theDate
		FROM tbl_events
        INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat)
        LEFT JOIN tbl_event_categories_sub AS subCats ON(subCats.sub_cat_id = tbl_events.event_sub_cat)
        INNER JOIN tbl_event_start_date_time AS eventDates ON (
             eventDates.start_date_time_event = tbl_events.event_id
             AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
        )
        GROUP BY event_id
		HAVING distance<=100
		AND event_type = 1
		";
        $query = $this->db->query($query);
        return $query->result();
    }

	function getRecentFavouriteUpdates($userId,$key){
		$today = date('Y-m-d');
        $time = date('H:i:s');
		$query = "SELECT *,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) * 
		SIN(event_lat * PI() / 180) + COS(".$this->session->userdata('userLat')." * PI() / 180) * 
		COS(event_lat * PI() / 180) * COS((".$this->session->userdata('userLng')." - event_lon) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_events 
		INNER JOIN tbl_event_meta AS emet ON (
			emet.event_id = tbl_events.event_id
			AND emet.meta_key = '".$key."'
			AND emet.meta_timestamp BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND NOW()
		)
		INNER JOIN tbl_event_favourites AS evtfav ON(
			evtfav.event_id = tbl_events.event_id
			AND evtfav.user_id = ".$userId."
		)
		INNER JOIN tbl_event_start_date_time AS eventDates ON (
             eventDates.start_date_time_event = tbl_events.event_id
             AND CONCAT(eventDates.start_date_time_end_date,' ',eventDates.start_date_time_start_time)  >= '".$today." ".$time."'
        )
        GROUP BY tbl_events.event_id
		HAVING distance<=100
		ORDER BY emet.meta_timestamp DESC
		";
		$query = $this->db->query($query);
		return $query->result();  
	}

    function getRecentFavouriteUpdatesSimple($userId){
        $today = date('Y-m-d');
        $time = date('H:i:s');
        $query = "SELECT *,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) *
		SIN(event_lat * PI() / 180) + COS(".$this->session->userdata('userLat')." * PI() / 180) *
		COS(event_lat * PI() / 180) * COS((".$this->session->userdata('userLng')." - event_lon) * PI() / 180))
		* 180 / PI()) * 60 * 1.1515)
		AS distance FROM tbl_events
		INNER JOIN tbl_event_favourites AS evtfav ON(
			evtfav.event_id = tbl_events.event_id
			AND evtfav.user_id = ".$userId."
		)
        GROUP BY tbl_events.event_id
		HAVING distance<=100
		";
        $query = $this->db->query($query);
        return $query->result();
    }

    function getRecentSuggestedUpdatesSimple($userId){
        $today = date('Y-m-d');

        $catIds = array();
        while( $row =  mysql_fetch_assoc($favEventCatIds) ) {
            $catIds[] = $row['event_cat'];
        }

        $favKeywords = mysql_query('SELECT * FROM tbl_event_favourites
			INNER JOIN tbl_event_to_keyword ON(
				tbl_event_to_keyword.event_id = tbl_event_favourites.event_id
			)
			WHERE tbl_event_favourites.user_id = '.$userId.'
		');

        $keywordIds = array();
        while( $row =  mysql_fetch_assoc($favKeywords) ) {
            $keywordIds[] = $row['keyword_id'];
        }

        $inKeywords = implode(",", $keywordIds);
        $inCats = implode(",", $catIds);
        $lat = $this->input->cookie('latCookie', TRUE);
        $lng = $this->input->cookie('lngCookie', TRUE);

        $query ="
			SELECT * ,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) *
			SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
			COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
			* 180 / PI()) * 60 * 1.1515)
			AS distance FROM tbl_events
			INNER JOIN tbl_event_to_keyword ON(
				tbl_event_to_keyword.event_id = tbl_events.event_id
			)
			INNER JOIN tbl_event_start_date_time ON(
tbl_event_start_date_time.start_date_time_event = tbl_events.event_id
)
LEFT JOIN tbl_event_categories_sub AS subCats ON(subCats.sub_cat_id = tbl_events.event_sub_cat)
			HAVING distance<=100 ";

        if($inKeywords != ''){
            $query .= "AND tbl_event_to_keyword.keyword_id IN(".$inKeywords.") ";
        }
        if($inCats != ''){
            $query .= "AND tbl_events.event_cat IN(".$inCats.") ";
        }
        $query .= "ORDER BY RAND() LIMIT 20 ";
        //$query .= "AND event_end_date >= '".$today."' ";

        //print_r($query);

        $query = $this->db->query($query,'event_id');
        $results = $query->result();
        return $results;
    }

	function getRecentSuggestedUpdates($userId,$key){
		$today = date('Y-m-d');		
		
		$favEventCatIds = mysql_query('SELECT * FROM tbl_event_favourites
			INNER JOIN tbl_events ON(
				tbl_events.event_id = tbl_event_favourites.event_id
			)
			WHERE tbl_event_favourites.user_id = '.$userId.'
		');
		
		$eventIds = array();
		$catIds = array();
		while( $row =  mysql_fetch_assoc($favEventCatIds) ) {
			$eventIds[] = $row['event_id'];
			$catIds[] = $row['event_cat'];
		}
		
		$favKeywords = mysql_query('SELECT * FROM tbl_event_favourites
			INNER JOIN tbl_event_to_keyword ON(
				tbl_event_to_keyword.event_id = tbl_event_favourites.event_id
			)
			WHERE tbl_event_favourites.user_id = '.$userId.'
		');
		
		$keywordIds = array();
		while( $row =  mysql_fetch_assoc($favKeywords) ) {
			$keywordIds[] = $row['keyword_id'];
		}
		
		$inKeywords = implode(",", $keywordIds);
		$inCats = implode(",", $catIds);
		$notInEvents = implode(",", $eventIds);

        $lat = $this->input->cookie('latCookie', TRUE);
        $lng = $this->input->cookie('lngCookie', TRUE);

		$query ="
			SELECT * ,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) * 
			SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) *
			COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180))
			* 180 / PI()) * 60 * 1.1515)
			AS distance FROM tbl_events
			INNER JOIN tbl_event_meta AS emet ON ( 
				emet.event_id = tbl_events.event_id 
				AND emet.meta_key = '".$key."' 
				AND emet.meta_timestamp  
				BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND NOW() 
			) 
						
			INNER JOIN tbl_event_to_keyword ON(
				tbl_event_to_keyword.event_id = tbl_events.event_id
			)
			
			HAVING distance<=100 ";
			
			if($inKeywords != ''){
				$query .= "AND tbl_event_to_keyword.keyword_id IN(".$inKeywords.") ";
			}
			if($notInEvents != ''){
				$query .= "AND tbl_events.event_id NOT IN(".$notInEvents.") ";
			}
			if($inCats != ''){
				$query .= "AND tbl_events.event_cat IN(".$inCats.") ";
			} 
			
			$query .= "AND event_end_date >= '".$today."' ";
			$query .= " ORDER BY emet.meta_timestamp DESC"; 
		
		/*
		$query = "SELECT *,((ACOS(SIN(".$this->session->userdata('userLat')." * PI() / 180) * 
		SIN(event_lat * PI() / 180) + COS(".$this->session->userdata('userLat')." * PI() / 180) * 
		COS(event_lat * PI() / 180) * COS((".$this->session->userdata('userLng')." - event_lon) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_events 
		INNER JOIN tbl_event_meta AS emet ON (
			emet.event_id = tbl_events.event_id
			AND emet.meta_key = 'event_update'
			AND emet.meta_timestamp BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND NOW()
		)
		INNER JOIN tbl_event_favourites AS evtfav ON(
			evtfav.event_id = tbl_events.event_id
			AND evtfav.user_id = ".$userId."
		)
		HAVING distance<=100
		AND event_end_date >= '".$today."'
		ORDER BY emet.meta_timestamp DESC
		";
		*/
        //print_r($query);

		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function countEventUpdates($eventId){
		$query = $this->db->query("SELECT COUNT(*) as numupdates FROM tbl_event_meta WHERE meta_key = 'event_update' AND event_id = ".$eventId." ORDER BY meta_id DESC LIMIT 3");
		$row = $query->row();  
		return $row;  
	}
	
	function getEventComments($eventId,$limit=3){
		if($limit == 0){
			$query = $this->db->query("SELECT * FROM tbl_event_meta 
			INNER JOIN tbl_users AS user ON(
				user.user_id = tbl_event_meta.meta_user
			)
			WHERE meta_key = 'event_comment' AND event_id = ".$eventId." ORDER BY meta_id DESC");
		}else{
			$query = $this->db->query("SELECT * FROM tbl_event_meta 
			INNER JOIN tbl_users AS user ON(
				user.user_id = tbl_event_meta.meta_user
			)
			WHERE meta_key = 'event_comment' AND event_id = ".$eventId." ORDER BY meta_id DESC LIMIT 3");
		}
		return $query->result();  
	}
	
	function countEventComments($eventId){
		$query = $this->db->query("SELECT COUNT(*) as numupdates FROM tbl_event_meta WHERE meta_key = 'event_comment' AND event_id = ".$eventId." ORDER BY meta_id DESC LIMIT 3");
		$row = $query->row();  
		return $row;  
	}
	
	function getUserEvents($userId,$offset=0){
		$today = date('Y-m-d');
		$query = $this->db->query("SELECT *
            FROM tbl_events
            INNER JOIN tbl_event_categories AS cats ON ( cats.cat_id = tbl_events.event_cat )
            LEFT JOIN tbl_event_categories_sub AS sub_cats ON ( tbl_events.event_sub_cat = sub_cats.sub_cat_id )
			INNER JOIN tbl_event_start_date_time AS eventDates ON (
            eventDates.start_date_time_event = tbl_events.event_id
            AND eventDates.start_date_time_end_date >= '".$today."'
            )
            WHERE user_id =".$userId."
            GROUP BY tbl_events.event_id
            ORDER BY start_date_time_start_date ASC LIMIT 10 OFFSET ".$offset."
		");

		return $query->result();
	}
	
	function getEventData($eventId){
        $today = date('Y-m-d');
		$query = $this->db->query("SELECT * FROM tbl_events INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
		LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
		INNER JOIN tbl_event_start_date_time AS eventDates ON (
             eventDates.start_date_time_event = tbl_events.event_id
            AND eventDates.start_date_time_end_date >= '".$today."'
        )

		WHERE event_id = ".$eventId."
		GROUP BY tbl_events.event_id
		ORDER BY event_end_date ASC
		");

        

		$row = $query->row();  
		return $row;  
	}
	
	
	function getCategories(){
		$query = $this->db->query('SELECT * FROM tbl_event_categories ORDER BY cat_name ASC');
		return $query->result();  
	}
	
	function getSubCategories($id){
		$query = $this->db->query('SELECT * FROM tbl_event_categories_sub WHERE cat_id = '.$id.' ORDER BY sub_cat_name ASC');
		return $query->result();
	}

    function getSearchCategories($cats){
        $query = $this->db->query('SELECT * FROM tbl_event_categories_sub WHERE cat_id IN ('.$cats.') ORDER BY sub_cat_name ASC');
        return $query->result();
    }
	
	function addEvent(){
		extract($_POST);
		
		if($ageRestricted == 0){
			$ageRestricted == 0;
		}else{
			$ageRestricted = $minAge;
		}
				
		$latlon = $this->geocode->setAddress(urlencode($eventLocation));
		if($latlon[0] != '' && $latlon[0] != ''){

			$query = 'INSERT INTO tbl_events VALUES(null,
			'.$this->session->userdata('user_id').',
			"'.mysql_real_escape_string($eventName).'",
			"'.mysql_real_escape_string($venueName).'",
			"'.mysql_real_escape_string($admissionPrice).'",
			"'.strip_tags(mysql_real_escape_string($eventDescription)).'",
			"'.mysql_real_escape_string($eventWebsite).'",
			"'.mysql_real_escape_string($eventTicketLink).'",
			"'.mysql_real_escape_string($eventCreatorType).'", 
			"'.mysql_real_escape_string($eventLocation).'",
			"'.$latlon[0].'", 
			"'.$latlon[1].'",
			"'.$latlon[2].'",
			"",
			"",
			"",
			"",
			'.$eventCategory.',
			'.$eventSubCategory.',
			"",
			'.$ageRestricted.',
			0,
			'.$claimEvent.'
			)';

			$query = mysql_query($query);
			
			$eventId = $this->getLastEvent();

            $dateTimeCounter = 0;
            foreach($eventStartMonth as $eventDateTime){
                $query = mysql_query('INSERT INTO tbl_event_start_date_time VALUES(null,
                '.$eventId.',
                "'.$eventStartYear[$dateTimeCounter].'-'.$eventStartMonth[$dateTimeCounter].'-'.$eventStartDay[$dateTimeCounter].'",
                "'.$eventEndYear[$dateTimeCounter].'-'.$eventEndMonth[$dateTimeCounter].'-'.$eventEndDay[$dateTimeCounter].'",
                "'.$eventStartTime[$dateTimeCounter].':00",
                "'.$eventEndTime[$dateTimeCounter].':00"
                )');
                $dateTimeCounter ++;
            }
			
			$eventFolder = str_replace(' ','-',$eventName);
			$showdomId = str_replace(' ','-',$this->session->userdata('showdom_id'));
			
			if($_FILES['eventImage']['name'] != ''){
				$eventImage = $_FILES['eventImage']['name'];
				$config['upload_path'] = 'themes/showdom/images/events/'.$eventId.'/';
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path']);
				}
				
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('eventImage')){
					$error = array('error' => $this->upload->display_errors());
				}else{
					/*
					$data = array('upload_data' => $this->upload->data());
					
					$configResize['image_library'] = 'gd2';
					$configResize['source_image'] = $config['upload_path'].$_FILES['eventImage']['name'];
					$configResize['maintain_ratio'] = TRUE;
					$configResize['master_dim'] = 'width';
					$configResize['width']  = '150';
					$configResize['height']  = '150';
					$this->load->library('image_lib', $configResize);
					$this->image_lib->resize();
					print_r( $configResize['source_image'] ); 
					*/
				}
				/*--- UPDATE USER IMAGE ----*/
			}else{
				$eventImage = '';	
			}

            if($eventSubCategory == 666666){
                $query = $this->db->query('INSERT INTO tbl_event_meta VALUES(null,'.$eventId.',"event_sub_meta_other","'.$otherCategory.'",NOW(),'.$this->session->userdata('user_id').')');
            }
			
			$query = 'UPDATE tbl_events SET event_image = "'.$eventImage.'" WHERE event_id = '.$eventId.'';
			$query = mysql_query($query);
		}
				
		/*--- keywords----*/
		$keywords = explode(',',$eventKeywords);
		foreach($keywords as $keyword){
			$check = $this->checkKeyword($keyword);
			if($check == 0){
				$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
				$keywordid = $this->getLastKeyword($eventId);
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventId.','.mysql_real_escape_string($keywordid).')');
			}else{
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventId.','.mysql_real_escape_string($check).')');
			}
		}
		
		return $eventId;
	}
	
	function addEventUpdate($eventId){
		$content = $_POST['eventUpdateContent']; 
		$query = mysql_query('INSERT INTO tbl_event_meta VALUES(null, '.$eventId.', "event_update","'.mysql_real_escape_string($content).'",NOW(),'.$this->session->userdata('user_id').')');
		//print_r('INSERT INTO tbl_event_meta VALUES(null, '.$eventId.', "event_update","'.$content.'",NOW(),'.$this->session->userdata('user_id').')');
	}
	
	function addEventComment($eventId){
		$content = $_POST['eventAddComment']; 
		$query = mysql_query('INSERT INTO tbl_event_meta VALUES(null, '.$eventId.', "event_comment","'.mysql_real_escape_string($content).'",NOW(),'.$this->session->userdata('user_id').')');
	}
	
	function addEventPhotos($id){
		$caption = $_POST['photoCaption'];
		if($_FILES['eventImage']['name'] != ''){
			
			$eventFolder = str_replace(' ','-',$this->getEventName($id));
			$showdomId = str_replace(' ','-',$this->session->userdata('showdom_id'));
				
			$mainFolder = 'themes/showdom/images/events/'.$id.'/';	
			if (!is_dir($mainFolder)) {
				mkdir($mainFolder);
			}	
						
			$eventImage = $_FILES['eventImage']['name'];
			$config['upload_path'] = 'themes/showdom/images/events/'.$id.'/gallery/';
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path']);
			}
			
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = FALSE;
			
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('eventImage')){
				$error = array('error' => $this->upload->display_errors());
			}else{
				$data = array('upload_data' => $this->upload->data());
				$data = $this->upload->data();
				$thumbnail = $data['raw_name'].'_thumb'.$data['file_ext']; 
				$file = $data['raw_name'].$data['file_ext']; 
				$configResize['image_library'] = 'gd2';
				$configResize['source_image'] = $config['upload_path'].$file;
				$configResize['create_thumb'] = TRUE;
				$configResize['maintain_ratio'] = FALSE;
				$configResize['width']  = '100';
				$configResize['height']  = '80';
				$this->load->library('image_lib', $configResize);
				$this->image_lib->resize();
			}
			/*--- UPDATE USER IMAGE ----*/
		}else{
			$eventImage = '';	
		}
		
		$query = mysql_query('INSERT INTO tbl_event_photos VALUES(null, '.$id.',"'.$file.'","'.$thumbnail.'","'.mysql_real_escape_string($caption).'")');
		$this->addGenericEventMeta($id,'event_update_image',$file);
	}
	
	function addGenericEventMeta($event_id,$meta_key,$meta_value){
		$query = mysql_query('INSERT INTO tbl_event_meta VALUES(null,'.$event_id.',"'.mysql_real_escape_string($meta_key).'","'.mysql_real_escape_string($meta_value).'",NOW(),'.$this->session->userdata('user_id').')');
	}
	
	
	function addEventAudio($id){
		$caption = $_POST['audioCaption'];
		if($_FILES['eventAudio']['name'] != ''){

            $featured = $this->eventHasAudio($id);
			$eventFolder = str_replace(' ','-',$this->getEventName($id));
			$showdomId = str_replace(' ','-',$this->session->userdata('showdom_id'));
				
						
			$eventAudio = $_FILES['eventAudio']['name'];
			$config['upload_path'] = 'themes/showdom/audio/events/'.$id.'/';
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path']);
			}
			
			$config['allowed_types'] = 'mp3|m4a';
			$config['overwrite'] = FALSE;
			$config['max_size']	= '1000000000';
			
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('eventAudio')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}else{
				$data = array('upload_data' => $this->upload->data());
				$data = $this->upload->data();
				$file = $data['raw_name'].$data['file_ext']; 
				$ext = $data['file_ext']; 
				$query = mysql_query('INSERT INTO tbl_event_audio VALUES(null, '.$id.',"'.$file.'","","'.$ext.'","'.mysql_real_escape_string($caption).'",'.$featured.')');
			}
			/*--- UPDATE USER IMAGE ----*/
		}else{
			$eventAudio = '';	
		}
	}


	
	function addEventYoutubeAudio($id){
		$audioCaption = $_POST['audioCaption'];
		$eventAudioYoutube = $_POST['eventAudioYoutube'];
        $featured = $this->eventHasAudio($id);
        echo $featured;
		if (strpos($eventAudioYoutube,'vimeo') !== false) {
			/*--- VIMEO VIDEO---*/	
			$audioVar = explode('/',$eventAudioYoutube);
			$audioId = end($audioVar);
			$type = 'vimeo';
		}else{
			/*--- YOUTUBE VIDEO---*/
			$audioVar = parse_url($eventAudioYoutube, PHP_URL_QUERY);
			$vars = array();
			parse_str($audioVar, $vars); 
			$audioId = $vars['v']; 
			$type = 'youtube';
		}
		
		$query = mysql_query('INSERT INTO tbl_event_audio VALUES(null, '.$id.',"","'.$audioId.'","'.$type.'","'.mysql_real_escape_string($audioCaption).'",'.$featured.')');
	}

    function eventHasAudio($id){
        $query = $this->db->query('SELECT * FROM tbl_event_audio WHERE event_id = '.$id.'');
        $numRows = $query->num_rows();
        if($numRows != 0){
            return 0;
        }else{
            return 1;
        }
    }
	
	function addEventVideo($id){
		$caption = $_POST['videoCaption'];
		
		if($_FILES['eventVideo']['name'] != ''){
            $featured = $this->eventHasVideo($id);
			$eventFolder = str_replace(' ','-',$this->getEventName($id));
			$showdomId = str_replace(' ','-',$this->session->userdata('showdom_id'));
						
			$eventVideo = $_FILES['eventVideo']['name'];
			$config['upload_path'] = 'themes/showdom/video/events/'.$id.'/';
			
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path']);
			}
			
			$config['allowed_types'] = 'avi|mpg|mpeg|wmv|mp4|flv';
			$config['overwrite'] = FALSE;
			$config['max_size']	= '1000000000';
			
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('eventVideo')){
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
				print_r($this->upload->file_type);
				return $error;
			}else{
				
				$data = array('upload_data' => $this->upload->data());
				$data = $this->upload->data();
				$file = $data['raw_name'].$data['file_ext']; 
				$ext = $data['file_ext']; 
				
				$query = mysql_query('INSERT INTO tbl_event_video VALUES(null, '.$id.',"'.$file.'","'.$ext.'","","'.mysql_real_escape_string($caption).'",'.$featured.')');
			}
			/*--- UPDATE USER IMAGE ----*/
		}else{
			$eventVideo = '';	
		}
	}
	
	function addEventYoutubeVideo($id){
		$caption = $_POST['videoCaption'];
		$eventVideoYoutube = $_POST['eventVideoYoutube'];
        $featured = $this->eventHasVideo($id);
		if (strpos($eventVideoYoutube,'vimeo') !== false) {
			/*--- VIMEO VIDEO---*/
			$videoVar = explode('/',$eventVideoYoutube);
			$videoId = end($videoVar);
			$type = 'vimeo';
		}else{
			/*--- YOUTUBE VIDEO---*/
			$videoVar = parse_url($eventVideoYoutube, PHP_URL_QUERY);
			$vars = array();
			parse_str($videoVar, $vars);
			$videoId = $vars['v'];
			$type = 'youtube';
		}
		
		
		$query = mysql_query('INSERT INTO tbl_event_video VALUES(null, '.$id.',"","'.$type.'","'.$videoId.'","'.mysql_real_escape_string($caption).'",'.$featured.')');
	}

    function eventHasVideo($id){
        $query = $this->db->query('SELECT * FROM tbl_event_video WHERE event_id = '.$id.'');
        $numRows = $query->num_rows();
        if($numRows != 0){
            return 0;
        }else{
            return 1;
        }
    }
	
	function deleteEventPhoto($eventid,$photoid){
		$query = mysql_query('DELETE FROM tbl_event_photos WHERE photo_id = '.$photoid.' AND event_id = '.$eventid.'');
	}
	
	function deleteEventAudio($eventid,$audioid){
		$query = mysql_query('DELETE FROM tbl_event_audio WHERE audio_id = '.$audioid.' AND event_id = '.$eventid.'');
	}
	
	function deleteEventVideo($eventid,$videoid){
		$query = mysql_query('DELETE FROM tbl_event_video WHERE video_id = '.$videoid.' AND event_id = '.$eventid.'');
	}
	
	function featureEventAudio($eventid,$audioid){
		$query = mysql_query('UPDATE tbl_event_audio SET featured = 0 WHERE event_id = '.$eventid.'');
		$query = mysql_query('UPDATE tbl_event_audio SET featured = 1 WHERE event_id = '.$eventid.' AND audio_id = '.$audioid.'');
	}
	
	function featureEventVideo($eventid,$videoid){
		$query = mysql_query('UPDATE tbl_event_video SET featured = 0 WHERE event_id = '.$eventid.'');
		$query = mysql_query('UPDATE tbl_event_video SET featured = 1 WHERE event_id = '.$eventid.' AND video_id = '.$videoid.'');
	}
	
	function removeFeatureEventAudio($eventid,$audioid){
		$query = mysql_query('UPDATE tbl_event_audio SET featured = 0 WHERE event_id = '.$eventid.'');
	}
	
	function removeFeatureEventVideo($eventid,$videoid){
		$query = mysql_query('UPDATE tbl_event_video SET featured = 0 WHERE event_id = '.$eventid.'');
	}
	
	function editEvent(){
		extract($_POST);

        //echo $this->input->post('eventDescription');
        //echo mysql_real_escape_string(strip_tags($eventDescription));

		$latlon = $this->geocode->setAddress(urlencode($eventLocation));
		if($latlon[0] != '' && $latlon[0] != ''){
			
			$query = 'UPDATE tbl_events SET
			event_title = "'.mysql_real_escape_string($eventName).'",
			venue_name = "'.mysql_real_escape_string($venueName).'",
			admission_price = "'.mysql_real_escape_string($admissionPrice).'",
			event_description = "'.strip_tags(mysql_real_escape_string($eventDescription)).'",
			event_website = "'.mysql_real_escape_string($eventWebsite).'",
			event_tickets = "'.mysql_real_escape_string($eventTicketLink).'",
			event_creator_type = "'.mysql_real_escape_string($eventCreatorType).'", 
			event_location = "'.mysql_real_escape_string($eventLocation).'",
			event_lat = "'.$latlon[0].'", 
			event_lon = "'.$latlon[1].'",
			event_timezone = "'.$latlon[2].'",
			event_start_date = "",
			event_end_date = "",
			event_start_time = "",
			event_end_time = "",
			event_cat = '.mysql_real_escape_string($eventCategory).',
			event_sub_cat = '.mysql_real_escape_string($eventSubCategory).',
			event_claim = '.mysql_real_escape_string($claimEvent).'
			WHERE event_id = '.$eventid.' AND user_id = '.$this->session->userdata('user_id').'';
            mysql_query($query);


            $query = mysql_query('DELETE FROM tbl_event_start_date_time WHERE start_date_time_event = '.$eventid.'');
            $dateTimeCounter = 0;
            foreach($eventStartMonth as $eventDateTime){

                $query = 'INSERT INTO tbl_event_start_date_time VALUES(null,
                '.$eventid.',
                "'.$eventStartYear[$dateTimeCounter].'-'.$eventStartMonth[$dateTimeCounter].'-'.$eventStartDay[$dateTimeCounter].'",
                "'.$eventEndYear[$dateTimeCounter].'-'.$eventEndMonth[$dateTimeCounter].'-'.$eventEndDay[$dateTimeCounter].'",
                "'.$eventStartTime[$dateTimeCounter].':00",
                "'.$eventEndTime[$dateTimeCounter].':00"
                )';
                $query = mysql_query($query);
                $dateTimeCounter ++;
            }

			if(isset($minAge)){
				$query = 'UPDATE tbl_events SET
				event_min_age = "'.mysql_real_escape_string($minAge).'"
				WHERE event_id = '.$eventid.' AND user_id = '.$this->session->userdata('user_id').'
				';
				$query = mysql_query($query);
			}else{
				$query = 'UPDATE tbl_events SET
				event_min_age = "0"
				WHERE event_id = '.$eventid.' AND user_id = '.$this->session->userdata('user_id').'
				';
				$query = mysql_query($query);
			}
			
			if(isset($_FILES['eventImage']['name']) && $_FILES['eventImage']['name'] != ''){
				$eventImage = $_FILES['eventImage']['name'];
				$config['upload_path'] = 'themes/showdom/images/events/'.$eventid.'/';
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path']);
				}
				
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('eventImage')){
					$error = array('error' => $this->upload->display_errors());
				}else{

				}
				/*--- UPDATE USER IMAGE ----*/
				$query = 'UPDATE tbl_events SET
				event_image = "'.$eventImage.'"
				WHERE event_id = '.$eventid.' AND user_id = '.$this->session->userdata('user_id').'
				';
				//print_r($query);
				$query = mysql_query($query);
			}

            if($eventSubCategory == 666666){
                $query = $this->db->query('UPDATE tbl_event_meta SET meta_value = "'.$otherCategory.'" WHERE event_id = '.$eventid.' AND meta_key = "event_sub_meta_other"');
            }
			
		}
				
		$query = mysql_query($query);
		
		/*--- keywords----*/
		$deleteOldKeywords = mysql_query('DELETE FROM tbl_event_to_keyword WHERE event_id = '.$eventid.'');
		$keywords = explode(',',$eventKeywords);
		foreach($keywords as $keyword){
			$check = $this->checkKeyword($keyword);
			if($check == 0){
				$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
				$keywordid = $this->getLastKeyword($eventId);
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventid.','.mysql_real_escape_string($keywordid).')');
			}else{
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventid.','.mysql_real_escape_string($check).')');
			} 
		}
		
		return TRUE;
	}
	
	function updateMoreOnLinks($eventid){
		$googleplus = mysql_real_escape_string($_POST['googleplus']);
		$facebook = mysql_real_escape_string($_POST['facebook']);
		$twitter = mysql_real_escape_string($_POST['twitter']);
		$linkedin = mysql_real_escape_string($_POST['linkedin']);
		$youtube = mysql_real_escape_string($_POST['youtube']);
		$myspace = mysql_real_escape_string($_POST['myspace']);
		$vimeo = mysql_real_escape_string($_POST['vimeo']);
		$flickr = mysql_real_escape_string($_POST['flickr']);
		$behance = mysql_real_escape_string($_POST['behance']);
		$deviantArt = mysql_real_escape_string($_POST['deviantArt']);
		$pinterest = mysql_real_escape_string($_POST['pinterest']);
		$lastfm = mysql_real_escape_string($_POST['lastfm']);
		$section = mysql_real_escape_string($_POST['section']);
		
		$links = array();
		$links[''.$section.'-googleplus-link'] = $googleplus;
		$links[''.$section.'-facebook-link'] = $facebook;
		$links[''.$section.'-twitter-link'] = $twitter;
		$links[''.$section.'-linkedIn-link'] = $linkedin;
		$links[''.$section.'-myspace-link'] = $myspace;
		$links[''.$section.'-youtube-link'] = $youtube;
		$links[''.$section.'-vimeo-link'] = $vimeo;
		$links[''.$section.'-flickr-link'] = $flickr;
		$links[''.$section.'-behance-link'] = $behance;
		$links[''.$section.'-deviantArt-link'] = $deviantArt;
		$links[''.$section.'-pinterest-link'] = $pinterest;
		$links[''.$section.'-lastfm-link'] = $lastfm;
		
		foreach($links as $key => $value){
			if($value != '' && substr($value, 0, 7) != "http://"){
				$value = 'http://'.$value;
			}
			$checkQuery = mysql_query('SELECT * FROM tbl_event_meta WHERE meta_key = "'.$key.'" AND event_id = '.$eventid.'');
			if(mysql_num_rows($checkQuery) != 0){
				mysql_query('UPDATE tbl_event_meta SET meta_value = "'.$value.'" WHERE meta_key = "'.$key.'" AND event_id = '.$eventid.'');
			}else{
				mysql_query('INSERT INTO tbl_event_meta VALUES(null, '.$eventid.', "'.$key.'","'.$value.'",NOW(),'.$this->session->userdata('user_id').')');
			}
		}
	}
	
	function updateEventPostingType($id,$type){
		$query = mysql_query('UPDATE tbl_events SET event_type = '.$type.' WHERE event_id = '.$id.''); 
	}
	
	function getEventInfo($id){
		$query = $this->db->query('SELECT * FROM tbl_events WHERE event_id = '.$id.'');
		return $query->result();  
	}	
	
	function getEventKeywords($id){
		$query = $this->db->query('SELECT * FROM tbl_event_to_keyword INNER JOIN tbl_event_keywords AS keyword ON(
									keyword.keyword_id = tbl_event_to_keyword.keyword_id
									) WHERE event_id = '.$id.'
								');
		return $query->result();  
	}
	
	function deleteEvent($id){
		$query = mysql_query('DELETE FROM tbl_events WHERE event_id = '.$id.' AND user_id = '.$this->session->userdata('user_id').'');
		$query = mysql_query('DELETE FROM tbl_event_to_keyword WHERE event_id = '.$id.'');
	}
	
	function adminDeleteEvent($id){
		$query = mysql_query('DELETE FROM tbl_events WHERE event_id = '.$id.'');
		$query = mysql_query('DELETE FROM tbl_event_to_keyword WHERE event_id = '.$id.'');
		$query = mysql_query('DELETE FROM tbl_event_reports WHERE event_id = '.$id.'');
	}
	
	function makeEventAsOk($id){
		$query = mysql_query('DELETE FROM tbl_event_reports WHERE event_id = '.$id.'');
	}
	
	function checkKeyword($keyword){
		$query = $this->db->query('SELECT * FROM tbl_event_keywords WHERE keyword_value = "'.$keyword.'"'); 
		if(count($query->row()) == 0){
			return count($query->row()); 
		}else{
			$row = $query->row();
			return $row->keyword_id; 
		}
	}
	
	function getLastKeyword($eventId){
		$query = $this->db->query('SELECT * FROM tbl_event_keywords ORDER BY keyword_id DESC LIMIT 1'); 
		$row = $query->row();  
		return $row->keyword_id;
	}
	
	function getLastEvent(){
		$query = $this->db->query('SELECT * FROM tbl_events WHERE user_id = '.$this->session->userdata('user_id').' ORDER BY event_id DESC LIMIT 1'); 
		$row = $query->row();  
		return $row->event_id;
	}
	
	function getEventPostingType($id){
		$query = $this->db->query('SELECT event_type FROM tbl_events WHERE user_id = '.$this->session->userdata('user_id').' AND event_id = '.$id.''); 
		$row = $query->row();  
		return $row->event_type;
	}
	
	function getEventPhotos($id){
		$query = $this->db->query('SELECT * FROM tbl_event_photos WHERE event_id = '.$id.'');
		return $query->result();  
	}
	
	function getEventAudio($id){
		$query = $this->db->query('SELECT * FROM tbl_event_audio WHERE event_id = '.$id.'');
		return $query->result();  
	}
	
	function getFeaturedAudio($id){
		$query = $this->db->query('SELECT * FROM tbl_event_audio WHERE event_id = '.$id.' AND featured = 1');
		return $query->result();  
	}
	
	function getFeaturedVideo($id){
		$query = $this->db->query('SELECT * FROM tbl_event_video WHERE event_id = '.$id.' AND featured = 1');
		return $query->result();  
	}
	
	function getEventVideo($id){
		$query = $this->db->query('SELECT * FROM tbl_event_video WHERE event_id = '.$id.'');
		return $query->result();  
	}
	
	function getEventName($id){
		$query = $this->db->query('SELECT event_title FROM tbl_events WHERE user_id = '.$this->session->userdata('user_id').' AND event_id = '.$id.''); 
		$row = $query->row();  
		return $row->event_title;
	}
	
	function getSocialLink($key,$eventId){
		$query = $this->db->query("SELECT meta_value FROM tbl_event_meta WHERE meta_key = '".$key."' AND event_id = ".$eventId.""); 
		if(count($query->row()) != 0){
			$row = $query->row();
			return $row->meta_value;
		}else{
            return '';
        }
	}

    function getAllSocialLink($eventId){
        $query = $this->db->query("SELECT meta_value FROM tbl_event_meta WHERE event_id = ".$eventId."");
        if(count($query->row()) != 0){
            return $query->result();
        }else{
            return '';
        }
    }
	
	function getUserIdFromEvent($eventId){
		$query = $this->db->query('SELECT user_id FROM tbl_events WHERE event_id = '.$eventId.''); 
		$row = $query->row();  
		return $row->user_id;
	}
	
	function favouriteEvent($id){
		$query = mysql_query('INSERT INTO tbl_event_favourites VALUES(NULL,'.$id.','.$this->session->userdata('user_id').')');	
	}
	
	function unfavouriteEvent($id,$userId){
		$query = mysql_query('DELETE FROM tbl_event_favourites WHERE event_id = '.$id.' AND user_id = '.$userId.'');	
	}
	
	function unfavouriteEventAjax($id){
		$query = mysql_query('DELETE FROM tbl_event_favourites WHERE event_id = '.$id.' AND user_id = '.$this->session->userdata('user_id').'');	
	}
	
	function getUserFavourites($userId){
		//$query = $this->db->query('SELECT * FROM tbl_event_favourites,tbl_events WHERE tbl_events.event_id = tbl_event_favourites.event_id AND tbl_event_favourites.user_id = '.$userId.'');
		$query = $this->db->query("SELECT * FROM tbl_events 
			INNER JOIN tbl_event_favourites AS fav ON (fav.event_id = tbl_events.event_id)
			INNER JOIN tbl_event_categories AS cats ON(cats.cat_id = tbl_events.event_cat) 
			LEFT JOIN tbl_event_categories_sub AS sub_cats ON(tbl_events.event_sub_cat = sub_cats.sub_cat_id)
			
		WHERE fav.user_id = ".$this->session->userdata('user_id')."
		ORDER BY event_end_date ASC
		");	
			
		return $query->result();  
	}
	
	function getCountEventFavourites($eventId){
		$query = $this->db->query("SELECT count(fav_id) AS numberOfFavourites FROM tbl_event_favourites WHERE event_id = ".$eventId.""); 
		$row = $query->row();  
		return $row->numberOfFavourites;
	}
	
	function checkIfEventFavourite($eventId,$userId){
		$query = $this->db->query("SELECT count(fav_id) AS numberOfFavourites FROM tbl_event_favourites WHERE event_id = ".$eventId." AND user_id = ".$userId.""); 
		$row = $query->row();  
		return $row->numberOfFavourites;
	}
	
	function eventsLocationBreakdown(){
		$today = date('Y-m-d');		
		$query = $this->db->query("SELECT *,COUNT(*) as total FROM tbl_events WHERE event_end_date >= '".$today."' GROUP BY event_location");
		return $query->result(); 
	}
	
	function reportEvent($eventId,$userId){
		extract($_POST);
		$query = mysql_query('INSERT INTO tbl_event_reports VALUES(null, '.$eventId.', '.$userId.',"'.mysql_real_escape_string($why).'","'.mysql_real_escape_string($fullName).'","'.mysql_real_escape_string($email).'")');
	}
	
	function claimEventSubmit($id){
		extract($_POST);
		$query = mysql_query('INSERT INTO tbl_claims VALUES(null, '.$id.',"'.mysql_real_escape_string($name).'","'.mysql_real_escape_string($email).'","'.mysql_real_escape_string($phone).'","'.mysql_real_escape_string($message).'")');
	}

    function getTimeZones(){
        $query = $this->db->query('SELECT * FROM tbl_timezone');
        return $query->result();
    }

}  
