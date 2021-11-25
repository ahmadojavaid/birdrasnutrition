<?php
    
    /**
     * madang_ecommerce_calories widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'madang_ecommerce_calories' );
    
    function madang_ecommerce_calories() {
        
        register_widget( 'madang_ecommerce_calories' );
    }

    class madang_ecommerce_calories extends WP_Widget {
        
        function madang_ecommerce_calories() {
            $widget_ops = array( 'classname' => 'madang_popular_calories', 'description' => __( 'A widget that displays ecommerce calories', 'madang' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madang_ecommerce_calories' );
            parent::__construct( 'madang_ecommerce_calories', __( 'WooCommerce Ajax Calories Filter', 'madang' ), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_ecommerce_calories', 'widget' );
            
            if ( !is_array($cache) ){
                $cache = array();
            }
            
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                echo $cache[ $args['widget_id'] ];
                //echo esc_html( $cache[ $args['widget_id'] ] );
                return;
            }
            
            ob_start();
            extract($args);
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Calories', 'madang' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            ?>
            <?php echo $before_widget; ?>

            <!-- calories range -->
            <div class="menu-sidebox-wrap wow fadeInLeft">

                <h2 class="title text-sp text-lt widgettitle"><?php echo esc_html( $title ); ?></h2>
                <div class="calories-range">
                    
                    <div id="slider-range" data-maxvalue="<?php echo esc_attr( $number ); ?>"></div>                                    
                    <div class="range-wrap text-sp"> 
                        <table>
                            <tr>
                                <td><?php esc_attr_e( 'Calories :', 'madang' ) ?></td>
                                <td><input type="text" id="amount" class="calories-amount"></td>
                                <input type="hidden" id="calories-amount-min" >
                                <input type="hidden" id="calories-amount-max" >
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <!-- calories range ends -->

            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();
           

            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_ecommerce_calories', $cache, 'widget' );
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
            wp_cache_delete( 'widget_ecommerce_calories', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; ?>
            <p><label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'madang' ); ?></label>
            <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Max value:', 'madang' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" size="3" /></p>
            <?php
        }
    }


    add_action( 'widgets_init', 'madang_ecommerce_pricing' );
    
    function madang_ecommerce_pricing() {
        
        register_widget( 'madang_ecommerce_pricing' );
    }

    class madang_ecommerce_pricing extends WP_Widget {
        
        function madang_ecommerce_pricing() {
            $widget_ops = array( 'classname' => 'madang_popular_pricing', 'description' => __( 'A widget that adds pricing filter', 'madang' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'madang_ecommerce_pricing' );
            parent::__construct( 'madang_ecommerce_pricing', __( 'WooCommerce Ajax Pricing Filter', 'madang' ), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_ecommerce_pricing', 'widget' );
            
            if ( !is_array($cache) ){
                $cache = array();
            }
            
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            if ( isset( $cache[ $args['widget_id'] ] ) ) {
                //echo esc_html( $cache[ $args['widget_id'] ] );
                echo $cache[ $args['widget_id'] ];
                return;
            }
            
            ob_start();
            extract($args);
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Pricing', 'madang' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            if ( empty( $instance['number_min'] ) || ! $number_min = absint( $instance['number_min'] ) ) {
                $number_min = 4;
            }
            ?>
            <?php echo $before_widget; ?>

            <!-- pricing range -->
            <div class="menu-sidebox-wrap wow fadeInLeft">

                <h2 class="title text-sp text-lt widgettitle"><?php echo esc_html( $title ); ?></h2>
                <div class="pricing-range">
                
                    <div id="pricing-range" data-maxvalue="<?php echo esc_attr( $number ); ?>" data-minvalue="<?php echo esc_attr( $number_min ); ?>"></div>                                
                    <div class="range-wrap text-sp"> 
                        <table>
                            <tr>
                                <td><?php esc_attr_e( 'Pricing :', 'madang' ) ?></td>
                                <td><input type="text" id="pricing-amount" class="pricing-amount"></td>
                                <input type="hidden" id="pricing-amount-min" >
                                <input type="hidden" id="pricing-amount-max" >
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <!-- pricing range ends -->

            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();
           

            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_ecommerce_pricing', $cache, 'widget' );
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
            wp_cache_delete( 'widget_ecommerce_pricing', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
            $number_min    = isset( $instance['number_min'] ) ? absint( $instance['number_min'] ) : 5; ?>
            <p><label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'madang' ); ?></label>
            <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number_min' ); ?>"><?php _e( 'Min value:', 'madang' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number_min' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number_min' )); ?>" type="text" value="<?php echo esc_html($number_min); ?>" size="10" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Max value:', 'madang' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" size="10" /></p>
            <?php
        }
    }
?>