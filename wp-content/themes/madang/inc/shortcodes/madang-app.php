<?php

/*
Widget Name: Madang App Widget
Description: Create App Promo Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_app_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_app_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang App', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create App Section', 'madang'),
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
                'subtitle' => array(
                    'type' => 'text',
                    'label' => esc_html__('Subtitle', 'madang'),
                    'default' => ''
                ),
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose app image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'app_store_link' => array(
                    'type' => 'link',
                    'label' => esc_html__('App Store Link', 'madang'),
                    'default' => '#'
                ),  
                'app_store_icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('App Store icon', 'madang'),
                    'description' => esc_html__('Go to you themes root folder > images', 'madang'),
                    'default' => ''
                ),          
                'play_market_link' => array(
                    'type' => 'link',
                    'label' => esc_html__('Play Market Link', 'madang'),
                    'default' => '#'
                ),
                'play_market_icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('Play Market icon', 'madang'),
                    'description' => esc_html__('Go to you themes root folder > images', 'madang'),
                    'default' => ''
                ),
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra Class', 'madang'),
                    'description' => esc_html__('Extra style class to apply to app', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-app';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_app_widget', __FILE__, 'madang_app_widget');

endif;

function madang_shortcode_app( $atts, $content = null ) {
	$atts = shortcode_atts(array(
		"image"         => '',
		"title"         => '',
		"subtitle"      => '',
		"image"         => '',
		"text"          => '',
        "source"        => 'true',
        "app_store_icon"    => '',
        "play_market_icon"  => '',
        "app_store_link"    => '',
        "play_market_link"  => ''
	), $atts);

	ob_start();

    $app_store_icon = '';
    if( '' != $atts['app_store_icon'] ){
        $app_store_icon = get_template_directory_uri() .'/images/'.$atts['app_store_icon'];
    }
    
    $play_market_icon = '';
    if( '' != $atts['play_market_icon'] ){
        $play_market_icon = get_template_directory_uri() .'/images/'.$atts['play_market_icon'];
    }
    ?>
    <!-- ============== download app block starts ============== -->
    <section class="download-app-block">
        <div class="container">
            <!-- left image starts -->
            <div class="wow fadeInLeft left-mobile">
                <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="Mobile phone" /></figure>
            </div>
            <!-- left image ends -->
            <!-- right text starts -->
            <div class="wow fadeInRight download-app-text">
                <div class="download-app-wrap">
                    <h4><a href="#" class="text-lt text-sp txcolor"><?php echo esc_attr( $atts['title'] ); ?></a></h4>
                    <h2 class="text-lt text-sp"><?php echo esc_attr( $atts['subtitle'] ); ?></h2>
                    <p><?php echo esc_attr( $atts['text'] ); ?></p>
                    <div class="download-from">
                        <a href="<?php echo esc_url( $atts['app_store_link'] ); ?>" target="_blank" class="pull-left" ><img src="<?php echo esc_url( $app_store_icon ); ?>" alt="<?php echo esc_html__( 'App store', 'madang' ); ?>" /></a>
                        <a href="<?php echo esc_url( $atts['play_market_link'] ); ?>" target="_blank" class="pull-left" ><img src="<?php echo esc_url( $play_market_icon ); ?>" alt="<?php echo esc_html__( 'Google Play', 'madang' ); ?>" /></a>
                    </div>
                </div>
            </div>
            <!-- right text ends -->
        </div>
    </section>
    <!-- ============== download app block ends ============== -->
    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}