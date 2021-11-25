<?php

/*
Widget Name: Madang Slider Widget
Description: Create Different Styles Madang slider
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_slider_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_slider_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Slider', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Different Sliders', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra class', 'madang'),
                    'default' => ''
                ),
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add slider record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup slider', 'madang' ),
                    'item_label' => array(
                        'selector'     => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__('Title', 'madang'),
                            'default' => ''
                        ),
                        'text' => array(
                            'type' => 'textarea',
                            'label' => esc_html__('Text', 'madang'),
                            'default' => ''
                        ),
                        'subtitle' => array(
                            'type' => 'text',
                            'label' => esc_html__('Subtitle', 'madang'),
                            //'description' => esc_html__('Icons are located in in your themes root folder > images', 'madang'),
                            'default' => ''
                        ),
                        'type' => array(
                            'type' => 'radio',
                            'label' => esc_html__( 'Choose text location', 'madang' ),
                            'default' => 'simple',
                            'options' => array(
                                'text_left' => esc_html__( 'Text left', 'madang' ),
                                'text_center' => esc_html__( 'Text center', 'madang' ),
                                'text_right' => esc_html__( 'Text right', 'madang' ),
                            )
                        ),   
                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Choose slider image', 'madang' ),
                            'choose' => esc_html__( 'Choose image', 'madang' ),
                            'update' => esc_html__( 'Set image', 'madang' ),
                            'library' => 'image',
                            'fallback' => true
                        ),
                        'button_text' => array(
                            'type' => 'text',
                            'label' => esc_html__('Button text', 'madang'),
                            'default' => ''
                        ),
                        'button_url' => array(
                            'type' => 'link',
                            'label' => esc_html__('Button link', 'madang'),
                            'default' => '#'
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
        return 'madang-slider';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_slider_widget', __FILE__, 'madang_slider_widget');

endif;
