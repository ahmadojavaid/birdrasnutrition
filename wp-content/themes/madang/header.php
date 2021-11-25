<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Madang
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta name="author" content="Kenzap">
<?php if ( function_exists('wp_site_icon') ) { wp_site_icon(); } ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php $colored = get_theme_mod('madang_header_scheme', 'white');
$meta = get_post_meta( get_the_ID() );
if ( isset( $meta['_seo_desc'][0] ) ) : ?>
<meta name="description" content="<?php echo esc_html($meta['_seo_desc'][0]);?>">
<?php endif;
$enable_transparent = false;
if ( isset( $meta['_transparent_header'][0] ) ) {
    $enable_transparent = true;
} 
wp_head();
?>
</head>
<body <?php body_class(); ?> >
    
    <?php if ( class_exists( 'Kenzap_Plugin' ) ){ Kenzap_Plugin::get_demo_body(); } ?>

    <!-- loader image before page load starts -->
    <div class="se-pre-con"></div>
    <!-- loader image before page load ends -->
    <!-- main wrapper of the site starts -->
    <div class="wrapper">

        <!-- ============== Header starts ============== -->
        <header class="<?php if( is_admin_bar_showing() ) { echo " logged_ofset "; } echo esc_attr( $colored ); ?> noscroll <?php if ( $enable_transparent ) echo 'transparent'; ?> ">
            <div class="container">
                <div class="row">

                    <!-- ============== Left logo block starts ============== -->
                    <?php 
                    global $content_main;
                    $content_main = false;
                    if ( 'green' == $colored ) {
                        $imgurl = (get_theme_mod( 'madang_logo_footer', '' ));
                            if(empty($imgurl) || '' == $imgurl){

                                $imgurl = get_template_directory_uri() . '/images/madang-logo-white.svg';
                        }
                    }else{
                        $imgurl = (get_theme_mod( 'madang_logo', '' ));
                        if(empty($imgurl) || '' == $imgurl){

                            $imgurl = get_template_directory_uri() . '/images/madang-logo.svg';
                        }
                    }
                    $imgurl_mobile = (get_theme_mod( 'madang_logo_mobile', '' ));
                    if(empty($imgurl_mobile) || '' == $imgurl_mobile){

                        $imgurl_mobile = get_template_directory_uri() . 'images/logo-small.png';
                    }
                    ?>
                    <div class="col-xs-12 col-sm-3 logo-block">
                        <figure>
                            <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='<?php echo esc_attr__( 'home', 'madang' ); ?>'><img class="original_size" src='<?php echo esc_url( $imgurl ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'></a>
                        </figure>
                    </div>
                    <!-- ============== Left logo block ends ============== -->

                    <!-- ============== Main navigation starts ============== -->
                    <div class="col-xs-12 <?php if ( '' != get_theme_mod( 'madang_dash_link', '' ) || 1 == get_theme_mod( 'madang_cart' )) { echo 'col-sm-7'; }else{ echo 'col-sm-9'; } ?> menu menu-block">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle">
                                        <span class="sr-only"><?php echo esc_attr__( 'Toggle navigation', 'madang' ); ?></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse">
                                    <ul class="nav navbar-nav text-right sf-menu pull-right">
                                        <?php
                                        if ( has_nav_menu( 'primary' ) ) {
                                            wp_nav_menu(array(
                                                  'theme_location'  => 'primary',
                                                  'container'       => false,
                                                  'items_wrap'      => '%3$s',
                                                  'depth'           => 3,
                                                  ));
                                        }
                                        ?>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>
                        <div class="area-mobile-content visible-sm visible-xs">
                            <div class="mobile-menu" >
                            </div>
                        </div>
                    </div>

                    <?php if ( 1 == get_theme_mod( 'madang_cart' ) && class_exists( 'WooCommerce' ) ) :
                        global $woocommerce; ?>
                        <div class="col-xs-12 col-sm-2 nav-cart">
                            <a href="<?php echo esc_url( ((wc_get_cart_url()==get_site_url())?get_site_url()."/cart/":wc_get_cart_url()) ); ?>" class="cart-btn pull-right transition-none brcolor bghcolor brhcolor"><i class="fa fa-shopping-cart transition-none txcolor"></i> <span class="cart-count transition-none"><?php echo WC()->cart->get_cart_contents_count()."</span> <span class='cart-text transition-none'>".((WC()->cart->get_cart_contents_count()==1)?esc_attr__( 'Item', 'madang' ):esc_attr__( 'Items', 'madang' )); ?></span></a>
                        </div>
                    <?php else: ?>
                        <?php if ( '' != get_theme_mod( 'madang_dash_link' ) ) : ?>
                        <div class="col-xs-12 col-sm-2 nav-right-btn">
                            <a class="choose-plan brcolor txcolor bghcolor" href="<?php echo esc_attr( get_theme_mod( 'madang_dash_link' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'madang_dash_link_text', 'Choose Plan' ) ); ?></a>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <!-- ============== Main navigation ends ============== -->
                </div>
            </div>
        </header>
        <!-- ============== Header ends ============== -->
