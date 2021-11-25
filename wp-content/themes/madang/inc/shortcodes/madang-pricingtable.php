<?php

/*
Widget Name: Madang Pricing Table Widget
Description: Create Different Style Pricing Tables 
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_pricingtable_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_pricingtable_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Pricing Table', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Different Style Pricing Tables', 'madang'),
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
                'show_header' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Show title and select field', 'madang' )
                ),
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose pricing table group type from selection below', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'normal' => esc_html__( 'Normal', 'madang' ),
                        'banner' => esc_html__( 'Banner', 'madang' ),     
                    )
                ),
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose background image', 'madang' ),
                    'description' => esc_html__('Only applicable to banner pricing table group', 'madang'),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra Class', 'madang'),
                    'description' => esc_html__('Extra style class to apply to pricingtable', 'madang'),
                    'default' => ''
                ),
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => esc_html__( 'Add table group record' , 'madang' ),
                    'item_name'  => esc_html__( 'Click here to setup table group', 'madang' ),
                    'item_label' => array(
                        'selector'     => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table group title', 'madang'),
                            'description' => esc_html__('Note: this field is required for select filter', 'madang'),
                            'default' => ''
                        ),
                        'title1' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 title', 'madang'),
                            'default' => ''
                        ),
                        'popular1' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Make this table featuring', 'madang' )
                        ),
                        'price1' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 price', 'madang'),
                            'default' => ''
                        ),
                        'price_period1' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 price period', 'madang'),
                            'default' => ''
                        ),
                        'text11' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 text upper', 'madang'),
                            'default' => ''
                        ),
                        'text12' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 text middle', 'madang'),
                            'default' => ''
                        ),
                        'text13' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 text bottom', 'madang'),
                            'default' => ''
                        ),
                        'button_text1' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 1 button text', 'madang'),
                            'default' => ''
                        ),
                        'button_url1' => array(
                            'type' => 'link',
                            'label' => esc_html__('Table 1 button link', 'madang'),
                            'default' => '#'
                        ),
   

                        'title2' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 title', 'madang'),
                            'default' => ''
                        ),
                        'popular2' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Make this table featuring', 'madang' )
                        ),
                        'price2' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 price', 'madang'),
                            'default' => ''
                        ),
                        'price_period2' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 price period', 'madang'),
                            'default' => ''
                        ),
                        'text21' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 text upper', 'madang'),
                            'default' => ''
                        ),
                        'text22' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 text middle', 'madang'),
                            'default' => ''
                        ),
                        'text23' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 text bottom', 'madang'),
                            'default' => ''
                        ),
                        'button_text2' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 button text', 'madang'),
                            'default' => ''
                        ),
                        'button_url2' => array(
                            'type' => 'link',
                            'label' => esc_html__('Table 2 button link', 'madang'),
                            'default' => '#'
                        ),


                        'title3' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 title', 'madang'),
                            'default' => ''
                        ),
                        'popular3' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Make this table featuring', 'madang' )
                        ),                        
                        'price3' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 price', 'madang'),
                            'default' => ''
                        ),
                        'price_period3' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 price period', 'madang'),
                            'default' => ''
                        ),
                        'text31' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 2 text upper', 'madang'),
                            'default' => ''
                        ),
                        'text32' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 text middle', 'madang'),
                            'default' => ''
                        ),
                        'text33' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 text bottom', 'madang'),
                            'default' => ''
                        ),
                        'button_text3' => array(
                            'type' => 'text',
                            'label' => esc_html__('Table 3 button text', 'madang'),
                            'default' => ''
                        ),
                        'button_url3' => array(
                            'type' => 'link',
                            'label' => esc_html__('Table 3 button link', 'madang'),
                            'default' => '#'
                        ),
                        'popular3' => array(
                            'type' => 'checkbox',
                            'label' => esc_html__( 'Make this table featuring', 'madang' )
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
        return 'madang-pricingtable';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_pricingtable_widget', __FILE__, 'madang_pricingtable_widget');

endif;

function madang_shortcode_pricingtable( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "show_header" => '',
        "sort1_class" => '',
        "sort1_title" => '',
        "sort2_class" => '',
        "sort2_title" => '',
        "sort3_class" => '',
        "sort3_title" => '',
        "sort4_class" => '',
        "sort4_title" => '',
        "sort5_class" => '',
        "sort5_title" => '',
        "sort6_class" => '',
        "sort6_title" => '',
        "sort7_class" => '',
        "sort7_title" => '',
        "sort8_class" => '',
        "sort8_title" => '',
        "sort9_class" => '',
        "sort9_title" => ''
    ), $atts );

    ob_start();

    ?> 
    <?php if( 'banner' == $atts['type']) : ?>
    <!-- ============== pricing block starts ============== -->
    <section class="block pricing-block">
        <!-- top header text starts -->
        <div class="top-text-header text-center">
            <div class="text-center wow flipInX animated" >
                <select class="select-program  brcolor bgcolor">
                    <?php if( '' != $atts['sort1_class']) : ?> <option value="<?php echo esc_attr( $atts['sort1_class'] ); ?>"><?php echo esc_attr( $atts['sort1_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort2_class']) : ?> <option value="<?php echo esc_attr( $atts['sort2_class'] ); ?>"><?php echo esc_attr( $atts['sort2_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort3_class']) : ?> <option value="<?php echo esc_attr( $atts['sort3_class'] ); ?>"><?php echo esc_attr( $atts['sort3_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort4_class']) : ?> <option value="<?php echo esc_attr( $atts['sort4_class'] ); ?>"><?php echo esc_attr( $atts['sort4_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort5_class']) : ?> <option value="<?php echo esc_attr( $atts['sort5_class'] ); ?>"><?php echo esc_attr( $atts['sort5_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort6_class']) : ?> <option value="<?php echo esc_attr( $atts['sort6_class'] ); ?>"><?php echo esc_attr( $atts['sort6_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort7_class']) : ?> <option value="<?php echo esc_attr( $atts['sort7_class'] ); ?>"><?php echo esc_attr( $atts['sort7_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort8_class']) : ?> <option value="<?php echo esc_attr( $atts['sort8_class'] ); ?>"><?php echo esc_attr( $atts['sort8_title'] ); ?></option> <?php endif; ?>
                    <?php if( '' != $atts['sort9_class']) : ?> <option value="<?php echo esc_attr( $atts['sort9_class'] ); ?>"><?php echo esc_attr( $atts['sort9_title'] ); ?></option> <?php endif; ?>
                </select>
            </div>
        </div>
        <!-- top header text ends -->

        <!-- == pricing box starts == -->
        <div class="row">
            <?php echo madang_fix_shortcode($content); ?>
        </div>
        <!-- pricing box ends -->
    </section>
    <!-- ============== pricing block ends ============== -->
    <?php elseif( 'normal' == $atts['type']) : ?>
    <!-- ============== pricing block starts ============== -->
    <section class="block pricing-block">
        <div class="container">
            <!-- top header text starts -->
            <?php if ( 'true' == $atts['show_header'] ) : ?>
            <div class="top-text-header text-center">
                <h4 class="wow fadeInUp text-center animated text-uppercase text-lt text-sp" style="visibility: visible; animation-name: fadeInUp;"><?php echo esc_attr( $atts['title'] ); ?></h4>
                <div class="text-center  wow flipInX animated" >
                    <span class="select-program-title"><?php echo esc_attr( $atts['subtitle'] ); ?></span>
                    <select class="select-program text-lt text-sp txcolor brcolor">
                        <?php if( '' != $atts['sort1_class']) : ?> <option value="<?php echo esc_attr( $atts['sort1_class'] ); ?>"><?php echo esc_attr( $atts['sort1_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort2_class']) : ?> <option value="<?php echo esc_attr( $atts['sort2_class'] ); ?>"><?php echo esc_attr( $atts['sort2_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort3_class']) : ?> <option value="<?php echo esc_attr( $atts['sort3_class'] ); ?>"><?php echo esc_attr( $atts['sort3_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort4_class']) : ?> <option value="<?php echo esc_attr( $atts['sort4_class'] ); ?>"><?php echo esc_attr( $atts['sort4_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort5_class']) : ?> <option value="<?php echo esc_attr( $atts['sort5_class'] ); ?>"><?php echo esc_attr( $atts['sort5_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort6_class']) : ?> <option value="<?php echo esc_attr( $atts['sort6_class'] ); ?>"><?php echo esc_attr( $atts['sort6_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort7_class']) : ?> <option value="<?php echo esc_attr( $atts['sort7_class'] ); ?>"><?php echo esc_attr( $atts['sort7_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort8_class']) : ?> <option value="<?php echo esc_attr( $atts['sort8_class'] ); ?>"><?php echo esc_attr( $atts['sort8_title'] ); ?></option> <?php endif; ?>
                        <?php if( '' != $atts['sort9_class']) : ?> <option value="<?php echo esc_attr( $atts['sort9_class'] ); ?>"><?php echo esc_attr( $atts['sort9_title'] ); ?></option> <?php endif; ?>
                    </select>
                </div>
            </div>  
            <?php endif; ?>
            <!-- top header text ends -->
            <!-- == pricing box starts == -->
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
            <!-- pricing box ends -->
        </div>
    </section>
    <!-- ============== pricing block ends ============== -->
    <?php
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_pricingtable_item( $atts, $content=null ) {

    shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "text_left" => '',
        "text_right" => '',
        "placeholder" => '',
        "button_text" => '',
        "button_url" => '',
    ), $atts );

    ob_start();
    ?> 

    <!-- pricing box single starts -->
    <div class="<?php echo esc_attr( $atts['class'] ); ?>">
        <div class="text-center price-box-wrap <?php if ( strpos($atts['class'], 'popular') !== false ){ echo 'brcolors'; }else{ echo 'brcolor'; } ?>">
            <h5><?php echo esc_attr( $atts['title'] ); ?></h5>
            <div class="price-per-day">
                <span class="price <?php if ( strpos($atts['class'], 'popular') !== false ){ echo 'txcolors'; }else{ echo 'txcolor'; } ?>"><?php echo esc_attr( $atts['price'] ); ?></span>
                <span class="per-day <?php if ( strpos($atts['class'], 'popular') !== false ){ echo 'txcolors'; }else{ echo 'txcolor'; } ?>"><?php echo esc_attr( $atts['price_period'] ); ?></span>
            </div>
            <p><?php echo esc_attr( $atts['text1'] ); ?></p>
            <p><?php echo esc_attr( $atts['text2'] ); ?></p>
            <p><?php echo esc_attr( $atts['text3'] ); ?></p>
            <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn box-btn order-now-btn test-uppercase <?php if ( strpos($atts['class'], 'popular') !== false ){ echo 'bgcolors'; }else{ echo 'bgcolor'; } ?> "><?php echo esc_attr( $atts['button_text'] ); ?></a>
        </div>
    </div>
    <!-- pricing box single ends -->
  
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}