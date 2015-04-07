<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event</h2>
            <div id="actions">
                <a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>" id="skip" class="yellowButton sixteen bold">BACK</a>
                <a id="save" class="yellowButton sixteen bold" href="<?php echo base_url(); ?>index.php/profile">SAVE & EXIT</a>
            </div>
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li>&raquo; Add Videos</li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <h2>Add New Video Clip (as File)</h2>
            <div class="clear-10"></div>
            <form class="standardForm" action="<?php echo base_url(); ?>index.php/events/addVideo/<?php echo $eventId; ?>" method="post" enctype="multipart/form-data">
                <div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">BROWSE FOR VIDEO CLIP (Less than 20MB)</label>
                        <input type="file" name="eventVideo" />
                	</div>
                    <div class="formWrap clearfix">
                    	<button style="width:140px" class="yellowButton sixteen bold">ADD VIDEO CLIP</button>
                    </div>
                </div>
                
                <div class="formRight">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">VIDEO CLIP TITLE</label>
                        <input type="text" name="videoCaption" value="" />
                	</div>
                </div>
             </form>
            <div class="clear-10"></div>
            <hr class="dotted" />
            <div class="clear-10"></div>
            
            <form class="standardForm" action="<?php echo base_url(); ?>index.php/events/addYoutubeVideo/<?php echo $eventId; ?>" method="post" enctype="multipart/form-data">
                <div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">VIDEO CLIP LINK(Youtube / Vimeo)</label>
                        <input type="text" name="eventVideoYoutube" placeholder="http://" />
                	</div>
                    <div class="formWrap clearfix">
                    	<button style="width:140px" class="yellowButton sixteen bold">ADD VIDEO CLIP</button>
                    </div>
                </div>
                
                <div class="formRight">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">VIDEO CLIP TITLE</label>
                        <input type="text" name="videoCaption" value="" />
                	</div>
                </div>
             </form>
            
            <div class="clear-10"></div>
            <hr class="dotted" />
            <div class="clear-10"></div>
            <div id="videoList">

				<?php $counter = 0; 
                foreach($video as $vid){ 
					if($vid->video_file != ''){
						$counter ++; 
						?>
					
						<div id="jp_container_<?php echo $counter; ?>" class="jp-video ">
						<div class="jp-type-single">
							<div class="jp-video-play">
							  <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
							</div>
							
						  <div id="jquery_jplayer_<?php echo $counter; ?>" class="jp-jplayer"></div>
						  <div class="jp-gui">                    
							<div class="jp-title">
							  <ul>
								<li><?php echo $vid->video_title; ?></li>
							  </ul>
							</div>
							
							<div class="jp-interface">
								<ul class="jp-controls">
									<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
									<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
									<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								</ul>
								<ul class="jp-toggles">
									<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
									<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
								</ul>
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>
									</div>
								</div>
								
								<div class="jp-volume-bar">
									<a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>
									<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>
									<div class="jp-volume-bar-value"></div>
									<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a>
								</div>
								
								<div class="jp-current-time"></div>
								<div class="jp-duration"></div>
							</div>
							
						  </div>
						  <div class="jp-no-solution">
							<span>There was an issue</span>
							<p>It appears we do not support this file format.</p>
						  </div>
						</div>
					  </div>
							
						<div class="clear-10"></div>
							
						<script>
						  $("#jquery_jplayer_<?php echo $counter; ?>").jPlayer({
							ready: function () {
							  $(this).jPlayer("setMedia", {
								"<?php echo substr($vid->video_file_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/video/events/<?php echo $eventId; ?>/<?php echo $vid->video_file; ?>"
							  });
							},
							swfPath: "<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/Jplayer.swf",
							supplied: "<?php if(substr($vid->video_file_ext,1) == 'mp4'){ echo 'M4V'; } else{ echo substr($vid->video_file_ext,1); } ?>",
							cssSelectorAncestor: "#jp_container_<?php echo $counter; ?>"
						  });
						</script>
						<?php 
					}elseif($vid->video_file_ext == 'youtube'){
						?>
						<div class="jp-title"><?php echo $vid->video_title; ?></div>
						<iframe style="z-index:0" width="400" height="250" src="http://www.youtube.com/embed/<?php echo $vid->video_youtube; ?>?autoplay=0&wmode=opaque" frameborder="0" allowTransparency="true"></iframe>
						<?php
					}else{ ?>
                        <div class="jp-title"><?php echo $vid->video_title; ?></div>
                        <iframe src="http://player.vimeo.com/video/<?php echo $vid->video_youtube; ?>" width="400" height="250" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    <?php } ?>
                     
                     
                     <div class="clear-10"></div>
                    <a onclick="return confirm('Are you sure?')" class="yellowButton blod sixteen" style="position:relative; float:left; width:80px; margin-right:10px;" href="<?php echo base_url(); ?>index.php/events/deleteVideo/<?php echo $eventId; ?>/<?php echo $vid->video_id; ?>">DELETE?</a>
                    <?php if($vid->featured != 1){ ?>
                        <a class="yellowButton blod sixteen" style="position:relative; float:left; width:150px" href="<?php echo base_url(); ?>index.php/events/makeFeaturedVideo/<?php echo $eventId; ?>/<?php echo $vid->video_id; ?>">MAKE FEATURED</a>
                    <?php }else{ ?>
                        <a class="yellowButton greenButton blod sixteen" style="position:relative; float:left; width:100px" href="<?php echo base_url(); ?>index.php/events/removeFeaturedVideo/<?php echo $eventId; ?>/<?php echo $vid->video_id; ?>">FEATURED</a>
                    <?php }?>
                     <div class="clear-10"></div>
                     <hr class="dotted" />
                     <?php
				}
				?>
                
            </div>
            
           <div class="clear-10"></div>
            <!--
           <hr class="dotted" />
           <div class="clear-10"></div>
           
           <h2>Add More On Links</h2>
           <p>Let Users Know Where They Can Find More of Your video Clips</p>
           <div class="clear-10"></div>
           <form id="socialLinkForm" class="standardForm" action="<?php echo base_url();?>index.php/events/addMoreOnLinks/<?php echo $eventId; ?>" method="post">
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/google-plus.png" />
                    <label for='googleplus'>Google Plus</label>
                    <input type='text' name='googleplus' placeholder="http://" value="<?php echo $googlePlusLink; ?>" /> 
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/facebook.png" />
                    <label for='facebook'>Facebook</label>
                    <input type='text' name='facebook' placeholder="http://" value="<?php echo $facebookLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/twitter.png" />
                    <label for='twitter'>Twitter</label>
                    <input type='text' name='twitter' placeholder="http://" value="<?php echo $twitterLink; ?>"  />
                </div>
                                    
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/linkedin.png" />
                    <label for='linkedin'>LinkedIn</label>
                    <input type='text' name='linkedin' placeholder="http://" value="<?php echo $linkedInLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/youtube.png" />
                    <label for='youtube'>YouTube</label>
                    <input type='text' name='youtube' placeholder="http://" value="<?php echo $youtubeLink; ?>"  />
                </div>

                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/myspace.png" />
                    <label for='youtube'>MySpace</label>
                    <input type='text' name='myspace' placeholder="http://" value="<?php echo $myspaceLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/vimeo.png" />
                    <label for='vimeo'>Vimeo</label>
                    <input type='text' name='vimeo' placeholder="http://" value="<?php echo $vimeoLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/flickr.png" />
                    <label for='flickr'>Flickr</label>
                    <input type='text' name='flickr' placeholder="http://" value="<?php echo $flickrLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/behance.png" />
                    <label for='behance'>Behance</label>
                    <input type='text' name='behance' placeholder="http://" value="<?php echo $behanceLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/deviantArt.png" />
                    <label for='deviantArt'>DeviantArt</label>
                    <input type='text' name='deviantArt' placeholder="http://" value="<?php echo $deviantArtLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/pinterest.png" />
                    <label for='showdomid'>Pinterest</label>
                    <input type='text' name='pinterest' placeholder="http://" value="<?php echo $pinterestLink; ?>"  />
                </div>
                
                <div class="formWrap clearfix">
                    <img src="<?php echo base_url(); ?>themes/showdom/images/icons/lastFm.png" />
                    <label for='showdomid'>Last.Fm</label>
                    <input type='text' name='lastfm' placeholder="http://" value="<?php echo $lastfmLink; ?>"  />
                </div>
                <input type="hidden" name="redirect" value="profile" />
                <input type="hidden" name="section" value="video" />
                
            </form>
           -->
        </div>
                
    </div>
</div>

<script>
/*
    $('#save').click(function(){
	$('#socialLinkForm').submit();	
});
*/
</script>