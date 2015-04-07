<?php  
	class Home extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu'));
			$this->load->model(array('profile_model'));  
			$this->load->helper( array('form', 'url', 'date','image','ads') );
        	$this->load->helper('url');
		} 
		
		public function check_isvalidated(){
			if(!$this->session->userdata('validated')){
				//redirect('login');
				//$data['signup'] = $this->session->userdata('userLat');
				//$data['signin'] = TRUE;
				//$this->load->view('signin',$data);
			}else{
				//$data['signin'] = TRUE; 
			}
		}
		
		public function do_logout(){
			$this->session->sess_destroy();
			redirect('login');
		}

        /*
        public function mapEventList(){

            if($this->session->flashdata('loginFail')){
                echo '<script>alert("'.$this->session->flashdata('loginFail').'");</script>';
            }

            $data = $this->map->mapSetUp();
            $menu = $this->mainmenu->getMainMenu();

            $data['page_title'] = "Showdom Home Page";

            $data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
            $data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);

            $data = array_merge($data, $menu);

            $this->load->view('userheader-new',$data);
            $this->load->view('rightbuttons');

            $this->load->view('home_view_new');

            $this->load->view('footer');
        }
        */

        public function index(){

            if($this->session->flashdata('loginFail')){
                echo '<script>alert("'.$this->session->flashdata('loginFail').'");</script>';
            }
						
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
						
			$data['page_title'] = "Showdom Home Page";
			
			$data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
			$data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
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
			
			$this->load->view('home_view');
			
			$this->load->view('footer');
		}

        /*
        public function homeNew(){

            if($this->session->flashdata('loginFail')){
                echo '<script>alert("'.$this->session->flashdata('loginFail').'");</script>';
            }

            $data = $this->map->mapSetUp();
            $menu = $this->mainmenu->getMainMenu();

            $data['page_title'] = "Showdom Home Page";

            $data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
            $data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

            $data = array_merge($data, $menu);

            if(!$this->session->userdata('validated')){
                //$this->load->view('signin');
                $this->load->view('header',$data);
                $this->load->view('rightbuttons');
                $this->load->view('signup');
            }else{
                $this->load->view('userheader-new',$data);
                $this->load->view('rightbuttons');
            }

            $this->load->view('home_view');

            $this->load->view('footer');
        }
        */

        public function forgotPassword(){
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$message = $this->uri->segment(3);
			if($message != ''){
				
				$data['message'] = 'Thank you. Your new password has been emailed to you.';
			}
			
			$data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
			$data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data['page_title'] = "Forgot Password";
			$data = array_merge($data, $menu);
			/*---LOAD VIEWS---*/
			$this->load->view('header',$data);
			$this->load->view('rightbuttons');
			$this->load->view('signup');
			$this->load->view('forgotPassword'); 
			$this->load->view('home_view');
			$this->load->view('footer');
		}
		
		public function forgotPasswordSubmit(){
			$addEventPhotos = $this->profile_model->forgotPassword();	
			redirect('home/forgotPassword/complete');
		}
		
		public function updateLatLong(){
			$cookie = array(
			  'name'   => 'latCookie',
			  'value'  => $_POST['lat'],
			  'expire' => 86500000, 
			  'secure' => FALSE
			);
			$this->input->set_cookie($cookie);
			
			$cookie = array(
			  'name'   => 'lngCookie',
			  'value'  => $_POST['lng'],
			  'expire' => 86500000, 
			  'secure' => FALSE
			);
			$this->input->set_cookie($cookie);

            $cookie = array(
                'name'   => 'zoomCookie',
                'value'  => $_POST['zoom'],
                'expire' => 86500000,
                'secure' => FALSE
            );
            $this->input->set_cookie($cookie);
		}

        public function updateListViewWidth(){
            $cookie = array(
                'name'   => 'listViewWidth',
                'value'  => $_POST['width'],
                'expire' => 86500000,
                'secure' => FALSE
            );
            $this->input->set_cookie($cookie);
        }

        public function updateShowFor(){
            $cookie = array(
                'name'   => 'showForCookie',
                'value'  => $_POST['showFor'],
                'expire' => 86500000,
                'secure' => FALSE
            );
            $this->input->set_cookie($cookie);
        }

        public function listVieOpenClose(){
            $cookie = array(
                'name'   => 'listViewOpen',
                'value'  => $_POST['isOpen'],
                'expire' => 86500000,
                'secure' => FALSE
            );
            $this->input->set_cookie($cookie);
        }
	
	}  
?>