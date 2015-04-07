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
        
        <div id="popupInnerRight">
         	<h2>SHOWDOM ADS</h2>
            <span>CREATE, EDIT, OR DELETE ADS</span>
            <a id="topRightButton" class="yellowButton sixteen bold" href="<?php echo base_url(); ?>index.php/ads/add">CREATE AD</a>
			<div id="events">
				<?php
                foreach($ads as $ad){
                    echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
                    echo '<div class="googleMapsInfoWindowInner clearfix">';
                        echo '<div class="eventLeftLarge">';
                            echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/ads//".$ad->ad_image."", 260, 200).'" />';
                        echo '</div>';
                        
                        echo '<div class="eventContentSmall">';
							echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
							echo '<p><small><em class="lightGrey">URL:</em></small> <span><a href="'.$ad->ad_link.'" target="_blank">'.$ad->ad_link.'</a></span></p>';
						
                            echo '<div class="clear-10"></div>';
                        	
                            echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/ads/edit/'.$ad->ad_id.'">EDIT AD</a>';
                            echo '<a style="margin-left:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/ads/stats/'.$ad->ad_id.'">STATISTICS</a>';
                            echo '<a onclick="return confirm(\'Are you sure you want to remove this ad?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/ads/delete/'.$ad->ad_id.'">DELETE</a>';
                        	echo '<div class="clear-10"></div>';
							if($ad->status == 0){
								echo '<a style="margin-right:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/ads/adPayment/'.$ad->ad_id.'">PAY NOW</a>';
							}
							if($ad->ad_end_date < date('Y-m-d')){
								echo '<a class="editEventButton redButton sixteen" href="'.base_url().'index.php/ads/renewAd/'.$ad->ad_id.'">RENEW AD</a>';
							}
						
						echo '</div>';
                    echo '</div>';
                }
                ?>
			</div>
        </div>
    </div>
</div>