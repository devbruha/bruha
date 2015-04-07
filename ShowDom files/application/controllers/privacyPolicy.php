<?php  
	class PrivacyPolicy extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu'));
			$this->load->helper( array('form', 'url', 'date','image','ads') );
        	$this->load->helper('url');
			$this->load->model(array('content_model'));  
		} 
		
		public function index(){
						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Showdom Home Page";
			$content = $this->content_model->getContent(6);
			$data['content'] = $content;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			
			if(!$this->session->userdata('validated')){
				//$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('rightbuttons');
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
				$this->load->view('rightbuttons');
			}
			
			$this->load->view('privacyPolicy');
			$this->load->view('home_view');
			$this->load->view('footer');
		}  
		
	}  
?>