<?php
/**
 * @package Madang
 * @basic setup
 */


    /**
     * Add custom metaboxes for post and default pages
     */
    function add_madang_metaboxes() {
        
        /**
         * Initiate the metabox
         */
        $cmb_page = new_cmb2_box( array(
                                'id'            => 'page_metabox',
                                'title'         => esc_attr( 'Settings', 'madang' ),
                                'object_types'  => array( 'page', ), // Post type
                                'context'       => 'normal',
                                'priority'      => 'high',
                                'show_names'    => true, // Show field names on the left
                                ) );
        
        // Enable Title
        $cmb_page->add_field( array(
                                'name' => esc_attr( 'Disable Title', 'madang' ),
                                'desc' => esc_attr( 'disable default page title in header', 'madang' ),
                                'id'   => '_title',
                                'type' => 'checkbox',
                                ) );
        
        // Enable Title
        $cmb_page->add_field( array(
                                'name' => esc_attr( 'Wide Content', 'madang' ),
                                'desc' => esc_attr( 'Expand page content to 100%', 'madang' ),
                                'id'   => '_narrow_content',
                                'type' => 'checkbox',
                                ) );

        // Transparent Header
        $cmb_page->add_field( array(
                                'name' => esc_attr( 'Transparent Header', 'madang' ),
                                'desc' => esc_attr( 'Make navigation header transparent for this page', 'madang' ),
                                'id'   => '_transparent_header',
                                'type' => 'checkbox',
                                ) );
        /**
         * Initiate the metabox
         */
        $cmb_page = new_cmb2_box( array(
                                'id'            => 'page_seobox',
                                'title'         => esc_attr( 'SEO', 'madang' ),
                                'object_types'  => get_post_types(), // Post type
                                'context'       => 'normal',
                                'priority'      => 'low',
                                'show_names'    => true, // Show field names on the left
                                ) );
        
        // Enable Description
        $cmb_page->add_field( array(
                                'name' => esc_attr( 'SEO Description', 'madang' ),
                                'desc' => esc_attr( 'Brief and relevant page description that will be hidden from site users but will most likely show up in search engine result pages. Max 160 characters.', 'madang' ). ' <a target="blank" href="https://support.google.com/webmasters/answer/79812?hl=en">'.esc_attr( 'More info', 'madang' ).'.</a>',
                                'maxlength' => 160,
                                'id'   => '_seo_desc',
                                'type' => 'textarea_small',
                                ) );

        
    }
    add_action( 'cmb2_init', 'add_madang_metaboxes' );
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.get_theme_mod( 'madang_products_num', '8' ).';' ), 20 );


    function madang_widgets_collection($folders){
        $folders[] = get_template_directory() . 'inc/shortcodes';
        return $folders;
    }
    add_filter('siteorigin_widgets_widget_folders', 'madang_widgets_collection');


    function madang_add_widget_tabs($tabs) {
        $tabs[] = array(
            'title' => esc_attr__('Madang Widgets', 'madang'),
            'filter' => array(
                'groups' => array('madang')
            )
        );

        return $tabs;
    }
    add_filter('siteorigin_panels_widget_dialog_tabs', 'madang_add_widget_tabs', 20);


    function ocdi_import_files() {
        return array(
            array(
                'import_file_name'           => 'Demo1',
                //'categories'                 => array( 'Category 1', 'Category 2' ),
                'import_file_url'            => 'http://themesapi.kenzap.com/demo/madang.wordpress.xml',
                // 'import_widget_file_url'     => 'http://www.your_domain.com/ocdi/widgets.json',
                'import_customizer_file_url' => 'http://themesapi.kenzap.com/demo/madang.export.dat',
                // 'import_redux'               => array(
                //     array(
                //         'file_url'    => 'http://www.your_domain.com/ocdi/redux.json',
                //         'option_name' => 'redux_option_name',
                //     ),
                // ),
                //'import_preview_image_url'   => 'http://www.your_domain.com/ocdi/preview_import_image1.jpg',
                'import_notice'              => __( 'If you experience server error 500 during import process please read the following <a target="_blank" href="https://github.com/proteusthemes/one-click-demo-import/blob/master/docs/import-problems.md#user-content-server-error-500" >article</a>. You may also install theme on <a target="blank" href="http://kenzap.com/signin/?project=madang" >Kenzap Cloud</a> for free or request paid installation/assistance with your hosting environment.', 'madang' ),
            ),
        );
    }
    add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );


    function ocdi_after_import_setup() {
        // Assign menus to their locations.

        $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
        $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

        set_theme_mod( 'nav_menu_locations', array(
                'primary' => $main_menu->term_id,
                'primary_mobile' => $main_menu->term_id,
                'footer' => $footer_menu->term_id,
            )
        );

        set_theme_mod( 'madang_cart', 1 );
        set_theme_mod( 'sidebar_location', 'left' );
         
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home' );
        $blog_page_id  = get_page_by_title( 'Blog' );

        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );
        update_option( 'siteorigin_panels_settings', 'a:19:{s:10:"post-types";a:2:{i:0;s:4:"page";i:1;s:4:"post";}s:22:"live-editor-quick-link";b:1;s:15:"parallax-motion";s:0:"";s:17:"sidebars-emulator";b:1;s:14:"display-teaser";b:1;s:13:"display-learn";b:1;s:10:"title-html";s:39:"<h3 class="widget-title">{{title}}</h3>";s:16:"add-widget-class";b:0;s:15:"bundled-widgets";b:0;s:19:"recommended-widgets";b:0;s:10:"responsive";b:1;s:13:"tablet-layout";b:0;s:12:"tablet-width";i:1024;s:12:"mobile-width";i:780;s:13:"margin-bottom";i:0;s:22:"margin-bottom-last-row";b:0;s:12:"margin-sides";i:30;s:20:"full-width-container";s:4:"body";s:12:"copy-content";b:1;}');

        reset_permalinks();
    }
    add_action( 'pt-ocdi/after_import', 'ocdi_after_import_setup' );


    function reset_permalinks() {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        $wp_rewrite->flush_rules();
    }

    add_theme_support('woocommerce');

    //hide siteorigin widgets from admin widgets  
    add_action( 'current_screen', 'this_screen' );
    function this_screen() {

        $current_screen = get_current_screen();
        if( $current_screen ->id === "widgets" ) {

        }
    }

?>