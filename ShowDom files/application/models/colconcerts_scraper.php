<?php  
class colconcerts_scraper extends CI_Model {  
	function colconcerts_scraper()  
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
    //Regex search for text between the string 'title="' and '"' - this returns a string of date time text that
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
    
    
    
    function parse_month($text){
        // Use php functionality to extract 2 characters starting from the 5th character position
        $slash = strpos($text, "/");
        $space = strpos($text, " ");
        $month = mb_substr($text,$space,$slash-$space);
        return $month;
        
    }
    
    function parse_day($text){
        $slash = strpos($text, "/");
        $day = mb_substr($text,$slash+1);
        return $day;
    }
    
    /*function parse_year($text){
        //from 2013-05-05T11:00:00-04:00
        $output=mb_substr($text,0,4);
        return $output;
    }*/
    
    function scrape_title($text){
    //Regex search for text between the string 'title="' and '"' - this returns a string of date time text that
    // then needs to be further parsed
        if ($text=preg_match('/title="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            return $output;
        }
    }
    
    function scrape_date($text)
    {
        $start = strpos($text,"<");
        if($start !== false)
        {
            $date = substr($text, 0, (strlen($text)-$start)*-1);
        }
        else
        {
            $date = $text;
        }
        return $date;
    }
    
    function parse_address($text)
    {
        if ($text=preg_match('/<br \/>(.*)<br \/>(.*)<br \/>(.*)<br \/>(.*)<br \/>/', $text, $matches))
        {
            $address=$matches[2];
            $city = $matches[3];
        }
        return $address . " " . $city;
    }
    
    function parse_show_start($text)
    {
        //echo $text;
        //echo "<br/> Running parse_show";
        if ($text=preg_match('/<\/span>(.*)/', $text, $matches))
        {
            $start=$matches[1];
            echo "<br/> Got into the if statement";
        }
        $space = strpos($start, " ");
        $show = strpos($start, "Show");
        $colon = strpos($start, "Show:");
        if($space!==FALSE && $show!==FALSE)
        {
            $start = substr($start,$space+1);
        }
        elseif($show!==FALSE)
        {
            
            $start = substr($start,$colon+5);
        }
        else
        {
            $start = $start;
        }
        $pm = strpos($start,"pm");
        $am = strpos($start,"am");
        if($am!==FALSE)
        {
            $start = substr($start,0,-3);
        }
        elseif($pm!==FALSE)
        {
            $start_hour = substr($start,0,-6)+12;
            $start_min = substr($start,strpos($start,":"));
            $start = $start_hour."".$start_min;
            $start = substr($start,0,-3);
        }
        return $start; 
    }
	
	
	 function colconcerts_main(){   
//Set url for crawl, and loat html objects.. Initialise file pointer with "write" capabilities
    $url = 'http://www.collectiveconcerts.com';
    echo "Running this<br/>";
    $html = file_get_html($url);
    echo "Now running this<br/>";
    $fp = fopen('colconcerts_data.csv', 'w');
	
			$output = "eventName,eventCategory,eventSubCategory,eventWebsite,eventTicketLink,eventStartMonth,eventStartDay,eventStartYear,eventEndMonth,eventEndDay,eventEndYear,eventStartTime,eventEndTime,eventLocation,eventCreatorType,eventKeywords,claimEvent,eventDescription,ageRestricted,longitude,latitude\n";
		fwrite($fp, $output );
    
    //foreach($html->find('div[class=list-view]') as $result) {
        //$a = 0;
        $result = $html->find('div[class=list-view]',0);
        foreach($result->find('div[class=list-view-item]') as $result2)
        {
            //Scrape data using the SimpleDOM library - this is easiest, but requires data fields to be separated by
            //html tags - in some cases info is contained in the tag themselves, in which case we use Regular Expressions (regex) and php parsing functionality to strip relavent info
            
            // Search for the tag <span> with the class= description - from these results, take the innertext between tags
            $title= $result2->find('a',0)->innertext;
            $title = $this->scrape_title($title);
            echo "$title<br/>";
            
            //Search for the tag <strong> with the class= location - from these results, take the innertext between tags
            $venue = $result2->find('h2[class=venue location]',0)->innertext;
            echo "$venue<br/>";
            
            //Get event covercharge
            if($result2->find('h3[class=price-range]',0)->innertext !== null)
            {
                $price = $result2->find('h3[class=price-range]',0)->innertext;
            }
            else
			{
                $price = $result2->find('h3[class=free]',0)->innertext;
			}
            
			echo "$price<br/>";
            
            //Location of the event is contained in an inner url. So first get the sub url
            $location_url=$this->parse_location($result2->find('a',0));
            //echo "$location_url<br/>";
            
            //Concatenate with the base url
            $full_location_url = $url . $location_url;
            //echo "$full_location_url<br/>";
                              
            //Start searching within the url
            $html2=file_get_html($full_location_url);
            $street_address = $html2->find('div[class=venue-info]',0)->innertext;
            //echo "$street_address<br/>";
            //var_dump($street_address);
            //echo "<br/>";
            $street_address = $this->parse_address($street_address);
            $latlong = $this->geocode->setAddress(urlencode($street_address));
            $latitude = $latlong[0];
            $longitude = $latlong[1];
           // echo "Street address = $street_address<br/>";
            
            $date = $this->scrape_date($result2->find('h2[class=dates]',0)->innertext);
            echo "!!!!!!!!!!!!!!!!!" . $date . "!!!!!!!!!!!";
            $start_month = $this->parse_month($date);
         //   echo $date;
        //    echo "<br/>";
        //    echo $start_month;
            $start_day = $this->parse_day($date);
            echo "<br/>";
            echo $start_day;
            echo "<br/>";
            $doors = $result2->find('span[class=doors]',0)->innertext;
            echo $doors;
            echo "<br/>";
            //$text2 = (string)$result2->find('span[class=start]',0)->innertext;
            //echo $text2;
            //$text3 = 'Hello';
            $start_hour = $this->parse_show_start($result2->find('span[class=start]',0)->innertext);
            
            //$start_hour = parse_show_start($text3);
            echo "<br/>";
            echo $start_hour;
            //$start_hour = $result2->find('span[class=start]',0)->innertext;

            print_r($start_hour);
         //   echo "<br/>";
        //    echo $doors . " - " . $start_hour;
            
        //    echo "<br/><br/>";

            
            
        //    echo "<br/>";
            //$street_address=$result->find('span[class=street-address]',0)->innertext;
            

            
            
            $output=$title." 1 , 0 , NULL , NULL , ".$start_month." , ".$start_day." , 
            NULL , NULL , NULL , NULL, " .$start_hour." NULL , ".$venue." , ".
            $street_address. "Artist , NULL, 0 , NULL , 0 \n";
        
		$var0 = htmlspecialchars_decode($title);
        $var1 = "1";
        $var2 = "0";
        $var3 = "NULL";
        $var4 = "NULL";
        $var5=$start_month;
        $var6=$start_day;
        $var7="2013";
        $var8=$start_month;
        $var9=$start_day;
     	$var10="2013";
        $var11=$start_hour;
        $var12="23:59";
        $var13=$venue;
     	$var14="Artist";
        $var15="NULL";
        $var16="0";
        $var17=htmlspecialchars_decode($description);
        $var18="0";
        $var19=$longitude;
        $var20=$latitude;
        
        $output = array($var0,$var1,$var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15,$var16,$var17,$var18,$var19,$var20);
        
		fputcsv($fp,$output);

        }
		
		
    }
	   

}  
