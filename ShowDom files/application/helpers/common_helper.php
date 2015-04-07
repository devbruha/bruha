<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function mapSetUp(){
	if($this->session->userdata('is_geocoded') == TRUE ){
		$data['lat'] = $this->session->userdata('userLat');
		$data['lng'] = $this->session->userdata('userLng');
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
		if($ip = '127.0.0.1'){
			$ip = '66.209.58.174';
		}
		
		$latLng = $this->geocode->geocode_ip($ip);
		
		/*--- add new lat long data to session ---*/
		$newdata = array(
		   'userLat'  => $latLng[0],
		   'userLng'     => $latLng[1],
		   'is_geocoded' => TRUE
		);
		$this->session->set_userdata($newdata);
		
		/*--- Add session data to data array ready tp pass to view ---*/
		$data['lat'] = $latLng[0];
		$data['lng'] = $latLng[1];
	}
	
	/*---- GET EVENTS OBJECT---*/
	$events = json_encode($this->events_model->getEvents());
	$data['events'] = $events; 
}

