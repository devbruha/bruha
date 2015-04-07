<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>PROFILE MANAGER</span>
            <h2>Edit Profile</h2>
            <a href="<?php echo base_url(); ?>index.php/profile/" style="position: absolute;right: 20px;top: 17px;width: 50px;" id="skip" class="yellowButton sixteen bold">SKIP</a>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
                	<li><a href="<?php echo base_url(); ?>index.php/profile/edit">Profile Information</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/profile/editSocialLinks">Social Links</a></li>
                    <li>&raquo; Deactivate Account</li>
                </ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
        		<?php if($userStatus == 1){ ?>
                    <h2 class="bold">Deactivate Your Account</h2>
                    <p>Enter Your Current Password to Deactivate Your Account</p>
                <?php }else{ ?>
                    <h2 class="bold">Activate Your Account</h2>
                    <p>Enter Your Current Password to Activate Your Account</p>
                <?php } ?>
                <?php
					if(isset($message)){
						echo '<span class="red">'.$message.'</span>';
					}
				?>
                <div class="clear-10"></div>
                <div class="formLeft">
					<?php if($userStatus == 1){ ?>
                        <form action='<?php echo base_url();?>index.php/profile/deactivateAccount' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
                            <div class="formWrap clearfix">
                                <label for="password">CURRENT PASSWORD<span class="red">*</span></label>
                                <input type="password" name="password" class="required" value="" />
                            </div>
                                                    
                             <input style="position: static; width: 298px !important;" type="submit" value="DEACTIVATE ACCOUNT" name="submit" class="yellowButton sixteen bold" />
                        </form>
                     <?php }else{ ?>
                     	<form action='<?php echo base_url();?>index.php/profile/activateAccount' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
                            <div class="formWrap clearfix">
                                <label for="password">CURRENT PASSWORD<span class="red">*</span></label>
                                <input type="password" name="password" class="required" value="" />
                            </div>
                             <input style="position: static; width: 298px !important;" type="submit" value="ACTIVATE ACCOUNT" name="submit" class="yellowButton sixteen bold" />
                        </form>
                     <?php } ?>
                </div>
        </div>
        

    </div>
</div>
