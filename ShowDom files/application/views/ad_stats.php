<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerLeft">
            <h2>Ad sizes</h2>
            <ul class="sidebarMenu">
            <?php
				echo '<li><a href="'.base_url().'index.php/ads">All</a></li>';
				foreach($adSizes as $adSize){
					echo '<li><a href="'.base_url().'index.php/ads/index/'.$adSize->ad_size_id.'">'.$adSize->ad_size.'</a></li>';
				}
			?>
            </ul>
        </div>
        
        <div id="popupInnerRight" class="viewEvent">
           <?php 
				echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix">';
					echo '<div class="eventLeftLarge">';
						echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/ads//".$ad->ad_image."", 260, 200).'" />';
					echo '</div>';
					
					echo '<div class="eventContentSmall">';
						echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
						echo '<p><small><em class="lightGrey">URL:</em></small> <span>'.$ad->ad_link.'</span></p>';

                        foreach($adLocation as $location){
                            echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$location->ad_location.'</span></p>';
                            echo '<p><small><em class="lightGrey">Distance:</em></small> <span>'.$location->ad_distance.' km</span></p>';
                        }

						echo '<div class="clear-10"></div>';
						
						echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/ads/edit/'.$ad->ad_id.'">EDIT AD</a>';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="googleMapsInfoWindowInner eventStats clearfix">';
					echo '<h3>TOTAL VIEWS</h3>';
					echo '<p>'.$totalViews->total.'</p>';
					
					echo '<hr />';
					
					echo '<h3>VIEW LOCATION BREAKDOWN</h3>';
					echo '<div class="statBreakdown">';
						foreach($totalViewsBreakdown as $breakdown){
							echo '<p><span>'.$breakdown->user_location.'</span> <span>'.$breakdown->total.'</span></p>';
						}
					echo '</div>';
					
					echo '<hr />';
										
					echo '<h3>TOTAL CLICKS</h3>';
					echo '<p>'.$totalClicks->total.'</p>';
					
					echo '<hr />';
					
					echo '<h3>CLICK LOCATION BREAKDOWN</h3>';
					echo '<div class="statBreakdown">';
						foreach($totalClicksdown as $breakdown){
							echo '<p><span>'.$breakdown->user_location.'</span> <span>'.$breakdown->total.'</span></p>';
						}
					echo '</div>';
					
					
					
				echo '</div>';
				
		   ?>
           
        </div>
    </div>
</div>

