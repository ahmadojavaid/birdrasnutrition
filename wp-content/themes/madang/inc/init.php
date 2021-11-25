<?php
/**
 * madang Engine Room.
 * This is where all Theme Functions runs.
 *
 * @package Madang
 */

/**
 * List of template files that can be overwritten by child theme
 */

 $templates = array(
        '/inc/setup.php',
        '/inc/setup-woocommerce.php',
        '/inc/custom-css.php',
        '/inc/shortcodes/madang-container.php',
        '/inc/shortcodes/madang-block.php',
        '/inc/shortcodes/madang-banner.php',
        '/inc/shortcodes/madang-feature.php',
        '/inc/shortcodes/madang-newsletter.php',
        '/inc/shortcodes/madang-aboutus.php',
        '/inc/shortcodes/madang-partner.php',
        '/inc/shortcodes/madang-button.php',
        '/inc/shortcodes/madang-maincontent.php',
        '/inc/shortcodes/madang-pricingtable.php',
        '/inc/shortcodes/madang-info.php',
        '/inc/shortcodes/madang-testimonial.php',
        '/inc/shortcodes/madang-map.php',
        '/inc/shortcodes/madang-contact.php',
        '/inc/shortcodes/madang-samplemenu.php',
        '/inc/shortcodes/madang-program.php',
        '/inc/shortcodes/madang-nutrition.php',
        '/inc/shortcodes/madang-nutrition-table.php',
        '/inc/shortcodes/madang-menufeatured.php',
        '/inc/shortcodes/madang-video.php',
        '/inc/shortcodes/madang-team.php',
        '/inc/shortcodes/madang-app.php',
        '/inc/shortcodes/madang-blog.php',
        '/inc/shortcodes/madang-gallery.php',
        '/inc/shortcodes/madang-promo.php',
        '/inc/shortcodes/madang-faq.php',
        '/inc/shortcodes/madang-cta.php',
        '/inc/shortcodes/madang-products.php',
        '/inc/shortcodes/madang-counters.php',
        '/inc/shortcodes/madang-story.php',
        '/inc/shortcodes/madang-howitworks.php',
        '/inc/shortcodes/madang-contact-form.php',
        '/inc/shortcodes/madang-programinfo.php',
        '/inc/shortcodes/madang-mealplan.php',
        '/inc/shortcodes/madang-slider.php',
        '/inc/shortcodes/madang-programselect.php',
        '/inc/shortcodes/madang-productcategories.php',
        );

foreach ( $templates as $key => $file) {
	if ( file_exists( get_stylesheet_directory() . $file )){ 

		require get_stylesheet_directory() . $file;
	}else{

		require get_template_directory() . $file;
	}	
}
