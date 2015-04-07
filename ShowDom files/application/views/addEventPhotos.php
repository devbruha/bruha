<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event</h2>
            <div id="actions">
                <a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>" id="skip" class="yellowButton sixteen bold">BACK</a>
                <a id="save" class="yellowButton sixteen bold" href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">SAVE & CONTINUE</a>
            </div>
            <hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>

                    <li>&raquo; Add Photos</li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventVideo//<?php echo $eventId; ?>">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <h2>Add New Photo</h2>
            <div class="clear-10"></div>
            <form class="standardForm" action="<?php echo base_url(); ?>index.php/events/addPhotos/<?php echo $eventId; ?>" method="post" enctype="multipart/form-data">
                <div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">BROWSE FOR PHOTO (Less than 1MB)</label>
                        <input type="file" name="eventImage" />
                	</div>
                    <div class="formWrap clearfix">
                    	<button style="width:110px" class="yellowButton sixteen bold">ADD PHOTO</button>
                    </div>
                </div>
                
                <div class="formRight">
                    <div class="formWrap clearfix">
                        <label for="eventCategory">PHOTO CAPTION</label>
                        <input type="text" name="photoCaption" value="" />
                	</div>
                </div>
             </form>
            <div class="clear-10"></div>
            <hr class="dotted" />
            <div class="clear-10"></div>
            <div id="imageThumbList">
				<?php  
                    foreach($photos as $photo){
                        echo '<div>';
                            echo '<img src="'.base_url().''.image("themes/showdom/images/events/".$eventId."/gallery/".$photo->photo_file, 200, 160).'" />';
							echo '<div class="photoGalleryManage">';
								echo '<a title="'.$photo->photo_caption.'" rel="view_photo_group" class="viewphoto yellowButton sixteen bold" href="'.base_url().'themes/showdom/images/events/'.$eventId.'/gallery/'.$photo->photo_file.'">VIEW</a>';
								echo '<a title="'.$photo->photo_caption.'" class="yellowButton sixteen bold" href="'.base_url().'index.php/events/deletePhoto/'.$eventId.'/'.$photo->photo_id.'">DELETE?</a>';
							echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="clear-10"></div>
            <!--
           <hr class="dotted" />
           <div class="clear-10"></div>
           <h2>Add More On Links</h2>
           <p>Let Users Know Where They Can Find More of Your Photos</p>
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
                <input type="hidden" name="redirect" value="events/eventAudio/<?php echo $eventId; ?>" />
                <input type="hidden" name="section" value="image" />
                
            </form>
           -->
        </div>
                
    </div>
</div>

<script>
	$("a.viewphoto").fancybox();
	
	/*
    $('#save').click(function(){
		$('#socialLinkForm').submit();	
	});
	*/
	
</script>