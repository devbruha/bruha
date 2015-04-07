<div id="popup">
    <div id="popupInner" class="clearfix">
        <div id="popupInnerFull" class="cmsPage">
            <h2>FORGOT PASSWORD</h2>
            <?php
            if(isset($message)){
                echo '<p style="color:red">'.$message.'<br/><br/><br/></p>';
            }
            ?>
            <form id="standardForm" action='<?php echo base_url();?>index.php/mobile/forgotPasswordSubmit' method='post' name='standardForm' class="clearfix" enctype="multipart/form-data">
                    <div class="formWrap clearfix">
                        <label for="eventName">SHOWDOM ID or EMAIL</label>
                        <input type="text" name="userEmail" class="required" />
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Reset Password" class="yellowButton" />
                    </div>

            </form>

        </div>
    </div>
</div>