<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>EVENTS</h2>
			<hr />
            
        	<p class="totalUsers"></p>
                        
            <div id="events" class="favourites">
                <?php
					foreach($events as $event){
						echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
							echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.$event->event_title.'">'.$event->event_title.'</a>';
							if($event->event_type == 1){
								echo '<span class="featured">FEATURED</span>';
							}
						echo '</h2>';

                        $eventDateData = getNextEventDate($event->event_id);

						echo '<div class="googleMapsInfoWindowInner clearfix">';
							echo '<div class="eventLeft">';
								echo '<div class="eventDate">';
                                        echo convertDate($eventDateData[0]);
								echo '</div>';
								echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'"" />';
							echo '</div>';
							
							echo '<div class="eventContentLarger">';
								echo '<p><small><em class="lightGrey">ShowdomId:</em></small> <span>'.$event->showdom_id.'</span></p>';
								echo '<p><small><em class="lightGrey">User Email:</em></small> <span><a href="mailto:'.$event->user_email.'">'.$event->user_email.'</a></span></p>';
								echo '<p><small><em class="lightGrey">User Phone Number:</em></small> <span>'.$event->user_phone .'</span></p>';
								echo '<p><small><em class="lightGrey">User Message:</em></small> <span>'.$event->user_message .'</span></p>';
								
								echo '<div class="clear-10"></div>';
								
								echo '<a style="margin-right:10px;" onclick="return confirm(\'Are you sure you want to approve this?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/claimEventApprove/'.$event->claim_id.'">APPROVE</a>';
                                echo '<a style="margin-right:10px;" onclick="return confirm(\'Are you sure you want to remove this?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/claimEventRemove/'.$event->claim_id.'">REMOVE</a>';

							echo '</div>';
						echo '</div>';
					}
				?>
				
            </div>
       </div>
    </div>
</div>