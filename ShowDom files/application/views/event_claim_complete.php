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
           <?php
				echo '<h2 class="eventTitle eventTitleCat'.$eventData->event_cat.'">'.$eventData->event_title.'</h2>';
				echo '<div class="googleMapsInfoWindowInner clearfix nomargin">';
					echo '<div class="eventLeftLarge">';
						echo '<div class="eventDate eventDateTall">';
							echo convertDate($eventData->event_start_date);
						echo '</div>';
						echo '<img class="eventImage" src="'.base_url().image("themes/showdom/images/events/".$eventData->event_id."/".$eventData->event_image."", 200, 200).'" />';
					echo '</div>';
					
					echo '<div class="eventContentSmall">';
						echo '<p><small><em class="lightGrey">Favourites:</em></small> <span>'.$eventFavourites.'</span></p>';
						echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$eventData->event_cat.'"><strong>'.$eventData->cat_name.'</strong></span> - '.$eventData->sub_cat_name.'</p>';
						echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$eventData->event_location.'</span></p>';
						echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventData->event_start_time).' to '.convertTime($eventData->event_end_time).'</span></p>';
						echo '<p><small><em class="lightGrey">End Date:</em></small> <span>'.convertSimpleDate($eventData->event_end_date).'</span></p>'; 
					echo '</div>';
				echo '</div>';
				?>
                <br/><br/>
                <h2>Thank You!</h2>
                <p>A showdom team member will review your request and get back to you shortly.</p>
                
        </div>
    </div>
</div>
