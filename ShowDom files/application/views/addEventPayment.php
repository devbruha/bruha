<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event</h2>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>
                    <li>&raquo; Posting Type</li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <div class="formLeft">
                    <div class="formWrap clearfix">
                        <strong>AD TITLE: </strong>
                        <?php echo $ad->ad_title; ?>
                    </div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong>AD SIZE: </strong>
                        <?php echo $adSizes; ?>
                	</div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong for="Category">CATEGORY: </strong>
                        <?php 
							foreach($getAdCategories as $getAdCat){
								$cats[] = getAdCatName($getAdCat->cat_id);
							}
							echo implode(', ',$cats);
						?>
                	</div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong>SUB-CATEGORY: </strong>
                        <?php 
							foreach($getAdSubCategories as $getAdSubCat){
								$cats[] = getAdSubCatName($getAdSubCat->sub_cat_id);
							}
							echo implode(', ',$cats);
						?>
                	</div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong>AD URL: </strong>
                        <?php echo $ad->ad_link; ?>
                    </div>
                                        
                </div>
                
                <div class="formRight">                    
                    <div class="formWrap clearfix">
                        <strong>LOCATION: </strong>
                        <?php
							foreach($getAdLocations as $getAdLocation){
								echo '<p>'.$getAdLocation->ad_location.' - '.$getAdLocation->ad_distance.' km</p>';	
							}
						?>

                    </div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong>START DATE: </strong>
                        <?php echo $ad->ad_start_date ?>
                    </div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
						<?php 														
							$start = strtotime($ad->ad_end_date);
							$end = strtotime($ad->ad_start_date);
							$days =  $start-$end;
							$days = ceil($days/86400);
							echo '<p>This ad will run for a total of '.$days.' days</p>';
							echo '<div class="clear-10"></div>';
							$start = strtotime(date('y-m-d'));
							$end = strtotime($ad->ad_start_date);
							$days =  $start-$end;
							$days = ceil($days/86400);
							
							if ($days < 0){
								echo '<p>This ad will start to run in '.substr($days,1).' days</p>';
							}else{
								echo '<p>This ad has been running for '.$days.' days</p>';
							}
							echo '<div class="clear-10"></div>';
						?>
                    </div>  
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <strong>AD KEYWORDS (Separate by Commas): </strong>
                        <?php
							$keys = array();
							foreach($keywords as $keyword){
								$keys[] = $keyword->keyword_value;
							} 
							$keys = implode(", ", $keys);
						?>
                        <?php echo $keys; ?>
                    </div>                    
                    
                </div>
                
                <div class="clear-10"></div>
                
                <strong>COST: </strong>
                <p>$<?php echo number_format($getAdCost,2); ?> </p>
                <br/>
                <br/>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="SDDQ8ADTDWMEE">
                    <input type="hidden" name="lc" value="CA">
                    <input type="hidden" name="item_name" value="Showdom Ad Payment">
                    <input type="hidden" name="item_number" value="<?php echo $ad->ad_id; ?>">
                    <input type="hidden" name="amount" value="<?php echo number_format($getAdCost,2); ?>">
                    <input type="hidden" name="currency_code" value="CAD">
                    <input type="hidden" name="button_subtype" value="services">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="tax_rate" value="13">
                    <input type="hidden" name="shipping" value="0.00">
                    <input type="hidden" name="return" value="<?php echo base_url(); ?>index.php/events/eventPaymentComplete/<?php echo $eventId; ?>" />
                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynow_LG.gif:NonHosted">
                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
                
                <br/>
                <p>Or enter promo code:</p>
                <?php
					if(isset($message)){
						echo '<p style="color:red">'.$message.'</p>';
					}
				?>
                <br/>
                <form id="standardForm" method="post" action="<?php echo base_url(); ?>index.php/ads/payWithCodeFromEvent">
                	<div class="formWrap clearfix">
                    	<label>Code: </label>
                        <input type="text" name="promocode" value="" />
                        <input type="hidden" name="item_number" value="<?php echo $ad->ad_id; ?>">
                        <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">
                    </div>
                    <div class="formWrap clearfix">
                    	<input type="submit" value="Submit" name="submit" class="yellowButton sixteen bold" style="width:200px;" />
                    </div>
                </form>
                
        </div>
                
    </div>
</div>