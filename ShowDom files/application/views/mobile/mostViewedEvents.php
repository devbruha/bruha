<div id="userHeader" class="userHeaderMenu">
    <div>
        <select id="eventUpdatesDropDown">
            <option value="eventUpdates" <?php if($currentPage == 'Featured Events'){ echo 'SELECTED'; } ?>>Featured</option>
            <option value="mostViewed" <?php if($currentPage == 'Most Viewed'){ echo 'SELECTED'; } ?>>Most Viewed</option>
            <?php if(isLoggedIn() == true){ ?>
                <option value="attending" <?php if($currentPage == 'Attending'){ echo 'SELECTED'; } ?>>Attending</option>
                <option value="suggestedEvents" <?php if($currentPage == 'Suggested'){ echo 'SELECTED'; } ?>>Suggested</option>
            <?php } ?>
        </select>
    </div>
</div>

<div id="viewEvent">
    <div>
        <h3>MOST VIEWED EVENTS</h3>
        <a id="closeQuickPreview" href="<?php echo base_url(); ?>index.php/mobile/homeMap"></a>
        <div class="clear"></div>

        <?php
            if(count($events) == 0){
                echo '<p>There are no featured events in your area at this time. Please check back soon.</p>';
            }else{
                $counter = 0;
                foreach($events as $event){
                    $counter ++;
                    if($counter == 2 || $counter == 6){
                        echo '<div style="margin-bottom:20px; text-align: center;">';
                        $keywords = getEventKeywords($event->event_id);
                        echo getRandomAd(3,$event->event_cat,$event->event_sub_cat,$keywords);
                        echo '</div>';
                    }
                    if($event->event_type == 1){
                        echo '<span class="featured">FEATURED</span>';
                    }
                    echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
                    echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';

                    echo '</h2>';

                    $eventDateData = getNextEventDate($event->event_id);

                    echo '<div class="googleMapsInfoWindowInner clearfix">';
                    echo '<div class="eventLeft">';
                    echo '<div class="eventDate">';
                    echo convertDate($eventDateData[0]);
                    echo '</div>';
                    echo '<img class="eventImage" src="'.base_url().image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 200, 200).'"" />';
                    echo '</div>';

                    echo '<div class="eventContent">';
                    echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
                    echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
                    echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        ?>

    </div>
</div>

<script>
    $('#eventUpdatesDropDown').change(function(){
        window.location = "<?php echo base_url(); ?>index.php/mobile/"+$(this).val();
    });
</script>