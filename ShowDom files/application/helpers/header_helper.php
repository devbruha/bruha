<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function sd_header(){ 
	?>
    <script type="text/javascript">
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
	var twelvehour=0;
	var featured = 0;
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
		  center: new gm.LatLng(<?php echo $lat; ?>, <?php echo $lng; ?>),
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
		
		oms.addListener('click', function(marker) {
			$.ajax({
				url: '<?php echo base_url(); ?>index.php/events/checkEventAge/'+marker['id'],
					success: function(data){
						json_obj = jQuery.parseJSON(data);
						minAge = json_obj[0].event_min_age;
						if(minAge == 0){
							$.ajax({
								url: '<?php echo base_url(); ?>index.php/events/loadContent/'+marker['id'],
									success: function(data){
										infoBubble2.setContent(data);
										infoBubble2.open(map, marker);
								}
							});
						}else{
							$('#ageRestrictedTrigger').click();
							$('#confirmAge').unbind('submit');
							$('#confirmAge').submit(function(){
								data = $(this).serializeArray();
								
								month 	= data[0].value;
								day 	= data[1].value;
								year 	= data[2].value;								
								
								today 		= new Date();
								dateString 	= year+'-'+month+'-'+day;
								birthDate	= new Date(dateString);
								age 		= today.getFullYear() - birthDate.getFullYear();
								
								if(age >= minAge){
									$.fancybox.close();
									$.ajax({
										url: '<?php echo base_url(); ?>index.php/events/loadContent/'+marker['id'],
											success: function(data){
												infoBubble2.setContent(data);
												infoBubble2.open(map, marker);
										}
									});
								}else{
								//	$.fancybox.close();
									$('#ageRestrictedFailTrigger').click();
								}
								
								return false;
							});
							
						}
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
		
		addMarkers("35",<?php echo $lat; ?>,<?php echo $lng; ?>);
	}
 
	function addMarkers(distance,lat,lng){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/events/getMarkers",
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
	}
  
	function addMarker(id,lat,lng,title,markerImage,cat,no,visible){
		var latlng = new google.maps.LatLng(lat,lng);  
		var marker = new google.maps.Marker({
			position: latlng,
			title: title,
			id: id,
			cat: cat,
			icon: '<?php echo base_url(); ?>/themes/showdom/images/markers/small/'+markerImage,
			map: map
		});
		marker.setVisible(visible);
		marker.metadata = { cat: cat };
		oms.addMarker(marker);
		markersArray2.push(marker);
	};
		
	function preAddMarkers(searchString,startDate,endDate,anyDate,twelvehourvalue,lat,lng,cats,featured){
			
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
			if(twelvehourvalue==1){
				twelvehour = 1;
			}else{
				twelvehour = 0;	
			}
			searchMarkers(dis,lat,lng,searchString,startDate,endDate,anyDate,cats,twelvehour,featured);
			inAdvancedSearch = false;
			inSearch = true;
		}else if(inSearch == true){
			if(twelvehourvalue==1){
				twelvehour = 1;
			}else{
				twelvehour = 0;	
			}
			searchMarkers(dis,center.lat(),center.lng(),searchString,startDate,endDate,anyDate,"1,2,3,4,5",twelvehour,featured);
		}else{
			addMarkers(dis,center.lat(),center.lng());
		}
	}
	
	function searchMarkers(distance,lat,lng,searchString,startDate,endDate,anyDate,cats,twelvehour,featured){
		if(twelvehour == undefined){
			twelvehour = 0;
		}
		if(featured == undefined){
			featured = 0;
		}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/events/searchMarkers",
			dataType: "json",
			data: "distance="+distance+"&lat="+lat+"&lng="+lng+"&searchString="+searchString+"&startDate="+startDate+"&endDate="+endDate+"&anyDate="+anyDate+"&cats="+cats+"&twelvehour="+twelvehour+"&featured="+featured,
			success: function(result){
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
					//}
				};
			}
		});		
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
	
	function unfavouriteEvent(elm,id){
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/events/unfavouriteAjax/"+id,
			success: function(result){
				$(elm).addClass('redButton');
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
	
	
	$(document).ready(function() {
		$("#ageRestrictedTrigger").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		});
		$("#ageRestrictedFailTrigger").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none'
		});
	});
	
</script>
    <?php
}