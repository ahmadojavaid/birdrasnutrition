<?php


/*
Widget Name: Madang Video Widget
Description: Create Video Preview Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_video_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_video_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Video', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Video Preview Section', 'madang'),
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
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose background image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'source' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose playback video', 'madang' ),
                    'choose' => esc_html__( 'Choose video', 'madang' ),
                    'update' => esc_html__( 'Set video', 'madang' ),
                    'library' => 'video',
                    'fallback' => true
                ),
                //https://www.youtube.com/embed/rmGLw6OPTZ4?autoplay=1
                'url' => array(
                    'type' => 'text',
                    'label' => esc_html__('External link', 'madang'),
                    'description' => esc_html__('Override video with external link like youtube. Ex.: https://www.youtube.com/embed/rmGLw6OPTZ4?autoplay=1', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-video';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_video_widget', __FILE__, 'madang_video_widget');

endif;

function madang_shortcode_video( $atts, $content = null ) {
	$atts = shortcode_atts(array(
		"image"         => '',
		"title"         => '',
		"subtitle"      => '',
		"image"         => '',
		"button_text"   => '',
        "source"        => 'true',
        "icon"          => '',
        "url"           => '#'
	), $atts);

	ob_start();

    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_template_directory_uri() .'/images/'.$atts['icon'];
    }
    ?>
    <!-- ============== full width video block starts ============== -->
    <section class="full-width-video" >
        <div class="video-wrap" >
            <div class="video-bg" style="background-image: url(<?php echo esc_url( $atts['image'] ); ?>);" ></div>
            <!-- <img class="video-bg" alt="Madang demo video playback" src="<?php echo esc_url( $atts['image'] ); ?>"> -->
            <video id="bg-video" preload="auto" muted>
                <source src="<?php echo esc_url( $atts['source'] ); ?>" type="video/mp4" />
                <?php _e( 'Your browser doesn\'t support HTML5 video. Link to download the video:', 'madang' ); ?>
                <a href="<?php echo esc_url( $atts['source'] ); ?>"><?php echo esc_url( $atts['source'] ); ?></a>
            </video>
            <div class="video-text text-center video-controls">
                <a href="<?php echo esc_url( $atts['url'] ); ?>" target="blank" class="play-btn" id="<?php echo ((strlen($atts['url'])>5)?'':'play-video-btn'); ?>"><img src="<?php echo esc_url( $icon ); ?>" alt="Play button" /></a>
                <h2 class="text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h2>
            </div>
        </div>
    </section>
    <!-- ============== full width video block ends ============== -->
    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}