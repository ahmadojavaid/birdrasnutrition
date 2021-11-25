<?php
    
    /**
     * Twitter widget class
     *
     * @since 1.0.0
     */
    
    add_action( 'widgets_init', 'twitter_widget' );
    
    function twitter_widget() {
        
        register_widget( 'Sayidan_Twitter_Widget' );
    }

    class Sayidan_Twitter_Widget extends WP_Widget {
        
        function Sayidan_Twitter_Widget() {
            $widget_ops = array( 'classname' => 'sayidan_twitter', 'description' => __( 'A widget that displays tweets', 'sayidan' ) );
            $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sayidan_twitter' );
            parent::__construct( 'sayidan_twitter', __( 'Sayidan Tweets', 'sayidan'), $widget_ops, $control_ops );
        }
        
        function widget( $args, $instance ) {
            
            $cache = wp_cache_get( 'widget_twitter', 'widget' );
            
            if ( !is_array( $cache ) ){
                $cache = array();
            }
            
            if ( ! isset( $args['widget_id'] ) ) {
                $args['widget_id'] = $this->id;
            }
            
            if ( isset( $cache[$args['widget_id']] ) ) {
                $cache[$args['widget_id']];
                return;
            }
            
            ob_start();
            extract($args);
            
            $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Twitter', 'sayidan' ) : $instance['title'], $instance, $this->id_base );
            if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
                $number = 4;
            }
            
            //check settings and die if not set
            // if ( empty( get_theme_mod( 'twitter_c_key' ) ) || empty( get_theme_mod( 'twitter_c_secret' ) ) || empty( get_theme_mod( 'twitter_c_secret' ) ) || empty( get_theme_mod( 'twitter_c_secret' ) ) || empty( get_theme_mod( 'twitter_cache' ) ) || empty( get_theme_mod( 'twitter_username' ) ) ){
            //     echo '<strong>'.__('Please fill all widget settings!','tp_tweets').'</strong>' . esc_html( $after_widget );
            //     return;
            // }

            //check if cache needs update
            $sayidan_twitter = get_option( 'sayidan_twitter' );
            $diff = time() - $sayidan_twitter;
            $crt = get_theme_mod( 'twitter_cache' ) * 3600;

            //	yes, it needs update
            if ( $diff >= $crt || empty( $sayidan_twitter ) ){

                if ( !require_once(  plugin_dir_path(__FILE__) . 'recent-tweets-widget/twitteroauth.php' ) ){
                    echo '<strong>'.__('Couldn\'t find twitteroauth.php!','tp_tweets').'</strong>' . esc_html( $after_widget );
                    return;
                }

                function getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
                    $connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
                    return $connection;
                }

                $connection = getConnectionWithAccessToken( get_theme_mod( 'twitter_c_key' ), get_theme_mod( 'twitter_c_secret' ), get_theme_mod( 'twitter_a_token' ), get_theme_mod( 'twitter_a_secret' ) );
                $tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".get_theme_mod( 'twitter_username' )."&count=10&exclude_replies=".$instance['excludereplies'] ) or die( 'Couldn\'t retrieve tweets! Wrong username?' );

                if( !empty( $tweets->errors ) ){
                    if($tweets->errors[0]->message == 'Invalid or expired token'){
                        echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />' . __('You\'ll need to regenerate it <a href="https://apps.twitter.com/" target="_blank">here</a>!','tp_tweets') . esc_html( $after_widget );
                    }else{
                        echo '<strong>'.$tweets->errors[0]->message.'</strong>' . esc_html( $after_widget );
                    }
                    return;
                }

                $tweets_array = array();
                for( $i = 0;$i <= count( $tweets ); $i++ ){
                    if( !empty( $tweets[$i] ) ){
                        $tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
                    
                        //clean tweet text
                        $tweets_array[$i]['text'] = preg_replace( '/[\x{10000}-\x{10FFFF}]/u', '', $tweets[$i]->text );
                    
                        if( !empty( $tweets[$i]->id_str ) ){
                            $tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
                        }
                    }
                }
                    
                //save tweets to wp option
                update_option( 'sayidan_twitter_plugin_tweets', serialize( $tweets_array ) );
                update_option( 'sayidan_twitter', time() );
                    
                echo '<!-- twitter cache has been updated! -->';
            }
        ?>

        <div class="block-item twitter">
            <?php if ( $title ) : ?>
            <div class="block-title text-center">
                <h5 class="text-regular text-uppercase"><?php echo esc_html( $title ); ?></h5>
            </div>
            <?php endif; ?>
        <?php
            
        $sayidan_twitter_plugin_tweets = maybe_unserialize( get_option( 'sayidan_twitter_plugin_tweets' ) );
        if( !empty( $sayidan_twitter_plugin_tweets ) && is_array( $sayidan_twitter_plugin_tweets ) ){ ?>
            <?php echo $before_widget; ?>
            <div class="block-content">
                <div class="twitter-wrapper text-center">
                    <div class="twitter-icon color-theme">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </div>
                    <div class="twitter-content">

                        <?php $fctr = '1';
                        foreach ( $sayidan_twitter_plugin_tweets as $tweet ){
                            if ( !empty( $tweet['text'] ) ){
                                if ( empty( $tweet['status_id'] ) ){ $tweet['status_id'] = ''; }
                                if ( empty( $tweet['created_at'] ) ){ $tweet['created_at'] = ''; }
                                ?>
                                <div class="twitter-desc">
                                <p class="text-light text-center">“<?php echo tp_convert_links( $tweet['text'] ); ?>“</p>
                                    <div class="twitter-user">
                                        <a href="https://twitter.com/<?php echo get_theme_mod( 'twitter_username' ); ?>" class="text-regular color-theme">@<?php echo get_theme_mod( 'twitter_username' ); ?></a>
                                    </div>
                                </div>
                                <?php
                                if ( $fctr == $instance['tweetstoshow'] ){ break; }
                                $fctr++;
                            }
                        } ?>
                    </div>
                </div>
            </div>
            <?php echo $after_widget; ?>
        <?php
        }else{
            print '
            <div class="tp_recent_tweets">
            ' . __('<b>Error!</b> Couldn\'t retrieve tweets for some reason!','tp_tweets') . '
            </div>';
        }
        ?>
        </div>

        <?php $cache[$args['widget_id']] = ob_get_flush();
            wp_cache_set( 'widget_twitter', $cache, 'widget' );
        }

        function flush_widget_cache() {
            wp_cache_delete( 'widget_twitter', 'widget' );
        }
        
        //save widget settings
        public function update($new_instance, $old_instance) {
            $instance = array();
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
            $instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
            $instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
            $instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
            $instance['cachetime'] = strip_tags( $new_instance['cachetime'] );
            $instance['username'] = strip_tags( $new_instance['username'] );
            $instance['tweetstoshow'] = strip_tags( $new_instance['tweetstoshow'] );
            $instance['excludereplies'] = strip_tags( $new_instance['excludereplies'] );
            
            if($old_instance['username'] != $new_instance['username']){
                delete_option('sayidan_twitter');
            }
            
            return $instance;
        }
            
            
        //widget settings form
        public function form($instance) {
            $defaults = array( 'title' => '', 'consumerkey' => '', 'consumersecret' => '', 'accesstoken' => '', 'accesstokensecret' => '', 'cachetime' => '', 'username' => '', 'tweetstoshow' => '' );
            $instance = wp_parse_args( (array) $instance, $defaults );
            
            echo '
            <p>Get your API keys &amp; tokens at:<br /><a href="https://apps.twitter.com/" target="_blank">https://apps.twitter.com/</a></p>
            <p><label>' . __('Title:','tp_tweets') . '</label>
            <input type="text" name="'.$this->get_field_name( 'title' ).'" id="'.$this->get_field_id( 'title' ).'" value="'.esc_attr($instance['title']).'" class="widefat" /></p>
            <p><label>' . __('Tweets to display:','tp_tweets') . '</label>
            <select type="text" name="'.$this->get_field_name( 'tweetstoshow' ).'" id="'.$this->get_field_id( 'tweetstoshow' ).'">';
            $i = 1;
            for($i; $i <= 10; $i++){
                echo '<option value="'.$i.'"'; if($instance['tweetstoshow'] == $i){ echo ' selected="selected"'; } echo '>'.$i.'</option>';
            }
            echo '
            </select></p>';

        }
            
            
    }
            
    //convert links to clickable format
    if (!function_exists('tp_convert_links')) {
        function tp_convert_links($status,$targetBlank=true,$linkMaxLen=250){
            
            // the target
            $target=$targetBlank ? " target=\"_blank\" " : "";
            
            // convert link to url
            $status = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[A-Z0-9+&@#\/%=~_|]/i', '<a href="\0" target="_blank">\0</a>', $status);
            
            // convert @ to follow
            $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
            
            // convert # to search
            $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
            
            // return the status
            return $status;
        }
    }


    //convert dates to readable format
    if (!function_exists('tp_relative_time')) {
        function tp_relative_time($a) {
            //get current timestampt
            $b = strtotime('now');
            //get timestamp when tweet created
            $c = strtotime($a);
            //get difference
            $d = $b - $c;
            //calculate different time values
            $minute = 60;
            $hour = $minute * 60;
            $day = $hour * 24;
            $week = $day * 7;
            
            if(is_numeric($d) && $d > 0) {
                //if less then 3 seconds
                if($d < 3) return __('right now','tp_tweets');
                //if less then minute
                if($d < $minute) return floor($d) . __(' seconds ago','tp_tweets');
                //if less then 2 minutes
                if($d < $minute * 2) return __('about 1 minute ago','tp_tweets');
                //if less then hour
                if($d < $hour) return floor($d / $minute) . __(' minutes ago','tp_tweets');
                //if less then 2 hours
                if($d < $hour * 2) return __('about 1 hour ago','tp_tweets');
                //if less then day
                if($d < $day) return floor($d / $hour) . __(' hours ago','tp_tweets');
                //if more then day, but less then 2 days
                if($d > $day && $d < $day * 2) return __('yesterday','tp_tweets');
                //if less then year
                if($d < $day * 365) return floor($d / $day) . __(' days ago','tp_tweets');
                //else return more than a year
                return __('over a year ago','tp_tweets');
            }
        }	
    }
            
?>