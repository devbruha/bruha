<?php get_header(); ?>
<div id="popup" class="adminpopup">
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
              
              <?php
			  	if( has_post_thumbnail() ){
					echo '<div class="postThumbnail">';
						the_post_thumbnail( array(150,150) );
					echo '</div>';
				}
			  ?>
             
             <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
             <span class="postDate"><?php the_time('F jS, Y') ?></span>
             <?php the_excerpt(); ?>
             <span class="postedIn">POSTED IN <?php the_category(', '); ?></span>
             <div class="clear"></div>
             <hr class="dotted" />
                 
			 <?php endwhile; else: ?>
             <?php endif; ?>
        </div>
        
    </div>
</div>
<?php get_footer(); ?>