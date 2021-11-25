<?php

/*
Widget Name: Madang Meal Plan Widget
Description: Create Meal Plan Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_mealplan_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_mealplan_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Meal Plan', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create mealplan Signup Section', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'id' => array(
                    'type' => 'text',
                    'label' => esc_html__('Meal Plan ID', 'madang'),
                    'description' => esc_html__('Go to Programs > Programs section and pick id from program list', 'madang'),
                    'default' => ''
                ),
                'tags' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose tag behaviour', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'hide' => esc_html__( 'Hide tags', 'madang' ),
                        'show' => esc_html__( 'Show tags', 'madang' ),
                        'link' => esc_html__( 'Show tags and make them clickable', 'madang' ),     
                    )
                ),
          
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-mealplan';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_mealplan_widget', __FILE__, 'madang_mealplan_widget');

endif;