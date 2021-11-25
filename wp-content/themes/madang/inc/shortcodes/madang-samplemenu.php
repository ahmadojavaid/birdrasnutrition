<?php

/*
Widget Name: Madang Sample Menu Widget
Description: Create Sample Menu Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_samplemenu_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_samplemenu_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Sample Menu', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Sample Menu Section', 'madang'),
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
                'text' => array(
                    'type' => 'textarea',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),
                'action' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Default action', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'link' => esc_html__( 'Open link', 'madang' ),
                        'enlarge' => esc_html__( 'Enlarge image', 'madang' ),   
                    )
                ),

                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add new record here' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup record', 'madang' ),
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
                            'type' => 'text',
                            'label' => esc_html__('Text', 'madang'),
                            'default' => ''
                        ),
                        'button_url' => array(
                            'type' => 'link',
                            'label' => esc_html__('Link', 'madang'),
                            'description' => esc_html__('Link will only work if action "Open link" above is selected', 'madang'),
                            'default' => ''
                        ),
                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Choose banner image', 'madang' ),
                            'choose' => esc_html__( 'Choose image', 'madang' ),
                            'update' => esc_html__( 'Set image', 'madang' ),
                            'library' => 'image',
                            'fallback' => true
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
        return 'madang-samplemenu';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_samplemenu_widget', __FILE__, 'madang_samplemenu_widget');

endif;

function madang_shortcode_samplemenu( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "placeholder" => '',
        "class" => '',
        "button_url" => '',
    ), $atts );

    ob_start();
    ?> 
    
    <!-- ============== Sample menu block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> sample-menu-block">
        <div class="container">
            <div class="text-center top-description wow fadeInUp">
                <h3 class="text-uppercase text-center"><?php echo esc_attr( $atts['title'] ); ?></h3>
                <p><?php echo esc_attr( $atts['text'] ); ?></p>
            </div>
            <!-- == menu listing starts == -->
            <div class="row menu-listing">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
            <!-- == menu listing ends == -->
        </div>
    </section>
    <!-- ============== Sample menu block ends ============== -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_samplemenu_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
         "type" => '',
         "icon" => '',
         "title" => '',
         "image" => '',
         "action" => '',
         "text" => '',
         "class" => '',
         "url" => '',
         ), $atts);
         
         ob_start();


?>

<div class="col-xs-12 col-sm-3 menu-item wow fadeInUp">
    <div class="text-center menu-item-wrap">
        <figure><a <?php echo ( ( 'enlarge' == $atts['action'] )?'data-toggle="lightbox" data-gallery="samplemenu-gallery" class="lightbox"':"");?> href="<?php echo esc_url( $atts['url'] ); ?>"><img class="img-responsive" src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></a></figure>
        <h4><a href="<?php echo esc_url( $atts['url'] ); ?>" class="txcolor"><?php echo esc_attr( $atts['title'] ); ?></a></h4>
        <span><?php echo esc_attr( $atts['text'] ); ?></span>
    </div>
</div>

<?php
$content = ob_get_contents();
ob_end_clean();
return $content;
}