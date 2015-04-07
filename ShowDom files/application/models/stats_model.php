<?php  
class Stats_model extends CI_Model {  
	function Events_model()  
	{  
		parent::__construct();
		$this->load->library(array('session', 'image_lib','geocode'));
	}
	
	function addStat($id,$userId,$statType){ 
	
		if($userId != 0){
			$location = $this->getUserLocation($userId);
		}else{
			$location = $this->getAddressFromLatLon($this->session->userdata('userLat'),$this->session->userdata('userLng'));
		}
		
		$query = mysql_query('INSERT INTO tbl_stats VALUES(null, 
		'.$id.',
		'.$userId.',
		"'.$statType.'",
		"'.$this->session->userdata('userLat').'",
		"'.$this->session->userdata('userLng').'",
		"'.$location.'"
		)');	

	}
	
	function deleteStat($id,$userId,$statType){ 
		$query = mysql_query('DELETE FROM tbl_stats WHERE user_id = '.$userId.' AND id = '.$id.' AND stat_type = "'.$statType.'"');	
	}
	
	function getUserLocation($userId){ 
		$query = mysql_query('SELECT city,state,country FROM tbl_users WHERE user_id = '.$userId.'');
		$row = mysql_fetch_array($query);
		return $row['city'].' '.$row['state'].' '.$row['country'];
	} 
	
	function getAddressFromLatLon($lat,$lon){
		$url = 'http://maps.google.com/maps/geo?q='.$lat.','.$lon.'&output=json&sensor=false';
		//print_r($url);
		$data = @file_get_contents($url);
		$jsondata = json_decode($data,true);
		if(is_array($jsondata )&& $jsondata ['Status']['code']==200){
			  $country = $jsondata ['Placemark'][0]['AddressDetails']['Country']['CountryName'];
			  $city = $jsondata ['Placemark'][0]['AddressDetails']['Country']['AdministrativeArea']['SubAdministrativeArea']['Locality']['LocalityName'];
			  $state = $jsondata ['Placemark'][0]['AddressDetails']['Country']['AdministrativeArea']['AdministrativeAreaName'];
			  			  
			  return $city.' '.$state.' '.$country;
		}else{

		}
	}
	
	function getTotalStats($id,$statType){
		//print_r("SELECT COUNT(*) as total FROM tbl_stats WHERE event_id = ".$eventId." AND stat_type = '".$statType."'");
		$query = $this->db->query("SELECT COUNT(*) as total FROM tbl_stats WHERE id = ".$id." AND stat_type = '".$statType."'");
		//print_r("SELECT COUNT(*) as total FROM tbl_stats WHERE id = ".$id." AND stat_type = '".$statType."'");
		$row = $query->row();  
		return $row;  
	}
	
	function getTotalStatsBreakdown($id,$statType){
		$query = $this->db->query("SELECT *,COUNT(*) as total FROM tbl_stats WHERE id = ".$id." AND stat_type = '".$statType."' GROUP BY user_location");
		return $query->result();
	}
	
	function totalComments($eventId){
		$query = $this->db->query("SELECT COUNT(*) as total FROM tbl_event_meta WHERE event_id = ".$eventId." AND meta_key = 'event_comment'");
		$row = $query->row();  
		return $row;  
	}
	
	
}  