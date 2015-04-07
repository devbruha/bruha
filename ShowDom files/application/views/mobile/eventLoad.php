<div  style="overflow:hidden; max-width: 220px">
<?php 

	foreach($events as $event){
        if($event->event_type == 1){
            echo '<span class="featured">FEATURED</span>';
        }
        echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
		echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'" onclick="return ajaxLoadEvent('.$event->event_id.')">'.$event->event_title.'</a>';

	echo '</h2>';

        $eventDateData = getNextEventDate($event->event_id);

		echo '<div class="googleMapsInfoWindowInner clearfix">';
				echo '<div class="eventDate">';
        if($eventDateData[0] < date('Y-m-d')){
            $eventDateData[0] = date('Y-m-d');
        }
					echo convertDate($eventDateData[0]);
				echo '</div>'; 
				echo '<div class="eventImageWrap">';
					if(file_exists('themes/showdom/images/events/'.$event->event_id.'/'.$event->event_image.'')){
						echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'" onclick="return ajaxLoadEvent('.$event->event_id.')"><img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 113, 113).'" /></a>';
					}else{
						echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'" onclick="return ajaxLoadEvent('.$event->event_id.')"><img class="eventImage" src="'.base_url().'themes/showdom/images/eventImage.png" /></a>';
					}
				echo '</div>';

            echo '<div class="mapEventControls">';
                echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'" class="yellowButton" onclick="return ajaxLoadEvent('.$event->event_id.')">View Event</a>';
                echo '<a href="#" onclick="return fancybox(this)" id="event_'.$event->event_id.'" class="eventQuickPreview yellowButton">Media Preview</a>';
            echo '</div>';

		echo '</div>';
    }
?>

</div>

