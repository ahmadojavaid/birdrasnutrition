<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="blog-content">
        <main>
            <div class="container">
                <div class="row">
                    <!--Col Main-->
                    <div class="col-main col-lg-8 col-md-7 col-xs-12">
                        <div class="blog-post-content">
                            <!--Blog Post-->
                            <div class="blog-post post-content">
                                <?php if ( has_post_thumbnail() ) : ?>
                                <div class="area-img">
                                   <?php the_post_thumbnail('madang-blog', array('class' => 'img-responsive')); ?>
                                </div>
                                <?php endif; ?>
                                <div class="area-content">
                                    <h2 class="text-regular text-uppercase"><?php echo get_the_title(); ?></h2>
                                    <div class="blog-stats">
                                        <span class="clock">
                                            <span class="fa fa-calendar stats-item"></span>
                                            <span class="text-center text-light stats-item"><?php echo date( 'd M Y', get_post_time( 'U', true ) ); ?></span>
                                        </span>
                                        <span class="comment">
                                            <span class="fa fa-comment stats-item"></span>
                                            <span class="text-center text-light stats-item"><?php echo comments_number( esc_html__( 'no comments', 'madang' ), esc_html__( 'one comment', 'madang' ), '% ' . esc_html__( 'comments', 'madang' ) ); ?></span>
                                        </span>
                                        <span class="user">
                                            <span class="fa fa-user stats-item"></span>
                                            <span class="text-content text-light stats-item"><?php echo get_the_author(); ?></span>
                                        </span>
                                        <?php
                                        $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'madang' ) );
                                        if ( $categories_list ) {
                                            printf( '<span class="cat-links"><span class="fa fa-folder stats-item" aria-hidden="true"></span><span class="screen-reader-text">%1$s </span>%2$s</span>',
                                                _x( 'Categories', 'Used before category names.', 'madang' ),
                                                $categories_list
                                            );
                                        }

                                        $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'madang' ) );
                                        if ( $tags_list ) {
                                            printf( '<span class="tags-links"><span class="fa fa-tag stats-item" aria-hidden="true"></span><span class="screen-reader-text">%1$s </span>%2$s</span>',
                                                _x( 'Tags', 'Used before tag names.', 'madang' ),
                                                $tags_list
                                            );
                                        }  ?>
                                    </div>
                                    <div class="clearfix" ></div>
                                    <div class="post-content-body">
                                    <?php
                                    the_content( sprintf(
                                             /* translators: %s: Name of current post. */
                                            wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'madang' ), array( 'span' => array( 'class' => array() ) ) ),
                                            the_title( '<span class="screen-reader-text">"', '"</span>', false )
                                    ) );
                                    ?>
                                    </div>  
                                    <?php
                                    //pagination
                                    wp_link_pages( array(
                                                         'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'madang' ) . '</span>',
                                                         'after'       => '</div>',
                                                         'link_before' => '<span>',
                                                         'link_after'  => '</span>',
                                                         'pagelink'    => '<span class="screen-reader-text">%</span>',
                                                         'separator'   => '',
                                                         ) );
                                  
                                    ?>

                                </div>
                            </div>

                            <!--Share-->
                            <?php madang_sharing( $type = 'blog' );
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif; ?>
                        </div>

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