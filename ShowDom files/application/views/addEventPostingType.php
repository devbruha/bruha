<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event</h2>
            SELECT A POSTING TYPE TO CONTINUE
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>
                    <li>&raquo; Posting Type</li>
                    <?php if($eventPostingType == 1){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/events/manageAd/<?php echo $eventId; ?>">Manage Event Ad</a></li>		
					<?php } ?>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventVideo//<?php echo $eventId; ?>">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <div class="formLeft">
                <div class="formWrap clearfix">
                    
                    <a href="<?php echo base_url(); ?>index.php/events/postingTypeSelect/<?php echo $eventId; ?>/0" class="yellowButton largeButton <?php if($eventPostingType == 0 ){ echo 'greenButton'; } ?>">
                        <span>FREE EVENT</span>
                        <span>STANDARD PRIORITY</span>
                    </a>
                    
                    <div class="greyBox">
                        <h3>What Free Events Offer</h3>
                        <p>
                            Free Events offer all the standard features when promoting your event to your audience. Features like: uploading event information; event location; posting links associated with the event as well as the URL where audiences can buy tickets. You can post event-affiliated photo, audio and video, and select what media you’d like audiences to Quick Preview on the main map. Your created event will appear on the main map as a tag. You will be able to view statistics about your event: total quick preview views, total views, total attending, and breakdown on the location of views and those attending. You can also update you event status in real-time, informing audiences of ticket left for sale hours prior to the event starting.
                    	</p>
                    </div>
                    <div class="clear-10"></div>
                    <a href="<?php echo base_url(); ?>index.php/events/postingTypeSelect/<?php echo $eventId; ?>/0" class="yellowButton bold sixteen <?php if($eventPostingType == 0 ){ echo 'greenButton'; } ?>">CONTINUE - FREE EVENT</a>
                    
                </div>
            </div>
            
            <div class="formRight">
                <div class="formWrap clearfix">
                    <a href="<?php echo base_url(); ?>index.php/events/postingTypeSelect/<?php echo $eventId; ?>/1"  class="yellowButton largeButton <?php if($eventPostingType == 1 ){ echo 'greenButton'; } ?>">
                        <span>FEATURED EVENT</span>
                        <span>UPGRADE TO HIGH PRIORITY</span>
                    </a>
                    
                    <div class="greyBox">
                        <h3>What Featured Events Offer</h3>
                        <p>
                            Featured Events offer more advertising opportunities on ShowDom.com for your event. Basic perks include a swapped colour "S" graphic and a listing in the Featured Ad category (under Event Updates). You may chose to purchase one or more designated advertising locations throughout the ShowDom.com website. You may select one or more cities or regions for your ad to be shown; attach a URL to the ad (if different from the ShowDom event URL); select the start date of your ad as well as them amount of days your ad will run for; and upload a graphic or photo for the ad spot. Based on the selected choices, a price is generated and you will be forward to a pay-pal screen to complete your payment. Ads may be edited, deleted and managed by viewing ad statistics.
                        </p>
                    </div>
                    <div class="clear-10"></div>
                    <a href="<?php echo base_url(); ?>index.php/events/postingTypeSelect/<?php echo $eventId; ?>/1" class="yellowButton bold sixteen <?php if($eventPostingType == 1 ){ echo 'greenButton'; } ?>">CONTINUE - FEATURED EVENT</a>
                </div>
            </div>
            <div class="clear-10"></div>
            <div class="greyBox">
                <h3>UPGRADE NOTICE</h3>
                <p>
                Events can be updated to a FEATURED EVENT at any time by choosing to EDIT the event and modifying the POSTING TYPE.
            	</p>
            </div>
                
        </div>
        
		<script type="text/javascript">
			$('#eventLocation').change(function(){
				var geocoder = new google.maps.Geocoder();
				var address = $(this).val();
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status != google.maps.GeocoderStatus.OK) {
						alert('We are having issues geocoding this address. Please be as specific as posible.');	
					}
				}); 
			});
        </script>
        
        <script>
			$(document).ready(function(){
				$("#standardForm").validate({
					validClass: "success"
				});
				
				$('#topRightButton').click(function(e){
					
					$('#standardForm').submit();
					e.preventDefault();	
				});
				
				$.ajax({
					url: '../events/getEventCategories',
					success: function(data) {
						var returnObj = '';
						var obj = $.parseJSON(data);
					    $.each(obj, function() {
					        returnObj += "<option value='"+this['cat_id']+"'>"+this['cat_name']+"</option>"; 
					    });
						$('#eventCategory').empty().append(returnObj);
						
					}
				});
				
				$('#eventCategory').change(function(){
					var cat = $(this).val();
					$.ajax({
						url: '../events/getEventSubCategories/'+cat,
						success: function(data) {
							var returnObj = '';
							var obj = $.parseJSON(data);
							returnObj += "<option value='0'>NA</option>"; 
							$.each(obj, function() {
								returnObj += "<option value='"+this['sub_cat_id']+"'>"+this['sub_cat_name']+"</option>"; 
							});
							$('#eventSubCategory').empty().append(returnObj);
							
						}
					});
				});
				
				$.ajax({
					url: '../events/getEventSubCategories/1',
					success: function(data) {
						var returnObj = '';
						var obj = $.parseJSON(data);
						returnObj += "<option value='0'>NA</option>"; 
						$.each(obj, function() {
							returnObj += "<option value='"+this['sub_cat_id']+"'>"+this['sub_cat_name']+"</option>"; 
						});
						$('#eventSubCategory').empty().append(returnObj);
						
					}
				});
				
			});
		</script>
        
    </div>
</div>