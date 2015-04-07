<?php  
class Scraper_model extends CI_Model {  
	function Scraper_model()  
	{  
		parent::__construct();  
		$this->load->library(array('session','geocode'));
		$this->load->model('events_model');
	} 
	
	public function sendemail(){
			// PHP has no native SMTP support, we recommend the SwiftMail library
			// for adding SMTP support. http://swiftmailer.org/
			//require_once '/swift/lib/swift_required.php'; 
			require_once APPPATH.'libraries/swift/lib/swift_required.php';
			// Set message recipients
			$showdomemail = 'scott.shan@gmail.com';
			
			$send_to            = array(
									$showdomemail => 'Scott Shannon'
								);
				
			// Set sender
			$sent_from          = array(
									'admin@showdom.com' => 'Showdom Admin'
								);
			 
			// Set subject and body
			$subject            = "Welcome to Showdom";
			$body               = file_get_contents('./showdomwelcome_final.html');
			
			// Set SMTP connection details
			$transport          = Swift_SmtpTransport::newInstance()
				->setHost('ssrs.reachmail.net') // Host.  This should not need to change
				->setPort(465) // Port.  Should not be changed as SwiftMail does not support starttls
				->setUsername('SHOWDOMC\\admin')
				->setPassword('Logitechthx%1')
				->setEncryption('ssl') // set the encription type.
				;
			// Create a Mailer
			$mailer             = Swift_Mailer::newInstance($transport);
			// Construct the message
			$message            = Swift_Message::newInstance()
				->setSubject($subject) // Set Subject line here
				->setContentType('text/html') // Sets the Content-Type
				->setFrom($sent_from) // Sets the sender address specified at the top
				->setTo($send_to) // Sets the recipient addresses sprecified at the top
				->setBody($body) // Sets the body of the email
				;
			// This method should be used to add addistional custom headers.
			// Use the format: $headers->addTextHeader('X-Tracking', '1'); to set other 
			// headers like X-Campaign or X-Address.
			$headers = $message->getHeaders();  
			$headers->addTextHeader('X-Tracking', '1');
			// $result will be an integer representing the number of successful recipients
			$result = $mailer->send($message);
			echo $result . "\n";
		}
		
	function addEventScript($inputvals){
		//extracts the incoming assciative array
				//print_r($inputvals);
		extract($inputvals);
		
		if($ageRestricted == 0){
			$ageRestricted == 0;
		}else{
			$ageRestricted = $minAge;
		}
		//$latlon = $this->geocode->setAddress(urlencode($eventLocation));
		
		$latlon[1] = $longitude;
		$latlon[0] = $latitude;
		
		//construct query
		$dupecheck = "SELECT * FROM tbl_events where (event_title = '$eventName')"; //AND event_start_date = '$temp_date')";
		$dupecheck = mysql_query($dupecheck);
				if (!$dupecheck) {
				die('Invalid query: ' . mysql_error());
				}
		//should check for the number of rows in the query
		$num_rows = mysql_num_rows($dupecheck);
		echo "number of rows =" . $num_rows . "</br>";
		echo $eventName . "</br>";
		//if (mysql_num_rows($dupecheck) = 0) {
			//if the event is geocoded add it
			if($latlon[0] != '' && $latlon[0] != '' && $num_rows == 0){
				$query = 'INSERT INTO tbl_events VALUES(null,
				'.$this->session->userdata('user_id').',
				"'.mysql_real_escape_string($eventName).'",
				"'.mysql_real_escape_string($eventDescription).'",
				"'.mysql_real_escape_string($eventWebsite).'",
				"'.mysql_real_escape_string($eventTicketLink).'",
				"'.mysql_real_escape_string($eventCreatorType).'", 
				"'.mysql_real_escape_string($eventLocation).'",
				"'.$latlon[0].'", 
				"'.$latlon[1].'",
				"'.$latlon[2].'",
				"",
				"",
				"",
				"",
				'.$eventCategory.',
				'.$eventSubCategory.',
				"",
				'.$ageRestricted.',
				0,
				'.$claimEvent.'
				)';

				$query = mysql_query($query);
				//print out the query
				//output an error message if the query doesn't return a value
				if (!$query) {
				die('Invalid query: ' . mysql_error());
				}
				
				$eventId = $this->events_model->getLastEvent();
				
				$dateTimeCounter = 0;
				//foreach($eventStartMonth as $eventDateTime){
					$query = mysql_query('INSERT INTO tbl_event_start_date_time VALUES(null,
					'.$eventId.',
					"'.$eventStartYear.'-'.$eventStartMonth.'-'.$eventStartDay.'",
					"'.$eventEndYear.'-'.$eventEndMonth.'-'.$eventEndDay.'",
					"'.$eventStartTime.':00",
					"'.$eventEndTime.':00"
					)');
								if (!$query) {
				die('Invalid query: ' . mysql_error());
				}
				//    $dateTimeCounter ++;
			    //}
				
				$eventFolder = str_replace(' ','-',$eventName);
				$showdomId = str_replace(' ','-',$this->session->userdata('showdom_id'));
				$eventImage = '';
				
				if($eventSubCategory == 666666){
					$query = $this->db->query('INSERT INTO tbl_event_meta VALUES(null,'.$eventId.',"event_sub_meta_other","'.$otherCategory.'",NOW(),'.$this->session->userdata('user_id').')');
				}
				
	//			$query = 'UPDATE tbl_events SET event_image = "'.$eventImage.'" WHERE event_id = '.$eventId.'';
	//			$query = mysql_query($query);
	//			
	//			if (!$query) {
	//			die('Invalid query: ' . mysql_error());
	//			}
			}
		//}
				
		/*--- keywords----*/
		$keywords = explode(',',$eventKeywords);
		
		foreach($keywords as $keyword){
			$check = $this->events_model->checkKeyword($keyword);
			if($check == 0){
				$addKeywords = mysql_query('INSERT INTO tbl_event_keywords VALUES(null,"'.mysql_real_escape_string($keyword).'")');
				$keywordid = $this->events_model->getLastKeyword($eventId);
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventId.','.mysql_real_escape_string($keywordid).')');
			}else{
				$keywordId = mysql_query('INSERT INTO tbl_event_to_keyword VALUES(null,'.$eventId.','.mysql_real_escape_string($check).')');
			}
		}
		//echo "before return";
		return $eventId;
	}
	

}