<?php
/*
Widget Name: Madang Product Category Widget
Description: Create Product Category Listings
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_productcategories_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_productcategories_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Categories', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create product category listing', 'madang'),
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
                'categories' => array(
                    'type' => 'text',
                    'label' => esc_html__('Categories', 'madang'),
                    'description' => esc_html__('Manually select categories by name. Separate by ",". Categories are case-sensitive.', 'madang'),
                    'default' => ''
                ),
                'per_page' => array(
                    'type' => 'text',
                    'label' => esc_html__('Records per page', 'madang'),
                    'default' => ''
                ),
                'link' => array(
                    'type' => 'text',
                    'label' => esc_html__('Products page', 'madang'),
                    'description' => esc_html__('By default opens WooCommerce category page. Provide url to our products page that uses ajax requests to automatically preload products from certain category.', 'madang'),
                    'default' => ''
                ),      
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-productcategories';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_productcategories_widget', __FILE__, 'madang_productcategories_widget');

endif;

function madang_shortcode_categories( $atts, $content = null ) {
    $atts = shortcode_atts(array(
        "image"         => '',
        "title"         => '',
        "subtitle"      => '',
        "image"         => '',
        "show_header"   => 'true',
        "categories"    => '',
        "per_page"      => '16',
        "images_ofset"  => '',
        "link"          => '',
        "type"          => ''
    ), $atts);

    ob_start(); ?>

    <!-- ================== menu cateogry list====================-->
    <section class="block cat-list-wrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 top-text-header text-center wow fadeInUp">
                    <h4 class="text-uppercase text-lt text-sp"><?php echo esc_html( $atts['title'] ); ?></h4>
                </div>
            </div>

            <?php if( class_exists( 'WooCommerce' ) ) : ?>
                <div class="row">
                    <?php $args = array(
                    'number'     => $atts['per_page'],
                    'hide_empty' => false,
                    );

                    
                    $product_categories = get_terms( 'product_cat', $args ); 
                    if ( $product_categories ) : 
                        foreach ( $product_categories as $tag ) : 

                            if ( strpos($atts['categories'], $tag->name) !== false || strlen($atts['categories']) < 2){

                                $thumbnail_id = "";
                                $thumbnail_id = get_woocommerce_term_meta( $tag->term_id, 'thumbnail_id', true );
                                $image = wp_get_attachment_image_src( $thumbnail_id, "madang-product-small" );
                                $link = get_term_link($tag->term_id);
                                if ( $atts['link'] != '' ){ $link = $atts['link']; }                   
                                ?>

                                <!--single cat -->
                                <div class="col-sm-3 cat-wrap wow fadeInLeft">
                                    <a href="<?php echo esc_url( $link ); ?>" class="ajax_cat" data-cat="<?php echo esc_attr( $tag->name ); ?>">
                                        <span><?php echo esc_html( $tag->name ); ?></span>
                                        <figure>
                                            <?php if ( isset( $image ) ) : ?>
                                                <img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php echo esc_attr( $tag->name ); ?>">
                                            <?php endif; ?>
                                        </figure>
                                    </a>
                                </div>
                                <!-- singel cat ends-->

                            <?php } ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- ================== menu cateogry list ends====================-->

    <?php
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}