<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>EVENTS</h2>
            <span>TOTAL EVENTS REPORTED: <?php echo $numEvents; ?></span>
            <form id="search">
            	<label>Search: </label>
                <input id="searchVal" type="text" name="value" />
            </form>
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
								echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
								echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
								echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
                                echo '<p><small><em class="lightGrey">Reason:</em></small> <span>'.$event->why.'</span></p>';
                                echo '<p><small><em class="lightGrey">Name:</em></small> <span>'.$event->name.'</span></p>';
                                echo '<p><small><em class="lightGrey">Email:</em></small> <span>'.$event->email.'</span></p>';
								
								echo '<div class="clear-10"></div>';
								
								echo '<a onclick="return confirm(\'Are you sure you want to delete this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deleteEvent/'.$event->event_id.'">DELETE THIS EVENT</a>';
								echo '<a style="margin-right:10px;" onclick="return confirm(\'Are you sure?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/makeEventAsOk/'.$event->event_id.'">THIS EVENT IS SAFE</a>';

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
					url: "<?php echo base_url(); ?>index.php/admin/reloadReportedEventList",
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
			url: "<?php echo base_url(); ?>index.php/admin/searchEventList",
			data: "searchTerm="+searchTerm,
			success: function(result){
				offset = offset + 10;
				$("#events").html(result);
			}
		}); 
   });
   
});
</script>