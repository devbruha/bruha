<div id="popup">
    <div id="popupInner" class="clearfix">
    	
        <div class="blackBox clearfix eventUpdatesMenu nopadding">
        	<ul>
            	<li><a href="<?php echo base_url() ?>index.php/updates">FEATURED</a></li>
                <li><a href="<?php echo base_url() ?>index.php/updates/mostViews">MOST VIEWED</a></li>
                <li class="active"><a href="<?php echo base_url() ?>index.php/updates/favourites">ATTENDING</a></li>
                <li><a href="<?php echo base_url() ?>index.php/updates/suggested">SUGGESTED</a></li>
            </ul>
        </div>
    
		<div id="popupInnerFull">
        
            <div id="events" class="favourites">
                <?php
                    if(count($recentEventUpdates) == 0){
                        echo '<p>No events you are attending have any recent updates.</p>';
                    }else{
                        $i = 0;
                        $randOdd = 5;
                        $randEven = 12;
                        $colleft = '<div class="leftHalf">';
                        $colright = '<div class="rightHalf">';
                        foreach($recentEventUpdates as $recentEventUpdate){
                            if ($i++ % 2 == 0) {
                                $var = 'left';
                            }else{
                                $var = 'right';
                            }
                            ${"col".$var} .= '<div>';

                                if ($i % $randOdd == 0) {
                                    ${"col".$var}  .= '<div style="margin-bottom:20px;">';
                                        $keywords = getEventKeywords($recentEventUpdate->event_id);
                                        ${"col".$var}  .= getRandomAd(1,$recentEventUpdate->event_cat,$recentEventUpdate->event_sub_cat,$keywords);
                                    ${"col".$var}  .= '</div>';
                                }

                                ${"col".$var}  .= '<h3 class="blackBox">'.convertDate($recentEventUpdate->meta_timestamp).' '.convertTime($recentEventUpdate->meta_timestamp).'</h3>';
                                ${"col".$var}   .= '<h2 class="eventTitle eventTitleCat'.$recentEventUpdate->event_cat.'"><a href="'.base_url().'index.php/events/view/'.$recentEventUpdate->event_id.'/'.seoNiceName($recentEventUpdate->event_title).'">'.$recentEventUpdate->event_title.'</a></h2>';

                                if(!isset($recentEventUpdate->actions)){
                                    ${"col".$var}  .= '<div class="metaContent">';
                                        ${"col".$var}  .= '<p>'.$recentEventUpdate->meta_value.'</p>';
                                    ${"col".$var}  .= '</div>';
                                }else{
                                    $numImages = 0;
                                    foreach($recentEventUpdate->actions as $action){
                                        $numImages ++;
                                    }

                                    ${"col".$var} .= '<div class="metaContentOutter clearfix">';
                                        ${"col".$var} .= '<div class="metaContent">';
                                            ${"col".$var} .= '<p>Added '.$numImages.' Event Photos</p>';
                                        ${"col".$var} .= '</div>';

                                        $imageCounter = 0;
                                        $imageCounter = 0;
                                        $imageLeftCounter = 0;
                                        foreach($recentEventUpdate->actions as $action){
                                            $imageCounter ++;
                                            if($imageCounter <=7){
                                                ${"col".$var} .= '<a rel="view_photo_group" class="enlargePhoto'.$recentEventUpdate->event_id.'" href="'.base_url().'themes/showdom/images/events/'.$recentEventUpdate->event_id.'/gallery/'.$action->meta_value.'">
                                                    <img src="'.base_url().''.image("themes/showdom/images/events/".$recentEventUpdate->event_id."/gallery/".$action->meta_value, 100, 80).'" />
                                                </a>';
                                            }else{
                                                $imageLeftCounter ++;
                                                ${"col".$var} .= '<a style="display:none" rel="view_photo_group" class="enlargePhoto'.$recentEventUpdate->event_id.'" href="'.base_url().'themes/showdom/images/events/'.$recentEventUpdate->event_id.'/gallery/'.$action->meta_value.'">
                                                    <img src="'.base_url().''.image("themes/showdom/images/events/".$recentEventUpdate->event_id."/gallery/".$photo->meta_value, 100, 80).'" />
                                                </a>';
                                            }
                                        }
                                        ${"col".$var} .= '<script>$(".enlargePhoto'.$recentEventUpdate->event_id.'").fancybox();</script>';
                                        ${"col".$var} .= '<div class="imagesLeft">+'.$imageLeftCounter.'</div>';
                                    ${"col".$var} .= '</div>';
                                }

                                if(date('Ymd') == date('Ymd', strtotime($recentEventUpdate->meta_timestamp))){
                                    ${"col".$var}  .= '<div class="ribbon-wrapper-red"><div class="ribbon-red">NEW</div></div>';
                                }

                            ${"col".$var}  .= '</div>';

                        }
                        $colleft  .= '</div>';
                        $colright .= '</div>';
                        echo $colleft;
                        echo $colright;
                    }
                ?> 
            </div>
       </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#eventNew').addClass('active');
});
</script>