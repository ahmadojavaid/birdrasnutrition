<?php

/*
Widget Name: Madang Feature Widget
Description: Create Feature Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_feature_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_feature_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Feature', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Feature Section', 'madang'),
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

                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add feature record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup feature record', 'madang' ),
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
                        'icon' => array(
                            'type' => 'text',
                            'label' => esc_html__('Icon', 'madang'),
                            'description' => esc_html__('Icons are located in in your themes root folder > images', 'madang'),
                            'default' => ''
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
        return 'madang-feature';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_feature_widget', __FILE__, 'madang_feature_widget');

endif;

function madang_shortcode_feature( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "placeholder" => '',
        "button_text" => '',
        "button_url" => '',
        ), $atts );

    ob_start();
    ?> 
    
    <!-- ============== Features block starts ============== -->
    <section class="block features-block">
        <div class="container">
            <div class="top-text text-center wow fadeInUp"><?php echo esc_attr( $atts['text'] ); ?></div>
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
        </div>
    </section>
    <!-- ============== Features block starts ============== -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_feature_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
       "type" => '',
       "icon" => '',
       "title" => '',
       "subtitle" => '',
       "text" => '',
       "class" => '',
       "placeholder" => '',
       "button_text" => '',
       "button_url" => '',
       ), $atts);

    ob_start();
    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_template_directory_uri() .'/images/'.$atts['icon'];
    }
    ?>
    <div class="col-xs-12 col-sm-4 features-item wow fadeInLeft <?php echo esc_attr( $atts['class'] ); ?>">
        <div class="feature-item-wrap text-center">
            <figure><a href="<?php echo esc_url( $atts['button_url'] ); ?>"><img class="img-responsive" src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></a></figure>
            <h5><a href="<?php echo esc_url( $atts['button_url'] ); ?>"><?php echo esc_attr( $atts['title'] ); ?></a></h5>
            <p><?php echo esc_attr( $atts['text'] ); ?>.</p>
            <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn hvr-wobble-horizontal bgcolor bghcolor"><?php echo esc_attr( $atts['button_text'] ); ?></a>
        </div>
    </div>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}