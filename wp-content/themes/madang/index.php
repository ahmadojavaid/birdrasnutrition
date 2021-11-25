<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

    get_header(); ?>

<!--Begin content wrapper-->
<div id="content" class="site-content content-wrapper">

    <div id="post-<?php the_ID(); ?>">
        <div class="blog-content">
            <main>
                <div class="container">
                    <div class="row">
                        
                            <!--Col Main-->
                            <div class="col-main col-lg-8 col-md-7 col-xs-12">
                            
                            <?php
                                while ( have_posts() ) : the_post(); ?>
                                    <div <?php post_class(); ?>>
                                         <?php get_template_part( 'template-parts/content-blog-index' ); ?>
                                    </div>
                               <?php endwhile;  // End of the loop.
                                madang_pagination_blog();
                            ?>
                            
                            </div>
                            <!--Sidrbar Right-->
                            <div class="sidebar blog-right col-lg-4 col-md-5 hidden-sm hidden-xs">
                                <?php get_sidebar(); ?>
                            </div>
                      
                    </div>
                </div>
            </main>
        </div>
    </div><!-- #post-## -->

</div>

<!--End content wrapper-->
<?php
    get_footer();

