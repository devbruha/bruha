<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>ADS</h2>
            <span>TOTAL ADS: <?php echo $numAds; ?></span>
            <form id="search">
            	<label>Search: </label>
                <input id="searchVal" type="text" name="value" />
            </form>
			<hr />
            
        	<p class="totalUsers"></p>
                        
            <div id="events" class="favourites">
                <?php
					foreach($ads as $ad){
						echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
						echo '<div class="googleMapsInfoWindowInner clearfix">';
							echo '<div class="eventLeft">';
								echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/ads//".$ad->ad_image."", 150, 150).'" />';
							echo '</div>';
							
							echo '<div class="eventContentLarger">';
								echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
								echo '<p><small><em class="lightGrey">URL:</em></small> <span><a href="'.$ad->ad_link.'" target="_blank">'.$ad->ad_link.'</a></span></p>';
								echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$ad->ad_location.'</span></p>';
								echo '<p><small><em class="lightGrey">Distance:</em></small> <span>'.$ad->ad_distance.' km</span></p>';
								echo '<p><small><em class="lightGrey">Starts:</em></small> <span>'.$ad->ad_start_date.'</span></p>';
								echo '<p><small><em class="lightGrey">Ends:</em></small> <span>'.$ad->ad_end_date.'</span></p>';
								echo '<div class="clear-10"></div>';
								echo '<a onclick="return confirm(\'Are you sure you want to remove this ad?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteAd/'.$ad->ad_id.'">DELETE</a>';
							
							echo '</div>';
						echo '</div>';
					}
				?>
				
            </div>
       </div>
    </div>
</div>


<script>
$(document).ready(function(){
	var loadingEvents = false;
	var offset = 6;
	var searchTerm = $('#searchVal').val();
	$(window).scroll(function() {		
		if (($("#popup").offset().top + $("#popup").height() - $(window).height()) <= $(window).scrollTop()) {
			if(loadingEvents == false){
				loadingEvents = true;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/admin/reloadAdList",
					data: "offset="+offset+"&searchTerm="+searchTerm,
					success: function(result){
						offset = offset + 10;
						$("#events").append(result);
						loadingEvents = false;
					}
				});
			}
		}
   });
   
   $('#searchVal').keyup(function(){
	   searchTerm = $('#searchVal').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/admin/searchAdList",
			data: "searchTerm="+searchTerm,
			success: function(result){
				offset = offset + 10;
				$("#events").html(result);
			}
		}); 
   });
   
});
</script>