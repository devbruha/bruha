<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="popup">
<div id="popupInner" class="equalHeightOutter clearfix">
<div id="popupInnerLeft">
<a href="<?php echo base_url(); ?>index.php/profile/view/<?php echo $showdomId; ?>/"><img class="userImage" src="<?php echo base_url().''.image($imagePath, 150, 0); ?>"  /></a>
<h3 class="showdomId"><a href="<?php echo base_url(); ?>index.php/profile/view/<?php echo $showdomId; ?>/"><?php echo $showdomId; ?></a></h3>
<hr/>
<span>Account Type</span>
<?php echo $accountType; ?>
<hr />
<span>location</span>
<?php echo $location; ?>
<hr />
<span>Gender</span>
<?php echo $gender; ?>
<hr />
<span>Age</span>
<?php echo $age; ?>
<hr />
<span>Website</span>
<a href="<?php echo $website; ?>" target="_blank">Visit Website</a>
<hr />
<span>Social Links</span>
<div class="socialLinks">
<?php
if($googlePlusLink != ''){
    echo '<a href="'.$googlePlusLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/google-plus.png" />';
    echo 'Google Plus';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($facebookLink != ''){
    echo '<a href="'.$facebookLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/facebook.png" />';
    echo 'Facebook';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($twitterLink != ''){
    echo '<a href="'.$twitterLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/twitter.png" />';
    echo 'Twitter';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($linkedInLink != ''){
    echo '<a href="'.$linkedInLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/linkedin.png" />';
    echo 'LinkedIn';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($myspaceLink != ''){
    echo '<a href="'.$myspaceLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/myspace.png" />';
    echo 'MySpace';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($youtubeLink != ''){
    echo '<a href="'.$youtubeLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/youtube.png" />';
    echo 'YouTube';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($vimeoLink != ''){
    echo '<a href="'.$vimeoLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/vimeo.png" />';
    echo 'Vimeo';
    echo '</a>';
    echo '<hr/>';
}
?>

<?php
if($flickrLink != ''){
    echo '<a href="'.$flickrLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/flickr.png" />';
    echo 'Flickr';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($behanceLink != ''){
    echo '<a href="'.$behanceLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/behance.png" />';
    echo 'Behance';
    echo '</a>';
    echo '<hr/>';
}

?>

<?php
if($deviantArtLink != ''){
    echo '<a href="'.$deviantArtLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/deviantArt.png" />';
    echo 'DeviantArt';
    echo '</a>';
    echo '<hr/>';
}
?>
<?php
if($pinterestLink != ''){
    echo '<a href="'.$pinterestLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/pinterest.png" />';
    echo 'Pinterest';
    echo '</a>';
    echo '<hr/>';
}
?>

<?php
if($lastfmLink != ''){
    echo '<a href="'.$lastfmLink.'" target="_blank">';
    echo '<img src="'.base_url().'themes/showdom/images/icons/lastFm.png" />';
    echo 'Last.fm';
    echo '</a>';
    echo '<hr/>';
}

?>
</div>

</div>
<div id="popupInnerRight" class="viewEvent">

<?php
$eventDateData = getNextEventDate($eventData->event_id);

echo '<h2 class="eventTitle eventTitleCat'.$eventData->event_cat.'">'.$eventData->event_title.'</h2>';

echo '<div class="googleMapsInfoWindowInner clearfix nomargin">';

echo '<div class="eventLeftLarge">';

if($eventDateData[0] < date('Y-m-d')){
    $eventDateData[0] = date('Y-m-d');
}

echo '<div class="eventDate eventDateTall">';

echo convertDate($eventDateData[0]);

echo '</div>';

//echo '<img class="eventImage" src="http://localhost/showdom/themes/showdom/images/eventImage.png" />';

echo '<img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$eventData->event_id."/".$eventData->event_image."", 200, 200).'" />';

echo '</div>';



echo '<div class="eventContentSmall">';

//echo '<p><small><em class="lightGrey">Attending:</em></small> <span>'.$eventFavourites.'</span></p>';

//echo '<p><small><em class="lightGrey">Event Views:</em></small> <span>'.$eventViews->total.'</span></p>';

if($eventData->event_sub_cat == 666666){

    $eventSubCat = getEventOtherCategory($eventData->event_id);

}else{

    $eventSubCat = $eventData->sub_cat_name;

}

echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$eventData->event_cat.'"><strong>'.$eventData->cat_name.'</strong></span> - '.$eventSubCat.'</p>';

echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$eventData->event_location.'</span></p>';

echo '<p><small><em class="lightGrey">Venue:</em></small> <span>' . $eventData->venue_name . '</span></p>';

echo '<p><small><em class="lightGrey">Admission:</em></small> <span>' . $eventData->admission_price . '</span></p>';


echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';

//if($eventData->event_timezone != ''){
    //echo '<p><small><em class="lightGrey">Tome Zone:</em></small> <span>'.$eventData->event_timezone.'</span></p>';
//}

//echo '<p><small><em class="lightGrey">End Date:</em></small> <span>'.convertSimpleDate($eventData->event_end_date).'</span></p>';





echo '</div>';

echo '</div>';



echo '<div class="blackBox clearfix">';

echo '<h2>EVENT DESCRIPTION</h2>';

echo '<pre>'.$eventData->event_description.'</pre>';

echo '<div id="eventButtons">';

if($eventData->event_website != ''){
    echo '<a target="_blank" href="'.$eventData->event_website.'" class="yellowButton bold sixteen">VIEW WEBSITE</a>';
}

if($eventData->event_tickets != ''){
    echo '<a style="margin-left:10px;" target="_blank" href="'.$eventData->event_tickets.'" class="yellowButton bold sixteen">GET TICKETS</a>';
}

if($eventData->event_claim != 0){
    echo '<a style="margin-left:10px;" target="_blank" href="'.base_url().'index.php/events/claim/'.$eventData->event_id.'" class="yellowButton bold sixteen">CLAIM EVENT</a>';
}

if($theUserId){
    echo '<a onclick="return confirm(\'Are you sure?\');" href="'.base_url().'index.php/events/reportEvent/'.$eventData->event_id.'" class="redButton redButton bold sixteen">REPORT EVENT</a>';
}

/*
if(isset($isFav)){

    if($isFav != 0){

        //echo '<a id="unfavouriteEvent" onclick="return unfavouriteEvent(this,'.$eventData->event_id.')" class="eventFavourite yellowButton sixteen bold greenButton">ATTENDING</a>';

        //echo '<a id="favouriteEvent" style="display:none;" onclick="return favouriteEvent(this,'.$eventData->event_id.')" class="eventFavourite yellowButton sixteen bold redButton">ATTENDING</a>';

    }else{

        //echo '<a id="unfavouriteEvent" style="display:none;" onclick="return unfavouriteEvent(this,'.$eventData->event_id.')" class="eventFavourite yellowButton sixteen bold greenButton">ATTENDING</a>';

        //echo '<a id="favouriteEvent" onclick="return favouriteEvent(this,'.$eventData->event_id.')" class="eventFavourite yellowButton sixteen bold">ATTENDING</a>';

    }

}
*/
echo '</div>';

echo '</div>';



echo '<div class="googleMapsInfoWindowInner clearfix">';

echo '<h2>EVENT DATES</h2>';



if(count($eventDates) != 0){

echo '<table id="eventDatesTable">';
    foreach($eventDates as $date){
        echo '<tr>';
            echo '<td>';
                echo '<div class="date">';
                    echo '<span class="dateDay">'.date('M',strtotime($date->start_date_time_start_date)).' '.date('j',strtotime($date->start_date_time_start_date)).'</span>';
                    echo '<span class="dateYear">'.date('Y',strtotime($date->start_date_time_start_date)).'</span>';
                echo '</div>';
            echo '</td>';

            if($date->start_date_time_start_date != $date->start_date_time_end_date){
                echo '<td>';
                    echo '<span class="eventFromTo">To</span>';
                echo '</td>';

                echo '<td>';
                    echo '<div class="date">';
                        echo '<span class="dateDay">'.date('M',strtotime($date->start_date_time_end_date)).' '.date('j',strtotime($date->start_date_time_end_date)).'</span>';
                        echo '<span class="dateYear">'.date('Y',strtotime($date->start_date_time_end_date)).'</span>';
                    echo '</div>';
                echo '</td>';
            }

            echo '<td>';
                echo '<div class="dateTime">';
                    echo '<span>'.convertTime($date->start_date_time_start_time).' - </span>';
                    echo '<span>'.convertTime($date->start_date_time_end_time).'</span>';
                echo '</div>';
            echo '</td>';

        echo '</tr>';
        /*
        echo '<div class="eventDates clearfix">';
            echo '<p><small><em class="lightGrey">Start Date:</em></small> <span>'.convertDate($date->start_date_time_start_date).'</span></p>';
            echo '<p><small><em class="lightGrey">End Date:</em></small> <span>'.convertDate($date->start_date_time_end_date).'</span></p>';
            echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($date->start_date_time_start_time).' to '.convertTime($date->start_date_time_end_time).'</span></p>';
        echo '</div>';
        */
    }



echo '</table>';

}else{
    echo 'This event has no dates!';
}

echo '</div>';



$numVids = count($video);
if($numVids != 0){
    echo '<div class="equalHeightOutter clearfix">';
    echo '<div class="googleMapsInfoWindowInner clearfix">';
    echo '<h2>Video Player</h2>';

    if($numVids!=0){

        echo '<div class="mediaControls">';

        echo '<span id="currentVideo">Video</span>';

        echo '<a id="prevVideo" class="mediaPrev">Prev</a>';

        echo '<a id="nextVideo" class="mediaNext">Next</a>';

        echo '</div>';



        echo '<div id="videoCycle">';

        $counter = 1;

    foreach($video as $vid){

        echo '<div>';

    if($vid->video_file != ''){

        $counter ++;

        echo '<div class="jp-title">

									  <ul>

										<li>'.$vid->video_title.'</li>

									  </ul>

									</div>';



        echo '<div id="jp_container_video_'.$counter.'" class="jp-video jp-video-400">

									<div class="jp-type-single">

										<div class="jp-video-play">

										  <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>

										</div>



									  <div id="jquery_jplayer_video_'.$counter.'" class="jp-jplayer"></div>

									  <div class="jp-gui">



										<div class="jp-interface">

											<ul class="jp-controls">

												<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>

												<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>

												<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>

											</ul>

											<ul class="jp-toggles">

												<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>

												<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>

											</ul>

											<div class="jp-progress">

												<div class="jp-seek-bar">

													<div class="jp-play-bar"></div>

												</div>

											</div>



											<div class="jp-volume-bar">

												<a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>

												<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>

												<div class="jp-volume-bar-value"></div>

												<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a>

											</div>



											<div class="jp-current-time"></div>

											<div class="jp-duration"></div>

										</div>



									  </div>

									  <div class="jp-no-solution">

										<span>There was an issue</span>

										<p>It appears we do not support this file format.</p>

									  </div>

									</div>

								  </div>



									<div class="clear-10"></div>';

        ?>

        <script>

            $("#jquery_jplayer_video_<?php echo $counter; ?>").jPlayer({

                ready: function () {

                    $(this).jPlayer("setMedia", {

                        "<?php echo substr($vid->video_file_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/video/events/<?php echo $eventData->event_id; ?>/<?php echo $vid->video_file; ?>"

                    });

                },

                swfPath: "<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/Jplayer.swf",

                supplied: "<?php if(substr($vid->video_file_ext,1) == 'mp4'){ echo 'M4V'; } else{ echo substr($vid->video_file_ext,1); } ?>",

                cssSelectorAncestor: "#jp_container_video_<?php echo $counter; ?>"

            });

        </script>

    <?php

    }elseif($vid->video_file_ext == 'youtube'){

        ?>

        <div class="jp-title"><?php echo $vid->video_title; ?></div>

        <iframe style="z-index:0" width="565" height="320" src="http://www.youtube.com/embed/<?php echo $vid->video_youtube; ?>?autoplay=0&wmode=opaque" frameborder="0" allowTransparency="true"></iframe>

    <?php }else{ ?>

        <div class="jp-title"><?php echo $vid->video_title; ?></div>

        <iframe src="http://player.vimeo.com/video/<?php echo $vid->video_youtube; ?>" width="565" height="320" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

    <?php }

        echo '</div>';



    }





        echo '</div>';

        ?>

        <script>

            $("#videoCycle").cycle({

                fx: "fade",

                timeout: 0,

                prev:   "#prevVideo",

                next:   "#nextVideo",

                after: function(curr, next, opts) {

                    $("#currentVideo").html("Video " + (opts.currSlide + 1) + " of " + opts.slideCount);

                }

            });

        </script>

    <?php

    }else{

        echo '<p>'.$showdomId.' has not added any videos to this event yet</p>';

    }

    echo '</div>';
    /*
    echo '<div class="infoWindowInnerRight infoWindowInnerRightVideo">';

    echo '<h3>MORE ON</h3>';
    if($googlePlusMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$googlePlusMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/google-plus.png" />';
        echo 'Google Plus';
        echo '</a>';
    }

    if($facebookMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$facebookMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/facebook.png" />';
        echo 'Facebook';
        echo '</a>';
    }

    if($twitterMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$twitterMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/twitter.png" />';
        echo 'Twitter';
        echo '</a>';
    }

    if($linkedInMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$linkedInMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/linkedin.png" />';
        echo 'LinkedIn';
        echo '</a>';
    }

    if($youtubeMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$youtubeMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/youtube.png" />';
        echo 'YouTube';
        echo '</a>';

    }

    if($myspaceMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$myspaceMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/myspace.png" />';
        echo 'MySpace';
        echo '</a>';
    }

    if($vimeoMoreVideosLink != ''){

        echo '<a class="socialIcon" href="'.$vimeoMoreVideosLink.'" target="_blank">';

        echo '<img src="'.base_url().'themes/showdom/images/icons/vimeo.png" />';

        echo 'Vimeo';

        echo '</a>';

    }

    if($flickrMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$flickrMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/flickr.png" />';
        echo 'Flickr';
        echo '</a>';
    }

    if($behanceMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$behanceMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/behance.png" />';
        echo 'Behance';
        echo '</a>';
    }

    if($deviantArtMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$deviantArtMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/deviantArt.png" />';
        echo 'DeviantArt';
        echo '</a>';
    }

    if($pinterestMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$pinterestMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/pinterest.png" />';
        echo 'Pinterest';
        echo '</a>';
    }

    if($lastfmMoreVideosLink != ''){
        echo '<a class="socialIcon" href="'.$lastfmMoreVideosLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/lastFm.png" />';
        echo 'Last.Fm';
        echo '</a>';
    }

    echo '</div>';
    */
    echo '</div>';



    echo '<div class="clear"></div>';
}




$numAudio = count($audio);

if($numAudio != 0){
    echo '<div class="equalHeightOutter clearfix">';

    echo '<div class="googleMapsInfoWindowInner clearfix">';

    echo '<h2>Audio Player</h2>';





    if($numAudio != 0){



        echo '<div class="mediaControls">';

        echo '<span id="currentAudio">Video</span>';

        echo '<a id="prevAudio" class="mediaPrev">Prev</a>';

        echo '<a id="nextAudio" class="mediaNext">Next</a>';

        echo '</div>';



        echo '<div id="audioCycle">';

        $counter = 0;

    foreach($audio as $aud){

        echo '<div>';

    if($aud->audio_file != ''){



        $counter ++;

        echo '<div id="jquery_jplayer_'.$counter.'" class="jp-jplayer"></div>

							<div id="jp_container_'.$counter.'" class="jp-audio">

								<div class="jp-type-single">

									<div class="jp-title">

										<ul>

										  <li>'.$aud->audio_caption.'</li>

										</ul>

									</div>



									<div class="jp-gui jp-interface">

										<ul class="jp-controls">

											<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>

											<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>

											<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>

										</ul>

										<ul class="jp-toggles">

											<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>

											<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>

										</ul>



										<div class="jp-progress">

											<div class="jp-seek-bar">

												<div class="jp-play-bar"></div>

											</div>

										</div>



										<div class="jp-volume-bar">

											<a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>

											<a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>

											<div class="jp-volume-bar-value"></div>

											<a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a>

										</div>



										<div class="jp-current-time"></div>

										<div class="jp-duration"></div>

									</div>



									<div class="jp-no-solution">

										<span>Update Required</span>

										To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.

									</div>

								</div>



								<div class="clear-10"></div>

							</div>';

        ?>

        <script>

            $("#jquery_jplayer_<?php echo $counter; ?>").jPlayer({

                ready: function () {

                    $(this).jPlayer("setMedia", {

                        "<?php echo substr($aud->audio_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/audio/events/<?php echo $eventData->event_id; ?>/<?php echo $aud->audio_file; ?>"

                    });

                },

                play: function() { // To avoid both jPlayers playing together.

                    $(this).jPlayer("pauseOthers");

                },

                repeat: function(event) { // Override the default jPlayer repeat event handler

                    if(event.jPlayer.options.loop) {

                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");

                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {

                            $(this).jPlayer("play");

                        });

                    } else {

                        $(this).unbind(".jPlayerRepeat").unbind(".jPlayerNext");

                        $(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerNext", function() {

                            $("#jquery_jplayer_<?php echo $counter; ?>").jPlayer("play", 0);

                        });

                    }

                },

                swfPath: "<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/Jplayer.swf",

                supplied: "<?php echo substr($aud->audio_ext,1); ?>",

                cssSelectorAncestor: "#jp_container_<?php echo $counter; ?>"

            });

        </script>



    <?php

    }elseif($aud->audio_ext == 'youtube'){

        echo '<div class="jp-title">'.$aud->audio_caption.'</div>';

        echo '<iframe style="z-index:0" width="565" height="24" src="http://www.youtube.com/embed/'.$aud->audio_url.'?rel=0&autohide=0&modestbranding=1" frameborder="0" allowTransparency="true"></iframe>';

    }else{

        echo '<div class="jp-title">'.$aud->audio_caption.'</div>';

        echo '<iframe src="http://player.vimeo.com/video/'.$aud->audio_url.'" width="565" height="55" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

    }

        echo '</div>';

    }

        echo '</div>';

        ?>

        <script>

            $("#audioCycle").cycle({

                fx: "fade",

                timeout: 0,

                prev:   "#prevAudio",

                next:   "#nextAudio",

                after: function(curr, next, opts) {

                    $("#currentAudio").html("Clip " + (opts.currSlide + 1) + " of " + opts.slideCount);

                }

            });

        </script>

    <?php

    }else{

        echo '<p>'.$showdomId.' has not added any audio clips to this event yet</p>';

    }

    echo '</div>';
    /*
    echo '<div class="infoWindowInnerRight infoWindowInnerRightAudio">';

    echo '<h3>MORE ON</h3>';

    if($googlePlusMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$googlePlusMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/google-plus.png" />';
        echo 'Google Plus';
        echo '</a>';
    }

    if($facebookMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$facebookMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/facebook.png" />';
        echo 'Facebook';
        echo '</a>';
    }

    if($twitterMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$twitterMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/twitter.png" />';
        echo 'Twitter';
        echo '</a>';
    }

    if($linkedInMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$linkedInMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/linkedin.png" />';
        echo 'LinkedIn';
        echo '</a>';
    }

    if($youtubeMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$youtubeMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/youtube.png" />';
        echo 'YouTube';
        echo '</a>';
    }

    if($myspaceMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$myspaceMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/myspace.png" />';
        echo 'MySpace';
        echo '</a>';
    }

    if($vimeoMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$vimeoMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/vimeo.png" />';
        echo 'Vimeo';
        echo '</a>';
    }

    if($flickrMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$flickrMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/flickr.png" />';
        echo 'Flickr';
        echo '</a>';
    }

    if($behanceMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$behanceMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/behance.png" />';
        echo 'Behance';
        echo '</a>';
    }

    if($deviantArtMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$deviantArtMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/deviantArt.png" />';
        echo 'DeviantArt';
        echo '</a>';
    }

    if($pinterestMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$pinterestMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/pinterest.png" />';
        echo 'Pinterest';
        echo '</a>';
    }

    if($lastfmMoreAudioLink != ''){
        echo '<a class="socialIcon" href="'.$lastfmMoreAudioLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/lastFm.png" />';
        echo 'Last.Fm';
        echo '</a>';
    }

    echo '</div>';
    */
    echo '</div>';



    echo '<div class="clear"></div>';
}



$numPhotos = count($photos);

if($numPhotos != 0){
    echo '<div class="equalHeightOutter clearfix">';

    echo '<div class="googleMapsInfoWindowInner clearfix">';

    echo '<h2>Photos & Images</h2>';

    echo '<div class="infoWindowInnerLeft">';



    $imageCounter = 0;

    $imageLeftCounter = 0;

    if($numPhotos != 0){

        foreach($photos as $photo){

            $imageCounter ++;

            if($imageCounter <=7){

                echo '<a title="'.$photo->photo_caption.'" rel="view_photo_group" class="enlargePhoto" href="'.base_url().'themes/showdom/images/events/'.$eventData->event_id.'/gallery/'.$photo->photo_file.'">

										<img alt="'.$photo->photo_caption.'" src="'.base_url().''.image("themes/showdom/images/events/".$eventData->event_id."/gallery/".$photo->photo_thumb, 100, 80).'" />

									</a>';

            }else{

                $imageLeftCounter ++;

                echo '<a title="'.$photo->photo_caption.'" style="display:none" rel="view_photo_group" class="enlargePhoto" href="'.base_url().'themes/showdom/images/events/'.$eventData->event_id.'/gallery/'.$photo->photo_file.'">

										<img alt="'.$photo->photo_caption.'" src="'.base_url().''.image("themes/showdom/images/events/".$eventData->event_id."/gallery/".$photo->photo_thumb, 100, 80).'" />

									</a>';

            }

        }

        echo '<div class="imagesLeft">+'.$imageLeftCounter.'</div>';

    }else{

        echo '<p>'.$showdomId.' has not added any photos to this event yet</p>';

    }

    echo '</div>';

    echo '</div>';


    /*
    echo '<div class="infoWindowInnerRight infoWindowInnerRightImages">';

    echo '<h3>MORE ON</h3>';

    if($googlePlusMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$googlePlusMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/google-plus.png" />';
        echo 'Google Plus';
        echo '</a>';
    }

    if($facebookMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$facebookMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/facebook.png" />';
        echo 'Facebook';
        echo '</a>';
    }

    if($twitterMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$twitterMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/twitter.png" />';
        echo 'Twitter';
        echo '</a>';
    }

    if($linkedInMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$linkedInMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/linkedin.png" />';
        echo 'LinkedIn';
        echo '</a>';
    }

    if($youtubeMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$youtubeMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/youtube.png" />';
        echo 'YouTube';
        echo '</a>';
    }

    if($myspaceMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$myspaceMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/myspace.png" />';
        echo 'MySpace';
        echo '</a>';
    }

    if($vimeoMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$vimeoMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/vimeo.png" />';
        echo 'Vimeo';
        echo '</a>';
    }

    if($flickrMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$flickrMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/flickr.png" />';
        echo 'Flickr';
        echo '</a>';
    }

    if($behanceMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$behanceMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/behance.png" />';
        echo 'Behance';
        echo '</a>';
    }

    if($deviantArtMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$deviantArtMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/deviantArt.png" />';
        echo 'DeviantArt';
        echo '</a>';
    }

    if($pinterestMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$pinterestMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/pinterest.png" />';
        echo 'Pinterest';
        echo '</a>';
    }

    if($lastfmMoreImagesLink != ''){
        echo '<a class="socialIcon" href="'.$lastfmMoreImagesLink.'" target="_blank">';
        echo '<img src="'.base_url().'themes/showdom/images/icons/lastFm.png" />';
        echo 'Last.Fm';
        echo '</a>';
    }



    echo '</div>';
    */
    echo '</div>';
}


echo '<div class="googleMapsInfoWindowInner clearfix">';

echo '<h2>EVENT KEYWORDS</h2>';
if(count($keywords) != 0){
    foreach($keywords as $keyword){
        $keywords = ', '.$keyword->keyword_value;
    }
    echo substr($keywords, 2);
}
echo '</div>';


?>






<!--
<div id="eventUpdates" class="nomargin">

    <h2>EVENT UPDATES <a href="<?php //echo base_url(); ?>index.php/events/allEventUpdates/<?php //echo $eventData->event_id; ?>/<?php //echo $eventData->event_title; ?>">Read All <?php //echo $numEventUpdates->numupdates; ?> Event Updates</a></h2>



    <div>

        <?php
        /*
        foreach($eventupdates as $eventupdate){

            echo '<p>'.$eventupdate->meta_value.'<br/>';

            echo '<span>POSTED: '.$eventupdate->meta_timestamp.'</span>';

            echo '</p>';



        }
        */
        ?>

    </div>

</div>
-->


<?php
//if($eventCreatorId==$theUserId){
?>
<!--
    <div class="googleMapsInfoWindowInner">

        <h2>POST EVENT UPDATE</h2>

        <form id="addEventUpdate">

            <textarea class="textarea" name="eventUpdateContent" placeholder="Add Event Update"></textarea>

            <div class="clear-10"></div>

            <input type="submit" class="yellowButton bold sixteen" value="POST EVENT UPDATE" name="submit" />

        </form>



        <script>

            $('#addEventUpdate').submit(function(){

                var data = $('#addEventUpdate').serializeArray()

                $.ajax({

                    type: "POST",

                    url: "<?php //echo base_url(); ?>index.php/events/addEventUpdate/<?php //echo $eventData->event_id; ?>/3",

                    data: data,

                    dataType: 'json',

                    success: function(result){

                        $('#eventUpdates > div').html(' ');

                        $.each(result, function(i, item) {

                            $('#eventUpdates > div').append('<p>'+result[i].meta_value+'<br/><span>POSTED: '+result[i].meta_timestamp+'</span></p>');

                        });



                    }

                });

                return false;

            });

        </script>



    </div>
-->
<?php //} ?>


<!--
<div id="eventComments" class="nomargin">

    <h2>COMMENTS <a href="<?php //echo base_url(); ?>index.php/events/allEventComments/<?php //echo $eventData->event_id; ?>/<?php //echo $eventData->event_title; ?>">Read All <span id="numComments"><?php //echo $numEventComments->numupdates; ?></span> Comments</a></h2>

    <div>

        <?php
        /*
        foreach($eventcomments as $eventcomment){

            $showdomId = str_replace(' ','',$eventcomment->showdom_id);

            echo '<div>';

            echo '<img class="userCommentImage" src="'.base_url().''.image("themes/showdom/images/users/".$showdomId."/".$eventcomment->image."", 60 , 60 ).'" />';

            echo '<a href="'.base_url().'index.php/profile/view/'.$eventcomment->showdom_id.'">'.$eventcomment->showdom_id.'</a>';

            echo '<p>'.$eventcomment->meta_value.'</p>';

            echo '<span>POSTED: '.$eventcomment->meta_timestamp.'</span>';

            echo '</div>';



        }
        */
        ?>

    </div>

</div>
-->
<!--
<?php //if($theUserId){ ?>

    <div class="googleMapsInfoWindowInner">

        <h2>POST COMMENT</h2>

        <form id="addEventComment">

            <textarea class="textarea" name="eventAddComment" placeholder="Add Comment"></textarea>

            <div class="clear-10"></div>

            <input type="submit" class="yellowButton bold sixteen" value="POST COMMENT" name="submit" />

        </form>

        <script>

            $('#addEventComment').submit(function(){

                if($('textarea[name="eventAddComment"]').val() != ''){

                    var data = $('#addEventComment').serializeArray();

                    $.ajax({

                        type: "POST",

                        url: "<?php //echo base_url(); ?>index.php/events/addEventComment/<?php //echo $eventData->event_id; ?>/3",

                        data: data,

                        success: function(result){

                            $('#eventComments > div').html(' ');

                            $('#eventComments > div').append(result);

                            $('textarea[name="eventAddComment"]').val('');

                            $('#numComments').html(Number($('#numComments').html())+Number(1));

                        } 

                    });

                }

                return false;



            });

        </script>

    </div>

<?php //} ?>
-->




</div>

</div>

</div>



<script>

    $("a.enlargePhoto").fancybox();

    $(function(){ $('.equalHeightOutter').equalHeights(); });

</script>