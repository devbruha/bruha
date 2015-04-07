<?php if ( have_comments() ) : ?>
    <ol class="commentlist">
        <?php
            wp_list_comments();
        ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <div class="navigation">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
        </div><!-- .navigation -->
    <?php endif;  ?>
                
<?php endif; ?>
<?php comment_form(); ?>