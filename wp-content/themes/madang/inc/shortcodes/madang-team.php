<?php

/*
Widget Name: Madang Team Widget
Description: Create Madang Team Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_team_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_team_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Team', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Team Section', 'madang'),
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
                    'type' => 'text',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add team member' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup team member', 'madang' ),
                    'item_label' => array(
                        'selector'     => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => esc_html__('Name', 'madang'),
                            'default' => ''
                        ),
                        'position' => array(
                            'type' => 'text',
                            'label' => esc_html__('Position', 'madang'),
                            'default' => ''
                        ),
                        'image' => array(
                            'type' => 'media',
                            'label' => esc_html__( 'Choose member image', 'madang' ),
                            'choose' => esc_html__( 'Choose image', 'madang' ),
                            'update' => esc_html__( 'Set image', 'madang' ),
                            'library' => 'image',
                            'fallback' => true
                        ),
                        'link' => array(
                            'type' => 'text',
                            'label' => esc_html__('Profile Link', 'madang'),
                            'default' => ''
                        ),
                        'facebook' => array(
                            'type' => 'text',
                            'label' => esc_html__('Facebook', 'madang'),
                            'default' => ''
                        ),
                        'googleplus' => array(
                            'type' => 'text',
                            'label' => esc_html__('Google plus', 'madang'),
                            'default' => ''
                        ),
                        'twitter' => array(
                            'type' => 'text',
                            'label' => esc_html__('Twitter', 'madang'),
                            'default' => ''
                        ),
                        'linkedin' => array(
                            'type' => 'text',
                            'label' => esc_html__('Linkedin', 'madang'),
                            'default' => ''
                        ),                        
                        'instagram' => array(
                            'type' => 'text',
                            'label' => esc_html__('Instagram', 'madang'),
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
        return 'madang-team';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_team_widget', __FILE__, 'madang_team_widget');

endif;

function madang_shortcode_team( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "class" => '',
        "button_text" => '',
        "button_url" => '',
        ), $atts );

    ob_start();
    ?> 
    <!-- ============== team member block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> team-member-block">
        <div class="container">
            <!-- == top header text starts == -->
            <div class="top-text-header wow fadeInUp text-center">
                <h4 class="text-uppercase text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h4>
                <p><?php echo esc_attr( $atts['text'] ); ?></p>
            </div>
            <!-- == top header text ends == -->
            <!-- == team member wrapper starts == -->
            <div class="row text-center">
                <?php echo madang_fix_shortcode( $content ); ?>
            </div>
            <!-- == team member wrapper ends == -->
        </div>
    </section>
    <!-- ============== team member block ends ============== -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_team_item( $atts, $content = null ) {
    $atts = shortcode_atts(array(
       "type" => '',
       "position" => '',
       "name" => '',
       "link" => '',
       "subtitle" => '',
       "text" => '',
       "class" => '',
       "image" => '',
       "facebook" => '',
       "googleplus" => '',
       "twitter" => '',
       "linkedin" => '',
       "instagram" => '',
       "button_text" => '',
       "button_url" => '',
       ), $atts);

    ob_start();
    ?>
    <!-- team member single starts -->
    <div class="col-xs-12 col-sm-4 col-md-3 wow fadeInLeft team-member-col">
        <div class="text-center member-wrap">
            <div class="member-info">
                <figure><a href="<?php echo esc_url( $atts['link'] ); ?>"><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['name'] ); ?>" /></a></figure>
                <h6 class="text-uppercase"><a class="text-lt text-sp" href="<?php echo esc_url( $atts['link'] ); ?>"><?php echo esc_attr( $atts['name'] ); ?></a></h6>
                <span class="designation text-capitalize"><?php echo esc_attr( $atts['position'] ); ?></span>
            </div>
            <div class="social-links">
                <ul>
                    <?php if ( $atts['facebook'] != '' ) { echo '<li><a href="'.esc_url( $atts["facebook"] ).'"><i class="fa fa-facebook hvr-wobble-top"></i></a></li>'; } ?>
                    <?php if ( $atts['googleplus'] != '' ) { echo '<li><a href="'.esc_url( $atts['googleplus'] ).'"><i class="fa fa-google-plus hvr-wobble-top"></i></a></li>'; } ?>
                    <?php if ( $atts['twitter'] != '' ) { echo '<li><a href="'.esc_url( $atts['twitter'] ).'"><i class="fa fa-twitter hvr-wobble-top"></i></a></li>'; } ?>
                    <?php if ( $atts['linkedin'] != '' ) { echo '<li><a href="'.esc_url( $atts['linkedin'] ).'"><i class="fa fa-linkedin hvr-wobble-top"></i></a></li>'; } ?>
                    <?php if ( $atts['instagram'] != '' ) { echo '<li><a href="'.esc_url( $atts['instagram'] ).'"><i class="fa fa-instagram hvr-wobble-top"></i></a></li>'; } ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- team member single ends -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
