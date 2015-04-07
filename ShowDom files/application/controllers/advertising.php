<?php  
	class Advertising extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu'));
			$this->load->helper( array('form', 'url', 'date','image','ads') );
			$this->load->model(array('content_model'));  
        	$this->load->helper('url');
		} 
		
		public function index(){
						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Showdom Home Page";
			$content = $this->content_model->getContent(4);
			$data['content'] = $content;
			$contentSection = $this->content_model->getContentSections(4);
			$data['contentSection'] = $contentSection;
			$data = array_merge($data, $menu);

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			
			if(!$this->session->userdata('validated')){
				//$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('rightbuttons');
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
				$this->load->view('rightbuttons');
			}
			
			$this->load->view('advertising');
			$this->load->view('home_view');
			$this->load->view('footer');
		}  
		
	}  
?>