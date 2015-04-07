<!DOCTYPE html>
<html>  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/css/style.css" media="screen" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjz2vi4I-eHsr7za-_zkXtqqkZjmJRjsg&sensor=true"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/spider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/infoBubble.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/jquery.validate.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/skin/showdom/showdom.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/cycle.js"></script>

<script type="text/javascript">
/*
	var map;
	var oms;
	var iw;
	var allMarkers;
	var markersArray = Array();
	var markersArray2 = Array();
	var inSearch;
	var inAdvancedSearch;
	
	var searchString;
	var startDate;
	var endDate;
	var anyDate;
	var location;
	var catString;
	var styles = [
	  {
		stylers: [
		  { saturation: -100 }
		]
	  }
	];
*/

	function initialize() {
		alert('test');
		/*
		var gm = google.maps;
		var mapOptions = {
		  center: new gm.LatLng(<?php //echo $lat; ?>, <?php //echo $lng; ?>),
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
				preAddMarkers(searchString,startDate,endDate,anyDate);
			}else{
				preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0);
			}
		});
		
		google.maps.event.addListener(map, 'dragend', function() {
			if(inSearch == true){
				preAddMarkers(searchString,startDate,endDate,anyDate);
			}else{
				preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0);
			}
		});
		
		oms.addListener('click', function(marker) {
			$.ajax({
				url: '<?php //echo base_url(); ?>index.php/events/loadContent/'+marker['id'],
					success: function(data){
						infoBubble2.setContent(data);
						infoBubble2.open(map, marker);
						//$(".quickpreview").fancybox();
						//alert('rtest');
				}
			});
		});
		oms.addListener('spiderfy', function(markers) {
			for(var i = 0; i < markers.length; i ++) {
			  markers[i].setIcon(iconWithColor(spiderfiedColor));
			  markers[i].setShadow(null);
			} 

		});
		oms.addListener('unspiderfy', function(markers) {
			for(var i = 0; i < markers.length; i ++) {
			  markers[i].setIcon(iconWithColor(usualColor));
			  markers[i].setShadow(shadow);
			}
		});
		
		addMarkers();
		*/
	}
 
	function addMarkers(distance="35",lat="<?php //echo $lat; ?>",lng="<?php //echo $lng; ?>"){
		/*
		$.ajax({
			type: "POST",
			url: "<?php //echo base_url(); ?>index.php/events/getMarkers",
			dataType: "json",
			data: "distance="+distance+"&lat="+lat+"&lng="+lng,
			success: function(result){
				allMarkers = result;
				for (var i = 0;i < allMarkers.length; i += 1) {
					if( !$('#markerfilter_'+allMarkers[i].event_cat).hasClass('disabled') ){
						if( $.inArray(allMarkers[i].event_id, markersArray) == -1 ){
							var id = allMarkers[i].event_id;
							var lat = allMarkers[i].event_lat;
							var lon = allMarkers[i].event_lon;
							var title = allMarkers[i].event_title;
							var markerImage = allMarkers[i].cat_icon;
							var cat = allMarkers[i].event_cat;
							addMarker(id,lat,lon,title,markerImage,cat,i,true);
							markersArray.push(allMarkers[i].event_id);
						}
					}
					
				};
				
			}
		});		
		*/
	}
  
	function addMarker(id,lat,lng,title,markerImage,cat,no,visible){
		/* 
		var latlng = new google.maps.LatLng(lat,lng);  
		var marker = new google.maps.Marker({
			position: latlng,
			title: title,
			id: id, 
			cat: cat,
			icon: '<?php //echo base_url(); ?>/themes/showdom/images/markers/small/'+markerImage,
			map: map
		});
		marker.setVisible(visible);
		marker.metadata = { cat: cat };
		oms.addMarker(marker);
		markersArray2.push(marker);
		*/
	};
		
	function preAddMarkers(searchString="search",startDate="",endDate="",anyDate=0,lat='',lng='',cats='1,2,3,4,5'){
		/*	
			bounds = map.getBounds();
			center = bounds.getCenter();
			ne = bounds.getNorthEast();
			sw = bounds.getSouthWest();
			var r = 3963.0;  
			var lat1 = center.lat() / 57.2958; 
			var lon1 = center.lng() / 57.2958;
			var lat2 = ne.lat() / 57.2958;
			var lon2 = ne.lng() / 57.2958;
			var dis = r * Math.acos(Math.sin(lat1) * Math.sin(lat2) + Math.cos(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1));
		if(inAdvancedSearch == true){
			searchMarkers(dis,lat,lng,searchString,startDate,endDate,anyDate,cats);
			inAdvancedSearch = false;
			inSearch = true;
		}else if(inSearch == true){
			searchMarkers(dis,center.lat(),center.lng(),searchString,startDate,endDate,anyDate);
		}else{
			addMarkers(dis,center.lat(),center.lng());
		}
		*/
	}
	
	function searchMarkers(distance="35",lat="<?php //echo $lat; ?>",lng="<?php //echo $lng; ?>",searchString="search",startDate="",endDate="",anyDate="0",cats='0'){
		/*
		$.ajax({
			type: "POST",
			url: "<?php //echo base_url(); ?>index.php/events/searchMarkers",
			dataType: "json",
			data: "distance="+distance+"&lat="+lat+"&lng="+lng+"&searchString="+searchString+"&startDate="+startDate+"&endDate="+endDate+"&anyDate="+anyDate+"&cats="+cats,
			success: function(result){
				//alert(result);
				inSearch = true;
				allMarkers = result;
				for (var i = 0;i < allMarkers.length; i += 1) {
					
						if( $.inArray(allMarkers[i].event_id, markersArray) == -1 ){
							var id = allMarkers[i].event_id;
							var lat = allMarkers[i].event_lat;
							var lon = allMarkers[i].event_lon;
							var title = allMarkers[i].event_title;
							var markerImage = allMarkers[i].cat_icon;
							var cat = allMarkers[i].event_cat;
							if( !$('#markerfilter_'+allMarkers[i].event_cat).hasClass('disabled') ){
								addMarker(id,lat,lon,title,markerImage,cat,i,true);
							}else{
								addMarker(id,lat,lon,title,markerImage,cat,i,false);
							}
							markersArray.push(allMarkers[i].event_id);
						}
				}
			}
		});	
		*/	
	}
	
	function clearMarkers(){
		for (var i = 0; i < markersArray2.length; i++) {
			markersArray2[i].setMap(null);
		}
		markersArray2.length = 0;
		markersArray.length = 0;
	}
	
	function hideMarkers(category) {
		for (var i = 0; i < markersArray2.length; i++) {
			if(markersArray2[i].cat == category){
				markersArray2[i].setVisible(false);
			}
		}
	}
	
	function showMarkers(category) {
		for (var i = 0; i < markersArray2.length; i++) {
			if(markersArray2[i].cat == category){
				markersArray2[i].setVisible(true);
			}
		}
		preAddMarkers();
	}

	function favouriteEvent(elm,id){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/events/favourite/"+id,
			success: function(result){
				$(elm).addClass('greenButton');
			}
		});	
	}
	
	function fancybox(elm){
		$("a.quickpreview").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		  }); 	
		  $("a.quickpreview").click();
	}
</script>

</head>  
<body onload="initialize()" class="loggedIn">  
<div id="headerSmall">
	<div id="headerInner">

    	<!--<img id="logo" src="http://localhost/showdom/themes/showdom/images/showdom-logo.png" />-->
        <a href="<?php echo base_url(); ?>"><img id="logo-150" src="http://localhost/showdom/themes/showdom/images/logos/showdom-logo-150.png" /></a>
        <?php
        	if(isset($welcome)){
				echo '<span class="welcomeText">welcome<br/><span class="yellow sixteen">'.$welcome.'</span></span>';	
			}
		?>
        <ul id="mainMenu"> 
			<?php
				if(isset($menu_item)){ 
					$counter = 0;
					foreach($menu_item as $item){
						echo '<li '.((base_url().''.$menu_url[$counter] == 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'') ? "class='active' " : "") .'><a href="'.base_url().''.$menu_url[$counter].'">'.$item.'</a></li>'; 	 
						$counter ++;
					}
				}
            ?>
        </ul>
        
    </div>
</div>

