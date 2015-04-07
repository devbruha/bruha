<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function seoNiceName($name){
    $urlname = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
    $urlname = str_replace(' ','-',$urlname);
    return $urlname;
}

function getEventOtherCategory($eventId){
    $query = mysql_query('SELECT * FROM tbl_event_meta WHERE event_id = '.$eventId.' AND meta_key = "event_sub_meta_other"');
    $row = mysql_fetch_array($query);
    return $row['meta_value'];
}