<?php  
	class Signup extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','cookie'));
			$this->load->helper('form');
        	$this->load->helper('url');
		
			//$this->check_isvalidated();
		} 
				
		public function index(){									  
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Showdom Home Page";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			$this->load->view('header',$data);
			$this->load->view('home_view');
			
			if(!$this->session->userdata('validated')){
				$this->load->view('signup'); 
			}else{

			}
			
			$this->load->view('footer');
		}  
		
		
	}  
?>