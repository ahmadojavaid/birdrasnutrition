<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Madang
 */

get_header(); ?>

<div id="primary" class="site-content content-wrapper topofset">
	<div id="main" class="container" >
        <div class="content content_search" >
			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title text-light"><?php printf( esc_html__( 'Search Results for: %s', 'madang' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				endwhile;

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>
        </div>
	</div><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
