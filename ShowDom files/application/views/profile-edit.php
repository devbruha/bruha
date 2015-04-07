<?php    
        $country_list = array(
            "Canada",
            "United States"
        );		
            ?>

<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>PROFILE MANAGER</span>
            <h2>Edit Profile</h2>
            <div id="actions">
                <a id="save" class="yellowButton sixteen bold">SAVE & CONTINUE</a>
            </div>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li>&raquo; Profile Information</li>
                    <li><a href="<?php echo base_url(); ?>index.php/profile/editSocialLinks">Social Links</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/profile/disableAccount">Deactivate Account</a></li>
                </ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
				<div class="formLeft">
			<form id="standardForm" action='<?php echo base_url();?>index.php/profile/updateprofile' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
                    <div class="formWrap clearfix">
                        <label for="email">E-MAIL</label>
                        <input type="text" name="email" class="required" value="<?php echo $email; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="country">COUNTRY<span class="red">*</span></label>
                        <select name="country">
                        <?php 
                            foreach($country_list as $country){
                                echo '<option value="'.$country.'" '.(($country == $theCountry) ? "SELECTED " : "").'>'.$country.'</option>';
                            }
                        ?>
                        </select>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="state">PROVINCE / STATE<span class="red">*</span></label>
                        <div id="stateContainer">
                            <select name='state' id='state'>
        
                            </select>
                        </div>
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="city">CITY</label>
                        <input type="text" name="city" value="<?php echo $city; ?>" />
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for='gender'>Gender</label>
                        <select name="gender">
                            <option value="1" <?php if($gender == "Male"){ echo 'SELECTED'; } ?>>Male</option>
                            <option value="2" <?php if($gender == "Female"){ echo 'SELECTED'; } ?>>Female</option>
                            <option value="3" <?php if($gender == "Other"){ echo 'SELECTED'; } ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label>BIRTHDAY<span class="red">*</span></label>
                        <select name="birthMonth" class="addEventMonth">
                            <option value="">MM</option>
                            <?php 
                                for($i=1;$i<=12;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option  value="'.$num_padded.'" '.(($birthMonth == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="birthDay" class="addEventDay">
                            <option value="">DD</option>
                            <?php 
                                for($i=1;$i<=31;$i++){
                                    $num_padded = sprintf("%02s", $i);
                                    echo '<option value="'.$num_padded.'" '.(($birthDay == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                                }
                            ?>
                        </select>
                        <select name="birthYear" class="addEventyear">
                            <option value="">YYYY</option>
                            <?php 
                                for($i=1900;$i<=date('Y');$i++){
                                    echo '<option value="'.$i.'" '.(($birthYear == $i) ? "SELECTED " : "").'>'.$i.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div class="formWrap clearfix">
                        <label for="website">WEBSITE LINK</label>
                        <input type="text" name="website" value="<?php echo $website; ?>"  />
                	</div>
                    
                    <div class="formWrap clearfix">
                        <label for="eventSubCategory">PROFILE IMAGE (150px x 150px for Best Results)</label>
                        <img class="userImage" src="<?php echo base_url().''.image($imagePath, 150, 0); ?>" />
                        <input type="file" name="userfile"  />
                	</div>
                    
                </form>

                </div>
            
                <div class="formRight">       
                    <form id="passwordChangeForm" action='<?php echo base_url(); ?>index.php/profile/updatePassword' method='post' name='standardForm' class="clearfix" enctype="multipart/form-data">
                        <div class="formWrap clearfix">
                            <label>OLD PASSWORD<span class="red">*</span></label>
                            <input type="password" name="passwordOld" id="passwordOld"  />
                        </div>
                        
                        <div class="formWrap clearfix">
                            <label for="eventName">NEW PASSWORD<span class="red">*</span></label>
                            <input type="password" name="passwordNew" id="passwordNew"  />
                        </div>
                        
                        <div class="formWrap clearfix">
                            <label>CONFIRM NEW PASSWORD<span class="red">*</span></label>
                            <input type="password" name="passwordNewTwo" id="passwordNewTwo"  />
                        </div>
                        
                        <div class="formWrap clearfix">
                            <button id="changePassword" class="yellowButton sixteen bold">CHANGE PASSWORD</button>
                        </div>
                    </form>
                </div>
               
        </div>
        

    </div>
</div>



<script>
var state_list = new Array("Alabama",  
"Alaska",  
"Arizona",  
"Arkansas",  
"California",  
"Colorado",  
"Connecticut",  
"Delaware",  
"District Of Columbia",  
"Florida",  
"Georgia",  
"Hawaii",  
"Idaho",  
"Illinois",  
"Indiana",  
"Iowa",  
"Kansas",  
"Kentucky",  
"Louisiana",  
"Maine",  
"Maryland",  
"Massachusetts",  
"Michigan",  
"Minnesota",  
"Mississippi",  
"Missouri",  
"Montana",
"Nebraska",
"Nevada",
"New Hampshire",
"New Jersey",
"New Mexico",
"New York",
"North Carolina",
"North Dakota",
"Ohio",  
"Oklahoma",  
"Oregon",  
"Pennsylvania",  
"Rhode Island",  
"South Carolina",  
"South Dakota",
"Tennessee",  
"Texas",  
"Utah",  
"Vermont",  
"Virginia",  
"Washington",  
"West Virginia",  
"Wisconsin",  
"Wyoming");


var canadianProvinces = new Array( 
"British Columbia", 
"Ontario", 
"Newfoundland and Labrador", 
"Nova Scotia", 
"Prince Edward Island", 
"New Brunswick", 
"Quebec", 
"Manitoba", 
"Saskatchewan", 
"Alberta", 
"Northwest Territories", 
"Nunavut",
"Yukon Territory");

$(document).ready(function(){
	
	$("#standardForm").validate({
		validClass: "success",
		rules: {
		  email: {
			 required: true, email: true 
		  }
		} 
	});
	
	$("#passwordChangeForm").validate({
		validClass: "success",
		rules: {
		  passwordOld: { 
				required: true,
				remote: "<?php echo base_url(); ?>index.php/profile/checkOldPassword"
		  }, 
		  passwordNew: { 
				required: true,
				minlength: 8
		  },
		  passwordNewTwo: { 
				required: true,
				equalTo: "#passwordNew",
				minlength: 8
		  }
		},
		messages: {
			passwordOld: {
				remote: 'Your password is not correct'
			}
		}
	});
	
	
	
	$('#changePassword').click(function(){
		if($("#passwordChangeForm").valid()){
			var oldPass = $('input[name="passwordOld"]').val();
			var newPass = $('input[name="passwordNew"]').val();
			var newPass2 = $('input[name="passwordNewTwo"]').val();
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/profile/updatePassword",
				data: "oldPass="+oldPass+"&newPass="+newPass+"&newPass2="+newPass2,
				success: function(result){
					alert('Password has been updated');
				}
			});	
		}else{
			alert('Please enter all fields.');	
		}
		
		
		return false;	
	});
	
	   
	if("<?php echo $theCountry ?>" == "Canada"){
		$.each(canadianProvinces, function(key, value) {  
			if(value == "<?php echo $state; ?>"){
				$('#state').append($("<option SELECTED='SELECTED'></option>").attr("value",value).text(value)); 
			}else{
				$('#state').append($("<option></option>").attr("value",value).text(value)); 
			}
		});
	}else{
		$.each(state_list, function(key, value) {   
			if(value == "<?php echo $state; ?>"){
				$('#state').append($("<option SELECTED='SELECTED'></option>").attr("value",value).text(value)); 
			}else{
				$('#state').append($("<option></option>").attr("value",value).text(value)); 
			}
			 
		});
	}
	
						
	$('select[name=country]').change(function(){
		if($(this).val()=='Canada'){ 
			$('#state').html(' ');
			$.each(canadianProvinces, function(key, value) {   
			 $('#state')
				 .append($("<option></option>")
				 .attr("value",value)
				 .text(value)); 
			});
		} 
		if($(this).val()=='United States'){
			$('#state').html(' ');
			$.each(state_list, function(key, value) {   
			 $('#state')
				 .append($("<option></option>")
				 .attr("value",value)
				 .text(value)); 
			});
		}
	});
	
	$('#save').click(function(){
		$('#standardForm').submit();	
	});
});
</script>