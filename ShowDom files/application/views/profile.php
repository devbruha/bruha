<div id="popup">
    <div id="popupInner" class="equalHeightOutter clearfix">
		
        <div id="popupInnerLeft">
        	
            <img class="userImage" src="<?php echo base_url().''.image($imagePath, 150, 0); ?>" />
            
            <a class="yellowButton sixteen bold" href="<?php echo base_url(); ?>index.php/profile/edit/" style="margin-bottom:10px;">EDIT PROFILE</a>
            
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
        
        <div id="popupInnerRight">
         	<h2>MY EVENTS</h2>
            <span>CREATE, EDIT, OR DELETE YOUR EVENTS</span>
            <a id="topRightButton" class="yellowButton sixteen bold" href="<?php echo base_url(); ?>index.php/events/add">CREATE EVENT</a>
            
            <div id="events">
            <?php
				
				$numEvents = count($events);
			
				if($numEvents == 0){
					echo '<h2>You have not yet added any events. Click the add event button to add a new event.</h2>';
				}else{
					$counter = 0;
					foreach($events as $event){
						$counter ++;
                        /*
						if($counter == 2 || $counter == 6){
							echo '<div style="margin-bottom:20px;">';
								$keywords = getEventKeywords($event->event_id); 
								echo getRandomAd(3,$event->event_cat,$event->event_sub_cat,$keywords);
							echo '</div>';
						}
                        */
						
						echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
							echo '<a href="'.base_url().'index.php/events/view/'.$event->event_id.'/'.seoNiceName($event->event_title).'">'.$event->event_title.'</a>';
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
							
							echo '<div class="eventContent">';
								echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
								echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
								echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
								
								echo '<div class="clear-10"></div>';
							
								echo '<a class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/edit/'.$event->event_id.'">EDIT EVENT</a>';
								echo '<a style="margin-left:10px;" class="editEventButton yellowButton sixteen" href="'.base_url().'index.php/events/stats/'.$event->event_id.'">STATISTICS</a>';
								echo '<a onclick="return confirm(\'Are you sure you want to remove this event?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/events/delete/'.$event->event_id.'">DELETE</a>';
							echo '</div>';
						echo '</div>';
					}
				}
			?>
            </div>
            
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
	var loadingEvents = false;
	var offset = 10;
	var userId = <?php echo $userId; ?>;
	$(window).scroll(function() {		
		if (($("#popup").offset().top + $("#popup").height() - $(window).height()) <= $(window).scrollTop()) {
			if(loadingEvents == false){
				loadingEvents = true;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/profile/reloadProfileEvents",
					data: "offset="+offset+"&userId="+userId,
					success: function(result){
						offset = offset + 10;
						$("#popupInnerRight").append(result);
						//alert(result);
						loadingEvents = false;
						$('.equalHeightOutter').equalHeights();
					}
				});
				
				
			}
		}
   });
   
   if($(window).height() > $('#popupInner').height()){
	   $('#popupInner').height($(window).height()-215);
	   $('.equalHeightOutter').equalHeights();
   }
   
   $(function(){ $('.equalHeightOutter').equalHeights(); });
});




</script>