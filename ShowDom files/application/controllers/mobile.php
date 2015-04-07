<?php  
	class Mobile extends CI_Controller{
		
		function __construct(){
			parent::__construct();
            $this->clear_cache();
			$this->load->library(array('session', 'geocode', 'map', 'mainmenu'));
			$this->load->helper( array('form', 'url', 'date','image','ads','user','keywords','cookie') );
            $this->load->model(array('profile_model', 'events_model','ads_model','stats_model','content_model'));
		}

        function clear_cache(){
            $this->output->set_header("HTTP/1.0 200 OK");
            $this->output->set_header("HTTP/1.1 200 OK");
            $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_update).' GMT');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");
        }
		
		public function index(){
            if(isset($_GET['lat']) && isset($_GET['long'])){
                $newdata = array(
                    'userLat'  => $_GET['lat'],
                    'userLng'     => $_GET['long'],
                    'is_geocoded' => TRUE
                );
                $this->session->set_userdata($newdata);

                $cookie = array(
                    'name'   => 'latCookie',
                    'value'  => $_GET['lat'],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);

                $cookie = array(
                    'name'   => 'lngCookie',
                    'value'  => $_GET['long'],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);
            }

            if($this->session->flashdata('loginFail')){
                echo '<script>alert("'.$this->session->flashdata('loginFail').'");</script>';
            }
            if($this->session->userdata('validated')){
               redirect('mobile/homeMap');
            }

            $data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
            $data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
            $data = $this->map->mapSetUp();

            //echo $data['lat'];
            //echo $data['lng'];

            $data['page_title'] = 'Showdom';

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/main');
            $this->load->view('mobile/footer');
		}

        function userLogIn(){
            if(isset($_GET['lat']) && isset($_GET['long'])){
                $newdata = array(
                    'userLat'  => $_GET['lat'],
                    'userLng'     => $_GET['long'],
                    'is_geocoded' => TRUE
                );
                $this->session->set_userdata($newdata);

                $cookie = array(
                    'name'   => 'latCookie',
                    'value'  => $_GET['lat'],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);

                $cookie = array(
                    'name'   => 'lngCookie',
                    'value'  => $_GET['long'],
                    'expire' => 86500000,
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);
            }

            if($this->session->flashdata('loginFail')){
                echo '<script>alert("'.$this->session->flashdata('loginFail').'");</script>';
            }
            if($this->session->userdata('validated')){
                redirect('mobile/homeMap');
            }

            $data['rememberUsername'] = get_cookie('rememberUsername', FALSE);
            $data['rememberPassword'] = get_cookie('rememberPassword', FALSE);
            $data['bodyClass'] = 'logo';
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/home');
            $this->load->view('mobile/footer');
        }

        function login(){
            $this->load->model('login_model');
            $result = $this->login_model->validate();

            if(!$result){
                $this->session->set_flashdata('loginFail', 'Login information was incorrect.');
                redirect('mobile');
            }else{
                redirect('mobile/homeMap');
            }
        }

        function logOut(){
            $this->session->unset_userdata('validated');
            $this->session->sess_destroy();
            redirect('mobile','location');
        }

        public function createAccount(){
            $data['bodyClass'] = 'logo';
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/createAccount');
            $this->load->view('mobile/footer');
        }

        public function signUpSubmit(){
            $this->load->model('login_model');
            $result = $this->login_model->signup();

            if($result){
                $msg['message'] = $result;
                redirect('homeMap/createAccount','location');
            }else{
                $msg['message'] = 'Thank you. You can now log in.';
                echo '<script>alert("'.$msg['message'].'");</script>';
                redirect('mobile','location');
            }
        }

        public function forgotPassword(){

            $data = $this->map->mapSetUp();

            $message = $this->uri->segment(3);
            if($message != ''){
                $data['message'] = 'Thank you. Your new password has been emailed to you.';
            }

            $data['page_title'] = "Forgot Password";
            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/forgotPassword');
            $this->load->view('mobile/footer');
        }

        public function forgotPasswordSubmit(){
            $addEventPhotos = $this->profile_model->forgotPassword();
            redirect('mobile/forgotPassword/complete');
        }

        public function homeMap(){
            $data = $this->map->mapSetUp();

            //echo $data['lat'];
            //echo $data['lng'];

            $data['page_title'] = 'Showdom';

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/main');
            $this->load->view('mobile/footer');
        }

        public function homeMapNew(){
            $data = $this->map->mapSetUp();

            //echo $data['lat'];
            //echo $data['lng'];

            $data['page_title'] = 'Showdom';

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/mainNew');
            $this->load->view('mobile/footer');
        }

        public function quickPreview(){
            if($this->session->userdata('validated')){
                $userId = $this->session->userdata('user_id');
            }
            $id = $this->uri->segment(3);

            /*--- STATISTICS---*/
            if($this->session->userdata('validated')){
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
            if($this->session->userdata('validated')){
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

            $this->load->view('mobile/quickPreview',$data);

        }

        function viewEvent(){
            $eventId = $this->uri->segment(3);

            if($this->session->userdata('validated')){
                $userId = $this->session->userdata('user_id');
                $addStat = $this->stats_model->addStat($eventId,$userId,'event-full-view');
            }else{
                $addStat = $this->stats_model->addStat($eventId,0,'event-full-view');
            }

            $userId = $this->events_model->getUserIdFromEvent($eventId);


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

            if($this->session->userdata('validated')){
                $checkFavourite = $this->events_model->checkIfEventFavourite($eventId,$this->session->userdata('user_id'));
                $data['isFav'] = $checkFavourite;
            }

            /*---GET USER EVENTS----*/
            $eventData = $this->events_model->getEventData($eventId);
            //print_r($eventData->event_image);

            $data['eventData'] = $eventData;

            $data['page_title'] = "Event Information";

            /*---LOAD VIEWS---*/

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/viewEvent',$data);
            $this->load->view('mobile/footer');
        }

        function viewAjax(){
            $eventId = $this->uri->segment(3);

            if($this->session->userdata('validated')){
                $userId = $this->session->userdata('user_id');
                $addStat = $this->stats_model->addStat($eventId,$userId,'event-full-view');
            }else{
                $addStat = $this->stats_model->addStat($eventId,0,'event-full-view');
            }

            $userId = $this->events_model->getUserIdFromEvent($eventId);


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

            if($this->session->userdata('validated')){
                $checkFavourite = $this->events_model->checkIfEventFavourite($eventId,$this->session->userdata('user_id'));
                $data['isFav'] = $checkFavourite;
            }

            /*---GET USER EVENTS----*/
            $eventData = $this->events_model->getEventData($eventId);
            //print_r($eventData->event_image);

            $data['eventData'] = $eventData;

            $data['page_title'] = "Event Information";

            /*---LOAD VIEWS---*/

            $this->load->view('mobile/viewEvent',$data);
        }

        function allEventComments(){
            $eventId = $this->uri->segment(3);
            $userId = $this->events_model->getUserIdFromEvent($eventId);

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

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/viewComments',$data);
            $this->load->view('mobile/footer');
        }

        function allEventUpdates(){
            $eventId = $this->uri->segment(3);
            $userId = $this->events_model->getUserIdFromEvent($eventId);

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


            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/viewUpdates',$data);
            $this->load->view('mobile/footer');
        }

        function viewProfile(){
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

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/viewProfile',$data);
            $this->load->view('mobile/footer');
        }

        function myProfile(){
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

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/viewMyProfile',$data);
            $this->load->view('mobile/footer');
        }

        function eventStats(){
            $eventId = $this->uri->segment(3);
            $userId = $this->events_model->getUserIdFromEvent($eventId);

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

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/stats');
            $this->load->view('mobile/footer');
        }

        function eventUpdates(){
            $data['page_title'] = "Event Updates";

            $userId = $this->session->userdata('user_id');
            $data = $this->map->mapSetUp();
            $recentEventUpdates = $this->events_model->getFeaturedEvents();
            $data['recentEventUpdates'] = $recentEventUpdates;
            $data['currentPage'] = 'Featured Events';
            /*---LOAD VIEWS---*/

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/eventUpdates');
            $this->load->view('mobile/footer');
        }

        function mostViewed(){
            $data['page_title'] = "Event Updates";

            $userId = $this->session->userdata('user_id');
            $data = $this->map->mapSetUp();

            $lat = $this->input->cookie('latCookie', TRUE);
            $lng = $this->input->cookie('lngCookie', TRUE);

            $mostViewedEvents = $this->events_model->getMostViewedEvents($data['lat'],$data['lng']);
            $data['events'] = $mostViewedEvents;
            $data['currentPage'] = 'Most Viewed';
            /*---LOAD VIEWS---*/

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/mostViewedEvents');
            $this->load->view('mobile/footer');
        }

        function attending(){
            $data['page_title'] = "Event Updates";

            $userId = $this->session->userdata('user_id');
            $data = $this->map->mapSetUp();
            $favouriteEvents = $this->events_model->getUserFavourites($userId);
            $data['events'] = $favouriteEvents;
            $data['currentPage'] = 'Attending';
            /*---LOAD VIEWS---*/

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/eventsAttending');
            $this->load->view('mobile/footer');
        }

        function suggestedEvents(){
            $data['page_title'] = "Event Updates";

            $userId = $this->session->userdata('user_id');
            $data = $this->map->mapSetUp();
            $recentEventUpdates = $this->events_model->getRecentSuggestedUpdatesSimple($userId);

            $data['events'] = $recentEventUpdates;
            $data['currentPage'] = 'Suggested';
            /*---LOAD VIEWS---*/

            /*---LOAD VIEWS---*/
            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/suggestedEvents');
            $this->load->view('mobile/footer');
        }

        function about(){
            $data['page_title'] = "About Showdom";

            $content = $this->content_model->getContent(2);
            $data['content'] = $content;

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('about');
            $this->load->view('mobile/footer');
        }

        function help(){
            $data['page_title'] = "About Showdom";

            $content = $this->content_model->getContent(3);
            $data['content'] = $content;

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('help');
            $this->load->view('mobile/footer');
        }

        function advertising(){
            $data['page_title'] = "About Showdom";

            $content = $this->content_model->getContent(4);
            $data['content'] = $content;
            $contentSection = $this->content_model->getContentSections(4);
            $data['contentSection'] = $contentSection;

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('advertising');
            $this->load->view('mobile/footer');
        }

        function termsOfService(){
            $data['page_title'] = "About Showdom";

            $content = $this->content_model->getContent(5);
            $data['content'] = $content;

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/about');
            $this->load->view('mobile/footer');
        }

        function privacyPolicy(){
            $data['page_title'] = "About Showdom";

            $content = $this->content_model->getContent(6);
            $data['content'] = $content;

            $this->load->view('mobile/header',$data);
            $this->load->view('mobile/mainMenu');
            $this->load->view('mobile/about');
            $this->load->view('mobile/footer');
        }

        function reloadProfileEvents(){
            $offset = $_POST['offset'];
            $userId = $_POST['userId'];
            $events = $this->events_model->getUserEvents($userId,$offset);
            $counter = 0;
            foreach($events as $event){
                $counter ++;
                if($counter == 2 || $counter == 6){
                    echo '<div style="margin-bottom:20px; text-align: center">';
                    $keywords = getEventKeywords($event->event_id);
                    echo getRandomAd(3,$event->event_cat,$event->event_sub_cat,$keywords);
                    echo '</div>';
                }
                if($event->event_type == 1){
                    echo '<span class="featured">FEATURED</span>';
                }
                $eventDateData = getNextEventDate($event->event_id);
                echo '<span class="featured">'.convertDate($eventDateData[0]).'</span>';
                echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
                echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';

                echo '</h2>';

                echo '<div class="googleMapsInfoWindowInner clearfix">';

                echo '<div class="eventContent">';
                echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
                echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
                echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';

                echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/edit/'.$event->event_id.'">EDIT EVENT</a>';
                echo '<a style="margin-left:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/mobile/eventStats/'.$event->event_id.'">STATISTICS</a>';
                echo '<a onclick="return confirm(\'Are you sure you want to remove this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/events/delete/'.$event->event_id.'/mobile">DELETE</a>';

                echo '</div>';
                echo '</div>';
            }
        }

        function reloadViewProfileEvents(){
            $offset = $_POST['offset'];
            $userId = $_POST['userId'];
            $events = $this->events_model->getUserEvents($userId,$offset);
            $counter = 0;
            foreach($events as $event){
                $counter ++;
                if($counter == 2 || $counter == 6){
                    echo '<div style="margin-bottom:20px; text-align: center;">';
                    $keywords = getEventKeywords($event->event_id);
                    echo getRandomAd(3,$event->event_cat,$event->event_sub_cat,$keywords);
                    echo '</div>';
                }
                if($event->event_type == 1){
                    echo '<span class="featured">FEATURED</span>';
                }
                echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
                echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';

                echo '</h2>';

                $eventDateData = getNextEventDate($event->event_id);

                echo '<div class="googleMapsInfoWindowInner clearfix">';
                echo '<div class="eventLeft">';
                echo '<div class="eventDate">';
                echo convertDate($eventDateData[0]);
                echo '</div>';
                echo '<img class="eventImage" src="'.base_url().image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 200, 200).'"" />';
                echo '</div>';

                echo '<div class="eventContent">';
                echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
                echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
                echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
                echo '</div>';
                echo '</div>';
            }
        }

	}
?>