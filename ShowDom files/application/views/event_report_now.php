<div id="popup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>REPORT EVENT</span>
			<hr />
        	<p>Please tell us a little bit as to why you wish to have this event removed from showdom.</p>
        <br/>
            <form id="standardForm" class="standardForm" method="post" action="<?php echo base_url(); ?>index.php/events/report/<?php echo $eventId; ?>/">
                <div class="formWrap clearfix">
                    <label>Full Name: </label>
                    <input type="text" name="fullName" />
                </div>
                <div class="formWrap clearfix">
                    <label>Email: </label>
                    <input type="text" name="email" />
                </div>
                <div class="formWrap clearfix">
                    <label>Reason: </label>
                    <textarea name="why" class="required"></textarea>
                </div>
                <div class="formWrap clearfix">
                    <input style="clear: both;float: right; position: relative; right: 0; top: 0;" type="submit" name="submit" value="Report Event" class="yellowButton sixteen bold" />
                </div>
            </form>
            <br/><br/>
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#standardForm").validate({
            validClass: "success"
        });
    });
</script>