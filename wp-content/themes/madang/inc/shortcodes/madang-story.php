<?php

/*
Widget Name: Madang Story Widget
Description: Create Success Story Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_story_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_story_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Story', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Success Story Section', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(

                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add success story record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup story record', 'madang' ),
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
                        'subtitle' => array(
                            'type' => 'text',
                            'label' => esc_html__('Subtitle', 'madang'),
                            'default' => ''
                        ),
                        'text' => array(
                            'type' => 'textarea',
                            'label' => esc_html__('Text', 'madang'),
                            'default' => ''
                        ),
                        'before' => array(
                            'type' => 'text',
                            'label' => esc_html__('Before note', 'madang'),
                            'default' => ''
                        ),
                        'before_postfix' => array(
                            'type' => 'text',
                            'label' => esc_html__('Before note postfix', 'madang'),
                            'default' => ''
                        ),
                        'after' => array(
                            'type' => 'text',
                            'label' => esc_html__('After note', 'madang'),
                            'default' => ''
                        ),
                        'after_postfix' => array(
                            'type' => 'text',
                            'label' => esc_html__('After note postfix', 'madang'),
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
                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Choose member avatar', 'madang' ),
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
        return 'madang-story';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_story_widget', __FILE__, 'madang_story_widget');

endif;

function madang_shortcode_story( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        ), $atts );

    ob_start();
    ?> 

    <!--sucess sotry-->
    <section class="wide_section">
        <div class="block sucess-story narrow">
            <div class="box border">
                <ul class="sucess-slide">
                    <?php echo madang_fix_shortcode( $content ); ?>
                </ul>
            </div>
        </div>
    </section>
    <!-- sucess story ends-->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_story_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
       "type" => '',
       "title" => '',
       "subtitle" => '',
       "text" => '',
       "before" => '',
       "before_postfix" => '',
       "after" => '#',
       "after_postfix" => '#',
       "button_text" => '',
       "button_url" => '',
       "image" => '',
       ), $atts);

    ob_start();
    ?>
    <!--single slide -->
    <li> 
       <div class="row">
           <div class="col-xs-12 col-sm-7 left">
                <h2 class="name">
                    <?php echo esc_attr( $atts['title'] ); ?>
                    <span><?php echo esc_attr( $atts['subtitle'] ); ?></span>
                </h2>

                <p>
                    <?php echo esc_attr( $atts['text'] ); ?>
                </p>

                <div class="change-wrap">
                    <div>
                        <h6 class="font-reg text-sp"><?php echo esc_attr__('Before:','madang');?></h6>
                        <span class="gap"></span>
                        <span class="circle red"> <?php echo esc_attr( $atts['before'] ); ?> <span><?php echo esc_attr( $atts['before_postfix'] ); ?></span></span>
                    </div>

                    <div class="font-reg">
                        <h6 class="font-reg text-sp"><?php echo esc_attr__('After:','madang');?></h6>
                        <span class="gap"></span>
                        <span class="circle green"> <?php echo esc_attr( $atts['after'] ); ?> <span><?php echo esc_attr( $atts['after_postfix'] ); ?></span></span>
                    </div>

                    <span class="btn sucess btn-radius"> <i> <img src="<?php echo get_template_directory_uri(); ?>/images/check-circle.svg" alt="<?php echo esc_attr( $atts['button_text'] ); ?>"></i> <?php echo esc_attr( $atts['button_text'] ); ?></span>
                </div>
            </div>

           <div class="col-xs-12 col-sm-5 pull-right sucess-img text-right">
               <img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>">
           </div>
       </div>
    </li>
    <!--single slide ends--> 
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}