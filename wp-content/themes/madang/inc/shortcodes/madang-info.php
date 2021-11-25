<?php

/*
Widget Name: Madang Info Widget
Description: Create Brief Info Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_info_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_info_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Info', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Brief Info Section', 'madang'),
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
                'icon1' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Item icon 1', 'madang' ),
                    'description' => esc_html__('Icons are stored in your themes root folder > images', 'madang'),
                ),
                'link1' => array(
                    'type' => 'link',
                    'label' => esc_html__('Item link 1', 'madang'),
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
                'icon2' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Item icon 2', 'madang' ),
                    'description' => esc_html__('Icons are stored in your themes root folder > images', 'madang'),
                ),
                'link2' => array(
                    'type' => 'link',
                    'label' => esc_html__('Item link 2', 'madang'),
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
                'icon3' => array(
                    'type' => 'text',
                    'label' => esc_html__( 'Item icon 3', 'madang' ),
                    'description' => esc_html__('Icons are stored in your themes root folder > images', 'madang'),
                ),
                'link3' => array(
                    'type' => 'link',
                    'label' => esc_html__('Item link 3', 'madang'),
                    'default' => ''
                ),               
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-info';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_info_widget', __FILE__, 'madang_info_widget');

endif;

function madang_shortcode_info( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "title" => ''
        ), $atts );

    ob_start();
    ?> 

    <!-- ============== how it works block starts ============== -->
    <section class="block how-it-works-block">
        <div class="container">
            <div class="top-text text-center wow fadeInUp">
                <h4 class="text-uppercase text-sp text-lt"><?php echo esc_attr( $atts['title'] ); ?></h4>
            </div>
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
        </div>
    </section>
    <!-- ============== how it works block starts ============== -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_info_item( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "link" => '',
        "class" => '',
        "icon" => ''
        ), $atts );

    ob_start();

    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_stylesheet_directory_uri() .'/images/'.$atts['icon'];
    }
    ?>

    <div class="<?php echo esc_attr( $atts['class'] ); ?>">
        <div class="feature-item-wrap text-center">
            <figure><a href="<?php echo esc_url( $atts['link'] ); ?>"><img class="img-responsive" src="<?php echo esc_url( $icon  ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></a></figure>
            <h5><a href="<?php echo esc_url( $atts['link'] ); ?>"><?php echo esc_attr( $atts['title'] ); ?></a></h5>
            <p><?php echo esc_attr( $atts['text'] ); ?></p>
        </div>
    </div>
    
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}