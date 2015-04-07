<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>AD MANAGER</span>
            <h2>Create Ad</h2>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        <?php echo '<img src="'.base_url().''.image("themes/showdom/images/ads/".$ad->ad_image."", 190, 190).'" />'; ?>
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li>&raquo; Ad Information</li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
        
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
                        <input type="text" name="adUrl" value="<?php echo $ad->ad_link; ?>"  />
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
                        <label for="adImage">AD IMAGE</label>
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
                <input type="hidden" name="adId" value="<?php echo $ad->ad_id; ?>" />
                <input type="submit" value="SAVE & CONTINUE" name="submit" class="yellowButton sixteen bold" />
            </form>
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
				
				$('#topRightButton').click(function(e){
					
					$('#standardForm').submit();
					e.preventDefault();	
				});
				
				
				$('#ageRestricted').change(function(){
					if($(this).val() == 1){
						$('#minAge').prop('disabled', false);
					}else{
						$('#minAge').prop('disabled', true);
					}
				});
								
			});
		</script>
        
    </div>
</div>