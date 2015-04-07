<?php  
	class Favourites extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->helper( array('form', 'url', 'date', 'keywords','ads','image') );
			$this->load->model(array('profile_model', 'events_model'));  
		} 
						
		public function index(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$favouriteEvents = $this->events_model->getUserFavourites($userId);
			
			$data['page_title'] = "Your Favourites";
			$data['favouriteEvents'] = $favouriteEvents;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('favourites'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}  
		
		function favourite(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventPhotos = $this->events_model->favouriteEvent($id);	
		}
		
		function unfavourite(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$userId = $this->session->userdata('user_id');
			$addEventPhotos = $this->events_model->unfavouriteEvent($id,$userId);	

            if( $this->uri->segment(4) == 'mobile' ){
                redirect('mobile/attending');
            }else{
                redirect('favourites');
            }

		}
		
	}  
?>