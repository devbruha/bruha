<?php  
	class Profile extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->helper( array('form', 'url', 'date', 'keywords','ads','image') );
			$this->load->model(array('profile_model', 'events_model'));  
		} 
						
		public function index(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			
			$imagePath = $this->profile_model->getUserImageNew($userId);
			$showdomId= $this->profile_model->getShowdomId($userId);
			$location = $this->profile_model->getLocation($userId);
			$gender = $this->profile_model->getGender($userId);
			$age = $this->profile_model->getAge($userId);
			$email = $this->profile_model->getEmail($userId);
			$country = $this->profile_model->getCountry($userId);
			$state = $this->profile_model->getState($userId);
			$city = $this->profile_model->getCity($userId);
			$birthYear = $this->profile_model->getBirthYear($userId);
			$birthMonth = $this->profile_model->getBirthMonth($userId);
			$birthDay = $this->profile_model->getBirthDay($userId);
			$website = $this->profile_model->getWebsite($userId);
			$accountType = $this->profile_model->getAccountType($userId);
			
			$googlePlusLink= $this->profile_model->getSocialLink('googleplus-link',$userId);
			$facebookLink= $this->profile_model->getSocialLink('facebook-link',$userId);
			$twitterLink= $this->profile_model->getSocialLink('twitter-link',$userId);
			$linkedInLink= $this->profile_model->getSocialLink('linkedIn-link',$userId);
			$myspaceLink= $this->profile_model->getSocialLink('myspace-link',$userId);
			$youtubeLink= $this->profile_model->getSocialLink('youtube-link',$userId);
			$vimeoLink= $this->profile_model->getSocialLink('vimeo-link',$userId);
			$flickrLink= $this->profile_model->getSocialLink('flickr-link',$userId);
			$behanceLink= $this->profile_model->getSocialLink('behance-link',$userId);
			$deviantArtLink= $this->profile_model->getSocialLink('deviantArt-link',$userId);
			$pinterestLink= $this->profile_model->getSocialLink('pinterest-link',$userId);
			$lastfmLink= $this->profile_model->getSocialLink('lastfm-link',$userId);
			
			$data['googlePlusLink'] = $googlePlusLink;
			$data['facebookLink'] = $facebookLink;
			$data['twitterLink'] = $twitterLink;
			$data['linkedInLink'] = $linkedInLink;
			$data['myspaceLink'] = $myspaceLink;
			$data['youtubeLink'] = $youtubeLink;
			$data['vimeoLink'] = $vimeoLink;
			$data['flickrLink'] = $flickrLink;
			$data['behanceLink'] = $behanceLink;
			$data['deviantArtLink'] = $deviantArtLink;
			$data['pinterestLink'] = $pinterestLink;
			$data['lastfmLink'] = $lastfmLink;
						
			$data['showdomId'] = $showdomId;
			$data['imagePath'] = $imagePath;
			$data['location'] = $location;
			$data['gender'] = $gender;
			$data['age'] = $age;
			$data['email'] = $email;
			$data['theCountry'] = $country;
			$data['state'] = $state;
			$data['city'] = $city;
			$data['birthYear'] = $birthYear;
			$data['birthMonth'] = $birthMonth;
			$data['birthDay'] = $birthDay;
			$data['website'] = $website;
			$data['accountType'] = $accountType;
			$data['userId'] = $userId;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			//$keywords = $this->events_model->getEventKeywords($id);
			
			$data['events'] = $events;
			
			$data['page_title'] = "Your Profile";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}  
		
		function view(){			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$showdomId = $this->uri->segment(3);
			$userId = $this->profile_model->getUserId($showdomId);
			
			$imagePath = $this->profile_model->getUserImageNew($userId);
			$showdomId= $this->profile_model->getShowdomId($userId);
			$location = $this->profile_model->getLocation($userId);
			$gender = $this->profile_model->getGender($userId);
			$age = $this->profile_model->getAge($userId);
			$email = $this->profile_model->getEmail($userId);
			$country = $this->profile_model->getCountry($userId);
			$state = $this->profile_model->getState($userId);
			$city = $this->profile_model->getCity($userId);
			$birthYear = $this->profile_model->getBirthYear($userId);
			$birthMonth = $this->profile_model->getBirthMonth($userId);
			$birthDay = $this->profile_model->getBirthDay($userId);
			$website = $this->profile_model->getWebsite($userId);
			$accountType = $this->profile_model->getAccountType($userId);
			
			$googlePlusLink= $this->profile_model->getSocialLink('googleplus-link',$userId);
			$facebookLink= $this->profile_model->getSocialLink('facebook-link',$userId);
			$twitterLink= $this->profile_model->getSocialLink('twitter-link',$userId);
			$linkedInLink= $this->profile_model->getSocialLink('linkedIn-link',$userId);
			$myspaceLink= $this->profile_model->getSocialLink('myspace-link',$userId);
			$youtubeLink= $this->profile_model->getSocialLink('youtube-link',$userId);
			$vimeoLink= $this->profile_model->getSocialLink('vimeo-link',$userId);
			$flickrLink= $this->profile_model->getSocialLink('flickr-link',$userId);
			$behanceLink= $this->profile_model->getSocialLink('behance-link',$userId);
			$deviantArtLink= $this->profile_model->getSocialLink('deviantArt-link',$userId);
			$pinterestLink= $this->profile_model->getSocialLink('pinterest-link',$userId);
			$lastfmLink= $this->profile_model->getSocialLink('lastfm-link',$userId);
			
			$data['googlePlusLink'] = $googlePlusLink;
			$data['facebookLink'] = $facebookLink;
			$data['twitterLink'] = $twitterLink;
			$data['linkedInLink'] = $linkedInLink;
			$data['myspaceLink'] = $myspaceLink;
			$data['youtubeLink'] = $youtubeLink;
			$data['vimeoLink'] = $vimeoLink;
			$data['flickrLink'] = $flickrLink;
			$data['behanceLink'] = $behanceLink;
			$data['deviantArtLink'] = $deviantArtLink;
			$data['pinterestLink'] = $pinterestLink;
			$data['lastfmLink'] = $lastfmLink;
						
			$data['showdomId'] = $showdomId;
			$data['imagePath'] = $imagePath;
			$data['location'] = $location;
			$data['gender'] = $gender;
			$data['age'] = $age;
			$data['email'] = $email;
			$data['theCountry'] = $country;
			$data['state'] = $state;
			$data['city'] = $city;
			$data['birthYear'] = $birthYear;
			$data['birthMonth'] = $birthMonth;
			$data['birthDay'] = $birthDay;
			$data['website'] = $website;
			$data['accountType'] = $accountType;
			$data['userId'] = $userId;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			//$keywords = $this->events_model->getEventKeywords($id);
			
			$data['events'] = $events;
			
			$data['page_title'] = "".$showdomId." Profile";
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
			$this->load->view('user_profile'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		
		function edit(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
            
            
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
            
            $imagePath = $this->profile_model->getUserImageNew($userId);
            
			$location = $this->profile_model->getLocation($userId);
			$gender = $this->profile_model->getGender($userId);
			$age = $this->profile_model->getAge($userId);
			$email = $this->profile_model->getEmail($userId);
			$country = $this->profile_model->getCountry($userId);
			$state = $this->profile_model->getState($userId);
			$city = $this->profile_model->getCity($userId);
			$birthYear = $this->profile_model->getBirthYear($userId);
			$birthMonth = $this->profile_model->getBirthMonth($userId);
			$birthDay = $this->profile_model->getBirthDay($userId);
			$website = $this->profile_model->getWebsite($userId);
			$accountType = $this->profile_model->getAccountType($userId);
			
						
			$data['showdomId'] = $showdomId;
            $data['imagePath'] = $imagePath;
			$data['location'] = $location;
			$data['gender'] = $gender;
			$data['age'] = $age;
			$data['email'] = $email;
			$data['theCountry'] = $country;
			$data['state'] = $state;
			$data['city'] = $city;
			$data['birthYear'] = $birthYear;
			$data['birthMonth'] = $birthMonth;
			$data['birthDay'] = $birthDay;
			$data['website'] = $website;
			$data['accountType'] = $accountType;
			
			$data['page_title'] = "Edit Profile";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile-edit'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function editSocialLinks(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			$userId = $this->session->userdata('user_id');
			
			$googlePlusLink= $this->profile_model->getSocialLink('googleplus-link',$userId);
			$facebookLink= $this->profile_model->getSocialLink('facebook-link',$userId);
			$twitterLink= $this->profile_model->getSocialLink('twitter-link',$userId);
			$linkedInLink= $this->profile_model->getSocialLink('linkedIn-link',$userId);
			$myspaceLink= $this->profile_model->getSocialLink('myspace-link',$userId);
			$youtubeLink= $this->profile_model->getSocialLink('youtube-link',$userId);
			$vimeoLink= $this->profile_model->getSocialLink('vimeo-link',$userId);
			$flickrLink= $this->profile_model->getSocialLink('flickr-link',$userId);
			$behanceLink= $this->profile_model->getSocialLink('behance-link',$userId);
			$deviantArtLink= $this->profile_model->getSocialLink('deviantArt-link',$userId);
			$pinterestLink= $this->profile_model->getSocialLink('pinterest-link',$userId);
			$lastfmLink= $this->profile_model->getSocialLink('lastfm-link',$userId);
			
			
			$data['googlePlusLink'] = $googlePlusLink;
			$data['facebookLink'] = $facebookLink;
			$data['twitterLink'] = $twitterLink;
			$data['linkedInLink'] = $linkedInLink;
			$data['myspaceLink'] = $myspaceLink;
			$data['youtubeLink'] = $youtubeLink;
			$data['vimeoLink'] = $vimeoLink;
			$data['flickrLink'] = $flickrLink;
			$data['behanceLink'] = $behanceLink;
			$data['deviantArtLink'] = $deviantArtLink;
			$data['pinterestLink'] = $pinterestLink;
			$data['lastfmLink'] = $lastfmLink;
			
			$data['page_title'] = "Edit Social Links";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile-edit-social-links'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function disableAccount(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			$userId = $this->session->userdata('user_id');
			$userStatus = $this->profile_model->getUserActiveStatus($userId);
			$data['userStatus'] = $userStatus;
			$data['page_title'] = "Disable Your Account";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile-disable'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function deactivateAccount(){
			$this->user->checkLogin();
				
			$updateUser = $this->profile_model->disableAccount();
			
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			$userId = $this->session->userdata('user_id');
			$userStatus = $this->profile_model->getUserActiveStatus($userId);
			$data['userStatus'] = $userStatus;
			
			$data['page_title'] = "Disable Your Account";
			$data['message'] = $updateUser;
			$data = array_merge($data, $menu);
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile-disable'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function activateAccount(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			$updateUser = $this->profile_model->activateAccount($userId);
			
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$userStatus = $this->profile_model->getUserActiveStatus($userId);
			$data['userStatus'] = $userStatus;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data['page_title'] = "Activate Your Account";
			$data['message'] = $updateUser;
			$data = array_merge($data, $menu);
			
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('profile-disable'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function updateSocialLinks(){
			$this->user->checkLogin();
			$userId = $this->session->userdata('user_id');
			$updateUser = $this->profile_model->updateSocialLinks();
			redirect('profile/');
		}
		
		function updateProfile(){
			$this->user->checkLogin();
			
			$updateUser = $this->profile_model->updateProfile();
			redirect('profile/editSocialLinks/');
		}
		
		function updatePassword(){
			$this->user->checkLogin();
			$updateUser = $this->profile_model->updatePassword();
			if($updateUser == TRUE){
				echo 'Password has been updated';	
			}else{
				echo 'There was an issue. Your password was not updated';
			}
		}
		
		function reloadProfileEvents(){
			$offset = $_POST['offset'];
			$userId = $_POST['userId'];
			$events = $this->events_model->getUserEvents($userId,$offset);
			$counter = 0;
			foreach($events as $event){
				$counter ++;
                /*
				if($counter == 2 || $counter == 6){
					echo '<div style="margin-bottom:20px;">';
						$keywords = getEventKeywords($event->event_id); 
						echo getRandomAd(3,$event->event_cat,$event->event_sub_cat,$keywords);
					echo '</div>';
				}
                */
                echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
                echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';
                echo '</h2>';
                $eventDateData = getNextEventDate($event->event_id);
				//echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">'.$event->event_title.'</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<div class="eventDate">';
							echo convertDate($eventDateData[0]);
						echo '</div>';
						echo '<img class="eventImage" src="'.base_url().'/'.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'"" />';
					echo '</div>';
					
					echo '<div class="eventContent">';
						echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
						
						echo '<div class="clear-10"></div>';
					
						echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/edit/'.$event->event_id.'">EDIT EVENT</a>';
						echo '<a style="margin-left:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/stats/'.$event->event_id.'">STATISTICS</a>';
						echo '<a onclick="return confirm(\'Are you sure you want to remove this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/events/delete/'.$event->event_id.'">DELETE</a>';
					echo '</div>';
				echo '</div>';
			}
			
		}
		
		function checkOldPassword(){
			$oldPassword = $this->profile_model->checkOldPassword();
			echo json_encode($oldPassword); 
		}
		
	}  
?>