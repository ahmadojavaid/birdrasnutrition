<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Madang
 */

get_header(); ?>

        <!--Begin content wrapper-->
        <div id="content" class="site-content content-wrapper page-content ">

		<?php
		while ( have_posts() ) : the_post();
  
            if ( 'event' === get_post_type() ) {
                get_template_part( 'template-parts/content-event' );
            } else if ( 'career' === get_post_type() ) {
                get_template_part( 'template-parts/content-career' );
            } else if ( 'story' === get_post_type() ) {
                get_template_part( 'template-parts/content-story' );
            } else if ( is_single() ) {
                get_template_part( 'template-parts/content-blog' );
            }
		endwhile; // End of the loop.
		?>
        </div>
        <!--End content wrapper-->
<?php
get_footer();
