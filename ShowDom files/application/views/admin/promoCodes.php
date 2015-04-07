<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		<div id="popupInnerFull">
            <h2>PROMO CODES</h2>
			<hr />
            <form id="standardForm" class="standardForm clearfix" method="post" action="<?php echo base_url() ?>index.php/admin/createPromoCodes">
                <div>
                    <label>How Many Codes</label>
                    <input name="numCodes" value="1" />
                </div>
                <div style="position: relative; margin-top: 10px;">
                    <input style="position: relative;top:0px;right: 0px" name="submit" value="Generate Codes" type="submit" class="yellowButton floatLeft" />
                </div>
            </form>
            <div id="events" class="favourites">
                <table style="width: 100%" cellspacing="1" cellpadding="1">

                <tr>
                    <td><strong>Code</strong></td>
                    <td><strong>Used</strong></td>
                    <td><strong>Delete</strong></td>
                </tr>
                <?php
                    foreach($codes as $code){
                        echo '<tr>';
                            echo '<td>'.$code->code_value.'</td>';
                            echo '<td>';
                                if($code->code_used == 0){
                                    echo 'No';
                                }else{
                                    echo 'Yes';
                                }
                            echo '</td>';
                            echo '<td><a onclick="return confirm(\'Are you sure?\');" href="'.base_url().'index.php/admin/deleteCode/'.$code->code_id.'">Delete</a></td>';
                        echo '</tr>';
                    }
                ?>
                </table>
            </div>
       </div>
    </div>
</div>


<style>
    tr{

        width: 100%;
    }
    table {
        border-collapse: separate;
        border-spacing: 10px;
    }
    td{
        border-bottom: 1px solid #333333;
        padding-bottom: 10px;
    }
</style>

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
					url: "<?php echo base_url(); ?>index.php/admin/reloadAdList",
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
			url: "<?php echo base_url(); ?>index.php/admin/searchAdList",
			data: "searchTerm="+searchTerm,
			success: function(result){
				offset = offset + 10;
				$("#events").html(result);
			}
		}); 
   });
   
});
</script>