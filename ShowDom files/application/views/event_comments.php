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
           
           <div id="eventComments" class="nomargin">
           		<h2>COMMENTS <a href="<?php echo base_url(); ?>index.php/events/view/<?php echo $eventData->event_id; ?>/<?php echo $eventData->event_title; ?>">Back To Event</a></h2>
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
</div>

<script>
	$("a.enlargePhoto").fancybox();
</script>