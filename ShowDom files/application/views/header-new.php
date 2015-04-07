<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="
<?php
    if($meta_description){
        echo $meta_description;
    }else{
        echo 'Upload, manage and discover shows and events in your area for various artistries: music, film/theatre, art/write, fashion, comedy and other';
    }
    ?>
">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/css/style.css" media="screen" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/skin/showdom/showdom.css" media="screen" />

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjz2vi4I-eHsr7za-_zkXtqqkZjmJRjsg&sensor=true&libraries=places"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/spider.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/infoBubble.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/jquery.validate.js"></script>

    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/cycle.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/equalheight.js"></script>

    <script type="text/javascript">
        var map;
        var oms;
        var iw;
        var allMarkers;
        var markersArray = Array();
        var markersArray2 = Array();
        var inSearch;
        var inAdvancedSearch;

        var searchString;
        var startDate;
        var endDate;
        var anyDate;
        var theLocation;
        var catString;
        var twelvehour=0;
        var featured = 0;
        var styles = [
            {
                stylers: [
                    { saturation: -100 }
                ]
            }
        ];
        var lat = "<?php echo $lat; ?>";
        var lng = "<?php echo $lng; ?>";
        var baseUrl = "<?php echo base_url(); ?>";
        <?php
            $startDate = strtotime("+0 day");
            $startDate = date('Y-m-d', $startDate);
            $endDate = strtotime("+0 day");
            $endDate = date('Y-m-d', $endDate);
        ?>
        var showTodayStart = "<?php echo $startDate; ?>";
        var showTodayEnd = "<?php echo $endDate; ?>";

        <?php
            $startDate = strtotime("+1 day");
            $startDate = date('Y-m-d', $startDate);
            $endDate = strtotime("+1 day");
            $endDate = date('Y-m-d', $endDate);
        ?>
        var showTomorrowStart = "<?php echo $startDate; ?>";
        var showTomorrowEnd = "<?php echo $endDate; ?>";

        <?php
            $startDate = strtotime("+1 day");
            $startDate = date('Y-m-d', $startDate);
            $endDate = strtotime("+7 day");
            $endDate = date('Y-m-d', $endDate);
        ?>
        var showThisWeekStart = "<?php echo $startDate; ?>";
        var showThisWeekEnd = "<?php echo $endDate; ?>";

        <?php
            $startDate = strtotime("+1 day");
            $startDate = date('Y-m-d', $startDate);
            $endDate = strtotime("+30 day");
            $endDate = date('Y-m-d', $endDate);
        ?>
        var showThisMonthStart = "<?php echo $startDate; ?>";
        var showThisMonthEnd = "<?php echo $endDate; ?>";

        <?php
            $startDate = strtotime("+1 day");
            $startDate = date('Y-m-d', $startDate);
        ?>
        var showAllStart = "<?php echo $startDate; ?>";

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-39207630-1']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/main.js"></script>
</head>
<body onload="initialize(); ">
<a href="#ageRestrictedEvent" id="ageRestrictedTrigger"></a>
<a href="#ageRestrictedFail" id="ageRestrictedFailTrigger"></a>
<div style="display: none;">
    <div id="ageRestrictedEvent" style="width:340px;height:auto;overflow:auto;">
        <div class="quickEventContainerBorderTop">
            <span>AGE RESTRICTED EVENT</span>
            <span>This is an <span class="red ageRestrictionValue">18+</span> Event</span>
            <span>Please confirm your age to continue.</span>

            <form class="standardForm clearfix" id="confirmAge">
                <div class="formWrap clearfix">
                    <select name="birthMonth" class="addEventMonth">
                        <option value="00">MM</option>
                        <?php
                        for($i=1;$i<=12;$i++){
                            $num_padded = sprintf("%02s", $i);
                            echo '<option  value="'.$num_padded.'" '.(($birthMonth == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                        }
                        ?>
                    </select>
                    <select name="birthDay" class="addEventDay">
                        <option value="00">DD</option>
                        <?php
                        for($i=1;$i<=31;$i++){
                            $num_padded = sprintf("%02s", $i);
                            echo '<option value="'.$num_padded.'" '.(($birthDay == $num_padded) ? "SELECTED " : "").'>'.$num_padded.'</option>';
                        }
                        ?>
                    </select>
                    <select name="birthYear" class="addEventyear">
                        <option value="0000">YYYY</option>
                        <?php
                        for($i=1900;$i<=date('Y');$i++){
                            echo '<option value="'.$i.'" '.(($birthYear == $i) ? "SELECTED " : "").'>'.$i.'</option>';
                        }
                        ?>
                    </select>
                    <div class="clear-10"></div>
                    <hr />
                    <input style="position:relative;top:0px;right:0px;display:block;width:100% !important;" type="submit" value="CONFIRM AGE" class="yellowButton bold" />
                    <hr />
                </div>
            </form>

        </div>
    </div>

    <div id="ageRestrictedFail" style="width:340px;height:auto;overflow:auto;">
        <div class="quickEventContainerBorderTop">
            <span>AGE RESTRICTED EVENT</span>
            <span>This is an <span class="red ageRestrictionValue">18+</span> Event</span>
            <span>You don't meet the age requirements for this event.</span>
        </div>
    </div>

</div>

<div id="headerAds">
    <div id="headerAdSliderOutter">

    </div>
</div>

<div id="header">
    <div id="headerInner">
        <a href="<?php echo base_url(); ?>"><img id="logo-150" src="<?php echo base_url(); ?>themes/showdom/images/showdom-logo.png" /></a>
        <img id="events-near-you" src="<?php echo base_url(); ?>themes/showdom/images/events-near-you.png"/>
        <?php
        if(isset($welcome)){
            echo '<span class="welcomeText">welcome<br/><span class="yellow sixteen">'.$welcome.'</span></span>';
        }
        ?>

        <ul id="mainMenu" style="border-left:none !important">
            <form id="signInForm" action='<?php echo base_url();?>index.php/login/process' method='post' name='process'>
                <li>
                    <div>
                        <label for='showdomid'>ShowDom ID</label>
                        <input type='text' name='showdomid' id='showdomid' tabindex="1" value="<?php if($rememberUsername){ echo $rememberUsername; } ?>" />
                        <input style="margin-top: 0;" type="checkbox" name="rememberMe" value="1" tabindex="3" <?php if($rememberPassword){ echo 'CHECKED'; } ?> /><label id="rememberMe">Remember Me?</label>
                    </div>

                    <div>
                        <label for='password'>Password</label>
                        <input type='password' name='password' id='password' tabindex="2" value="<?php if($rememberPassword){ echo $rememberPassword; } ?>"  />
                        <a class="yellow twelve" href="<?php echo base_url(); ?>index.php/home/forgotPassword">Forgot Your Password??</a>
                    </div>
                </li>
                <li>
                    <input type='Submit' value='SIGN IN' tabindex="4" />
                </li>
            </form>
            <?php
            if(isset($menu_item)){
                $counter = 0;
                foreach($menu_item as $item){
                    echo '<li '.((base_url().''.$menu_url[$counter] == 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'') ? "class='active' " : "") .'><a href="'.base_url().''.$menu_url[$counter].'">'.$item.'</a></li>';
                    $counter ++;
                }
            }
            ?>
        </ul>
        <a class="yellowButton" id="signUpTrigger">SIGN UP</a>

        <a id="createAnEvent" href="">Create Event</a>

        <div id="showingEventsFor">
            <a id="showToday" href="" class="active">Today</a>
            <a id="showTomorrow" href="">Tomorrow</a>
            <a id="showThisWeek" href="">This Week</a>
            <a id="showThisMonth" href="">This Month</a>
            <a id="showAll" href="">All</a>
        </div>

        <a id="clearSearchResults" href="" style="display: none" class="active">Clear Search</a>


    </div>

</div>
