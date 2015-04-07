<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function sortFunction( $a, $b ) {
	return  strtotime($b->meta_timestamp) - strtotime($a->meta_timestamp);
}