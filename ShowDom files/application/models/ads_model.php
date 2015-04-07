<?php  
class Ads_model extends CI_Model {  
	function Events_model()  
	{  
		parent::__construct();
		$this->load->helper( array('image') );
	}
	
	
	public function getAdSizes(){
		$query = $this->db->query("SELECT * FROM tbl_ad_size");		
		return $query->result();  
	}
	
	public function countAds(){
		$today = date('Y-m-d');		
		$query = $this->db->query("SELECT COUNT(ad_id) AS numAds FROM tbl_ads WHERE ad_end_date >= '".$today."'"); 
		$row = $query->row();  
		return $row->numAds;
	}
	
	public function getActiveAds($searchTerm='',$offset=0,$limit=6){
		$today = date('Y-m-d');		
		if($searchTerm != ''){
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				WHERE ad_end_date >= '".$today."'
				AND ad_location LIKE '%".$searchTerm."%'
				ORDER BY ad_end_date ASC
				LIMIT ".$limit." OFFSET ".$offset."
			");		
		}else{
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				WHERE ad_end_date >= '".$today."'
				ORDER BY ad_end_date ASC
				LIMIT ".$limit." OFFSET ".$offset."
			");	
		}
		return $query->result();  
	}
	
	public function getAllAds($filter){
		if($filter != ''){
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				WHERE tbl_ads.ad_size = ".$filter."
				ORDER BY ad_id DESC
			");
		}else{
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				ORDER BY ad_id DESC
			");		
		}
		return $query->result();  
	}
	
	public function getUserAds($filter,$userId){
		if($filter != ''){
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				WHERE tbl_ads.ad_size = ".$filter."
				AND user_id = ".$userId."
				ORDER BY ad_id DESC
			");
		}else{
			$query = $this->db->query("SELECT * FROM tbl_ads
				INNER JOIN tbl_ad_size ON(
					tbl_ad_size.ad_size_id = tbl_ads.ad_size
				)
				WHERE user_id = ".$userId."
				ORDER BY ad_id DESC
			");		
		}
		return $query->result();  
	}
	
	public function getAdByEvent($eventId){
		$query = $this->db->query("SELECT * FROM tbl_ads
			INNER JOIN tbl_ad_size ON(
				tbl_ad_size.ad_size_id = tbl_ads.ad_size
			)
			WHERE event_id = ".$eventId."
			ORDER BY ad_id DESC
		");		
		return $query->result();  
	}
	
	public function getAd($adId){
		$query = $this->db->query("SELECT * FROM tbl_ads WHERE ad_id = ".$adId."");				
		$row = $query->row();  
		return $row;
	}
	
	public function getAdContent($adId){
		$query = $this->db->query('SELECT * FROM tbl_ads WHERE ad_id = '.$adId.'');  
		$row = $query->row();  
		return $row;
	}
	
	public function getAdLocations($adId){
		$query = $this->db->query('SELECT * FROM tbl_ad_to_location WHERE ad_id = '.$adId.'');  
		$result = $query->result();  
		return $result;
	}
	
	public function getAdKeywords($adId){
		$query = $this->db->query('
		
			SELECT * FROM tbl_event_keywords
			INNER JOIN tbl_ad_to_keyword ON(
				tbl_ad_to_keyword.ad_id = '.$adId.'
				AND tbl_ad_to_keyword.key_id = tbl_event_keywords.keyword_id
			)
			WHERE ad_id = '.$adId.'
		
		');  
		return $query->result();  
	}
	
	public function getAdCategories($adId){
		$query = $this->db->query('SELECT cat_id FROM tbl_ad_to_category WHERE ad_id = '.$adId.'');  
		return $query->result();  
	}
	
	public function getAdSubCategories($adId){
		$query = $this->db->query('SELECT sub_cat_id FROM tbl_ad_to_sub_category WHERE ad_id = '.$adId.'');  
		return $query->result();  
	}
	
	public function getRandomAdd($size){
		$query = mysql_query('
			SELECT * FROM tbl_ads WHERE ad_size = '.$size.' ORDER BY RAND() LIMIT 1
		');
		$row = mysql_fetch_array($query);
		
		return '<img class="greyBorder" src="http://localhost/showdom/'.image("themes/showdom/images/ads/".$row['ad_image']."", 260, 200).'" />';
    }
	
	public function getAllCategories(){
		$query = $this->db->query("SELECT * FROM tbl_event_categories");		
		return $query->result();  
	}
	
	public function getAllSubCategories(){
		$query = $this->db->query("SELECT * FROM tbl_event_categories_sub");		
		return $query->result();  
	}
	
	/*--- CRUD---*/
	
	public function addAd(){
		extract($_POST);
		
		
		$endDate = date('y-m-d', strtotime("+".$_POST['numberOfDays']." day", strtotime($eventStartYear.'-'.$eventStartMonth.'-'.$eventStartDay)));
		
		//if($latlon[0] != '' && $latlon[0] != ''){
			
			$query = mysql_query('
				INSERT INTO tbl_ads VALUES(null,
				"'.mysql_real_escape_string($adTitle).'",
				"",
				'.mysql_real_escape_string($adSize).', 
				"'.mysql_real_escape_string($adUrl).'",
				"",
				"",
				"", 
				"",
				0,
				"'.$eventStartYear.'-'.$eventStartMonth.'-'.$eventStartDay.'",
				"'.$endDate.'",
				'.$eventId.',
				'.$this->session->userdata('user_id').',
				0
				)
			');	
			
			
			$adId = $this->getLastAd();
			
			//$latlon = $this->geocode->setAddress(urlencode($adLocation));
			$counter = 0;
			foreach($adLocation as $loc){
				$latlon = $this->geocode->setAddress(urlencode($loc));
				if($latlon[0] != '' && $latlon[0] != ''){
					$query = mysql_query('INSERT INTO tbl_ad_to_location VALUES(null, "'.$adId.'", "'.mysql_real_escape_string($loc).'","'.$latlon[0].'","'.$latlon[1].'","'.mysql_real_escape_string($adDistance[$counter]).'")');	
				}
				$counter ++;
			}
			
			if($_FILES['adImage']['name'] != ''){
				$adImage = $_FILES['adImage']['name'];
				$config['upload_path'] = 'themes/showdom/images/ads/';
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path']);
				}
				
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('adImage')){
					$error = array('error' => $this->upload->display_errors());
				}else{

				}
			}else{
				$adImage = '';	
			}
			
			$query = 'UPDATE tbl_ads SET ad_image = "'.mysql_real_escape_string($adImage).'" WHERE ad_id = '.$adId.'';
			$query = mysql_query($query);
			
			/*--- keywords----*/
			$keywords = explode(',',$adKeywords);
			foreach($keywords as $keyword){
				$check = $this->checkKeyword($keyword);
				if($check == 0){
					$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
					$keywordid = $this->getLastKeyword($adId);
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($keywordid).')');
				}else{
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($check).')');
				}
			}
			
			/*--- categories----*/
			foreach($adCategory as $adCat){
				$addAdCategory = mysql_query('INSERT INTO tbl_ad_to_category VALUES(null,'.$adId.','.$adCat.')');
			}
			/*--- sub categories----*/
			foreach($adSubCategory as $adSubCat){
				$addAdSubCategory = mysql_query('INSERT INTO tbl_ad_to_sub_category VALUES(null,'.$adId.','.$adSubCat.')');
			}
			
		//}
	}
	
	
	
	public function updateAd(){
		extract($_POST);
			
			$query = mysql_query('UPDATE tbl_ads SET ad_title = "'.mysql_real_escape_string($adTitle).'", ad_link =  "'.mysql_real_escape_string($adUrl).'" WHERE ad_id = '.$adId.'');	
			$query = mysql_query($query);
						
						
			if($_FILES['adImage']['name'] != ''){
				$adImage = $_FILES['adImage']['name'];
				$config['upload_path'] = 'themes/showdom/images/ads/';
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path']);
				}
				
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('adImage')){
					$error = array('error' => $this->upload->display_errors());
				}else{

				}
				$query = 'UPDATE tbl_ads SET ad_image = "'.mysql_real_escape_string($adImage).'" WHERE ad_id = '.$adId.'';
				$query = mysql_query($query);
			}			
			/*--- keywords----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_keyword WHERE ad_id = '.$adId.'');
			$keywords = explode(',',$adKeywords);
			foreach($keywords as $keyword){
				$check = $this->checkKeyword($keyword);
				if($check == 0){
					$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
					$keywordid = $this->getLastKeyword($adId);
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($keywordid).')');
				}else{
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($check).')');
				}
			}
			
			/*--- categories----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_category WHERE ad_id = '.$adId.'');
			foreach($adCategory as $adCat){
				$addAdCategory = mysql_query('INSERT INTO tbl_ad_to_category VALUES(null,'.$adId.','.$adCat.')');
			}
			/*--- sub categories----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_sub_category WHERE ad_id = '.$adId.'');
			foreach($adSubCategory as $adSubCat){
				$addAdSubCategory = mysql_query('INSERT INTO tbl_ad_to_sub_category VALUES(null,'.$adId.','.$adSubCat.')');
			}
	}
	
	function renewAd(){
		extract($_POST);
		$endDate = date('y-m-d', strtotime("+".$_POST['numberOfDays']." day", strtotime($eventStartYear.'-'.$eventStartMonth.'-'.$eventStartDay)));
		
			$query = '
				UPDATE tbl_ads SET
				ad_title = "'.mysql_real_escape_string($adTitle).'",
				ad_size = '.mysql_real_escape_string($adSize).',
				ad_link =  "'.mysql_real_escape_string($adUrl).'",
				ad_location = "",
				ad_lat = "", 
				ad_lng = "",
				ad_distance = 0,
				ad_start_date = "'.$eventStartYear.'-'.$eventStartMonth.'-'.$eventStartDay.'",
				ad_end_date = "'.$endDate.'",
				status = 0
				WHERE ad_id = '.$adId.'
			';	
			
			$query = mysql_query($query);		
			
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_location WHERE ad_id = '.$adId.'');
			$counter = 0;
			foreach($adLocation as $loc){
				$latlon = $this->geocode->setAddress(urlencode($loc));
				if($latlon[0] != '' && $latlon[0] != ''){
					$query = mysql_query('INSERT INTO tbl_ad_to_location VALUES(null, "'.$adId.'", "'.mysql_real_escape_string($loc).'","'.$latlon[0].'","'.$latlon[1].'","'.mysql_real_escape_string($adDistance[$counter]).'")');	
				}
				$counter ++;
			}
				
						
			if($_FILES['adImage']['name'] != ''){
				$adImage = $_FILES['adImage']['name'];
				$config['upload_path'] = 'themes/showdom/images/ads/';
				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path']);
				}
				
				$config['allowed_types'] = 'gif|jpg|png';
				$config['overwrite'] = TRUE;
				
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('adImage')){
					$error = array('error' => $this->upload->display_errors());
				}else{

				}
				$query = 'UPDATE tbl_ads SET ad_image = "'.mysql_real_escape_string($adImage).'" WHERE ad_id = '.$adId.'';
				$query = mysql_query($query);
			}			
			/*--- keywords----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_keyword WHERE ad_id = '.$adId.'');
			$keywords = explode(',',$adKeywords);
			foreach($keywords as $keyword){
				$check = $this->checkKeyword($keyword);
				if($check == 0){
					$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
					$keywordid = $this->getLastKeyword($adId);
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($keywordid).')');
				}else{
					$keywordId = mysql_query('INSERT INTO tbl_ad_to_keyword VALUES(null,'.$adId.','.mysql_real_escape_string($check).')');
				}
			}
			
			/*--- categories----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_category WHERE ad_id = '.$adId.'');
			foreach($adCategory as $adCat){
				$addAdCategory = mysql_query('INSERT INTO tbl_ad_to_category VALUES(null,'.$adId.','.$adCat.')');
			}
			/*--- sub categories----*/
			$deleteOldKeywords = mysql_query('DELETE FROM tbl_ad_to_sub_category WHERE ad_id = '.$adId.'');
			foreach($adSubCategory as $adSubCat){
				$addAdSubCategory = mysql_query('INSERT INTO tbl_ad_to_sub_category VALUES(null,'.$adId.','.$adSubCat.')');
			}
			
		
	}
	
	function deleteAd($adId){
		$query = mysql_query('DELETE FROM tbl_ads WHERE ad_id = '.$adId.'');
	}
	
	function getLastAd(){
		$query = $this->db->query('SELECT * FROM tbl_ads ORDER BY ad_id DESC LIMIT 1'); 
		$row = $query->row();  
		return $row->ad_id;
	}
	
	function getLastUserAd($userId){
		$query = $this->db->query('SELECT * FROM tbl_ads WHERE user_id = '.$userId.' ORDER BY ad_id DESC LIMIT 1'); 
		$row = $query->row();  
		return $row->ad_id;
	}
	
	function getLastKeyword($eventId){
		$query = $this->db->query('SELECT * FROM tbl_event_keywords ORDER BY keyword_id DESC LIMIT 1'); 
		$row = $query->row();  
		return $row->keyword_id;
	}
	
	function getEventIdFromAdId($adId){
		$query = $this->db->query('SELECT event_id FROM tbl_ads WHERE ad_id = '.$adId.''); 
		$row = $query->row();  
		return $row->event_id;
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
	
	function eventAdExists($eventId){
		$query = $this->db->query("SELECT * FROM tbl_ads WHERE event_id = ".$eventId."");		
		return $query->result();  
	}
	
	function getAdType($adId){
		$query = $this->db->query('SELECT ad_size FROM tbl_ads WHERE ad_id = '.$adId.''); 
		$row = $query->row();  
		return $row->ad_size;
	}
	
	function getAdReachout($adId){
		$query = $this->db->query('
		SELECT ad_distance,ad_lat,ad_lng,ad_location FROM tbl_ad_to_location WHERE ad_id = '.$adId.'
		'); 
		return $query->result();  
	}
	
	function getAdTypeCost($adType){
		$query = $this->db->query('SELECT ad_cost FROM tbl_ad_size WHERE ad_size_id = '.$adType.''); 
		$row = $query->row();  
		return $row->ad_cost;
	}
	
	function getNumberOfDays($adId){
		
		$query = mysql_query('SELECT ad_start_date, ad_end_date FROM tbl_ads WHERE ad_id = '.$adId.'');
		$row = mysql_fetch_array($query);
		$start = strtotime($row['ad_start_date']); 
		$end = strtotime($row['ad_end_date']);
		$days =  $end-$start;
		$days = ceil($days/86400);
		return $days;
	}	
	
	function getAdCost($adId){
		$adType = $this->getAdType($adId);
		$numberOfDays = $this->getNumberOfDays($adId);
		$adCost = $this->getAdTypeCost($adType);
		$adDistance = $this->getAdReachout($adId);
		
		$howManyAds = 0;			
		$howManyUsres = 0;			
		$howManyEvents = 0;
		
		$counter = 0;
		foreach($adDistance as $ad){
			/*--- HOW MANY ADS IN THIS ADS SIZE CATEGORY----*/
			$query = "SELECT ad_id,ad_size,((ACOS(SIN(".$ad->ad_lat." * PI() / 180) * 
			SIN(ad_lat * PI() / 180) + COS(".$ad->ad_lat." * PI() / 180) * 
			COS(ad_lat * PI() / 180) * COS((".$ad->ad_lng." - ad_lng) * PI() / 180)) 
			* 180 / PI()) * 60 * 1.1515) 
			AS distance FROM tbl_ads 
			HAVING distance<=".$ad->ad_distance."
			AND ad_size = ".$adType."";
			$ads = mysql_query($query);
			
			/*--- HOW MANY USERS WITH IN THIS ADS DISTANCE----*/
			$query = "SELECT user_id,((ACOS(SIN(".$ad->ad_lat." * PI() / 180) * 
			SIN(user_lat * PI() / 180) + COS(".$ad->ad_lat." * PI() / 180) * 
			COS(user_lat * PI() / 180) * COS((".$ad->ad_lng." - user_lon) * PI() / 180)) 
			* 180 / PI()) * 60 * 1.1515) 
			AS distance FROM tbl_users 
			HAVING distance<=".$ad->ad_distance."";
			$users = mysql_query($query);
			
			/*--- HOW MANY EVENTS WITHIN THIS ADS DISTANCE----*/
			$query = "SELECT event_id,((ACOS(SIN(".$ad->ad_lat." * PI() / 180) * 
			SIN(event_lat * PI() / 180) + COS(".$ad->ad_lat." * PI() / 180) * 
			COS(event_lat * PI() / 180) * COS((".$ad->ad_lng." - event_lon) * PI() / 180)) 
			* 180 / PI()) * 60 * 1.1515) 
			AS distance FROM tbl_events 
			HAVING distance<=".$ad->ad_distance."";
			$events = mysql_query($query);
			
			$howManyAds += mysql_num_rows($ads);			
			$howManyUsres += mysql_num_rows($users);			
			$howManyEvents += mysql_num_rows($events);
		
			$counter ++;
		}
				
		$cost = ( ($howManyUsres*0.01)*($howManyAds/$howManyEvents)*$numberOfDays ) + 1;
		return $cost;
		//$distance = $adDistance[0];
		//$lat = $adDistance[1];
		//$lng = $adDistance[2];
				
		/*--- HOW MANY ADS IN THIS ADS SIZE CATEGORY----
		$query = "SELECT ad_id,ad_size,((ACOS(SIN(".$lat." * PI() / 180) * 
		SIN(ad_lat * PI() / 180) + COS(".$lat." * PI() / 180) * 
		COS(ad_lat * PI() / 180) * COS((".$lng." - ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ads 
		HAVING distance<=".$distance."
		AND ad_size = ".$adType."";
		$ads = mysql_query($query);
		
		/*--- HOW MANY USERS WITH IN THIS ADS DISTANCE----
		$query = "SELECT user_id,((ACOS(SIN(".$lat." * PI() / 180) * 
		SIN(user_lat * PI() / 180) + COS(".$lat." * PI() / 180) * 
		COS(user_lat * PI() / 180) * COS((".$lng." - user_lon) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_users 
		HAVING distance<=".$distance."";
		$users = mysql_query($query);
		
		/*--- HOW MANY EVENTS WITHIN THIS ADS DISTANCE----
		$query = "SELECT event_id,((ACOS(SIN(".$lat." * PI() / 180) * 
		SIN(event_lat * PI() / 180) + COS(".$lat." * PI() / 180) * 
		COS(event_lat * PI() / 180) * COS((".$lng." - event_lon) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_events 
		HAVING distance<=".$distance."";
		$events = mysql_query($query);
		
		$howManyAds = mysql_num_rows($ads);			
		$howManyUsres = mysql_num_rows($users);			
		$howManyEvents = mysql_num_rows($events);
		
		/*--- calculations ----
		
		$numberOfDays = 7;
		$howManyAds = 40;
		$howManyUsres = 1500;
		$howManyEvents = 500;
		
	//	print_r('base price: '.$adCost.'   ');
	//	print_r('Days: '.$numberOfDays.'   ');
	//	print_r('Ads: '.$howManyAds.'    ');
	//	print_r('Users: '.$howManyUsres.'    ');
	//	print_r('Events: '.$howManyEvents.'    ');
		//numberOfDays	
		
		$pricePerDay = ($howManyAds / $howManyUsres)*($howManyUsres / $howManyEvents)*($howManyEvents / $howManyUsres);
	//		print_r('Per Day: '.number_format($pricePerDay,2).'  '); 	
		$total = ( number_format($pricePerDay,2) * $numberOfDays) + number_format($adCost,2);
	//		print_r('Total: '.number_format($total,2).'  '); 	
			
		
		/*
		$inflation = $howManyAds * ($adCost/20);
			print_r(number_format($inflation,2).'  '); 
		
		$withAds = ($howManyAds * $inflation) / 20;
			print_r(number_format($withAds,2).'  '); 
		
		$withUsers = ($withAds * $howManyUsres)  / 100;
			print_r(number_format($withUsers,2).'  '); 
		
		$withEvents = ($withUsers * $howManyEvents)  / 20;
			print_r(number_format($withEvents,2).'  '); 
		
		$total = ($withEvents * $numberOfDays);
			print_r(number_format($total,2)); 
		*/
	}	
	
	function adsLocationBreakdown(){
		$today = date('Y-m-d');		
		$query = $this->db->query("SELECT *,COUNT(*) as total FROM tbl_ads WHERE ad_end_date >= '".$today."' GROUP BY ad_location");
		return $query->result(); 
	}
	 
	function adPaymentComplete($adId){
		$query = mysql_query('UPDATE tbl_ads SET status = 1 WHERE ad_id = '.$adId.'');
	}
	
	function checkPromoCode($code){
		$query = mysql_query('SELECT * FROM tbl_promo_codes WHERE code_value = "'.$code.'" AND code_used = 0');
		if(mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query);
			mysql_query('UPDATE tbl_promo_codes SET code_used = 1 WHERE code_id = '.$row['code_id'].'');
			return true;	
		}
	}

    function getPromoCodes(){
        $query = $this->db->query("SELECT * FROM tbl_promo_codes");
        return $query->result();
    }

    function createPromoCodes(){
        $howMany = $_POST['numCodes'];
        for ($i = 1; $i <= $howMany; $i++) {
            $getLastId=mysql_query('SELECT * FROM tbl_promo_codes ORDER BY code_id DESC LIMIT 1');
            if(mysql_num_rows($getLastId) == 0){
                $lastId = 0;
            }else{
                $row = mysql_fetch_array($getLastId);
                $lastId = $row['code_id'];
            }

            $randomCode = 'SHOW'.$lastId.$this->get_random_string('ABCDEFGHIJKLMNOPQRSTUV0123456789',16);
            $query = mysql_query('INSERT INTO tbl_promo_codes VALUES(null, "'.$randomCode.'",0)');
        }
    }

    function get_random_string($valid_chars, $length){
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++){
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $random_string .= $random_char;
        }
        return $random_string;
    }

    function deleteCode($id){
        $query = $this->db->query('DELETE FROM tbl_promo_codes WHERE code_id = '.$id.'');
    }
}  