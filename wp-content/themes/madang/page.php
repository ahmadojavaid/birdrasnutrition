<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

get_header(); 
$meta = get_post_meta( get_the_ID() );
$wide_content = true;

if ( isset( $meta['_narrow_content'][0] ) ) {
	$wide_content = false;
}

$enable_title = true;
if ( isset( $meta['_title'][0] ) ) {
	$enable_title = false;
}

?>

        <!--Begin content wrapper-->
        <div id="content" class="site-content content-wrapper page-content">

            <?php if ( $enable_title ) : ?>
                <div class="entry-header text-center">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </div>
            <?php endif; ?>

          	<?php if ( $wide_content ) : ?>
		    <div class="page-content">
			    <div class="container">
			    <?php endif; ?>
			    	
					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; ?>
					
			    <?php if ( $wide_content ) : ?>
			    </div>
		    </div>
		    <?php endif; ?>
        </div><!-- #primary -->
<?php
get_footer();
