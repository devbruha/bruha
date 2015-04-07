<?php  
	class Updates extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
            
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->helper( array('form', 'url', 'date', 'keywords','ads','image','sort') );
			$this->load->model(array('profile_model', 'events_model'));  
		} 
						
		public function index(){

			//$userId = $this->session->userdata('user_id');
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();

            /*
            $recentEventUpdates = $this->events_model->getRecentEventUpdates(1,'event_update');
			$recentEventImages = $this->events_model->getRecentEventUpdates(1,'event_update_image');

			$in = $recentEventImages;
			$recentImages = array();

			foreach($in as $element) {
			   $id = $element->event_id;
			   if (!isset($recentImages[$id])) {
				   $recentImages[$id] = array(
					   'event_id'=>$element->event_id,
					   'event_title'=>$element->event_title,
					   'event_cat'=>$element->event_cat,
					   'meta_timestamp'=>$element->meta_timestamp,
					   'values' => array()
				   );
			   }

			   $recentImages[$id]['actions'][] = array(
			   		'meta_value' => $element->meta_value
			   );
			}

			$recentImageArray = array();
			foreach($recentImages as $recentImage){
				$image = $this->arrayToObject($recentImage);
				array_push($recentEventUpdates,$image);
			}

			usort($recentEventUpdates, "sortFunction");
            */

            $recentEventUpdates = $this->events_model->getFeaturedEvents();

			$data['page_title'] = "Your Favourites";
			$data['recentEventUpdates'] = $recentEventUpdates;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			/*---LOAD VIEWS---*/

            if(!$this->session->userdata('validated')){
                $this->load->view('header',$data);
                $this->load->view('signup');
            }else{
                $this->load->view('userheader',$data);
            }

			$this->load->view('home_view');
			$this->load->view('updates'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function favourites(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$recentEventUpdates = $this->events_model->getRecentFavouriteUpdates($userId,'event_update'); 
			$recentEventImages = $this->events_model->getRecentFavouriteUpdates($userId,'event_update_image'); 
			
			$in = $recentEventImages;
			$recentImages = array();
						
			foreach($in as $element) {
			   $id = $element->event_id;
			   if (!isset($recentImages[$id])) {
				   $recentImages[$id] = array(
					   'event_id'=>$element->event_id,
					   'event_title'=>$element->event_title,
					   'event_cat'=>$element->event_cat,
					   'meta_timestamp'=>$element->meta_timestamp,
					   'values' => array()
				   );
			   }
			
			   $recentImages[$id]['actions'][] = array(
			   		'meta_value' => $element->meta_value
			   );
			}
			
			$recentImageArray = array();
			foreach($recentImages as $recentImage){
				$image = $this->arrayToObject($recentImage);
				array_push($recentEventUpdates,$image);
			}
			
			usort($recentEventUpdates, "sortFunction");
			
			$data['page_title'] = "Your Favourites";
			$data['recentEventUpdates'] = $recentEventUpdates;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			/*---LOAD VIEWS---*/
			if(!$this->session->userdata('validated')){
				//$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
			}
			$this->load->view('home_view');
			$this->load->view('updates_favourites'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		
		function suggested(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$recentEventUpdates = $this->events_model->getRecentSuggestedUpdates($userId,'event_update'); 
			$recentEventImages = $this->events_model->getRecentSuggestedUpdates($userId,'event_update_image'); 
			
			$in = $recentEventImages;
			$recentImages = array();
						
			foreach($in as $element) {
			   $id = $element->event_id;
			   if (!isset($recentImages[$id])) {
				   $recentImages[$id] = array(
					   'event_id'=>$element->event_id,
					   'event_title'=>$element->event_title,
					   'event_cat'=>$element->event_cat,
					   'meta_timestamp'=>$element->meta_timestamp,
					   'values' => array()
				   );
			   }
			
			   $recentImages[$id]['actions'][] = array(
			   		'meta_value' => $element->meta_value
			   );
			}
			
			$recentImageArray = array();
			foreach($recentImages as $recentImage){
				$image = $this->arrayToObject($recentImage);
				array_push($recentEventUpdates,$image);
			}
			
			usort($recentEventUpdates, "sortFunction");
			
			$data['page_title'] = "Your Favourites";
			$data['recentEventUpdates'] = $recentEventUpdates;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			/*---LOAD VIEWS---*/
			if(!$this->session->userdata('validated')){
				//$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
			}
			$this->load->view('home_view');
			$this->load->view('updates_suggested'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}

        function mostViews(){
            $data = $this->map->mapSetUp();
            $menu = $this->mainmenu->getMainMenu();

            $lat = $this->input->cookie('latCookie', TRUE);
            $lng = $this->input->cookie('lngCookie', TRUE);


            $mostViewedEvents = $this->events_model->getMostViewedEvents($data['lat'],$data['lng']);
            $data['events'] = $mostViewedEvents;

            $data['page_title'] = "Showdom - Most Viewd Events";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
            $data = array_merge($data, $menu);
            if(!$this->session->userdata('validated')){
                //$this->load->view('signin');
                $this->load->view('header',$data);
                $this->load->view('signup');
            }else{
                $this->load->view('userheader',$data);
            }
            $this->load->view('home_view');
            $this->load->view('updates_mostViews');
            $this->load->view('rightbuttons');
            $this->load->view('footer');
        }
		
		function arrayToObject($array) {
			if(!is_array($array)) {
				return $array;
			}
			
			$object = new stdClass();
			if (is_array($array) && count($array) > 0) {
			  foreach ($array as $name=>$value) {
				 $name = strtolower(trim($name));
				 if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);
				 }
			  }
			  return $object; 
			}
			else {
			  return FALSE;
			}
		}
		
	}  
?>