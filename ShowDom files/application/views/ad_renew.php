<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>AD MANAGER</span>
            <h2>Create Ad</h2>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        <?php echo '<img src="http://localhost/showdom/'.image("themes/showdom/images/ads/".$ad->ad_image."", 190, 190).'" />'; ?>
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li>&raquo; Ad Information</li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
        
			<form id="standardForm" action='<?php echo base_url();?>index.php/ads/renewAdSubmit' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
				<div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventName">AD TITLE</label>
                        <input type="text" name="adTitle" class="required" value="<?php echo $ad->ad_title; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="adSize">AD SIZE</label>
                        <select name="adSize" class="required">
                            <?php
								foreach($adSizes as $adSize){
									echo '<option '.(($adSize->ad_size_id == $ad->ad_size) ? "SELECTED " : "") .' value="'.$adSize->ad_size_id.'">'.$adSize->ad_size.'</option>';
								}
							?>
                        </select>
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
                        <?php
							foreach($getAdLocations as $getAdLocation){
								$randId = rand(0, 1500);
								echo '<label for="adName">LOCATION</label>';
								echo '<input type="text" name="adLocation[]" id="adLocation'.$randId.'" class="required" value="'.$getAdLocation->ad_location.'" />';
								echo '<label for="adDistance">AD REACH OUT DISTANCE (In km)</label>';
								echo '<input type="text" name="adDistance[]" value="'.$getAdLocation->ad_distance.'" />';
								echo '<script>';
									echo 'var input = document.getElementById("adLocation'.$randId.'");';
									echo 'var autocomplete = new google.maps.places.Autocomplete(input);';
								echo '</script>';
								echo '<div class="clear-10"></div>';
							}
						?>
                        <div class="clear-10"></div>
                    </div>
                    
                    <div id="addAdditionalLocations">
                    
                    </div>
                    
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                    	<a id="addAnotherLocation" href="">Add another location</a>
                    </div>
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <label for="adImage">AD IMAGE (150px x 150px for Best Results)</label>
                        <input type="file" name="adImage" id="adImage" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label>START DATE</label>
                        <select name="eventStartMonth" class="addEventMonth">
                            <option value="">MM</option>
                            <?php 
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option  value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventStartDay" class="addEventDay">
                            <option value="">DD</option>
                            <?php 
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="eventStartYear" class="addEventyear">
                            <option value="">YYYY</option>
                            <?php 
                                for($i=date('Y');$i<=date('Y')+20;$i++){
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label>HOW MANY DAYS WOULD YOU LIKE THIS AD TO RUN FOR</label>
                        <select name="numberOfDays" class="numberOfDays">
                        	<?php 
								for ($i = 1; $i <= 30; $i++) {
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							?>
                        </select>
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
                <input type="hidden" name="redirect" value="ads/adPayment/<?php echo $ad->ad_id; ?>" /> 
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
							
							
				$('#addAnotherLocation').click(function(){
					randomnumber=Math.floor(Math.random()*10000);
					$('<div class="formWrap clearfix"><label for="adName">LOCATION*</label><input type="text" name="adLocation[]" id="adLocation'+randomnumber+'" class="required" /></div>').appendTo('#addAdditionalLocations');
					$('<div class="formWrap clearfix" id="additionalLocations"><label for="adDistance">AD REACH OUT DISTANCE (In km)</label><input type="text" name="adDistance[]" value="100" /></div>').appendTo('#addAdditionalLocations');
					var input = document.getElementById("adLocation"+randomnumber+"");
					var autocomplete = new google.maps.places.Autocomplete(input);
					return false;
				});
								
			});
		</script>
        
    </div>
</div>