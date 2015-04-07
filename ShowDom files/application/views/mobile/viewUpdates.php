<div id="userHeader">
    <span>VIEW USER PROFILE</span>
    <a id="profileTrigger" href="#"></a>
</div>



<div id="viewEvent">
    <div>

        <div id="eventUpdates" class="nomargin">
            <h2>EVENT UPDATES <a style="float: right" href="<?php echo base_url(); ?>index.php/mobile/viewEvent/<?php echo $eventData->event_id; ?>/<?php echo $eventData->event_title; ?>">Back To Event</a></h2>
            <div>
                <?php
                foreach($eventupdates as $eventupdate){
                    echo '<p>'.$eventupdate->meta_value.'<br/>';
                    echo '<span>POSTED: '.$eventupdate->meta_timestamp.'</span>';
                    echo '</p>';
                }
                ?>
            </div>
        </div>

        <?php if($eventCreatorId==$theUserId){ ?>
        <div class="googleMapsInfoWindowInner">
            <h2>POST EVENT UPDATE</h2>
            <form id="addEventUpdate">
                <textarea class="textarea" name="eventUpdateContent" placeholder="Add Event Update"></textarea>
                <div class="clear-10"></div>
                <input type="submit" class="yellowButton bold sixteen" value="POST EVENT UPDATE" name="submit" />
            </form>

            <script>
                $('#addEventUpdate').submit(function(){
                    var data = $('#addEventUpdate').serializeArray()
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/events/addEventUpdate/<?php echo $eventData->event_id; ?>/0",
                        data: data,
                        dataType: 'json',
                        success: function(result){
                            $('#eventUpdates > div').html(' ');
                            $.each(result, function(i, item) {
                                $('#eventUpdates > div').append('<p>'+result[i].meta_value+'<br/><span>POSTED: '+result[i].meta_timestamp+'</span></p>');
                            });
                        }
                    });
                    return false;
                });
            </script>
        </div>
        <?php } ?>
    </div>
</div>