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
        <h1 class="page-title text-light"><?php $cat = get_query_var('cat'); $current_cat = get_category($cat); printf( esc_html__( 'Search Results for category: %s', 'madang' ), '<span>' . $current_cat->name . '</span>' ); ?></h1>
        </header><!-- .page-header -->

        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $args = array(
                      'post_status'     => 'publish',
                      'post_type'       => 'post',
                      'posts_per_page'  => get_option( 'posts_per_page' ),
                      'cat'             => $cat,
                      'paged'           => $paged
                      );

        $tag_query = new WP_Query( $args );
        while ( $tag_query->have_posts() ) : $tag_query->the_post();

            get_template_part( 'template-parts/content', 'tag' );

        endwhile;
            
        wp_reset_postdata();
        ?>

        <!-- menu pegination -->
        <div class="row pagination-cont">
            <div class="col-xs-12 col-sm-12 text-center menu-pegination wow fadeInUp">

                <?php  madang_product_pagination( $tag_query, get_pagenum_link( 999999999 ) );  ?>

            </div>
        </div>
        <!-- menu pegination ends-->
    </div><!-- #main -->
</div><!-- #primary -->
<?php get_footer();