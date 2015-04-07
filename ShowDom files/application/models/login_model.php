<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function validate(){
		$this->load->helper('cookie');
		// grab user input
		$username = $this->security->xss_clean($this->input->post('showdomid'));
		$password = $this->security->xss_clean($this->input->post('password'));

		// Prep the query
		$this->db->where('showdom_id', $username);
		$this->db->where('password', md5($password));
		// Run the query
		$query = $this->db->get('tbl_users');
		// Let's check if there are any results
		if($query->num_rows == 1){

			if(isset($_POST['rememberMe']) && $_POST['rememberMe'] == 1){
				//setcookie("rememberUsername", $username,2592000 + time(), '/showdom/',".netgainseo-client.com", 1);
				//setcookie("rememberPassword", $password,2592000 + time(), '/showdom/',".netgainseo-client.com", 1);
				//print_r('test');
				$cookie = array(
				  'name'   => 'rememberUsername',
				  'value'  => $username,
				  'expire' => 86500000, 
				  'secure' => FALSE
				);
				$this->input->set_cookie($cookie);
				
				$cookie = array(
				  'name'   => 'rememberPassword',
				  'value'  => $password,
				  'expire' => 86500000, 
				  'secure' => FALSE
				);
				$this->input->set_cookie($cookie);
				
			}else{ 
				$cookie = array(
				  'name'   => 'rememberUsername',
				  'value'  => '',
				  'expire' => 86500, 
				  'secure' => FALSE
				);
				$this->input->set_cookie($cookie);
				
				$cookie = array(
				  'name'   => 'rememberPassword',
				  'value'  => '',
				  'expire' => 86500, 
				  'secure' => FALSE
				);
				$this->input->set_cookie($cookie);
				//print_r('fail');
			}
			//print_r($_COOKIE['rememberUsername']);
			
			
			// If there is a user, then create session data
			$row = $query->row();
			$data = array(
					'user_id' => $row->user_id,
					'showdom_id' => $row->showdom_id,
					'userLat' => $row->user_lat,
					'userLng' => $row->user_lon,
					'access' => $row->access,
					'validated' => true,
					'is_geocoded' => true
					);
			$this->session->set_userdata($data);
			return true;
		}
		// If the previous process did not validate
		// then return false.
		return false;
	}
	
	public function signup(){
		$this->load->library('geocode');
		$this->load->model('scraper_model');
		
		$showdomid = $this->security->xss_clean($this->input->post('showdomid'));
		$accountType = $this->security->xss_clean($this->input->post('accountType'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$password2 = $this->security->xss_clean($this->input->post('password2'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$email2 = $this->security->xss_clean($this->input->post('email2'));
		$country = $this->security->xss_clean($this->input->post('country'));
		$state = $this->security->xss_clean($this->input->post('state'));
		$city = $this->security->xss_clean($this->input->post('city'));
		$gender = $this->security->xss_clean($this->input->post('gender'));
		$birthdayMonth = $this->security->xss_clean($this->input->post('birthdayMonth'));
		$birthdayDay = $this->security->xss_clean($this->input->post('birthdayDay'));
		$birthdayYear = $this->security->xss_clean($this->input->post('birthdayYear'));
				
		$birthdayString = $birthdayYear.'-'.$birthdayMonth.'-'.$birthdayDay;
		
		$errors = array();
		if($this->checkShowdomId($showdomid) == FALSE){
			$errors = 'Your showdom id has already been used';
		}
		if($this->checkEmail($showdomid) == FALSE){
			$errors = 'Your email has already been used';
		}
		if($password != $password2){
			$errors = 'Your passwords do not match';
		}
		
		$latlon = $this->geocode->setAddress(urlencode($city.' '.$state.' '.$country));
		 
		// print_r($latlon);
		 if($latlon){
			 
		 }else{
			$errors = 'Your location could not geocode'; 
		 }
		 
		if(count($errors) == 0){
			$query = mysql_query('INSERT INTO tbl_users VALUES(null, 
			"'.mysql_real_escape_string($showdomid).'", 
			"'.mysql_real_escape_string($email).'", 
			'.mysql_real_escape_string($accountType).', 
			"'.md5(mysql_real_escape_string($password)).'", 
			"'.mysql_real_escape_string($country).'",
			"'.mysql_real_escape_string($state).'",
			"'.mysql_real_escape_string($city).'",
			'.mysql_real_escape_string($gender).',
			"'.mysql_real_escape_string($birthdayString).'",
			"",
			"",
			"'.$latlon[0].'",
			"'.$latlon[1].'",
			1,
			0)'); 
			
			//$emailsent = $this->scraper_model->sendemail();
			//echo $emailsent;
		}else{
			return $errors;	
		}
	} 
	
	public function checkEmail($email){
		$query = mysql_query('SELECT * FROM tbl_users WHERE email = "'.$email.'"');
		if(mysql_num_rows($query) != 0){
			return FALSE;	
		}else{
			return TRUE;	
		}
	}
	public function checkShowdomId($showdomid){
		$query = mysql_query('SELECT * FROM tbl_users WHERE showdom_id = "'.$showdomid.'"');
		if(mysql_num_rows($query) != 0){
			return FALSE;	
		}else{
			return TRUE;	
		}
	}
	
	
	function checkEmailAddress(){
		extract($_REQUEST);
		$query = mysql_query('SELECT * FROM tbl_users WHERE email = "'.mysql_real_escape_string($email).'"');
		$rows = mysql_num_rows($query);
		
		if($rows == 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function checkShowdomIdValidate(){
		extract($_REQUEST);
		$query = mysql_query('SELECT * FROM tbl_users WHERE showdom_id = "'.mysql_real_escape_string($showdomid).'"');
		$rows = mysql_num_rows($query);
		
		if($rows == 0){
			return true;
		}else{
			return false;	
		}
	}
	
}
