<?php

/*
Widget Name: Madang Program Info Widget
Description: Create Nutrition Program Features and Description Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_programinfo_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_programinfo_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Program Info Widget', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Nutrition Program Features and Description Section', 'madang'),
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
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),
                'icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('Icon', 'madang'),
                    'description' => esc_html__('Go to themes root folder > images to find another icon', 'madang'),
                    'default' => ''
                ),
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add program feature record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup table group', 'madang' ),
                    'item_label' => array(
                        'selector'     => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'feature_name' => array(
                            'type' => 'text',
                            'label' => esc_html__('Feature name', 'madang'),
                            'default' => ''
                        ),
                        'feature_text' => array(
                            'type' => 'text',
                            'label' => esc_html__('Feature text', 'madang'),
                            'default' => ''
                        ),
                        'visibility' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Temporary hide this record', 'madang' )
                        ),
                    )
                )
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-programinfo';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_programinfo_widget', __FILE__, 'madang_programinfo_widget');

endif;

function madang_shortcode_programinfo($atts, $content = null) {
    $atts = shortcode_atts(array(
     "title" => '',
     "text" => '',
     "icon" => '',
    ), $atts);
    
    ob_start();
    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_template_directory_uri() .'/images/'.$atts['icon'];
    }
    ?>
    <section class="block weight-loss-block">
        <div class="container">
            <div class="text-center img-text-center">
                <figure><img class="img-responsive" src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
                <h3 class="text-capitalize"><?php echo esc_attr( $atts['title'] ); ?></h3>
                <p><?php echo esc_attr( $atts['text'] ); ?></p>
            </div>
            <ul>
                <?php echo madang_fix_shortcode($content); ?>
            </ul>
        </div>
    </section>
    <?php
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programinfo_feature($atts, $content = null) {
    $atts = shortcode_atts(array(
     "feature_name" => '',
     "feature_text" => '',
     "icon" => '',
    ), $atts);
    
    ob_start();
    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_template_directory_uri() .'/images/'.$atts['icon'];
    }
    
    echo '<li><span>' . esc_attr( $atts['feature_name'] ) . '</span>'. esc_attr( $atts['feature_text'] ) .'</li>';

    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}