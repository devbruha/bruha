<div id="menu">
    <div id="menuInner">
        <ul>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/">Home</a></li>

            <?php if(isLoggedIn() == true){ ?>
                <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/myProfile">My Profile & Events</a></li>
                <li><a href="http://showdom.com/index.php/mobile/logOut">Log Out</a></li>
            <?php }else{ ?>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/createAccount">Sign Up</a></li>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/userLogIn">Sign In</a></li>
            <?php } ?>
        </ul>

        <ul>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/about">About</a></li>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/termsOfService">Terms Of Service</a></li>
            <li><a class="loadingLink" href="http://showdom.com/index.php/mobile/privacyPolicy">Privacy Policy</a></li>
        </ul>
    </div>
</div>
<div id="header">
    <a class="loadingLink" href="http://showdom.com/index.php/mobile/"><img id="logoSmall" src="<?php echo base_url() ?>/themes/showdomMobile/images/showdom-logo-small.png" /></a>
    <a id="menuTrigger" href="#">Menu</a>
</div>

<script>
    $('#menuTrigger').click(function(){
        var menuHeight = $("#menu").height();
        if(menuHeight == 0){
            $("#menu").animate({height:'100%'},500);
            $('#menuTrigger').addClass('opened');
            //$("#header").animate({bottom:'0'},500);
            //$("#header").css('top','auto');
        }else{
            $("#menu").animate({height:0},500);
            $('#menuTrigger').removeClass('opened');
            //$("#header").animate({top:'0'},500);
            //$("#header").css('bottom','auto');
        }

    });
</script>