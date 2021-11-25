<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Madang
 */

get_header(); ?>

<div id="primary" class="site-content content-wrapper topofset">
	<div id="main" class="container error-404 not-found" role="main">
		<div class="content content_search" >
				<?php
                    get_template_part( 'template-parts/content', 'none' );
				?>
		</div>
	</div><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
