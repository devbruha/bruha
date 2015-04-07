<!DOCTYPE html>
<html>  
<head>  
<title><?php echo $page_title; ?></title>  
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/css/style.css" media="screen" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjz2vi4I-eHsr7za-_zkXtqqkZjmJRjsg&sensor=true&libraries=places"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/spider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/infoBubble.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/jquery.validate.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/skin/showdom/showdom.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/cycle.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/equalheight.js"></script>

</head>  
<body style="background:#f2f2f2"> 

<div id="headerSmall" class="adminHeader">
	<div id="headerInner">
		
        <a href="<?php echo base_url(); ?>"><img id="logo-150" src="<?php echo base_url(); ?>themes/showdom/images/logos/showdom-logo-150.png" /></a>
        <ul id="mainMenu"> 
			<li><a href="<?php echo base_url(); ?>index.php/admin">Home</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/users">Users</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/events">Events</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/ads">Ads</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/promoCodes">Promo Codes</a></li>
            <li><a href="<?php echo base_url(); ?>index.php/admin/content/1">Content</a></li>
            <li><a href="<?php echo base_url(); ?>blog/wp-admin">Blog</a></li>
        </ul>
        
    </div>
</div>