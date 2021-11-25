<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package madang
 */

add_action('wp_ajax_nopriv_madang_product_modal_ajax', 'madang_product_modal_ajax');
add_action('wp_ajax_madang_product_modal_ajax', 'madang_product_modal_ajax');
if ( ! function_exists( 'madang_product_modal_ajax' ) ) {
    function madang_product_modal_ajax() {
        global $woocommerce;

        $id       = (isset($_POST['id'])) ? $_POST['id'] : "";
        $_product = wc_get_product( $id );

        ob_start(); 

        $metering = get_theme_mod( 'madang_metering', 'g' );

        global $wp;
        $current_url = home_url(add_query_arg(array(),$wp->request));

        $madang_title = get_post_meta( $_product->id, 'madang_title', '');
        if( sizeof($madang_title)==0 ) $madang_title[0] = '';

        $madang_calories = get_post_meta( $_product->id, 'madang_calories', '');
        if( sizeof($madang_calories)==0 ) $madang_calories[0] = '';

        $madang_proteins = get_post_meta( $_product->id, 'madang_proteins', '');
        if( sizeof($madang_proteins)==0 ) $madang_proteins[0] = '';

        $madang_fats = get_post_meta( $_product->id, 'madang_fats', '');
        if( sizeof($madang_fats)==0 ) $madang_fats[0] = '';

        $madang_carbohydrates = get_post_meta( $_product->id, 'madang_carbohydrates', '');
        if( sizeof($madang_carbohydrates)==0 ) $madang_carbohydrates[0] = '';

        $madang_ingredients = get_post_meta( $_product->id, 'madang_ingredients', '');
        if( sizeof($madang_ingredients)==0 ) $madang_ingredients[0] = '';

        ?>

        <!-- Modal -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">              
              <div class="modal-body">
                <figure>
                    <?php echo ($_product->get_image( 'madang-blog' )); ?>
                </figure>
                
                <!--inner starts-->
                <div class="inner">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 top text-sp">
                            <span class="price pull-right"><?php echo wc_price( $_product->get_price() ); ?></span>
                            <h3 class="product-single-modal"><?php echo esc_html($_product->post->post_title); ?>
                                <span><?php echo esc_attr($madang_title[0]); ?></span>
                            </h3>
                        </div>

                        <div class="col-xs-12 col-sm-12"><hr></div>

                        <div class="col-xs-12 col-sm-12 content">
                            <p> 
                                <?php echo madang_output_html($_product->post->post_excerpt); ?>
                            </p>
                        </div>

                        <div class="col-xs-12 col-sm-6 ingredients">
                            <h6><?php esc_html_e('INGREDIENTS','madang');?></h6>
                            <ul>
                                <?php $madang_ingredients_arr = explode( PHP_EOL, $madang_ingredients[0] );
                                foreach($madang_ingredients_arr as $ingredient){

                                    echo '<li>'.$ingredient.'</li>';
                                } ?>
                            </ul>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <h6><?php esc_html_e('NUTRITION FACTS','madang');?></h6>     
                            <div class="facts-table">                                
                                <table>
                                    <tbody>
                                        <?php if( $madang_calories[0]!='' ) :?>
                                        <tr>
                                            <td><span><?php echo esc_html__('Calories', 'madang'); ?></span></td>
                                            <td><span><?php echo esc_attr($madang_calories[0].$metering); ?></span></td>
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
                    </div>
                </div>
                <!--inner ends-->
                <div class="woocommerce product-single-modal">

                    <?php madang_add_to_cart_btn( $_product->id ); ?>

                </div>    
              </div>
            </div>
            <!--model content ends-->
        </div>

        <!--model ends-->

        <?php
        $buffer = ob_get_clean();
        wp_reset_postdata();
        wp_die($buffer); 
    }
}

add_action('wp_ajax_nopriv_madang_cart_data_ajax', 'madang_cart_data_ajax');
add_action('wp_ajax_madang_cart_data_ajax', 'madang_cart_data_ajax');
if ( ! function_exists( 'madang_cart_data_ajax' ) ) {
    function madang_cart_data_ajax() {
        global $woocommerce;

        ob_start();
        $output = [];
        $output['success'] = true;
        $output['cart_contents_count'] = WC()->cart->get_cart_contents_count();
        $madang_calories_total = $madang_proteins_total = $madang_fats_total = $madang_carbohydrates_total = 0;
        $metering = get_theme_mod( 'madang_metering', 'g' );
        $metering_cal = get_theme_mod( 'madang_calories', '' );
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            $madang_calories = get_post_meta( $product_id, 'madang_calories', '');
            if( sizeof($madang_calories)==0 ) { $madang_calories[0] = ''; }else{ $madang_calories_total += (intval($madang_calories[0]) * $cart_item['quantity']); }

            $madang_proteins = get_post_meta( $product_id, 'madang_proteins', '');
            if( sizeof($madang_proteins)==0 ) { $madang_proteins[0] = ''; }else{ $madang_proteins_total += (intval($madang_proteins[0]) * $cart_item['quantity']); }

            $madang_fats = get_post_meta( $product_id, 'madang_fats', '');
            if( sizeof($madang_fats)==0 ) { $madang_fats[0] = ''; }else{ $madang_fats_total += (intval($madang_fats[0]) * $cart_item['quantity']); }

            $madang_carbohydrates = get_post_meta( $product_id, 'madang_carbohydrates', '');
            if( sizeof($madang_carbohydrates)==0 ) { $madang_carbohydrates_total[0] = ''; }else{ $madang_carbohydrates_total += (intval($madang_carbohydrates[0]) * $cart_item['quantity']); }
        }
        $output['cart_calories'] = esc_attr(number_format($madang_calories_total,0," "," ").$metering_cal);
        $output['cart_proteins'] = esc_attr(number_format($madang_proteins_total,0," "," ").$metering);
        $output['cart_fats'] = esc_attr(number_format($madang_fats_total,0," "," ").$metering);
        $output['cart_carbohydrates'] = esc_attr(number_format($madang_carbohydrates_total,0," "," ").$metering);
  
        echo json_encode($output);   
        $buffer = ob_get_clean();
        wp_reset_postdata();
        wp_die($buffer); 
    }
}

//user not logged in and logged in hook
add_action('wp_ajax_nopriv_madang_more_products_ajax', 'madang_more_products_ajax');
add_action('wp_ajax_madang_more_products_ajax', 'madang_more_products_ajax');
if ( ! function_exists( 'madang_more_products_ajax' ) ) {
    function madang_more_products_ajax() {
        global $woocommerce;

    
        $ppp     = (isset($_POST['ppp'])) ? $_POST['ppp'] : 3;
        $cat     = (isset($_POST['cat'])) ? $_POST['cat'] : 0;
        $offset  = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
        $id      = (isset($_POST['post_id'])) ? $_POST['post_id'] : "";
        $limit   = 8;

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => $ppp,
            'cat'            => $cat,
            'offset'         => $offset,
        );

        // Related products are found from category and tag
        $tags_array = array(0);
        $cats_array = array(0);

        // Get tags
        $terms = wp_get_post_terms($id, 'product_tag');
        foreach ( $terms as $term ) $tags_array[] = $term->term_id;

        // Get categories (removed by NerdyMind)
        //*
        $terms = wp_get_post_terms($id, 'product_cat');
        foreach ( $terms as $term ) $cats_array[] = $term->term_id;
        //*/

        // Don't bother if none are set
        if ( sizeof($cats_array)==1 && sizeof( $tags_array)==1 ) return array();

        // Meta query
        $meta_query = array();
        $meta_query[] = $woocommerce->query->visibility_meta_query();
        $meta_query[] = $woocommerce->query->stock_status_meta_query();

        // Get the posts
        $related_posts = get_posts( apply_filters('woocommerce_product_related_posts', array(
            'posts_per_page' => $limit,
            'post_type'      => 'product',
            'offset'         => $offset,
            'meta_query'     => $meta_query,
            'tax_query'      => array(
                'relation'      => 'OR',
                array(
                    'taxonomy'     => 'product_cat',
                    'field'        => 'id',
                    'terms'        => $cats_array
                ),
                array(
                    'taxonomy'     => 'product_tag',
                    'field'        => 'id',
                    'terms'        => $tags_array
                )
            )
        ) ) );


        ob_start();
        $_pf = new WC_Product_Factory(); 
        foreach ( $related_posts as $post_item ) : setup_postdata( $post_item ); 
        $product_related = $_pf->get_product($post_item->ID); ?>

                <div class="item col-sm-3 col-xs-12">
                    <div class="product-img position-relative">
                        <a href="<?php echo get_post_permalink($post_item->ID); ?>">
                            <img id="zoom" class="img-responsive" src="<?php echo get_the_post_thumbnail_url( $post_item, 'madang-related' ); ?>" alt="<?php echo esc_html( $post_item->post_title ); ?>"/>
                        </a>
                        <div class="icon-wishlist position-absolute ">
                            <?php if( YITH_WCWL()->is_product_in_wishlist( $product_related->id ) ) : ?>  
                                <a title="<?php esc_attr_e( 'Already in wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo esc_attr( $product_related->id ); ?>">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </a> 
                            <?php else: ?>
                                <a title="<?php esc_attr_e( 'Add to wishlist', 'madang' ) ?>" href="?add_to_wishlist=<?php echo esc_attr( $product_related->id ); ?>">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                </a> 
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="product-content text-item">
                        <h5 class="product-edit">
                            <a href="<?php echo get_post_permalink($post_item->ID); ?>" class="font-montserrat font16"><?php echo esc_attr( $post_item->post_title ); ?></a>
                        </h5>
                        <p class="product-edit1 price font-montserrat font16"><?php echo wc_price($product_related->get_display_price()); ?></p>
                    </div>
                </div>

        <?php endforeach; 
        $buffer = ob_get_clean();
        wp_reset_postdata();
        wp_die($buffer);
    }
}


add_action('wp_ajax_nopriv_madang_filter_products_ajax', 'madang_filter_products_ajax');
add_action('wp_ajax_madang_filter_products_ajax', 'madang_filter_products_ajax');
if ( ! function_exists( 'madang_filter_products_ajax' ) ) {
    function madang_filter_products_ajax() {
        global $woocommerce;

        $ppp                      = (isset($_POST['ppp'])) ? $_POST['ppp'] : 3;
        $cat                      = (isset($_POST['cat'])) ? $_POST['cat'] : "";
        $tag                      = (isset($_POST['product_tag'])) ? $_POST['product_tag'] : "";
        $ppp                      = (isset($_POST['ppp'])) ? $_POST['ppp'] : 0;
        $offset                   = (isset($_POST['offset'])) ? $_POST['offset'] : 0;
        $product_list             = (isset($_POST['product_list'])) ? $_POST['product_list'] : "";
        $product_order            = (isset($_POST['product_order'])) ? $_POST['product_order'] : "";
        $product_calories_low     = (isset($_POST['product_calories_low'])) ? $_POST['product_calories_low'] : 0;
        $product_calories_high    = (isset($_POST['product_calories_high'])) ? $_POST['product_calories_high'] : 1000000;
        $product_pricing_low      = (isset($_POST['product_pricing_low'])) ? $_POST['product_pricing_low'] : 0;
        $product_pricing_high     = (isset($_POST['product_pricing_high'])) ? $_POST['product_pricing_high'] : 1000000;
        $pagenum_link             = (isset($_POST['pagenum_link'])) ? $_POST['pagenum_link'] : '';
        $pagination               = (isset($_POST['pagination'])) ? $_POST['pagination'] : 'no';

        $limit   = 8;

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $attribute = 'size';
        $values = "S,L";

        $attribute_name  = 'size';
        $attribute_value = 'S';
        $serialized_value = serialize( 'name' ) . serialize( $attribute_name ) . serialize( 'value' ) . serialize( $attribute_value );

        $product_calories_arr =  array(
            'key' => 'madang_calories',
            'value' => array(intval(preg_replace('/[^0-9]/', '', $product_calories_low)), intval(preg_replace('/[^0-9]/', '', $product_calories_high))),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        );

        $product_pricing_arr =  array(
            'key' => '_price',
            'value' => array(intval(preg_replace('/[^0-9]/', '', $product_pricing_low)), intval(preg_replace('/[^0-9]/', '', $product_pricing_high))),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        );

        $product_cat_arr = array(
            'taxonomy'     => 'product_cat',
            'field'        => 'name',
            'terms'        => esc_attr( $cat )
        );

        $product_tag_arr = array(
            'taxonomy'     => 'product_tag',
            'field'        => 'name',
            'terms'        => esc_attr( $tag )
        );

        $args = array(
            'posts_per_page' => $ppp,
            'post_type' => array('product'), //, 'product_variation'
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'meta_query' => array(),
            'tax_query' => array('relation'=>'AND'),       
        );

        //product order sorting
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
        if ( strlen($cat) > 0 ) {

            array_push( $args['tax_query'], $product_cat_arr ); 
        }

        //product tag filter
        if ( strlen($tag) > 0 ) {

            array_push( $args['tax_query'], $product_tag_arr ); 
        }

        if ( $product_calories_low!=0 && $product_calories_high!=100000000000000 )
            array_push( $args['meta_query'], $product_calories_arr ); 

        array_push( $args['meta_query'], $product_pricing_arr ); 

        $products = new WP_Query( $args );

        ob_start();

            if ( "list" == $product_list."" ) :  ?>

                <div class="row menu-listing-wrap list-view">
                    <!--single menu -->
                    <?php if ( $products->have_posts() ) : ?>
                        <?php while ( $products->have_posts() ) : $_product = $products->the_post(); 

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
                        <?php endwhile;
                    endif; ?>

                     <?php if ( 'pagination' == $pagination ) : ?>
                        <!-- menu pegination -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 text-center menu-pegination wow fadeInUp">

                                <?php  madang_product_pagination( $products, $pagenum_link );  ?>

                            </div>
                        </div>
                        <!-- menu pegination ends-->
                    <?php endif; ?>

                </div>

            <?php elseif ( "grid" == $product_list."" ) : ?>

                <div class="row menu-listing-wrap gd-view">
                    <?php if ( $products->have_posts() ) : ?>
                        <?php while ( $products->have_posts() ) : $products->the_post(); 

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
                                        <a href="<?php echo get_permalink(get_the_ID()); ?>" data-id="<?php echo get_the_ID(); ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?>">
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
                            <!--single menu ends -->
                      
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php if ( 'pagination' == $pagination ) : ?>
                        <!-- menu pegination -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 text-center menu-pegination wow fadeInUp">

                                <?php  madang_product_pagination( $products, $pagenum_link );  ?>

                            </div>
                        </div>
                        <!-- menu pegination ends-->
                    <?php endif; ?>

                </div>
            <?php endif; 
        $buffer = ob_get_clean();
        wp_reset_postdata();
        wp_die($buffer);
    }
}