<div id="popup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>ATTENDING</h2>
            <span>EVENTS YOU ARE ATTENDING</span>
			<hr />
        
            <div id="events" class="favourites">
                <?php
					$numFavs = count($favouriteEvents);
					if($numFavs == 0){
						echo '<h2>You are not attending any events.</h2><br/>';
					}else{
						$counter = 0;
						foreach($favouriteEvents as $favouriteEvent){
							$counter ++;
							if($counter == 2 || $counter % 6 == 0){
								echo '<div style="margin-bottom:20px;">';
									$keywords = getEventKeywords($favouriteEvent->event_id); 
									echo getRandomAd(2,$favouriteEvent->event_cat,$favouriteEvent->event_sub_cat,$keywords);
								echo '</div>';
							}
							echo '<h2 class="eventTitle eventTitleCat'.$favouriteEvent->event_cat.'">';
								echo '<a href="'.base_url().'index.php/events/view/'.$favouriteEvent->event_id.'/'.seoNiceName($favouriteEvent->event_title).'">'.$favouriteEvent->event_title.'</a>';
								if($favouriteEvent->event_type == 1){
									echo '<span class="featured">FEATURED</span>';
								}
							echo '</h2>';

                            $eventDateData = getNextEventDate($favouriteEvent->event_id);

							echo '<div class="googleMapsInfoWindowInner clearfix">';
								echo '<div class="eventLeft">';
									echo '<div class="eventDate">';
                                        echo convertDate($eventDateData[0]);
									echo '</div>';
									echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$favouriteEvent->event_id."/".$favouriteEvent->event_image."", 113, 113).'"" />';
								echo '</div>';
								
								echo '<div class="eventContentLarger">';
									echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$favouriteEvent->event_cat.'"><strong>'.$favouriteEvent->cat_name.'</strong></span> - '.$favouriteEvent->sub_cat_name.'</p>';
									echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$favouriteEvent->event_location.'</span></p>';
									echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
									echo '<a href="'.base_url().'index.php/favourites/unfavourite/'.$favouriteEvent->event_id.'" class="yellowButton sixteen bold floatLeft">NOT ATTENDING</a>';
								echo '</div>';
							echo '</div>';
						}
					}
                ?>
            </div>
       </div>
    </div>
</div>
