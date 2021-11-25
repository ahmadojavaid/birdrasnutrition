<?php
    
    /**
     * madang_ecommerce_featured widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'ecommerce_featured' );
    
    function ecommerce_featured() {
        
        register_widget( 'madang_ecommerce_featured' );
    }

    class madang_ecommerce_featured extends WP_Widget {
        
        function madang_ecommerce_featured() {
            $widget_ops = array( 'classname' => 'madang_popular_tags', 'description' => __( 'A widget that displays ecommerce featured', 'madang' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madang_ecommerce_featured' );
            parent::__construct( 'madang_ecommerce_featured', __( 'WooCommerce Ajax Product Featured', 'madang'), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_ecommerce_featured', 'widget' );
            
            if ( !is_array($cache) ){
                $cache = array();
            }
            
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            // if ( isset( $cache[ $args['widget_id'] ] ) ) {
            //     echo esc_html( $cache[ $args['widget_id'] ] );
            //     return;
            // }
            
            ob_start();
            extract($args);
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Tags', 'madang' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            ?>
            <?php echo $before_widget; ?>
            <?php
            $meta_query   = WC()->query->get_meta_query();
            $meta_query[] = array(
                'key'   => '_featured',
                'value' => 'yes'
            );
            $args = array(
                'post_type'   =>  'product',
                'stock'       =>  1,
                'showposts'   =>  6,
                'orderby'     =>  'date',
                'order'       =>  'DESC',
                'meta_query'  =>  $meta_query
            );
            ?>
            <!--seller list-->
            <div class="menu-sidebox-wrap seller-list wow fadeInLeft">
                <h2 class="title text-sp text-lt widgettitle"><?php echo esc_html( $title ); ?></h2>
                <ul>
                    <?php $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

                            <li>
                                <figure><a href="<?php echo get_permalink( $loop->post->ID ); ?>" data-id="<?php echo $loop->post->ID; ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?> " > 
                                    <?php 
                                    if ( has_post_thumbnail( $loop->post->ID ) ) 
                                        echo get_the_post_thumbnail( $loop->post->ID, 'madang-thumb' ); 
                                    else 
                                        echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="110px" height="90px" />'; 
                                    ?></a>
                                </figure>
                            
                                <h6><a href="<?php echo get_permalink( $loop->post->ID ); ?>" data-id="<?php echo $loop->post->ID; ?>" class="<?php if ( 1 == get_theme_mod( 'madang_popup' ) ){ echo 'product_modal_ajax';} ?> txcolor"><?php echo $product->get_title(); ?></a></h6>
                                <h6 class="price"><?php echo $product->get_price_html(); ?></h6>
                            </li>

                    <?php endwhile;
                    wp_reset_query(); ?>
                </ul>
            </div>
            <!-- seller list ends -->

            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();
           

            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_ecommerce_featured', $cache, 'widget' );
        }
        
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['number'] = (int) $new_instance['number'];
            $this->flush_widget_cache();
            
            $alloptions = wp_cache_get( 'alloptions', 'options' );
            if ( isset( $alloptions['widget_popular_entries'] ) )
                delete_option( 'widget_popular_entries' );
            
            return $instance;
        }
        
        function flush_widget_cache() {
            wp_cache_delete( 'widget_ecommerce_featured', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; ?>
            <p><label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php echo esc_html( 'Title:', 'madang' ); ?></label>
            <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo esc_html( 'Go to products list click on featured star to add individual product here', 'madang' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" type="hidden" value="<?php echo esc_html($number); ?>" size="3" /></p>
            <?php
        }
    }
?>