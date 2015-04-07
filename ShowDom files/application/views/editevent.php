<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>EVENT MANAGER</span>
            <h2>Edit Event</h2>
            <div id="actions">
                <a href="<?php echo base_url(); ?>index.php/profile" id="skip" class="yellowButton sixteen bold">BACK</a>
                <a id="save" class="yellowButton sixteen bold">SAVE & CONTINUE</a>
            </div>
			<hr />
        </div>
        
        <?php foreach($events as $event){ ?>
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li>&raquo; Event Information</li>

                    <li><a href="<?php echo base_url(); ?>index.php/events/eventPhotos/<?php echo $eventId; ?>">Add Photos</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventAudio/<?php echo $eventId; ?>">Add Audio</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/events/eventVideo//<?php echo $eventId; ?>">Add Videos</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
        
			<form id="standardForm" action='<?php echo base_url();?>index.php/events/editEvent' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
				<div class="formLeft">
                    <div class="formWrap clearfix">
                        <label for="eventName">EVENT NAME</label>
                        <input type="text" name="eventName" class="required" value="<?php echo $event->event_title; ?>" />
                    </div>

                    <div class="formWrap clearfix">
                        <label for="venueName">VENUE NAME</label>
                        <input type="text" name="venueName" value="<?php echo $event->venue_name; ?>" />
                    </div>

                    <div class="formWrap clearfix">
                        <label for="admissionPrice">ADMISSION PRICE</label>
                        <input type="text" name="admissionPrice" value="<?php echo $event->admission_price; ?>" />
                    </div>

                    <div class="formWrap clearfix">
                        <label for="eventCategory">CATEGORY</label>
                        <select name="eventCategory" id="eventCategory" class="required">
                            <option value="Music">Music</option>
                        </select> 
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventSubCategory">SUB-CATEGORY</label>
                        <select name="eventSubCategory" id="eventSubCategory" class="required">
                            <option value="Metal">Metal</option>
                        </select>
                	</div>

                    <div class="formWrap clearfix otherCategory" <?php if($event->event_sub_cat != 666666){ echo 'style="display:none;"';  } ?>>
                        <label for="eventSubCategory">OTHER CATEGORY</label>
                        <input name="otherCategory" type="text" value="<?php echo getEventOtherCategory($event->event_id); ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventWebsite">EVENT WEBSITE (If Applicable)</label>
                        <input type="text" name="eventWebsite" value="<?php echo $event->event_website; ?>"  />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventWebsite">TICKET LINK (If Applicable)</label>
                        <input type="text" name="eventTicketLink" value="<?php echo $event->event_tickets; ?>" />
                    </div>


                    <?php
                    $counter = 0;
                    $numDates = count($dates);
                    foreach($dates as $date){
                        $counter ++;
                    ?>
                        <div class="formWrap clearfix eventDate<?php echo $date->start_date_time_id; ?>">
                            <label>
                                <strong>START DATE <?php echo $counter; ?></strong> - <a class="removeEventDate" id="removeEventDate_<?php echo $date->start_date_time_id ?>" href="#">Remove</a>
                            </label>
                        </div>
                        <div class="formWrap clearfix eventDate<?php echo $date->start_date_time_id; ?>">
                            <?php
                            $startDate = $date->start_date_time_start_date;
                            $startDate = explode('-',$startDate);
                            ?>
                            <label>START DATE</label>
                            <select name="eventStartMonth[]" class="addEventMonth">
                                <option value="">MM</option>
                                <?php
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($startDate[1] == $num_padded) ? "SELECTED " : "") .' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                                ?>
                            </select>
                            <select name="eventStartDay[]" class="addEventDay">
                                <option value="">DD</option>
                                <?php
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($startDate[2] == $num_padded) ? "SELECTED " : "") .' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                                ?>
                            </select>
                            <select name="eventStartYear[]" class="addEventyear">
                                <option value="">YYYY</option>
                                <?php
                                for($i=date('Y');$i<=date('Y')+20;$i++){
                                    echo '<option '.(($startDate[0] == $i) ? "SELECTED " : "") .' value="'.$i.'">'.$i.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formWrap clearfix eventDate<?php echo $date->start_date_time_id; ?>">
                            <?php
                            $endDate = $date->start_date_time_end_date;
                            $endDate = explode('-',$endDate);
                            ?>
                            <label>END DATE*</label>
                            <select name="eventEndMonth[]" class="addEventMonth">
                                <option value="">MM</option>
                                <?php
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($endDate[1] == $num_padded) ? "SELECTED " : "") .' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                                ?>
                            </select>
                            <select name="eventEndDay[]" class="addEventDay">
                                <option value="">DD</option>
                                <?php
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($endDate[2] == $num_padded) ? "SELECTED " : "") .' value="'.$num_padded.'">'.$num_padded.'</option>';
                                }
                                ?>
                            </select>
                            <select name="eventEndYear[]" class="addEventyear">
                                <option value="">YYYY</option>
                                <?php
                                for($i=date('Y');$i<=date('Y')+20;$i++){
                                    echo '<option '.(($endDate[0] == $i) ? "SELECTED " : "") .' value="'.$i.'">'.$i.'</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formWrap clearfix eventDate<?php echo $date->start_date_time_id; ?>">
                            <?php
                            $startTime = $date->start_date_time_start_time;
                            ?>
                            <label>START TIME*</label>
                            <select name="eventStartTime[]">
                                <option value="00">12:00 AM</option>
                                <?php
                                for($i=1;$i<=11;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($startTime == $num_padded.':00:00') ? "SELECTED " : "") .' value="'.$num_padded.':00">'.$num_padded.':00 AM</option>';
                                    echo '<option '.(($startTime == $num_padded.':30:00') ? "SELECTED " : "") .' value="'.$num_padded.':30">'.$num_padded.':30 AM</option>';
                                }
                                ?>
                                <option value="12">12:00 PM</option>
                                <?php
                                for($i=1;$i<=11;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    $val = $num_padded + 12;
                                    echo '<option '.(($startTime == $val.':00:00') ? "SELECTED " : "") .' value="'.$val.':00">'.$num_padded.':00 PM</option>';
                                    echo '<option '.(($startTime == $val.':30:00') ? "SELECTED " : "") .' value="'.$val.':30">'.$num_padded.':30 PM</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="formWrap clearfix eventDate<?php echo $date->start_date_time_id; ?>">
                            <?php
                            $endTime = $date->start_date_time_end_time;
                            ?>
                            <label>END TIME*</label>
                            <select name="eventEndTime[]">
                                <option value="00">12:00 AM</option>
                                <?php
                                for($i=1;$i<=11;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option '.(($endTime == $num_padded.':00:00') ? "SELECTED " : "") .' value="'.$num_padded.':00">'.$num_padded.':00 AM</option>';
                                    echo '<option '.(($endTime == $num_padded.':30:00') ? "SELECTED " : "") .' value="'.$num_padded.':30">'.$num_padded.':30 AM</option>';
                                }
                                ?>
                                <option value="12">12:00 PM</option>
                                <?php
                                for($i=1;$i<=11;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    $val = $num_padded + 12;
                                    echo '<option '.(($endTime == $val.':00:00') ? "SELECTED " : "") .' value="'.$val.':00">'.$num_padded.':00 PM</option>';
                                    echo '<option '.(($endTime == $val.':30:00') ? "SELECTED " : "") .' value="'.$val.':30">'.$num_padded.':30 PM</option>';
                                }
                                ?>
                            </select>
                        </div>

                    <hr class="eventDate<?php echo $date->start_date_time_id; ?>" />
                    <?php
                    }
                    ?>

                    <div id="additionalDateTimes">

                    </div>

                    <div class="formWrap clearfix">
                        <a id="addDateTime" href="#">Add Another Date/Time</a>
                    </div>
                    
                </div>
                
                <div class="formRight">

                    
                    <div class="formWrap clearfix">
                        <label for="eventName">LOCATION*</label>
                        <input id="eventLocation" type="text" name="eventLocation" class="required" value="<?php echo $event->event_location; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventImage">EVENT IMAGE (150px x 150px for Best Results)</label>
                        <input type="file" name="eventImage" id="eventImage" />
                        <div id="imagePreview">
                            <?php echo '<img src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 200, 200).'" />'; ?>
                        </div>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label>EVENT CREATOR TYPE*</label>
                        <select name="eventCreatorType">
                             <option value="Artist" <?php if($event->event_location == 'Artist'){ echo 'SELECTED'; } ?>>Artist</option>
                             <option value="Venue" <?php if($event->event_location == 'Venue'){ echo 'SELECTED'; } ?>>Venue</option>
                             <option value="Promoter" <?php if($event->event_location == 'Promoter'){ echo 'SELECTED'; } ?>>Promoter</option>
                        </select>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventName">EVENT KEYWORDS (Separate by Commas)*</label>
                        <textarea name="eventKeywords"><?php 
								$theKeywords = '';
								foreach($keywords as $keyword){
									$theKeywords .= $keyword->keyword_value.',';
								}
								echo substr_replace($theKeywords,'',-1)
							?></textarea>
                    </div>
                    
                    <div class="formWrap clearfix" <?php if($access != 659){ echo 'style="display:none;"'; } ?>>
                        <label for="claimEvent">THIS EVENT CAN BE CLAIMED<span class="red">*</span></label>
                        <select name="claimEvent" id="claimEvent" class="required">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="formWrap clearfix">
                        <label for="eventDescription">EVENT DESCRIPTION*</label>
                        <textarea name="eventDescription" class="required" style="width:99% !important"><?php echo $event->event_description; ?></textarea>
                    </div>


                    <div class="formWrap clearfix">
                        <label for="ageRestricted">AGE RESTRICTED<span class="red">*</span></label>
                        <select name="ageRestricted" id="ageRestricted" class="required">
                            <option value="0" <?php if($event->event_min_age == 0){ echo 'SELECTED'; } ?>>No</option>
                            <option value="1" <?php if($event->event_min_age != 0){ echo 'SELECTED'; } ?>>Yes</option>
                        </select>
                    </div>

                    <div class="formWrap clearfix">
                        <label for="minAge">SET MINIMUM AGE<span class="red">*</span></label>
                        <input type="text" name="minAge" id="minAge" maxlength='2' class="required" <?php if($event->event_min_age == 0){ echo 'disabled="disabled"'; } ?> value="<?php if($event->event_min_age != 0){ echo $event->event_min_age; } ?>" />
                    </div>

                </div>

                
                <input type="hidden" name="eventid" value="<?php echo $event->event_id; ?>" />
            </form>
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

                function readURL(input) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            //$('#blah').attr('src', e.target.result);
                            $('#imagePreview').html(' ');
                            $('#imagePreview').append('<img src="'+e.target.result+'" />');
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#eventImage").change(function(){
                    $('#imagePreview').css('display','block');
                    readURL(this);
                });

                numStartDates = <?php echo $numDates; ?>;
                $('#addDateTime').click(function(){
                    var randomnumber=Math.floor(Math.random()*11);
                    numStartDates ++;
                    $('<div class="formWrap clearfix eventDate'+randomnumber+'"><label><strong>START DATE '+numStartDates+'</strong> - <a class="removeEventDate" id="removeEventDate_'+randomnumber+'" href="#">Remove</a></label></div>').appendTo('#additionalDateTimes');
                    $('<div class="formWrap clearfix eventDate'+randomnumber+'"><label>START DATE</label><select name="eventStartMonth[]" class="addEventMonth required"><option value="">MM</option><?php for($i=1;$i<=12;$i++){ $num_padded = sprintf("%02s", $i); echo '<option  value="'.$num_padded.'" '.(($num_padded == date('m'))? 'SELECTED':'').'>'.$num_padded.'</option>';}?></select><select name="eventStartDay[]" class="addEventDay required"><option value="">DD</option><?php for($i=1;$i<=31;$i++){ $num_padded = sprintf("%02s", $i); echo '<option value="'.$num_padded.'" '.(($num_padded == date('d'))? 'SELECTED':'').'>'.$num_padded.'</option>'; } ?> </select><select name="eventStartYear[]" class="addEventyear required"> <option value="">YYYY</option> <?php for($i=date('Y');$i<=date('Y')+5;$i++){ echo '<option value="'.$i.'" '.(($i == date('Y'))? 'SELECTED':'').'>'.$i.'</option>'; } ?> </select></div>').appendTo('#additionalDateTimes');
                    $('<div class="formWrap clearfix eventDate'+randomnumber+'"><label>END DATE</label><select name="eventEndMonth[]" class="addEventMonth required"><option value="">MM</option><?php for($i=1;$i<=12;$i++){ $num_padded = sprintf("%02s", $i); echo '<option  value="'.$num_padded.'" '.(($num_padded == date('m'))? 'SELECTED':'').'>'.$num_padded.'</option>';}?></select><select name="eventEndDay[]" class="addEventDay required"><option value="">DD</option><?php for($i=1;$i<=31;$i++){ $num_padded = sprintf("%02s", $i); echo '<option value="'.$num_padded.'" '.(($num_padded == date('d'))? 'SELECTED':'').'>'.$num_padded.'</option>'; } ?> </select><select name="eventEndYear[]" class="addEventyear required"> <option value="">YYYY</option> <?php for($i=date('Y');$i<=date('Y')+5;$i++){ echo '<option value="'.$i.'" '.(($i == date('Y'))? 'SELECTED':'').'>'.$i.'</option>'; } ?> </select></div>').appendTo('#additionalDateTimes');
                    $('<div class="formWrap clearfix eventDate'+randomnumber+'"><label>START TIME*</label><select name="eventStartTime[]"><option value="00:00">12:00 AM</option><option value="00:30">12:30 AM</option><?php for($i=1;$i<=11;$i++){ $num_padded = sprintf("%02s", $i); echo '<option value="'.$num_padded.':00">'.$num_padded.':00 AM</option>'; echo '<option value="'.$num_padded.':30">'.$num_padded.':30 AM</option>'; } ?> <option value="12">12:00 PM</option> <?php for($i=1;$i<=11;$i++){ $num_padded = sprintf("%02s", $i); $val = $num_padded + 12; echo '<option value="'.$val.':00">'.$num_padded.':00 PM</option>'; echo '<option value="'.$val.':30">'.$num_padded.':30 PM</option>';  } ?> </select> </div>').appendTo('#additionalDateTimes');
                    $('<div class="formWrap clearfix eventDate'+randomnumber+'"><label>END TIME*</label><select name="eventEndTime[]"><option value="00:00">12:00 AM</option><option value="00:30">12:30 AM</option><?php for($i=1;$i<=11;$i++){ $num_padded = sprintf("%02s", $i); echo '<option value="'.$num_padded.':00">'.$num_padded.':00 AM</option>'; echo '<option value="'.$num_padded.':30">'.$num_padded.':30 AM</option>'; } ?> <option value="12">12:00 PM</option> <?php for($i=1;$i<=11;$i++){ $num_padded = sprintf("%02s", $i); $val = $num_padded + 12; echo '<option value="'.$val.':00">'.$num_padded.':00 PM</option>'; echo '<option value="'.$val.':30">'.$num_padded.':30 PM</option>';  } ?> </select> </div><hr class="eventDate'+randomnumber+'"/>').appendTo('#additionalDateTimes');
                    return false
                });

                $(document).on('click','.removeEventDate',function(){
                    var id = $(this).attr('id');
                    id = id.split('_');
                    id = id[1];
                    $('.eventDate'+id).remove();
                    return false;
                });

				$("#standardForm").validate({
					validClass: "success",
                    submitHandler: function(form) {
                        var eventStartMonth = new Array();
                        var eventStartDay = new Array();
                        var eventStartYear = new Array();

                        var eventEndMonth = new Array();
                        var eventEndDay = new Array();
                        var eventEndYear = new Array();

                        $('select[name^=eventStartMonth]').map(function() {
                            eventStartMonth.push($(this).val());
                        });
                        $('select[name^=eventStartDay]').map(function() {
                            eventStartDay.push($(this).val());
                        });
                        $('select[name^=eventStartYear]').map(function() {
                            eventStartYear.push($(this).val());
                        });

                        $('select[name^=eventEndMonth]').map(function() {
                            eventEndMonth.push($(this).val());
                        });
                        $('select[name^=eventEndDay]').map(function() {
                            eventEndDay.push($(this).val());
                        });
                        $('select[name^=eventEndYear]').map(function() {
                            eventEndYear.push($(this).val());
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
                        var currentDate = year +''+ month +''+ day;

                        var errors = new Array();
                        errors = [];

                        for (var i = 0; i < eventStartMonth.length; i++) {
                            var pickedMonth = eventStartYear[i]+eventStartMonth[i]+eventStartDay[i];
                            if(pickedMonth < currentDate){
                                errors.push('fail');
                            }
                        }
                        for (var i = 0; i < eventEndMonth.length; i++) {
                            var pickedMonth = eventEndYear[i]+eventEndMonth[i]+eventEndDay[i];
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
				
				$.ajax({
					url: '../../events/getEventCategories',
					success: function(data) {
						var returnObj = '';
						var obj = $.parseJSON(data);
					    $.each(obj, function() {
							if("<?php echo $event->event_cat; ?>" == this['cat_id']){
								returnObj += "<option SELECTED value='"+this['cat_id']+"'>"+this['cat_name']+"</option>"; 
							}else{
					        	returnObj += "<option value='"+this['cat_id']+"'>"+this['cat_name']+"</option>"; 
							}
					    });
						$('#eventCategory').empty().append(returnObj);

					}
				});
				
				$('#eventCategory').change(function(){
					var cat = $(this).val();
					$.ajax({
						url: '../../events/getEventSubCategories/'+cat,
						success: function(data) {
							var returnObj = '';
							var obj = $.parseJSON(data);
							returnObj += "<option value='0'></option>";
							$.each(obj, function() {
								returnObj += "<option value='"+this['sub_cat_id']+"'>"+this['sub_cat_name']+"</option>"; 
							});
                            returnObj += "<option value='666666'>Other</option>";
							$('#eventSubCategory').empty().append(returnObj);
							
						}
					});
				});

                $('#eventSubCategory').change(function(){
                    if($(this).val() == 666666){
                        $('.otherCategory').fadeIn();
                    }else{
                        $('.otherCategory').fadeOut();
                    }
                });
				
				$.ajax({
					url: '../../events/getEventSubCategories/<?php echo $event->event_cat; ?>',
					success: function(data) {
						var returnObj = '';
						var obj = $.parseJSON(data);
						returnObj += "<option value='0'></option>";
						$.each(obj, function() {
							if("<?php echo $event->event_sub_cat; ?>" == this['sub_cat_id']){
								returnObj += "<option SELECTED value='"+this['sub_cat_id']+"'>"+this['sub_cat_name']+"</option>"; 
							}else{
								returnObj += "<option value='"+this['sub_cat_id']+"'>"+this['sub_cat_name']+"</option>"; 
							}
                            if("<?php echo $event->event_sub_cat; ?>" == 666666){
                                returnObj += "<option value='666666' SELECTED>Other</option>";
                            }else{
                                returnObj += "<option value='666666'>Other</option>";
                            }

						});
						$('#eventSubCategory').empty().append(returnObj);
						
					}
				});
				
			});
		</script>
            
           
        </div>
         <?php } ?>
        
    </div>
</div>

<script>
	$('#save').click(function(){
		$('#standardForm').submit();	
	});
</script>
