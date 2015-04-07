<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map {
	private $CI;
    function __construct(){
		//parent::__construct();
		$this->CI =& get_instance();
		$this->CI->load->model('events_model');
		$this->CI->load->library(array('session', 'geocode'));
		$this->CI->load->helper( array('cookie') );
	}
    
    public function mapSetUp(){
		$data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
		$data['rememberPassword'] = get_cookie('rememberPassword', FALSE);

		$data['latCookie'] = get_cookie('latCookie', FALSE);
		$data['lngCookie'] = get_cookie('lngCookie', FALSE);
        $data['zoomCookie'] = get_cookie('zoomCookie', FALSE);
        $data['showForCookie'] = get_cookie('showForCookie', FALSE);

        if(!isset($data['zoomCookie']) || $data['zoomCookie'] == ''){
            $data['zoomCookie'] = 10;
        }

        if(!isset($data['showForCookie']) || $data['showForCookie'] == ''){
            $data['showForCookie'] = '';
        }

		if(isset($data['latCookie']) && $data['latCookie'] != ''){
            $newdata = array(
                'userLat'  => $data['latCookie'],
                'userLng'     => $data['lngCookie'],
                'is_geocoded' => TRUE
            );
            $this->CI->session->set_userdata($newdata);

            $data['lat'] = $data['latCookie'];
			$data['lng'] = $data['lngCookie'];
			if(!$this->CI->session->userdata('is_geocoded') == TRUE ){
				$ip = $_SERVER['REMOTE_ADDR'];

				$latLng = $this->CI->geocode->geocode_ip($ip);
				/*--- add new lat long data to session ---*/
				$newdata = array(
				   'userLat'  => $latLng[0],
				   'userLng'     => $latLng[1],
				   'is_geocoded' => TRUE
				);
				$this->CI->session->set_userdata($newdata);
				
				/*--- Add session data to data array ready tp pass to view ---*/
				$data['lat'] = $latLng[0];
				$data['lng'] = $latLng[1];
			}
			
		}else{

			if($this->CI->session->userdata('is_geocoded') == TRUE && $this->CI->session->userdata('userLat') != ''){

				$data['lat'] = $this->CI->session->userdata('userLat');
				$data['lng'] = $this->CI->session->userdata('userLng');
				//print_r($this->session->userdata('userLat'));
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];

				//if($ip = '127.0.0.1'){
				//	$ip = '66.209.58.174';
				//}
				
				$latLng = $this->CI->geocode->geocode_ip($ip);
				/*--- add new lat long data to session ---*/

				$newdata = array(
				   'userLat'  => $latLng[0],
				   'userLng'     => $latLng[1],
				   'is_geocoded' => TRUE
				);
                $this->CI->session->set_userdata($newdata);
                //print_r($this->CI->session->userdata('userLat'));
				/*--- Add session data to data array ready tp pass to view ---*/
                $cookie = array(
                    'name'   => 'latCookie',
                    'value'  => $latLng[0],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->CI->input->set_cookie($cookie);

                $cookie = array(
                    'name'   => 'lngCookie',
                    'value'  => $latLng[1],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->CI->input->set_cookie($cookie);
                //return $this->mapSetUp();
                //return false;

				$data['lat'] = $latLng[0];
				$data['lng'] = $latLng[1];
			}
            //print_r($data['lat'].' is lat');
		}
		
		
		/*---- GET EVENTS OBJECT---*/
		//$events = json_encode($this->CI->events_model->getEvents());
		//$data['events'] = $events; 
		
		return $data; 
			
    }

}

