<?php  
	class Admin extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->model(array('profile_model','ads_model','stats_model', 'content_model'));  
			$this->load->helper( array('form', 'url', 'date','image','ads','user') );
        	$this->load->helper('url');
			$this->user->adminOnly();
		} 
		
		public function signIn(){
			
		}
		
		public function index(){
			$data['page_title'] = "Showdom Admin Dashboard";
			
			$numUsers = $this->profile_model->countUsers();
			$userBreakDown = $this->profile_model->profileLocationBreakdown('');
			
			$numEvents = $this->events_model->countEvents();
			$eventsBreakdown = $this->events_model->eventsLocationBreakdown('');
			
			$numAds = $this->ads_model->countAds();
			$adsBreakdown = $this->ads_model->adsLocationBreakdown('');
			
			$data['numUsers'] = $numUsers;
			$data['userBreakDown']  = $userBreakDown; 
			$data['numEvents'] = $numEvents;
			$data['eventsBreakdown']  = $eventsBreakdown; 
			$data['numAds'] = $numAds;
			$data['adsBreakdown']  = $adsBreakdown; 
			
			$this->load->view('admin/header',$data);
			$this->load->view('admin/home_view');
			$this->load->view('admin/footer');
		}
		
		public function users(){
			$data['page_title'] = "Showdom Users";
			
			$users = $this->profile_model->getAllUsers();
			$numUsers = $this->profile_model->countUsers();
			$data['users'] = $users;
			$data['numUsers'] = $numUsers;						
									
			$this->load->view('admin/header',$data);
			$this->load->view('admin/users');
			$this->load->view('admin/footer');
		}  
		
		public function deactivateUser(){
			$id = $this->uri->segment(3);
			$this->profile_model->deactivateUser($id);
			redirect('admin/users');
		}
		
		public function activateUser(){
			$id = $this->uri->segment(3);
			$this->profile_model->activateUser($id);
			redirect('admin/users');
		}
		
		public function reloadUserList(){
			$offset = $_POST['offset'];
			$searchTerm = $_POST['searchTerm'];
			$users = $this->profile_model->getAllUsers($searchTerm,$offset);
			$counter = 0;
			foreach($users as $user){
                if($user->gender == 1){
                    $gender = 'Male';
                }elseif($user->gender == 2){
                    $gender = 'Female';
                }else{
                    $gender = 'Other';
                }
				echo '<h2 class="eventTitle eventTitleCat1">';
					echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/">'.$user->showdom_id.'</a>';
				echo '</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/"><img class="userImage" src="'.base_url().image('themes/showdom/images/users/'.$user->showdom_id.'/'.$user->image."", 150, 150).'" /></a>';
					echo '</div>'; 
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Account Type:</em></small> <span>'.getAccountType($user->account_type).'</span></p>';
						echo '<p><small><em class="lightGrey">Email:</em></small> <span>'.$user->email.'</span></p>';
						echo '<p><small><em class="lightGrey">Status:</em></small> <span>'.getStatus($user->active).'</span></p>';
						echo '<p><small><em class="lightGrey">location:</em></small> <span>'.$user->city.' '.$user->state.' '.$user->country.'</span></p>';
						echo '<p><small><em class="lightGrey">Gender:</em></small> <span>'.$gender.'</span></p>';
						echo '<p><small><em class="lightGrey">Age:</em></small> <span>'.getAge($user->birth).'</span></p>';
						if($user->website != ''){
							echo '<p><small><em class="lightGrey">Website:</em></small> <span><a href="'.$user->website.'" target="_blank">'.$user->website.'</a></span></p>';
						}
						
						echo '<div class="clear-10"></div>';
					
						if($user->active == 1){
							echo '<a onclick="return confirm(\'Are you sure you want to deactivate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deactivateUser/'.$user->user_id.'">DEACTIVATE</a>';
						}else{
							echo '<a onclick="return confirm(\'Are you sure you want to activate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/activateUser/'.$user->user_id.'">ACTIVATE</a>';
						}
						
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function searchUserList(){
			$searchTerm = $_POST['searchTerm'];
			$users = $this->profile_model->searchAllUsers($searchTerm);
			$counter = 0;
			foreach($users as $user){
				echo '<h2 class="eventTitle eventTitleCat1">';
					echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/">'.$user->showdom_id.'</a>';
				echo '</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/"><img class="userImage" src="'.base_url().image('themes/showdom/images/users/'.$user->showdom_id.'/'.$user->image."", 150, 150).'" /></a>';
					echo '</div>'; 
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Account Type:</em></small> <span>'.getAccountType($user->account_type).'</span></p>';
						echo '<p><small><em class="lightGrey">Email:</em></small> <span>'.$user->email.'</span></p>';
						echo '<p><small><em class="lightGrey">Status:</em></small> <span>'.getStatus($user->active).'</span></p>';
						echo '<p><small><em class="lightGrey">location:</em></small> <span>'.$user->city.' '.$user->state.' '.$user->country.'</span></p>';
						echo '<p><small><em class="lightGrey">Gender:</em></small> <span>'.$user->showdom_id.'</span></p>';
						echo '<p><small><em class="lightGrey">Age:</em></small> <span>'.getAge($user->birth).'</span></p>';
						if($user->website != ''){
							echo '<p><small><em class="lightGrey">Website:</em></small> <span><a href="'.$user->website.'" target="_blank">'.$user->website.'</a></span></p>';
						}
						
						echo '<div class="clear-10"></div>';
					
						if($user->active == 1){
							echo '<a onclick="return confirm(\'Are you sure you want to deactivate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deactivateUser/'.$user->user_id.'">DEACTIVATE</a>';
						}else{
							echo '<a onclick="return confirm(\'Are you sure you want to activate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/activateUser/'.$user->user_id.'">ACTIVATE</a>';
						}

					echo '</div>';
				echo '</div>';
			}
		}
		
		
		public function events(){
			$data['page_title'] = "Showdom Events";
			
			$events = $this->events_model->getAllEvents();
			$numEvents = $this->events_model->countEvents();
			$data['events'] = $events;
			$data['numEvents'] = $numEvents;						
									
			$this->load->view('admin/header',$data);
			$this->load->view('admin/events');
			$this->load->view('admin/footer');
		}
		
		public function reportedEvents(){
			$data['page_title'] = "Showdom Events";
			
			$events = $this->events_model->getAllReportedEvents();
			$numEvents = $this->events_model->countReportedEvents();
			$data['events'] = $events;
			$data['numEvents'] = $numEvents;						
									
			$this->load->view('admin/header',$data);
			$this->load->view('admin/eventsReported');
			$this->load->view('admin/footer');
		}
		
		public function claimRequests(){
			$data['page_title'] = "Showdom Event Claim Requests";
			
			$events = $this->events_model->getAllClaimedEvents();
			$data['events'] = $events;
									
			$this->load->view('admin/header',$data);
			$this->load->view('admin/eventsClaimed');
			$this->load->view('admin/footer');
		}
		
		public function claimEventApprove(){
			$claimid = $this->uri->segment(3);
			$this->events_model->claimEventApprove($claimid);
			redirect('admin/claimRequests');
		}

        public function claimEventRemove(){
            $claimid = $this->uri->segment(3);
            $this->events_model->claimEventRemove($claimid);
            redirect('admin/claimRequests');
        }
		
		public function reloadReportedEventList(){
			$offset = $_POST['offset'];
			$searchTerm = $_POST['searchTerm'];
			$events = $this->events_model->getAllReportedEvents($searchTerm,$offset);
			$counter = 0;
			foreach($events as $event){
				echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
					echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.$event->event_title.'">'.$event->event_title.'</a>';
					if($event->event_type == 1){
						echo '<span class="featured">FEATURED</span>';
					}
				echo '</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<div class="eventDate">';
							echo convertDate($event->event_start_date);
						echo '</div>';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'"" />';
					echo '</div>';
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($event->event_start_time).' to '.convertTime($event->event_end_time).'</span></p>';
                        echo '<p><small><em class="lightGrey">Reason:</em></small> <span>'.$event->why.'</span></p>';

                        echo '<div class="clear-10"></div>';
						
						echo '<a onclick="return confirm(\'Are you sure you want to delete this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteEvent/'.$event->event_id.'">DELETE THIS EVENT</a>';
						echo '<a style="margin-right:10px;" onclick="return confirm(\'Are you sure?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/makeEventAsOk/'.$event->event_id.'">THIS EVENT IS SAFE</a>';
			
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function reloadEventList(){
			$offset = $_POST['offset'];
			$searchTerm = $_POST['searchTerm'];
			$events = $this->events_model->getAllEvents($searchTerm,$offset);
			$counter = 0;
			foreach($events as $event){
				echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
					echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.$event->event_title.'">'.$event->event_title.'</a>';
					if($event->event_type == 1){
						echo '<span class="featured">FEATURED</span>';
					}
				echo '</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<div class="eventDate">';
							echo convertDate($event->event_start_date);
						echo '</div>';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'"" />';
					echo '</div>';
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($event->event_start_time).' to '.convertTime($event->event_end_time).'</span></p>';
						
						echo '<div class="clear-10"></div>';
						
						echo '<a onclick="return confirm(\'Are you sure you want to delete this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteEvent/'.$event->event_id.'">DELETE</a>';
					
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function searchEventList(){
			$searchTerm = $_POST['searchTerm'];
			$offset = 0;
			$events = $this->events_model->getAllEvents($searchTerm,$offset);
			$counter = 0;
			foreach($events as $event){
				echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
					echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.$event->event_title.'">'.$event->event_title.'</a>';
					if($event->event_type == 1){
						echo '<span class="featured">FEATURED</span>';
					}
				echo '</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<div class="eventDate">';
							echo convertDate($event->event_start_date);
						echo '</div>';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'"" />';
					echo '</div>';
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($event->event_start_time).' to '.convertTime($event->event_end_time).'</span></p>';
						
						echo '<div class="clear-10"></div>';
						
						echo '<a onclick="return confirm(\'Are you sure you want to delete this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteEvent/'.$event->event_id.'">DELETE</a>';
					
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function deleteEvent(){
			$id = $this->uri->segment(3);
			$this->events_model->adminDeleteEvent($id);
			redirect('admin/events');
		} 
		
		public function makeEventAsOk(){
			$id = $this->uri->segment(3);
			$this->events_model->makeEventAsOk($id);
			redirect('admin/reportedEvents');
		}
		
		public function ads(){
            $data['page_title'] = "Showdom Promo Codes";

            $ads = $this->ads_model->getActiveAds();
            $numAds = $this->ads_model->countAds();
            $data['ads'] = $ads;
            $data['numAds'] = $numAds;

            $this->load->view('admin/header',$data);
            $this->load->view('admin/ads');
            $this->load->view('admin/footer');
		}

        public function promoCodes(){
            $data['page_title'] = "Showdom Ads";

            $codes = $this->ads_model->getPromoCodes();
            $data['codes'] = $codes;

            $this->load->view('admin/header',$data);
            $this->load->view('admin/promoCodes');
            $this->load->view('admin/footer');
        }

        public function createPromoCodes(){
            $this->ads_model->createPromoCodes();
            redirect('admin/promoCodes');
        }

        public function deleteCode(){
            $id = $this->uri->segment(3);
            $this->ads_model->deleteCode($id);
            redirect('admin/promoCodes');
        }

		public function reloadAdList(){
			$offset = $_POST['offset'];
			$searchTerm = $_POST['searchTerm'];
			$ads = $this->ads_model->getActiveAds($searchTerm,$offset,6);
			foreach($ads as $ad){
				echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/ads//".$ad->ad_image."", 150, 150).'" />';
					echo '</div>';
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
						echo '<p><small><em class="lightGrey">URL:</em></small> <span><a href="'.$ad->ad_link.'" target="_blank">'.$ad->ad_link.'</a></span></p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$ad->ad_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Distance:</em></small> <span>'.$ad->ad_distance.' km</span></p>';
						echo '<p><small><em class="lightGrey">Starts:</em></small> <span>'.$ad->ad_start_date.'</span></p>';
						echo '<p><small><em class="lightGrey">Ends:</em></small> <span>'.$ad->ad_end_date.'</span></p>';
						echo '<div class="clear-10"></div>';
						echo '<a onclick="return confirm(\'Are you sure you want to remove this ad?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteAd/'.$ad->ad_id.'">DELETE</a>';
					
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function searchAdList(){
			$searchTerm = $_POST['searchTerm'];
			$offset = 0;
			$ads = $this->ads_model->getActiveAds($searchTerm,$offset,6);
			foreach($ads as $ad){
				echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeft">';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/ads//".$ad->ad_image."", 150, 150).'" />';
					echo '</div>';
					
					echo '<div class="eventContentLarger">';
						echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
						echo '<p><small><em class="lightGrey">URL:</em></small> <span><a href="'.$ad->ad_link.'" target="_blank">'.$ad->ad_link.'</a></span></p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$ad->ad_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Distance:</em></small> <span>'.$ad->ad_distance.' km</span></p>';
						echo '<p><small><em class="lightGrey">Starts:</em></small> <span>'.$ad->ad_start_date.'</span></p>';
						echo '<p><small><em class="lightGrey">Ends:</em></small> <span>'.$ad->ad_end_date.'</span></p>';
						echo '<div class="clear-10"></div>';
						echo '<a onclick="return confirm(\'Are you sure you want to remove this ad?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteAd/'.$ad->ad_id.'">DELETE</a>';
					
					echo '</div>';
				echo '</div>';
			}
		}
		
		public function deleteAd(){
			$id = $this->uri->segment(3);
			$this->ads_model->deleteAd($id);
			redirect('admin/ads');
		}
		
		public function content(){
			$data['page_title'] = "Showdom Page Content";
			$contentId = $this->uri->segment(3);			
			
			$content = $this->content_model->getContent($contentId);
			
			$data['contentId'] = $contentId;				
			$data['content'] = $content;								
			
			if($contentId == 3 || $contentId == 4){
				$contentSections = $this->content_model->getContentSections($contentId);
				$data['contentSections'] = $contentSections;		
				$this->load->view('admin/header',$data);
				$this->load->view('admin/contentSections');
			}else{
				$this->load->view('admin/header',$data);
				$this->load->view('admin/content');
			}
			$this->load->view('admin/footer');
		}
		
		public function contentUpdate(){
			$id = $_POST['content_id'];
			$this->content_model->updateContent();
			redirect('admin/content/'.$id.''); 
		}
		
		public function contentSectionAdd(){
			$id = $_POST['content_id'];
			$this->content_model->addContentSection();
			redirect('admin/content/'.$id.''); 
		}
		
		public function contentSectionUpdate(){
			$id = $_POST['content_id'];
			$this->content_model->updateContentSection();
			redirect('admin/content/'.$id.''); 
		}
		
	}  
?>