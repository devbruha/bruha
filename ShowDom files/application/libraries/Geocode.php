<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geocode {
	
	private $lattitude = '';
    private $longitude = '';
    
    function __construct(){
    
	}
    
    public function setAddress($address){
        $geocode            = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        $output             = json_decode($geocode);

        $this->lattitude    = $output->results[0]->geometry->location->lat;
        $this->longitude    = $output->results[0]->geometry->location->lng;

        $getTimeZone = file_get_contents('https://maps.googleapis.com/maps/api/timezone/json?timestamp='.strtotime(date('c')).'&location='.$this->lattitude.','.$this->longitude.'&sensor=false');
        $timeZone = json_decode($getTimeZone);

		$latLng = array();
		$latLng[] = $this->lattitude;
		$latLng[] = $this->longitude;
        $latLng[] = $timeZone->timeZoneId;
		return($latLng);
    }
    
    public function getLattitude(){
        return $this->lattitude;
    }
    
    public function getLongitude(){
        return $this->longitude;
    }

	 public function geocode_ip($ip){
		//$geocode = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=99ebae8b0847b70cd51646c965570893c4d72ed1fbb396ac87cc2bcc565627f4&ip='.$ip.'&format=json');
        $geocode = file_get_contents('http://services.ipaddresslabs.com/iplocation/locateip?key=SAK7S683Q9NXLCQTZ4ZZ&ip='.$ip.'');
		//$output = json_decode($geocode);

        $xmlObj = simplexml_load_string($geocode);

        $this->lattitude    = $xmlObj->geolocation_data->latitude;
        $this->longitude    = $xmlObj->geolocation_data->longitude;
		$latLng = array();
		$latLng[] = $this->lattitude;
		$latLng[] = $this->longitude;
		return($latLng);
    }


}

