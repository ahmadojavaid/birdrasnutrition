<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

get_header(); ?>

<div id="primary" class="site-content content-wrapper topofset">
    <div id="main" class="container content_search" >

        <header class="page-header">
        <h1 class="page-title text-light"><?php $tag_slug = get_query_var('tag'); printf( esc_html__( 'Search Results for tag: %s', 'madang' ), '<span>' . $tag_slug . '</span>' ); ?></h1>
        </header><!-- .page-header -->

        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array(
                      'post_status'     => 'publish',
                      'post_type'       => 'post',
                      'posts_per_page'  => '10',
                      'tag'             => $tag_slug,
                      'paged'           => $paged
                      );
        $tag_query = new WP_Query( $args );
        while ( $tag_query->have_posts() ) : $tag_query->the_post();

            get_template_part( 'template-parts/content', 'tag' );

        endwhile;
            
        wp_reset_postdata();
        ?>
        <?php madang_pagination_blog(); ?>
    </div><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); 