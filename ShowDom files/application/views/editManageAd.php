<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event</h2>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/postingType/<?php echo $eventId; ?>">Posting Type</a></li>
					<?php if($eventPostingType == 1){ ?>
					<li>Manage Event Ad</li>		
					<?php } ?>                    
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventVideo/<?php echo $eventId; ?>">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
			<?php
            if(count($ads) == 0){
                echo 'It appears you have not completed your Event Ad. Please click <a href="http://showdom.com/index.php/events/createAd/'.$eventId.'">here</a> to complete your ad.';
            }else{
                foreach($ads as $ad){
                    echo '<h2 class="eventTitle eventTitleCat0">'.$ad->ad_title.'</h2>';
                    echo '<div class="googleMapsInfoWindowInner clearfix">';
                        echo '<div class="eventLeftLarge">';
                            echo '<img class="eventImage" src="'.base_url().image("themes/showdom/images/ads//".$ad->ad_image."", 260, 200).'" />';
                        echo '</div>';
                        
                        echo '<div class="eventContentSmall">';
							echo '<p><small><em class="lightGrey">Ad Size:</em></small> <span>'.$ad->ad_size.'</span></p>';
							echo '<p><small><em class="lightGrey">URL:</em></small> <span>'.$ad->ad_link.'</span></p>';
							echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$ad->ad_location.'</span></p>';
							echo '<p><small><em class="lightGrey">Distance:</em></small> <span>'.$ad->ad_distance.' km</span></p>';
						
                            echo '<div class="clear-10"></div>';
                        	
                            echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/editAd/'.$ad->ad_id.'">EDIT AD</a>';
                            echo '<a style="margin-left:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/adStats/'.$ad->ad_id.'">STATISTICS</a>';
                        echo '</div>';
                    echo '</div>';
                }
            }
                ?>
        </div>
                
    </div>
</div>