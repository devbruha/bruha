<div id="signUp" style="display: none">
    <div id="signUpInner" class="clearfix">
        <div class="leftCol">
          
            <h1>SIGN UP FOR FREE</h1>
            <p>and Get Your Official ShowDom ID</p>
    
       <?php    
        $country_list = array(
            "Canada",
            "United States"
        );		
            ?>
            
            <hr />
            <form id="signUpForm" action='<?php echo base_url();?>index.php/login/signup' method='post' name='signup' class="clearfix">
                <div class="formWrap clearfix">
                    <label for='showdomid'>ShowDom ID</label>
                    <input type='text' name='showdomid' id='showdomid' class="required" />
                </div>
                
                <div class="formWrap clearfix">
                    <label for='accountType'>Account Type</label>
                    <select name="accountType">
                        <option value="4">Patron</option>
                        <option value="1">Artist</option>
                        <option value="2">Promoter</option>
                        <option value="3">Venue</option>
                    </select>
                </div>
                
                <div class="formWrap clearfix">
                    <label for='password'>Password</label>
                    <input type='password' name='password' id='signUppassword' class="required" />                           
                </div>
                
                <div class="formWrap clearfix">
                    <label for='password2'>Confirm Password</label>
                    <input type='password' name='password2' id='password2' class="required" />                           
                </div>
                
                <div class="formWrap clearfix">
                    <label for='email'>E-Mail</label>
                    <input type='text' name='email' id='email' class="required" />
                </div>
                
                <div class="formWrap clearfix">
                    <label for='email2'>Confirm E-Mail</label>
                    <input type='text' name='email2' id='email2' class="required" />
                </div>
                
                <div class="formWrap clearfix">
                    <label for='country'>Country</label>
                    <select name="country">
                    <?php 
                        foreach($country_list as $country){
                            echo '<option value="'.$country.'">'.$country.'</option>';
                        }
                    ?>
                    </select>
                </div>
                
                <div class="formWrap clearfix">
                    <label for='state'>Province / State</label>
                    <div id="stateContainer">
                        <select name='state' id='state'>
                            <option value="Ontario">Ontario</option>
                            <option value="Quebec">Quebec</option>
                            <option value="British Columbia">British Columbia</option>
                            <option value="Alberta">Alberta</option>
                            <option value="Manitoba">Manitoba</option>
                            <option value="Saskatchewan">Saskatchewan</option>
                            <option value="Nova Scotia">Nova Scotia</option>
                            <option value="New Brunswick">New Brunswick</option>
                            <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                            <option value="Prince Edward Island">Prince Edward Island</option>
                            <option value="Northwest Territories">Northwest Territories</option>
                            <option value="Yukon">Yukon</option>
                            <option value="Nunavut">Nunavut</option>

                            <option value="Alabama">Alabama</option>
                            <option value="Alaska">Alaska</option>
                            <option value="Arizona">Arizona</option>
                            <option value="Arkansas">Arkansas</option>
                            <option value="California">California</option>
                            <option value="Colorado">Colorado</option>
                            <option value="Connecticut">Connecticut</option>
                            <option value="Delaware">Delaware</option>
                            <option value="Florida">Florida</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Hawaii">Hawaii</option>
                            <option value="Idaho">Idaho</option>
                            <option value="Illinois">Illinois</option>
                            <option value="Indiana">Indiana</option>
                            <option value="Iowa">Iowa</option>
                            <option value="Kansas">Kansas</option>
                            <option value="Kentucky">Kentucky</option>
                            <option value="Louisiana">Louisiana</option>
                            <option value="Maine">Maine</option>
                            <option value="Maryland">Maryland</option>
                            <option value="Massachusetts">Massachusetts</option>
                            <option value="Michigan">Michigan</option>
                            <option value="Minnesota">Minnesota</option>
                            <option value="Mississippi">Mississippi</option>
                            <option value="Missouri">Missouri</option>
                            <option value="Montana">Montana</option>
                            <option value="Nebraska">Nebraska</option>
                            <option value="Nevada">Nevada</option>
                            <option value="New Hampshire">New Hampshire</option>
                            <option value="New Jersey">New Jersey</option>
                            <option value="New Mexico">New Mexico</option>
                            <option value="New York">New York</option>
                            <option value="North Carolina">North Carolina</option>
                            <option value="North Dakota">North Dakota</option>
                            <option value="Ohio">Ohio</option>
                            <option value="Oklahoma">Oklahoma</option>
                            <option value="Oregon">Oregon</option>
                            <option value="Pennsylvania">Pennsylvania</option>
                            <option value="Rhode Island">Rhode Island</option>
                            <option value="South Carolina">South Carolina</option>
                            <option value="South Dakota">South Dakota</option>
                            <option value="Tennessee">Tennessee</option>
                            <option value="Texas">Texas</option>
                            <option value="Utah">Utah</option>
                            <option value="Vermont">Vermont</option>
                            <option value="Virginia">Virginia</option>
                            <option value="Washington">Washington</option>
                            <option value="West Virginia">West Virginia</option>
                            <option value="Wisconsin">Wisconsin</option>
                            <option value="Wyoming">Wyoming</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="formWrap clearfix">
                    <label for='city'>City</label>
                    <input type='text' name='city' id='city' class="required" />
                </div>
                
                <div class="formWrap clearfix">
                    <label for='gender'>Gender</label>
                    <select name="gender">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                
                <div class="formWrap clearfix">
                    <label>Birthday</label>
                    <select name="birthdayMonth" id="signUpMonth" class="required">
                        <option value="">MM</option>
                        <?php 
                            for($i=1;$i<=12;$i++){
                                $num_padded = sprintf("%02s", $i);
                                echo '<option value="'.$num_padded.'">'.$num_padded.'</option>';
                            }
                        ?>
                    </select>
                    <select name="birthdayDay" id="signUpDay" class="required">
                        <option value="">DD</option>
                        <?php 
                            for($i=1;$i<=31;$i++){
                                $num_padded = sprintf("%02s", $i);
                                echo '<option value="'.$num_padded.'">'.$num_padded.'</option>';
                            }
                        ?>
                    </select>
                    <select name="birthdayYear" id="signUpYear" class="required">
                        <option value="">YYYY</option>
                        <?php 
                            for($i=1900;$i<=date('Y');$i++){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <hr />
                <input id="completeSignUp" style="margin-top: 10px; padding:5px 0" class="yellowButton" type='Submit' value='COMPLETE SIGN UP' />            
            </form>
			<script>
                
            </script>
        </div>
        
        <div class="rightCol">
            <img class="featuredImage" src="<?php echo base_url(); ?>themes/showdom/images/ShowDom_SignUpGraphic_01.jpg" />
            
            <p>
            ShowDom is your social hub for local and global entertainment. Discover events in Music, Film & Theatre, Art & Writing, Comedy, and Fashion. Save your favourites or create your own!
			<strong>Sign Up Today!</strong>
            </p>
			
            <div id="notRightNow">
                <a class="yellowButton" href="#">Not Right Now, Thanks</a>
			</div>
        </div>
        
    </div>
</div>


<script>
$(document).ready(function() {
    $("#signUpForm").validate({
        validClass: "success",
        rules: {
            password2: {
                equalTo: '#signUppassword'
            },
            email2: {
                equalTo: '#email'
            },
            showdomid: {
                remote: "<?php echo base_url(); ?>index.php/login/checkShowdomId"
            },
            email: {
                remote: "<?php echo base_url(); ?>index.php/login/checkEmailAddress"
            }
        },
        messages: {
            showdomid: {
                remote: 'This showdom ID has already been taken.'
            },
            email: {
                remote: 'Your email address has already been used on Showdom.'
            }
        }
    });
});
</script>