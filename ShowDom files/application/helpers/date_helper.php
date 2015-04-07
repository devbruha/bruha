<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function convertDate($date){
	$day = date("d", strtotime($date));
	$month = date("M", strtotime($date));
	$year = date("Y", strtotime($date));
	
	return '<span class="day">'.$day.'</span>'.'<span class="month">'.$month.'</span><span class="year">'.$year.'</span>';

}

function getNextEventDate($eventId){
    $today = date('Y-m-d');
    $time = date('H:i:s');
    
    $query = mysql_query('SELECT * FROM tbl_event_start_date_time WHERE start_date_time_event = '.$eventId.'
    AND CONCAT(start_date_time_end_date," ",start_date_time_end_time) >= "'.$today.' '.$time.'"
    ORDER BY start_date_time_end_date ASC LIMIT 1');
    
    $row = mysql_fetch_array($query);
    $array = array();
    $array[] = $row['start_date_time_start_date'];
    $array[] = $row['start_date_time_start_time'];
    $array[] = $row['start_date_time_end_time'];
    return $array;
}

function convertTime($time){
	return date("g:i A", strtotime($time));
}

function convertSimpleDate($date){
	return date("M d Y", strtotime($date));
}