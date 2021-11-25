<?php


/* start post type */
if ( ! class_exists( 'madang_meals_Post_Type' ) ) :

class madang_meals_Post_Type {

    private $theme = 'madang';
	public function __construct() {
        // Run when the plugin is activated
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Add the meals post type and taxonomies
		add_action( 'init', array( $this, 'meals_init' ) );

		// Thumbnail support for meals posts
		add_theme_support( 'post-thumbnails', array( 'meals' ) );

		// Add thumbnails to column view
		add_filter( 'manage_edit-meals_columns', array( $this, 'add_thumbnail_column_meals'), 10, 1 );
		add_action( 'manage_pages_custom_column', array( $this, 'display_thumbnail_meals' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show meals post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_meals_counts' ) );
		
        // Add custom metaboxes
        add_action( 'cmb2_init', array( $this, 'add_meals_metaboxes' ) );
        
		//Add taxonomy terms as body classes
		//add_filter( 'body_class', array( $this, 'add_body_classes' ) );
        //add_action( 'add_meta_boxes', array( $this, 'add_events_metaboxes' ) );
        //add_action( 'save_post', array( $this, 'madang_meals_meta_details_save'), 1, 2); // save the custom fields
	}

    /**
  	 * Create madang block specific meta box key values
  	 */
  	public function add_meals_metaboxes() {

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
                               'id'            => 'meals_metabox',
                               'title'         => esc_html( 'Program Menu Day', $this->theme ),
                               'object_types'  => array( 'meals', ), // Post type
                               'context'       => 'normal',
                               'priority'      => 'high',
                               'show_names'    => true, // Show field names on the left
                               // 'cmb_styles' => false, // false to disable the CMB stylesheet
                               // 'closed'     => true, // Keep the metabox closed by default
                               ) );
        // URL text field
/*
        $cmb->add_field( array(
                               'name' => __( 'Link', $this->theme ),
                               'desc' => __( 'opens link if once image is clicked (optional)', $this->theme ),
                               'id'   => $this->theme . '_url',
                               'type' => 'text_url',
                               ) );
*/
        $group_field_id = $cmb->add_field( array(
            'id'          => 'madang_program_meals_group',
            'type'        => 'group',
            //'description' => __( 'Specify your program days here', 'cmb2' ),
            // 'repeatable'  => false, // use false if you want non-repeatable group
            'options'     => array(
                'group_title'   => esc_html( 'Meal {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => esc_html( 'Add Another Meal', 'cmb2' ),
                'remove_button' => esc_html( 'Remove Meal', 'cmb2' ),
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

        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Tags',
            'id'   => 'tags',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );

        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Image',
            'id'   => 'image',
            'type' => 'file',
        ) );
/*
        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Image Caption',
            'id'   => 'image_caption',
            'type' => 'text',
        ) );
*/
    }

	/**
	 * Load the plugin text domain for translation.
	 */


	/**
	 * Flushes rewrite rules on plugin activation to ensure meals posts don't 404.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 *
	 * @uses meals Item_Post_Type::meals_init()
	 */
	public function plugin_activation() {
		$this->meals_init();
		flush_rewrite_rules();
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses meals Item_Post_Type::register_post_type()
	 * @uses meals Item_Post_Type::register_taxonomy_tag()
	 * @uses meals Item_Post_Type::register_taxonomy_category()
	 */
	public function meals_init() {
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
		return array( 'meals_category', 'meals_tag' );
	}



	/**
	 * Enable the meals Item custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => esc_html( 'Meals', 'madang' ),
			'singular_name'      => esc_html( 'Meals', 'madang' ),
			'add_new'            => esc_html( 'Add New', 'madang' ),
			'add_new_item'       => esc_html( 'Add New', 'madang' ),
			'edit_item'          => esc_html( 'Edit Item', 'madang' ),
			'new_item'           => esc_html( 'Add New  Item', 'madang' ),
			'view_item'          => esc_html( 'View Item', 'madang' ),
			'search_items'       => esc_html( 'Search Items', 'madang' ),
			'not_found'          => esc_html( 'No items found', 'madang' ),
			'not_found_in_trash' => esc_html( 'No items found in trash', 'madang' ),
		);
		
		$args = array(
			'menu_icon' => 'dashicons-images-alt',
			'labels'          => $labels,
			'public'          => true,
			'publicly_queryable' => false,
			'supports'        => array(
				'title',
				//'editor',
				//'excerpt',
				//'thumbnail',
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
		register_post_type( 'meals', $args );
	}



	/**
	 * Register a taxonomy for meals Item Tags.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_tag() {
		$labels = array(
			'name'                       => esc_html( 'Tags', 'madang' ),
			'singular_name'              => esc_html( 'Tag', 'madang' ),
			'menu_name'                  => esc_html( 'Tags', 'madang' ),
			'edit_item'                  => esc_html( 'Edit Tag', 'madang' ),
			'update_item'                => esc_html( 'Update Tag', 'madang' ),
			'add_new_item'               => esc_html( 'Add New Tag', 'madang' ),
			'new_item_name'              => esc_html( 'New  Tag Name', 'madang' ),
			'parent_item'                => esc_html( 'Parent Tag', 'madang' ),
			'parent_item_colon'          => esc_html( 'Parent Tag:', 'madang' ),
			'all_items'                  => esc_html( 'All Tags', 'madang' ),
			'search_items'               => esc_html( 'Search  Tags', 'madang' ),
			'popular_items'              => esc_html( 'Popular Tags', 'madang' ),
			'separate_items_with_commas' => esc_html( 'Separate tags with commas', 'madang' ),
			'add_or_remove_items'        => esc_html( 'Add or remove tags', 'madang' ),
			'choose_from_most_used'      => esc_html( 'Choose from the most used tags', 'madang' ),
			'not_found'                  => esc_html( 'No  tags found.', 'madang' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'query_var'         => true,

		);

		$args = apply_filters( 'madang_tag_args', $args );

		register_taxonomy( 'meals_tag', array( 'meals' ), $args );

	}

	/**
	 * Register a taxonomy for meals Item Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		

		$labels = array(
			'name'                       => esc_html( 'Categories', 'madang' ),
			'singular_name'              => esc_html( 'Category', 'madang' ),
			'menu_name'                  => esc_html( 'Categories', 'madang' ),
			'edit_item'                  => esc_html( 'Edit Category', 'madang' ),
			'update_item'                => esc_html( 'Update Category', 'madang' ),
			'add_new_item'               => esc_html( 'Add New Category', 'madang' ),
			'new_item_name'              => esc_html( 'New Category Name', 'madang' ),
			'parent_item'                => esc_html( 'Parent Category', 'madang' ),
			'parent_item_colon'          => esc_html( 'Parent Category:', 'madang' ),
			'all_items'                  => esc_html( 'All Categories', 'madang' ),
			'search_items'               => esc_html( 'Search Categories', 'madang' ),
			'popular_items'              => esc_html( 'Popular Categories', 'madang' ),
			'separate_items_with_commas' => esc_html( 'Separate categories with commas', 'madang' ),
			'add_or_remove_items'        => esc_html( 'Add or remove categories', 'madang' ),
			'choose_from_most_used'      => esc_html( 'Choose from the most used categories', 'madang' ),
			'not_found'                  => esc_html( 'No categories found.', 'madang' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => false,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'madang_category_args', $args );

        register_taxonomy( 'meals_category', array( 'meals' ), $args );
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
	 * Add columns to meals Item list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column_meals( $columns ) {
		$column_thumbnail = array( 'thumbnail' => esc_html( 'Thumbnail', 'madang' ) );
		return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
	}

	/**
	 * Custom column callback
	 *
	 * @global stdClass $post Post object.
	 *
	 * @param string $column Column ID.
	 */
	public function display_thumbnail_meals( $column ) {
		global $post;
        if( $post->post_type == 'meals' ){
            switch ( $column ) {
                case 'thumbnail':
                    echo get_the_post_thumbnail( $post->ID, array(35, 35, true ), array('class' => 'img-responsive') );
                break;
            }
        }
	}

	/**
	 * Add taxonomy filters to the meals admin page.
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
		if ( 'meals' != $typenow ) {
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
	 * Add meals Item count to "Right Now" dashboard widget.
	 *
	 * @return null Return early if meals post type does not exist.
	 */
	public function add_meals_counts() {
		if ( ! post_type_exists( 'meals' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'meals' );

		// Published items
		$href = 'edit.php?post_type=meals';
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'meals Item Item', 'meals Item Items', intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=meals';
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'meals Item Item Pending', 'meals Item Items Pending', intval( $num_posts->pending ) );
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
			<td class="first b b-meals"><?php echo esc_html( $number ); ?></td>
			<td class="t meals"><?php echo esc_html( $label ); ?></td>
		</tr>
		<?php
	}
}

new madang_meals_Post_Type;

endif;
