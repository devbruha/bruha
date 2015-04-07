<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getEventKeywords($eventId){
	$CI =& get_instance(); 
	$CI->load->model('events_model');
	
	
	$keywords = $CI->events_model->getEventKeywords($eventId);
	return $keywords;
	
}
