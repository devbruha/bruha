<?php get_header(); ?>

<div id="popup" class="adminpopup">
<div class="clear-10"></div>
<div class="clear-10"></div>
    <div id="popupInner" class="clearfix">
		
        <div id="popupInnerFull" class="">
        	<span> </span>
            <h2>Welcome to the ShowDom™ Blog</h2>
			<p>
               This is where we'll keep you updated on site developments, updates, free stuff, cool feedback and anything else we think is relevant to you. 
            </p>
			<hr />
        </div>
        
        <div id="popupInnerLeft" class="whiteBackground">
        	<div class="blackBg">
                <h2>CATEGORIES</h2>
                <ul class="sidebarMenu">
					<?php wp_list_categories('title_li='); ?>
                </ul>
           </div>
           <div class="clear-10"></div>
           <div class="blackBg">
                <h2>ARCHIVES</h2>
                <ul class="sidebarMenu">
					<?php wp_get_archives(); ?>
           		</ul>
           </div>
        </div>
        
        <div id="popupInnerRight">
			 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>             
             <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
             <span class="postDate"><?php the_time('F jS, Y') ?></span>
			  <div class="clear-10"></div>
			  <?php
			  	if( has_post_thumbnail() ){
						the_post_thumbnail(array(600,300));
				}
			  ?>			 
              <div class="clear-10"></div>
			  <?php the_content(); ?>
             <span class="postedIn">POSTED IN <?php the_category(', '); ?></span>
             <div class="clear"></div>
             <hr class="dotted" />
                 
			 <?php endwhile; else: ?>
             <?php endif; ?>
             <div class="clear-10"></div>
             <h2>COMMENTS</h2>
             <div class="clear-10"></div>
             <?php comments_template(); ?>
             
             
             <a class="yellowButton sixteen bold" style="width:100px;" href="<?php echo bloginfo('url'); ?>">BACK</a>
        </div>
        
    </div>
</div>
<?php get_footer(); ?>