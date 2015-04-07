<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function isLoggedIn(){

    $CI =& get_instance();
    $CI->load->library(array('session'));

    if(!$CI->session->userdata('validated')){
        return false;
    }else{
        return true;
    }
}

function getAge($bday){
	$age = time() - strtotime($bday);
	$years = floor($age / 31556926); // 31556926 seconds in a year
	return $years;
}

function getAccountType($account){
	if($account == 1){
		$account = 'Artist';
	}elseif($account == 2){
		$account = 'Promoter';
	}elseif($account == 1){
		$account = 'Venue';
	}elseif($account == 4){
        $account = 'User';
    }
	return $account;
}

function getStatus($status){
	if($status == 1){
		$status = 'Active';
	}else{
		$status = 'Deactive';
	}
	return $status;
}