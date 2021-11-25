<?php

/*
Widget Name: Madang Main Content Widget
Description: Provides smooth scroll effect with top banner overflow
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_maincontent_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_maincontent_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Main Content Start', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Provides smooth scroll effect with top banner overflow', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'visibility' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Temporary hide effect of this record', 'madang' )
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-maincontent';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_maincontent_widget', __FILE__, 'madang_maincontent_widget');

endif;

function madang_shortcode_maincontent( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "container" => 'false'
    ), $atts );

    ob_start();
  
    if ( 'false' == $atts['container'] ): ?>
    <main>
        <?php echo madang_fix_shortcode($content); ?>
    </main>
    <?php elseif ( 'true' == $atts['container'] ): ?>
    <main>
        <div class="container">
            <?php echo madang_fix_shortcode($content); ?>
        </div>
    </main>

    <?php
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}