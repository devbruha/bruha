<?php  
class blogto_scraper extends CI_Model {  
	function blogto_scraper()  
	{  
		parent::__construct();  
		$this->load->library(array('session','geocode'));
		include_once('DOM/simple_html_dom.php');
	}  
	
	    function scrape_time($text){
    //Regex search for text between the strin 'title="' and '"' - this returns a string of date time text that
    // then needs to be further parsed
        if ($text=preg_match('/title="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            return $output;
        }
    }
	        //AT BEGINNING OF CODE//

		function scrape_title($text){
    //Regex search for text between the strin 'title="' and '"' - this returns a string of date time text that
    // then needs to be further parsed
        if ($text=preg_match('/title="([^"]*)"/', $text, $matches)) {
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
	function blogto_main(){
	
		//Set url for crawl, and loat html objects.. Initialise file pointer with "write" capabilities
		$url = 'http://www.blogTO.com/events';
	   
		$html = file_get_html($url);
		$fp = fopen('data_blogto.csv', 'w');
		//$htmlfp = fopen('datadump_blogto.txt','w');
		
		//write the header of the csv
		$output = "eventName,eventCategory,eventSubCategory,eventWebsite,eventTicketLink,eventStartMonth,eventStartDay,eventStartYear,eventEndMonth,eventEndDay,eventEndYear,eventStartTime,eventEndTime,eventLocation,eventCreatorType,eventKeywords,claimEvent,eventDescription,ageRestricted,longitude,latitude\n";
		fwrite($fp, $output );
		
    foreach($html->find('div[class=event vevent]') as $result) {
    
        //Scrape data using the SimpleDOM library - this is easiest, but requires data fields to be separated by
        //html tags - in some cases info is contained in the tag themselves, in which case we use Regular Expressions (regex) and php parsing functionality to strip relavent info
        
        // Search for the tag <a> with the class= url summary- from these results, take the innertext between tags
        $title= $result->find('a[class=url summary]',0)->innertext;
        
        // Search for the tag <span> with the class= fn org- from these results, take the innertext between tags
        $venue = $result->find('span[class=fn org]',0)->innertext;
        
        // Search for the tag <p> with the class= description - from these results, take the innertext between tags
        $description = $result->find('p[class=description]',0)->innertext;

        //You get the picture
        $street_address=$result->find('span[class=street-address]',0)->innertext;
        

        //Parse time data using the functions declared above, in this case the time data is pulled using SimpleDOM -> Regex -> php
        
        //Set temp_time variable to the start tag and process info
        $temp_time=$result->find('span[class=dtstart]',0);
        $start=$this->scrape_time($temp_time);
        $start_year=$this->parse_year($start);
        $start_month=$this->parse_month($start);
        $start_day= $this->parse_day($start);
        $start_hour= $this->parse_hour($start);
        
        //Set temp_time variable to the end tag and process info
        $temp_time=$result->find('span[class=dtend]',0);
        $end = $this->scrape_time($temp_time);
        $end_year=$this->parse_year($end);
        $end_month=$this->parse_month($end);
        $end_day= $this->parse_day($end);
        $end_hour= $this->parse_hour($end);
		
		 //NEW LAT LONG SCRAPING//


        $longitude=$result->find('span[class=longitude]',0)->innertext;
        $latitude=$result->find('span[class=latitude]',0)->innertext;

        $latitude=$this->scrape_title($latitude);
        $longitude=$this->scrape_title($longitude);
        
    //Store all values to a string, using " , " as delimiter - this will be used to convert to assosciative array//
    // These are formatted to fit Scotts requirements, so if you use the same variable name convention, this should be
        // correct and need not be changed
        
        //$output=$title." 1 , 0 , NULL , NULL , ".$start_month." , ".$start_day." , ".$start_year." , ".$end_month." , ".$end_day." , ".$end_year." , ".$start_hour." , ".$end_hour." , ".$venue." , Artist , NULL, 0 , ".$description." , 0 \n";
        //fwrite($fp, $output );
/*"eventName,eventCategory,eventSubCategory,eventWebsite,eventTicketLink,eventStartMonth,eventStartDay,eventStartYear,eventEndMonth,eventEndDay,eventEndYear,eventStartTime,eventEndTime,eventLocation,eventCreatorType,eventKeywords,claimEvent,eventDescription,ageRestricted\n";*/
		
		$var0 = $title;
        $var1 = "1";
        $var2 = "0";
        $var3 = "NULL";
        $var4 = "NULL";
        $var5=$start_month;
        $var6=$start_day;
        $var7=$start_year;
        $var8=$end_month;
        $var9=$end_day;
     	$var10=$end_year;
        $var11=$start_hour;
        $var12=$end_hour;
        $var13=$venue;
     	$var14="Artist";
        $var15="NULL";
        $var16="0";
        $var17=$description;
        $var18="0";
		$var19=$longitude;
		$var20=$latitude;
        
        $output = array($var0,$var1,$var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15,$var16,$var17,$var18,$var19,$var20);
        
        fputcsv($fp,$output);
		}
	}
}  
