<?php

/*
Widget Name: Madang Newsletter Widget
Description: Create Newsletter Signup Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_newsletter_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_newsletter_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Newsletter', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Newsletter Signup Section', 'madang'),
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
                    'label' => esc_html__('Newsletter title', 'madang'),
                    'default' => ''
                ),
                'subtitle' => array(
                    'type' => 'text',
                    'label' => esc_html__('Newsletter subtitle', 'madang'),
                    'default' => ''
                ),
                'placeholder' => array(
                    'type' => 'text',
                    'label' => esc_html__('Newsletter text', 'madang'),
                    'default' => ''
                ),
                'button_text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Button text', 'madang'),
                    //'description' => esc_html__('May not apply to all newsletter types', 'madang'),
                    'default' => ''
                ),
                'id' => array(
                    'type' => 'text',
                    'label' => esc_html__('Form ID', 'madang'),
                    'description' => esc_html__('Go to Mailchimp for WP > Forms to find your form id', 'madang'),
                    'default' => ''
                ),
          
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-newsletter';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_newsletter_widget', __FILE__, 'madang_newsletter_widget');

endif;

function madang_shortcode_newsletter( $atts, $content = null ) {
	shortcode_atts(array(
		"image"         => '',
		"title"         => '',
		"subtitle"      => '',
		"placeholder"   => '',
		"button_text"   => '',
        "parallax"      => 'true',
        "form_id"       => ''
	), $atts);

	ob_start();
	?>

    <!-- ============== Subscribe block starts ============== -->
    <section class="block subscribe-block text-center">
        <div class="container">
            <div class="subscribe-wrap">
                <div class="top-text wow fadeInUp">
                    <?php echo esc_attr( $atts['title'] ); ?>
                </div>
                <div class="subscribe-form wow fadeInDown">
                    <?php echo do_shortcode( '[mc4wp_form id="' . esc_attr( $atts['form_id'] ) . '"]' );?>
                </div>
            </div>
        </div>
    </section>
    <!-- ============== Subscribe block ends ============== -->

    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}