<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Create Event Ad</h2>
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
                    <li>&raquo; Posting Type</li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <div class="clear-10"></div>
            <form id="standardForm" action='<?php echo base_url();?>index.php/ads/addAd' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
				<div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventName">AD TYPE <a href="<?php echo base_url();?>index.php/ads/adBreakdown" target="_blank">View Breakdown</a></label>
                        <div class="clear-10"></div>
                        <p><input type="radio" name="adSize" value="1" checked="checked" /><label>400-80</label></p>
                        <p><input type="radio" name="adSize" value="2" /><label>820-100</label></p>
                        <div class="clear-10"></div>
                        <p><input type="radio" name="adSize" value="3" /><label>610-100</label></p>
                        <p><input type="radio" name="adSize" value="4" /><label>660-100</label></p>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventName">AD TITLE</label>
                        <input type="text" name="adTitle" class="required" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="Category">CATEGORY</label>
                        <select name="adCategory[]" id="adCategory" class="required" multiple="multiple">
						  <?php
								foreach($adCategories as $adCategorie){
									echo '<option value="'.$adCategorie->cat_id.'">'.$adCategorie->cat_name.'</option>';
								}
							 ?>
                        </select>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="adSubCategory">SUB-CATEGORY</label>
                        <select name="adSubCategory[]" id="adSubCategory" class="required" multiple="multiple">
                             <?php
								foreach($adSubCategories as $adSubCategorie){
									echo '<option value="'.$adSubCategorie->sub_cat_id.'">'.$adSubCategorie->sub_cat_name.'</option>';
								}
							 ?>
                        </select>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="adUrl">AD URL</label>
                        <input type="text" name="adUrl"  /> 
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="adUrl">USE EVENT URL FOR AD</label>
                        <input type="checkbox" name="useEventUrl" value="<?php echo base_url(); ?>index.php/events/view/<?php echo $eventId; ?>" />
                    </div>
                                        
                </div>
                
                <div class="formRight">
                    
                    <div class="formWrap clearfix">
                        <label for="adName">LOCATION*</label>
                        <input type="text" name="adLocation[]" id="adLocation" class="required" />
						<script>
							var input = document.getElementById('adLocation');
							var autocomplete = new google.maps.places.Autocomplete(input);
						</script>
                    </div>
                    
                    <div class="formWrap clearfix" id="additionalLocations">
                        <label for="adDistance">AD REACH OUT DISTANCE (In km)</label>
                        <input type="text" name="adDistance[]" value="100" />
                	</div>
                    
                    <div id="addAdditionalLocations">
                    
                    </div>
                    
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                    	<a id="addAnotherLocation" href="">Add another location</a>
                    </div>
                    
                    <div class="clear-10"></div>
                    
                    <div class="formWrap clearfix">
                        <label for="adImage">AD IMAGE</label>
                        <input type="file" name="adImage" id="adImage" class="required" />
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
                        <textarea name="adKeywords"></textarea>
                    </div>                    
                    
                </div>
                <input type="hidden" name="eventId" value="<?php echo $eventId; ?>" />
                <input type="hidden" name="redirect" value="events/eventPayment/<?php echo $eventId; ?>" />
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
			validClass: "success",
            submitHandler: function(form) {
                var eventStartMonth = new Array();
                var eventStartDay = new Array();
                var eventStartYear = new Array();

                $('select[name^=eventStartMonth]').map(function() {
                    eventStartMonth.push($(this).val());
                });
                $('select[name^=eventStartDay]').map(function() {
                    eventStartDay.push($(this).val());
                });
                $('select[name^=eventStartYear]').map(function() {
                    eventStartYear.push($(this).val());
                });


                var currentTime = new Date();
                var month = currentTime.getMonth() + 1;
                var day = currentTime.getDate();
                var year = currentTime.getFullYear();
                if(month<10){
                    month = '0'+month;
                }
                if(day<10){
                    day = '0'+day;
                }
                var currentDate = year + month + day;

                var errors = new Array();
                errors = [];

                for (var i = 0; i < eventStartMonth.length; i++) {
                    var pickedMonth = eventStartYear[i]+eventStartMonth[i]+eventStartDay[i];
                    if(pickedMonth < currentDate){
                        errors.push('fail');
                    }
                }

                if(errors.length == 0){
                    form.submit();
                }else{
                    alert('Events can not start before the current date.');
                }

            }
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