<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getRandomAd($size,$cat,$subCat,$keywords){
	
	$nuKeys =  count($keywords);
	$keys = array();
	if($nuKeys != 0){
		foreach($keywords as $keyword){
			$keys[] = $keyword->keyword_id;
		}
	} 
	$keys = implode(",", $keys);
	print_r($keys); 
	$CI =& get_instance(); 
	
	$randomNumber = rand(0, 1000);
	
	if($randomNumber >=10){
		//----- DISTANCE, CAT, SUBCAT KEYS----//
		if($nuKeys != 0){
			echo ' DISTANCE, CAT, SUBCAT, KEYS';
			$query = distanceCatSubcatKeysAd($size,$cat,$subCat,$keys);
		}else{
			echo ' DISTANCE, CAT, SUBCAT';
			$query = distanceCatSubcatAd($size,$cat,$subCat);
		}
		
	}else{
		//----- RANDOM AD----//
		echo ' RANDOM AD';
		$query = randomAd($size,$cat,$subCat);
	}
	if(mysql_num_rows($query) == 0){
		//----- DISTANCE, CAT----//
		echo " DISTANCE, CAT";
		$query2 = distanceCatAd($size,$cat,$subCat);
		$row = mysql_fetch_array($query2);
		
		if(mysql_num_rows($query2) == 0){
			//----- DISTANCE----//
			echo " DISTANCE";
			$query3 = distanceAd($size,$cat,$subCat);
			$row = mysql_fetch_array($query3);
			
			if(mysql_num_rows($query3) == 0){
				//----- CAT, SUBCAT----//
				echo " CAT, SUBCAT";
				$query4 = catSubcatAd($size,$cat,$subCat);
				$row = mysql_fetch_array($query4);
				
				if(mysql_num_rows($query4) == 0){
					//----- CAT----//
					echo " CAT";
					$query5 = catAd($size,$cat,$subCat);
					$row = mysql_fetch_array($query5);
					
					if(mysql_num_rows($query5) == 0){
						//----- ANY RAONDOM AD----//
						echo " ANY RAONDOM AD";
						$query6 = randomAd($size,$cat,$subCat);
						$row = mysql_fetch_array($query6);
					}
				}
			}
		}
		
	}else{
		$queryType = 0;
		$row = mysql_fetch_array($query);
	}
	
	
	$size = explode('-',$row['ad_size']);
	return '<a target="_blank" href="'.$row['ad_link'].'"><img src="http://localhost/showdom/'.image("themes/showdom/images/ads/".$row['ad_image']."", $size[0], $size[1]).'" /></a>';
}


function distanceCatSubcatKeysAd($size,$cat,$subCat,$keys){
	$CI =& get_instance(); 
	
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ads
		
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size)
		INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
		INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
		INNER JOIN tbl_ad_to_keyword ON ( tbl_ad_to_keyword.ad_id = tbl_ads.ad_id AND tbl_ad_to_keyword.key_id IN (".$keys."))
		 
		HAVING distance<=ad_distance
		AND tbl_ads.ad_size = ".$size."
		ORDER BY RAND() LIMIT 1
		");
	return $query;
}



function distanceCatSubcatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
		SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
		SIN(ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
		COS(ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - ad_lng) * PI() / 180)) 
		* 180 / PI()) * 60 * 1.1515) 
		AS distance FROM tbl_ads
		
		INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size)
		INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
		INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
		 
		HAVING distance<=ad_distance
		AND tbl_ads.ad_size = ".$size."
		ORDER BY RAND() LIMIT 1
		");
	return $query;
}


function distanceCatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
	SIN(ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
	COS(ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - ad_lng) * PI() / 180)) 
	* 180 / PI()) * 60 * 1.1515) 
	AS distance FROM tbl_ads
	
	INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size)
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	 
	HAVING distance<=ad_distance
	AND tbl_ads.ad_size = ".$size."
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function distanceAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$query = mysql_query("
	SELECT *,((ACOS(SIN(".$CI->session->userdata('userLat')." * PI() / 180) * 
	SIN(ad_lat * PI() / 180) + COS(".$CI->session->userdata('userLat')." * PI() / 180) * 
	COS(ad_lat * PI() / 180) * COS((".$CI->session->userdata('userLng')." - ad_lng) * PI() / 180)) 
	* 180 / PI()) * 60 * 1.1515) 
	AS distance FROM tbl_ads
	
	INNER JOIN tbl_ad_size ON(tbl_ad_size.ad_size_id = tbl_ads.ad_size)
	 
	HAVING distance<=ad_distance
	AND tbl_ads.ad_size = ".$size."
	ORDER BY RAND() LIMIT 1
	");	
	return $query;
}

function catSubcatAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$queryType = 3;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	INNER JOIN tbl_ad_to_sub_category ON (tbl_ad_to_sub_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_sub_category.sub_cat_id = ".$subCat.")
	AND tbl_ads.ad_size = ".$size." 
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}

function catAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$queryType = 4;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size ) 
	INNER JOIN tbl_ad_to_category ON (tbl_ad_to_category.ad_id = tbl_ads.ad_id AND tbl_ad_to_category.cat_id = ".$cat.")
	AND tbl_ads.ad_size = ".$size." 
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}

function randomAd($size,$cat,$subCat){
	$CI =& get_instance(); 
	$queryType = 4;
	$query = mysql_query("
	SELECT * FROM tbl_ads 
	INNER JOIN tbl_ad_size ON( tbl_ad_size.ad_size_id = tbl_ads.ad_size ) 
	AND tbl_ads.ad_size = ".$size." 
	ORDER BY RAND() LIMIT 1
	");
	return $query;
}
