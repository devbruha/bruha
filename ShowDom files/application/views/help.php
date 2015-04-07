<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull" class="">
        	<div class="clear-10"></div>
            <?php echo $content; ?>
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CONTENTS</h2>
                <ul class="sidebarMenu">
					<?php
                        foreach($contentSection as $section){
                            echo '<li><a href="#step'.$section->section_id.'">'.$section->title.'</a></li>';
                        }
                    ?>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight" class="cmsPage">
        	<br />
            <?php
				foreach($contentSection as $section){
					echo '<h2 id="step'.$section->section_id.'">'.$section->title.'</h2>';
					echo $section->content;
					echo '<hr class="dotted" />';
					echo '<div class="clear-10">&nbsp;</div>';
				}
			?>
           
        </div>
        
    </div>
</div>