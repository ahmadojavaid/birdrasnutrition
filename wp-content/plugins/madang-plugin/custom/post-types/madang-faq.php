<?php


/* start post type */
if ( ! class_exists( 'madang_faq_Post_Type' ) ) :

class madang_faq_Post_Type {

    private $theme = 'madang';
	public function __construct() {
        // Run when the plugin is activated
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Add the faq post type and taxonomies
		add_action( 'init', array( $this, 'faq_init' ) );

		// Thumbnail support for faq posts
		add_theme_support( 'post-thumbnails', array( 'faq' ) );

		// Add thumbnails to column view
		add_filter( 'manage_edit-faq_columns', array( $this, 'add_thumbnail_column_faq'), 10, 1 );
		add_action( 'manage_pages_custom_column', array( $this, 'display_thumbnail_faq' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show faq post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_faq_counts' ) );
		
        // Add custom metaboxes
        add_action( 'cmb2_init', array( $this, 'add_faq_metaboxes' ) );
        
		//Add taxonomy terms as body classes
		//add_filter( 'body_class', array( $this, 'add_body_classes' ) );
        //add_action( 'add_meta_boxes', array( $this, 'add_events_metaboxes' ) );
        //add_action( 'save_post', array( $this, 'madang_faq_meta_details_save'), 1, 2); // save the custom fields
	}

    /**
  	 * Create madang block specific meta box key values
  	 */
  	public function add_faq_metaboxes() {

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
                       'id'            => 'faq_metabox',
                       'title'         => __( 'Fill in one FAQ tab', $this->theme ),
                       'object_types'  => array( 'faq', ), // Post type
                       'context'       => 'normal',
                       'priority'      => 'high',
                       'show_names'    => true, // Show field names on the left
                       // 'cmb_styles' => false, // false to disable the CMB stylesheet
                       // 'closed'     => true, // Keep the metabox closed by default
                       ) );

        // URL text field
///*
        $cmb->add_field( array(
                       'name' => __( 'Order', $this->theme ),
                       'desc' => __( 'Set up this tab for order priority', $this->theme ),
                       'id'   => $this->theme . '_priority',
                       'type' => 'text_small',
                       'default' => '10'
                       ) );

        $cmb->add_field( array(
                       'name' => __( 'Icon', $this->theme ),
                       'desc' => __( 'Set up this tab for order priority', $this->theme ),
                       'id'   => $this->theme . '_icon',
                       'type' => 'text_small',
                       'default' => ''
                       ) );
//*/
        $group_field_id = $cmb->add_field( array(
            'id'          => 'madang_faq_group',//madang_program_faq_group
            'type'        => 'group',
            //'description' => __( 'Specify your program days here', 'cmb2' ),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => __( 'Row {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => __( 'Add Another Row', 'cmb2' ),
                'remove_button' => __( 'Remove Row', 'cmb2' ),
                'sortable'      => true, // beta
                // 'closed'     => true, // true to have the groups closed by default
            ),
        ) );

        // Id's for group's fields only need to be unique for the group. Prefix is not needed.
        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Title',
            'id'   => 'title',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );

        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Description',
            'description' => 'Write a short description for this entry',
            'id'   => 'description',
            'type' => 'textarea_small',
        ) );
/*
        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Tags',
            'id'   => 'tags',
            'type' => 'text',
        ) );

        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Image',
            'id'   => 'image',
            'type' => 'file',
        ) );
 */
    }

	/**
	 * Load the plugin text domain for translation.
	 */


	/**
	 * Flushes rewrite rules on plugin activation to ensure faq posts don't 404.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 *
	 * @uses faq Item_Post_Type::faq_init()
	 */
	public function plugin_activation() {
		$this->faq_init();
		flush_rewrite_rules();
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses faq Item_Post_Type::register_post_type()
	 * @uses faq Item_Post_Type::register_taxonomy_tag()
	 * @uses faq Item_Post_Type::register_taxonomy_category()
	 */
	public function faq_init() {
		$this->register_post_type();
		$this->register_taxonomy_category();
		$this->register_taxonomy_tag();
        //$this->add_events_metaboxes();
	}

	/**
	 * Get an array of all taxonomies this plugin handles.
	 *
	 * @return array Taxonomy slugs.
	 */
	protected function get_taxonomies() {
		return array( 'faq_category', 'faq_tag' );
	}

	/**
	 * Enable the faq Item custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Faq', 'madang' ),
			'singular_name'      => __( 'Faq', 'madang' ),
			'add_new'            => __( 'Add New', 'madang' ),
			'add_new_item'       => __( 'Add New', 'madang' ),
			'edit_item'          => __( 'Edit Item', 'madang' ),
			'new_item'           => __( 'Add New  Item', 'madang' ),
			'view_item'          => __( 'View Item', 'madang' ),
			'search_items'       => __( 'Search Items', 'madang' ),
			'not_found'          => __( 'No items found', 'madang' ),
			'not_found_in_trash' => __( 'No items found in trash', 'madang' ),
		);
		
		$args = array(
			'menu_icon' => 'dashicons-universal-access-alt',
			'labels'          => $labels,
			'public'          => true,
			'publicly_queryable' => false,
			'supports'        => array(
				'title',
				//'editor',
				//'excerpt',
				'thumbnail',
				//'comments',
				//'author',
				//'custom-fields',
				'revisions',
			),
			'capability_type' => 'page',
			'menu_position'   => 4,
			'hierarchical'      => true,
			'has_archive'     => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
		);

		$args = apply_filters( 'madang_args', $args );
		register_post_type( 'faq', $args );
	}



	/**
	 * Register a taxonomy for faq Item Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_tag() {
		$labels = array(
			'name'                       => __( 'Tags', 'madang' ),
			'singular_name'              => __( 'Tag', 'madang' ),
			'menu_name'                  => __( 'Tags', 'madang' ),
			'edit_item'                  => __( 'Edit Tag', 'madang' ),
			'update_item'                => __( 'Update Tag', 'madang' ),
			'add_new_item'               => __( 'Add New Tag', 'madang' ),
			'new_item_name'              => __( 'New  Tag Name', 'madang' ),
			'parent_item'                => __( 'Parent Tag', 'madang' ),
			'parent_item_colon'          => __( 'Parent Tag:', 'madang' ),
			'all_items'                  => __( 'All Tags', 'madang' ),
			'search_items'               => __( 'Search  Tags', 'madang' ),
			'popular_items'              => __( 'Popular Tags', 'madang' ),
			'separate_items_with_commas' => __( 'Separate tags with commas', 'madang' ),
			'add_or_remove_items'        => __( 'Add or remove tags', 'madang' ),
			'choose_from_most_used'      => __( 'Choose from the most used tags', 'madang' ),
			'not_found'                  => __( 'No  tags found.', 'madang' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => false,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'query_var'         => true,

		);

		$args = apply_filters( 'madang_tag_args', $args );

		register_taxonomy( 'faq_tag', array( 'faq' ), $args );
	}

	/**
	 * Register a taxonomy for faq Item Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		

		$labels = array(
			'name'                       => __( 'Categories', 'madang' ),
			'singular_name'              => __( 'Category', 'madang' ),
			'menu_name'                  => __( 'Categories', 'madang' ),
			'edit_item'                  => __( 'Edit Category', 'madang' ),
			'update_item'                => __( 'Update Category', 'madang' ),
			'add_new_item'               => __( 'Add New Category', 'madang' ),
			'new_item_name'              => __( 'New Category Name', 'madang' ),
			'parent_item'                => __( 'Parent Category', 'madang' ),
			'parent_item_colon'          => __( 'Parent Category:', 'madang' ),
			'all_items'                  => __( 'All Categories', 'madang' ),
			'search_items'               => __( 'Search Categories', 'madang' ),
			'popular_items'              => __( 'Popular Categories', 'madang' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'madang' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'madang' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'madang' ),
			'not_found'                  => __( 'No categories found.', 'madang' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => false,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'madang_category_args', $args );

        register_taxonomy( 'faq_category', array( 'faq' ), $args );
	}

		

	/**
	 * Add taxonomy terms as body classes.
	 *
	 * If the taxonomy doesn't exist (has been unregistered), then get_the_terms() returns WP_Error, which is checked
	 * for before adding classes.
	 *
	 * @param array $classes Existing body classes.
	 *
	 * @return array Amended body classes.
	 */
	public function add_body_classes( $classes ) {
		$taxonomies = $this->get_taxonomies();

		foreach( $taxonomies as $taxonomy ) {
			$terms = get_the_terms( get_the_ID(), $taxonomy );
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach( $terms as $term ) {
					$classes[] = sanitize_html_class( str_replace( '_', '-', $taxonomy ) . '-' . $term->slug );
				}
			}
		}

		return $classes;
	}

	/**
	 * Add columns to faq Item list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column_faq( $columns ) {
		$column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', 'madang' ) );
		return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
	}

	/**
	 * Custom column callback
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param string $column Column ID.
	 */
	public function display_thumbnail_faq( $column ) {
		global $post;
        if( $post->post_type == 'faq' ){
            switch ( $column ) {
                case 'thumbnail':
                    echo get_the_post_thumbnail( $post->ID, array(35, 35, true ), array('class' => 'img-responsive') );
                break;
            }
        }
	}

	/**
	 * Add taxonomy filters to the faq admin page.
	 *
	 * Code artfully lifted from http://pippinsplugins.com/
	 *
	 * @global string $typenow
	 */
	public function add_taxonomy_filters() {
		global $typenow;

		// An array of all the taxonomies you want to display. Use the taxonomy name or slug
		$taxonomies = $this->get_taxonomies();

		// Must set this to the post type you want the filter(s) displayed on
		if ( 'faq' != $typenow ) {
			return;
		}

		foreach ( $taxonomies as $tax_slug ) {
			$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
			$tax_obj          = get_taxonomy( $tax_slug );
			$tax_name         = $tax_obj->labels->name;
			$terms            = get_terms( $tax_slug );
			if ( 0 == count( $terms ) ) {
				return;
			}
			echo '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="postform">';
			echo '<option>' . esc_html( $tax_name ) .'</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%s"%s />%s</option>',
					esc_attr( $term->slug ),
					selected( $current_tax_slug, $term->slug ),
					esc_html( $term->name . '(' . $term->count . ')' )
				);
			}
			echo '</select>';
		}
	}

	/**
	 * Add faq Item count to "Right Now" dashboard widget.
	 *
	 * @return null Return early if faq post type does not exist.
	 */
	public function add_faq_counts() {
		if ( ! post_type_exists( 'faq' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'faq' );

		// Published items
		$href = 'edit.php?post_type=faq';
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'faq Item Item', 'faq Item Items', intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=faq';
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'faq Item Item Pending', 'faq Item Items Pending', intval( $num_posts->pending ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );
	}

	/**
	 * Wrap a dashboard number or text value in a link, if the current user can edit posts.
	 *
	 * @param  string $value Value to potentially wrap in a link.
	 * @param  string $href  Link target.
	 *
	 * @return string        Value wrapped in a link if current user can edit posts, or original value otherwise.
	 */
	protected function link_if_can_edit_posts( $value, $href ) {
		if ( current_user_can( 'edit_posts' ) ) {
			return '<a href="' . esc_url( $href ) . '">' . $value . '</a>';
		}
		return $value;
	}

	/**
	 * Display a number and text with table row and cell markup for the dashboard counters.
	 *
	 * @param  string $number Number to display. May be wrapped in a link.
	 * @param  string $label  Text to display. May be wrapped in a link.
	 */
	protected function display_dashboard_count( $number, $label ) {
		?>
		<tr>
			<td class="first b b-faq"><?php echo esc_html( $number ); ?></td>
			<td class="t faq"><?php echo esc_html( $label ); ?></td>
		</tr>
		<?php
	}
}

new madang_faq_Post_Type;

endif;
