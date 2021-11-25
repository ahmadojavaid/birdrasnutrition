<?php


/*
Widget Name: Madang Counters Widget
Description: Create Counters Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_counters_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_counters_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Counters', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Counters Section', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'title1' => array(
                    'type' => 'text',
                    'label' => esc_html__('Title 1', 'madang'),
                    'default' => ''
                ),
                'count1' => array(
                    'type' => 'text',
                    'label' => esc_html__('Counter value 1', 'madang'),
                    'default' => ''
                ),
                'title2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Title 2', 'madang'),
                    'default' => ''
                ),
                'count2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Counter value 2', 'madang'),
                    'default' => ''
                ),
                'title3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Title 3', 'madang'),
                    'default' => ''
                ),
                'count3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Counter value 3', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-counters';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_counters_widget', __FILE__, 'madang_counters_widget');

endif;

function madang_shortcode_counters( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title1" => '',
        "title2" => '',
        "title3" => '',
        "subtitle" => '',
        "text" => '',
        "count1" => '',
        "count2" => '', 
        "count3" => '', 
    ), $atts );
    ob_start();
    ?> 

    <!--fun fact-->
    <section class="wide_section">
        <div class="fun-fact text-center brcolor narrow" data-counterup-nums="0">
            <div class="row">
                <div class="col-xs-12 col-sm-4 wow fadeInLeft">
                    <div class="brcolor box ">
                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/user-trust-icon.svg" alt="<?php echo esc_attr( $atts['title1'] ); ?>"></i>
                        <span data-counterup-nums="0" class="number counter txcolor"><?php echo esc_attr( $atts['count1'] ); ?></span>
                        <h6><?php echo esc_attr( $atts['title1'] ); ?></h6>
                    </div>
                </div>

                <div class="col-xs-12  col-sm-4 wow fadeInUp">
                     <div class="brcolor box brcolor">
                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/message-icon.svg" alt="<?php echo esc_attr( $atts['title2'] ); ?>"></i>
                        <span data-counterup-nums="0" class="number counter txcolor"><?php echo esc_attr( $atts['count2'] ); ?></span>
                        <h6><?php echo esc_attr( $atts['title2'] ); ?></h6>
                    </div>
                </div>

                <div class="col-xs-12  col-sm-4 wow fadeInRight">
                     <div class="brcolor box brcolor">
                        <i><img src="<?php echo get_template_directory_uri(); ?>/images/sucess-story-icon.svg" alt="<?php echo esc_attr( $atts['title3'] ); ?>"></i>
                        <span data-counterup-nums="0" class="number counter txcolor"><?php echo esc_attr( $atts['count3'] ); ?></span>
                        <h6><?php echo esc_attr( $atts['title3'] ); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--fun fact ends-->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}