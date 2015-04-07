<!DOCTYPE html>
<html>  
<head>  
<title><?php echo wp_title(); ?></title>  
<link rel="stylesheet" type="text/css" href="http://showdom.com/themes/showdom/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo bloginfo('template_url'); ?>/style.css" media="screen" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjz2vi4I-eHsr7za-_zkXtqqkZjmJRjsg&sensor=true&libraries=places"></script>
<script type="text/javascript" src="http://showdom.com/themes/showdom/js/spider.js"></script>
<script type="text/javascript" src="http://showdom.com/themes/showdom/js/infoBubble.js"></script>
<?php wp_head(); ?>
</head>  
<body onload="initialize(); " style="background:#f2f2f2;"> 
<a href="#ageRestrictedEvent" id="ageRestrictedTrigger"></a>
<a href="#ageRestrictedFail" id="ageRestrictedFailTrigger"></a>

<div id="headerSmall" class="adminHeader">
	<div id="headerInner">
		
        <a href="http://showdom.com/"><img id="logo-150" src="http://showdom.com/themes/showdom/images/logos/showdom-logo-150.png" /></a>
        <ul id="mainMenu"> 
        </ul>
        
    </div>
</div>


<script type="text/javascript">
	var map;
	var styles = [
	  {
		stylers: [
		  { saturation: -100 }
		]
	  }
	];

	function initialize() {
		var gm = google.maps;
		var mapOptions = {
		  center: new gm.LatLng(43.653226, -79.3831843),
		  zoom: 10,
		  minZoom : 10,
		  mapTypeId: gm.MapTypeId.ROADMAP
		};
		map = new gm.Map(document.getElementById("map_canvas"),mapOptions);
		oms = new OverlappingMarkerSpiderfier(map,{markersWontMove: true, markersWontHide: true,keepSpiderfied:true});
		map.setOptions({styles: styles});
		iw = new gm.InfoWindow({
			maxWidth : 1200	
		});
		
		infoBubble2 = new InfoBubble({
		  borderRadius: 0
        });
		
		google.maps.event.addListener(map, 'zoom_changed', function() {
			if(inSearch == true){
				preAddMarkers(searchString,startDate,endDate,anyDate,twelvehour);
			}else{
				preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0,twelvehour);
			}
		});
		
		google.maps.event.addListener(map, 'dragend', function() {
			if(inSearch == true){
				preAddMarkers(searchString,startDate,endDate,anyDate,twelvehour);
			}else{
				preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0,twelvehour);
			}
		});
		

	}
 

</script>
<div id="map_canvas" class="map_canvas" style="width:100%; height:100%; top:50px"></div>
