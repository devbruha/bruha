<?php  
class nowtorontoart_scraper extends CI_Model {  
    //include_once('DOM/simple_html_dom.php');
    function nowtorontoart_scraper() 
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
        if ($text=preg_match('/content="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            $output=mb_substr($output,5,2);
            return $output;
        };
        
    }
    
    function parse_day($text){
        if ($text=preg_match('/content="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            $output=mb_substr($output,8,2);
            return $output;
        };
    }
    
    function parse_year($text){
        if ($text=preg_match('/content="([^"]*)"/', $text, $matches)) {
            $output=$matches[1];
            $output=mb_substr($output,0,4);
            return $output;
        };
    }
    
    function nowtorontoart_main(){
       //Set url for crawl, and loat html objects.. Initialise file pointer with "write" capabilities
        $url = 'http://www.nowtoronto.com/art/listings/';
        //echo "running this";
        $html = file_get_html($url);
        $fp = fopen('nowtoronto_art_data.csv', 'w');
        
        //write the header of the csv
        $output = "eventName,eventCategory,eventSubCategory,eventWebsite,eventTicketLink,eventStartMonth,eventStartDay,eventStartYear,eventEndMonth,eventEndDay,eventEndYear,eventStartTime,eventEndTime,eventLocation,eventCreatorType,eventKeywords,claimEvent,eventDescription,ageRestricted,longitude,latitude\n";
        fwrite($fp, $output );
        
        foreach($html->find('div[class=listing-readmore]') as $result) {
            /*if (preg_match("/.{2,4}/", "Hello World!", $matches)) {
                echo "Match was found <br />";
                echo $matches[0];
            }*/  
            
            $url2=$url.$this->parse_location($result);
            $html2=file_get_html($url2);
            foreach($html2->find('div[id=leftColFrame]') as $result2)
            {
                $title=$result2->find('span[property=v:summary]',0)->innertext;
                foreach($result2->find('span[property=v:datestart]')as $result3)
                {
                    $start_month=$this->parse_month($result3);
                    $start_day=$this->parse_day($result3);
                    $start_year=$this->parse_year($result3);
                }
                $venue=$result2->find('span[property=v:name]',0)->innertext;
                echo "Month: ".$start_month."<br/>";
                echo "Day: ".$start_day."<br/>";
                echo "Year: ".$start_year."<br/>";
                echo "Venue: ".$venue."<br/>";
                $street_address = $result2->find('span[property=v:street-address]',0)->innertext;
                $city = $result2->find('span[property=v:locality]',0)->innertext;
                $street_address = $street_address . " ".$city. ", ON";
                
                echo  "Address: ".$street_address."<br/>";
                $latlong = $this->geocode->setAddress(urlencode($street_address));
                $latitude = $latlong[0];
                $longitude = $latlong[1];
        //        echo "$street_address";
                //$description = $result2->find('div[class=show-other-details]',0);
                //echo "Description is: $description"; */   
            }
            
            
        
             
            
        
       /* if ($end_year = "") -----------here
        {
        $end_year = $start_year;
        }*/
        
        $var0 = htmlspecialchars_decode($title);
        $var1 = "3";
        $var2 = "0";
        $var3 = "NULL";
        $var4 = "NULL";
        $var5=$start_month;
        $var6=$start_day;
        $var7=$start_year;
        $var8=$start_month;
        $var9=$start_day;
        $var10=$start_year;
        $var11="NULL"; //$start_hour;
        $var12="23:59";
        $var13=htmlspecialchars_decode($venue);
        $var14="Artist";
        $var15="NULL";
        $var16="0";
        $var17="NULL"; //$description;
        $var18="0";
        $var19=$longitude;
        $var20=$latitude;        
        
        $output = array($var0,$var1,$var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $var10, $var11, $var12, $var13, $var14, $var15,$var16,$var17,$var18,$var19,$var20);
        //echo "$output";
        fputcsv($fp,$output);
        }
    //return $counter;
    }
    
}  
