<?php
function madang_custom_css() {
    
    global $madang_main_color;
    $madang_main_color = '#60ba62';
    $madang_sub_color = '#f7ca18';
    if ( get_theme_mod( 'madang_main_color' ) ) :
        $madang_main_color = get_theme_mod( 'madang_main_color' );
    endif;

    if ( get_theme_mod( 'madang_sub_color' ) ) :
        $madang_sub_color = get_theme_mod( 'madang_sub_color' );
    endif;
    
    ob_start();
?>
.no-js #loader {display: none;}.js #loader { display: block; position: absolute; left: 100px; top: 0;}.se-pre-con {position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url(<?php echo get_template_directory_uri(); ?>/images/Preloader_4.gif) center no-repeat #fff;}

h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover {color: <?php echo esc_html( $madang_main_color ); ?>;}
input[type=submit], button {background: <?php echo esc_html( $madang_main_color ); ?>;}
blockquote {color: <?php echo esc_html( $madang_main_color ); ?>;}
input:focus, textarea:focus, select:focus {border: 1px solid <?php echo esc_html( $madang_main_color ); ?>;}
select {border: 1px solid #66ab79;color: <?php echo esc_html( $madang_main_color ); ?>;}
.bx-wrapper .bx-pager.bx-default-pager a:hover, .bx-wrapper .bx-pager.bx-default-pager a.active {background: <?php echo esc_html( $madang_main_color ); ?>;}

.blog-admin .admin:hover {color: <?php echo esc_html( $madang_main_color ); ?>;}
.pagination-wrapper ul li a, .pagination-wrapper ul li span {border: 1px solid <?php echo esc_html( $madang_main_color ); ?>;color: <?php echo esc_html( $madang_main_color ); ?>;}
.pagination-wrapper ul li a.current, .pagination-wrapper ul li span.current, .pagination-wrapper ul li a:hover, .pagination-wrapper ul li span:hover {background: <?php echo esc_html( $madang_main_color ); ?>;color: #fff;}
.sidebar-widget>h6 {color: <?php echo esc_html( $madang_main_color ); ?>;}
.sidebar-widget h6 a:hover {color: <?php echo esc_html( $madang_main_color ); ?>;}
.archives li a:hover, .archives li a:hover span {color: <?php echo esc_html( $madang_main_color ); ?>;}
blockquote { border-left: 4px solid <?php echo esc_html( $madang_main_color ); ?>;}

.sticky .blog-post .area-content h2{border-left:4px solid <?php echo esc_html( $madang_main_color ); ?>;}
.bottom-footer{background-color: <?php echo madang_adjust_brightness( esc_html( $madang_main_color ), -30); ?>;}
.member-wrap:hover .member-info{background-color: <?php echo esc_html( $madang_main_color ); ?>;}
.member-wrap figure:before{border: 1px solid <?php echo esc_html( $madang_main_color ); ?>;}
.navbar-default .navbar-nav .sub-menu li a:hover{color:<?php echo esc_html( $madang_main_color ); ?>;}
.support-tab .nav-tabs>li.active a{background-color: <?php echo esc_html( $madang_main_color ); ?>}
.fun-fact .box{border-color: <?php echo esc_html( $madang_main_color ); ?>;}
.nav>li>a:hover,
.nav>li>a:focus,
.nav-tabs>li.active>a,
.nav-tabs>li.active>a:hover,
.nav-tabs>li.active>a:focus{color:<?php echo esc_html( $madang_main_color ); ?>;}
.nav-tabs>li>a:after, .food-listing-group .food-listing-row:nth-child(2n+1) figure:before,.ui-widget-header,.ui-slider .ui-slider-handle{background-color:<?php echo esc_html( $madang_main_color ); ?>}
.food-listing-group .food-listing-row:nth-child(2n) figure:before{background-color:<?php echo esc_html( $madang_sub_color ); ?>}
.product-single .woocommerce-Price-amount,.woocommerce ul.products li.product span.woocommerce-Price-amount,.woocommerce a.btn_white,.woocommerce-message:before{color:<?php echo esc_html( $madang_main_color ); ?>;}
.woocommerce ul.products li.product a.button,.woocommerce button.button.alt, .woocommerce input.button.alt,.widget a:hover,.menu-listing-wrap .menu-item-wrap h4 a:hover, .menu-listing-wrap .menu-item-wrap h4.price, .menu-listing-wrap .menu-item-wrap h3.price,.tool-bar .action-btn-wrap .btn:hover, .tool-bar .action-btn-wrap .btn.active, .tool-bar .action-btn-wrap .btn:focus,.woocommerce .pagination-wrapper ul li a:hover, .woocommerce .pagination-wrapper ul li.active a, .woocommerce .pagination-wrapper ul li span.current,ul.steps li.current a, ul.steps li.completed a, ul.steps li:hover a,.shop_table .product-price .woocommerce-Price-amount,.shop_table .coupon .button, .shop_table .actions .button,.cart-steps ul.steps a, .cart-steps ul.steps a span,.woocommerce-info:before,.menu-pop-up span.price,.woocommerce_checkout_place_order{color:<?php echo esc_html( $madang_main_color ); ?>;}
.woocommerce ul.products li.product a.button,.woocommerce button.button.alt, .woocommerce input.button.alt,select,.ui-slider .ui-slider-handle + .ui-slider-handle,.woocommerce a.btn_white,.woocommerce .pagination-wrapper ul li a:hover, .woocommerce .pagination-wrapper ul li.active a, .woocommerce .pagination-wrapper ul li span.current,.shop_table .coupon .button, .shop_table .actions .button,.cart-steps ul.steps .current a span, .cart-steps ul.steps a:hover span,.cart-steps ul.steps a span,.woocommerce-info,.woocommerce-message{border-color:<?php echo esc_html( $madang_main_color ); ?>;}
.woocommerce ul.products li.product a.button:hover,.woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,.navbar-default .navbar-nav>li>a:after,.side-cat-list li a, .side-cat-list li span:hover, .menu-sidebox-wrap li a.active, .side-cat-list li span.active,.woocommerce a.btn_white:hover,.shop_table .coupon .button:hover, .shop_table .actions .button:hover,.cart-steps ul.steps .current a span, .cart-steps ul.steps a:hover span,.woocommerce-cart .wc-proceed-to-checkout a.button.alt,.woocommerce a.btn, .woocommerce .site-content a.btn, .btn, input[type=submit], button{background-color: <?php echo esc_html( $madang_main_color ); ?>;}
button.alt.disabled{background-color: <?php echo esc_html( $madang_main_color ); ?>!important;}

.txcolor{color: <?php echo esc_html( $madang_main_color ); ?>}
.bgcolor{background-color: <?php echo esc_html( $madang_main_color ); ?>;}
.brcolor{border-color: <?php echo esc_html( $madang_main_color ); ?>;}
.txhcolor:hover{color: <?php echo esc_html( $madang_main_color ); ?>}
.bghcolor:hover{background-color: <?php echo esc_html( $madang_main_color ); ?>!important;}
.woocommerce a.btn_white:hover,
.brhcolor:hover{border-color: <?php echo esc_html( $madang_main_color ); ?>;}

.txcolors{color: <?php echo esc_html( $madang_sub_color ); ?>}
.bgcolors{background-color: <?php echo esc_html( $madang_sub_color ); ?>;}
.brcolors{border-color: <?php echo esc_html( $madang_sub_color ); ?>;}
.txhcolors:hover{color: <?php echo esc_html( $madang_sub_color ); ?>}
.bghcolors:hover{background-color: <?php echo esc_html( $madang_sub_color ); ?>;}
.brhcolors:hover{border-color: <?php echo esc_html( $madang_sub_color ); ?>;}
.panel-grid-cell{padding:0!important;}
.panel-grid{margin:0!important;}
.logo-block figure{overflow:visible;}

<?php
$font1 = get_theme_mod( 'madang_font1', '0' );
$font2= get_theme_mod( 'madang_font2', '0' );
$font3 = get_theme_mod( 'madang_font3', '0' );
if ( empty($font1) ) { $font1 = '0'; }
if ( empty($font2) ) { $font2 = '0'; }
if ( empty($font3) ) { $font3 = '0'; }

if ( '0' != $font1 || '0' != $font2 || '0' != $font3 ){
  $fonts_arr = madang_google_fonts();
}

if ( '0' !== $font3 ){ $font3 = $fonts_arr[$font3]; ?>
  body,p,div,strong,b,cite,ul li{font-family:'<?php echo esc_html( $font3 ); ?>'!important;}
<?php } 

if ( '0' !== $font1 ){ $font1 = $fonts_arr[$font1]; ?>
  h1, h2, h3, h4, h5, h6, h7{font-family:'<?php echo esc_html( $font1 ); ?>'!important;}
<?php } 

if ( '0' !== $font2 ){ $font2 = $fonts_arr[$font2]; ?>
  ul li a{font-family:'<?php echo esc_html( $font2 ); ?>'!important;}
<?php } ?>


.logo-block img {
    width: <?php echo get_theme_mod( 'madang_logo_width', '240' ); ?>px;
    height:auto;
}
@media (max-width: 767px) {
    .logo-block img {
        width: <?php echo get_theme_mod( 'madang_logo_mobile_width', '120' ); ?>px;=
        height:auto;
    }
}
.footer-logo img {
    width: <?php echo get_theme_mod( 'madang_footer_width', '203' ); ?>px;
    height:auto;
}
<?php
$buffer = ob_get_clean();
// Minify CSS
$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer );
$buffer = str_replace( ': ', ':', $buffer );
$buffer = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer );
wp_add_inline_style( 'madang-style', $buffer );
    
}