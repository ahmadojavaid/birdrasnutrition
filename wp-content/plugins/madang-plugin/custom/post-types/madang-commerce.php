<?php
    
    
    /* start post type */
    if ( ! class_exists( 'madang_commerce_Post_Type' ) ) :
    
    class madang_commerce_Post_Type {
        
        private $theme = 'madang';
        
        public function __construct() {
            // Run when the plugin is activated
            // register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );
            
            // // Add the commerce post type and taxonomies
            // add_action( 'init', array( $this, 'commerce_init' ) );
            
            // // Thumbnail support for commerce posts
            // add_theme_support( 'post-thumbnails', array( 'commerce' ) );
            
            // // Add thumbnails to column view
            // add_filter( 'manage_edit-commerce_columns', array( $this, 'add_thumbnail_column'), 10, 1 );
            // add_action( 'manage_pages_custom_column', array( $this, 'display_thumbnail' ), 10, 1 );
            
            // // Allow filtering of posts by taxonomy in the admin view
            // add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );
            
            // // Show commerce post counts in the dashboard
            // add_action( 'right_now_content_table_end', array( $this, 'add_commerce_counts' ) );
            
            
            // // Add taxonomy terms as body classes
            // add_action( 'add_meta_boxes', array( $this, 'add_events_metaboxes' ) );
            // add_filter( 'manage_edit-commerces_columns', array( $this, $this->theme . '_edit_commerces_columns' ) );
            // add_action( 'manage_commerces_posts_custom_column', array( $this, $this->theme . '_manage_commerces_columns' ), 10, 2 );

            //add_action( 'woocommerce_single_product_summary', 'wpse116660_wc_add_2nd_title', 6 );


            //add_action( 'save_post', 'wpse116660_wc_2nd_title_save_postdata' );
            //add_action( 'add_meta_boxes', 'wpse116660_wc_2nd_title_mb', 0 );

            add_action( 'cmb2_init', array( $this, 'add_commerce_metaboxes' ) );   
            add_action( 'widgets_init', array( $this, 'madang_woocommerce_sidebar' ) );
        }
        


        public function madang_woocommerce_sidebar() {


            $my_sidebars = array(
            array(
                'name' => 'E-commerce Sidebar 1',
                'id' => 'ecommerce-widget-area1',
                'description' => 'Will appear in the e-commerce parts of your website. Select it using Page Builder.',
            ),
            array(
                'name' => 'E-commerce Sidebar 2',
                'id' => 'ecommerce-widget-area2',
                'description' => 'Will appear in the e-commerce parts of your website. Select it using Page Builder.',
            ),
            array(
                'name' => 'E-commerce Sidebar 3',
                'id' => 'ecommerce-widget-area3',
                'description' => 'Will appear in the e-commerce parts of your website. Select it using Page Builder.',
            ),
            );

            $defaults = array(
                'name' => 'Awesome Sidebar',
                'id' => 'awesome-sidebar',
                'description' => 'The Awesome Sidebar is shown on the left hand side of blog pages in this theme',
                'class' => '',
                'before_widget' => '<li id="%1$s" class="widget %2$s">',
                'after_widget' => '</li>',
                'before_title' => '<h2 class="widgettitle">',
                'after_title' => '</h2>' 
            );

            foreach( $my_sidebars as $sidebar ) {
                $args = wp_parse_args( $sidebar, $defaults );
                register_sidebar( $args );
            }
        }

        /**
         * Create madang commerce specific meta box key values
         */
        public function add_commerce_metaboxes() {


            /**
             * Initiate the metabox
             */
            $cmb = new_cmb2_box( array(
                                   'id'            => 'product_metabox',
                                   'title'         => esc_html__( 'Product Extra Details', $this->theme ),
                                   'object_types'  => array( 'product', ), // Post type
                                   'context'       => 'normal',
                                   'priority'      => 'high',
                                   'show_names'    => true, // Show field names on the left
                                   // 'cmb_styles' => false, // false to disable the CMB stylesheet
                                   // 'closed'     => true, // Keep the metabox closed by default
                                   ) );

            // Product subtitle
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Product subtitle', $this->theme ),
                                   'desc' => esc_html__( 'Will show up immediately below product main title', $this->theme ),
                                   'id'   => $this->theme . '_title',
                                   'type' => 'text',
                                   ) );

            // Calories
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Calories', $this->theme ),
                                   'desc' => esc_html__( 'Will be used for filtering and popup description (integer only)', $this->theme ),
                                   'id'   => $this->theme . '_calories',
                                   'type' => 'text_small',
                                   ) );

            // Proteins
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Proteins', $this->theme ),
                                   'desc' => esc_html__( 'Will be used for filtering and popup description (integer only)', $this->theme ),
                                   'id'   => $this->theme . '_proteins',
                                   'type' => 'text_small',
                                   ) );

            // Fats
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Fats', $this->theme ),
                                   'desc' => esc_html__( 'Will be used for filtering and popup description (integer only)', $this->theme ),
                                   'id'   => $this->theme . '_fats',
                                   'type' => 'text_small',
                                   ) );

            // Carbohydrates
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Carbohydrates', $this->theme ),
                                   'desc' => esc_html__( 'Will be used for filtering and popup description (integer only)', $this->theme ),
                                   'id'   => $this->theme . '_carbohydrates',
                                   'type' => 'text_small',
                                   ) );

            // Ingredients
            $cmb->add_field( array(
                                   'name' => esc_html__( 'Ingredients', $this->theme ),
                                   'desc' => esc_html__( 'Important! Separate multiple values by new line', $this->theme ),
                                   'id'   => $this->theme . '_ingredients',
                                   'type' => 'textarea',
                                   ) );

        }
        
        public function madang_edit_commerces_columns( $columns ) {
            
            $columns = array(
                             'cb'               => '<input type="checkbox" />',
                             'title'            => esc_html__( 'Title', $this->theme),
                             'quick_preview'    => esc_html__( 'Preview', $this->theme),
                             'shortcode'        => esc_html__( 'Shortcode', $this->theme),
                             'date'             => esc_html__( 'Date', $this->theme),
                             );
            
            return $columns;
        }
        
        function madang_manage_commerces_columns( $column, $post_id ) {
            
            global $post;
            $post_data = get_post($post_id, ARRAY_A);
            $slug = $post_data['post_name'];
            add_thickbox();
            switch( $column ) {
                case 'shortcode' :
                    echo '<textarea style="min-width:100%; max-height:30px; background:#eee;">[madang_commerce id="'.$slug.'"]</textarea>';
                    break;
                case 'quick_preview' :
                    echo '<a title="'.get_the_title().'" href="'.get_the_permalink().'?preview&TB_iframe=true&width=1100&height=600" rel="logos1" class="thickbox button">+ Quick Preview</a>';
                    break;
            }
        }
        
        /**
         * Load the plugin text domain for translation.
         */
        
        
        /**
         * Flushes rewrite rules on plugin activation to ensure commerce posts don't 404.
         *
         * @link http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
         *
         * @uses commerce Item_Post_Type::commerce_init()
         */
        public function plugin_activation() {
            $this->commerce_init();
            flush_rewrite_rules();
        }
        
        /**
         * Initiate registrations of post type and taxonomies.
         *
         * @uses commerce Item_Post_Type::register_post_type()
         * @uses commerce Item_Post_Type::register_taxonomy_tag()
         * @uses commerce Item_Post_Type::register_taxonomy_category()
         */
        public function commerce_init() {
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
            return array( 'commerce_category', 'commerce_tag' );
        }

        /**
         * Enable the commerce Item custom post type.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_post_type
         */
        protected function register_post_type() {
            $labels = array(
                            'name'               => __( 'commerces', $this->theme ),
                            'singular_name'      => __( 'commerces', $this->theme ),
                            'add_new'            => __( 'Add New', $this->theme ),
                            'add_new_item'       => __( 'Add New', $this->theme ),
                            'edit_item'          => __( 'Edit Item', $this->theme ),
                            'new_item'           => __( 'Add New  Item', $this->theme ),
                            'view_item'          => __( 'View Item', $this->theme ),
                            'search_items'       => __( 'Search Items', $this->theme ),
                            'not_found'          => __( 'No items found', $this->theme ),
                            'not_found_in_trash' => __( 'No items found in trash', $this->theme ),
                            );
            
            $args = array(
                          'menu_icon' => 'dashicons-schedule',
                          'labels'          => $labels,
                          'public'          => true,
                          'supports'        => array(
                                                     'title',
                                                     'editor',
                                                     'excerpt',
                                                     'thumbnail',
                                                     //'comments',
                                                     //'author',
                                                     //'custom-fields',
                                                     'revisions',
                                                     ),
                          'capability_type' => 'page',
                          'menu_position'   => 5,
                          'hierarchical'      => true,
                          'has_archive'     => true,
                          );
            
            $args = apply_filters( 'commerceposttype_args', $args );
            register_post_type( 'commerces', $args );
        }
        
        /**
         * Register a taxonomy for commerce Item Tags.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        protected function register_taxonomy_tag() {
            $labels = array(
                            'name'                       => __( 'Tags', $this->theme ),
                            'singular_name'              => __( 'Tag', $this->theme ),
                            'menu_name'                  => __( 'Tags', $this->theme ),
                            'edit_item'                  => __( 'Edit Tag', $this->theme ),
                            'update_item'                => __( 'Update Tag', $this->theme ),
                            'add_new_item'               => __( 'Add New Tag', $this->theme ),
                            'new_item_name'              => __( 'New  Tag Name', $this->theme ),
                            'parent_item'                => __( 'Parent Tag', $this->theme ),
                            'parent_item_colon'          => __( 'Parent Tag:', $this->theme ),
                            'all_items'                  => __( 'All Tags', $this->theme ),
                            'search_items'               => __( 'Search  Tags', $this->theme ),
                            'popular_items'              => __( 'Popular Tags', $this->theme ),
                            'separate_items_with_commas' => __( 'Separate tags with commas', $this->theme ),
                            'add_or_remove_items'        => __( 'Add or remove tags', $this->theme ),
                            'choose_from_most_used'      => __( 'Choose from the most used tags', $this->theme ),
                            'not_found'                  => __( 'No  tags found.', $this->theme ),
                            );
            
            $args = array(
                          'labels'                  => $labels,
                          'public'                  => true,
                          'has_archive'             => true,
                          'show_in_menu'            => true,
                          'supports'                => array('thumbnail','editor','title','revisions','custom-fields'),
                          'show_in_nav_menus'       => false,
                          'exclude_from_search'     => true,
                          'rewrite'                 => array('slug' => ''),
                          'exclude_from_search'     => true,
                          'publicly_queryable'      => true,
                          'show_ui'                 => true,
                          'query_var'               => true,
                          'capability_type'         => 'page',
                          'hierarchical'            => true,
                          'menu_position'           => null,
                          'menu_icon'               => 'dashicons-tagcloud',
                          );
            
            $args = apply_filters( 'commerceposttype_tag_args', $args );
            
            register_taxonomy( 'commerce_tag', array( 'commerce' ), $args );
        }
        
        /**
         * Register a taxonomy for commerce Item Categories.
         *
         * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        protected function register_taxonomy_category() {
            
            
            $labels = array(
                            'name'                       => __( 'Categories', $this->theme ),
                            'singular_name'              => __( 'Category', $this->theme ),
                            'menu_name'                  => __( 'Categories', $this->theme ),
                            'edit_item'                  => __( 'Edit Category', $this->theme ),
                            'update_item'                => __( 'Update Category', $this->theme ),
                            'add_new_item'               => __( 'Add New Category', $this->theme ),
                            'new_item_name'              => __( 'New Category Name', $this->theme ),
                            'parent_item'                => __( 'Parent Category', $this->theme ),
                            'parent_item_colon'          => __( 'Parent Category:', $this->theme ),
                            'all_items'                  => __( 'All Categories', $this->theme ),
                            'search_items'               => __( 'Search Categories', $this->theme ),
                            'popular_items'              => __( 'Popular Categories', $this->theme ),
                            'separate_items_with_commas' => __( 'Separate categories with commas', $this->theme ),
                            'add_or_remove_items'        => __( 'Add or remove categories', $this->theme ),
                            'choose_from_most_used'      => __( 'Choose from the most used categories', $this->theme ),
                            'not_found'                  => __( 'No categories found.', $this->theme ),
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
            
            $args = apply_filters( 'commerceposttype_category_args', $args );
            
            register_taxonomy( 'commerce_category', array( 'commerce' ), $args );
            
            /*
            global $flatsome_opt;
            
            if(isset($flatsome_opt['commerces_page']) && $flatsome_opt['commerces_page']){
                add_action( 'wp_loaded', 'madang_add_commerce_permastructure' );
                function madang_add_commerce_permastructure() {
                    global $wp_rewrite;
                    //$items_link = $flatsome_opt['commerces_page'];
                    add_permastruct( 'commerce_category',  $items_link.'/%commerce_category%', false );
                    add_permastruct( 'commerce', $items_link.'/%commerce_category%/%commerce%', false );
                }
                
                add_filter( 'post_type_link', 'madang_commerces_permalinks', 10, 2 );
                function madang_commerces_permalinks( $permalink, $post ) {
                    if ( $post->post_type !== 'commerce' )
                        return $permalink;
                    
                    $terms = get_the_terms( $post->ID, 'commerce_category' );
                    
                    if ( ! $terms )
                        return str_replace( '%commerce_category%', '', $permalink );
                    
                    $post_terms = array();
                    foreach ( $terms as $term )
                    $post_terms[] = $term->slug;
                    
                    return str_replace( '%commerce_category%', implode( ',', $post_terms ) , $permalink );
                }
                
                
                
                // Make sure that all term links include their parents in the permalinks
                add_filter( 'term_link', 'add_term_parents_to_permalinks', 10, 2 );
                
                function add_term_parents_to_permalinks( $permalink, $term ) {
                    $term_parents = get_term_parents( $term );
                    
                    foreach ( $term_parents as $term_parent )
                    $permlink = str_replace( $term->slug, $term_parent->slug . ',' . $term->slug, $permalink );
                    
                    return $permalink;
                }
                
                // Helper function to get all parents of a term
                function get_term_parents( $term, &$parents = array() ) {
                    $parent = get_term( $term->parent, $term->taxonomy );
                    
                    if ( is_wp_error( $parent ) )
                        return $parents;
                    
                    $parents[] = $parent;
                    
                    if ( $parent->parent )
                        get_term_parents( $parent, $parents );
                    
                    return $parents;
                }
                
            } // Set custom permalinks
            
            */
            
            
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
         * Add columns to commerce Item list screen.
         *
         * @link http://wptheming.com/2010/07/column-edit-pages/
         *
         * @param array $columns Existing columns.
         *
         * @return array Amended columns.
         */
        public function add_thumbnail_column( $columns ) {
            $column_thumbnail = array( 'thumbnail' => __( 'Thumbnail', $this->theme ) );
            return array_slice( $columns, 0, 2, true ) + $column_thumbnail + array_slice( $columns, 1, null, true );
        }
        
        /**
         * Custom column callback
         *
         * @global stdClass $post Post object.
         *
         * @param string $column Column ID.
         */
        public function display_thumbnail( $column ) {
            global $post;
            if( $post->post_type == 'commerce' ){
            switch ( $column ) {
                case 'thumbnail':
                    echo get_the_post_thumbnail( $post->ID, array(35, 35) );
                    break;
            }
            }
        }
        
        /**
         * Add taxonomy filters to the commerce admin page.
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
            if ( 'commerce' != $typenow ) {
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
         * Add commerce Item count to "Right Now" dashboard widget.
         *
         * @return null Return early if commerce post type does not exist.
         */
        public function add_commerce_counts() {
            if ( ! post_type_exists( 'commerce' ) ) {
                return;
            }
            
            $num_posts = wp_count_posts( 'commerce' );
            
            // Published items
            $href = 'edit.php?post_type=commerce';
            $num  = number_format_i18n( $num_posts->publish );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'commerce Item Item', 'commerce Item Items', intval( $num_posts->publish ) );
            $text = $this->link_if_can_edit_posts( $text, $href );
            $this->display_dashboard_count( $num, $text );
            
            if ( 0 == $num_posts->pending ) {
                return;
            }
            
            // Pending items
            $href = 'edit.php?post_status=pending&amp;post_type=commerce';
            $num  = number_format_i18n( $num_posts->pending );
            $num  = $this->link_if_can_edit_posts( $num, $href );
            $text = _n( 'commerce Item Item Pending', 'commerce Item Items Pending', intval( $num_posts->pending ) );
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
<td class="first b b-commerce"><?php echo esc_html( $number ); ?></td>
<td class="t commerce"><?php echo esc_html( $label ); ?></td>
</tr>
<?php
    }
    }
    
    new madang_commerce_Post_Type;
    
    endif;
