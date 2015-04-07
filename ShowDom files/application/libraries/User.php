<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user {
    private $CI;
    function __construct(){
		$this->CI =& get_instance();
		
		$this->CI->load->model(array('login_model'));
		$this->CI->load->library(array('session', 'geocode'));
	}
    
    public function checkLogin(){	

		if($this->CI->session->userdata('user_id')){ 
		}else{
			redirect('home');	
		}
    }
	
	
	public function adminOnly(){	
		if($this->CI->session->userdata('access') == 659){ 
		
		}else{
			redirect('home');	
		}
    }
    

}

