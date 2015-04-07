<div id="signIn">
    <div id="signInInner" class="clearfix">
    	<div id="signInLeft">
    		<img src="http://localhost/showdom/themes/showdom/images/logos/showdom-logo-300.png" />
            <h1>FULL SITE COMING SOON!</h1>
            <p>Get a head start by reserving your</p>
            <p>ShowDom ID and adding your events now!</p>
            <p>ShowDom is your social hub for local and global entertainment. Discover events in Music, Film & Theatre, Art & Writing, Comedy, and Fashion. Save your favourites or create your own!</p>
    	</div>
        <div id="signInRight">
            <h2>SIGN IN OR SIGN UP!</h2>
            <form id="signInForm" action='<?php echo base_url();?>index.php/login/process' method='post' name='process'>
                <label for='showdomid'>ShowDom ID</label>
                <input type='text' name='showdomid' id='showdomid' />
            
                <label for='password'>Password</label>
                <input type='password' name='password' id='password' />                           
            
                <input style="margin-top: 10px;" class="yellowButton thirty" type='Submit' value='SIGN IN' />            
            </form>
            <h2>Not a Member?</h2>
            <p>Reserve your ShowDom ID Today</p>
            <a class="yellowButton thirty" href="http://localhost/showdom/index.php/signup">SIGN UP TODAY!</a>
        </div>
    </div>
</div>