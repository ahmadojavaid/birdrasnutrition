<?php
/**
 * @package Madang
 * @version 1.6.5
 */
/*
Plugin Name: Madang
Plugin URI: http://madang.kenzap.com
Description: This plugin extends default <cite>madang theme</cite> functionality. To activate all custom elements  features use this plugin.
Author: Kenzap
Version: 1.6.4
Author URI: http://kenzap.com
*/


define( 'KENZAP_PARAM', '1' );
$my_theme = wp_get_theme();
if ( 'Madang' == $my_theme || 'Madang Child Theme' == $my_theme ) :

	// Add Advanced Options
	if ( !is_customize_preview()  && is_admin() ) {
	  require plugin_dir_path(__FILE__) . 'inc/setup/envato_setup.php';
	}

	// register custom post types
	if ( get_option( basename( get_template_directory() ) . '_plugin_version', 0 ) < 2 ) :
	require plugin_dir_path(__FILE__) . 'custom/setup.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-blocks.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-menu.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-gallery.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-meals.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-nutrition.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-promo.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-faq.php';
	require plugin_dir_path(__FILE__) . 'custom/post-types/madang-commerce.php';
	endif;

	// register custom widgets
	require plugin_dir_path(__FILE__) . 'custom/widgets/ecommerce_categories.php';
	require plugin_dir_path(__FILE__) . 'custom/widgets/ecommerce_tags.php';
	require plugin_dir_path(__FILE__) . 'custom/widgets/ecommerce_filters.php';
	require plugin_dir_path(__FILE__) . 'custom/widgets/ecommerce_bestsellers.php';

	// register shortcodes
	add_shortcode( 'madang_block', 'madang_block_shortcode' );
	add_shortcode( 'madang_banner', 'madang_shortcode_banner' );
	add_shortcode( 'madang_feature', 'madang_shortcode_feature' );
	add_shortcode( 'madang_feature_item', 'madang_shortcode_feature_item' );
	add_shortcode( 'madang_newsletter', 'madang_shortcode_newsletter' );
	add_shortcode( 'madang_aboutus', 'madang_shortcode_aboutus' );
	add_shortcode( 'madang_partner', 'madang_shortcode_partner' );
	add_shortcode( 'madang_button', 'madang_shortcode_button' );
	add_shortcode( 'madang_maincontent', 'madang_shortcode_maincontent' );
	add_shortcode( 'madang_pricingtable', 'madang_shortcode_pricingtable' );
	add_shortcode( 'madang_pricingtable_item', 'madang_shortcode_pricingtable_item' );
	add_shortcode( 'madang_info', 'madang_shortcode_info' );
	add_shortcode( 'madang_info_item', 'madang_shortcode_info_item' );
	add_shortcode( 'madang_testimonial', 'madang_shortcode_testimonial' );
	add_shortcode( 'madang_testimonial_item', 'madang_shortcode_testimonial_item' );
	add_shortcode( 'madang_map', 'madang_shortcode_map' );
	add_shortcode( 'madang_contact', 'madang_shortcode_contact' );
	add_shortcode( 'madang_menu', 'madang_shortcode_menu' );
	add_shortcode( 'madang_menu_cont', 'madang_shortcode_menu_cont' );
	add_shortcode( 'madang_menu_search', 'madang_shortcode_menu_search' );
	add_shortcode( 'madang_samplemenu', 'madang_shortcode_samplemenu' );
	add_shortcode( 'madang_samplemenu_item', 'madang_shortcode_samplemenu_item' );
	add_shortcode( 'madang_programinfo', 'madang_shortcode_programinfo' );
	add_shortcode( 'madang_programinfo_feature', 'madang_shortcode_programinfo_feature' );
	add_shortcode( 'madang_testimonial_compact', 'madang_shortcode_testimonial_compact' );
	add_shortcode( 'madang_nutrition', 'madang_shortcode_nutrition' );
	add_shortcode( 'madang_nutrition_table', 'madang_shortcode_nutrition_table' );
	add_shortcode( 'madang_container', 'madang_shortcode_container' );
	add_shortcode( 'madang_slide', 'madang_shortcode_slide' );
	add_shortcode( 'madang_menufeatured', 'madang_shortcode_menufeatured' );
	add_shortcode( 'madang_menufeatured_item', 'madang_shortcode_menufeatured_item' );
	add_shortcode( 'madang_programselect', 'madang_shortcode_programselect' );
	add_shortcode( 'madang_programselect_item', 'madang_shortcode_programselect_item' );
	add_shortcode( 'madang_video', 'madang_shortcode_video' );
	add_shortcode( 'madang_team', 'madang_shortcode_team' );
	add_shortcode( 'madang_team_item', 'madang_shortcode_team_item' );
	add_shortcode( 'madang_app', 'madang_shortcode_app' );
	add_shortcode( 'madang_blog', 'madang_shortcode_blog' );
	add_shortcode( 'madang_gallery', 'madang_shortcode_gallery' );	 
	add_shortcode( 'madang_promo', 'madang_shortcode_promo' );	 
	add_shortcode( 'madang_faq', 'madang_shortcode_faq' );	
	add_shortcode( 'madang_cta', 'madang_shortcode_cta' );	
	add_shortcode( 'madang_products', 'madang_shortcode_products' );	
	add_shortcode( 'madang_counters', 'madang_shortcode_counters' );	
	add_shortcode( 'madang_howitworks', 'madang_shortcode_howitworks' );	
	add_shortcode( 'madang_story', 'madang_shortcode_story' );
	add_shortcode( 'madang_story_item', 'madang_shortcode_story_item' );
	add_shortcode( 'madang_categories', 'madang_shortcode_categories' );

	/* Add shortcode fix to content */
	add_filter( 'the_content', 'madang_fix_shortcode' );
	add_filter( 'the_excerpt', 'madang_fix_shortcode' );
	add_filter( 'logout_url', 'madang_new_logout_url', 10, 2 );
	add_filter( 'body_class', 'madang_body_classes' );
	   
	//load suggested plugins
	require plugin_dir_path(__FILE__) . 'custom/plugins.php';
	require plugin_dir_path(__FILE__) . 'inc/classes/activation/class-tgm-plugin-activation.php';
	//require plugin_dir_path(__FILE__) . 'inc/classes/performance/class-performance.php';

endif;  

?>
