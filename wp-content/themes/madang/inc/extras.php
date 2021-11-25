<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Madang
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function madang_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
    
function madang_string_limit_words( $string, $word_limit ) {
    
    $words = explode(' ', $string, ($word_limit + 1));
    if(count($words) > $word_limit)
        array_pop($words);
    return implode(' ', $words);
}

    
function madang_human_timing( $time ){
    
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
                     31536000 => esc_html__( 'year', 'madang' ),
                     2592000 => esc_html__( 'month', 'madang' ),
                     604800 => esc_html__( 'week', 'madang' ),
                     86400 => esc_html__( 'day', 'madang' ),
                     3600 => esc_html__( 'hour', 'madang' ),
                     60 => esc_html__( 'minute', 'madang' ),
                     1 => esc_html__( 'second', 'madang' ),
                     );
    
    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

/* Fix Normal Shortcodes */
function madang_fix_shortcode($content){
    
    $fix = array (
                  '_____' => '<div class="tx-div large"></div>',
                  '____' => '<div class="tx-div medium"></div>',
                  '___' => '<div class="tx-div small"></div>',
                  '</div></p>' => '</div>',
                  '<p><div' => '<div',
                  ']</p>' => ']',
                  ']<br />' => ']',
                  '<p>[' => '[',
                  '<br />[' => '[',
                  );
    $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
    $content = strtr( $content, $fix );
    
    return do_shortcode( $content );
}

function madang_new_logout_url( $logouturl, $redir ){
    
    $redir = get_option('siteurl');
    return $logouturl . '&amp;redirect_to=' . urlencode($redir);
}

/* Create Shorter Excerpt */
function madang_short_excerpt( $limit ) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

function madang_content( $limit ) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

function madang_hex2rgba( $color, $opacity = false ) {
    
    $default = 'rgb(0,0,0)';
    
    //Return default if no color provided
    if(empty($color))
        return $default;
    
    //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }
    
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }
    
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);
    
    //Check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }
    
    //Return rgb(a) color string
    return $output;
}

function madang_adjust_brightness( $hex, $steps ) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));
    
    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }
    
    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';
    
    foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }
    
    return $return;
}

function madang_output_text( $str ) {
    return wp_kses( $str, array( 
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'b' => array(),
    'em' => array(),
    'strong' => array(),
    ) );
} 

function madang_output_html( $str ) {
    return wp_kses( $str, array( 
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'b' => array(),
    'tr' => array(),
    'th' => array(),
    'td' => array(),
    'em' => array(),
    'strong' => array(),
    'span' => array(
        'href' => array(),
        'class' => array(),
    ),
    'div' => array(
        'id' => array(),
        'class' => array(),
    ),
    ) );
} 