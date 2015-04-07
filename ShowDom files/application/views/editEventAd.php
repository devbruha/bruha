<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Edit Event</h2>
			<div id="actions">
                <a id="save" class="yellowButton sixteen bold">SAVE & CONTINUE</a>
            </div>
            <hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/events/edit/<?php echo $eventId; ?>">Event Information</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/postingType/<?php echo $eventId; ?>">Posting Type</a></li>
                    <li>Manage Event Ad</li>		
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
        	<p>With a featured event you get a free advertisement</p>
            <div class="clear-10"></div>
            <form id="standardForm" action='<?php echo base_url();?>index.php/ads/updateAd' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
				<div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventName">AD TITLE</label>
                        <input type="text" name="adTitle" class="required" value="<?php echo $ad->ad_title; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <?php
							foreach($getAdCategories as $getAdCat){
								$cats[] = $getAdCat->cat_id;
							}
							
						?>
                    
                        <label for="Category">CATEGORY</label>
                        <select name="adCategory[]" id="adCategory" class="required" multiple="multiple">
						  <?php 
								foreach($adCategories as $adCategorie){
									if(in_array($adCategorie->cat_id,$cats)){
										echo '<option selected="selected" value="'.$adCategorie->cat_id.'">'.$adCategorie->cat_name.'</option>';
									}else{
										echo '<option value="'.$adCategorie->cat_id.'">'.$adCategorie->cat_name.'</option>';
									}
									
								}
							 ?>
                        </select>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <?php
							$subcats = array();
							foreach($getAdSubCategories as $getAdSubCat){
								$subcats[] = $getAdSubCat->sub_cat_id;
							}
						?>
                        <label for="adSubCategory">SUB-CATEGORY</label>
                        <select name="adSubCategory[]" id="adSubCategory" class="required" multiple="multiple">
                             <?php
								foreach($adSubCategories as $adSubCategorie){
									if(in_array($adSubCategorie->sub_cat_id,$subcats)){
										echo '<option selected="selected" value="'.$adSubCategorie->sub_cat_id.'">'.$adSubCategorie->sub_cat_name.'</option>';
									}else{
										echo '<option value="'.$adSubCategorie->sub_cat_id.'">'.$adSubCategorie->sub_cat_name.'</option>';
									}
									
								}
							 ?>
                        </select>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="adUrl">AD URL</label>
                        <input type="text" name="adUrl" value="<?php echo $ad->ad_link; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="adUrl">USE EVENT URL FOR AD</label>
                        <input type="checkbox" name="useEventUrl" value="<?php echo base_url(); ?>index.php/events/view/<?php echo $eventId; ?>" />
                    </div>
                                        
                </div>
                
                <div class="formRight">
                    
                    <div class="formWrap clearfix">
                        <label for="adName">LOCATIONS</label>
                        <?php
							foreach($getAdLocations as $getAdLocation){
								echo '<p>'.$getAdLocation->ad_location.' - '.$getAdLocation->ad_distance.' km</p>';	
							}
						?>
                        <div class="clear-10"></div>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="adDistance">AD REACH OUT DISTANCE (In km)</label>
                        <input type="text" name="adDistance" value="<?php echo $ad->ad_distance; ?>" />
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="adImage">AD IMAGE (150px x 150px for Best Results)</label>
                        <input type="file" name="adImage" id="adImage" />
                    </div>
                    
                    <div class="formWrap clearfix">
                    	<?php 
							$adStarts= explode('-',$ad->ad_start_date); 
							$startMonth = $adStarts[1];
							$startDay = $adStarts[2];
							$startYear = $adStarts[0];
						?>
                        
                        <label>START DATE</label>
                        <select name="eventStartMonth" class="addEventMonth" disabled="disabled">
                            <option value="">MM</option>
                            <?php 
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($startMonth == $num_padded) ? "SELECTED " : "").' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventStartDay" class="addEventDay" disabled="disabled">
                            <option value="">DD</option>
                            <?php 
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($startDay == $num_padded) ? "SELECTED " : "").' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventStartYear" class="addEventyear" disabled="disabled">
                            <option value="">YYYY</option>
                            <?php 
                                for($i=date('Y');$i<=date('Y')+20;$i++){
                                    echo '<option '.(($startYear == $i) ? "SELECTED " : "").' value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="formWrap clearfix">
						<?php 
							$adEnds= explode('-',$ad->ad_end_date); 
							$endMonth = $adEnds[1];
							$endDay = $adEnds[2];
							$endYear = $adEnds[0];
						?>
                        
                        <label>END DATE*</label>
                        <select name="eventEndMonth" class="addEventMonth" disabled="disabled">
                            <option value="">MM</option>
                            <?php 
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($endMonth == $num_padded) ? "SELECTED " : "").' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventEndDay" class="addEventDay" disabled="disabled">
                            <option value="">DD</option>
                            <?php 
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($endDay == $num_padded) ? "SELECTED " : "").' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventEndYear" class="addEventyear" disabled="disabled">
                            <option value="">YYYY</option>
                            <?php 
                                for($i=date('Y');$i<=date('Y')+20;$i++){
                                    echo '<option '.(($endYear == $i) ? "SELECTED " : "").' value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>  
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
                    
                    <div class="formWrap clearfix">
                        <label for="adName">AD KEYWORDS (Separate by Commas)*</label>
                        <?php
							$keys = array();
							foreach($keywords as $keyword){
								$keys[] = $keyword->keyword_value;
							} 
							$keys = implode(",", $keys);
						?>
                        <textarea name="adKeywords"><?php echo $keys; ?></textarea>
                    </div>                
                    
                </div>
                <input type="hidden" name="eventId" value="<?php echo $eventId; ?>" />
                <input type="hidden" name="adId" value="<?php echo $ad->ad_id; ?>" />
                <input type="hidden" name="adSize" value="1" />
                <input type="hidden" name="redirect" value="events/eventPhotos/<?php echo $eventId; ?>" />
                
            </form>
                
        </div>
                
    </div>
</div>


<script type="text/javascript">
			$('#adLocation').change(function(){
				var geocoder = new google.maps.Geocoder();
				var address = $(this).val();
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status != google.maps.GeocoderStatus.OK) {
						alert('We are having issues geocoding this address. Please be as specific as posible.');	
					}
				}); 
			});

			$(document).ready(function(){
				
				$("#standardForm").validate({
					validClass: "success"
				});
				
				$('input[name="useEventUrl"]').click(function(){
					if($(this).is(':checked')){
						$('input[name="adUrl"]').val($(this).val());
					}else{
						$('input[name="adUrl"]').val(' ');	
					}
				});
				
				$('#save').click(function(){
					$('#standardForm').submit();	
				});
								
			});
		</script>