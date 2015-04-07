<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>PROFILE MANAGER</span>
            <h2>Edit Profile</h2>
            <div id="actions">
                <a href="<?php echo base_url(); ?>index.php/profile/" id="skip" class="yellowButton sixteen bold">SKIP</a>
                <a id="save" class="yellowButton sixteen bold">SAVE & EXIT</a>
            </div>
            <hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/profile/edit">Profile Information</a></li>
                    <li>&raquo; Social Links</li>
                    <li><a href="<?php echo base_url(); ?>index.php/profile/disableAccount">Deactivate Account</a></li>
                </ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
				<h2 class="bold">Social Media Links</h2>
                <p>Let Users Know Where They Can Find More Information About Yourself</p>
                <div class="clear-10"></div>
                <form id="socialLinkForm" class="standardForm" action="<?php echo base_url();?>index.php/profile/updateSocialLinks" method="post">
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
                    <!--
                    <input type="submit" value="SAVE & EXIT" name="submit" class="yellowButton sixteen bold" />
                    -->
                </form>
        </div>
        

    </div>
</div>

<script>
	$('#save').click(function(){
		$('#socialLinkForm').submit();	
	});
</script>
