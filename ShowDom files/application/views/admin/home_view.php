<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull" class="">
            <h2>ADMIN </h2>
            <span>DASHBOARD</span>
			<hr />
        
            <?php 				
				echo '<div class="googleMapsInfoWindowInner eventStats clearfix">';
					echo '<h3>TOTAL USERS</h3>';
					echo '<p>'.$numUsers.'</p>';
					
					echo '<div class="statBreakdown">';
						foreach($userBreakDown as $breakdown){
							echo '<p><span>'.$breakdown->city.' '.$breakdown->state.' '.$breakdown->country.'</span> <span>'.$breakdown->total.'</span></p>';
						}
					echo '</div>';
					
					echo '<hr />';
					
					echo '<h3>TOTAL EVENTS</h3>';
					echo '<p>'.$numEvents.'</p>';
					echo '<div class="statBreakdown">';
						foreach($eventsBreakdown as $breakdown){
							echo '<p><span>'.$breakdown->event_location.'</span> <span>'.$breakdown->total.'</span></p>';
						}
					echo '</div>';
					echo '<hr />';
					
					echo '<h3>TOTAL ADS</h3>';
					echo '<p>'.$numAds.'</p>';
					echo '<div class="statBreakdown">';
						foreach($adsBreakdown as $breakdown){
							echo '<p><span>'.$breakdown->ad_location.'</span> <span>'.$breakdown->total.'</span></p>';
						}
					echo '</div>';
					echo '<hr />';
					
				echo '</div>';
				
		   ?>
           
        </div>
        
    </div>
</div>
