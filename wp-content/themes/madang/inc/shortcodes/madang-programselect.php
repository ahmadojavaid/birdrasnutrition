<?php

/*
Widget Name: Madang Program Finder Widget
Description: Create Powerfull Nutrition Program Search Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_programselect_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_programselect_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Program Finder', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Powerfull Nutrition Program Search Section', 'madang'),
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
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra class', 'madang'),
                    'default' => ''
                ),
                'button_text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Button text', 'madang'),
                    'default' => ''
                ),
                'action' => array(
                    'type' => 'text',
                    'label' => esc_html__('Button text', 'madang'),
                    'description' => esc_html__('Link to a page that contains program search shortcode', 'madang'),
                    'default' => '/search-program/'
                ),
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose front image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'background' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose background image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),   
                
                'relation' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Query relation', 'madang' ),
                    'default' => 'OR',
                    'options' => array(
                        '1' => esc_html__( 'List programs if at least any of the slugs is found.', 'madang' ),
                        '2' => esc_html__( 'List programs if all three different slugs match one program.', 'madang' ),
                    )
                ),

                'icon1' => array(
                    'type' => 'text',
                    'label' => esc_html__('First select field icon', 'madang'),
                    'description' => esc_html__('Go to themes root folder > images to find another icon', 'madang'),
                    'default' => ''
                ),
                'category1' => array(
                    'type' => 'text',
                    'label' => esc_html__('First select field category list', 'madang'),
                    'description' => esc_html__('Go to Programs > Categories section to find available category slugs. Separate values by ","', 'madang'),
                    'default' => ''
                ),
                'title1' => array(
                    'type' => 'text',
                    'label' => esc_html__('First select field title', 'madang'),
                    'description' => esc_html__('Separate values by ","', 'madang'),
                    'default' => ''
                ),


                'icon2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Second select field icon', 'madang'),
                    'description' => esc_html__('Go to themes root folder > images to find another icon', 'madang'),
                    'default' => ''
                ),
                'category2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Second select field category list', 'madang'),
                    'description' => esc_html__('Go to Programs > Categories section to find available category slugs. Separate values by ","', 'madang'),
                    'default' => ''
                ),
                'title2' => array(
                    'type' => 'text',
                    'label' => esc_html__('Second select field title', 'madang'),
                    'description' => esc_html__('Separate values by ","', 'madang'),
                    'default' => ''
                ),


                'icon3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Third select field icon', 'madang'),
                    'description' => esc_html__('Go to themes root folder > images to find another icon', 'madang'),
                    'default' => ''
                ),
                'category3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Third select field category list', 'madang'),
                    'description' => esc_html__('Go to Programs > Categories section to find available category slugs. Separate values by ","', 'madang'),
                    'default' => ''
                ),
                'title3' => array(
                    'type' => 'text',
                    'label' => esc_html__('Third select field title', 'madang'),
                    'description' => esc_html__('Separate values by ","', 'madang'),
                    'default' => ''
                ),               
            ),
            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-programselect';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_programselect_widget', __FILE__, 'madang_programselect_widget');

endif;

function madang_shortcode_programselect( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "subtitle" => '',
        "relation" => '1',
        "title" => '',
        "button_text" => '',
        "text" => '',
        "image" => '',
        "background" => '',
        "class" => '', 
        "action" => '', 
    ), $atts );

    ob_start();
    ?> 
    <!-- ============== select program block starts ============== -->
    <section class='<?php echo esc_attr( $atts['class'] ); ?> select-program-block' style="background: url(<?php echo esc_url( $atts['background'] ); ?>);">
        <div class='container'>
            <div class='row'>
                <div class="col-xs-12 col-sm-6 wow fadeInLeft left-image-block">
                    <figure><img class="img-responsive" src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
                </div>
                <div class="col-xs-12 col-sm-6 wow fadeInRight pull-right right-form-block">
                    <h3 class='text-uppercase text-sp'><?php echo esc_attr( $atts['title'] ); ?><br /><?php echo esc_attr( $atts['subtitle'] ); ?></h3>
                    <form action="<?php echo esc_attr( $atts['action'] ); ?>">
                        <?php echo madang_fix_shortcode($content); ?>
                        <fieldset>
                            <input type="hidden" name="rel" value="<?php echo esc_attr( $atts['relation'] ); ?>" />
                            <input type='submit' class='btn hvr-wobble-horizontal text-lt text-sp bghcolor' value='<?php echo esc_attr( $atts['button_text'] ); ?>' />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============== select program block ends ============== -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programselect_item( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "titles" => '',
        "select_program_categories" => '',
        "select_program_titles" => '',
        "text" => '',
        "image" => '',
        "class" => '', 
        "id" => '', 
    ), $atts );

    ob_start();
    ?> 
    <fieldset>
        <div class="select <?php echo esc_attr( $atts['class'] ); ?> text-lt text-sp">
            <select name="<?php echo esc_attr( $atts['id'] ); ?>" class="txcolor brcolor">
                <?php  
                $select_program_ids_arr = explode(",", $atts['select_program_categories'] );
                $select_program_titles_arr = explode(",", $atts['select_program_titles'] );
                $index = 0;
                foreach ($select_program_ids_arr as $program_id) {

                    echo '<option value="'.esc_attr( $select_program_ids_arr[$index] ).'">'.esc_attr( $select_program_titles_arr[$index] ).'</option>';
                    $index++;
                }
                ?>
            </select>
        </div>
    </fieldset>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
