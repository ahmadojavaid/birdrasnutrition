<?php
    
    /**
     * Sayidan_Popular_Posts widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'popular_posts_widget' );
    
    function popular_posts_widget() {
        
        register_widget( 'Sayidan_Popular_Post_Widget' );
    }

    class Sayidan_Popular_Post_Widget extends WP_Widget {
        
        function Sayidan_Popular_Post_Widget() {
            $widget_ops = array( 'classname' => 'sayidan_popular_posts', 'description' => __( 'A widget that displays popular posts ', 'sayidan' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sayidan_popular_posts' );
            parent::__construct( 'sayidan_popular_posts', __( 'Sayidan Popular Posts', 'sayidan'), $widget_ops, $control_ops );
        }
        
        function widget($args, $instance) {
            
            $cache = wp_cache_get( 'widget_popular_posts', 'widget' );
            
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
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Popular Posts', 'sayidan' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            //echo $number; die;
            $args_q = array(
                          'post_status'             => 'publish',
                          'ignore_sticky_posts'     => true,
                          'no_found_rows'           => true,
                          'posts_per_page'          => $number,
                          'no_found_rows'           => true,
                          'orderby'                 => 'comment_count',
                          'order'                   => 'DESC',
                          );
                          
            $r = new WP_Query( apply_filters( 'widget_posts_args', $args_q ) );
            
            if ( $r->have_posts() ) : ?>
                <?php echo $before_widget; ?>
                <div class="block-item popurlar-port">
                    <?php if ( $title ) : ?>
                        <div class="block-title text-center">
                            <h5 class="text-regular text-uppercase"><?php echo $title; ?></h5>
                        </div>
                    <?php endif; ?>
                    <ul>
                        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                            <li>
                                <div class="area-img">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'sayidan-thumb', array( 'class' => 'img-responsive' ) ); ?>
                                    </a>
                                </div>
                                <div class="area-content <?php if ( !has_post_thumbnail() ) { echo 'area-content-large'; } ?>">
                                    <h6>
                                        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                    </h6>
                                    <div class="stats">
                                        <span class="clock">
                                            <span class="icon clock-icon"></span>
                                            <span class="text-content text-light"><?php echo date( 'd M Y', get_post_time( 'U', true ) ); ?></span>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php echo $after_widget; ?>
                <?php
                wp_reset_postdata();
            endif;
    
            $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_popular_posts', $cache, 'widget' );
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
            wp_cache_delete( 'widget_popular_posts', 'widget' );
        }
        
        function form( $instance ) {
            $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
            $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5; ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'sayidan' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'sayidan' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
            <?php
        }
    }
?>