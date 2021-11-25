<?php

/*
Widget Name: Madang FAQ Widget
Description: Create Frequently Asked Questions Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_faq_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_faq_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang FAQ', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Frequently Asked Questions Section', 'madang'),
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
                    'label' => esc_html__('FAQ Title', 'madang'),
                    'description' => esc_html__('Go to Faq section > Add New to create your questions and anwsers', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-faq';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_faq_widget', __FILE__, 'madang_faq_widget');

endif;

function madang_shortcode_faq( $atts, $content = null ) {
	$atts = shortcode_atts(array(
        "show_header"   => 'true',
		"button_text"   => '',
        "per_page"      => '16',
        "type"          => ''
	), $atts);

	ob_start();
           
    $args = array(
        'post_type' => 'faq',
        'orderby' => 'madang_priority',
        'order' => 'ASC'
    );
    $recentPosts = new WP_Query( $args ); ?>
    <section class="wide_section">
     
        <div class="block support-tab">
            <div class="container">
                <ul class="nav nav-tabs row" role="tablist">
                    <?php if ( $recentPosts->have_posts() ) :
                        $count = 1;
                        $class = 'active';
                        while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); 

                            $image = get_post_meta( get_the_ID(), 'madang_icon');
                            ?>
                            <li class="<?php echo esc_attr($class); ?> col-xs-12 col-sm-3 wow fadeInLeft" data-wow-delay="0.<?php echo esc_attr($count-1);?>s">
                                <a href="#tab-content<?php echo esc_attr($count);?>" class="doc hvr-wobble-top txcolor bghcolor brcolor brhcolor" role="tab" data-toggle="tab">
                                    <i style="background: url(<?php echo get_template_directory_uri()."/images/".esc_attr( $image[0] ); ?>) no-repeat top center;"></i>
                                    <span><?php echo get_the_title(); ?></span>
                                </a>
                            </li>
                            <!-- ask health ends-->
                        <?php 
                        $class = '';
                        $count ++;
                        endwhile;
                    endif; ?>
                </ul>
            </div>

            <div class="tab-content-block">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            <div class="tab-content">

                                <?php if ( $recentPosts->have_posts() ) :
                                    $class = 'in active'; $wow = 'wow'; $count = 1; $countp = 1;
                                    while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?>

                                        <div role="tabpanel" class="tab-pane <?php echo esc_attr($class); ?>" id="tab-content<?php echo esc_attr($count);?>">
                                            <ul class="acdn accordion">

                                                <?php $entries = get_post_meta( get_the_ID(), 'madang_faq_group', true );
                                                $col_in = "";
                                                foreach ( (array) $entries as $key => $entry ) {

                                                    $img = $title = $meal_ids = $tags = '';
                                                    $image = '#';
                                                    if ( isset( $entry['title'] ) ) {
                                                        $title = esc_html( $entry['title'] );
                                                    }
                                                    if ( isset( $entry['description'] ) ) {
                                                        $description = esc_html( $entry['description'] );
                                                    }
                                                    if ( isset( $entry['tags'] ) ) {
                                                        $tags = esc_html( $entry['tags'] );
                                                    } ?>

                                                    <!--singel list-->
                                                    <li class="<?php echo esc_attr( $wow ); ?> fadeInLeft bghcolor">
                                                        <div class="link bghcolor"> <?php echo esc_attr( $title ); ?> <i class="fa fa-chevron-down"></i></div>
                                                        
                                                        <div class="detail">
                                                           <p><?php echo esc_html( $description ); ?></p>
                                                        </div>
                                                    </li>
                                                    <!--singel list ends-->

                                                <?php $countp ++; $col_in = '';                     
                                                } ?>

                                            </ul>
                                        </div>

                                    <?php 
                                    $class = ''; $wow = '';
                                    $countp = $countp * $count;
                                    $count ++;
                                    endwhile;
                                endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--tab block ends-->
        </div>
    </section>
    <?php
    wp_reset_postdata();
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}