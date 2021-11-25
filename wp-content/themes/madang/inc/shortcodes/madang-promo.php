<?php

/*
Widget Name: Madang Promotion Widget
Description: Create Promotion Landing Page
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_promo_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_promo_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Promotion', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Promotion Landing Page', 'madang'),
                'panels_groups' => array('madang'),
                'help'        => 'http://madang_docs.kenzap.com',
            ),

            //The $control_options array, which is passed through to WP_Widget
            array(
            ),

            //The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'category' => array(
                    'type' => 'text',
                    'label' => esc_html__('Category', 'madang'),
                    'description' => esc_html__('Go to Promo > Add New to create new sales listing', 'madang'),
                    'default' => ''
                ),
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-promo';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_promo_widget', __FILE__, 'madang_promo_widget');

endif;

function madang_shortcode_promo( $atts, $content = null ) {
	$atts = shortcode_atts(array(
		"category"      => '',
		"image"         => '',
        "show_header"   => 'true',
        "per_page"      => '6',
        "type"          => ''
	), $atts);

	ob_start();

    if ( 'landing' == $atts['type'] ) : 

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_status'       => 'publish',
            'posts_per_page'    => esc_attr( $atts['per_page'] ),
            'post_type'         => array('promo'), 
            'tax_query'         => array (
                                  array (
                                     'taxonomy' => 'promo_category',
                                     'field'    => 'name',
                                     'terms' => esc_attr( $atts['category'] ),
                                  )
                                ),
            'paged'             => $paged,
            'orderby'           => 'madang_priority',
            'order'             => 'ASC'
        );
        $products = new WP_Query( $args );
        if ( $products->have_posts() ) : ?>
            <!-- ============== Deal page starts ============== -->
            <section class="wide_section">
                <div class="block">
                     <!--container-->
                     <div class="container">
                        <?php $count = 1; 
                        while ($products->have_posts()) : $products->the_post();

                            $thumb_id = get_post_thumbnail_id();
                            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full');
                            $thumb_url = $thumb_url_array[0]; 
                            $position = get_post_meta( get_the_ID(), 'madang_position', 'left' );

                            ?>
                            <!--single deal -->
                            <div class="block-wrap block1 wow fadeIn<?php echo esc_attr(strtoupper($position)); ?>" style="background: url(<?php echo esc_url($thumb_url);?>) no-repeat top center;">                   
                                 <div class="row">
                                     <div class="col-sm-5 <?php echo esc_attr($position); ?>">
                                         <h2><?php echo get_the_title(); ?></h2>
                                         <p><?php echo esc_html( get_post_meta( get_the_ID(), 'madang_description', true ) ); ?></p>
                                         <?php 
                                         $row1 = get_post_meta( get_the_ID(), 'madang_row1', true ); 
                                         if ( -1 != strpos($row1,"|") ){
                                            $row1 = explode("|",$row1);
                                            $row1_t = $row1[0];
                                            $row1_v = $row1[1];
                                         }else{
                                            $row1_t = $row1;
                                            $row1_v = "";
                                         }
                                         $row2 = get_post_meta( get_the_ID(), 'madang_row2', true ); 
                                         if ( -1 != strpos($row2,"|") ){
                                            $row2 = explode("|",$row2);
                                            $row2_t = $row2[0];
                                            $row2_v = $row2[1];
                                         }else{
                                            $row2_t = $row2;
                                            $row2_v = "";
                                         }                                     
                                         $row3 = get_post_meta( get_the_ID(), 'madang_row3', true ); 
                                         if ( -1 != strpos($row3,"|") ){
                                            $row3 = explode("|",$row3);
                                            $row3_t = $row3[0];
                                            $row3_v = $row3[1];
                                         }else{
                                            $row3_t = $row3;
                                            $row3_v = "";
                                         }                                     
                                         $row4 = get_post_meta( get_the_ID(), 'madang_row4', true ); 
                                         if ( -1 != strpos($row4,"|") ){
                                            $row4 = explode("|",$row4);
                                            $row4_t = $row4[0];
                                            $row4_v = $row4[1];
                                         }else{
                                            $row4_t = $row1;
                                            $row4_v = "";
                                         }
                                         ?>
                                         <table>
                                            <tr>
                                                 <td><?php echo esc_attr($row1_t);?></td>    
                                                 <td>...................</td>    
                                                 <td><?php echo esc_attr($row1_v);?></td>
                                            </tr>

                                            <tr>
                                                 <td><?php echo esc_attr($row2_t);?></td>    
                                                 <td>...................</td>    
                                                 <td><?php echo esc_attr($row2_v);?></td>
                                            </tr>

                                            <tr>
                                                 <td><?php echo esc_attr($row3_t);?></td>    
                                                 <td>...................</td>    
                                                 <td><?php echo esc_attr($row3_v);?></td>
                                            </tr>

                                            <tr>
                                                 <td><?php echo esc_attr($row4_t);?></td>    
                                                 <td>...................</td>    
                                                 <td><?php echo esc_attr($row4_v);?></td>
                                            </tr>
                                         </table>

                                         <a href="<?php echo  esc_url( get_post_meta( get_the_ID(), 'madang_btn_url', true ) ); ?>" class="btn btn-big btn-radius hvr-wobble-top bgcolor"><?php echo esc_attr( get_post_meta( get_the_ID(), 'madang_btn_text', true ) ); ?></a>
                                     </div>
                                 </div>                         
                            </div>
                            <!--single deal ends-->
                        <?php $count++; endwhile; ?>
                    </div> 
                </div>  
            </section>
        <?php endif;?>

    <?php elseif ( 'sale' == $atts['type'] ) :

     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_status'       => 'publish',
            'posts_per_page'    => esc_attr( $atts['per_page'] ),
            'post_type'         => array('promo'),
            'tax_query'         => array (
                                      array (
                                         'taxonomy' => 'promo_category',
                                         'field'    => 'name',
                                         'terms' => esc_attr( $atts['category'] ),
                                      )
                                   ),
            'paged'             => $paged,
            'orderby'           => 'madang_priority',
            'order'             => 'ASC'
        );
        $products = new WP_Query( $args );
        if ( $products->have_posts() ) : ?>

        <div class="list-promo">
            <div class="container">
                <div class="row">
                    <?php $count = 1; while ($products->have_posts()) :
                    $products->the_post(); ?>
                        <div class="item1 col-xs-12 col-sm-6 col-md-4 grid-group effect-animate">
                            <div class="product clearfix product-hover">
                                <div class="top-main">
                                    <span class="font-montserrat-light font10"><?php echo date( 'd M Y', get_post_time( 'U', true ) ); ?></span>
                                    <a class="font-montserrat text-normal font18" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'madang_btn_url', true ) ); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>
                                <div class="center-main">
                                    <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'madang_btn_url', true ) ); ?>">
                                        <?php the_post_thumbnail( 'madang-sale', array( "class" => "img-responsive" ) ); ?>
                                    </a>
                                </div>   <!--  /product-view -->
                                <div class="bottom-main ">
                                    <p class="font-montserrat-light font13"><?php 

                                        echo esc_attr( get_post_meta( get_the_ID(), 'madang_description', true ) ); 
                                        $time_start = intval( get_post_time( 'U', true ) );
                                        $time_end   = intval( esc_attr( get_post_meta( get_the_ID(), 'madang_time', true ) ) );
                                        $time_left  = intval( esc_attr( get_post_meta( get_the_ID(), 'madang_time', true ) ) ) - time();
                                        $days_left  = round( ( $time_left / 86400 ) ); 
                                        $days_total  = round( ( ($time_end - $time_start) / 86400 ) ); 
                                        $time_percent = round(($time_end - $time_start) / ($time_left * 100));
                                        if ($time_percent==0) $time_percent = 5;

                                        //echo " ".$days_left." ".$days_total." ".($time_left / 86400);
                                    ?></p>
                                    <div class="distance-line">
                                        <div class="line-out" style="width: 100%" data-percent="<?php echo esc_attr( $time_percent );?>%">
                                            <div class="line-in" >
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline text-center">
                                        <li><span></span></li>
                                        <li class="font-montserrat-light font14"><?php 

                                        if ( $days_left < 0 ) {
                                            echo esc_html_e('promo expired', 'madang');
                                        }else{
                                            echo esc_attr( $days_left );
                                            if ( madang_ends_with( $days_left, "1" ) ){
                                                echo esc_html_e(' day left', 'madang'); 
                                            } else {
                                                echo esc_html_e(' days left', 'madang'); 
                                            } 
                                        }
                                        ?></li>
                                    </ul>
                                </div>    <!-- /bottom-main -->
                                <div class="view-detail text-center font14 font-montserrat-light">
                                    <?php if ( $days_left > 0 ) : ?>
                                        <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'madang_btn_url', true ) ); ?>"><?php echo esc_attr( get_post_meta( get_the_ID(), 'madang_btn_text', true ) ); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'madang_btn_url', true ) ); ?>"><?php esc_html_e('Expired', 'madang'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>    <!-- /product-main -->
                        </div>
                    <?php $count++; endwhile; ?>
                </div>
                <?php madang_pagination( $products ); ?> 
            </div>  
            <div class="separates"></div>
        </div> 
        <?php endif; ?>

    <?php endif;
    wp_reset_postdata();
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}