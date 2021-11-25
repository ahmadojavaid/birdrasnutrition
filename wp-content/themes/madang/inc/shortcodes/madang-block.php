<?php
function madang_block_shortcode($atts, $content = null) {
	$atts = shortcode_atts(array(
        "id" => '',
		"image" => '',
		"title" => '',
		"subtitle" => '',
		"placeholder" => '',
		"button_text" => ''
	), $atts);

	ob_start();

    // get Page ID by slug
    global $wpdb, $post;
    $post_id = $wpdb->get_var( $wpdb->prepare(
      "SELECT ID FROM {$wpdb->posts} WHERE post_name = '%s' ",
      $atts['id'] //function will do the sanitization for you
    ) );

    $permalink =  get_permalink($post_id); 
    if($post_id){
        
        $html = apply_filters( 'the_content', get_post_field( 'post_content', $post_id), $atts );        
        $html = do_shortcode( $html );
        
    } else{
        
        $html = '<p><mark>'.esc_attr( 'Block', 'madang' ).' <b>"'.esc_attr( $atts['id'] ).'"</b> '.esc_attr( 'not found.', 'madang' ).'</mark></p>';
        
    }
    return $html;
    
	?>

    <?php
    $content = ob_get_contents();
	ob_end_clean();
	return $content;
}
    
function madang_shortcode_blocks_row($atts, $content = null) {
    $atts = shortcode_atts(array(
     "id" => '',
    ), $atts);
    
    ob_start();
    ?>
    <div class="block-links">
        <div class="container">
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
    