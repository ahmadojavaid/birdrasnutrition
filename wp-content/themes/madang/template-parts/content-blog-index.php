<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

?>

                    <div class="blog-post-content">
                        <!--Blog Post-->
                        <div class="blog-post post-content " >
                            <?php if ( has_post_thumbnail() ) : ?>
                            <div class="area-img">
                               <a href="<?php echo get_the_permalink(); ?>"><?php the_post_thumbnail('madang-blog', array('class' => 'img-responsive')); ?></a>
                            </div>
                            <?php endif; ?>
                            <div class="area-content">
                                <h2 class="text-regular text-uppercase"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                                <div class="blog-stats">
                                    <span class="clock">
                                        <span class="fa fa-calendar stats-item"></span>
                                        <span class="text-center text-light stats-item"><a href="<?php echo get_the_permalink(); ?>"><?php echo date( 'd M Y', get_post_time( 'U', true ) ); ?></a></span>
                                    </span>
                                    <span class="comment">
                                        <span class="fa fa-comment stats-item"></span>
                                        <span class="text-center text-light stats-item"><?php echo comments_number( esc_html__( 'no comments', 'madang' ), esc_html__( 'one comment', 'madang' ), '% ' . esc_html__( 'comments', 'madang' ) ); ?></span>
                                    </span>
                                    <span class="user">
                                        <span class="fa fa-user stats-item"></span>
                                        <span class="text-content text-light stats-item"><?php echo get_the_author(); ?></span>
                                    </span>
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
                        <?php 
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif; ?>
                    </div>
