<?php


/* start post type */
if ( ! class_exists( 'madang_menu_Post_Type' ) ) :

class madang_menu_Post_Type {

  private $theme = 'madang';
	public function __construct() {
        // Run when the plugin is activated
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Add the menu post type and taxonomies
		add_action( 'init', array( $this, 'menu_init' ) );

		// Thumbnail support for menu posts
		add_theme_support( 'post-thumbnails', array( 'menu' ) );

		// Add thumbnails to column view
		add_filter( 'manage_edit-menu_columns', array( $this, 'add_thumbnail_column_menu'), 10, 1 );
		add_action( 'manage_pages_custom_column', array( $this, 'display_thumbnail_menu' ), 10, 1 );

		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );

		// Show menu post counts in the dashboard
		add_action( 'right_now_content_table_end', array( $this, 'add_menu_counts' ) );
		
    // Add custom metaboxes
    add_action( 'cmb2_init', array( $this, 'add_menu_metaboxes' ) );
        
		//Add taxonomy terms as body classes
    add_filter( 'manage_edit-menu_columns', array( $this, $this->theme . '_edit_menu_columns' ) );
    add_action( 'manage_menu_posts_custom_column', array( $this, $this->theme . '_manage_menu_columns' ), 10, 2 );

	}



    /**
  	 * Create madang block specific meta box key values
  	 */
  	public function add_menu_metaboxes() {

        /**
         * Initiate the metabox
         */
        $cmb = new_cmb2_box( array(
                               'id'            => 'menu_metabox',
                               'title'         => esc_html( 'Program Menu Settings', $this->theme ),
                               'object_types'  => array( 'menu', ), // Post type
                               'context'       => 'normal',
                               'priority'      => 'high',
                               'show_names'    => true, // Show field names on the left
                               ) );
        // URL text field
        $cmb->add_field( array(
                               'name' => esc_html( 'Link', $this->theme ),
                               'desc' => esc_html( 'link to page that describes this program', $this->theme ),
                               'id'   => $this->theme . '_url',
                               'type' => 'text_url',
                               ) );

        $group_field_id = $cmb->add_field( array(
            'id'          => 'madang_program_days_group',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => esc_html( 'Day {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                'add_button'    => esc_html( 'Add Another Day', 'cmb2' ),
                'remove_button' => esc_html( 'Remove Day', 'cmb2' ),
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
            'name' => 'Meals ID',
            'id'   => 'meal_ids',
            'description' => 'Provide IDs of comma separated meals',
            'type' => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );
    }

    public function madang_edit_menu_columns( $columns ) {
        
        $columns = array(
                         'cb'               => '<input type="checkbox" />',
                         'title'            => esc_html( 'Title', $this->theme),
                         'quick_preview'    => esc_html( 'Preview', $this->theme),
                         'shortcode'        => esc_html( 'Shortcode', $this->theme),
                         'date'             => esc_html( 'Date', $this->theme),
                         );
        
        return $columns;
    }
    
    function madang_manage_menu_columns( $column, $post_id ) {
        
        global $post;
        $post_data = get_post($post_id, ARRAY_A);
        $slug = $post_data['post_name'];
        add_thickbox();
        switch( $column ) {
            case 'shortcode' :
                echo '<textarea style="min-width:100%; max-height:30px; background:#eee;">[madang_menu id="'.$slug.'"]</textarea>';
                break;
            case 'quick_preview' :
                echo '<a title="'.get_the_title().'" href="'.get_the_permalink().'?preview&TB_iframe=true&width=1100&height=600" rel="logos1" class="thickbox button">+ Quick Preview</a>';
                break;
        }
    }


    /**
     * Create madang menu specific meta box key values
     */
    public function add_menu_metaboxes_ex() {
        
        /**
         * Initiate the metabox
         */
        
        $cmb_company = new_cmb2_box( array(
                               'id'            => 'company_metabox',
                               'title'         => esc_html( 'Day 1', $this->theme ),
                               'object_types'  => array( 'menu', ), // Post type
                               'context'       => 'normal',
                               'priority'      => 'high',
                               'show_names'    => true, // Show field names on the left
                               ) );
        // Location
        $cmb_company->add_field( array(
                               'name' => esc_html( 'Location', $this->theme ),
                               'desc' => esc_html( 'ex: Paris, France', $this->theme ),
                               'id'   => '_location',
                               'type' => 'text',
                               ) );
        
        // Description
        $cmb_company->add_field( array(
                               'name' => esc_html( 'Description', $this->theme ),
                               'desc' => esc_html( 'describe company details', $this->theme ),
                               'id'   => '_desc',
                               'type' => 'textarea',
                               ) );
        // Applications
        $cmb_company->add_field( array(
                               'name' => esc_html( 'Extra Field', $this->theme ),
                               'desc' => esc_html( 'ex: 189 Applications', $this->theme ),
                               'id'   => '_applications',
                               'type' => 'text',
                               // 'split_values' => true, // Save latitude and longitude as two separate fields
                               ) );
        // Link
        $cmb_company->add_field( array(
                               'name' => esc_html( 'Link', $this->theme ),
                               'desc' => esc_html( 'event link (optional)', $this->theme ),
                               'id'   => '_link',
                               'type' => 'text_url',
                               ) );
        
        $cmb_job = new_cmb2_box( array(
                               'id'            => 'menu_metabox',
                               'title'         => esc_html( 'Job Details', $this->theme ),
                               'object_types'  => array( 'menu', ), // Post type
                               'context'       => 'normal',
                               'priority'      => 'high',
                               'show_names'    => true, // Show field names on the left
                               ) );
        // Position
        $cmb_job->add_field( array(
                               'name' => esc_html( 'Position', $this->theme ),
                               'desc' => esc_html( 'ex: Engineer', $this->theme ),
                               'id'   => '_position',
                               'type' => 'text',
                               ) );

        // Rate
        $cmb_job->add_field( array(
                               'name' => esc_html( 'Rate', $this->theme ),
                               'desc' => esc_html( 'ex: 70,000', $this->theme ),
                               'id'   => '_rate',
                               'type' => 'select',
                               'options' => array(
                                      '0'       => esc_html( '< $20,000', $this->theme ),
                                      '1'       => esc_html( '$20,000 - $50,000', $this->theme ),
                                      '2'       => esc_html( '$50,000 - $100,000', $this->theme ),
                                      '3'       => esc_html( '$100,000 - $150,000', $this->theme ),
                                      '4'       => esc_html( '$150,000 - $200,000', $this->theme ),
                                      '5'       => esc_html( '> $200,000', $this->theme ),
                                      ),
                               ) );
        // Role
        $cmb_job->add_field( array(
                               'name' => esc_html( 'Role', $this->theme ),
                               'desc' => esc_html( 'ex: fulltime', $this->theme ),
                               'id'   => '_role',
                               'type' => 'select',
                               'options' => array(
                                      '1'       => esc_html( 'Full-Time', $this->theme ),
                                      '2'       => esc_html( 'Part-Time', $this->theme ),
                                      '3'       => esc_html( 'Freelance', $this->theme ),
                                      '4'       => esc_html( 'Contract', $this->theme ),
                                      ),
                               ) );
        
        // Extras
        $cmb_job->add_field( array(
                                'name' => esc_html( 'Extras', $this->theme ),
                                'desc' => esc_html( 'ex: Remote, Free Mac', $this->theme ),
                                'id'   => '_extras',
                                'type' => 'text',
                                'split_values' => true,
                                ) );
    
        // Apply Link
        $cmb_job->add_field( array(
                               'name'       => esc_html( 'Apply Link', $this->theme ),
                               'desc'       => esc_html( '', $this->theme ),
                               'id'         => '_apply',
                               'default'    => '/apply-to-job/',
                               'type'       => 'text_url',
                               ) );
        // Description
        $cmb_job->add_field( array(
                               'name'       => esc_html( 'Description', $this->theme ),
                               'desc'       => esc_html( 'describe job details', $this->theme ),
                               'id'         => '_descj',
                               'type'       => 'textarea',
                               ) );
        // Advantages
        $cmb_job->add_field( array(
                               'name' => esc_html( 'Feature List', $this->theme ),
                               'desc' => esc_html( 'ex: Remote & Flexible, Personal home office budget, ...', $this->theme ),
                               'id'   => '_featuresj',
                               'type' => 'textarea',
                               //'split_values' => true, // Save values as separate fields
                               ) );
        
        
        $cmb_requirements = new_cmb2_box( array(
                               'id'            => 'requirements_metabox',
                               'title'         => esc_html( 'Skills & Requirements', $this->theme ),
                               'object_types'  => array( 'menu', ), // Post type
                               'context'       => 'normal',
                               'priority'      => 'high',
                               'show_names'    => true, // Show field names on the left
                               ) );

        // Description
        $cmb_requirements->add_field( array(
                               'name'       => esc_html( 'Description', $this->theme ),
                               'desc'       => esc_html( 'describe job details', $this->theme ),
                               'id'         => '_descr',
                               'default'    => '',
                               'type'       => 'textarea',
                               ) );
        // Advantages
        $cmb_requirements->add_field( array(
                               'name' => esc_html( 'Feature List', $this->theme ),
                               'desc' => esc_html( 'provide one feature per line', $this->theme ),
                               'id'   => '_featuresr',
                               'type' => 'textarea',
                               //'split_values' => true, // Save values as separate fields
                               ) );
    }
    
	/**
	 * Load the plugin text domain for translation.
	 */


	/**
	 * Flushes rewrite rules on plugin activation to ensure menu posts don't 404.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
	 *
	 * @uses menu Item_Post_Type::menu_init()
	 */
	public function plugin_activation() {
		$this->menu_init();
		flush_rewrite_rules();
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses menu Item_Post_Type::register_post_type()
	 * @uses menu Item_Post_Type::register_taxonomy_tag()
	 * @uses menu Item_Post_Type::register_taxonomy_category()
	 */
	public function menu_init() {
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
		return array( 'menu_category', 'menu_tag' );
	}



	/**
	 * Enable the menu Item custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => esc_html( 'Programs', 'madang' ),
			'singular_name'      => esc_html( 'Program Item', 'madang' ),
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
			'menu_icon' => 'dashicons-media-text',
			'labels'          => $labels,
			'public'          => true,
			'supports'        => array(
				'title',
				//'editor',
				'excerpt',
				'thumbnail',
				//'comments',
				//'author',
				//'custom-fields',
				'revisions',
			),
			'capability_type' => 'page',
			'menu_position'   => 5,
			'hierarchical'    => true,
			'has_archive'     => true,
      'publicly_queryable'  => false
		);

		$args = apply_filters( 'madang_args', $args );
		register_post_type( 'menu', $args );
	}



	/**
	 * Register a taxonomy for menu Item Tags.
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

		register_taxonomy( 'menu_tag', array( 'menu' ), $args );

	}

	/**
	 * Register a taxonomy for menu Item Categories.
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

		register_taxonomy( 'menu_category', array( 'menu' ), $args );
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
	 * Add columns to menu Item list screen.
	 *
	 * @link http://wptheming.com/2010/07/column-edit-pages/
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array Amended columns.
	 */
	public function add_thumbnail_column_menu( $columns ) {
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
	public function display_thumbnail_menu( $column ) {
		global $post;
        if( $post->post_type == 'menu' ){
            switch ( $column ) {
                case 'thumbnail':
                    echo get_the_post_thumbnail( $post->ID, array(35, 35, true ), array('class' => 'img-responsive') );
                break;
            }
        }
	}

	/**
	 * Add taxonomy filters to the menu admin page.
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
		if ( 'menu' != $typenow ) {
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
	 * Add menu Item count to "Right Now" dashboard widget.
	 *
	 * @return null Return early if menu post type does not exist.
	 */
	public function add_menu_counts() {
		if ( ! post_type_exists( 'menu' ) ) {
			return;
		}

		$num_posts = wp_count_posts( 'menu' );

		// Published items
		$href = 'edit.php?post_type=menu';
		$num  = number_format_i18n( $num_posts->publish );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'menu Item Item', 'menu Item Items', intval( $num_posts->publish ) );
		$text = $this->link_if_can_edit_posts( $text, $href );
		$this->display_dashboard_count( $num, $text );

		if ( 0 == $num_posts->pending ) {
			return;
		}

		// Pending items
		$href = 'edit.php?post_status=pending&amp;post_type=menu';
		$num  = number_format_i18n( $num_posts->pending );
		$num  = $this->link_if_can_edit_posts( $num, $href );
		$text = _n( 'menu Item Item Pending', 'menu Item Items Pending', intval( $num_posts->pending ) );
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
			<td class="first b b-menu"><?php echo esc_html( $number ); ?></td>
			<td class="t menu"><?php echo esc_html( $label ); ?></td>
		</tr>
		<?php
	}
}

new madang_menu_Post_Type;

endif;
