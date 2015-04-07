<script type="text/javascript" src="<?php echo base_url(); ?>themes/showdom/js/tinymce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		theme_advanced_resizing : true

	});
</script>

<div id="popup" class="adminpopup">
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull">
            <span>PAGE CONTENT</span>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>PAGES</h2>
                <ul class="sidebarMenu">
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/1">Sign Up</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/2">About</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/3">Help</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/4">Advertising</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/5">Terms Of Service</a></li>
                    <li><a href="<?php echo base_url(); ?>index.php/admin/content/6">Privacy Policy</a></li>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
            <form method="post" action="<?php echo base_url(); ?>index.php/admin/contentUpdate">
                <textarea name="content" style="width:100%"><?php if($content){ echo $content; } ?></textarea>
                <input type="hidden" name="content_id" value="<?php echo $contentId; ?>" />
                <input type="submit" name="submit" value="Edit" />
            </form>
        </div>
        
    </div>
</div>