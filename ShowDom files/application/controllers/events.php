<?php  
	class Events extends CI_Controller{  
		
		function __construct(){
			parent::__construct();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu','user'));
			$this->load->helper( array('form', 'url', 'date','image','ads') );
			$this->load->model(array('profile_model', 'events_model','ads_model','stats_model'));  
		}
		
		function checkEventAge(){
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}
			$id = $this->uri->segment(3);
			
			$events = $this->events_model->getEventContent($id);

			$data['events'] = $events;
			echo json_encode($data['events']); 
		}
		
		function loadContent(){
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}
			$id = $this->uri->segment(3);
			/*--- STATISTICS---*/
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
				$addStat = $this->stats_model->addStat($id,$userId,'event-quick-view');
			}else{
				$addStat = $this->stats_model->addStat($id,0,'event-quick-view');
			}
            $eventViews = $this->stats_model->getTotalStats($id,'event-full-view');

            $events = $this->events_model->getEventContent($id);
			$keywords = $this->events_model->getEventKeywords($id);

			$featuredaudio = $this->events_model->getFeaturedAudio($id);
			$featuredVideo = $this->events_model->getFeaturedVideo($id);
			$eventimages = $this->events_model->getEventPhotos($id);
			$eventFavourites = $this->events_model->getCountEventFavourites($id);
			if($this->session->userdata('user_id')){
				$checkFavourite = $this->events_model->checkIfEventFavourite($id,$userId);
				$data['isFav'] = $checkFavourite;
			}
			$data['events'] = $events;
			$data['keywords'] = $keywords;
			$data['featuredaudio'] = $featuredaudio;
			$data['featuredVideo'] = $featuredVideo;
			$data['eventimages'] = $eventimages;
			$data['eventId'] = $id;
			$data['numFavourites'] = $eventFavourites;
            $data['eventViews'] = $eventViews;

            if($this->uri->segment(4)=='mobile'){
                $this->load->view('mobile/eventLoad',$data);
            }else{
                $this->load->view('eventLoad',$data);
            }

		}

        function loadContentNew(){
            if($this->session->userdata('user_id')){
                $userId = $this->session->userdata('user_id');
            }
            $id = $this->uri->segment(3);
            /*--- STATISTICS---*/
            if($this->session->userdata('user_id')){
                $userId = $this->session->userdata('user_id');
                $addStat = $this->stats_model->addStat($id,$userId,'event-quick-view');
            }else{
                $addStat = $this->stats_model->addStat($id,0,'event-quick-view');
            }
            $eventViews = $this->stats_model->getTotalStats($id,'event-full-view');

            $events = $this->events_model->getEventContent($id);
            $keywords = $this->events_model->getEventKeywords($id);

            $featuredaudio = $this->events_model->getFeaturedAudio($id);
            $featuredVideo = $this->events_model->getFeaturedVideo($id);
            $eventimages = $this->events_model->getEventPhotos($id);
            $eventFavourites = $this->events_model->getCountEventFavourites($id);
            if($this->session->userdata('user_id')){
                $checkFavourite = $this->events_model->checkIfEventFavourite($id,$userId);
                $data['isFav'] = $checkFavourite;
            }
            $data['events'] = $events;
            $data['keywords'] = $keywords;
            $data['featuredaudio'] = $featuredaudio;
            $data['featuredVideo'] = $featuredVideo;
            $data['eventimages'] = $eventimages;
            $data['eventId'] = $id;
            $data['numFavourites'] = $eventFavourites;
            $data['eventViews'] = $eventViews;

            if($this->uri->segment(4)=='mobile'){
                $this->load->view('mobile/eventLoad',$data);
            }else{
                $this->load->view('eventLoadNew',$data);
            }

        }
		
		function favourite(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			 
			/*---STATISTICS---*/
			$userId = $this->session->userdata('user_id');
			$addStat = $this->stats_model->addStat($id,$userId,'favourite');
			/*---STATISTICS---*/
			
			$addEventPhotos = $this->events_model->favouriteEvent($id);	
		}
		
		function unfavourite(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			
			/*---REMOVE STATISTICS---*/
			$userId = $this->session->userdata('user_id');
			$removeStat = $this->stats_model->deleteStat($id,$userId,'favourite');
			/*---REMOVE STATISTICS---*/
			
			$addEventPhotos = $this->events_model->unfavouriteEvent($id);	
		}
		
		function unfavouriteAjax(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			
			/*---REMOVE STATISTICS---*/
			$userId = $this->session->userdata('user_id');
			$removeStat = $this->stats_model->deleteStat($id,$userId,'favourite');
			/*---REMOVE STATISTICS---*/
			
			$addEventPhotos = $this->events_model->unfavouriteEventAjax($id);	
		}		
		
		function view(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*--- STATISTICS---*/
			if($this->session->userdata('user_id')){
				$lggedInUser = $this->session->userdata('user_id');
				$addStat = $this->stats_model->addStat($eventId,$lggedInUser,'event-full-view');
			}else{
				$addStat = $this->stats_model->addStat($eventId,0,'event-full-view');	
			}


			/*---EVENT CREATOR INFORMATION---*/
            $data['imagePath'] = $this->profile_model->getUserImageNew($userId);

            $userInfo = $this->profile_model->getUserInformation($userId);
            //print_r($userInfo);
            $data['showdomId']= $userInfo->showdom_id;
            $data['location'] = $userInfo->city.' '.$userInfo->state.' '.$userInfo->country;
            if($userInfo->gender == 1){
                $data['gender'] = 'Male';
            }elseif($userInfo->gender == 2){
                $data['gender'] = 'Female';
            }else{
                $data['gender'] = 'Other';
            }

            $age = $userInfo->birth;
            $ageArray = explode('-',$age);
            $data['age'] = date('Y') - $ageArray[0];

            $data['email'] = $userInfo->email;
            $data['theCountry'] = $userInfo->country;
            $data['state'] = $userInfo->state;
            $data['city'] = $userInfo->city;

            $birthYear = $userInfo->birth;
            $year = explode('-',$birthYear);
            $data['birthYear'] = $year[0];

            $month = explode('-',$userInfo->birth);
            $data['birthMonth'] = $month[1];

            $day = explode('-',$userInfo->birth);
            $data['birthDay'] = $day[2];

            $data['website'] = $userInfo->website;

            if($userInfo->account_type == 1){
                $data['accountType'] = 'Artist';
            }
            if($userInfo->account_type == 2){
                $data['accountType'] = 'Promoter';
            }
            if($userInfo->account_type == 3){
                $data['accountType'] = 'Venue';
            }

            $userMeta = $this->profile_model->getAllUserMeta($userId);
            foreach($userMeta as $meta){
                if($meta->meta_key == 'googleplus-link'){
                    $data['googlePlusLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'facebook-link'){
                    $data['facebookLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'twitter-link'){
                    $data['twitterLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'linkedIn-link'){
                    $data['linkedInLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'myspace-link'){
                    $data['myspaceLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'youtube-link'){
                    $data['youtubeLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'vimeo-link'){
                    $data['vimeoLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'flickr-link'){
                    $data['flickrLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'behance-link'){
                    $data['behanceLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'deviantArt-link'){
                    $data['deviantArtLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'pinterest-link'){
                    $data['pinterestLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'lastfm-link'){
                    $data['lastfmLink'] = $meta->meta_value;
                }
            }

			/*--EVENT SOCIAL IMAGE INFORMATION--
			$googlePlusMoreImagesLink= $this->events_model->getSocialLink('image-googleplus-link',$eventId);
			$facebookMoreImagesLink= $this->events_model->getSocialLink('image-facebook-link',$eventId);
			$twitterMoreImagesLink= $this->events_model->getSocialLink('image-twitter-link',$eventId);
			$linkedInMoreImagesLink= $this->events_model->getSocialLink('image-linkedIn-link',$eventId);
			$myspaceMoreImagesLink= $this->events_model->getSocialLink('image-myspace-link',$eventId);
			$youtubeMoreImagesLink= $this->events_model->getSocialLink('image-youtube-link',$eventId);
			$vimeoMoreImagesLink= $this->events_model->getSocialLink('image-vimeo-link',$eventId);
			$flickrMoreImagesLink= $this->events_model->getSocialLink('image-flickr-link',$eventId);
			$behanceMoreImagesLink= $this->events_model->getSocialLink('image-behance-link',$eventId);
			$deviantArtMoreImagesLink= $this->events_model->getSocialLink('image-deviantArt-link',$eventId);
			$pinterestMoreImagesLink= $this->events_model->getSocialLink('image-pinterest-link',$eventId);
			$lastfmMoreImagesLink= $this->events_model->getSocialLink('image-lastfm-link',$eventId);

			$data['googlePlusMoreImagesLink'] = $googlePlusMoreImagesLink;
			$data['facebookMoreImagesLink'] = $facebookMoreImagesLink;
			$data['twitterMoreImagesLink'] = $twitterMoreImagesLink;
			$data['linkedInMoreImagesLink'] = $linkedInMoreImagesLink;
			$data['myspaceMoreImagesLink'] = $myspaceMoreImagesLink;
			$data['youtubeMoreImagesLink'] = $youtubeMoreImagesLink;
			$data['vimeoMoreImagesLink'] = $vimeoMoreImagesLink;
			$data['flickrMoreImagesLink'] = $flickrMoreImagesLink;
			$data['behanceMoreImagesLink'] = $behanceMoreImagesLink;
			$data['deviantArtMoreImagesLink'] = $deviantArtMoreImagesLink;
			$data['pinterestMoreImagesLink'] = $pinterestMoreImagesLink;
			$data['lastfmMoreImagesLink'] = $lastfmMoreImagesLink;
			*/
			
			/*--EVENT SOCIAL VIDEO INFORMATION--
			$googlePlusMoreVideosLink= $this->events_model->getSocialLink('video-googleplus-link',$eventId);
			$facebookMoreVideosLink= $this->events_model->getSocialLink('video-facebook-link',$eventId);
			$twitterMoreVideosLink= $this->events_model->getSocialLink('video-twitter-link',$eventId);
			$linkedInMoreVideosLink= $this->events_model->getSocialLink('video-linkedIn-link',$eventId);
			$myspaceMoreVideosLink= $this->events_model->getSocialLink('video-myspace-link',$eventId);
			$youtubeMoreVideosLink= $this->events_model->getSocialLink('video-youtube-link',$eventId);
			$vimeoMoreVideosLink= $this->events_model->getSocialLink('video-vimeo-link',$eventId);
			$flickrMoreVideosLink= $this->events_model->getSocialLink('video-flickr-link',$eventId);
			$behanceMoreVideosLink= $this->events_model->getSocialLink('video-behance-link',$eventId);
			$deviantArtMoreVideosLink= $this->events_model->getSocialLink('video-deviantArt-link',$eventId);
			$pinterestMoreVideosLink= $this->events_model->getSocialLink('video-pinterest-link',$eventId);
			$lastfmMoreVideosLink= $this->events_model->getSocialLink('video-lastfm-link',$eventId);
			
			$data['googlePlusMoreVideosLink'] = $googlePlusMoreVideosLink;
			$data['facebookMoreVideosLink'] = $facebookMoreVideosLink;
			$data['twitterMoreVideosLink'] = $twitterMoreVideosLink;
			$data['linkedInMoreVideosLink'] = $linkedInMoreVideosLink;
			$data['youtubeMoreVideosLink'] = $youtubeMoreVideosLink;
			$data['myspaceMoreVideosLink'] = $myspaceMoreVideosLink;
			$data['vimeoMoreVideosLink'] = $vimeoMoreVideosLink;
			$data['flickrMoreVideosLink'] = $flickrMoreVideosLink;
			$data['behanceMoreVideosLink'] = $behanceMoreVideosLink;
			$data['deviantArtMoreVideosLink'] = $deviantArtMoreVideosLink;
			$data['pinterestMoreVideosLink'] = $pinterestMoreVideosLink;
			$data['lastfmMoreVideosLink'] = $lastfmMoreVideosLink;			
			*/
			/*--EVENT SOCIAL AUDIO INFORMATION--
			$googlePlusMoreAudioLink= $this->events_model->getSocialLink('audio-googleplus-link',$eventId);
			$facebookMoreAudioLink= $this->events_model->getSocialLink('audio-facebook-link',$eventId);
			$twitterMoreAudioLink= $this->events_model->getSocialLink('audio-twitter-link',$eventId);
			$linkedInMoreAudioLink= $this->events_model->getSocialLink('audio-linkedIn-link',$eventId);
			$myspaceMoreAudioLink= $this->events_model->getSocialLink('audio-myspace-link',$eventId);
			$youtubeMoreAudioLink= $this->events_model->getSocialLink('audio-youtube-link',$eventId);
			$vimeoMoreAudioLink= $this->events_model->getSocialLink('audio-vimeo-link',$eventId);
			$flickrMoreAudioLink= $this->events_model->getSocialLink('audio-flickr-link',$eventId);
			$behanceMoreAudioLink= $this->events_model->getSocialLink('audio-behance-link',$eventId);
			$deviantArtMoreAudioLink= $this->events_model->getSocialLink('audio-deviantArt-link',$eventId);
			$pinterestMoreAudioLink= $this->events_model->getSocialLink('audio-pinterest-link',$eventId);
			$lastfmMoreAudioLink= $this->events_model->getSocialLink('audio-lastfm-link',$eventId);
			
			$data['googlePlusMoreAudioLink'] = $googlePlusMoreAudioLink;
			$data['facebookMoreAudioLink'] = $facebookMoreAudioLink;
			$data['twitterMoreAudioLink'] = $twitterMoreAudioLink;
			$data['linkedInMoreAudioLink'] = $linkedInMoreAudioLink;
			$data['myspaceMoreAudioLink'] = $myspaceMoreAudioLink;
			$data['youtubeMoreAudioLink'] = $youtubeMoreAudioLink;
			$data['vimeoMoreAudioLink'] = $vimeoMoreAudioLink;
			$data['flickrMoreAudioLink'] = $flickrMoreAudioLink;
			$data['behanceMoreAudioLink'] = $behanceMoreAudioLink;
			$data['deviantArtMoreAudioLink'] = $deviantArtMoreAudioLink;
			$data['pinterestMoreAudioLink'] = $pinterestMoreAudioLink;
			$data['lastfmMoreAudioLink'] = $lastfmMoreAudioLink;			
			*/

			/*--EVENT INFORMATION--*/
			$keywords = $this->events_model->getEventKeywords($eventId);
			$photos = $this->events_model->getEventPhotos($eventId);
			$featuredVideo = $this->events_model->getEventVideo($eventId);
			$featuredaudio = $this->events_model->getEventAudio($eventId);
			$eventupdates = $this->events_model->getEventUpdates($eventId);
			$numEventUpdates = $this->events_model->countEventUpdates($eventId);
			$eventComments = $this->events_model->getEventComments($eventId);
			$numEventComments = $this->events_model->countEventComments($eventId);
			$eventFavourites = $this->events_model->getCountEventFavourites($eventId);
			$eventViews = $this->stats_model->getTotalStats($eventId,'event-full-view');
            $eventDates = $this->events_model->getEventDates($eventId);
						
			$data['keywords'] = $keywords;
			$data['photos'] = $photos;
			$data['video'] = $featuredVideo;
			$data['audio'] = $featuredaudio;
			$data['eventupdates'] = $eventupdates;
			$data['numEventUpdates'] = $numEventUpdates;
			$data['eventcomments'] = $eventComments;
			$data['numEventComments'] = $numEventComments;
			$data['eventCreatorId'] = $userId;
			$data['eventFavourites'] = $eventFavourites;
			$data['eventViews'] = $eventViews;
			$data['theUserId'] = $this->session->userdata('user_id');
            $data['eventDates'] = $eventDates;
			
			if($this->session->userdata('user_id')){
				$checkFavourite = $this->events_model->checkIfEventFavourite($eventId,$this->session->userdata('user_id'));
				$data['isFav'] = $checkFavourite;
			}
			
			/*---GET USER EVENTS----*/
			$eventData = $this->events_model->getEventData($eventId);
			//print_r($eventData->event_image);
			
			$data['eventData'] = $eventData;
			
			$data['page_title'] = "Event Information";
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
			$this->load->view('event'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}

        function viewAjax(){
            $eventId = $this->uri->segment(3);
            $userId = $this->events_model->getUserIdFromEvent($eventId);

            $data = $this->map->mapSetUp();
            $menu = $this->mainmenu->getMainMenu();

            /*--- STATISTICS---*/
            if($this->session->userdata('user_id')){
                $lggedInUser = $this->session->userdata('user_id');
                $addStat = $this->stats_model->addStat($eventId,$lggedInUser,'event-full-view');
            }else{
                $addStat = $this->stats_model->addStat($eventId,0,'event-full-view');
            }

            /*---EVENT CREATOR INFORMATION---*/
            $data['imagePath'] = $this->profile_model->getUserImageNew($userId);

            $userInfo = $this->profile_model->getUserInformation($userId);
            //print_r($userInfo);
            $data['showdomId']= $userInfo->showdom_id;
            $data['location'] = $userInfo->city.' '.$userInfo->state.' '.$userInfo->country;
            if($userInfo->gender == 1){
                $data['gender'] = 'Male';
            }elseif($userInfo->gender == 2){
                $data['gender'] = 'Female';
            }else{
                $data['gender'] = 'Other';
            }

            $age = $userInfo->birth;
            $ageArray = explode('-',$age);
            $data['age'] = date('Y') - $ageArray[0];

            $data['email'] = $userInfo->email;
            $data['theCountry'] = $userInfo->country;
            $data['state'] = $userInfo->state;
            $data['city'] = $userInfo->city;

            $birthYear = $userInfo->birth;
            $year = explode('-',$birthYear);
            $data['birthYear'] = $year[0];

            $month = explode('-',$userInfo->birth);
            $data['birthMonth'] = $month[1];

            $day = explode('-',$userInfo->birth);
            $data['birthDay'] = $day[2];

            $data['website'] = $userInfo->website;

            if($userInfo->account_type == 1){
                $data['accountType'] = 'Artist';
            }
            if($userInfo->account_type == 2){
                $data['accountType'] = 'Promoter';
            }
            if($userInfo->account_type == 3){
                $data['accountType'] = 'Venue';
            }

            $userMeta = $this->profile_model->getAllUserMeta($userId);
            foreach($userMeta as $meta){
                if($meta->meta_key == 'googleplus-link'){
                    $data['googlePlusLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'facebook-link'){
                    $data['facebookLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'twitter-link'){
                    $data['twitterLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'linkedIn-link'){
                    $data['linkedInLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'myspace-link'){
                    $data['myspaceLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'youtube-link'){
                    $data['youtubeLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'vimeo-link'){
                    $data['vimeoLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'flickr-link'){
                    $data['flickrLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'behance-link'){
                    $data['behanceLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'deviantArt-link'){
                    $data['deviantArtLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'pinterest-link'){
                    $data['pinterestLink'] = $meta->meta_value;
                }
                if($meta->meta_key == 'lastfm-link'){
                    $data['lastfmLink'] = $meta->meta_value;
                }
            }

            /*--EVENT SOCIAL IMAGE INFORMATION--
            $googlePlusMoreImagesLink= $this->events_model->getSocialLink('image-googleplus-link',$eventId);
            $facebookMoreImagesLink= $this->events_model->getSocialLink('image-facebook-link',$eventId);
            $twitterMoreImagesLink= $this->events_model->getSocialLink('image-twitter-link',$eventId);
            $linkedInMoreImagesLink= $this->events_model->getSocialLink('image-linkedIn-link',$eventId);
            $myspaceMoreImagesLink= $this->events_model->getSocialLink('image-myspace-link',$eventId);
            $youtubeMoreImagesLink= $this->events_model->getSocialLink('image-youtube-link',$eventId);
            $vimeoMoreImagesLink= $this->events_model->getSocialLink('image-vimeo-link',$eventId);
            $flickrMoreImagesLink= $this->events_model->getSocialLink('image-flickr-link',$eventId);
            $behanceMoreImagesLink= $this->events_model->getSocialLink('image-behance-link',$eventId);
            $deviantArtMoreImagesLink= $this->events_model->getSocialLink('image-deviantArt-link',$eventId);
            $pinterestMoreImagesLink= $this->events_model->getSocialLink('image-pinterest-link',$eventId);
            $lastfmMoreImagesLink= $this->events_model->getSocialLink('image-lastfm-link',$eventId);

            $data['googlePlusMoreImagesLink'] = $googlePlusMoreImagesLink;
            $data['facebookMoreImagesLink'] = $facebookMoreImagesLink;
            $data['twitterMoreImagesLink'] = $twitterMoreImagesLink;
            $data['linkedInMoreImagesLink'] = $linkedInMoreImagesLink;
            $data['myspaceMoreImagesLink'] = $myspaceMoreImagesLink;
            $data['youtubeMoreImagesLink'] = $youtubeMoreImagesLink;
            $data['vimeoMoreImagesLink'] = $vimeoMoreImagesLink;
            $data['flickrMoreImagesLink'] = $flickrMoreImagesLink;
            $data['behanceMoreImagesLink'] = $behanceMoreImagesLink;
            $data['deviantArtMoreImagesLink'] = $deviantArtMoreImagesLink;
            $data['pinterestMoreImagesLink'] = $pinterestMoreImagesLink;
            $data['lastfmMoreImagesLink'] = $lastfmMoreImagesLink;
*/
            /*--EVENT SOCIAL VIDEO INFORMATION--
            $googlePlusMoreVideosLink= $this->events_model->getSocialLink('video-googleplus-link',$eventId);
            $facebookMoreVideosLink= $this->events_model->getSocialLink('video-facebook-link',$eventId);
            $twitterMoreVideosLink= $this->events_model->getSocialLink('video-twitter-link',$eventId);
            $linkedInMoreVideosLink= $this->events_model->getSocialLink('video-linkedIn-link',$eventId);
            $myspaceMoreVideosLink= $this->events_model->getSocialLink('video-myspace-link',$eventId);
            $youtubeMoreVideosLink= $this->events_model->getSocialLink('video-youtube-link',$eventId);
            $vimeoMoreVideosLink= $this->events_model->getSocialLink('video-vimeo-link',$eventId);
            $flickrMoreVideosLink= $this->events_model->getSocialLink('video-flickr-link',$eventId);
            $behanceMoreVideosLink= $this->events_model->getSocialLink('video-behance-link',$eventId);
            $deviantArtMoreVideosLink= $this->events_model->getSocialLink('video-deviantArt-link',$eventId);
            $pinterestMoreVideosLink= $this->events_model->getSocialLink('video-pinterest-link',$eventId);
            $lastfmMoreVideosLink= $this->events_model->getSocialLink('video-lastfm-link',$eventId);

            $data['googlePlusMoreVideosLink'] = $googlePlusMoreVideosLink;
            $data['facebookMoreVideosLink'] = $facebookMoreVideosLink;
            $data['twitterMoreVideosLink'] = $twitterMoreVideosLink;
            $data['linkedInMoreVideosLink'] = $linkedInMoreVideosLink;
            $data['youtubeMoreVideosLink'] = $youtubeMoreVideosLink;
            $data['myspaceMoreVideosLink'] = $myspaceMoreVideosLink;
            $data['vimeoMoreVideosLink'] = $vimeoMoreVideosLink;
            $data['flickrMoreVideosLink'] = $flickrMoreVideosLink;
            $data['behanceMoreVideosLink'] = $behanceMoreVideosLink;
            $data['deviantArtMoreVideosLink'] = $deviantArtMoreVideosLink;
            $data['pinterestMoreVideosLink'] = $pinterestMoreVideosLink;
            $data['lastfmMoreVideosLink'] = $lastfmMoreVideosLink;
*/
            /*--EVENT SOCIAL AUDIO INFORMATION--
            $googlePlusMoreAudioLink= $this->events_model->getSocialLink('audio-googleplus-link',$eventId);
            $facebookMoreAudioLink= $this->events_model->getSocialLink('audio-facebook-link',$eventId);
            $twitterMoreAudioLink= $this->events_model->getSocialLink('audio-twitter-link',$eventId);
            $linkedInMoreAudioLink= $this->events_model->getSocialLink('audio-linkedIn-link',$eventId);
            $myspaceMoreAudioLink= $this->events_model->getSocialLink('audio-myspace-link',$eventId);
            $youtubeMoreAudioLink= $this->events_model->getSocialLink('audio-youtube-link',$eventId);
            $vimeoMoreAudioLink= $this->events_model->getSocialLink('audio-vimeo-link',$eventId);
            $flickrMoreAudioLink= $this->events_model->getSocialLink('audio-flickr-link',$eventId);
            $behanceMoreAudioLink= $this->events_model->getSocialLink('audio-behance-link',$eventId);
            $deviantArtMoreAudioLink= $this->events_model->getSocialLink('audio-deviantArt-link',$eventId);
            $pinterestMoreAudioLink= $this->events_model->getSocialLink('audio-pinterest-link',$eventId);
            $lastfmMoreAudioLink= $this->events_model->getSocialLink('audio-lastfm-link',$eventId);

            $data['googlePlusMoreAudioLink'] = $googlePlusMoreAudioLink;
            $data['facebookMoreAudioLink'] = $facebookMoreAudioLink;
            $data['twitterMoreAudioLink'] = $twitterMoreAudioLink;
            $data['linkedInMoreAudioLink'] = $linkedInMoreAudioLink;
            $data['myspaceMoreAudioLink'] = $myspaceMoreAudioLink;
            $data['youtubeMoreAudioLink'] = $youtubeMoreAudioLink;
            $data['vimeoMoreAudioLink'] = $vimeoMoreAudioLink;
            $data['flickrMoreAudioLink'] = $flickrMoreAudioLink;
            $data['behanceMoreAudioLink'] = $behanceMoreAudioLink;
            $data['deviantArtMoreAudioLink'] = $deviantArtMoreAudioLink;
            $data['pinterestMoreAudioLink'] = $pinterestMoreAudioLink;
            $data['lastfmMoreAudioLink'] = $lastfmMoreAudioLink;
*/
            /*--EVENT INFORMATION--*/
            $keywords = $this->events_model->getEventKeywords($eventId);
            $photos = $this->events_model->getEventPhotos($eventId);
            $featuredVideo = $this->events_model->getEventVideo($eventId);
            $featuredaudio = $this->events_model->getEventAudio($eventId);
            $eventupdates = $this->events_model->getEventUpdates($eventId);
            $numEventUpdates = $this->events_model->countEventUpdates($eventId);
            $eventComments = $this->events_model->getEventComments($eventId);
            $numEventComments = $this->events_model->countEventComments($eventId);
            $eventFavourites = $this->events_model->getCountEventFavourites($eventId);
            $eventViews = $this->stats_model->getTotalStats($eventId,'event-full-view');
            $eventDates = $this->events_model->getEventDates($eventId);

            $data['keywords'] = $keywords;
            $data['photos'] = $photos;
            $data['video'] = $featuredVideo;
            $data['audio'] = $featuredaudio;
            $data['eventupdates'] = $eventupdates;
            $data['numEventUpdates'] = $numEventUpdates;
            $data['eventcomments'] = $eventComments;
            $data['numEventComments'] = $numEventComments;
            $data['eventCreatorId'] = $userId;
            $data['eventFavourites'] = $eventFavourites;
            $data['eventViews'] = $eventViews;
            $data['theUserId'] = $this->session->userdata('user_id');
            $data['eventDates'] = $eventDates;

            if($this->session->userdata('user_id')){
                $checkFavourite = $this->events_model->checkIfEventFavourite($eventId,$this->session->userdata('user_id'));
                $data['isFav'] = $checkFavourite;
            }

            /*---GET USER EVENTS----*/
            $eventData = $this->events_model->getEventData($eventId);
            //print_r($eventData->event_image);

            $data['eventData'] = $eventData;

            $data['page_title'] = "Event Information";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

            $data = array_merge($data, $menu);

            /*---LOAD VIEWS---*/

            $this->load->view('eventNew',$data);

        }
		
		function allEventUpdates(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---EVENT CREATOR INFORMATION---*/
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
			
			/*--EVENT INFORMATION--*/
			$eventupdates = $this->events_model->getEventUpdates($eventId,0);
			$numEventUpdates = $this->events_model->countEventUpdates($eventId);
			$eventData = $this->events_model->getEventData($eventId);
			
			$data['eventData'] = $eventData;
			$data['eventupdates'] = $eventupdates;
			$data['numEventUpdates'] = $numEventUpdates;
			$data['eventCreatorId'] = $userId;
			$data['theUserId'] = $this->session->userdata('user_id');
						
			$data['page_title'] = "All Event Updates";

            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);

			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('event_updates'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function allEventComments(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---EVENT CREATOR INFORMATION---*/
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
			
			/*--EVENT INFORMATION--*/
			$eventcomments = $this->events_model->getEventComments($eventId,0);
			$eventData = $this->events_model->getEventData($eventId);
			
			$data['eventData'] = $eventData;
			$data['eventcomments'] = $eventcomments;
			$data['eventCreatorId'] = $userId;
			$data['theUserId'] = $this->session->userdata('user_id');
						
			$data['page_title'] = "All Event Updates";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);

			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('event_comments'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function add(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$access = $this->session->userdata('access');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$location = $this->profile_model->getLocation($userId);
			$gender = $this->profile_model->getGender($userId);
			$age = $this->profile_model->getAge($userId);

			$data['showdomId'] = $showdomId;
			$data['location'] = $location;
			$data['gender'] = $gender;
			$data['age'] = $age;
			$data['access'] = $access;

			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$data['events'] = $events;
			
			$data['page_title'] = "Add Event";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);

			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addevent'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function postingType(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			$eventPostingType= $this->events_model->getEventPostingType($id);
			
			$data['eventId'] = $id;			
			$data['showdomId'] = $showdomId;
			$data['eventPostingType'] = $eventPostingType;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$data['events'] = $events;
			
			$data['page_title'] = "Event Type";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventPostingType'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
						
		function edit(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$id = $this->uri->segment(3);
			$data['eventId'] = $id;
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$location = $this->profile_model->getLocation($userId);
			$gender = $this->profile_model->getGender($userId);
			$age = $this->profile_model->getAge($userId);
			$access = $this->session->userdata('access');
            $dates = $this->events_model->getEventDates($id);
						
			$data['showdomId'] = $showdomId;
			$data['location'] = $location;
			$data['gender'] = $gender;
			$data['age'] = $age;
			$data['access'] = $access;
            $data['dates'] = $dates;

			/*---GET USER EVENTS----*/
			$events = $this->events_model->getEventInfo($id);
			$data['events'] = $events;
			
			$keywords = $this->events_model->getEventKeywords($id);
			$data['keywords'] = $keywords;
			
			$data['page_title'] = "Edit Event";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('editevent'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function delete(){
			$this->user->checkLogin();
			
			$id = $this->uri->segment(3);
			$deleteEvent = $this->events_model->deleteEvent($id);
            if($this->uri->segment(4)){
                redirect('mobile/myProfile');
            }else{
                redirect('profile');
            }

		}
		
		function postingTypeSelect(){
			$id = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$this->events_model->updateEventPostingType($id,$type);
			
			if($type == 1){
				redirect('events/createAd/'.$id.'');
			}else{
				redirect('events/eventPhotos/'.$id.'');
			}
		}
		
		function createAd(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			$data['page_title'] = "Create Event Ad";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$adExists = $this->ads_model->eventAdExists($id);
			if(count($adExists) == 1){
				redirect('events/editEventAd/'.$id.'');
			}
			
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventAd'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function editEventAd(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			$data['page_title'] = "Edit Event Ad";
			
			$adExists = $this->ads_model->eventAdExists($id);
			$adid = $adExists[0]->ad_id;
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			$getAdKeywords = $this->ads_model->getAdKeywords($adid);
			$getAdContent = $this->ads_model->getAdContent($adid);
			$getAdCategories = $this->ads_model->getAdCategories($adid);
			$getAdSubCategories = $this->ads_model->getAdSubCategories($adid);
			$getAdLocations = $this->ads_model->getAdLocations($adid);
			
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
			$this->load->view('editEventAd'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function eventPayment(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
						
			$adId = $this->ads_model->getLastUserAd($userId);			
						
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$data['events'] = $events;
			
			$data['page_title'] = "Pay For Event";
			
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
			
			if($this->uri->segment(4)){
				$data['message'] = 'The code you have entered does not match our records';
			}
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventPayment'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function eventPaymentComplete(){
			$this->user->checkLogin();
			$adId = $_GET['item_number'];
			$eventId = $this->ads_model->getEventIdFromAdId($adId);
			
			$updateAdStatus = $this->ads_model->adPaymentComplete($adId);
			redirect('events/eventPhotos/'.$eventId.'');
		}
		
		function eventPhotos(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			
			$googlePlusLink= $this->events_model->getSocialLink('image-googleplus-link',$id);
			$facebookLink= $this->events_model->getSocialLink('image-facebook-link',$id);
			$twitterLink= $this->events_model->getSocialLink('image-twitter-link',$id);
			$linkedInLink= $this->events_model->getSocialLink('image-linkedIn-link',$id);
			$myspaceLink= $this->events_model->getSocialLink('image-myspace-link',$id);
			$youtubeLink= $this->events_model->getSocialLink('image-youtube-link',$id);
			$vimeoLink= $this->events_model->getSocialLink('image-vimeo-link',$id);
			$flickrLink= $this->events_model->getSocialLink('image-flickr-link',$id);
			$behanceLink= $this->events_model->getSocialLink('image-behance-link',$id);
			$deviantArtLink= $this->events_model->getSocialLink('image-deviantArt-link',$id);
			$pinterestLink= $this->events_model->getSocialLink('image-pinterest-link',$id);
			$lastfmLink= $this->events_model->getSocialLink('image-lastfm-link',$id);
			
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
			
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			$eventPostingType= $this->events_model->getEventPostingType($id);
			$data['eventPostingType'] = $eventPostingType;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$photos = $this->events_model->getEventPhotos($id);
			
			$data['events'] = $events;
			$data['photos'] = $photos;
			$data['page_title'] = "Manage Event Photos";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);

			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventPhotos'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		} 
		
		function eventAudio(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			
			$googlePlusLink= $this->events_model->getSocialLink('audio-googleplus-link',$id);
			$facebookLink= $this->events_model->getSocialLink('audio-facebook-link',$id);
			$twitterLink= $this->events_model->getSocialLink('audio-twitter-link',$id);
			$linkedInLink= $this->events_model->getSocialLink('audio-linkedIn-link',$id);
			$myspaceLink= $this->events_model->getSocialLink('audio-myspace-link',$id);
			$youtubeLink= $this->events_model->getSocialLink('audio-youtube-link',$id);
			$vimeoLink= $this->events_model->getSocialLink('audio-vimeo-link',$id);
			$flickrLink= $this->events_model->getSocialLink('audio-flickr-link',$id);
			$behanceLink= $this->events_model->getSocialLink('audio-behance-link',$id);
			$deviantArtLink= $this->events_model->getSocialLink('audio-deviantArt-link',$id);
			$pinterestLink= $this->events_model->getSocialLink('audio-pinterest-link',$id);
			$lastfmLink= $this->events_model->getSocialLink('audio-lastfm-link',$id);
			
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
			
						
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$audio = $this->events_model->getEventAudio($id);
			$eventPostingType= $this->events_model->getEventPostingType($id);
			$data['eventPostingType'] = $eventPostingType;
			
			$data['events'] = $events;
			$data['audio'] = $audio;
			$data['page_title'] = "Manage Event Audio";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			 
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventAudio'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		} 
		
		
		function eventVideo(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$id = $this->uri->segment(3);		
			
			$googlePlusLink= $this->events_model->getSocialLink('video-googleplus-link',$id);
			$facebookLink= $this->events_model->getSocialLink('video-facebook-link',$id);
			$twitterLink= $this->events_model->getSocialLink('video-twitter-link',$id);
			$linkedInLink= $this->events_model->getSocialLink('video-linkedIn-link',$id);
			$myspaceLink= $this->events_model->getSocialLink('video-myspace-link',$id);
			$youtubeLink= $this->events_model->getSocialLink('video-youtube-link',$id);
			$vimeoLink= $this->events_model->getSocialLink('video-vimeo-link',$id);
			$flickrLink= $this->events_model->getSocialLink('video-flickr-link',$id);
			$behanceLink= $this->events_model->getSocialLink('video-behance-link',$id);
			$deviantArtLink= $this->events_model->getSocialLink('video-deviantArt-link',$id);
			$pinterestLink= $this->events_model->getSocialLink('video-pinterest-link',$id);
			$lastfmLink= $this->events_model->getSocialLink('video-lastfm-link',$id);
			
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
			
						
			$data['eventId'] = $id;
			$data['showdomId'] = $showdomId;
			
			/*---GET USER EVENTS----*/
			$events = $this->events_model->getUserEvents($userId);
			$video = $this->events_model->getEventVideo($id);
			$eventPostingType= $this->events_model->getEventPostingType($id);
			$data['eventPostingType'] = $eventPostingType;
			
			$data['events'] = $events;
			$data['video'] = $video;
			$data['page_title'] = "Manage Event Video";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			 
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('addEventVideo'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		} 
		
		function addPhotos(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventPhotos = $this->events_model->addEventPhotos($id);	
			redirect('events/eventPhotos/'.$id.'');
		}
		
		
		function deletePhoto(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$photoid = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->deleteEventPhoto($eventid,$photoid);	
			redirect('events/eventPhotos/'.$eventid.'');
		}
		
		
		function addAudio(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventPhotos = $this->events_model->addEventAudio($id);	
			redirect('events/eventAudio/'.$id.'');
		}
		
		function addYoutubeAudio(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventPhotos = $this->events_model->addEventYoutubeAudio($id);	
			redirect('events/eventAudio/'.$id.'');
		}
		
		function deleteAudio(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$audioid = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->deleteEventAudio($eventid,$audioid);	
			redirect('events/eventAudio/'.$eventid.'');
		}
		
		function deleteVideo(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$videoid = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->deleteEventVideo($eventid,$videoid);	
			redirect('events/eventVideo/'.$eventid.'');
		}
		
		function addVideo(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventVideo = $this->events_model->addEventVideo($id);	
			redirect('events/eventVideo/'.$id.'');
		}
		
		function addYoutubeVideo(){
			$this->user->checkLogin();
			$id = $this->uri->segment(3);	
			$addEventVideo = $this->events_model->addEventYoutubeVideo($id);	
			redirect('events/eventVideo/'.$id.'');
		}
		
		function makeFeaturedAudio(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$audioid = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->featureEventAudio($eventid,$audioid);	
			redirect('events/eventAudio/'.$eventid.'');
		}
		
		function makeFeaturedVideo(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$videoId = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->featureEventVideo($eventid,$videoId);	
			redirect('events/eventVideo/'.$eventid.'');
		}
		
		function removeFeaturedAudio(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$audioid = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->removeFeatureEventAudio($eventid,$audioid);	
			redirect('events/eventAudio/'.$eventid.'');
		}
		
		function removeFeaturedVideo(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$video_id = $this->uri->segment(4);	
			$addEventPhotos = $this->events_model->removeFeatureEventVideo($eventid,$video_id);	
			redirect('events/eventVideo/'.$eventid.'');
		}
		
		function addMoreOnLinks(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$updateUser = $this->events_model->updateMoreOnLinks($eventid);
			redirect($_POST['redirect']);
		}
		
		function addEvent(){
			extract($_POST);
			$addEvent = $this->events_model->addEvent();
						
			if($addEvent != FALSE){
                //redirect('events/postingType/'.$addEvent.'');
				redirect('events/eventPhotos/'.$addEvent.'');
                			
            }else{
				redirect('events/add');
			}
		}
		
		function manageAd(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			$id = $this->uri->segment(3);
			$data['eventId'] = $id;
			/*---PROFILE INFORMATION---*/
			$userId = $this->session->userdata('user_id');
			$showdomId= $this->profile_model->getShowdomId($userId);
			$eventPostingType= $this->events_model->getEventPostingType($id);
			
			$ads = $this->ads_model->getAdByEvent($id);
			$data['ads'] = $ads; 
			
			$data['eventPostingType'] = $eventPostingType;
			
			/*---GET USER EVENTS----*/
			
			$data['page_title'] = "Manage Ad";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('editManageAd'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');	
		}
		
		function editAd(){
			$this->user->checkLogin();
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();

			$adId = $this->uri->segment(3);	
			$ad = $this->ads_model->getAd($adId);
			$getAdCategories = $this->ads_model->getAdCategories($adId);
			$getAdSubCategories = $this->ads_model->getAdSubCategories($adId);
			$getAdKeywords = $this->ads_model->getAdKeywords($adId);
			$getAdLocations = $this->ads_model->getAdLocations($adId);
			
			$data['eventId'] = $ad->event_id;
			$data['getAdCategories'] = $getAdCategories;
			$data['getAdSubCategories'] = $getAdSubCategories;
			$data['keywords'] = $getAdKeywords;
			$data['ad'] = $ad; 
			$data['page_title'] = "Edit Ad";
			
			$adSizes = $this->ads_model->getAdSizes();
			$adCategories = $this->ads_model->getAllCategories();
			$adSubCategories = $this->ads_model->getAllSubCategories();
			
			$data['adSizes'] = $adSizes; 
			$data['adCategories'] = $adCategories; 
			$data['adSubCategories'] = $adSubCategories; 
			$data['getAdLocations'] = $getAdLocations;
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('editEventAd'); 
			//$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function adStats(){
			$this->user->checkLogin();
			
			$adId = $this->uri->segment(3);	
			$menu = $this->mainmenu->getMainMenu();
			
			/*--STAT INFORMATION--*/
			$ad = $this->ads_model->getAd($adId);
			$data['eventId'] = $ad->event_id;
			$data['ad'] = $ad; 
			
			$totalViews = $this->stats_model->getTotalStats($adId,'ad-view');	
			$totalViewsBreakdown = $this->stats_model->getTotalStatsBreakdown($adId,'ad-view');
			$totalClicks = $this->stats_model->getTotalStats($adId,'ad-click');	
			$totalClicksdown = $this->stats_model->getTotalStatsBreakdown($adId,'ad-click');		
			$adSizes = $this->ads_model->getAdSizes();
            $adLocation = $this->ads_model->getAdReachout($adId);
			
			$data['adSizes'] = $adSizes; 
			$data['totalViews'] = $totalViews;
			$data['totalViewsBreakdown'] = $totalViewsBreakdown;
			$data['totalClicks'] = $totalClicks;
			$data['totalClicksdown'] = $totalClicksdown;
            $data['adLocation'] = $adLocation;
			$data['page_title'] = "Ad Statistics";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('eventAdStats'); 
			//$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function addEventUpdate(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$limit = $this->uri->segment(4);	
			$addEventUpdate = $this->events_model->addEventUpdate($eventid);	
			$reloadEventUpdates = $this->events_model->getEventUpdates($eventid,$limit);
			echo json_encode($reloadEventUpdates);
		}
		
		function addEventComment(){
			$this->user->checkLogin();
			$eventid = $this->uri->segment(3);	
			$limit = $this->uri->segment(4);
			$addEventUpdate = $this->events_model->addEventComment($eventid);	
			$reloadEventUpdates = $this->events_model->getEventComments($eventid,$limit);
			
			$results = '';
			foreach($reloadEventUpdates as $reloadEventUpdate){
				$results .= '<div>';
					$results .= '<img class="userCommentImage" src="'.base_url().image("themes/showdom/images/users/".$reloadEventUpdate->showdom_id."/".$reloadEventUpdate->image."", 60 , 60 ).'" />';
					$results .= '<a href="'.base_url().'index.php/profile/view/'.$reloadEventUpdate->showdom_id.'">'.$reloadEventUpdate->showdom_id.'</a>';
					$results .= '<p>'.$reloadEventUpdate->meta_value;
					$results .= '<br/>';
					$results .= '<span>POSTED: '.$reloadEventUpdate->meta_timestamp.'</span></p>';
				$results .= '</div>';
			}
			//print_r($results);
			echo $results; 
		}
				
		function editEvent(){
			$this->user->checkLogin();
			
			extract($_POST);
			$addEvent = $this->events_model->editEvent();
			
			if($addEvent == TRUE){
                //redirect('events/postingType/'.$_POST['eventid'].'');
				redirect('events/eventPhotos/'.$_POST['eventid'].'');
			}else{
				redirect('events/edit/'.$_POST['eventid'].'');
			}
		}
				
		function getEventCategories(){
			$cats = json_encode($this->events_model->getCategories());
			echo $cats;
		}
		
		function getEventSubCategories(){
			$this->user->checkLogin();
			
			$id = $this->uri->segment(3);
			$cats = json_encode($this->events_model->getSubCategories($id));
			echo $cats;
		}
		
		function getMarkers(){
			$distance = $_POST['distance'];
			$lat = $_POST['lat'];
			$lng = $_POST['lng'];
			$events = $this->events_model->getEvents($lat,$lng,$distance);	
			$events = json_encode($events);
			echo $events;
		}
		
		function searchMarkers(){
			$distance = $_POST['distance'];
			$lat = $_POST['lat'];
			$lng = $_POST['lng'];

			$searchString = $_POST['searchString'];
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			$anyDate = $_POST['anyDate'];
			$twelvehour = $_POST['twelvehour'];
			$featured = $_POST['featured'];
            $subCats = $_POST['subCats'];
			$cats = $_POST['cats'];
			
			$events = $this->events_model->searchEvents($lat,$lng,$distance,$searchString,$startDate,$endDate,$anyDate,$cats,$twelvehour,$featured,$subCats);
			$events = json_encode($events);
			echo $events;
		}
		
		function stats(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
						
			/*---EVENT CREATOR INFORMATION---*/
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
						
			/*----EVENT INFORMATION--*/
			$eventData = $this->events_model->getEventData($eventId);			
			$data['eventData'] = $eventData;
			$eventFavourites = $this->events_model->getCountEventFavourites($eventId);
			$data['eventFavourites'] = $eventFavourites;
			
			
			
			/*--STAT INFORMATION--*/
			$data['theUserId'] = $this->session->userdata('user_id');
			
			$totalFullViews = $this->stats_model->getTotalStats($eventId,'event-full-view');	
			$totalFullViewsBreakdown = $this->stats_model->getTotalStatsBreakdown($eventId,'event-full-view');		
			
			$totalQuickViews = $this->stats_model->getTotalStats($eventId,'event-quick-view');		
			$totalQuickViewsBreakdown = $this->stats_model->getTotalStatsBreakdown($eventId,'event-quick-view');			
			$totalComments = $this->stats_model->totalComments($eventId);
			
			$totalFavouriteBreakdown = $this->stats_model->getTotalStatsBreakdown($eventId,'favourite');
			
			$data['totalFullViews'] = $totalFullViews;
			$data['totalFullViewsBreakdown'] = $totalFullViewsBreakdown;
			$data['totalQuickViews'] = $totalQuickViews;
			$data['totalQuickViewsBreakdown'] = $totalQuickViewsBreakdown;
			$data['totalComments'] = $totalComments;
			$data['totalFavouriteBreakdown'] = $totalFavouriteBreakdown;
			
			$data['page_title'] = "Event Statistics";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('stats'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function claim(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*--- STATISTICS---*/
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}else{
				redirect('home');
			}
			
			/*---EVENT CREATOR INFORMATION---*/
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
			
			
			/*--EVENT INFORMATION--*/
			$keywords = $this->events_model->getEventKeywords($eventId);
			$photos = $this->events_model->getEventPhotos($eventId);
			$featuredVideo = $this->events_model->getEventVideo($eventId);
			$featuredaudio = $this->events_model->getEventAudio($eventId);
			$eventupdates = $this->events_model->getEventUpdates($eventId);
			$numEventUpdates = $this->events_model->countEventUpdates($eventId);
			$eventComments = $this->events_model->getEventComments($eventId);
			$numEventComments = $this->events_model->countEventComments($eventId);
			$eventFavourites = $this->events_model->getCountEventFavourites($eventId);
			
			$data['keywords'] = $keywords;
			$data['photos'] = $photos;
			$data['video'] = $featuredVideo;
			$data['audio'] = $featuredaudio;
			$data['eventupdates'] = $eventupdates;
			$data['numEventUpdates'] = $numEventUpdates;
			$data['eventcomments'] = $eventComments;
			$data['numEventComments'] = $numEventComments;
			$data['eventCreatorId'] = $userId;
			$data['eventFavourites'] = $userId;
			$data['theUserId'] = $this->session->userdata('user_id');
			
			/*---GET USER EVENTS----*/
			$eventData = $this->events_model->getEventData($eventId);
			//print_r($eventData->event_image);
			
			$data['eventData'] = $eventData;
			
			$data['page_title'] = "Event Information";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('event_claim'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}
		
		function claimSubmit(){
			$this->user->checkLogin();
			$id = $_POST['eventId'];
			$this->events_model->claimEventSubmit($id);	
			redirect('events/claimEventComplete/'.$id.'');
		}
		
		function claimEventComplete(){
			$eventId = $this->uri->segment(3);	
			$userId = $this->events_model->getUserIdFromEvent($eventId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
			
			/*--- STATISTICS---*/
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}else{
				redirect('home');
			}
			
			/*---EVENT CREATOR INFORMATION---*/
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
			
			
			/*--EVENT INFORMATION--*/
			$keywords = $this->events_model->getEventKeywords($eventId);
			$photos = $this->events_model->getEventPhotos($eventId);
			$featuredVideo = $this->events_model->getEventVideo($eventId);
			$featuredaudio = $this->events_model->getEventAudio($eventId);
			$eventupdates = $this->events_model->getEventUpdates($eventId);
			$numEventUpdates = $this->events_model->countEventUpdates($eventId);
			$eventComments = $this->events_model->getEventComments($eventId);
			$numEventComments = $this->events_model->countEventComments($eventId);
			$eventFavourites = $this->events_model->getCountEventFavourites($eventId);
			
			$data['keywords'] = $keywords;
			$data['photos'] = $photos;
			$data['video'] = $featuredVideo;
			$data['audio'] = $featuredaudio;
			$data['eventupdates'] = $eventupdates;
			$data['numEventUpdates'] = $numEventUpdates;
			$data['eventcomments'] = $eventComments;
			$data['numEventComments'] = $numEventComments;
			$data['eventCreatorId'] = $userId;
			$data['eventFavourites'] = $userId;
			$data['theUserId'] = $this->session->userdata('user_id');
			
			/*---GET USER EVENTS----*/
			$eventData = $this->events_model->getEventData($eventId);
			//print_r($eventData->event_image);
			
			$data['eventData'] = $eventData;
			
			$data['page_title'] = "Event Information";
            $data['listViewWidth'] = get_cookie('listViewWidth', FALSE);
            $data['listViewOpen'] = get_cookie('listViewOpen', FALSE);
			$data = array_merge($data, $menu);
			
			/*---LOAD VIEWS---*/
			$this->load->view('userheader',$data);
			$this->load->view('home_view');
			$this->load->view('event_claim_complete'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}

        function reportEvent(){
            $eventId = $this->uri->segment(3);

            if($this->session->userdata('user_id')){
                $userId = $this->session->userdata('user_id');
            }else{
                $userId = 0;
            }

            $data = $this->map->mapSetUp();
            $menu = $this->mainmenu->getMainMenu();
            $data['eventId'] = $eventId;
            $data['page_title'] = "Report Event";
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
            $this->load->view('event_report_now');
            $this->load->view('rightbuttons');
            $this->load->view('footer');
        }
		
		function report(){
			$eventId = $this->uri->segment(3);	
			if($this->session->userdata('user_id')){
				$userId = $this->session->userdata('user_id');
			}else{
				$userId = 0;
			}
			
			$this->events_model->reportEvent($eventId,$userId);
			
			$data = $this->map->mapSetUp();
			$menu = $this->mainmenu->getMainMenu();
						
			$data['page_title'] = "Report Event";
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
			$this->load->view('event_report'); 
			$this->load->view('rightbuttons');
			$this->load->view('footer');
		}

        function reloadSubCats(){
            extract($_POST);
            $subCats = $this->events_model->getSearchCategories($cats);
            echo json_encode($subCats);
        }
		
	}  
?>