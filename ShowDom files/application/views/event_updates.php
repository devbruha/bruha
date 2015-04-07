<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerLeft">
        	
            <img class="userImage" src="<?php echo base_url().''.image($imagePath, 150, 0); ?>" />
            
            <h3 class="showdomId"><?php echo $showdomId; ?></h3>
			<hr/>
            <span>Account Type</span>
			<?php echo $accountType; ?>
            <hr />
            <span>location</span>
			<?php echo $location; ?>
            <hr />
            <span>Gender</span>
			<?php echo $gender; ?>
            <hr />
            <span>Age</span>
			<?php echo $age; ?>
            <hr />
            <span>Website</span>
			<a href="<?php echo $website; ?>" target="_blank">Visit Website</a>
            <hr />
            <span>Social Links</span>
            <div class="socialLinks">
				<?php 
                    if($googlePlusLink != ''){
                        echo '<a href="'.$googlePlusLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/google-plus.png" />';
                            echo 'Google Plus';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($facebookLink != ''){
                        echo '<a href="'.$facebookLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/facebook.png" />';
                            echo 'Facebook';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($twitterLink != ''){
                        echo '<a href="'.$twitterLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/twitter.png" />';
                            echo 'Twitter';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($linkedInLink != ''){
                        echo '<a href="'.$linkedInLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/linkedin.png" />';
                            echo 'LinkedIn';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($myspaceLink != ''){
                        echo '<a href="'.$myspaceLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/myspace.png" />';
                            echo 'MySpace';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($youtubeLink != ''){
                        echo '<a href="'.$youtubeLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/youtube.png" />';
                            echo 'YouTube';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($vimeoLink != ''){
                        echo '<a href="'.$vimeoLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/vimeo.png" />';
                            echo 'Vimeo';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($flickrLink != ''){
                        echo '<a href="'.$flickrLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/flickr.png" />';
                            echo 'Flickr';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($behanceLink != ''){
                        echo '<a href="'.$behanceLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/behance.png" />';
                            echo 'Behance';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($deviantArtLink != ''){
                        echo '<a href="'.$deviantArtLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/deviantArt.png" />';
                            echo 'DeviantArt';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($pinterestLink != ''){
                        echo '<a href="'.$pinterestLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/pinterest.png" />';
                            echo 'Pinterest';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
                <?php 
                    if($lastfmLink != ''){
                        echo '<a href="'.$lastfmLink.'" target="_blank">';
                            echo '<img src="'.base_url().'themes/showdom/images/icons/lastFm.png" />';
                            echo 'Last.fm';
                        echo '</a>';
                        echo '<hr/>';
                    }
                ?>
            </div>
        </div>
        
        <div id="popupInnerRight" class="viewEvent">
           
           <div id="eventUpdates" class="nomargin">
           		<h2>EVENT UPDATES <a href="<?php echo base_url(); ?>index.php/events/view/<?php echo $eventData->event_id; ?>/<?php echo $eventData->event_title; ?>">Back To Event</a></h2>
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
</div>

<script>
	$("a.enlargePhoto").fancybox();
</script>