<div id="popup" class="forgotPassword">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>FORGOT PASSWORD</h2>
            <div id="actions">
                <a id="save" class="yellowButton sixteen bold">RESET PASSWORD</a>
            </div>
			<hr />
        
            <div id="events" class="favourites">
            	<?php 
					if(isset($message)){
						echo '<p style="color:red">'.$message.'<br/><br/><br/></p>';
					}
				?>
				<form id="standardForm" action='<?php echo base_url();?>index.php/home/forgotPasswordSubmit' method='post' name='standardForm' class="standardForm clearfix" enctype="multipart/form-data">
                    <div class="formLeft">
                        <div class="formWrap clearfix">
                            <label for="eventName">SHOWDOM ID or EMAIL</label>
                            <input type="text" name="userEmail" class="required" />
                        </div>
                    </div>
                    
                </form>
                <div class="clear-10"></div>
            </div>
            
            
       </div>
    </div>
</div> 

<script>
$('#save').click(function(){
	$('#standardForm').submit();	
});
</script>