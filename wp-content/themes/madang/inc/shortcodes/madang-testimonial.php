<?php

/*
Widget Name: Madang Testimonials Widget
Description: Create Testimonials Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_testimonial_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_testimonial_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Testimonial', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Different testimonials', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose testimonial type from selection below', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'normal' => esc_html__( 'Normal', 'madang' ),
                        'compact' => esc_html__( 'Compact', 'madang' ),    
                    )
                ),
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
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose background image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add testimonials record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup testimonials record', 'madang' ),
                    'item_label' => array(
                        'selector'     => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'author' => array(
                            'type' => 'text',
                            'label' => esc_html__('Author', 'madang'),
                            'default' => ''
                        ),
                        'author_image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Choose author image', 'madang' ),
                            'choose' => esc_html__( 'Choose image', 'madang' ),
                            'update' => esc_html__( 'Set image', 'madang' ),
                            'library' => 'image',
                            'fallback' => true
                        ),
                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__('Title', 'madang'),
                            //'description' => esc_html__('Icons are located in in your themes root folder > images', 'madang'),
                            'default' => ''
                        ),
                        'text' => array(
                            'type' => 'text',
                            'label' => esc_html__('Text', 'madang'),
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
        return 'madang-testimonial';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_testimonial_widget', __FILE__, 'madang_testimonial_widget');

endif;

function madang_shortcode_testimonial( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "text" => ''
    ), $atts );

    ob_start();
    ?> 
    <?php if( 'compact' == $atts['type'] ) : ?>
    <!-- ============== testimonial block starts ============== -->
    <section class="full-width-testimonial">
        <div class="container">
            <div class="text-center top-text-header">
                <h3 class="text-capitalize light-font"><?php echo esc_attr( $atts['title'] ); ?></h3>
                <p><?php echo esc_attr( $atts['text'] ); ?></p>
            </div>
            <div class="row text-center testimonial-wrap">
                <?php echo madang_fix_shortcode( $content ); ?>      
            </div>
        </div>
    </section>
    <!-- ============== testimonial block ends ============== -->
    <?php else: ?>
    <!-- ============== testimonials block starts ============== -->
    <section class="testimonials-block" style="background-image: url( <?php echo esc_url( $atts['image'] ); ?>);">
        <div class="container">
            <div class="text-center wow fadeInRight testimonials">
                <ul class="bxslider">
                    <?php echo madang_fix_shortcode( $content ); ?>
                </ul>
            </div>
        </div>
    </section>
    <!-- ============== testimonials block ends ============== -->
    <?php
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_testimonial_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
         "type" => '',
         "class" => '',
         "author" => '',
         "author_image" => '',
         "title" => '',
         "text" => '',
         "button_text" => '',
         "button_url" => '',
         ), $atts);
         
        ob_start();
        ?>
        <li>
            <h3><?php echo esc_attr( $atts['title'] ); ?></h3>
            <p><?php echo esc_attr( $atts['text'] ); ?></p>
            <div class="testimonial-author">
                <figure><img src="<?php echo esc_url( $atts['author_image'] ); ?>" alt="<?php echo esc_attr( $atts['author'] ); ?>" /></figure>
                <span class="writer"><?php echo esc_attr( $atts['author'] ); ?></span>
            </div>
        </li>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
}

function madang_shortcode_testimonial_compact( $atts, $content = null ) {
    $atts = shortcode_atts(array(
         "type" => '',
         "class" => '',
         "author" => '',
         "author_image" => '',
         "title" => '',
         "text" => '',
         "button_text" => '',
         "button_url" => '',
         ), $atts);
         
        ob_start();
        ?>
        <div class="col-xs-12 col-sm-5 testimonial-box-wrap">
            <div class="text-center testimonial-box">
                <figure><img src="<?php echo esc_url( $atts['author_image'] ); ?>" alt="<?php echo esc_attr( $atts['author'] ); ?>" /></figure>
                <h6><?php echo esc_attr( $atts['author'] ); ?></h6>
                <p><?php echo esc_attr( $atts['text'] ); ?></p>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
}