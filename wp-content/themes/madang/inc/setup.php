<?php

if ( ! function_exists( 'madang_setup' ) ) :
function madang_setup() {

  /* add title tag support */
  add_theme_support( 'title-tag' );

  /* Add excerpt to pages */
  add_post_type_support( 'page', 'excerpt' );

  // wp-content/themes/madang-child-theme/languages/nb_NO.mo
  load_theme_textdomain( 'madang', get_stylesheet_directory() . '/languages' );

  /* load theme languages */
  load_theme_textdomain( 'madang', get_template_directory() . '/languages' );
  
  /* Add default posts and comments RSS feed links to head */
  add_theme_support( 'automatic-feed-links' );

  /* Add support for post thumbnails */
  add_theme_support( 'post-thumbnails' );

  /* Add support for HTML5 */
  add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'caption',
    'widgets',
  ) );
  
  /*  Enable support for Post Formats */
  add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif;
    
// madang_setup
add_action( 'after_setup_theme', 'madang_setup' );
add_image_size( 'madang-square', 583, 573, true );
add_image_size( 'madang-story', 569, 331, true );
add_image_size( 'madang-story-large', 1536, 637, true );
add_image_size( 'madang-minified', 262, 179, true );
add_image_size( 'madang-thumb', 93, 93, true );
add_image_size( 'madang-blog', 750, 405, true );
add_image_size( 'madang-thumb', 192, 132, true ); 
add_image_size( 'madang-gallery', 290, 290, true );
add_image_size( 'madang-gallery-carousel', 600, 388, true );
add_image_size( 'madang-blog-minified', 389, 258, true );
add_image_size( 'madang-product-small', 270, 270, true );
add_image_size( 'madang-aboutus-small', 321, 257, true );
add_image_size( 'madang-aboutus-large', 471, 543, true );
add_filter('jpeg_quality', function($arg){return get_theme_mod( 'madang_imgq', 90 );});

/*  Registrer menus. */
register_nav_menus( array(
      'primary' => esc_html__( 'Main Menu', 'madang' ),
      'primary_mobile' => esc_html__( 'Main Menu - Mobile', 'madang' ),
      'footer' => esc_html__( 'Footer Menu', 'madang' ),
      ) );
      
/**
 * Deactivate default widgets
 */
function madang_widgets_init() {

  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'madang' ),
    'id'            => 'sidebar-main',
    'description'   => esc_html__( 'Blog extension sidebar for core functionality', 'madang' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3><div class="tx-div small"></div>',
  ) );
}

add_action( 'widgets_init', 'madang_widgets_init' );

function madang_fonts_url() {
  
  $fonts_url = '';
  $montserrat = _x( 'on', 'Montserrat font: on or off', 'madang' );
   
  if ( 'off' !== $montserrat ) {
    $font_families = array();
     
    if ( 'off' !== $montserrat ) {
      $font_families[] = 'Montserrat:100,200,300,400,700';
    }

    $font1 = get_theme_mod( 'madang_font1', '0' );
    $font2 = get_theme_mod( 'madang_font2', '0' );
    $font3 = get_theme_mod( 'madang_font3', '0' );
    if ( empty($font1) ) { $font1 = '0'; }
    if ( empty($font2) ) { $font2 = '0'; }
    if ( empty($font3) ) { $font3 = '0'; }

    if ( '0' != $font1 || '0' != $font2 || '0' != $font3 ){
      $fonts_arr = madang_google_fonts();
    }

    if ( '0' !== $font1 ) {
      $font1 = $fonts_arr[$font1];
      $font_families[] = $font1;
    }

    if ( '0' !== $font2 ) {
      $font2 = $fonts_arr[$font2];
      $font_families[] = $font2;
    }

    if ( '0' !== $font3 ) {
      $font3 = $fonts_arr[$font3];
      $font_families[] = $font3;
    }

    $query_args = array(
      'family' => urlencode( implode( '|', $font_families ) ),
      'subset' => urlencode( 'latin,latin-ext' ),
    );
     
    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
  }
  return esc_url_raw( $fonts_url );
}

      
/* Setup madang Scripts and CSS */
function madang_scripts() {

  $theme = wp_get_theme('madang');
  $version = $theme['Version'];

  /* Ajax urls */
  $ajaxurl = '';
  if( in_array('sitepress-multilingual-cms/sitepress.php', get_option('active_plugins')) ){
      $ajaxurl .= admin_url( 'admin-ajax.php?lang=' . ICL_LANGUAGE_CODE );
  } else{
      $ajaxurl .= admin_url( 'admin-ajax.php');
  }

  /* Styles */
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() .'/css/bootstrap.min.css', array(), $version, 'all' ); 
  wp_enqueue_style( 'animate', get_template_directory_uri() .'/css/animate.css', array(), $version, 'all' );    
  wp_enqueue_style( 'hover', get_template_directory_uri() .'/css/hover.css', array(), $version, 'all' );
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() .'/css/font-awesome.css', array(), $version, 'all' );
  wp_enqueue_style( 'jquery-bxslider', get_template_directory_uri() .'/css/jquery.bxslider.css', array(), $version, 'all' );
  wp_enqueue_style( 'owl-carousel', get_template_directory_uri() .'/css/owl.carousel.css', array(), $version, 'all' );
  wp_enqueue_style( 'owl-transitions', get_template_directory_uri() .'/css/owl.transitions.css', array(), $version, 'all' );
  wp_enqueue_style( 'feature-carousel', get_template_directory_uri() .'/css/feature-carousel.css', array(), $version, 'all' );
  wp_enqueue_style( 'meanmenu', get_template_directory_uri() .'/css/meanmenu.css', array(), $version, 'all' );
  wp_enqueue_style( 'madang-fonts', madang_fonts_url(), array(), null );
  wp_enqueue_style( 'lightbox', get_template_directory_uri() .'/css/ekko-lightbox.min.css', array(), $version, 'all' );
  wp_enqueue_style( 'jquery-slider-custom', get_template_directory_uri() .'/css/jquery.slider.custom.css', array(), $version, 'all' );

  /* Load Custom styles CSS */
  wp_enqueue_style( 'madang-style', get_template_directory_uri().'/style.css', array(), $version, 'all');
  madang_custom_css();

  /* JS libaries */
  wp_enqueue_script( 'modernizr', get_template_directory_uri() .'/js/modernizr.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() .'/js/bootstrap.min.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'wow', get_template_directory_uri() .'/js/wow.min.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'Headroom', get_template_directory_uri() .'/js/Headroom.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-meanmenu', get_template_directory_uri() .'/js/jquery.meanmenu.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-parallax', get_template_directory_uri() .'/js/jquery.parallax-1.1.3.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-featureCarousel', get_template_directory_uri() .'/js/jquery.featureCarousel.min.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() .'/js/jquery.bxslider.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'owl-carousel', get_template_directory_uri() .'/js/owl.carousel.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'lightbox', get_template_directory_uri() .'/js/ekko-lightbox.min.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-custom-slider', get_template_directory_uri() .'/js/jquery.custom.slider.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() .'/js/jquery.waypoints.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() .'/js/jquery.counterup.js', array( 'jquery' ), $version, true );
  wp_enqueue_script( 'touch-punch', get_template_directory_uri() .'/js/touch-punch.js', array( 'jquery' ), $version, true );

  wp_enqueue_script( 'madang-script', get_template_directory_uri() .'/js/main.js', array( 'jquery' ), $version, true );
  $googleapis = get_theme_mod( 'madang_maps_api', '' );
  if ( !empty($googleapis) && '' != $googleapis ){
    wp_enqueue_script( 'maps.googleapis', 'https://maps.googleapis.com/maps/api/js?callback=initMap&key='.esc_attr( $googleapis ), array('jquery'), $version, true );
  }
  
  /* add JS variables to scripts */
  wp_localize_script( 'madang-script', 'screenReaderText', array(
      'expand'   => esc_html__( 'expand child menu', 'madang' ),
      'prev'  => esc_html__('Prev', 'madang'),
      'next'  => esc_html__('Next', 'madang'),
      'collapse' => esc_html__( 'collapse child menu', 'madang' ),
      'ajaxurl'  => $ajaxurl,
      'noposts'  => esc_html__('No records found', 'madang'),
      'loadmore' => esc_html__('Load more', 'madang')
  ) );
  wp_localize_script( 'madang-theme-js', 'ajaxURL',  array( 'ajaxurl'    => admin_url( 'admin-ajax.php' ) ) );
  wp_localize_script( 'madang-theme-js-minified', 'ajaxURL',  array( 'ajaxurl'    => admin_url( 'admin-ajax.php' ) ) );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
  
}
add_action( 'wp_enqueue_scripts', 'madang_scripts' );

    
function madang_image_dimensions() {
  global $pagenow;
 
  if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
    return;
  }
}    
add_action( 'after_switch_theme', 'madang_image_dimensions', 1 );

function madang_body_class( $classes ) {

    if ( '0' == get_theme_mod( 'sidebar_sprod', '1' ) ){
      $classes[] = 'rem-sidebar';
    }

    if ( 'left' == get_theme_mod( 'sidebar_location' ) ){
      $classes[] = 'left-sidebar';
    }else if ( 'right' == get_theme_mod( 'sidebar_location' ) ){
      $classes[] = 'right-sidebar';
    }

    //sidebar position
    return $classes;  
} 
add_filter( 'body_class', 'madang_body_class' );

//footer menu nav walker
class madang_footer_walker_nav_menu extends Walker_Nav_Menu {
    
    // add classes to ul sub-menus
    public $madang_depth_couter = 0;
    function __construct(){
        $this->madang_depth_couter = 0;
  
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        // depth dependent classes
        $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
        $display_depth = ( $depth + 1); // because it counts the first submenu as 0
        $classes = array(
                         'sub-menu',
                         ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
                         ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
                         'menu-depth-' . $display_depth
                         );
        $class_names = implode( ' ', $classes );
        
        // build html
        if($this->madang_depth_couter<4){
        $output .= "\n" . $indent . '<ul class="list-unstyled no-margin ' . $class_names . '">' . "\n";
      }
    }
    
    // add main/sub classes to li's and links

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
        
        // depth dependent classes
        $depth_classes = array(
                               ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
                               ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
                               ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
                               'menu-item-depth-' . $depth
                               );

        // passed classes
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
        
        
        // link attributes
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

        if($this->madang_depth_couter<4){
          if( $depth == 0 ) {
              
             
              $output .= "\n".'<div class="col-xs-12 col-sm-3 footer-links-col ' . $class_names . '">';
              $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                                     $args->before,
                                     $attributes,
                                     $args->link_before,
                                     apply_filters( 'the_title', $item->title, $item->ID ),
                                     $args->link_after,
                                     $args->after
                                     );
          }else{
              
              $output .= $indent . '<li class="' . $class_names . '">';
              $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                                     $args->before,
                                     $attributes,
                                     $args->link_before,
                                     apply_filters( 'the_title', $item->title, $item->ID ),
                                     $args->link_after,
                                     $args->after
                                     );
          }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
      }
    }
    
    function end_el(&$output, $item, $depth=0, $args=array()) {
        if( $depth == 0 ) {
            
            if($this->madang_depth_couter<4){
            $output .= "</div>\n";
             $this->madang_depth_couter++;
          }
        }
    }
}