<?php  
	class Ads extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->helper( array('form', 'url', 'date','image','ads') );
			$this->load->model(array('profile_model', 'events_model', 'ads_model', 'stats_model'));  
		} 
						
		public function index(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			
			if($this->uri->segment(3)){
				$filter = $this->uri->segment(3);	
			}else{
				$filter = '';
			}
						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data['page_title'] = "Ads";
			$data = array_merge($data, $menu);
			
			
			/*--- AD INFO----*/
			$adSizes = $this->ads_model->getAdSizes();
			$data['adSizes'] = $adSizes; 
			
			//if($this->session->userdata('access') == '659'){
			//	$ads = $this->ads_model->getAllAds($filter);
			//	$data['ads'] = $ads; 
			//}else{
				$userId = $this->session->userdata('user_id');
				$ads = $this->ads_model->getUserAds($filter,$userId);
				$data['ads'] = $ads; 
			//}
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ads'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}  
		
		public function add(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Add Ad";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$adSizes = $this->ads_model->getAdSizes();
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			$userId = $this->session->userdata('user_id');
			
			$data['adSizes'] = $adSizes; 
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			$data['userId'] = $userId;
			$data['access'] = $this->session->userdata('access'); 
			
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('add_ad');
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		public function adPayment(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			
			if($this->uri->segment(3)){
				$adId = $this->uri->segment(3);	
			}else{
				$adId = $this->ads_model->getLastUserAd($userId);
			}
			 						
			$data = $this->map->mapSetUp();			
			$menu = $this->mainmenu->getMainMenu();
						
			$data['page_title'] = "Ad Payment";
			$data = array_merge($data, $menu);
			
			$adSizes = $this->ads_model->getAdSizes();
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$getAdKeywords = $this->ads_model->getAdKeywords($adId);
			$getAdContent = $this->ads_model->getAdContent($adId);
			$getAdCategories = $this->ads_model->getAdCategories($adId);
			$getAdSubCategories = $this->ads_model->getAdSubCategories($adId);
			
			$getAdLocations = $this->ads_model->getAdLocations($adId);
			
			$getAdCost = $this->ads_model->getAdCost($adId);
			
			$data['adSizes'] = $adSizes; 
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			
			$data['keywords'] = $getAdKeywords;
			$data['ad'] = $getAdContent; 
			$data['getAdLocations'] = $getAdLocations;
			
			$data['getAdCategories'] = $getAdCategories; 
			$data['getAdSubCategories'] = $getAdSubCategories;
			$data['getAdCost'] = $getAdCost;

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			
			if($this->uri->segment(4)){
				$data['message'] = 'The code you have entered does not match our records';
			}
						
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ad_payment'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		public function payWithCode(){
			extract($_POST);
			$codeGood = $this->ads_model->checkPromoCode($promocode);	
			if($codeGood == false){
				redirect('ads/adPayment/'.$item_number.'/codeFail');
			}else{
				redirect('ads/adPaymentComplete/'.$item_number.'');
			}
		}
		
		public function payWithCodeFromEvent(){
			extract($_POST);
			$codeGood = $this->ads_model->checkPromoCode($promocode);	
			if($codeGood == false){
				redirect('events/eventPayment/'.$event_id.'/codeFail');
			}else{ 
				redirect('events/eventPaymentComplete/'.$event_id.'?item_number='.$item_number.'');
			}
		}
		
		public function adPaymentComplete(){
			$this->user->checkLogin();
			
			if(isset($_GET['item_number'])){
				$adId = $_GET['item_number'];
			}elseif($this->uri->segment(3) != ''){
				$adId = $this->uri->segment(3);
			}

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$updateAdStatus = $this->ads_model->adPaymentComplete($adId);
			
			
			$data = $this->map->mapSetUp();			
			$menu = $this->mainmenu->getMainMenu();
						
			$data['page_title'] = "Ad Payment Complate";
			$data = array_merge($data, $menu);
			
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ad_payment_complete'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
			
		}
		
		public function activateAd(){
			
		}
		
		public function edit(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			$adid = $this->uri->segment(3);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Add Ad";
			
			$adSizes = $this->ads_model->getAdSizes();
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$getAdKeywords = $this->ads_model->getAdKeywords($adid);
			$getAdContent = $this->ads_model->getAdContent($adid);
			
			$getAdCategories = $this->ads_model->getAdCategories($adid);
			$getAdSubCategories = $this->ads_model->getAdSubCategories($adid);
			
			$getAdLocations = $this->ads_model->getAdLocations($adid);
			
			$data['adSizes'] = $adSizes; 
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			
			$data['keywords'] = $getAdKeywords;
			$data['ad'] = $getAdContent; 
			
			$data['getAdCategories'] = $getAdCategories; 
			$data['getAdSubCategories'] = $getAdSubCategories; 
			$data['getAdLocations'] = $getAdLocations;

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ad_edit'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		public function renewAd(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			$adid = $this->uri->segment(3);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Add Ad";
			
			$adSizes = $this->ads_model->getAdSizes();
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$getAdKeywords = $this->ads_model->getAdKeywords($adid);
			$getAdContent = $this->ads_model->getAdContent($adid);
			
			$getAdCategories = $this->ads_model->getAdCategories($adid);
			$getAdSubCategories = $this->ads_model->getAdSubCategories($adid);
			
			$getAdLocations = $this->ads_model->getAdLocations($adid);
			
			
			$data['adSizes'] = $adSizes; 
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			
			$data['keywords'] = $getAdKeywords;
			$data['ad'] = $getAdContent; 
			
			$data['getAdCategories'] = $getAdCategories; 
			$data['getAdSubCategories'] = $getAdSubCategories; 
			$data['getAdLocations'] = $getAdLocations;

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ad_renew'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		public function stats(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			
			$adId = $this->uri->segment(3);	
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*--STAT INFORMATION--*/
			$ad = $this->ads_model->getAd($adId);
			$data['ad'] = $ad; 
			
			$totalViews = $this->stats_model->getTotalStats($adId,'ad-view');	
			$totalViewsBreakdown = $this->stats_model->getTotalStatsBreakdown($adId,'ad-view');
			$totalClicks = $this->stats_model->getTotalStats($adId,'ad-click');	
			$totalClicksdown = $this->stats_model->getTotalStatsBreakdown($adId,'ad-click');
            $adLocation = $this->ads_model->getAdReachout($adId);
			$adSizes = $this->ads_model->getAdSizes();
			
			$data['adSizes'] = $adSizes; 
			$data['totalViews'] = $totalViews;
			$data['totalViewsBreakdown'] = $totalViewsBreakdown;
			$data['totalClicks'] = $totalClicks;
			$data['totalClicksdown'] = $totalClicksdown;
            $data['adLocation'] =$adLocation;

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data['page_title'] = "Ad Statistics";
			
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('ad_stats'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function addAd(){
			$this->user->checkLogin();
			
			$adAdd = $this->ads_model->addAd();
			
			if(isset($_POST['redirect'])){
				redirect($_POST['redirect']);
			}else{
				redirect('ads');	
			}
			
		}
		
		function updateAd(){
			$this->user->checkLogin();
			
			$adAdd = $this->ads_model->updateAd();
			if(isset($_POST['redirect'])){
				redirect($_POST['redirect']);
			}else{
				redirect('ads');	
			}
		}
		
		function renewAdSubmit(){
			$this->user->checkLogin();
			
			$adAdd = $this->ads_model->renewAd();
			if(isset($_POST['redirect'])){
				redirect($_POST['redirect']);
			}else{
				redirect('ads');	
			}
		}
		
		function delete(){
			$this->user->checkLogin();
			//$this->user->adminOnly();
			
			$adid = $this->uri->segment(3);
			$adAdd = $this->ads_model->deleteAd($adid);
			redirect('ads');
		}
		
		function clickAd(){
			$adid = $this->uri->segment(3);
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}else{
				$userId = 0;
			}
			$this->stats_model->addStat($adid,$userId,'ad-click');
			redirect($_GET['url']);
		}
		
		function getRandomAd(){
			echo getRandomAd(1,0,0,array());
		}
		
		function getRandomSliderAd(){
			echo getRandomAd(1,0,0,array(),'ad-slider-view');
		}
		
		function adBreakdown(){						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
						
			$data['page_title'] = "Ad Breakdown";
			$data = array_merge($data, $menu);

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('adBreakdown'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
	}  
?>