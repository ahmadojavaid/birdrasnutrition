<?php
    
    /**
     * Sayidan_Popular_tags widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'popular_tags_widget' );
    
    function popular_tags_widget() {
        
        register_widget( 'Sayidan_Popular_Tags_Widget' );
    }

    class Sayidan_Popular_Tags_Widget extends WP_Widget {
        
        function Sayidan_Popular_Tags_Widget() {
            $widget_ops = array( 'classname' => 'sayidan_popular_tags', 'description' => __( 'A widget that displays popular tags ', 'sayidan' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sayidan_popular_tags' );
            parent::__construct( 'sayidan_popular_tags', __( 'Sayidan Popular Tags', 'sayidan'), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_popular_tags', 'widget' );
            
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
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Tags', 'sayidan' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            ?>
            <?php echo $before_widget; ?>
            <div class="block-item tag ">
                <?php if ( $title ) : ?>
                    <div class="block-title text-center">
                        <h5 class="text-regular text-uppercase"><?php echo esc_html( $title ); ?></h5>
                    </div>
                <?php endif; ?>
                <div class="block-content">
                    <ul class="list-inline">
                        <?php $tags = get_tags();
                            if ( $tags ) :
                                foreach ( $tags as $tag ) : ?>
                                    <li><a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo esc_html( $tag->name ); ?></a></li>
                                <?php endforeach;
                            endif;
                        ?>
                    </ul>
                </div>
            </div>
            <?php echo $after_widget; ?>
            <?php
            wp_reset_postdata();
           
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_popular_tags', $cache, 'widget' );
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
            wp_cache_delete( 'widget_popular_tags', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; ?>
            <p><label for="<?php echo esc_html($this->get_field_id( 'title' )); ?>"><?php _e( 'Title:', 'sayidan' ); ?></label>
            <input class="widefat" id="<?php echo esc_html($this->get_field_id( 'title' )); ?>" name="<?php echo esc_html($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'sayidan' ); ?></label>
            <input id="<?php echo esc_html($this->get_field_id( 'number' )); ?>" name="<?php echo esc_html($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_html($number); ?>" size="3" /></p>
            <?php
        }
    }
?>