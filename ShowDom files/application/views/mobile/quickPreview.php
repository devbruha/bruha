<div id="quickPreivew">
    <div>
    <h3>MEDIA PREVIEW</h3>
    <a id="closeQuickPreview" href="#"></a>

    <div class="clear"></div>

    <?php

    foreach($events as $event){
        if($event->event_type == 1){
            echo '<span class="featured">FEATURED</span>';
        }
        echo '<h2 class="eventTitle eventTitleCat'.$event->event_cat.'">';
        echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'">'.$event->event_title.'</a>';

        echo '</h2>';

        $eventDateData = getNextEventDate($event->event_id);

        /*
        echo '<div class="googleMapsInfoWindowInner clearfix">';
            echo '<div class="eventLeft">';
                    echo '<div class="eventDate">';
                        echo convertDate($eventDateData[0]);
                    echo '</div>';
                    echo '<div class="eventImageWrap">';
                        if(file_exists('themes/showdom/images/events/'.$event->event_id.'/'.$event->event_image.'')){
                            echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'"><img class="eventImage" src="'.base_url().''.image("themes/showdom/images/events/".$event->event_id."/".$event->event_image."", 200, 200).'" /></a>';
                        }else{
                            echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'"><img class="eventImage" src="'.base_url().'themes/showdom/images/eventImage.png" /></a>';
                        }
                    echo '</div>';
                echo '</div>';

                echo '<div class="eventContent eventContentLarge">';
                echo '<p><small><em class="lightGrey">Attending:</em></small> <span>'.$numFavourites.'</span></p>';
                echo '<p><small><em class="lightGrey">Category:</em></small> <span class="catColor'.$event->event_cat.'"><strong>'.$event->cat_name.'</strong></span> - '.$event->sub_cat_name.'</p>';
                echo '<p><small><em class="lightGrey">Location:</em></small> <span>'.$event->event_location.'</span></p>';
                echo '<p><small><em class="lightGrey">Time:</em></small> <span>'.convertTime($eventDateData[1]).' to '.convertTime($eventDateData[2]).'</span></p>';
                if($event->event_timezone != ''){
                    echo '<p><small><em class="lightGrey">Tome Zone:</em></small> <span>'.$event->event_timezone.'</span></p>';
                }

                echo '<a href="'.base_url().'index.php/mobile/viewEvent/'.$event->event_id.'" class="yellowButton">VIEW EVENT</a>';

            echo '</div>';
        echo '</div>';
        */

        echo '<div class="quickEventContainer">';
        $numAudio = count($featuredaudio);
        if($numAudio != 0){
            foreach($featuredaudio as $aud){
                echo '<h2>Audio Player</h2>';
                $numAudio = count($featuredaudio);
            if($numAudio != 0){
            foreach($featuredaudio as $aud){
                        if($aud->audio_file != ''){
                            echo '<div id="jquery_jplayer_1" class="jp-jplayer"></div>
                                <div id="jp_container_1" class="jp-audio">
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
                                    <div class="clear-10"></div>
                                </div>';
                            echo '</div>';
                        }elseif($aud->audio_ext == 'youtube'){
                            echo '<div class="jp-title">'.$aud->audio_caption.'</div>';
                            echo '<iframe style="z-index:0" width="380" height="24" src="http://www.youtube.com/embed/'.$aud->audio_url.'?rel=0&autohide=0&modestbranding=1" frameborder="0" allowTransparency="true"></iframe>';
                        }else{
                            echo '<div class="jp-title">'.$aud->audio_caption.'</div>';
                            echo '<iframe src="http://player.vimeo.com/video/'.$aud->audio_url.'" width="380" height="55" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                        }
                        ?>
                        <script>
                            $("#jquery_jplayer_1").jPlayer({
                                ready: function () {
                                    $(this).jPlayer("setMedia", {
                                    "<?php echo substr($aud->audio_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/audio/events/<?php echo $eventId; ?>/<?php echo $aud->audio_file; ?>"
                                });
                            }
                            });
                        </script>
                    <?php
                    }
                    }else{
                        echo '<p>No Audio have been added to this event.</p>';
                    }


                ?>
                <script>
                    $("#jquery_jplayer_1").jPlayer({
                        ready: function () {
                            $(this).jPlayer("setMedia", {
                            "<?php echo substr($aud->audio_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/audio/events/<?php echo $eventId; ?>/<?php echo $aud->audio_file; ?>"
                        });
                    }
                    });
                </script>
            <?php
            }
        }else{
            echo '<h2>Audio Player</h2>';
            echo '<p>No Audio have been added to this event.</p>';
        }
        echo '</div>';


        echo '<div class="quickEventContainer">';
            $totalImages = count($eventimages);
            if($totalImages != 0){
                echo '<h2>Photos & Images</h2>';
                $imageCounter = 0;
                $imageLeftCounter = 0;
                foreach($eventimages as $image){
                    $imageCounter ++;
                    if($imageCounter <=7){
                        echo '<img src="'.base_url().'themes/showdom/images/events/'.$eventId.'/gallery/'.$image->photo_thumb.'" />';
                        //echo '<img src="'.base_url().''.image("themes/showdom/images/events/'.$eventId.'/gallery/'.$image->photo.'", 100, 80).'" />';
                    }else{
                        $imageLeftCounter ++;
                    }
                }
                echo '<div class="imagesLeft">+'.$imageLeftCounter.'</div>';
                echo '<div class="clear"></div>';
            }else{
                echo '<h2>Photos & Images</h2>';
                echo '<p>No images have been added.</p>';
            }
        echo '</div>';


        echo '<div class="quickEventContainer">';

        $numVids = count($featuredVideo);
        if($numVids != 0){
            foreach($featuredVideo as $vid){
                echo '<h2>Video</h2>';
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
                                "<?php echo substr($vid->video_file_ext,1); ?>": "<?php echo base_url(); ?>themes/showdom/video/events/<?php echo $eventId; ?>/<?php echo $vid->video_file; ?>"
                            });
                        },
                            swfPath: "<?php echo base_url(); ?>themes/showdom/plugins/jPlayer-master/jquery.jplayer/Jplayer.swf",
                            supplied: "<?php echo substr($vid->video_file_ext,1); ?>",
                            cssSelectorAncestor: "#jp_container_video_<?php echo $counter; ?>"
                        });
                    </script>
                <?php
                }elseif($vid->video_file_ext == 'youtube'){
                    ?>
                    <div class="jp-title"><?php echo $vid->video_title; ?></div>
                    <iframe style="z-index:0" width="380" height="200" src="http://www.youtube.com/embed/<?php echo $vid->video_youtube; ?>?autoplay=0&wmode=opaque" frameborder="0" allowTransparency="true"></iframe>
                <?php }else{ ?>
                    <div class="jp-title"><?php echo $vid->video_title; ?></div>
                    <iframe src="http://player.vimeo.com/video/<?php echo $vid->video_youtube; ?>" width="380" height="200" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                <?php }

            }
        }else{
            echo '<h2>Video</h2>';
            echo '<p>No videos have been added to this event.</p>';
        }
        echo '</div>';


    }
    ?>



</div>


