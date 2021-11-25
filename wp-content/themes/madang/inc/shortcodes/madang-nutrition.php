<?php

/*
Widget Name: Madang Nutrition Widget
Description: Create Nutrition Table and Ingredients Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_nutrition_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_nutrition_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Nutrition Table', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Nutrition Table Section', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(

                'text' => array(
                    'type' => 'textarea',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'madang'),
                    'default' => ''
                ),
                'ingredients' => array(
                    'type' => 'textarea',
                    'label' => esc_html__('Ingredients', 'madang'),
                    'description' => esc_html__('Provide list of ingredients. Separate ingredients by ","', 'madang'),
                    'default' => ''
                ),
                'table_id' => array(
                    'type' => 'text',
                    'label' => esc_html__('Table ID', 'madang'),
                    'description' => esc_html__('Go to Nutrition section to find table id from the list', 'madang'),
                    'default' => ''
                ),
        
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-nutrition';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_nutrition_widget', __FILE__, 'madang_nutrition_widget');

endif;

function madang_shortcode_nutrition( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "text" => ''
    ), $atts );

    ob_start();
    ?> 
    <!-- =============== menu single block starts ================== -->
    <section class="block menu-single-block">
        <div class="container">
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?> 
            </div>
        </div>
    </section>
    <!-- =============== menu single block ends ================== -->

    <?php

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
