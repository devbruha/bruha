<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model(array('events_model', 'login_model', 'home_model'));
		$this->load->library(array('session', 'geocode', 'map', 'mainmenu','geocode','user'));
		$this->load->helper('form','header','cookie');
		$this->load->helper('url');

	}
	
	public function index(){
		// Load our view to be displayed
		// to the user
		$this->load->view('login_view');
	}
	
	public function checkEmailAddress(){
		$validate = $result = $this->login_model->checkEmailAddress();
		echo json_encode($validate);
	}
	
	public function checkShowdomId(){
		$validate = $result = $this->login_model->checkShowdomIdValidate();
		echo json_encode($validate);
	}
	
	public function process(){
		// Load the model
		$this->load->model('login_model');
		// Validate the user can login
		$result = $this->login_model->validate();
		// Now we verify the result
		if(!$result){
            $this->session->set_flashdata('loginFail', 'Login information was incorrect.');
			redirect('home');
		}else{
			// If user did validate, 
			// Send them to members area
			redirect('home');
		}
	}
	
	public function logout(){
        $this->session->unset_userdata('validated');
		$this->session->sess_destroy();
		redirect('');
	}
	
	
	public function signup(){
		$result = $this->login_model->signup();
		$data = $this->map->mapSetUp();
		$menu = $this->mainmenu->getMainMenu();
        $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
        $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
		$data = array_merge($data, $menu);
		if($result){
			$msg['message'] = $result;
		}else{
			$msg['message'] = 'Thank you. You can now log in.';
			echo '<script>alert("'.$msg['message'].'");</script>';
		}
		
		$data['page_title'] = "Showdom Sign Up"; 
		
		$this->load->view('header',$data);
		$this->load->view('home_view');
		
		if(!$this->session->userdata('validated')){
			$this->load->view('signup',$msg); 
		}else{
			redirect('home'); 
		}
		
		$this->load->view('footer');
		
	}
	
}
?>