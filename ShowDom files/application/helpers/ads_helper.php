<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getRandomAd($size,$cat,$subCat,$keywords,$stat = 'ad-view'){
	
	$nuKeys =  count($keywords);
	$keys = array();
	if($nuKeys != 0){
		foreach($keywords as $keyword){
			$keys[] = $keyword->keyword_id;
		}
	} 
	$keys = implode(",", $keys);
	if($keys == ''){
		$keys = '0';
	}
	$CI =& get_instance(); 
	$CI->load->model('stats_model');
	
	$randomNumber = rand(0, 1000);
	
	if($randomNumber <=10){
		//----- RANDOM AD----//
		$query = randomAd($size,$cat,$subCat);
	}else{
		//----- DISTANCE CAT SUB KEY----//
		//$query = distanceAd($size,$cat,$subCat);
		$query = distanceCatSubcatKeysAd($size,$cat,$subCat,$keys);
		if(mysql_num_rows($query) == 0){
			//----- DISTANCE CAT KEY----// 
			$query = distanceCatKeysAd($size,$cat,$subCat,$keys);
			if(mysql_num_rows($query) == 0){
				//----- DISTANCE KEY----//
				$query = distanceKeysAd($size,$cat,$subCat,$keys);
				if(mysql_num_rows($query) == 0){
					//----- DISTANCE CAT SUB----//
					$query = distanceCatSubcatAd($size,$cat,$subCat);
					if(mysql_num_rows($query) == 0){
						//----- DISTANCE CAT----//
						$query = distanceCatAd($size,$cat,$subCat);
						if(mysql_num_rows($query) == 0){
							//----- DISTANCE----//
							$query = distanceAd($size,$cat,$subCat);
							if(mysql_num_rows($query) == 0){
								//----- CAT SUB KEY----//
								$query = catSubKeyAd($size,$cat,$subCat,$keys);
								if(mysql_num_rows($query) == 0){
									//----- CAT KEY----//
									$query = catKeyAd($size,$cat,$keys);
									if(mysql_num_rows($query) == 0){
										//----- KEY----//
										$query = keyAd($size,$keys);
										if(mysql_num_rows($query) == 0){
											//----- CAT SUB----//
											$query = catSubcatAd($size,$cat,$subCat,$keys);
											if(mysql_num_rows($query) == 0){
												//----- CAT----//
												$query = catAd($size,$cat,$keys);
												if(mysql_num_rows($query) == 0){
													//----- RANDOM----//
													$query = randomAd($size,$cat,$subCat,$keys); 
													
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	if(mysql_num_rows($query) != 0){
		$row = mysql_fetch_array($query);	
		$size = explode('-',$row['ad_size']);
		
		if($CI->session->userdata('user_id')){
			$userId = $CI->session->userdata('user_id');
		}else{
			$userId = 0;
		}
		
		$CI->stats_model->addStat($row['ad_id'],$userId,$stat);
		if($row['ad_image']){
			return '<a target="_blank" href="'.base_url().'index.php/ads/clickAd/'.$row['ad_id'].'/?url='.$row['ad_link'].'"><img src="'.base_url().''.image("themes/showdom/images/ads/".$row['ad_image']."", $size[0], $size[1]).'" /></a>';
		}
	}else{
		return '<a target="_blank" href="'.base_url().'index.php/ads/add"><img src="'.base_url().''.image("themes/showdom/images/ads/defualt/ad-".$size.".jpg", $size[0], $size[1]).'" /></a>';
	}
}


function distanceCatSubcatKeysAd($size,$cat,$subCat,$keys){
	$CI =& get_instance(); 
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ad_to_location
		
		INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
		INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
		INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
		INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))
		 
		HAVING distance<=tbl_ad_to_location.ad_distance
		AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
		ORDER BY RAND() LIMIT 1
		");
		
	return $query;
}

function distanceCatKeysAd($size,$cat,$subCat,$keys){
	$CI =& get_instance(); 
	
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ad_to_location
		
		INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
		INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
		INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))
		 
		HAVING distance<=tbl_ad_to_location.ad_distance
		AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
		ORDER BY RAND() LIMIT 1
		");
	return $query;
}

function distanceKeysAd($size,$cat,$subCat,$keys){
	$CI =& get_instance(); 
	
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ad_to_location
		
		INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
		INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))
		 
		HAVING distance<=tbl_ad_to_location.ad_distance
		AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
		ORDER BY RAND() LIMIT 1
		");
	return $query;
}

function distanceCatSubcatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ad_to_location
		
		INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
		INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
		INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
		 
		HAVING distance<=tbl_ad_to_location.ad_distance
		AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
		ORDER BY RAND() LIMIT 1
		");
	return $query;
}


function distanceCatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
	SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
	COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
	* 180 / PI()) * 60 * 1.1515) 
	AS distance FROM tbl_ad_to_location
	
	INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
	INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	 
	HAVING distance<=tbl_ad_to_location.ad_distance
	AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function distanceAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
	SIN(tbl_ad_to_location.ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
	COS(tbl_ad_to_location.ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - tbl_ad_to_location.ad_lng) * PI() / 180)) 
	* 180 / PI()) * 60 * 1.1515) 
	AS distance FROM tbl_ad_to_location
	INNER JOIN tbl_ads ON(tbl_ad_to_location.ad_id = tbl_ads.ad_id AND tbl_ads.status = 1)
	INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size." )
	 
	HAVING distance<=tbl_ad_to_location.ad_distance
	AND (ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00')
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function catSubKeyAd($size,$cat,$subCat,$keys){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size."  ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
	INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))	
	AND ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function catKeyAd($size,$cat,$keys){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size."  ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))	
	AND ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function keyAd($size,$keys){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size."  ) 
	INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))	
	AND ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function catSubcatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$queryType = 3;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size."  ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
	AND ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}

function catAd($size,$cat){
	$CI =& get_instance(); 
	$queryType = 4;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size AND tbl_ad_size.ad_size_id = ".$size."  ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	AND ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}

function randomAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$queryType = 4;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( 
		tbl_ad_size.ad_size_id = tbl_ads.ad_size 
		AND tbl_ad_size.ad_size_id = ".$size." 
	) 
	WHERE ((ad_start_date < NOW() AND ad_end_date > NOW())
		|| (ad_start_date < NOW() AND ad_end_date = '0000-00-00')
		|| (ad_end_date > NOW() AND ad_start_date = '0000-00-00'))
	AND tbl_ads.status = 1
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}


function getAdCatName($catId){
	$query = mysql_query('SELECT * FROM tbl_event_categories WHERE cat_id = '.$catId.'');
	$row = mysql_fetch_array($query);
	return $row['cat_name'];
}

function getAdSubCatName($catId){
	$query = mysql_query('SELECT * FROM tbl_event_categories_sub WHERE sub_cat_id = '.$catId.'');
	$row = mysql_fetch_array($query);
	return $row['sub_cat_name'];
}
