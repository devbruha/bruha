<?php  
class Profile_model extends CI_Model {  
	function Home_model()  
	{  
		parent::__construct();
		
		$this->load->library(array('session', 'image_lib','geocode','email'));
	}  
	
	
/*----- GET USER DATA ---- */	
	function getAllUsers($searchTerm='',$offset=0,$limit=6){
		if($searchTerm != ''){
			$query = "SELECT * FROM tbl_users WHERE showdom_id LIKE '%".$searchTerm."%' || email LIKE '%".$searchTerm."%' || country LIKE '%".$searchTerm."%' || state LIKE '%".$searchTerm."%' || city LIKE '%".$searchTerm."%'  ORDER BY showdom_id ASC LIMIT ".$limit." OFFSET ".$offset.""; 
		}else{
			$query = "SELECT * FROM tbl_users ORDER BY showdom_id ASC LIMIT ".$limit." OFFSET ".$offset.""; 
		}
		
		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function searchAllUsers($searchTerm){
		$query = "SELECT * FROM tbl_users WHERE showdom_id LIKE '%".$searchTerm."%' || email LIKE '%".$searchTerm."%' || country LIKE '%".$searchTerm."%' || state LIKE '%".$searchTerm."%' || city LIKE '%".$searchTerm."%' ORDER BY showdom_id ASC LIMIT 6"; 
		$query = $this->db->query($query);
		return $query->result();  
	}
	
	function deactivateUser($id){
		$query = mysql_query('UPDATE tbl_users SET active = 0 WHERE user_id = '.$id.'');
	}
	
	function activateUser($id){
		$query = mysql_query('UPDATE tbl_users SET active = 1 WHERE user_id = '.$id.'');
	}
	
	function countUsers(){  		 	
		$query = $this->db->query("SELECT COUNT(showdom_id) AS numUsers FROM tbl_users"); 
		$row = $query->row();  
		return $row->numUsers;
	}

    function getUserInformation($id){
        $query = $this->db->query("SELECT * FROM tbl_users WHERE user_id = ".$id."");
        $row = $query->row();
        return $row;
    }

    function getShowdomId($id){
		$query = $this->db->query("SELECT showdom_id FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->showdom_id;
	}  
	
	function getUserId($showdomId){  		 	
		$query = $this->db->query("SELECT user_id FROM tbl_users WHERE showdom_id = '".$showdomId."'"); 
		$row = $query->row();  
		return $row->user_id;
	}  
	
	function getUserActiveStatus($id){
		$query = $this->db->query("SELECT active FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->active;
	}
	
	function getEmail($id){  		 	
		$query = $this->db->query("SELECT email FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->email;
	} 
	
	function getCountry($id){  		 	
		$query = $this->db->query("SELECT country FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->country;
	}  
	
	function getState($id){  		 	
		$query = $this->db->query("SELECT state FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->state;
	}  
	
	function getCity($id){  		 	
		$query = $this->db->query("SELECT city FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->city;
	}  
	
	function getLocation($id){
		$query = $this->db->query("SELECT country,state,city FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->city.' '.$row->state.' '.$row->country;
	}
	
	function getGender($id){
		$query = $this->db->query("SELECT gender FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		$gender = $row->gender;
		if($gender == 1){
			return 'Male';
		}elseif($gender == 2){
			return 'Female';
		}else{
			return 'Other';
		}
	}
	
	function getWebsite($id){
		$query = $this->db->query("SELECT website FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->website;
	}
	
	function getAccountType($id){
		$query = $this->db->query("SELECT account_type FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		if($row->account_type == 1){
			return 'Artist';
		}
		if($row->account_type == 2){
			return 'Promoter';
		}
		if($row->account_type == 3){
			return 'Venue';
		}
	}
	
	function getFullBirthday($id){
		$query = $this->db->query("SELECT birth FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->birth;
	}
	
	function getBirthYear($id){
		$query = $this->db->query("SELECT birth FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();
		$year = explode('-',$row->birth);  
		return $year[0];
	}
	
	function getBirthMonth($id){
		$query = $this->db->query("SELECT birth FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();
		$month = explode('-',$row->birth);  
		return $month[1];
	}
	
	function getBirthDay($id){
		$query = $this->db->query("SELECT birth FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();
		$day = explode('-',$row->birth);  
		return $day[2];
	}
	
	function getAge($id){
		$query = $this->db->query("SELECT birth FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		$age = $row->birth;
		
		$ageArray = explode('-',$age);
				
		$age = date('Y') - $ageArray[0]; 
		return $age; 
	}
	
	function getUserPassword($id){
		$query = $this->db->query("SELECT password FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		return $row->password;
	}
	
	function getUserImage($id){
		$query = $this->db->query("SELECT image FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		
		$showdomId = $this->getShowdomId($id);
		$showdomId = str_replace(' ','',$showdomId);
		
		if($row->image == ""){
			return base_url().'themes/showdom/images/users/user.png';
		}else{
			return base_url().'themes/showdom/images/users/'.$showdomId.'/'.$row->image;
		}
	}
	
	function getUserImageNew($id){
		$query = $this->db->query("SELECT image FROM tbl_users WHERE user_id = ".$id.""); 
		$row = $query->row();  
		
		$showdomId = $this->getShowdomId($id);
		$showdomId = str_replace(' ','',$showdomId);
		
		if($row->image == ""){
			return 'themes/showdom/images/users/user.png';
		}else{
			return 'themes/showdom/images/users/'.$showdomId.'/'.$row->image;
		}
	}
	
	function getSocialLink($key,$userId){
		$query = $this->db->query("SELECT meta_value FROM tbl_user_meta WHERE meta_key = '".$key."' AND user_id = ".$userId.""); 
		if(count($query->row()) != 0){
			$row = $query->row();
			return $row->meta_value;
		}else{ return ''; }
	}


    function getAllUserMeta($userId){
        $query = $this->db->query("SELECT * FROM tbl_user_meta WHERE user_id = ".$userId."");
        return $query->result();
    }
	
/*----- UPDATE USER DATA------*/	
	
	function updateProfile(){
		$email = mysql_real_escape_string($_POST['email']);
		$country = mysql_real_escape_string($_POST['country']);
		$state = mysql_real_escape_string($_POST['state']);
		$city = mysql_real_escape_string($_POST['city']);
		$gender = mysql_real_escape_string($_POST['gender']);
		$birthMonth = mysql_real_escape_string($_POST['birthMonth']);
		$birthDay = mysql_real_escape_string($_POST['birthDay']);
		$birthYear = mysql_real_escape_string($_POST['birthYear']);
		$website = mysql_real_escape_string($_POST['website']);
		
		$latlon = $this->geocode->setAddress(urlencode($city.' '.$state.' '.$country));
		$errors = array();
		if($latlon){
			 
		 }else{
			$errors[] = 'Your location could not geocode'; 
		 }
		
		$showdomId = $this->getShowdomId($this->session->userdata('user_id'));
		$showdomId = str_replace(' ','',$showdomId);
		 
		if($_FILES['userfile']['name'] != ''){
			$config['upload_path'] = 'themes/showdom/images/users/'.$showdomId.'/';
			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path']);
			}
			
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = TRUE;
		
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()){
				$error = array('error' => $this->upload->display_errors());
			}else{
				/*
				$data = array('upload_data' => $this->upload->data());
				
				$configResize['image_library'] = 'gd2';
				$configResize['source_image'] = $config['upload_path'].$_FILES['userfile']['name'];
				$configResize['maintain_ratio'] = TRUE;
				$configResize['master_dim'] = 'width';
				$configResize['width'] = '150';
				$configResize['height'] = '150';
				$this->load->library('image_lib', $configResize);
				$this->image_lib->resize();
				*/
				$query = mysql_query('UPDATE tbl_users SET 
					image = "'.$_FILES['userfile']['name'].'" 
					WHERE user_id = '.$this->session->userdata('user_id').'
				');
			}
			/*--- UPDATE USER IMAGE ----*/
		}
		
		/*--- UPDATE USER DATA ----*/
		if(count($errors) == 0){
		$query = mysql_query('UPDATE tbl_users SET 
			email = "'.$email.'",
			country = "'.$country.'",
			state = "'.$state.'",
			city = "'.$city.'",
			gender = "'.$gender.'",
			birth = "'.$birthYear.'-'.$birthMonth.'-'.$birthDay.'",
			website = "'.$website.'",
			user_lat = "'.$latlon[0].'",
			user_lon = "'.$latlon[1].'"
			WHERE user_id = '.$this->session->userdata('user_id').'
		');
		
		$data = array(
				'userLat' => $latlon[0],
				'userLng' => $latlon[1]
				);
		$this->session->set_userdata($data);
		
		}else{
			foreach($errors as $error){
				echo '<script>alert("'.$error.'");</script>';	
			}
		}
	}
	
	
	function updatePassword(){
		$oldPass = mysql_real_escape_string($_POST['oldPass']);
		$newPass = mysql_real_escape_string($_POST['newPass']);
		$newPass2 = mysql_real_escape_string($_POST['newPass2']);
		
		$theOldPassword = $this->getUserPassword($this->session->userdata('user_id'));
		
		if(md5($oldPass) == $theOldPassword && $newPass == $newPass2){
			$query = mysql_query('UPDATE tbl_users SET password = "'.md5($newPass).'" WHERE user_id = '.$this->session->userdata('user_id').'');
			print_r('UPDATE tbl_users SET password = "'.md5($newPass).'" WHERE user_id = '.$this->session->userdata('user_id').'');
			return TRUE;
		}else{
			return FALSE;
		} 
			
	}
	
	
	function updateSocialLinks(){
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
		
		$links = array();
		$links['googleplus-link'] = $googleplus;
		$links['facebook-link'] = $facebook;
		$links['twitter-link'] = $twitter;
		$links['linkedIn-link'] = $linkedin;
		$links['myspace-link'] = $myspace;
		$links['youtube-link'] = $youtube;
		$links['vimeo-link'] = $vimeo;
		$links['flickr-link'] = $flickr;
		$links['behance-link'] = $behance;
		$links['deviantArt-link'] = $deviantArt;
		$links['pinterest-link'] = $pinterest;
		$links['lastfm-link'] = $lastfm;
		
		foreach($links as $key => $value){
			if($value != '' && substr($value, 0, 7) != "http://"){
				$value = 'http://'.$value;
			}
			$checkQuery = mysql_query('SELECT * FROM tbl_user_meta WHERE meta_key = "'.$key.'" AND user_id = '.$this->session->userdata('user_id').'');
			if(mysql_num_rows($checkQuery) != 0){
				mysql_query('UPDATE tbl_user_meta SET meta_value = "'.$value.'" WHERE meta_key = "'.$key.'" AND user_id = '.$this->session->userdata('user_id').'');
			}else{
				mysql_query('INSERT INTO tbl_user_meta VALUES(null, '.$this->session->userdata('user_id').', "'.$key.'","'.$value.'")');
			}
		}
	}
	
	
	function disableAccount(){
		$password = mysql_real_escape_string($_POST['password']);
		$currentPassword = $this->getUserPassword($this->session->userdata('user_id'));
		if(md5($password)==$currentPassword){
			$query = mysql_query('UPDATE tbl_users SET active = 0 WHERE user_id = '.$this->session->userdata('user_id').'');
			return 'Your account has been deactivated';
		}else{
			return 'It appears your password does not match';
		}	
	}
	
	function activateAccount(){
		$password = mysql_real_escape_string($_POST['password']);
		$currentPassword = $this->getUserPassword($this->session->userdata('user_id'));
		if(md5($password)==$currentPassword){
			$query = mysql_query('UPDATE tbl_users SET active = 1 WHERE user_id = '.$this->session->userdata('user_id').'');
			return 'Your account has been activated';
		}else{
			return 'It appears your password does not match';
		}	
	}
	
	function forgotPassword(){
		$email = mysql_real_escape_string($_POST['userEmail']);
		$query = mysql_query('SELECT * FROM tbl_users WHERE showdom_id = "'.$email.'" || email = "'.$email.'"');
		$numRows = mysql_num_rows($query);
		if($numRows != 0){
			$newPass = $this->get_random_string('abcdefghijklmnopqrstuvwxyz123456789', 8);
			$row = mysql_fetch_array($query);
			$query = mysql_query('UPDATE tbl_users SET password = "'.md5($newPass).'" WHERE email = "'.$row['email'].'"');
			
			
			$this->load->library('email');
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			
			$this->email->initialize($config);
	
			$this->email->from('info@showdom.com', 'Showdom password reset');
			$this->email->to($row['email']);
			$this->email->subject('Showdom password reset');
			
			$message = '<div style="font-family: arial; font-size:14px;">';
				$message .= '<p><strong>Your new temporary showdom password: </strong>'.$newPass.'</p>';
			$message .= '</div>';
			$this->email->message($message);
			
			$this->email->send();	
			
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
	
	function profileLocationBreakdown(){
		$query = $this->db->query("SELECT *,COUNT(*) as total FROM tbl_users GROUP BY city,state,country");
		return $query->result();
	}
	
	function checkOldPassword(){
		extract($_REQUEST); 
		$query = mysql_query('SELECT * FROM tbl_users WHERE password = "'.md5($passwordOld).'" AND user_id = '.$this->session->userdata('user_id').'');
		$rows = mysql_num_rows($query);		
		if($rows == 0){
			return false;
		}else{
			return true;	
		}	
	}
	
}  
