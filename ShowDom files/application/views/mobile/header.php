<!DOCTYPE html>
<html>
<head>
    <title>Showdom Mobile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdomMobile/style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" media="screen" />

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/skin/showdom/showdom.css" media="screen" />

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.13&key=AIzaSyAjz2vi4I-eHsr7za-_zkXtqqkZjmJRjsg&sensor=true&libraries=places"></script>
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

    <script>
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

</head>

<body class="<?php if(isset($bodyClass)){ echo $bodyClass; } ?>" onload="initialize(); ">

<script>
    $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
    $(window).load(function() {
        $('.loadingGif').remove();
    });
    $(document).ready(function() {
        $("a.loadingLink").click(function(){
            if($(this).attr('href') != undefined) {
                $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
            }
        });
        $('#eventUpdatesDropDown').change(function(){
            $('body').append('<img class="loadingGif" src="<?php echo base_url(); ?>/themes/showdomMobile/images/ajax-loader.gif" />');
        });
    });
</script>