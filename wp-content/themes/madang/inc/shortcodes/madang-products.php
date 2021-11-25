<?php
/*
Widget Name: Flusi Products Widget
Description: Create Different Woocommerce Listing Previews
Author: Raloco
Author URI: http://raloco.com
Widget URI: http://raloco.com/,
Video URI: http://raloco.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_products_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_products_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Products', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Different productss', 'madang'),
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
                'show_header' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__('Show toolbar', 'madang'),
                    'default' => ''
                ),
                'category' => array(
                    'type' => 'text',
                    'label' => esc_html__('Category', 'madang'),
                    'description' => esc_html__('Restrict product listings to certain category', 'madang'),
                    'default' => ''
                ),
                'per_page' => array(
                    'type' => 'text',
                    'label' => esc_html__('Records per page', 'madang'),
                    'default' => ''
                ),
                'orderby' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose default sorting', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        '' => esc_html__( 'None', 'madang' ),
                        'popularity' => esc_html__( 'Popularity', 'madang' ),
                        'rating' => esc_html__( 'Rating', 'madang' ),
                        'newest' => esc_html__( 'Newest', 'madang' ),
                        'lowestprice' => esc_html__( 'Lowest price', 'madang' ),
                        'highestprice' => esc_html__( 'Highest price', 'madang' ),
                        'alphabetically' => esc_html__( 'Alphabetically', 'madang' ),
                    )
                ),      
                'remember' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__( 'Remember selections', 'madang' ),
                    'description' => esc_html__('Remember user selections even if the page is refreshed but resets "Choose default sorting" option.', 'madang'),
                    'default' => '1',
                ),          
                'widget' => array(
                    'type' => 'select',
                    'label' => esc_html__( 'Choose sidebar', 'madang' ),
                    'description' => esc_html__( 'Select which sidebar to use. You can change siderbar position from left to right under in Customizer > Advanced > Widget sidebar location', 'madang' ),
                    'default' => 'ecommerce-widget-area1',
                    'options' => array(
                        'ecommerce-widget-area1' => esc_html__( 'E-commerce Sidebar 1', 'madang' ),
                        'ecommerce-widget-area2' => esc_html__( 'E-commerce Sidebar 2', 'madang' ),
                        'ecommerce-widget-area3' => esc_html__( 'E-commerce Sidebar 3', 'madang' ),
 
                    )
                ),
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose product listing type', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'shop' => esc_html__( 'Shop', 'madang' ),
                    )
                ),
                'list_style' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Listing style', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'grid' => esc_html__( 'Grid', 'madang' ),
                        'list' => esc_html__( 'List', 'madang' ),
                    )
                ),
                'pagination' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Pagination/load more', 'madang' ),
                    'description' => esc_html__( 'When product list/grid ends choose load more products variant. Note, all requests are based on Ajax except when in pagination mode.', 'madang' ),
                    'default' => 'no',
                    'options' => array(
                        'no' => esc_html__( 'Nothing', 'madang' ),
                        'pagination' => esc_html__( 'Pagination buttons', 'madang' ),
                        //'loadmore' => esc_html__( 'Load More button', 'madang' ),
                    )
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-products';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_products_widget', __FILE__, 'madang_products_widget');

endif;

function madang_shortcode_products( $atts, $content = null ) {
	$atts = shortcode_atts(array(
		"image"         => '',
		"title"         => '',
        "category"      => '',
		"subtitle"      => '',
		"image"         => '',
        "show_header"   => 'true',
		"button_text"   => '',
        "per_page"      => '16',
        "time_left"     => '',
        "sizes"         => '',
        "colors"        => '',
        "price_min"     => '0',
        "list_style"    => 'list',
        "price_max"     => '1000',
        "badge"         => '',
        "columns"       => '4',
        "orderby"       => '',
        "remember"      => '',
        "pagination"    => 'no',
        "widget"        => 'ecommerce-widget-area1',
        "type"          => ''
	), $atts);

    if ( 1 == $atts['remember'] ){
        $atts['list_style'] = (strlen($_COOKIE["product_list"]) > 1 ) ? $_COOKIE["product_list"] : $atts['list_style'];
        $atts['category'] = ($_COOKIE["product_category"] != '' ) ? $_COOKIE["product_category"] : $atts['category'];
        $atts['orderby'] = ($_COOKIE["product_order"] != '' ) ? $_COOKIE["product_order"] : $atts['product_order'];
        $tag = ($_COOKIE["product_tag"] != '' ) ? $_COOKIE["product_tag"] : "";
        setcookie("product_list", $atts['list_style'], time()+3600);
    }

    if ( isset($_COOKIE["product_category_single"]) ){
        $atts['category'] = ($_COOKIE["product_category_single"] != '' ) ? $_COOKIE["product_category_single"] : $atts['category'];
    }

	ob_start();
 
    if ( 'minified' == $atts['type'] ) : 

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'posts_per_page'    => $atts['per_page'],
            'post_type'         => array('product'), //, 'product_variation'
            'paged'             => $paged,
        );

        $products = new WP_Query( $args );

        if ( $products->have_posts() ) : ?>
            <div class="newest list-popup">
                <div class="container">
                    <div class="row">
                        <?php while ($products->have_posts()) :
                            $products->the_post(); ?>
                            <div class="item col-md-3 col-sm-6 col-xs-12">
                                <div class="item-zoom">
                                    <a href="<?php echo the_permalink();?>" class="products-img list-links" >
                                        <?php the_post_thumbnail( 'madang-newest', array( 'class' => 'img-responsive' ) ); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div> 
                    <?php madang_pagination( $products ); ?>   
                    <div class="separates"></div>
                </div> 
            </div>  
        <?php endif;?>

    <?php elseif ( 'shop' == $atts['type'] ) :  ?>

        <?php if ( !is_admin() ){ wc_print_notices(); } ?>
        <section class="block menu-page-block">
            <div class="container">
                <?php if ( '' != $atts['show_header'] ) : ?>
                <!-- tool bar starts -->
                <div class="tool-bar wow fadeInUp">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                        <?php //product order sorting
                            $product_order = $atts['orderby'];
                            ?>

                            <fieldset>
                                <label><?php esc_attr_e( 'Sort By:', 'madang' ) ?></label>
                                <select id="product-sorting" class="cat" data-active="<?php echo esc_attr( $atts['orderby'] );?>">
                                    <option value=""><?php esc_attr_e( 'Default', 'madang' ) ?></option>
                                    <option <?php if($product_order=='popularity'){ echo 'selected'; }?> value="popularity"><?php esc_attr_e( 'Popularity', 'madang' ) ?></option>
                                    <option <?php if($product_order=='rating'){ echo 'selected'; }?> value="rating"><?php esc_attr_e( 'Rating', 'madang' ) ?></option>
                                    <option <?php if($product_order=='newest'){ echo 'selected'; }?> value="newest"><?php esc_attr_e( 'Newest', 'madang' ) ?></option>
                                    <option <?php if($product_order=='lowestprice'){ echo 'selected'; }?> value="lowestprice"><?php esc_attr_e( 'Lowest Price', 'madang' ) ?></option>
                                    <option <?php if($product_order=='highestprice'){ echo 'selected'; }?> value="highestprice"><?php esc_attr_e( 'Highest Price', 'madang' ) ?></option>
                                    <option <?php if($product_order=='alphabetically'){ echo 'selected'; }?> value="alphabetically"><?php esc_attr_e( 'Alphabetically', 'madang' ) ?></option>
                                </select>
                            </fieldset>

                            <fieldset>
                                <label><?php esc_attr_e( 'Display:', 'madang' ) ?></label>
                                <select id="product-records" class="num">
                                    <option slected value="<?php echo esc_html($atts['per_page']); ?>"><?php echo esc_html($atts['per_page']); ?></option>
                                    <option value="10">10</option>
                                    <option value="20">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </fieldset>

                            <div class="action-btn-wrap text-right pull-right">
                               <span id="products-grid" data-active="<?php echo esc_attr( $atts['list_style'] );?>" class="products-list-type btn hvr-wobble-top <?php if ( "grid" == $atts['list_style'] ){ echo 'active'; } ?>"><i class="fa fa-th"></i></span> 
                               <span id="products-list" class="products-list-type btn hvr-wobble-top <?php if ( "list" == $atts['list_style'] ){ echo 'active'; } ?>"><i class="fa fa-list-ul"></i></span> 
                            </div>
                        </div>
                    </div>
                </div>
                <!-- tool bar ends-->
                <?php endif; ?>
                
                <div class="row products-list-cont" >
                    <!-- menu left sidebar -->
                    <div class="menu-left-sidebar widget-area">

                        <?php if ( is_active_sidebar( $atts['widget'] ) ) : ?>
                            <ul id="ecommerce-sidebar">
                                <?php dynamic_sidebar( $atts['widget'] ); ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <!-- menu left ends -->

                    <!-- menu list right -->
                    <div id="product-content" class="products-area" data-per_page="<?php echo esc_html($atts['per_page']); ?>" data-pagenum_link="<?php echo get_pagenum_link(999999999); ?>" data-pagination="<?php echo esc_attr( $atts['pagination'] ); ?>" data-list_style="<?php echo esc_attr( $atts['list_style'] );?>" >

                        <?php 

                        //pagination
                        global $wpdb, $post, $wp_query;
                        $total_record = 100;
                        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                        $post_per_page  = $atts['per_page'];
                        $offset         = ($paged - 1)*$post_per_page;
                        $max_num_pages  = ceil($total_record/ $post_per_page);
                        $wp_query->found_posts = $total_record;


                        $product_cat_arr = array(
                                    'taxonomy'     => 'product_cat',
                                    'field'        => 'name',
                                    'terms'        => esc_attr( $atts['category'] )
                                );

                        $product_tag_arr = array(
                                    'taxonomy'     => 'product_tag',
                                    'field'        => 'name',
                                    'terms'        => esc_attr( $tag )
                                );

                        $args = array(
                                    'posts_per_page' => esc_attr( $atts['per_page'] ),
                                    'post_type' => array('product'), //, 'product_variation'
                                    'post_status' => 'publish',
                                    'meta_query' => array(),
                                    'paged'  => $paged,
                                    'ignore_sticky_posts' => 1,
                                    'tax_query'      => array( 'relation'      => 'AND' ), 
                                ); 

                        switch ( $product_order ) {
                            case 'lowestprice':
                                $args['meta_key'] = '_price';  
                                $args['orderby'] = array( 'meta_value_num' => 'ASC' );  
                            break;
                            case 'highestprice':
                                $args['meta_key'] = '_price';  
                                $args['orderby'] = array( 'meta_value_num' => 'DESC' );  
                            break;
                            case 'newest':
                                $args['orderby'] = array( 'date' => 'DESC' );   
                            break;
                            case 'popularity':
                                $args['orderby'] = 'meta_value_num';  
                                $args['order'] = 'DESC';
                                $args['orderby_meta_key'] = 'total_sales';
                            break;
                            case 'rating':
                                $args['orderby'] = 'meta_value_num';  
                                $args['order'] = 'DESC';
                                $args['orderby_meta_key'] = '_wc_average_rating';
                            break;
                            case 'rating':
                                $args['orderby'] = 'meta_value_num';  
                                $args['order'] = 'DESC';
                                $args['orderby_meta_key'] = '_wc_average_rating';
                            break;
                            case 'alphabetically':
                                $args['orderby'] = 'title'; 
                                $args['order'] = 'ASC';
                            break;
                            default:
                                $args['orderby'] = 'menu_order'; 
                                $args['order'] = 'ASC';
                            break;
                        }         

                        //product cat filter
                        if ( strlen($atts['category']) > 0 ) {

                            array_push( $args['tax_query'], $product_cat_arr ); 
                        } 

                        //product tag filter
                        if ( strlen($tag) > 0 ) {

                            array_push( $args['tax_query'], $product_tag_arr ); 
                        }

                        ?>

                        <?php if ( "list" == $atts['list_style'] ): ?>
                            <!--menu listing -->
                            <div class="row menu-listing-wrap list-view">

                                <?php

                                $products = new WP_Query( $args );

                                if ( $products->have_posts() ) :  ?>
                                    <?php while ($products->have_posts()) : $products->the_post();  

                                        $_product = wc_get_product( get_the_ID() );
                                        $metering = get_theme_mod( 'madang_metering', 'g' );
                                        $metering_cal = get_theme_mod( 'madang_calories', '' );

                                        global $wp;
                                        $current_url = home_url(add_query_arg(array(),$wp->request));

                                        $madang_title = get_post_meta( get_the_ID(), 'madang_title', '');
                                        if( sizeof($madang_title)==0 ) $madang_title[0] = '';

                                        $madang_calories = get_post_meta( get_the_ID(), 'madang_calories', '');
                                        if( sizeof($madang_calories)==0 ) $madang_calories[0] = '';

                                        $madang_proteins = get_post_meta( get_the_ID(), 'madang_proteins', '');
                                        if( sizeof($madang_proteins)==0 ) $madang_proteins[0] = '';

                                        $madang_fats = get_post_meta( get_the_ID(), 'madang_fats', '');
                                        if( sizeof($madang_fats)==0 ) $madang_fats[0] = '';

                                        $madang_carbohydrates = get_post_meta( get_the_ID(), 'madang_carbohydrates', '');
                                        if( sizeof($madang_carbohydrates)==0 ) $madang_carbohydrates[0] = '';
                                        ?>

                                        <!--single menu -->
                                        <div class="col-xs-12 col-sm-12 menu-item wow fadeInLeft">
                                            <div class="menu-item-wrap">
                                                <figure>
                                                    <a href="<?php echo get_permalink(get_the_ID()); ?>" data-id="<?php echo get_the_ID(); ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?>">
                                                        <?php the_post_thumbnail( 'madang-product-small', array( 'class' => 'img-responsive' ) ); ?>
                                                    </a>
                                                </figure>
                                                
                                                <div class="mid">
                                                    <h4><a href="<?php echo get_permalink(get_the_ID()); ?>" data-id="<?php echo get_the_ID(); ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?>"><?php the_title();?></a></h4>
                                                    <span><?php echo esc_attr($madang_title[0]); ?></span>

                                                    <div class="facts-table">
                                                        <table>
                                                            <tbody>
                                                                <?php if( $madang_calories[0]!='' ) :?>
                                                                <tr>
                                                                    <td><span><?php echo esc_html__('Calories', 'madang'); ?></span></td>
                                                                    <td><span><?php echo esc_attr($madang_calories[0].$metering_cal); ?></span></td>
                                                                </tr>
                                                                <?php endif;?>
                                                                <?php if( $madang_proteins[0]!='' ) :?>
                                                                <tr>
                                                                    <td><span><?php echo esc_html__('Proteins', 'madang'); ?></span></td>
                                                                    <td><span><?php echo esc_attr($madang_proteins[0].$metering); ?></span></td>
                                                                </tr>
                                                                <?php endif;?>
                                                                <?php if( $madang_fats[0]!='' ) :?>
                                                                <tr>
                                                                    <td><span><?php echo esc_html__('Fats', 'madang'); ?></span></td>
                                                                    <td><span><?php echo esc_attr($madang_fats[0].$metering); ?></span></td>
                                                                </tr>
                                                                <?php endif;?>
                                                                <?php if( $madang_carbohydrates[0]!='' ) :?>
                                                                <tr>
                                                                    <td><span><?php echo esc_html__('Carbohydrates', 'madang'); ?></span>  </td>
                                                                    <td><span><?php echo esc_attr($madang_carbohydrates[0].$metering); ?></span></td>
                                                                </tr>
                                                                <?php endif;?>
                                                            </tbody>
                                                        </table>
                                                    </div>                                            
                                                </div>

                                                <div class="woocommerce right">
                                                    <?php if ( $price_html = $_product->get_price_html() ) : ?>
                                                        <h3 class="price"><?php echo ($price_html); ?></h3>
                                                    <?php endif; ?>
                                                    <?php madang_add_to_cart_btn( get_the_ID() ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--single menu ends -->

                                    <?php endwhile; ?> 
                                <?php endif;?>

                                <?php if ( 'pagination' == $atts['pagination'] ) : ?>
                                    <!-- menu pegination -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 text-center menu-pegination wow fadeInUp">

                                            <?php  madang_product_pagination( $products, get_pagenum_link( 999999999 ) );  ?>

                                        </div>
                                    </div>
                                    <!-- menu pegination ends-->
                                <?php endif; ?>
                            </div>
                            <!-- menu list ends--> 

                        <?php elseif ( "grid" == $atts['list_style'] ): ?>

                            <div class="row menu-listing-wrap gd-view">

                                <?php 

                                $products = new WP_Query( $args );

                                if ( $products->have_posts() ) :  ?>
                                    <?php while ($products->have_posts()) : $products->the_post();  

                                        $_product = wc_get_product( get_the_ID() );
                                        $metering = get_theme_mod( 'madang_metering', 'g' );
                                        $metering_cal = get_theme_mod( 'madang_calories', '' );

                                        global $wp;
                                        $current_url = home_url(add_query_arg(array(),$wp->request));

                                        $madang_title = get_post_meta( get_the_ID(), 'madang_title', '');
                                        if( sizeof($madang_title)==0 ) $madang_title[0] = '';

                                        $madang_calories = get_post_meta( get_the_ID(), 'madang_calories', '');
                                        if( sizeof($madang_calories)==0 ) $madang_calories[0] = '';

                                        $madang_proteins = get_post_meta( get_the_ID(), 'madang_proteins', '');
                                        if( sizeof($madang_proteins)==0 ) $madang_proteins[0] = '';

                                        $madang_fats = get_post_meta( get_the_ID(), 'madang_fats', '');
                                        if( sizeof($madang_fats)==0 ) $madang_fats[0] = '';

                                        $madang_carbohydrates = get_post_meta( get_the_ID(), 'madang_carbohydrates', '');
                                        if( sizeof($madang_carbohydrates)==0 ) $madang_carbohydrates[0] = '';
                                        
                                        ?>

                                        <!--single menu -->
                                        <div class="col-xs-12 col-md-4 col-sm-6 menu-item wow fadeInLeft">
                                             <div class="text-center menu-item-wrap">
                                                <figure>
                                                    <a href="<?php echo get_permalink(get_the_ID()); ?>" data-id="<?php echo get_the_ID(); ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?>" >
                                                        <?php the_post_thumbnail( 'madang-product-small', array( 'class' => 'img-responsive' ) ); ?>
                                                    </a>
                                                </figure>
                                                
                                                <div class="content">
                                                    <h4><a href="<?php echo get_permalink(get_the_ID()); ?>" data-id="<?php echo get_the_ID(); ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?>"><?php the_title();?></a></h4>
                                                    <span><?php echo esc_attr($madang_title[0]); ?></span>
                                                    <?php if ( $price_html = $_product->get_price_html() ) : ?>
                                                        <h3 class="price"><?php echo ($price_html); ?></h3>
                                                    <?php endif; ?>
                                                    <div class="woocommerce bottom">
                                                        <div class="facts-table">
                                                            <table>
                                                                <tbody>
                                                                    <?php if( $madang_calories[0]!='' ) :?>
                                                                    <tr>
                                                                        <td><span><?php echo esc_html__('Calories', 'madang'); ?></span></td>
                                                                        <td><span><?php echo esc_attr($madang_calories[0].$metering_cal); ?></span></td>
                                                                    </tr>
                                                                    <?php endif;?>
                                                                    <?php if( $madang_proteins[0]!='' ) :?>
                                                                    <tr>
                                                                        <td><span><?php echo esc_html__('Proteins', 'madang'); ?></span></td>
                                                                        <td><span><?php echo esc_attr($madang_proteins[0].$metering); ?></span></td>
                                                                    </tr>
                                                                    <?php endif;?>
                                                                    <?php if( $madang_fats[0]!='' ) :?>
                                                                    <tr>
                                                                        <td><span><?php echo esc_html__('Fats', 'madang'); ?></span></td>
                                                                        <td><span><?php echo esc_attr($madang_fats[0].$metering); ?></span></td>
                                                                    </tr>
                                                                    <?php endif;?>
                                                                    <?php if( $madang_carbohydrates[0]!='' ) :?>
                                                                    <tr>
                                                                        <td><span><?php echo esc_html__('Carbohydrates', 'madang'); ?></span>  </td>
                                                                        <td><span><?php echo esc_attr($madang_carbohydrates[0].$metering); ?></span></td>
                                                                    </tr>
                                                                    <?php endif;?>
                                                                </tbody>
                                                            </table>
                                                        </div> 

                                                        <?php madang_add_to_cart_btn( get_the_ID() ); ?>
                                                        
                                                    </div>                                          
                                                </div>
                                            </div>
                                        </div>
                                        <!--single menu ends data-toggle="modal" data-target="#myModal"-->
                                   <?php endwhile; ?> 
                                <?php endif;?>

                                <?php if ( 'pagination' == $atts['pagination'] ) : ?>
                                    <!-- menu pegination -->
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 text-center menu-pegination wow fadeInUp">

                                            <?php  madang_product_pagination( $products, get_pagenum_link( 999999999 ) );  ?>

                                        </div>
                                    </div>
                                    <!-- menu pegination ends-->
                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

    <?php elseif ( 'slider_newest' == $atts['type'] ) : ?>

        <!--Newest Items-->
        <div class="newest-items">
            <div class="container">
                <div class="title text-center">
                    <h4><?php echo esc_attr( $atts['title'] ); ?></h4>
                </div>
            </div>
            <div class="container-slider">
                <div class="product-slider">
                    <?php
                    $args = array(
                        'posts_per_page' => $atts['per_page'],
                        'post_type' => array('product'), //, 'product_variation'
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'tax_query'      => array(
                                'relation'      => 'OR',
                                array(
                                    'taxonomy'     => 'product_cat',
                                    'field'        => 'name',
                                    'terms'        => $atts['category'],
                                )
                            )
                    );

                    $products = new WP_Query( $args );

                    if ( $products->have_posts() ) : ?>
                        <ul class="columns4 no-padding list-product">
                            <?php while ($products->have_posts()) :
                                $products->the_post(); ?>
                                <li class="item">
                                    <div class="img__product position-relative">
                                        <a href="<?php echo the_permalink();?>" class="font15 text-bold">
                                        <?php the_post_thumbnail( 'madang-related', array( 'class' => 'img-responsive' ) ); ?>
                                        </a>
                                    </div>
                                    <div class="cart-item-info position-absolute">
                                        <div class="title-content">
                                            <a href="<?php echo the_permalink();?>" class="font15 text-bold"><?php the_title();?></a>
                                            <?php echo wc_price( get_post_meta( get_the_ID(), '_sale_price', true ) ); ?>
                                            <div class="add-cart add-cart-item text-center">
                                                <form action="<?php echo the_permalink();?>">
                                                    <button class="font-15 link-add"><?php esc_attr_e( 'Add to Cart', 'madang' ) ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?> 
                        </ul>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!--/Newest Items-->

   <?php elseif ( 'slider_best_seller' == $atts['type'] ) : ?>

        <!--Best Seller-->
        <div class="best-seller">
            <div class="container">
                <div class="title text-center">
                    <h4><?php echo esc_attr( $atts['title'] ); ?></h4>
                </div>
            </div>
            <div class="container-slider">
                <div class="product-slider">
                    <?php
                    $args = array(
                        'posts_per_page' => $atts['per_page'],
                        'post_type' => array('product'), //, 'product_variation'
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'orderby' =>  array('date' => 'DESC'),
                        'tax_query'      => array(
                                'relation'      => 'OR',
                                array(
                                    'taxonomy'     => 'product_cat',
                                    'field'        => 'name',
                                    'terms'        => $atts['category'],
                                )
                            )
                    );

                    $products = new WP_Query( $args );

                    if ( $products->have_posts() ) : ?>
                        <ul class="columns4-bestseller no-padding list-product">
                        <?php while ($products->have_posts()) :
                            $products->the_post(); ?>
                            <li class="item">
                                <div class="img__product position-relative">
                                    <a href="<?php echo the_permalink();?>" >
                                        <?php the_post_thumbnail( 'madang-related', array( 'class' => 'product-image img-responsive' ) ); ?>
                                    </a>
                                    <span class="font11 label-seller label-item position-absolute position-top"><?php echo esc_attr( $atts['badge'] ); ?></span>
                                </div>
                                <div class="cart-item-info position-absolute">
                                    <div class="title-content">
                                        <div class="ratings">
                                            <div class="rating-box">
                                                <div class="rating"></div>
                                            </div>
                                        </div>
                                        <a href="<?php echo the_permalink();?>" class="font15 text-bold"><?php the_title();?></a>
                                        <?php echo wc_price( get_post_meta( get_the_ID(), '_sale_price', true ) ); ?>
                                        <div class="add-cart add-cart-item text-center">
                                            <form action="<?php echo the_permalink();?>">
                                                <button class="font-15 link-add"><?php esc_attr_e( 'Add to Cart', 'madang' ) ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?> 
                        </ul>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!--/Best Seller-->

   <?php elseif ( 'slider_limited' == $atts['type'] ) : ?>

        <!--Limited Time Offer-->
        <div class="limited-time-offer">
            <div class="container">
                <div class="row">
                    <div class="limited-time-offer__time col-lg-3 col-md-12 col-xs-12">
                        <div class="time-title">
                            <h3>
                                <span class="text-bold font35 text-uppercase text1"><?php echo esc_attr( $atts['title'] ); ?></span>  <br />
                                <span class="text-normal font19 text-uppercase text2"><?php echo esc_attr( $atts['subtitle'] ); ?></span>
                            </h3>
                        </div>
                        <?php if ( strlen($atts["time_left"]) == 16 ) : ?>
                        <div id="time" data-year="<?php echo substr($atts['time_left'],0,4); ?>" data-month="<?php echo substr($atts['time_left'],5,2); ?>" data-day="<?php echo substr($atts['time_left'],8,2); ?>" data-hour="<?php echo substr($atts['time_left'],11,2); ?>" data-minute="<?php echo substr($atts['time_left'],14,2); ?>">

                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="limited-time-offer__slide col-lg-9 col-xs-12">
                        <?php
                        $args = array(
                            'posts_per_page' => $atts['per_page'],
                            'post_type' => array('product'), //, 'product_variation'
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'tax_query'      => array(
                                    'relation'      => 'OR',
                                        array(
                                        'taxonomy'     => 'product_cat',
                                        'field'        => 'name',
                                        'terms'        => $atts['category'],
                                        )
                                )
                        );

                        $products = new WP_Query( $args );

                        if ( $products->have_posts() ) : ?>
                            <ul class="columns3 block-time-offer">
                            <?php while ($products->have_posts()) :
                                $products->the_post(); ?>
                                <li class="item">
                                    <div class="image-time-offer position-relative">
                                        <a href="<?php echo the_permalink();?>">
                                            <?php the_post_thumbnail( 'madang-limited', array( 'class' => 'img-responsive' ) ); ?>
                                        </a>
                                        <div class="price-time-offer position-absolute position-bottom">
                                            <span class="price"><?php echo wc_price( get_post_meta( get_the_ID(), '_sale_price', true ) ); ?></span>
                                            <span class="un-price"><?php echo wc_price( get_post_meta( get_the_ID(), '_regular_price', true ) ); ?></span>
                                        </div>
                                    </div>
                                </li>
                            <?php endwhile; ?> 
                            </ul>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <!--/Limited Time Offer-->

    <?php elseif ( 'cover' == $atts['type'] ) : 
        //http://stackoverflow.com/questions/28367830/woocommerce-search-products-between-price-range-using-wp-query
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $attribute = 'size';
        $values = "S,L";

        $attribute_name  = 'size';
        $attribute_value = 'S';
        $serialized_value = serialize( 'name' ) . serialize( $attribute_name ) . serialize( 'value' ) . serialize( $attribute_value );

        $args = array(
            'posts_per_page' => esc_attr( $atts['per_page'] ),
            'post_type'      => array('product'), //, 'product_variation'
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'paged' => $paged,   
            'tax_query' => array(
                'relation'      => 'OR',    
            )    
        );

        $product_cat_arr = array(
            'taxonomy'     => 'product_cat',
            'field'        => 'name',
            'terms'        => esc_attr( $atts['category'] ),
        );

        //product cat filter
        if ( strlen( $atts['category'] ) > 0 ) {
            array_push( $args['tax_query'], $product_cat_arr ); 
        }

        $products = new WP_Query( $args );
        if( class_exists( 'WooCommerce' ) ) : 
        if ( 'true' == $atts['show_header'] ) : ?>
        <!--filter product-->
        <div class="filter-product">
            <div class="container product-filter">
                <div class="row no-margin">
                    <div class="group__filter">
                        <div class="item__filter filter__title col-lg-2 col-xs-4">
                            <p class="font-montserrat text-bold text-uppercase font17 no-margin text-center"><?php esc_attr_e( 'Filter', 'madang' ) ?></p>
                        </div>
                        <div class="item__filter set__column col-lg-2 hidden-xs">
                            <div class="set__column6 <?php echo ($atts['columns']=='6')?'active-column':''; ?> ">
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                            </div>
                            <div class="set__column4 <?php echo ($atts['columns']=='4')?'active-column':''; ?>">
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                                <span class="icon-col"><span class="hidden">1</span></span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-9 col-lg-pull-2 no-padding hidden-xs">
                            <?php if ( '' != $atts['sizes'] ) : ?>
                                <div class="item__filter item-open filter__size">
                                    <div class="panel__size"></div>
                                    <h5 class="font-montserrat-light font16 text-center text-normal"><?php esc_attr_e( 'Size', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                </div>
                            <?php endif; ?>
                            <?php if ( '' != $atts['colors'] ) : ?>
                                <div class="item__filter item-open filter__color">
                                    <div class="panel__color"></div>
                                    <h5 class="font-montserrat-light font16 text-center text-normal"><?php esc_attr_e( 'Color', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                </div>
                            <?php endif; ?>
                            <div class="item__filter item-open filter__price">
                                <div class="panel__price"></div>
                                <h5 class="font-montserrat-light font16 text-center text-normal"><?php esc_attr_e( 'Price', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-3 pull-right no-padding hidden-xs">
                            <div class="item__filter item-open filter_sort">
                                <div class="panel__sort"></div>
                                <h5 class="font-montserrat-light font16 text-center"><?php esc_attr_e( 'Sort By', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                            </div>
                        </div>

                        <!--filter for mobile-->
                        <div class="filter-mobile hidden-lg hidden-md hidden-ms visible-xs-inline-block">
                            <!--size-->
                            <?php if ( '' != $atts['sizes'] ) : ?>
                                <div class="panel-mobile hidden-lg hidden-md hidden-ms visible-xs">
                                    <h5 class="font-montserrat-light font16 text-bold btn-expand"><?php esc_attr_e( 'Size', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                    <ul class="list-unstyled list-inline block_panel font-montserrat font14 text-left">
                                        <?php $sizes_arr = explode( ",", $atts['sizes'] );
                                        $terms = get_terms(array(
                                            'taxonomy' => "pa_size",
                                            'hide_empty' => false,
                                        ));
                                        foreach ( $terms as $term ) {
                                           
                                            if( in_array( $term->name, $sizes_arr ) ){ ?>

                                                <li class="item">
                                                    <div class="section size-selection" data-size="<?php echo esc_attr( $term->name ); ?>"><span><?php echo esc_attr( $term->name ); ?></span><span class="size"><?php echo esc_html( $term->description ); ?></span></div>
                                                </li>

                                            <?php }
                                        } ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if ( '' != $atts['colors'] ) : ?>
                                <!--color-->
                                <div class="panel-mobile hidden-lg hidden-md hidden-ms visible-xs">
                                    <h5 class="font-montserrat-light font16 text-bold btn-expand"><?php esc_attr_e( 'Color', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                    <ul class="list-unstyled list-inline block_panel font-montserrat font14 text-left">
                                        <?php $colors_arr = explode( ",", $atts['colors'] );
                                        $terms = get_terms(array(
                                            'taxonomy' => "pa_color",
                                            'hide_empty' => false,
                                        ));
                                        foreach ( $terms as $term ) {
                                           
                                            if( in_array( $term->name, $colors_arr ) ){ ?>

                                                <li class="item">
                                                    <div class="section color-selection" data-color="<?php echo esc_attr( $term->name ); ?>"><i class="gray__color" style="background-color:<?php echo esc_attr( $term->description ); ?>"></i><span class="font-montserrat-light font15"><?php echo esc_attr( $term->name ); ?></span></div>
                                                </li>

                                            <?php }
                                        } ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <!--price-->
                            <div class="panel-mobile hidden-lg hidden-md hidden-ms visible-xs">
                                <h5 class="font-montserrat-light font16 text-bold btn-expand"><?php esc_attr_e( 'Price', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                <div class="range__price position-relative block_panel">
                                    <input type="text" class="span2 ex2" value="" data-slider-min="<?php echo esc_html( $atts['price_min'] ); ?>" data-slider-max="<?php echo esc_html( $atts['price_max'] ); ?>" data-slider-step="10" data-slider-value="[<?php echo esc_html( $atts['price_min'] ); ?>,<?php echo esc_html( $atts['price_max'] ); ?>]" />
                                    <span class="position-absolute font-montserrat-light font18" id="mmin"></span>
                                    <span class="position-absolute font-montserrat-light font18" id="mmax"></span>
                                </div>
                            </div>
                            <!--sort-->
                            <div class="panel-mobile hidden-lg hidden-md hidden-ms visible-xs">
                                <h5 class="font-montserrat-light font16 text-bold btn-expand"><?php esc_attr_e( 'Sort', 'madang' ) ?> <i class="flaticon-next-1" aria-hidden="true"></i></h5>
                                <ul class="list-unstyled list-inline block_panel font-montserrat font14 text-left">
                                    <li class="item active__sort">
                                        <div class="section order-selection" data-order=""><span class="font-montserrat-light font18"><?php esc_attr_e( 'Default', 'madang' ) ?></span></div>
                                    </li>
                                    <li class="item">
                                        <div class="section order-selection" data-order="popularity"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Popularity', 'madang' ) ?></span></div>
                                    </li>
                                    <li class="item">
                                        <div class="section order-selection" data-order="rating"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Rating', 'madang' ) ?></span></div>
                                    </li>
                                    <li class="item">
                                        <div class="section order-selection" data-order="newest"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Newest', 'madang' ) ?></span></div>
                                    </li>
                                    <li class="item">
                                        <div class="section order-selection" data-order="lowestprice"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Price: Low to High', 'madang' ) ?></span></div>
                                    </li>
                                    <li class="item">
                                        <div class="section order-selection" data-order="highestprice"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Price: High to Low', 'madang' ) ?></span></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inner__filter">
                <div class="container product-filter">
                    <?php if ( '' != $atts['sizes'] ) : ?>
                        <div class="panel__size item-inner__filter">
                            <ul class="list-unstyled list-inline block_panel font-montserrat font14">
                                <?php $sizes_arr = explode( ",", $atts['sizes'] );
                                $terms = get_terms(array(
                                    'taxonomy' => "pa_size",
                                    'hide_empty' => false,
                                ));
                                foreach ( $terms as $term ) {
                                   
                                    if( in_array( $term->name, $sizes_arr ) ){ ?>

                                        <li class="item">
                                            <div class="section size-selection" data-size="<?php echo esc_attr( $term->name ); ?>"><span><?php echo esc_attr( $term->name ); ?></span><span class="size"><?php echo esc_attr( $term->description ); ?></span></div>
                                        </li>

                                    <?php }
                                } ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if ( '' != $atts['colors'] ) : ?>
                        <div class="panel__color item-inner__filter">
                            <div class="block_panel">
                                <ul class="list-unstyled list-inline font-montserrat font14">
                                    <?php $colors_arr = explode( ",", $atts['colors'] );
                                        $terms = get_terms(array(
                                            'taxonomy' => "pa_color",
                                            'hide_empty' => false,
                                        ));
                                        foreach ( $terms as $term ) {
                                           
                                            if( in_array( $term->name, $colors_arr ) ){ ?>

                                                <li class="item">
                                                    <div class="section color-selection" data-color="<?php echo esc_attr( $term->name ); ?>"><i class="gray__color" style="background-color:<?php echo esc_attr( $term->description ); ?>"></i><span class="font-montserrat-light font15"><?php echo esc_attr( $term->name ); ?></span></div>
                                                </li>

                                            <?php }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="panel__price item-inner__filter">
                        <div class="block_panel">
                            <div class="range__price position-relative">
                                <input type="text" class="span2 ex2" value="" data-slider-min="<?php echo esc_html( $atts['price_min'] ); ?>" data-slider-max="<?php echo esc_html( $atts['price_max'] ); ?>" data-slider-step="10" data-slider-value="[<?php echo esc_html( $atts['price_min'] ); ?>,<?php echo esc_html( $atts['price_max'] ); ?>]" />
                                <span class="position-absolute font-montserrat-light font18 price_min_listener" id="min"></span>
                                <span class="position-absolute font-montserrat-light font18 price_max_listener" id="max"></span>
                            </div>
                        </div>
                    </div>
                    <div class="panel__sort item-inner__filter">
                        <div class="block_panel">
                            <ul class="list-unstyled list-inline font-montserrat font14">
                                <li class="item active__sort">
                                    <div class="section order-selection" data-order=""><span class="font-montserrat-light font18"><?php esc_attr_e( 'Default', 'madang' ) ?></span></div>
                                </li>
                                <li class="item">
                                    <div class="section order-selection" data-order="popularity"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Popularity', 'madang' ) ?></span></div>
                                </li>
                                <li class="item">
                                    <div class="section order-selection" data-order="rating"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Rating', 'madang' ) ?></span></div>
                                </li>
                                <li class="item">
                                    <div class="section order-selection" data-order="newest"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Newest', 'madang' ) ?></span></div>
                                </li>
                                <li class="item">
                                    <div class="section order-selection" data-order="lowestprice"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Price: Low to High', 'madang' ) ?></span></div>
                                </li>
                                <li class="item">
                                    <div class="section order-selection" data-order="highestprice"><span class="font-montserrat-light font18"><?php esc_attr_e( 'Price: High to Low', 'madang' ) ?></span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif;?> 
        <!--/ filter product--> 
        <?php if ( $products->have_posts() ) : ?>
            <div class="product-gird" data-category="<?php echo esc_attr( $atts['category'] ); ?>">
                <div class="container">
                    <div class="grid-product-content">
                        <div class="row">
                            <?php while ($products->have_posts()) :
                                $products->the_post(); 
                                if ( "4" == $atts['columns']."" ) :  ?>
                                    <div class="item col-md-3 col-sm-3 col-xs-12">
                                        <div class="product-img position-relative">
                                            <a href="<?php echo the_permalink();?>" class="products-img list-links" >
                                                <?php the_post_thumbnail( 'madang-newest', array( 'class' => 'img-responsive' ) ); ?>
                                            </a>
                                            <div class="icon-wishlist position-absolute ">
                                                <?php if( YITH_WCWL()->is_product_in_wishlist( get_the_ID() ) ) : ?>  
                                                    <a title="<?php esc_attr_e( 'Already in wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a> 
                                                <?php else: ?>
                                                    <a title="<?php esc_attr_e( 'Add to wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    </a> 
                                                <?php endif; ?>
                                            </div>   
                                        </div>
                                        <div class="product-content text-item">
                                            <h5>
                                                <a href="#" class="font-montserrat font16"><?php the_title(); ?></a>
                                            </h5>
                                            <p class="price font-montserrat font16"><?php echo wc_price( get_post_meta( get_the_ID(), '_sale_price', true ) ); ?></p>
                                        </div>
                                    </div>
                                <?php elseif ( "6" == $atts['columns']."" ) : ?>
                                    <div class="item col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                        <div class="product-img position-relative">
                                            <a href="<?php echo the_permalink();?>" class="products-img list-links font16" >
                                                <?php the_post_thumbnail( 'madang-newest', array( 'class' => 'img-responsive' ) ); ?>
                                            </a>
                                            <div class="icon-wishlist position-absolute ">
                                                <?php if( YITH_WCWL()->is_product_in_wishlist( get_the_ID() ) ) : ?>  
                                                    <a title="<?php esc_attr_e( 'Already in wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a> 
                                                <?php else: ?>
                                                    <a title="<?php esc_attr_e( 'Add to wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo get_the_ID(); ?>">
                                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    </a> 
                                                <?php endif; ?>
                                            </div>   
                                        </div>
                                        <div class="product-content text-item">
                                            <h5>
                                                <a href="#" class="font-montserrat font15"><?php the_title(); ?></a>
                                            </h5>
                                            <p class="price font-montserrat font15"><?php echo wc_price( get_post_meta( get_the_ID(), '_sale_price', true ) ); ?></p>
                                        </div>
                                    </div>
                                <?php endif;
                            endwhile; ?>
                        </div> 
                        <?php madang_pagination( $products ); ?> 
                    </div>  
                    <div class="separates"></div>
                </div> 
            </div> 
        <?php endif;?>
        <?php endif;?>
    <?php endif;
    wp_reset_postdata();
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}

