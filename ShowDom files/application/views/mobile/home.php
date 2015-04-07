<div class="wrap" id="logIn">
    <div class="center">
        <img id="mobileLogo" src="<?php echo base_url(); ?>themes/showdomMobile/images/showdom-logo.png" />
    </div>

    <div>
        <form id="signInForm" method="post" action="<?php echo base_url() ?>index.php/mobile/login">
            <div>
                <label>ShowDom ID</label>
                <input type="text" name="showdomid" value="<?php if($rememberUsername){ echo $rememberUsername; } ?>" />
            </div>
            <div>
                <input type="checkbox" name="rememberMe" value="1" <?php if($rememberPassword){ echo 'CHECKED'; } ?> />
                <label>Remember Me?</label>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php if($rememberPassword){ echo $rememberPassword; } ?>" />
            </div>
            <div>
                <a href="http://showdom.com/index.php/mobile/forgotPassword">Forgot Your Password?</a>
            </div>
            <div>
                <input class="yellowButton" type="submit" name="submit" value="SIGN IN" />
            </div>
            <div>
                <a data-transition="flip" class="yellowButton loadingLink" href="<?php echo base_url() ?>index.php/mobile/createAccount">CREATE ACCOUNT</a>
            </div>
        </form>

        <div class="clear"></div>

        <a id="noThanks" class="yellowButton small loadingLink" href="<?php echo base_url() ?>index.php/mobile/homeMap">Not Right Now</a>

    </div>

</div>

