<?php  
	class Scraper_controller extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu'));
			$this->load->helper( array('form', 'url', 'date','image','ads') );
			$this->load->model(array('content_model'));  
        	$this->load->helper('url');
			$this->load->helper('cookie');
		} 
		
		public function index(){
						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$data['page_title'] = "Showdom Home Page";
			
			//here is where we should pass the buttons to the view to call the scraping/adding functions
			//$content = $this->content_model->getContent(5);
			//$content = $username;		
			$data['content'] = $content;
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

		
			$this->load->view('scraper');
			$this->load->view('home_view');
			$this->load->view('footer');
		}
		public function crawlBlogTO(){
		
		$userlogin = $this->session->userdata('showdom_id');
		
		//change this to the ID we use as the priveleged user that can add scraped events
		if ($userlogin == "showdom") {
			//loads the scraper model
			$this->load->model('blogto_scraper');
			
			//calls the scraper
			$this->blogto_scraper->blogto_main();
				
			$content = "I for one welcome to our robot crawling overlords";
			$data['content'] = $content;
			//loads all the views
			if(!$this->session->userdata('validated')){
				$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('rightbuttons');
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
				$this->load->view('rightbuttons');
			}
			
			$this->load->view('scraper');
			$this->load->view('home_view');
			$this->load->view('footer');
		}
			else{
				echo "HALT CITIZEN!";
			}
		}
		
		public function crawlJustshows(){
		
		
		$userlogin = $this->session->userdata('showdom_id');
		
		if ($userlogin == "showdom") {
		
			$this->load->model('justshows_scraper');
			
			$content = $this->justshows_scraper->justshows_main();
			
			$data['content'] = $content;
			
			if(!$this->session->userdata('validated')){
				$this->load->view('signin'); 
				$this->load->view('header',$data);
				$this->load->view('rightbuttons');
				$this->load->view('signup');
			}else{
				$this->load->view('userheader',$data);
				$this->load->view('rightbuttons');
			}
		
		$this->load->view('scraper');
		$this->load->view('home_view');
		$this->load->view('footer');
		}
		else
		{
				echo "HALT CITIZEN!";
		}
		
		}
		
		public function crawlColConcerts(){
		
			$userlogin = $this->session->userdata('showdom_id');
		
			if ($userlogin == "showdom") {
				$this->load->model('colconcerts_scraper');
				$content = $this->colconcerts_scraper->colconcerts_main();
				
				$data['content'] = $content;
				
				if(!$this->session->userdata('validated')){
					$this->load->view('signin'); 
					$this->load->view('header',$data);
					$this->load->view('rightbuttons');
					$this->load->view('signup');
				}else{
					$this->load->view('userheader',$data);
					$this->load->view('rightbuttons');
				}
			
			$this->load->view('scraper');
			$this->load->view('home_view');
			$this->load->view('footer');
			}
					else
			{
					echo "HALT CITIZEN!";
			}
		} 
        
        public function crawlNowTorontoArt(){
        
            $userlogin = $this->session->userdata('showdom_id');
        
            if ($userlogin == "showdom") {
                $this->load->model('nowtorontoart_scraper');
                $content = $this->nowtorontoart_scraper->nowtorontoart_main();
                
                $data['content'] = $content;
                
                if(!$this->session->userdata('validated')){
                    $this->load->view('signin'); 
                    $this->load->view('header',$data);
                    $this->load->view('rightbuttons');
                    $this->load->view('signup');
                }else{
                    $this->load->view('userheader',$data);
                    $this->load->view('rightbuttons');
                }
            
            $this->load->view('scraper');
            $this->load->view('home_view');
            $this->load->view('footer');
            }
                    else
            {
                    echo "HALT CITIZEN!";
            }
        }
        
        public function crawlNowTorontoComedy(){
        
            $userlogin = $this->session->userdata('showdom_id');
        
            if ($userlogin == "showdom") {
                $this->load->model('nowtorontocomedy_scraper');
                $content = $this->nowtorontocomedy_scraper->nowtorontocomedy_main();
                
                $data['content'] = $content;
                
                if(!$this->session->userdata('validated')){
                    $this->load->view('signin');
                    $this->load->view('header',$data);
                    $this->load->view('rightbuttons');
                    $this->load->view('signup');
                }else{
                    $this->load->view('userheader',$data);
                    $this->load->view('rightbuttons');
                }
            
            $this->load->view('scraper');
            $this->load->view('home_view');
            $this->load->view('footer');
            }
                    else
            {
                    echo "HALT CITIZEN!";
            }
        }
        
		public function addCSV(){
			$userlogin = $this->session->userdata('showdom_id');
		
			if ($userlogin == "showdom") {
			//load models
				$this->load->model('scraper_model');
				//define filenames"data_blogto.csv",
				$filenames = array("data_blogto.csv","colconcerts_data.csv","justshows_data.csv","nowtorontoart_data.csv");
				//print_r($filenames);
				//goes through each site (scraper), if the csv exists process it
				foreach($filenames as $filename){
				
					if (file_exists($filename)){
						echo $filename;
						//print_r($filename);
						//puts the contents of the csv file into the array csv[]
						$rows = array_map('str_getcsv',file($filename));
						$header = array_shift($rows);
						$csv = array();
						
						foreach ($rows as $row) {
							$csv[] = array_combine($header, $row);
						}
						//print_r($csv);
						//goes through each event in the csv array and adds it to the database
						foreach ($csv as $event)
						{
						//runs a dupe check to see if the event has been added already
							  	$returnvalue = $this->scraper_model->addEventScript($event);
								echo $returnvalue;

						}
					}
				}
					$data['content'] = $content;
					
					if(!$this->session->userdata('validated')){
						$this->load->view('signin'); 
						$this->load->view('header',$data);
						$this->load->view('rightbuttons');
						$this->load->view('signup');
					}else{
						$this->load->view('userheader',$data);
						$this->load->view('rightbuttons');
					}
				
				$this->load->view('scraper');
				$this->load->view('home_view');
				$this->load->view('footer');
			}
			else{
				echo "Provide Proper Credentials";
			}
		}
	}  
?>