<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainmenu {
    private $CI;
    function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->model('events_model');
		$this->CI->load->library(array('session', 'geocode'));
	}
    
    public function getMainMenu(){	
		if(!$this->CI->session->userdata('validated')){
			//$data['menu_item'][0] = "Sign Up";
			//$data['menu_url'][0] = "index.php/signup";
			
			$data['menu_item'][0] = "";
			$data['menu_url'][0] = "";	
			
		}else{
			$data['menu_item'][0] = "MY PROFILE & EVENTS";	
			$data['menu_url'][0] = "index.php/profile";	

			//$data['menu_item'][1] = "PROMOTE";
			//$data['menu_url'][1] = "index.php/ads";

            //$data['menu_item'][1] = "ATTENDING";
            //$data['menu_url'][1] = "index.php/favourites";

            $data['menu_item'][1] = "SIGN OUT";
			$data['menu_url'][1] = "index.php/login/logout/";
			
			$data['welcome'] = $this->CI->session->userdata('showdom_id');
			
		}
		
		return $data; 
		
    }
    

}

