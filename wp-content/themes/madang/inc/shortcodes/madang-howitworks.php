<?php

/*
Widget Name: Madang How It Works Widget
Description: Create How It Works Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_howitworks_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_howitworks_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang How It Works', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create How It Works Section', 'madang'),
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
                'subtitle1' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item subtitle 1', 'madang'),
                    'default' => ''
                ),
                'text1' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item text 1', 'madang'),
                    'default' => ''
                ),

                'subtitle2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item subtitle 2', 'madang'),
                    'default' => ''
                ),
                'text2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item text 2', 'madang'),
                    'default' => ''
                ),

                'subtitle3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item subtitle 3', 'madang'),
                    'default' => ''
                ),
                'text3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item text 3', 'madang'),
                    'default' => ''
                ),

                'subtitle4' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item subtitle 4', 'madang'),
                    'default' => ''
                ),
                'text4' => array(
                    'type' => 'text',
                    'label' => esc_html__('Item text 4', 'madang'),
                    'default' => ''
                ),

            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-howitworks';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_howitworks_widget', __FILE__, 'madang_howitworks_widget');

endif;

function madang_shortcode_howitworks( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "subtitle1" => '',
        "subtitle2" => '',
        "subtitle3" => '',
        "subtitle4" => '',
        "text1" => '',
        "text2" => '',
        "text3" => '',
        "text4" => '', 
        "icon1" => '',
        "icon2" => '', 
        "icon3" => '', 
        "icon4" => '',  
    ), $atts );
    ob_start();
    ?> 

    <!-- how it work start -->
    <section class="wide_section">
        <div class="how-it-works narrow">
            <div class="container">
                <div class="top-text text-center wow fadeInUp">
                    <h3 class="text-uppercase text-sp text-lt"><strong><?php echo esc_attr( $atts['title'] ); ?></strong></h3>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-3 wow fadeInLeft" data-wow-delay="0.s">
                        <div class="text-center">
                            <figure><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/step1.svg" alt="step"></figure>
                            <h6 class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle1'] ); ?></h6>
                            <p><?php echo esc_attr( $atts['text1'] ); ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 wow fadeInLeft" data-wow-delay="0.1s">
                        <div class="text-center">
                            <figure><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/step2.svg" alt="step"></figure>
                            <h6 class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle2'] ); ?></h6>
                            <p><?php echo esc_attr( $atts['text2'] ); ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="text-center">
                            <figure><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/step3.svg" alt="step"></figure>
                            <h6 class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle3'] ); ?></h6>
                            <p><?php echo esc_attr( $atts['text3'] ); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-3 wow fadeInLeft" data-wow-delay="0.3s">
                        <div class="text-center">
                            <figure><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/step4.svg" alt="step"></figure>
                            <h6 class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle4'] ); ?></h6>
                            <p><?php echo esc_attr( $atts['text4'] ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- how it works ends-->  

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}