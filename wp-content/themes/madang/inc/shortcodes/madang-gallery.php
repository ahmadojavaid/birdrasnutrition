<?php
/*
Widget Name: Madang Gallery Widget
Description: Create Gallery Section
Author: Kenzap
Author URI: http://kenzap.com
Widget URI: http://kenzap.com/,
Video URI: http://kenzap.com/
*/

if( class_exists( 'SiteOrigin_Widget' ) ) : 

class madang_gallery_widget extends SiteOrigin_Widget {

    function __construct() {
        //Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        //Call the parent constructor with the required arguments.
        parent::__construct(
            // The unique id for your widget.
            'madang_gallery_widget',

            // The name of the widget for display purposes.
            esc_html__('Madang Gallery', 'madang'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => esc_html__('Create Gallery Signup Section', 'madang'),
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
                    'label' => esc_html__('Gallery title ', 'madang'),
                    'description' => esc_html__('Go to Gallery > Add New section to add new gallery items', 'madang'),
                    'default' => ''
                ),
                'show_header' => array(
                    'type' => 'checkbox',
                    'label' => esc_html__('Show header', 'madang'),
                ),
                'images_per_page' => array(
                    'type' => 'text',
                    'label' => esc_html__('Max images to query', 'madang'),
                    'default' => ''
                ),
                'category' => array(
                    'type' => 'text',
                    'label' => esc_html__('Category', 'madang'),
                    'description' => esc_html__('Restrict gallery to certain category', 'madang'),
                    'default' => ''
                ),
                'text' => array(
                    'type' => 'text',
                    'label' => esc_html__('Text', 'madang'),
                    'default' => ''
                ),              
                'icon' => array(
                    'type' => 'text',
                    'label' => esc_html__('Icon', 'madang'),
                    'default' => ''
                ),
                'class' => array(
                    'type' => 'text',
                    'label' => esc_html__('Class', 'madang'),
                    'default' => ''
                ),
                'type' => array(
                    'type' => 'radio',
                    'label' => esc_html__( 'Choose gallery type', 'madang' ),
                    'default' => 'simple',
                    'options' => array(
                        'normal' => esc_html__( 'Normal', 'madang' ),
                        'carousel' => esc_html__( 'Carousel', 'madang' ),
                        'minified' => esc_html__( 'Minified', 'madang' ),     
                        'menu' => esc_html__( 'Menu', 'madang' ), 
                        'categories' => esc_html__( 'Categories/Links', 'madang' ), 
                    )
                ),
          
            ),

            //The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_template_name($instance) {
        return 'madang-gallery';
    }

    function get_template_dir($instance) {
        return 'widgets';
    }
}

siteorigin_widget_register('madang_gallery_widget', __FILE__, 'madang_gallery_widget');

endif;

function madang_shortcode_gallery($atts, $content = null) {
	$atts = shortcode_atts(array(
		"title"             => '',
		"pagination"        => 'true',
        "images_per_page"   => '16',
        "show_header"       => 'true',
        "type"              => 'normal',
        "link"              => '',
        "text"              => '',
        "icon"              => '',
        "class"             => '',
        "link"              => '',
        "link"              => '',
		"category"          => ''
	), $atts);  
	ob_start();
    
    if( 'normal' == $atts['type'] ) :
	?>

    <div class="galery-wrapper">
        <div class="container">
            <?php if( $title ) : ?>
            <div class="galery-title text-center">
                <h4 class="heading-regular"><?php echo esc_html( $title ); ?></h4>
            </div>
            <?php endif; ?>
            <div class="galery-content">
                <ul>
                    <?php
                    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                    $args = array(
                                  'post_status'     => 'publish',
                                  'post_type'       => 'gallery',
                                  'category_name'   => $category,
                                  'posts_per_page'  => $images_per_page,
                                  'paged'           => $paged,
                                  );
                                  $postCount = 0;
                                  $recentPosts = new WP_Query( $args );
                                  
                    if ( $recentPosts->have_posts() ) :
                        while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
                    ?>
                    
                    <li class="col-sm-3 col-xs-6">
                        <div class="galery-item">
                            <?php the_post_thumbnail( 'madang-gallery', array( 'class' => 'img-responsive' ) ); ?>
                            <div class="galery-content">
                                <h4><?php echo the_title();?></h4>
                                <a href="#" class="popup-click"><span class="lnr lnr-magnifier"></span></a>
                            </div>
                            <div class="box-content-item">
                                <div class="box-img">
                                    <?php the_post_thumbnail( 'madang-story-large', array( 'class' => 'img-responsive' ) ); ?>
                                </div>
                                <div class="desc">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <?php  endwhile;
                    endif;
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <?php if( $pagination == 'true'){ madang_pagination( $recentPosts ); } ?>

        </div>
        
        <div class="bg-popup"></div>
        <div class="wrapper-popup">
            <a href="javascript:void(0)" class="close-popup"><span class="lnr lnr-cross-circle"></span></a>
            <div class="popup-content">
                <!--content-popup   -->
            </div>
        </div>
    </div>

    <?php elseif( 'minified' == $atts['type'] ) : ?>

    <!-- ============== instagram block starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> instagram-block">
        <div class="container">
            <div class="top-text-header text-center">
                <h4 class="text-uppercase text-sp text-lt"><?php echo esc_attr( $atts['title'] ); ?></h4>
                <span class="follow-at text-spx text-lt txcolor"><?php echo esc_attr( $atts['text'] ); ?></span>
            </div>
        </div>
        <div class="instagram-image-row">
            <ul><?php $args = array(
                'post_status'     => 'publish',
                'post_type'       => 'gallery',
                'category_name'   => $atts['category'],
                'posts_per_page'  => $atts['images_per_page'],
                );
                $recentPosts = new WP_Query( $args );
                if ( $recentPosts->have_posts() ) :
                    while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?><li class="no-padding no-margin no-style" style="width:<?php echo 100/intVal( $atts['images_per_page'] );?>%"><figure><a data-toggle="lightbox" data-gallery="example-gallery" class="lightbox" href="<?php echo the_post_thumbnail_url( 'full' ); ?>"><?php the_post_thumbnail( 'madang-gallery', array( 'class' => 'img-responsive' ) ); ?></a></figure></li><?php endwhile;
                endif;
                ?></ul>
        </div>
    </section>

    <?php elseif( 'carousel' == $atts['type'] ) : ?>

    <!-- ============== featured menu carousel starts ============== -->
    <section class="<?php echo esc_attr( $atts['class'] ); ?> featured-menu-carousel">
        <div class="container">
            <?php if ( 'true' == $atts['show_header'] ) : ?>
            <!-- == top text header starts == -->
            <div class="wow fadeInUp top-text-header text-center animated" >
                <h4 class="text-uppercase text-sp text-lt"><?php echo esc_attr( $atts['title'] ); ?></h4>
            </div>
            <!-- == top text header ends == -->
            <?php endif; ?>
            <!-- == carousel starts == -->
            <div class="carousel-container">
                <div id="carousel">
                    <?php $args = array(
                    'post_status'     => 'publish',
                    'post_type'       => 'gallery',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category',   // taxonomy name
                            'field' => 'name',           // term_id, slug or name
                            'terms' => esc_attr( $atts['category'] ),                  // term id, term slug or term name
                        )
                    ),
                    'posts_per_page'  => esc_attr( $atts['images_per_page'] ),
                    );

                    $recentPosts = new WP_Query( $args );
                    if ( $recentPosts->have_posts() ) :
                        while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
                        $meta = get_post_meta( get_the_ID() );  ?>
                        <div class="carousel-feature feature-slide active">
                            <a href="<?php echo esc_url( $meta['madang_url'][0] ); ?>"><?php the_post_thumbnail( 'madang-gallery-carousel', array( 'class' => 'img-responsive' ) ); ?></a>
                            <div class="carousel-caption">
                                <p><?php echo the_title(); ?></p>
                            </div>
                        </div>
                    <?php endwhile;
                    endif;
                    ?>
                </div>
                <div id="carousel-left"><img alt="arrow left" src="<?php echo get_stylesheet_directory_uri() .'/images/arrow-left.png'; ?>" /></div>
                <div id="carousel-right"><img alt="arrow right" src="<?php echo get_stylesheet_directory_uri() .'/images/arrow-right.png'; ?>" /></div>
            </div>
            <!-- == carousel ends == -->
        </div>
    </section>
    <!-- ============== featured menu carousel ends ============== -->

    <?php elseif( 'menu' == $atts['type'] ) : ?>

    <!-- ============== featured menu block starts ============== -->
    <section class="block featured-menu-block">
        <?php if ( 'true' == $atts['show_header'] ) : ?>
        <div class="container">
            <!-- == top text header starts == -->
            <div class="wow fadeInUp top-text-header text-center">
                <h4 class="text-uppercase text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h4>
            </div>
            <!-- == top text header ends == -->
        </div>
        <?php endif; ?>
        <!-- == featured menu slider starts == -->
        <div class="wow fadeInUp featured-menu-slider">
            <div class="container">
                <ul class="bxslider1 row">

                    <?php $args = array(
                    'post_status'     => 'publish',
                    'post_type'       => 'gallery',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category',   // taxonomy name
                            'field' => 'name',                      // term_id, slug or name
                            'terms' => esc_attr( $atts['category'] ),   // term id, term slug or term name
                        )
                    ),
                    'posts_per_page'  => esc_attr( $atts['images_per_page'] ),
                    );

                    $recentPosts = new WP_Query( $args );
                    if ( $recentPosts->have_posts() ) :
                        while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
                        $meta = get_post_meta( get_the_ID() );
                        $img_link = (isset($meta['madang_url'])?$meta['madang_url'][0]:get_the_post_thumbnail_url()); ?>

                        <li class="col-xs-12 col-sm-3">
                            <a  <?php if (!isset($meta['madang_url'])){ echo 'data-toggle="lightbox" class="lightbox" '; } ?> href="<?php echo esc_url($img_link); ?>">
                                <figure><?php the_post_thumbnail( 'madang-gallery', array( 'class' => 'img-responsive' ) ); ?></figure>
                                <div class="menu-info">
                                    <h6 class="text-capitalize text-lt text-sp txcolor"><?php echo the_title(); ?></h6>
                                    <span><?php echo get_the_excerpt(); ?></span>
                                </div>
                            </a>
                        </li>
                        <?php endwhile;
                    endif;
                    ?>
                </ul>
            </div>
        </div>
        <!-- == featured menu slider ends == -->
    </section>
    <!-- ============== featured menu block ends ============== -->

    <?php elseif( 'categories' == $atts['type'] ) : ?>

    <!-- ================== menu cateogry list====================-->
    <section class="block cat-list-wrap">
        <div class="container">

            <?php if ($atts['title']!='') { ?>
                <div class="row">
                    <div class="col-sm-12 top-text-header text-center wow fadeInUp">
                        <h4 class="text-uppercase text-lt text-sp"><?php echo esc_attr( $atts['title'] ); ?></h4>
                    </div>
                </div>
            <?php } ?>

            <?php
            $arg = array(
                  'post_status'     => 'publish',
                  'post_type'       => 'gallery',
                  'category_name'   => $atts['category'],
                  'posts_per_page'  => $atts['images_per_page'],
                  );
                  $postCount = 0;
            
            $recentPosts = new WP_Query( $arg );
            if ( $recentPosts->have_posts() ) :
                while ( $recentPosts->have_posts() ) : $recentPosts->the_post();
                $meta = get_post_meta( get_the_ID() );
                $img_link = (isset($meta['madang_url'])?$meta['madang_url'][0]:get_the_post_thumbnail_url());

                ?>
               
                <!--single cat -->
                <div class="col-sm-3 cat-wrap wow fadeInLeft">
                    <a href="<?php echo esc_url($img_link); ?>">
                        <span><?php echo the_title(); ?></span>
                        <figure>
                            <?php if ( isset( $img_link  ) ) : ?>
                                <?php the_post_thumbnail( 'madang-gallery', array( 'class' => 'img-responsive' ) ); ?>
                            <?php endif; ?>
                        </figure>
                    </a>
                </div>
                <!-- singel cat ends-->

                <?php endwhile;
            endif;
            ?>

        </div>
    </section>
    <!-- ================== menu cateogry list ends====================-->

    <?php endif; 
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
    
