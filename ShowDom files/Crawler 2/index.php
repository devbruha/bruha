<?php

    include_once('DOM/simple_html_dom.php');
    
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
    
    
    
//Set url for crawl, and loat html objects.. Initialise file pointer with "write" capabilities
    $url = 'http://www.blogTO.com/events';
   
    $html = file_get_html($url);
    $fp = fopen('data.csv', 'w');

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
        $start=scrape_time($temp_time);
        $start_year=parse_year($start);
        $start_month=parse_month($start);
        $start_day= parse_day($start);
        $start_hour= parse_hour($start);
        
        //Set temp_time variable to the end tag and process info
        $temp_time=$result->find('span[class=dtend]',0);
        $end = scrape_time($temp_time);
        $end_year=parse_year($end);
        $end_month=parse_month($end);
        $end_day= parse_day($end);
        $end_hour= parse_hour($end);
        
        
        
    //Store all values to a string, using " , " as delimiter - this will be used to convert to assosciative array//
    // These are formatted to fit Scotts requirements, so if you use the same variable name convention, this should be
        // correct and need not be changed
        
        $output=$title." 1 , 0 , NULL , NULL , ".$start_month." , ".$start_day." , ".$start_year." , ".$end_month." , ".$end_day." , ".$end_year." , ".$start_hour." , ".$end_hour." , ".$venue." , Artist , NULL, 0 , ".$description." , 0 \n";
        
        fwrite($fp, $output );


    }
 ?> 