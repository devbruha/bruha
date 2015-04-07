<?php  
class justshows_scraper extends CI_Model {  

	function justshows_scraper() 
	{  
		parent::__construct(); 
		$this->load->library(array('session','geocode'));
		include_once('DOM/simple_html_dom.php');
	}     
    //*******-----------------------------------******//
    // The following functions parse the time string scraped 
    // using   $temp_time=$result->find('span[class=dtstart]',0) to extract
    // specific date month year etc  as described in their function names
    // These are called in the foreach loop
    
     function scrape_time($text){
    //Regex search for text between the strin 'title="' and '"' - this returns a string of date time text that
    // then needs to be further parsed
        if ($text=preg_match('/title="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            return $output;
        }
    }
    
    function parse_location($text){
        if ($text=preg_match('/href="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            return $output;
        }
    }
    
    function parse_hour($text){
        // Use php functionality to extract 5 characters starting from the 11th character position
        $output=mb_substr($text,11,5);
        return $output;
        
    }
    
    function parse_month($text){
        // Use php functionality to extract 2 characters starting from the 5th character position
        $output=mb_substr($text,5,2);
        return $output;
        
    }
    
    function parse_day($text){
        $output=mb_substr($text,8,2);
        return $output;
    }
    
    function parse_year($text){
        //from 2013-05-05T11:00:00-04:00
        $output=mb_substr($text,0,4);
        return $output;
    }
	
	function justshows_main(){
	   //Set url for crawl, and loat html objects.. Initialise file pointer with "write" capabilities
		$url = 'http://www.justshows.com/toronto/';
		$url2 = 'http://www.justshows.com';
	    echo "Running this<br/>";
		$html = file_get_html($url);
        echo "Now Running this <br/>";
		$fp = fopen('justshows_data.csv', 'w');
		
		//write the header of the csv
		$output = "eventName,eventCategory,eventSubCategory,eventWebsite,eventTicketLink,eventStartMonth,eventStartDay,eventStartYear,eventEndMonth,eventEndDay,eventEndYear,eventStartTime,eventEndTime,eventLocation,eventCreatorType,eventKeywords,claimEvent,eventDescription,ageRestricted,longitude,latitude\n";
		fwrite($fp, $output );
		
		foreach($html->find('li[class=vevent]') as $result) {
			/*if (preg_match("/.{2,4}/", "Hello World!", $matches)) {
				echo "Match was found <br />";
				echo $matches[0];
			}*/  
			
			//Scrape data using the SimpleDOM library - this is easiest, but requires data fields to be separated by
			//html tags - in some cases info is contained in the tag themselves, in which case we use Regular Expressions (regex) and php parsing functionality to strip relavent info
			
			// Search for the tag <span> with the class= description - from these results, take the innertext between tags
			$title= $result->find('strong[class=summary]',0)->innertext;
			//echo "$title";
			
			// Search for the tag <strong> with the class= location - from these results, take the innertext between tags
			$venue = $result->find('strong[class=location]',0)->innertext;
            
		//	echo "$venue";
			
			// Get event covercharge
			$price = $result->find('span[class=venue-meta]',0)->innertext;
			//echo "$price<br/>";
			
			//Location of the event is contained in an inner url. So first get the sub url
			$location_url=$this->parse_location($result);
			//echo "$location_url<br/>";
			//Concatenate with the base url
			$full_location_url = $url2 . $location_url;
			//echo "$full_location_url<br/>";
			
			//Start searching within the url
			$html2=file_get_html($full_location_url);
			foreach($html2->find('div[class=show-venue-box]') as $result2)
            {
                $street_address = $result2->find('span[class=street-address]',0)->innertext;
                $street_address = $street_address . "Toronto, ON";
                $latlong = $this->geocode->setAddress(urlencode($street_address));
                $latitude = $latlong[0];
                $longitude = $latlong[1];
        //        echo "$street_address";
                $description = $result2->find('div[class=show-other-details]',0);
                //echo "Description is: $description";    
            }
            /*foreach($html2->find('div[class=show-ticket-box]') as $result3)
			{
				$eventTicketLink = $result2->find('')    
			}*/
            
		//	echo "<br/>";
			//$street_address=$result->find('span[class=street-address]',0)->innertext;
			

			//Parse time data using the functions declared above, in this case the time data is pulled using SimpleDOM -> Regex -> php
			
			//Set temp_time variable to the start tag and process info
			$temp_time=$result->find('abbr[class=dtstart]',0);
			$start=$this->scrape_time($temp_time);
	//		echo "$start<br/>";
			$start_year=$this->parse_year($start);
	//		echo "$start_year<br/>"; 
			$start_month=$this->parse_month($start);
	//		echo "$start_month<br/>"; 
			$start_day= $this->parse_day($start);
	//		echo "$start_day<br/>"; 
			$start_hour= $this->parse_hour($start);
	//		echo "$start_hour<br/>"; 
			
			//Set temp_time variable to the end tag and process info
			$temp_time=$result->find('span[class=dtend]',0);
			$end = $this->scrape_time($temp_time);
			$end_year=$this->parse_year($end);
			$end_month=$this->parse_month($end);
			$end_day= $this->parse_day($end);
			$end_hour=$this->parse_hour($end);
			
			 
			
		//Store all values to a string, using " , " as delimiter - this will be used to convert to assosciative array//
		// These are formatted to fit Scotts requirements, so if you use the same variable name convention, this should be
			// correct and need not be changed
			//$counter = $counter + 1;
			//echo $counter;
			/*$output=$title." 1 , 0 , NULL , NULL , ".$start_month." , ".$start_day." , ".$start_year." , NULL , NULL , NULL, " .$start_hour." NULL , ".$venue." , ". $street_address. "Artist , NULL, 0 , ".$description." , 0 //\n";*/
		
		if ($end_year = "")
		{
		$end_year = $start_year;
		}
		
		$var0 = htmlspecialchars_decode($title);
        $var1 = "1";
        $var2 = "0";
        $var3 = "NULL";
        $var4 = "NULL";
        $var5=$start_month;
        $var6=$start_day;
        $var7=$start_year;
        $var8=$start_month;
        $var9=$start_day;
     	$var10=$start_year;
        $var11=$start_hour;
        $var12="23:59";
        $var13=htmlspecialchars_decode($venue);
     	$var14="Artist";
        $var15="NULL";
        $var16="0";
        $var17=$description;
        $var18="0";
        $var19=$longitude;
        $var20=$latitude;
		
        
		$output = array($var0,$var1,$var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15,$var16,$var17,$var18,$var19,$var20);
		echo "$output";
		fputcsv($fp,$output);
		}
	return $counter;
	}
	
}  
