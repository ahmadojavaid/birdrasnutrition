<?php

/*
Widget Name: Madang Blog Widget
Description: Create Different Blog Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_blog_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_blog_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Blog', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Blog Section', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'madang'),
                    'default' => ''
                ),
                'category' => array(
                    'type' => 'text',
                    'label' => esc_html__('Category', 'madang'),
                    'default' => ''
                ),
                'records_per_page' => array(
                    'type' => 'text',
                    'label' => esc_html__('Records per page', 'madang'),
                    'default' => ''
                ),
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose blog type from selection below', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'minified' => esc_html__( 'Minified', 'madang' ),
                        'normal' => esc_html__( 'Normal', 'madang' ),    
                    )
                ),
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra Class', 'madang'),
                    'description' => esc_html__('Extra style class to apply to the blog', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-blog';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_blog_widget', __FILE__, 'madang_blog_widget');

endif;

function madang_shortcode_blog($atts, $content = null) {
	$atts = shortcode_atts(array(
		"records_per_page"  => '8',
		"columns"           => '2',
		"category"          => '',
		"style"             => 'text-normal',
		"title"             => '',
        "class"             => '',
        "type"              => 'normal',
		"image_height"      => 'auto',
		"show_date"         => 'true',
		"excerpt"           => 'true',
        "button_text"       => '',
        "button_url"        => ''
	), $atts);

	ob_start();
    
    if( 'normal' == $atts['type'] ) :
	?>

    <div class="alumni-story">
        <div class="container">
                <?php
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array(
                            'post_status'       => 'publish',
                            'post_type'         => 'story',
                            'category_name'     => $category,
                            'posts_per_page'    => $records_per_page,
                            'paged'             => $paged
                        );
                        $postCount = 0;
                        $recentPosts = new WP_Query( $args );
                        
                        if ( $recentPosts->have_posts() ) : ?>

                            <?php while( $recentPosts->have_posts() ) : $recentPosts->the_post();
                            $meta = get_post_meta( get_the_ID() ); ?>
                            <?php if( $postCount == 0 ) { ?>
                            <div class="row">
                            <?php } ?>
                            <div class="col-sm-<?php echo (12 / intVal( $columns ) );?> col-xs-12">
                                <div class="alumni-story-wrapper">
                                    <div class="alumni-story-img" >
                                        <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('madang-story', array('class' => 'img-responsive')); ?></a>
                                    </div>
                                    <div class="alumni-story-content">
                                        <h3 class="heading-regular"><a href="<?php the_permalink() ?>"><?php if ( isset( $meta['_name'] ) ) { echo esc_attr( $meta['_name'][0] ).': '; } the_title(); ?></a></h3>
                                        <?php if($excerpt != 'false') { ?>
                                        <p class="text-light"><?php
                                            $excerpt = get_the_excerpt();
                                            echo madang_string_limit_words($excerpt, 18) . '[...]';
                                            ?>
                                        </p>
                                        <?php } ?>
                                        <?php if($show_date != 'false') { ?>
                                        <span class="dates text-light"><?php echo get_the_time('M', get_the_ID()); ?> <?php echo get_the_time('d', get_the_ID()); ?>, <?php echo get_the_time( 'Y', get_the_ID() ); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php if( $postCount == ( intVal( $columns ) - 1 ) ) { ?>
                            </div>
                            <?php } ?>
                            <?php if( $postCount == ( intVal( $columns ) - 1 ) ) {
                                $postCount = 0;
                            }else{
                                $postCount ++;
                            }
                            ?>
                            <?php endwhile; // end of the loop. ?>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                        <?php madang_pagination( $recentPosts ); ?>

        </div><!-- col -->
    </div><!-- row -->

	<?php
    elseif( 'minified' == $atts['type'] ) :
    ?>

    <!-- ============== blog block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> blog-block">
        <div class="container">
            <!-- == top header text starts == -->
            <div class="top-text-header text-center wow fadeInUp">
                <h4 class="text-uppercase text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h4>
            </div>
            <!-- == top header text ends == -->
            <!-- == blog row starts == -->
            <div class="row">
                <?php
                $args = array(
                  'post_status' => 'publish',
                  'post_type' => 'post',
                  'category_name' => $atts['category'],
                  'posts_per_page' => $atts['records_per_page'],
                  );
                  $postCount = 0;
                  $recentPosts = new WP_Query( $args );
                  if ( $recentPosts->have_posts() ) :
            
                    while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?>
                    <!-- blog single starts -->
                    <div class="col-xs-12 col-sm-4 wow fadeInLeft blog-single">
                        <div class="blog-single-wrap">
                            <?php if  ( has_post_thumbnail() ) : ?>
                                <figure><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('madang-blog-minified', array('class' => 'img')); ?></a></figure>
                            <?php endif; ?>
                        </div>
                        <div class="blog-description <?php if  ( !has_post_thumbnail() ){ echo 'post-desc-wrapper-wide'; } ?>">
                            <h6 class="text-uppercase"><a href="<?php the_permalink() ?>" class="text-lt text-sp"><?php echo get_the_title(); ?></a></h6>
                            <span class="posted-date"><?php echo get_the_time('M', get_the_ID()); ?> <?php echo get_the_time('d', get_the_ID()); ?>, <?php echo get_the_time( 'Y', get_the_ID() ); ?></span>
                            <p><?php echo madang_string_limit_words( get_the_excerpt(), 30 ). '[...]';  ?></p>
                            <span class="comments-count"><?php echo comments_number( esc_html__( 'no comments', 'madang' ), esc_html__( 'one comment', 'madang' ), '% ' . esc_html__( 'comments', 'madang' ) ); ?></span>
                            <a href="<?php the_permalink() ?>" class="text-capitalize pull-right read-more-btn text-lt text-sp txcolor"><?php esc_html_e( 'read more', 'madang' ); ?></a>
                        </div>
                    </div>
                    <?php
                    endwhile;
                  endif;
                  wp_reset_postdata(); 
                  ?>
            </div>
            <!-- == blog row ends == -->
        </div>
    </section>
    <!-- ============== blog block ends ============== -->
    <?php
    endif;    
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}
