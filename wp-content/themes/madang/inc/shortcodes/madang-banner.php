<?php

/*
Widget Name: Madang Banner Widget
Description: Create Different Styles Madang Banner
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_banner_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_banner_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Banner', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Different Banners', 'madang'),
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
                    'label' => esc_html__('Banner Title', 'madang'),
                    'default' => ''
                ),
                'subtitle' => array(
                    'type' => 'text',
                    'label' => esc_html__('Banner Subtitle', 'madang'),
                    'default' => ''
                ),
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Banner Text', 'madang'),
                    'default' => ''
                ),
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose banner type from selection below', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'simple' => esc_html__( 'Simple Banner', 'madang' ),
                        'parallax' => esc_html__( 'Parallax Banner', 'madang' ),
                        'aboutus' => esc_html__( 'About us Banner', 'madang' ),
                        'product' => esc_html__( 'Product Banner', 'madang' ),
                        'menu' => esc_html__( 'Menu Banner', 'madang' ),
                        'support' => esc_html__( 'Support Banner', 'madang' ),
                        'deal' => esc_html__( 'Special Deals Banner', 'madang' ),
                        'video' => esc_html__( 'Youtube Banner', 'madang' ),     
                    )
                ),
                'image' => array(
                    'type' => 'media',
                    'label' => esc_html__( 'Choose banner image', 'madang' ),
                    'choose' => esc_html__( 'Choose image', 'madang' ),
                    'update' => esc_html__( 'Set image', 'madang' ),
                    'library' => 'image',
                    'fallback' => true
                ),
                'button_url' => array(
                    'type' => 'link',
                    'label' => esc_html__('Button Link', 'madang'),
                    'description' => esc_html__('May not apply to all banner types', 'madang'),
                    'default' => '#'
                ),
                'button_text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Button Text', 'madang'),
                    'description' => esc_html__('May not apply to all banner types', 'madang'),
                    'default' => ''
                ),
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Extra Class', 'madang'),
                    'description' => esc_html__('Extra style class to apply to banner', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-banner';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_banner_widget', __FILE__, 'madang_banner_widget');

endif;

function madang_shortcode_banner( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "parallax" => '',
        "placeholder" => '',
        "button_text" => '',
        "button_url" => '',
        "class" => '',
        "video" => '',
    ), $atts );

    ob_start();

    if ( 'simple' == $atts['type'] ) :
    ?> 

    <!-- ============== Banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>"/></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><?php echo esc_attr( $atts['title'] ); ?><br/><strong class="txcolor"><?php echo esc_attr( $atts['subtitle'] ); ?></strong></h1>
            </div>
        </div>
    </section>
    <!-- ============== Baner ends ============== -->

    <?php
    elseif ( 'parallax' == $atts['type'] ) :
    ?>

    <!-- ============== Body banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> parallax-block wow fadeInUp <?php if ( 'true' == $atts['parallax'] ) { echo 'banner-parallax'; }else{ echo 'banner-noparallax'; } ?>" <?php if ( 'true' == $atts['parallax'] ) { echo 'data-parallax="scroll"'; } ?> data-image-src="<?php echo esc_url( $atts['image'] ); ?>" <?php if ( 'false' == $atts['parallax'] ) { } echo 'style="background: url(\'' . ( $atts['image'] ) . '\') no-repeat; background-size: cover;"'; ?> >
        <div class="parallax-block-text text-right">
            <div class="container">
                <h2 class="text-capitalize text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?><br /><?php echo esc_attr( $atts['subtitle'] ); ?></h2>
                <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn border-btn-big hvr-wobble-horizontal text-sp brcolor brhcolor txcolor bghcolor"><?php echo esc_attr( $atts['button_text'] ); ?></a>
            </div>
        </div>
    </section>
    <!-- ============== Body banner ends ============== -->

    <?php
    elseif ( 'pricing' == $atts['type'] ) :
    ?>

    <!-- ============== Banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner pricing-banner" style="background: url( <?php echo esc_url( $atts['image'] ); ?>) no-repeat fixed;">
        <div class="bannerwrap">
            <div class="container">
                <div class="banner-text text-center">
                    <?php echo madang_fix_shortcode( $content ); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- ============== Baner ends ============== -->

    <?php
    elseif ( 'aboutus' == $atts['type'] ) :
    ?>

    <!-- ============== About us Banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image about-us-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_url( $atts['title'] ); ?>" /></figure>
        </div>
    </section>
    <!-- ============== About us Baner ends ============== -->

    <?php
    elseif ( 'menu' == $atts['type'] ) :
    ?>

    <!-- ============== Sample menu banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner sample-menu-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><?php echo esc_attr( $atts['title'] ); ?><br><strong><?php echo esc_attr( $atts['subtitle'] ); ?></strong></h1>
            </div>
        </div>
    </section>
    <!-- ============== Sample menu banner starts ============== -->

    <?php
    elseif ( 'program' == $atts['type'] ) :
    ?>

    <!-- ============== Single program banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner single-program-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="Single program banner" /></figure>
        </div>
    </section>
    <!-- ============== Single program banner starts ============== -->

    <?php
    elseif ( 'deal' == $atts['type'] ) :
    ?>

    <!-- ============== Menu page banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image deal-page-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><strong class="txcolor"><?php echo esc_attr( $atts['title'] ); ?></strong></h1>
                <h2 class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle'] ); ?></h2>
            </div>
        </div>
    </section>
    <!-- ============== Menu page banner ends ============== -->

    <?php
    elseif ( 'nutrition' == $atts['type'] ) :
    ?>

    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner menu-single-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="Blog Banner" /></figure>
            <div class="banner-text text-center">
                <h2 class="text-uppercase txcolor"><?php echo esc_attr( $atts['title'] ); ?></h2>
                <span><?php echo esc_attr( $atts['subtitle'] ); ?></span>
            </div>
        </div>
    </section>

    <?php
    elseif ( 'support' == $atts['type'] ) :
    ?>

    <!-- ============== Menu page banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image support-page-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><?php echo esc_attr( $atts['title'] ); ?></h1>
                <p class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle'] ); ?></p>
            </div>
        </div>
    </section>
    <!-- ============== Menu page banner ends ============== -->

    <?php
    elseif ( 'product' == $atts['type'] ) :
    ?>

    <!-- ============== Menu page banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image menu-page-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><strong class="txcolor"><?php echo esc_attr( $atts['title'] ); ?></strong></h1>
                <p class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle'] ); ?></p>
            </div>
        </div>
    </section>
    <!-- ============== Menu page banner ends ============== -->

    <?php
    elseif ( 'video' == $atts['type'] ) :
    ?>

    <!-- ============== Menu page banner starts ============== -->
    <section style="overflow-y: hidden;" class="<?php echo esc_attr( $atts['class'] ); ?> banner banner-image health-banner">
        <div class="bannerwrap">
            <figure><img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure>
            <div class="banner-text text-center">
                <h1 class="text-uppercase"><strong><?php echo esc_attr( $atts['title'] ); ?></strong></h1>
                <p class="text-sp text-lt"><?php echo esc_attr( $atts['subtitle'] ); ?></p>

                <a href="#" class="btn btn-big btn-radius text-uppercase hvr-wobble-horizontal banner-video bgcolor" data-toggle="modal" data-target="#myModal"> <i class="fa fa-play-circle "></i><?php echo esc_attr( $atts['button_text'] ); ?></a>
            </div>
        </div>
    </section>
    <div class="video-banner-cont" >
        <div class="modal-dialog video-pop-up" role="document">
            <div class="modal-content"> 
                <div class="modal-body">
                 <iframe width="100%" height="315" src="<?php echo esc_url( $atts['video'] ); ?>" frameborder="0" allowfullscreen></iframe>
                </div>   
            </div>
          </div>
    </div>

    <!-- ============== Menu page banner ends ============== -->

    <?php
    elseif ( 'home' == $atts['type'] ) :
    ?>
    <!-- ============== Banner starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> banner home-banner home-banner1">
        <div class="bannerwrap">
            <div id="owl-demo">
                <?php echo madang_fix_shortcode( $content ); ?>
            </div>
        </div>
    </section>
    <!-- ============== Baner ends ============== -->
    <?php
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_slide( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "subtitle" => '',
        "text" => '',
        "button_text" => '',
        "button_url" => '', 
        "image" => '', 
    ), $atts );
    ob_start();
    ?> 

    <?php
    if ( 'text_left' == $atts['type'] ) :
    ?>
    <div class="item owl-left">
        <img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>">
        <div class="container">
            <div class="banner-text text-left">
                <h1 class="text-capitalize"><?php echo esc_html( $atts['title'] ); ?> <span class="txcolor"><?php echo esc_html( $atts['subtitle'] ); ?></span></h1>
                <p><?php echo esc_html( $atts['text'] ); ?></p>
                <?php if ( $atts['button_text']!='' ){ ?>
                <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn bgcolor bghcolors"><?php echo esc_html( $atts['button_text'] ); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    elseif ( 'text_center' == $atts['type'] ) :
    ?>
    <div class="item owl-center">
        <img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>">
        <div class="container">
            <div class="banner-text text-center">
                <h1 class="text-capitalize"><?php echo esc_html( $atts['title'] ); ?> <span class="txcolor"><?php echo esc_html( $atts['subtitle'] ); ?></span></h1>
                <?php if ( $atts['button_text']!='' ){ ?>
                <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn bgcolor bghcolors"><?php echo esc_html( $atts['button_text'] ); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    elseif ( 'text_right' == $atts['type'] ) :
    ?>
    <div class="item owl-right">
        <img src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>">
        <div class="container">
            <div class="banner-text text-right">
                <h1 class="text-capitalize"><?php echo esc_html( $atts['title'] ); ?> <span class="txcolor"><?php echo esc_html( $atts['subtitle'] ); ?></span></h1>
                <p><?php echo esc_html( $atts['text'] ); ?></p>
                <?php if ( $atts['button_text']!='' ){ ?>
                <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="btn bgcolor bghcolors"><?php echo esc_html( $atts['button_text'] ); ?></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php
    endif;
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
