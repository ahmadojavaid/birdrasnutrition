<?php
    
    /**
     * madang_ecommerce_tags widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'ecommerce_tags' );
    
    function ecommerce_tags() {
        
        register_widget( 'madang_ecommerce_tags' );
    }

    class madang_ecommerce_tags extends WP_Widget {
        
        function madang_ecommerce_tags() {
            $widget_ops = array( 'classname' => 'madang_popular_tags', 'description' => __( 'A widget that displays ecommerce tags', 'madang' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madang_ecommerce_tags' );
            parent::__construct( 'madang_ecommerce_tags', __( 'WooCommerce Ajax Product Tags', 'madang'), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_ecommerce_tags', 'widget' );
            
            if ( !is_array($cache) ){
                $cache = array();
            }
            
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                echo $cache[ $args['widget_id'] ];
                return;
            }
            
            ob_start();
            extract($args);
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Tags', 'madang' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            ?>
            <?php echo $before_widget; ?>
            <div class="menu-sidebox-wrap ingredient-tags wow fadeInLeft">
                <h2 class="title text-sp text-lt widgettitle"><?php echo esc_html( $title ); ?></h2>
                <ul class="side-cat-list">
                    <?php $args = array(
                        'number'     => $number,
                        //'orderby'    => $orderby,
                        //'order'      => $order,
                        //'hide_empty' => $hide_empty,
                        //'include'    => $ids
                    );

                    $product_tags = get_terms( 'product_tag', $args );
                    //$tags = get_tags();
                        if ( $product_tags ) : ?>
                            <li class="e_tags" data-tag=""><span class="active hvr-wobble-top"><?php esc_attr_e( 'All Tags', 'madang' ) ?></span>
                            <?php foreach ( $product_tags as $tag ) : ?>
                                <li class="e_tags" data-tag="<?php echo esc_html( $tag->name ); ?>"><span class="hvr-wobble-top"><?php echo esc_html( $tag->name ); ?></span></li>
                            <?php endforeach;
                        endif;
                    ?>                                  
                </ul>
            </div>
            <?php echo $after_widget; ?>
            <?php wp_reset_postdata();
           

            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_ecommerce_tags', $cache, 'widget' );
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
            wp_cache_delete( 'widget_ecommerce_tags', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; ?>
            <p><label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'madang' ); ?></label>
            <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'madang' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" size="3" /></p>
            <?php
        }
    }
?>