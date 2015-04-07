<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>USERS</h2>
            <span>TOTAL USERS: <?php echo $numUsers; ?></span>
            <form id="search">
            	<label>Search: </label>
                <input id="searchVal" type="text" name="value" />
            </form>
			<hr />
            
        	<p class="totalUsers"></p>
            
            
            
            <div id="events" class="favourites">
                <?php
					foreach($users as $user){
                        if($user->gender == 1){
                            $gender = 'Male';
                        }elseif($user->gender == 2){
                            $gender = 'Female';
                        }else{
                            $gender = 'Other';
                        }
						echo '<h2 class="eventTitle eventTitleCat1">';
							echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/">'.$user->showdom_id.'</a>';
						echo '</h2>';
						echo '<div class="googleMapsInfoWindowInner clearfix">';
							echo '<div class="eventLeft">';
								echo '<a href="'.base_url().'index.php/profile/view/'.$user->showdom_id.'/"><img class="userImage" src="'.base_url().image('themes/showdom/images/users/'.$user->showdom_id.'/'.$user->image."", 150, 150).'" /></a>';
							echo '</div>'; 
							
							echo '<div class="eventContentLarger">';
								echo '<p><small><em class="lightGrey">Account Type:</em></small> <span>'.getAccountType($user->account_type).'</span></p>';
								echo '<p><small><em class="lightGrey">Email:</em></small> <span>'.$user->email.'</span></p>';
								echo '<p><small><em class="lightGrey">Status:</em></small> <span>'.getStatus($user->active).'</span></p>';
								echo '<p><small><em class="lightGrey">location:</em></small> <span>'.$user->city.' '.$user->state.' '.$user->country.'</span></p>';
								echo '<p><small><em class="lightGrey">Gender:</em></small> <span>'.$gender.'</span></p>';
								echo '<p><small><em class="lightGrey">Age:</em></small> <span>'.getAge($user->birth).'</span></p>';
								if($user->website != ''){
									echo '<p><small><em class="lightGrey">Website:</em></small> <span><a href="'.$user->website.'" target="_blank">'.$user->website.'</a></span></p>';
								}
								
								echo '<div class="clear-10"></div>';
								if($user->active == 1){
									echo '<a onclick="return confirm(\'Are you sure you want to deactivate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/deactivateUser/'.$user->user_id.'">DEACTIVATE</a>';
								}else{
									echo '<a onclick="return confirm(\'Are you sure you want to activate this user?\')" class="deleteEventButton yellowButton sixteen" href="'.base_url().'index.php/admin/activateUser/'.$user->user_id.'">ACTIVATE</a>';
								}
							echo '</div>';
						echo '</div>';
					}
				?>
				
            </div>
       </div>
    </div>
</div>


<script>
$(document).ready(function(){
	var loadingEvents = false;
	var offset = 6;
	var searchTerm = $('#searchVal').val();
	$(window).scroll(function() {		
		if (($("#popup").offset().top + $("#popup").height() - $(window).height()) <= $(window).scrollTop()) {
			if(loadingEvents == false){
				loadingEvents = true;
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/admin/reloadUserList",
					data: "offset="+offset+"&searchTerm="+searchTerm,
					success: function(result){
						offset = offset + 10;
						$("#events").append(result);
						loadingEvents = false;
					}
				});
			}
		}
   });
   
   $('#searchVal').keyup(function(){
	   searchTerm = $('#searchVal').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/admin/searchUserList",
			data: "searchTerm="+searchTerm,
			success: function(result){
				offset = offset + 10;
				$("#events").html(result);
			}
		}); 
   });
   
});
</script>