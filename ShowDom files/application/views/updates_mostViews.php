<div id="popup">
    <div id="popupInner" class="clearfix">

        <div class="blackBox clearfix eventUpdatesMenu nopadding">
            <ul>
                <li><a href="<?php echo base_url() ?>index.php/updates">FEATURED</a></li>
                <li class="active"><a href="<?php echo base_url() ?>index.php/updates/mostViews">MOST VIEWED</a></li>
                <?php if($this->session->userdata('user_id')){ ?>
                    <li><a href="<?php echo base_url() ?>index.php/updates/favourites">ATTENDING</a></li>
                    <li><a href="<?php echo base_url() ?>index.php/updates/suggested">SUGGESTED</a></li>
                <?php } ?>
            </ul>
        </div>

        <div id="popupInnerFull">

            <div id="events" class="favourites">

                <?php

                    foreach($events as $event){
                        $counter ++;
                        if($counter == 2 || $counter % 6 == 0){
                            echo '<div style="margin-bottom:20px;">';
                            $keywords = getEventKeywords($event->event_id);
                            echo getRandomAd(2,$event->event_cat,$event->event_sub_cat,$keywords);
                            echo '</div>';
                        }
                        echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
                        echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';
                        if($event->event_type == 1){
                            echo '<span class="featured">FEATURED</span>';
                        }
                        $eventDateData = getNextEventDate($event->event_id);
                        echo '</h2>';
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
                        echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($event->event_start_time).' to '.convertTime($event->event_end_time).'</span></p>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>

            </div>
        </div>
    </div>
</div>