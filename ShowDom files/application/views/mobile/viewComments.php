<div id="userHeader">
    <span>VIEW USER PROFILE</span>
    <a id="profileTrigger" href="#"></a>
</div>


<div id="viewEvent">
    <div>
        <div id="eventComments" class="nomargin">
            <h2>COMMENTS <a style="float: right" href="<?php echo base_url(); ?>index.php/mobile/viewEvent/<?php echo $eventData->event_id; ?>/<?php echo $eventData->event_title; ?>">Back To Event</a></h2>
            <div>
                <?php
                foreach($eventcomments as $eventcomment){
                    $showdomId = str_replace(' ','',$eventcomment->showdom_id);
                    echo '<div>';
                    echo '<img class="userCommentImage" src="'.base_url().''.image("themes/showdom/images/users/".$showdomId."/".$eventcomment->image."", 60 , 60 ).'" />';
                    echo '<a href="">'.$eventcomment->showdom_id.'</a>';
                    echo '<p>'.$eventcomment->meta_value.'</p>';
                    echo '<span>POSTED: '.$eventcomment->meta_timestamp.'</span>';
                    echo '</div>';

                }
                ?>
            </div>
        </div>

        <?php if($eventCreatorId==$theUserId){ ?>
            <div class="googleMapsInfoWindowInner">
                <h2>POST COMMENT</h2>
                <form id="addEventComment">
                    <textarea class="textarea" name="eventAddComment" placeholder="Add Comment"></textarea>
                    <div class="clear-10"></div>
                    <input type="submit" class="yellowButton bold sixteen" value="POST COMMENT" name="submit" />
                </form>
                <script>
                    function initialize(){

                    }

                    $('#addEventComment').submit(function(){
                        var data = $('#addEventComment').serializeArray()
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>index.php/events/addEventComment/<?php echo $eventData->event_id; ?>/0",
                            data: data,
                            dataType: 'json',
                            success: function(result){
                                $('#eventComments > div').html(' ');
                                $.each(result, function(i, item) {
                                    $('#eventComments > div').append('<div><img class="userCommentImage" src="http://localhost/showdom/<?php //image("themes/showdom/images/users/".$showdomId."/".$eventcomment->image."", 60 , 60 ); ?>" /><a href="">'+result[i].showdom_id+'</a><p>'+result[i].meta_value+'<br/><span>POSTED: '+result[i].meta_timestamp+'</span></p></div>');
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


