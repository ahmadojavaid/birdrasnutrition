<?php
/*
Widget Name: Madang CTA Widget
Description: Create CTA Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_cta_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_cta_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang CTA', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create CTA Section', 'madang'),
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
                'button_url' => array(
                    'type' => 'link',
                    'label' => esc_html__('Button Link', 'madang'),
                    //'description' => esc_html__('May not apply to all banner types', 'madang'),
                    'default' => '#'
                ),
                'button_text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Button Text', 'madang'),
                    //'description' => esc_html__('May not apply to all banner types', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-cta';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_cta_widget', __FILE__, 'madang_cta_widget');

endif;

function madang_shortcode_cta( $atts, $content = null ) {
	$atts = shortcode_atts(array(
		"image"         => '',
		"title"         => '',
		"subtitle"      => '',
		"image"         => '',
		"button_text"   => '',
        "button_url"    => '#',
        "icon"       => ''
	), $atts);

	ob_start();

    $icon = '';
    if( '' != $atts['icon'] ){
        $icon = get_template_directory_uri() .'/images/'.$atts['icon'];
    }
    ?>

    <!--try-block-->
    <section class="wide_section">
        <div class="container">
            <div class="try-block text-center">
                <h3><?php echo esc_attr( $atts['title'] ); ?></h3>
                <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn hvr-wobble-skew bgcolor bghcolor"><?php echo esc_attr( $atts['button_text'] ); ?></a>
            </div>
        </div>
    </section>
    <!--try block ends-->

    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}