<?php
/**
 * Envato Theme Setup Wizard Class
 *
 * Takes new users through some basic steps to setup their ThemeForest theme.
 *
 * @author      dtbaker
 * @author      vburlak
 * @package     envato_wizard
 * @version     1.0.0
 *
 * Based off the WooThemes installer.
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Envato_Theme_Setup_Wizard' ) ) {
	/**
	 * Envato_Theme_Setup_Wizard class
	 */
	class Envato_Theme_Setup_Wizard {

		protected $version = '1.0.0';

		/** @var string Current theme name, used as namespace in actions. */
		protected $theme_name = '';

		/** @var string Current Step */
		protected $step   = '';
		protected $page   = '';

		/** @var array Steps for the setup wizard */
		protected $steps  = array();

		/**
		 * Relative plugin path
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $plugin_path = '';

		/**
		 * Relative plugin url for this plugin folder, used when enquing scripts
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $plugin_url = '';

		/**
		 * The slug name to refer to this menu
		 *
		 * @since 1.1.1
		 *
		 * @var string
		 */
		protected $page_slug;

		/**
		 * TGMPA instance storage
		 *
		 * @var object
		 */
		protected $tgmpa_instance;

		/**
		 * TGMPA Menu slug
		 *
		 * @var string
		 */
		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		/**
		 * TGMPA Menu url
		 *
		 * @var string
		 */
		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

		/**
		 * The slug name for the parent menu
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $page_parent;

		/**
		 * Complete URL to Setup Wizard
		 *
		 * @since 1.1.2
		 *
		 * @var string
		 */
		protected $page_url;

   		//public $theme_name;

        public $theme_slug;

		/**
		 * Holds the current instance of the theme manager
		 *
		 * @since 1.1.3
		 * @var Envato_Theme_Setup_Wizard
		 */
		private static $instance = null;

		/**
		 * @since 1.1.3
		 *
		 * @return Envato_Theme_Setup_Wizard
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * A dummy constructor to prevent this class from being loaded more than once.
		 *
		 * @see Envato_Theme_Setup_Wizard::instance()
		 *
		 * @since 1.1.1
		 * @access private
		 */
		public function __construct() {
			$this->init_globals();
			//if ( strtolower( wp_get_theme() ) == strtolower(KENZAP_THEME) ){
				$this->init_actions();
			//} 
		}

		/**
		 * Get the default style. Can be overriden by theme init scripts.
		 *
		 * @see Envato_Theme_Setup_Wizard::instance()
		 *
		 * @since 1.1.9
		 * @access public
		 */
		public function get_header_logo_width(){
			return '100px';
		}

		/**
		 * Setup the class globals.
		 *
		 * @since 1.1.1
		 * @access public
		 */
		public function init_globals() {

			$theme = wp_get_theme();
  			$this->version = $theme['Version'];
			$current_theme = wp_get_theme();
			$this->theme_name = ucfirst( basename( get_template_directory() ) );
            $this->theme_slug = strtolower( $this->theme_name );
			//$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#','',$current_theme->get( 'Name' ) ) );
			$this->page_slug = apply_filters( $this->theme_slug.'_theme_setup_wizard_page_slug', $this->theme_slug.'-setup' );
			$this->parent_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_parent_slug', '' );

			//If we have parent slug - set correct url
			if( $this->parent_slug !== '' ){
				$this->page_url = 'admin.php?page='.$this->page_slug;
			}else{
				$this->page_url = 'admin.php?page='.$this->page_slug;
			}
			$this->page_url = apply_filters( $this->theme_slug . '_theme_setup_wizard_page_url', $this->page_url );

			//set relative plugin path url
			$this->plugin_path = trailingslashit( $this->cleanFilePath( dirname( __FILE__ ) ) );
			$relative_url = str_replace( $this->cleanFilePath( get_template_directory() ), '', $this->plugin_path );
			//$this->plugin_url = trailingslashit( get_template_directory_uri(). $relative_url );
			$this->plugin_url = trailingslashit( plugin_dir_url(__FILE__) );
		}

		/**
		 * Setup the hooks, actions and filters.
		 *
		 * @uses add_action() To add actions.
		 * @uses add_filter() To add filters.
		 *
		 * @since 1.1.1
		 * @access public
		 */
		public function init_actions() {

			if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' )  ) {

				if(!is_child_theme()){
					add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );
				}

				if(class_exists( 'TGM_Plugin_Activation' ) && isset($GLOBALS['tgmpa'])) {
					add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
					add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
				}

				add_action( 'admin_menu', array( $this, 'admin_menus' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
				add_action( 'admin_init', array( $this, 'init_wizard_steps' ), 30 );
				add_action( 'admin_init', array( $this, 'setup_wizard' ), 30 );
				add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
				add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
				add_action( 'wp_ajax_envato_setup_content', array( $this, 'ajax_content' ) );
				

			 	$this->page = ( isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : "" );
		
			 	if ( false != get_option($this->theme_slug.'_install_url', false) && $this->page == 'wc-setup' ){

					wp_safe_redirect( get_site_url().get_option($this->theme_slug.'_install_url', false), $status );
					exit;
			 	}


				//add theme admin menu
			    add_action( 'admin_menu', array( $this, 'plugin_setup_menu' ) );

			}
			add_action('upgrader_post_install', array($this,'upgrader_post_install'), 10, 2);
		}

		public function plugin_setup_menu(){

		   	add_menu_page( ucfirst( 'Setup' ), ucfirst( 'Setup' ), 'manage_options', $this->theme_slug.'-menu', array( $this, 'menu_init' ), '', 2 );
			add_submenu_page( $this->theme_slug.'-menu', esc_attr( 'Customize', $this->theme_slug ), esc_attr( 'Customize', $this->theme_slug ), 'administrator', 'customize.php?theme='.$this->theme_slug );
			add_submenu_page( $this->theme_slug.'-menu', esc_attr( 'Setup Wizard', $this->theme_slug ), esc_attr( 'Setup Wizard', $this->theme_slug ), 'administrator', $this->theme_slug.'-setup', array( $this, 'menu_init' ) );
		}

		public function menu_init(){

			update_option( basename( get_template_directory() ). '_last_pingback', 0 );

			echo "<h1>Version: ".$this->version ."</h1>";
			echo "<p>Thank you for using Kenzap premium theme. Feel free to <a target='_blank' href='http://kenzap.com/contacts/'>contat us</a> for assistance or customization.</p>";
			echo "<img width='600' src='".get_template_directory_uri().'/screenshot.jpg'."'>";	

		}

		/**
		 * After a theme update we clear the setup_complete option. This prompts the user to visit the update page again.
		 *
		 * @since 1.1.8
		 * @access public
		 */
		public function upgrader_post_install($return, $theme) {

			if ( is_wp_error( $return ) ) {
				return $return;
			}
			if ( $theme != get_stylesheet() ) {
				return $return;
			}
			update_option( 'envato_setup_complete', false );

			return $return;
		}
		/**
		 * We determine if the user already has theme content installed. This can happen if swapping from a previous theme or updated the current theme. We change the UI a bit when updating / swapping to a new theme.
		 *
		 * @since 1.1.8
		 * @access public
		 */
		public function is_possible_upgrade(){
			return false;
		}
		public function enqueue_scripts() {
		}
		public function tgmpa_load( $status ) {
			return is_admin() || current_user_can( 'install_themes' );
		}
		public function switch_theme() {
			set_transient( '_'.$this->theme_name.'_activation_redirect', 1 );
		}
		public function admin_redirects() {
			ob_start();

			
			//set_transient( '_'.$this->theme_name.'_activation_redirect', 1 );
			//update_option( 'envato_setup_complete', false );

			//surpress WooCommerce Setup Wizard
			// $this->page = ( isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : "" );


			// if ( !get_option( 'envato_setup_complete', false ) && $this->page == 'wc-setup' ){
			// 	$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			// }
			
			if ( ! get_transient( '_'.$this->theme_name.'_activation_redirect' ) || get_option( 'envato_setup_complete', false ) ) {
				return;
			}

			delete_transient( '_'.$this->theme_name.'_activation_redirect' );
			wp_safe_redirect( admin_url( $this->page_url ) );
			exit;
		}

		/**
		 * Get configured TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function get_tgmpa_instanse(){
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		/**
		 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
		 *
		 * @access public
		 * @since 1.1.2
		 */
		public function set_tgmpa_url(){

			$this->tgmpa_menu_slug = ( property_exists($this->tgmpa_instance, 'menu') ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters($this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug);

			$tgmpa_parent_slug = ( property_exists($this->tgmpa_instance, 'parent_slug') && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters($this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug.'?page='.$this->tgmpa_menu_slug);

		}

		/**
		 * Add admin menus/screens.
		 */
		public function admin_menus() {

			add_submenu_page($this->theme_slug.'-panel', __( 'Setup Wizard','envato_setup' ), __( 'Setup Wizard','envato_setup' ), 'manage_options', $this->page_slug,  array( $this, $this->page_slug) );
		}


		/**
		 * Setup steps.
		 *
		 * @since 1.1.1
		 * @access public
		 * @return array
		 */
		public function init_wizard_steps() {

			$this->steps = array(
				'introduction' => array(
					'name'    => __( 'Introduction', 'envato_setup' ),
					'view'    => array( $this, 'envato_setup_introduction' ),
					'handler' => array( $this, 'envato_setup_introduction_save' ),
				),
			);
			
			$this->steps['updates'] = array(
				'name'    => __( 'Welcome', 'envato_setup' ),
				'view'    => array( $this, 'envato_setup_updates' ),
				'handler' => array( $this, 'envato_setup_updates_save' ),
			);

			// $this->steps['customize'] = array(
			// 	'name'    => __( 'Child Theme', 'envato_setup' ),
			// 	'view'    => array( $this, 'envato_setup_customize' ),
			// 	'handler' => '',
			// );

			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				$this->steps['default_plugins'] = array(
					'name' => __( 'Plugins', 'envato_setup' ),
					'view' => array( $this, 'envato_setup_default_plugins' ),
					'handler' => '',
				);
			}
			// $this->steps['default_content'] = array(
			// 	'name'    => __( 'Content', 'envato_setup' ),
			// 	'view'    => array( $this, 'envato_setup_default_content' ),
			// 	'handler' => '',
			// );
			// $this->steps['design'] = array(
			// 	'name'    => __( 'Logo & Design', 'envato_setup' ),
			// 	'view'    => array( $this, 'envato_setup_logo_design' ),
			// 	'handler' => array( $this, 'envato_setup_logo_design_save' ),
			// );
			$this->steps['help_support'] = array(
				'name'    => __( 'Support', 'envato_setup' ),
				'view'    => array( $this, 'envato_setup_help_support' ),
				'handler' => '',
			);
			$this->steps['next_steps'] = array(
				'name'    => __( 'Docs', 'envato_setup' ),
				'view'    => array( $this, 'envato_setup_ready' ),
				'handler' => '',
			);
			$this->steps['default_content'] = array(
				'name'    => __( 'Content', 'envato_setup' ),
				'view'    => array( $this, 'envato_setup_default_content2' ),
				'handler' => '',
			);

			$this->steps = apply_filters(  $this->theme_name . '_theme_setup_wizard_steps', $this->steps );

		}

		/**
		 * Show the setup wizard
		 */
		public function setup_wizard() {

			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}
			ob_end_clean();

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			update_option($this->theme_slug.'_install_url', $_SERVER['REQUEST_URI']);

			wp_register_script( 'jquery-blockui', $this->plugin_url . 'js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
			wp_register_script( 'envato-setup', $this->plugin_url . 'js/envato-setup.js', array( 'jquery', 'jquery-blockui' ), $this->version );
			wp_localize_script( 'envato-setup', 'envato_setup_params', array(
				'tgm_plugin_nonce'            => array(
					'update' => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url' => admin_url( $this->tgmpa_url ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
				'verify_text' => __( '...verifying','envato_setup' ),
			) );

			//wp_enqueue_style( 'envato_wizard_admin_styles', $this->plugin_url . '/css/admin.css', array(), $this->version );
			wp_enqueue_style( 'envato-setup', $this->plugin_url . 'css/envato-setup.css', array( 'wp-admin', 'dashicons', 'install' ), $this->version );

			//enqueue style for admin notices
			wp_enqueue_style( 'wp-admin' );
			wp_enqueue_media();
			wp_enqueue_script( 'media' );

			ob_start();
			$this->setup_wizard_header();
			$this->setup_wizard_steps();
			$show_content = true;
			
			echo '<div class="envato-setup-content">';
			if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {

				//var_dump($this->steps[ $this->step ]['handler']);//die;
				//echo $this->steps[ $this->step ]['handler'];die;
				$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
			}
			if ( $show_content ) {
				$this->setup_wizard_content();
			}
			echo '</div>';
			$this->setup_wizard_footer();
			exit;
		}

		public function get_step_link( $step ) {
			return  add_query_arg( 'step', $step, admin_url( 'admin.php?page=' .$this->page_slug ) );
		}
		public function get_next_step_link() {
			$keys = array_keys( $this->steps );
			return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
		}

		/**
		 * Setup Wizard Header
		 */
		public function setup_wizard_header() {
		?>
		<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
		<head>
			<meta name="viewport" content="width=device-width" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title><?php _e( 'Theme &rsaquo; Setup Wizard', 'envato_setup' ); ?></title>
			<?php wp_print_scripts( 'envato-setup' ); ?>
			<?php do_action( 'admin_print_styles' ); ?>
			<?php do_action( 'admin_print_scripts' ); ?>
			<?php //do_action( 'admin_head' ); ?>
		</head>
		<body class="envato-setup wp-core-ui">
		<h1 id="wc-logo">
			<?php
				$image_url = do_shortcode(get_theme_mod( 'site_logo', get_template_directory_uri().'/images/install-logo.svg')); 
				$image_url = apply_filters('envato_setup_logo_image',$image_url);
				if ( $image_url ) {
					$image = '<img class="site-logo" src="%s" alt="%s" style="width:220px; height:auto" />';
					printf(
						$image,
						$image_url,
						get_bloginfo( 'name' )
						//,$this->get_header_logo_width()
					);
				}?>
		</h1>
		<?php
		}

		/**
		 * Setup Wizard Footer
		 */
		public function setup_wizard_footer() {
		?>
		<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php _e( 'Return to the WordPress Dashboard', 'envato_setup' ); ?></a>
		</body>
		<?php
		@do_action( 'admin_footer' ); 
		do_action( 'admin_print_footer_scripts' );
		?>
		</html>
		<?php
	}

		/**
		 * Output the steps
		 */
		public function setup_wizard_steps() {
			$ouput_steps = $this->steps;
			array_shift( $ouput_steps );
			?>
			<ol class="envato-setup-steps">
				<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
					<li class="<?php
					$show_link = false;
					if ( $step_key === $this->step ) {
						echo 'active';
					} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
						echo 'done';
						$show_link = true;
					}
					?>"><?php
						if ( $show_link ) {
							?>
							<a href="<?php echo esc_url( $this->get_step_link( $step_key ) );?>"><?php echo esc_html( $step['name'] );?></a>
							<?php
						} else {
							echo esc_html( $step['name'] );
						}
						?></li>
				<?php endforeach; ?>
			</ol>
			<?php
		}

		/**
		 * Get the default style. Can be overriden by theme init scripts.
		 *
		 * @see Envato_Theme_Setup_Wizard::instance()
		 *
		 * @since 1.1.7
		 * @access public
		 */
		public function get_default_theme_style() {
			return 'style1';
		}

		public function filter_options( $options ) {
			return $options;
		}

		/**
		 * Output the content for the current step
		 */
		public function setup_wizard_content() {
			isset( $this->steps[ $this->step ] ) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
		}

		/**
		 * Introduction step
		 */
			/**
		 * Introduction step
		 */
		public function envato_setup_introduction() {

			if ( false ) {
				echo '<pre>';
				// debug inserting a particular post so we can see what's going on
				$post_type = 'nav_menu_item';
				$post_id   = 239; // debug this particular import post id.
				$all_data  = $this->_get_json( 'default.json' );
				if ( ! $post_type || ! isset( $all_data[ $post_type ] ) ) {
					echo "Post type $post_type not found.";
				} else {
					echo "Looking for post id $post_id \n";
					foreach ( $all_data[ $post_type ] as $post_data ) {
						if ( $post_data['post_id'] == $post_id ) {
							//print_r( $post_data );
							$this->_process_post_data( $post_type, $post_data, 0, true );
						}
					}
				}
				$this->_handle_delayed_posts();
				print_r( $this->logs );
				echo '</pre>';
			} else if ( isset( $_REQUEST['export'] ) ) {
				include( plugin_dir_path(__FILE__) . 'envato-setup-export.php' );
			} else if ( $this->is_possible_upgrade() ) {
				?>
				<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.' ), wp_get_theme() ); ?></h1>
				<p><?php esc_html_e( 'It looks like you may have recently upgraded to this theme. Great! This setup wizard will help ensure all the default settings are correct. It will also show some information about your new website and support options.' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Not right now' ); ?></a>
				</p>
				<?php 
			} else if ( strpos( strtolower( wp_get_theme()), 'child') !== false ) {  
				?>
				<h1><?php printf( esc_html__( 'Please deactivate %s theme before install.' ), wp_get_theme() ); ?></h1>
				<p><?php echo $this->output_html( "It looks like may have not activated correct theme version! This setup wizard requires that <b>".$this->theme_name.' theme</b> is active during registration and demo content installation. Once finished feel free to switch to <b>'.wp_get_theme().' </b> in order to perform theme customization.' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( 'themes.php?theme='.$this->theme_slug ); ?>"
					   class="button-primary button button-large button-next"><?php esc_html_e( 'Switch themes' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Cancel' ); ?></a>
				</p>
				<?php
			} else if ( get_option( 'envato_setup_complete', false ) ) {
				?>
				<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.' ), wp_get_theme() ); ?></h1>
				<p><?php esc_html_e( 'It looks like you have already run the setup wizard. Below are some options: ' ); ?></p>
				<ul style="list-style: none;">
					<li>
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
						   class="button-primary button button-next button-large"><?php esc_html_e( 'Run Setup Wizard Again' ); ?></a>
					</li>
					<li>
						<form method="post">
							<input type="hidden" name="reset-font-defaults" value="yes">
							<!-- <input type="submit" class="button-primary button button-large button-next"
							       value="<?php esc_attr_e( 'Reset font style and colors' ); ?>" name="save_step"/> -->
							<?php wp_nonce_field( 'envato-setup' ); ?>
						</form>
					</li>
				</ul>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Cancel' ); ?></a>
				</p>
				<?php

			} else {
				?>
				<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.' ), wp_get_theme() ); ?></h1>
				<p><?php printf( esc_html__( 'Thank you for choosing the %s theme. This quick setup wizard will help you configure your new website. This wizard will install the required WordPress plugins, default content, logo and tell you a little about Help &amp; Support options. It should only take 5 minutes.' ), wp_get_theme() ); ?></p>
				<p><?php esc_html_e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!' ); ?></p>
				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
					   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!' ); ?></a>
					<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
					   class="button button-large"><?php esc_html_e( 'Not right now' ); ?></a>
				</p>
				<?php
			}
		}

		public function output_html( $str ) {
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

		/**
		 *
		 * Handles save button from welcome page. This is to perform tasks when the setup wizard has already been run. E.g. reset defaults
		 *
		 * @since 1.2.5
		 */
		public function envato_setup_introduction_save(){

			check_admin_referer( 'envato-setup' );
			return false;
		}

		private function _wp_get_attachment_id_by_post_name( $post_name ) {
	        global $wpdb;
			$str = $post_name;
			$posts = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_title = '$str' ", OBJECT );
			if($posts) return $posts[0]->ID;
   		}

		private function _get_plugins() {
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugins = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}
			return $plugins;
		}

		/**
		 * Page setup
		 */
		public function envato_setup_default_plugins() {

			//verify email address if provided
			$slug = basename( get_template_directory() );
			$email_address = '';
			if(isset($_POST[$slug . '_email_address'])){
				update_option( $slug . '_email_address', $_POST[$slug . '_email_address'] );
			}

			tgmpa_load_bulk_installer();
			// install plugins with TGM.
			if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
				die( 'Failed to find TGM' );
			}
			$url = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
			$plugins = $this->_get_plugins();

			// copied from TGM

			$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
			$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
				return true; // Stop the normal page form from displaying, credential request form will be shown.
			}

			// Now we have some credentials, setup WP_Filesystem.
			if ( ! WP_Filesystem( $creds ) ) {
				// Our credentials were no good, ask the user for them again.
				request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

				return true;
			}

			/* If we arrive here, we have the filesystem */

			?>
			<h1><?php _e( 'Default Plugins', 'envato_setup' ); ?></h1>
			<form method="post">

				<?php
				$plugins = $this->_get_plugins();
				if ( count( $plugins['all'] ) ) {
					?>
					<p class="lead"><?php _e( 'This will install the default plugins included with '.$this->theme_name.'. You can add and remove plugins later on from within WordPress.', 'envato_setup' ); ?></p>
					<ul class="envato-wizard-plugins">
						<?php foreach ( $plugins['all'] as $slug => $plugin ) {  ?>
							<li data-slug="<?php echo esc_attr( $slug );?>"><?php echo esc_html( $plugin['name'] );?>
								<span>
    								<?php
								    $keys = array();
								    if ( isset( $plugins['install'][ $slug ] ) ) { $keys[] = 'Installation'; }
								    if ( isset( $plugins['update'][ $slug ] ) ) { $keys[] = 'Update'; }
								    if ( isset( $plugins['activate'][ $slug ] ) ) { $keys[] = 'Activation'; }
								    echo implode( ' and ',$keys ).' required';
								    ?>
    							</span>
								<div class="spinner"></div>
							</li>
						<?php } ?>
					</ul>
					<?php
				} else {
					echo '<p class="lead">'.__( 'Good news! All plugins are already installed and up to date. Please continue.','envato_setup' ).'</p>';
				} ?>

				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_plugins"><?php _e( 'Continue', 'envato_setup' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'envato_setup' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form>
			<?php
		}

		public function ajax_plugins() {
			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => __( 'No Slug Found','envato_setup' ) ) );
			}
			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url' => admin_url( $this->tgmpa_url ),
						'plugin' => array( $slug ),
						'tgmpa-page' => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
						'action' => 'tgmpa-bulk-activate',
						'action2' => -1,
						'message' => __( 'Activating Plugin','envato_setup' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url' => admin_url( $this->tgmpa_url ),
						'plugin' => array( $slug ),
						'tgmpa-page' => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
						'action' => 'tgmpa-bulk-update',
						'action2' => -1,
						'message' => __( 'Updating Plugin','envato_setup' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url' => admin_url( $this->tgmpa_url ),
						'plugin' => array( $slug ),
						'tgmpa-page' => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce' => wp_create_nonce( 'bulk-plugins' ),
						'action' => 'tgmpa-bulk-install',
						'action2' => -1,
						'message' => __( 'Installing Plugin','envato_setup' ),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'done' => 1, 'message' => __( 'Success','envato_setup' ) ) );
			}
			exit;
		}

		private function _content_default_get() {

			$content = array();

			// find out what content is in our default json file.
			$available_content = $this->_get_json( 'default.json' );
			foreach($available_content as $post_type => $post_data){
				if(count($post_data)){
					$first = current($post_data);
					$post_type_title = !empty($first['type_title']) ? $first['type_title'] : ucwords( $post_type ).'s';
					if($post_type_title == 'Navigation Menu Items'){
						$post_type_title = 'Navigation';
					}
					$content[$post_type] = array(
						'title' => $post_type_title,
						'description' => sprintf( __( 'This will create default %s as seen in the demo.', 'envato_setup' ), $post_type_title ),
						'pending' => __( 'Pending.', 'envato_setup' ),
						'installing' => __( 'Installing.', 'envato_setup' ),
						'success' => __( 'Success.', 'envato_setup' ),
						'install_callback' => array( $this,'_content_install_type' ),
						'checked' => $this->is_possible_upgrade() ? 0 : 1 // dont check if already have content installed.
					);
				}
			}

			$content['widgets'] = array(
				'title' => __( 'Widgets', 'envato_setup' ),
				'description' => __( 'Insert default sidebar widgets as seen in the demo.', 'envato_setup' ),
				'pending' => __( 'Pending.', 'envato_setup' ),
				'installing' => __( 'Installing Default Widgets.', 'envato_setup' ),
				'success' => __( 'Success.', 'envato_setup' ),
				'install_callback' => array( $this,'_content_install_widgets' ),
				'checked' => $this->is_possible_upgrade() ? 0 : 1 // dont check if already have content installed.
			);
	
			$content['settings'] = array(
				'title' => __( 'Settings', 'envato_setup' ),
				'description' => __( 'Configure default settings.', 'envato_setup' ),
				'pending' => __( 'Pending.', 'envato_setup' ),
				'installing' => __( 'Installing Default Settings.', 'envato_setup' ),
				'success' => __( 'Success.', 'envato_setup' ),
				'install_callback' => array( $this,'_content_install_settings' ),
				'checked' => $this->is_possible_upgrade() ? 0 : 1 // dont check if already have content installed.
			);

			$content = apply_filters( $this->theme_name . '_theme_setup_wizard_content', $content );

			return $content;

		}

		/**
		 * Page setup
		 */
		public function envato_setup_default_content() {
			?>
			<h1><?php _e( 'Install Demo Content', 'envato_setup' ); ?></h1>
			<form method="post">
				<?php if($this->is_possible_upgrade()){ ?>
					<p><?php _e('It looks like you already have content installed on this website. If you would like to install the default demo content as well you can select it below. Otherwise just choose the upgrade option to ensure everything is up to date.'); ?></p>
				<?php }else{ ?>
					<p class="lead"><?php printf( __( 'It\'s time to insert some default content for your new '.$this->theme_name.' website. Choose what you would like inserted below and click Continue. It is recommended to leave everything selected. Once inserted, this content can be managed from the WordPress admin dashboard. ', 'envato_setup' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" target="_blank">', '</a>' ); ?></p>
				<?php } ?>
				<table class="envato-setup-pages" cellspacing="0">
					<thead>
					<tr>
						<td class="check"> </td>
						<th class="item"><?php _e( 'Item', 'envato_setup' ); ?></th>
						<th class="description"><?php _e( 'Description', 'envato_setup' ); ?></th>
						<th class="status"><?php _e( 'Status', 'envato_setup' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ( $this->_content_default_get() as $slug => $default ) {  ?>
						<tr class="envato_default_content" data-content="<?php echo esc_attr( $slug );?>">
							<td>
								<input type="checkbox" name="default_content[<?php echo esc_attr( $slug );?>]" class="envato_default_content" id="default_content_<?php echo esc_attr( $slug );?>" value="1" <?php echo (!isset($default['checked']) || $default['checked']) ? ' checked':'';?>>
							</td>
							<td><label for="default_content_<?php echo esc_attr( $slug );?>"><?php echo $default['title']; ?></label></td>
							<td class="description"><?php echo $default['description']; ?></td>
							<td class="status"> <span><?php echo $default['pending'];?></span> <div class="spinner"></div></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_content"><?php _e( 'Continue', 'envato_setup' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'envato_setup' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form>
			<?php
		}

		/**
		 * Page setup
		 */
		public function envato_setup_default_content2() {
			?>
			<h1><?php _e( 'Install Demo Content', 'envato_setup' ); ?></h1>
			<form method="post">
				<?php if($this->is_possible_upgrade()){ ?>
					<p><?php _e('It looks like you already have content installed on this website. If you would like to install the default demo content as well you can select it below. Otherwise just choose the upgrade option to ensure everything is up to date.'); ?></p>
				<?php }else{ ?>
					<p class="lead"><?php printf( __( 'It\'s time to insert some default content for your new '.$this->theme_name.' website. Choose what you would like inserted below and click Continue. It is recommended to leave everything selected. Once inserted, this content can be managed from the WordPress admin dashboard. ', 'envato_setup' ), '<a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '" target="_blank">', '</a>' ); ?></p>
				<?php } ?>
				<table class="envato-setup-pages" cellspacing="0">
					<thead>
					<tr>
						<td class="check"> </td>
						<th class="item"><?php _e( 'Item', 'envato_setup' ); ?></th>
						<th class="description"><?php _e( 'Description', 'envato_setup' ); ?></th>
						<th class="status"><?php _e( 'Status', 'envato_setup' ); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ( $this->_content_default_get() as $slug => $default ) {  ?>
						<tr class="envato_default_content" data-content="<?php echo esc_attr( $slug );?>">
							<td>
								<input type="checkbox" name="default_content[<?php echo esc_attr( $slug );?>]" class="envato_default_content" id="default_content_<?php echo esc_attr( $slug );?>" value="1" <?php echo (!isset($default['checked']) || $default['checked']) ? ' checked':'';?>>
							</td>
							<td><label for="default_content_<?php echo esc_attr( $slug );?>"><?php echo $default['title']; ?></label></td>
							<td class="description"><?php echo $default['description']; ?></td>
							<td class="status"> <span><?php echo $default['pending'];?></span> <div class="spinner"></div></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>

				<p class="envato-setup-actions step">
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next" data-callback="install_content"><?php _e( 'Continue', 'envato_setup' ); ?></a>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'envato_setup' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form>
			<?php
		}


		public function ajax_content() {
			$content = $this->_content_default_get();
			if ( ! check_ajax_referer( 'envato_setup_nonce', 'wpnonce' ) || empty( $_POST['content'] ) && isset( $content[ $_POST['content'] ] ) ) {
				wp_send_json_error( array( 'error' => 1, 'message' => __( 'No content Found','envato_setup' ) ) );
			}

			$json = false;
			$this_content = $content[ $_POST['content'] ];

			if ( isset( $_POST['proceed'] ) ) {
				// install the content!
				if ( ! empty( $this_content['install_callback'] ) ) {
					if ( $result = call_user_func( $this_content['install_callback'] ) ) {
						if( is_array( $result ) && isset( $result['retry'] ) ){
							// we split the stuff up again.
							$json = array(
								'url' => admin_url( 'admin-ajax.php' ),
								'action' => 'envato_setup_content',
								'proceed' => 'true',
								'retry' => time(),
								'retry_count' => $result['retry_count'],
								'content' => $_POST['content'],
								'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
								'message' => $this_content['installing'],
							);
						}else{
							$json = array(
								'done' => 1,
								'message' => $this_content['success'],
								'debug' => $result,
							);
						}
					}
				}
			} else {

				$json = array(
					'url' => admin_url( 'admin-ajax.php' ),
					'action' => 'envato_setup_content',
					'proceed' => 'true',
					'content' => $_POST['content'],
					'_wpnonce' => wp_create_nonce( 'envato_setup_nonce' ),
					'message' => $this_content['installing'],
				);
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json( array( 'error' => 1, 'message' => __( 'Error','envato_setup' ) ) );
			}

			exit;
		}

		private function _make_child_theme( $new_theme_title ) {

				$parent_theme_title = $this->theme_slug;
				$parent_theme_template = $this->theme_slug.'';
				$parent_theme_name = get_stylesheet();
				$parent_theme_dir = get_stylesheet_directory();

				// Turn a theme name into a directory name
				$new_theme_name = sanitize_title( $new_theme_title );
				$theme_root = get_theme_root();

				// Validate theme name
				$new_theme_path = $theme_root.'/'.$new_theme_name;
				if ( file_exists( $new_theme_path ) ) {
					// Don't create child theme.
				} else{
					// Create Child theme
					mkdir( $new_theme_path );

					$plugin_folder = plugin_dir_path(__FILE__) . 'child-theme/';

					// Make style.css
					ob_start();
					require $plugin_folder.'child-theme-css.php';
					$css = ob_get_clean();
					file_put_contents( $new_theme_path.'/style.css', $css );
					echo "copying";
					// Copy functions.php 
					copy( $plugin_folder.'functions.php', $new_theme_path.'/functions.php' );
					
					// Copy screenshot
					copy( $plugin_folder.'screenshot.jpg', $new_theme_path.'/screenshot.jpg' );

					// Make child theme an allowed theme (network enable theme)
					$allowed_themes = get_site_option( 'allowedthemes' );
					$allowed_themes[ $new_theme_name ] = true;
					update_site_option( 'allowedthemes', $allowed_themes );
				}
				
				// Switch to theme
				if($parent_theme_template !== $new_theme_name){
					echo '<p class="lead success">Child Theme <strong>'.$new_theme_title.'</strong> created and activated! Folder is located in wp-content/themes/<strong>'.$new_theme_name.'</strong></p>';
					update_option('fl_has_child_theme', $new_theme_name);
					switch_theme( $new_theme_name, $new_theme_name );
				}
		}



		private function _imported_term_id( $original_term_id , $new_term_id = false ){
			$terms = get_transient('importtermids');
			if(!is_array($terms))$terms = array();
			if($new_term_id){
				$terms[$original_term_id] = $new_term_id;
				set_transient('importtermids', $terms, 60 * 60 * 24 );
			}else if($original_term_id && isset($terms[$original_term_id])){
				return $terms[$original_term_id];
			}
			return false;
		}

		private function _imported_post_id( $original_id = false , $new_id = false ){
			if(is_array($original_id) || is_object($original_id))return false;
			$post_ids = get_transient('importpostids');
			if(!is_array($post_ids))$post_ids = array();
			if($new_id){
				$post_ids[$original_id] = $new_id;
				set_transient('importpostids', $post_ids, 60 * 60 * 24 );
			}else if($original_id && isset($post_ids[$original_id])){
				return $post_ids[$original_id];
			}else if($original_id === false){
				return $post_ids;
			}
			return false;
		}
		private function _post_orphans( $original_id = false, $missing_parent_id = false ){
			$post_ids = get_transient('postorphans');
			if(!is_array($post_ids))$post_ids = array();
			if($missing_parent_id){
				$post_ids[$original_id] = $missing_parent_id;
				set_transient('postorphans', $post_ids, 60 * 60 * 24 );
			}else if($original_id && isset($post_ids[$original_id])){
				return $post_ids[$original_id];
			}else if($original_id === false){
				return $post_ids;
			}
			return false;
		}

		private function _cleanup_imported_ids(){
			// loop over all attachments and assign the correct post ids to those attachments.

		}

		private $delay_posts = array();
		private function _delay_post_process( $post_type, $post_data ){
			if(!isset($this->delay_posts[$post_type]))$this->delay_posts[$post_type]= array();
			$this->delay_posts[$post_type][] = $post_data;
		}


		// return the difference in length between two strings
		public function cmpr_strlen( $a, $b ) {
			return strlen( $b ) - strlen( $a );
		}

		private function _process_post_data( $post_type, $post_data, $delayed = false ){

			if ( ! post_type_exists( $post_type ) ) {
				return false;
			}
			/*if ( 'nav_menu_item' == $post_type ) {
				$this->process_menu_item( $post );
				continue;
			}*/

			if(empty($post_data['post_title']) && empty($post_data['post_name'])){
				// this is menu items
				$post_data['post_name'] = $post_data['post_id'];
			}

			$post_data['post_type'] = $post_type;

			$post_parent = (int) $post_data['post_parent'];
			if ( $post_parent ) {
				// if we already know the parent, map it to the new local ID
				if ( $this->_imported_post_id( $post_parent ) ) {
					$post_data['post_parent'] = $this->_imported_post_id( $post_parent );
					// otherwise record the parent for later
				} else {
					$this->_post_orphans( intval( $post_data['post_id'] ) , $post_parent);
					$post_data['post_parent'] = 0;
				}
			}

			// check if already exists
			if( empty($post_data['post_title']) && !empty($post_data['post_name'])){
				global $wpdb;
				$sql = "
					SELECT ID, post_name, post_parent, post_type
					FROM $wpdb->posts
					WHERE post_name = %s
					AND post_type = %s
				";
				$pages = $wpdb->get_results( $wpdb->prepare($sql,array($post_data['post_name'], $post_type)), OBJECT_K );
				$foundid = 0;
				foreach ( (array) $pages as $page ) {
					if($page->post_name == $post_data['post_name'] && empty($page->post_title)){
						$foundid = $page->ID;
					}
				}
				if($foundid){
					$this->_imported_post_id( $post_data['post_id'], $foundid );
					return true;
				}
			}
			$post_exists = post_exists( $post_data['post_title'] ); //, '', $post_data['post_date_gmt'] );
			if ( $post_exists && get_post_type( $post_exists ) == $post_type ) {
				$existing_post = get_post($post_exists);
				if(!empty($post_data['post_title']) || (empty($post_data['post_title']) && $existing_post->post_name == $post_data['post_name'])) {
					// this is the same.
					$this->_imported_post_id( $post_data['post_id'], $post_exists );
//					echo $post_data['post_id'] . " title " . $post_data['post_title'] . " already exists 1: $post_exists\n";
					return true;
				}
			}

			switch($post_type){
					case 'attachment':
					// import media via url
					if(!empty($post_data['guid'])){

						// check if this has already been imported.
						$old_guid = $post_data['guid'];
						if($this->_imported_post_id( $old_guid)){
							return true; // alrady done;
						}
						// ignore post parent, we haven't imported those yet.
//							$file_data = wp_remote_get($post_data['guid']);
						$remote_url = $post_data['guid'];

						$post_data['upload_date'] = date('Y/m',strtotime($post_data['post_date_gmt']));
						if ( isset( $post_data['meta'] ) ) {
							foreach ( $post_data['meta'] as $key => $meta ) {
								if ( $key == '_wp_attached_file' ) {
									foreach((array)$meta as $meta_val) {
										if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta_val, $matches ) ) {
											$post_data['upload_date'] = $matches[0];
										}
									}
								}
							}
						}

						$upload = $this->_fetch_remote_file( $remote_url, $post_data );

						if ( !is_array($upload) || is_wp_error( $upload ) ) {
							// todo: error
							return false;
						}

						if ( $info = wp_check_filetype( $upload['file'] ) ) {
							$post['post_mime_type'] = $info['type'];
						} else {
							return false;
//								return new WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'wordpress-importer' ) );
						}

						$post_data['guid'] = $upload['url'];

						// as per wp-admin/includes/upload.php
						$post_id = wp_insert_attachment( $post_data, $upload['file'] );
						wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

						// remap resized image URLs, works by stripping the extension and remapping the URL stub.
						if ( preg_match( '!^image/!', $info['type'] ) ) {
							$parts = pathinfo( $remote_url );
							$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

							$parts_new = pathinfo( $upload['url'] );
							$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

							$this->_imported_post_id( $parts['dirname'] . '/' . $name , $parts_new['dirname'] . '/' . $name_new );
						}
						$this->_imported_post_id( $post_data['post_id'], $post_id );
						$this->_imported_post_id( $old_guid, $post_id );

					}
					break;
				default:
					// work out if we have to delay this post insertion
					if ( ! empty( $post_data['meta'] ) ) {
						foreach ( $post_data['meta'] as $meta_key => $meta_val ) {

							// export gets meta straight from the DB so could have a serialized string
							$meta_val = maybe_unserialize( $meta_val );
							if ( is_array( $meta_val ) && count( $meta_val ) == 1 ) {
								$meta_val = current( $meta_val );
							}

							if ( ( $meta_key == '_menu_item_object_id' || $meta_key == '_menu_item_menu_item_parent' ) && $meta_val ) {
								$meta_val = $this->_imported_post_id( $meta_val );
								if ( ! $meta_val ) {
									if ( $delayed ) {
										return false;
									} else {
										$this->_delay_post_process( $post_type, $post_data );

										return true;
									}
								}
							}
						}
					}

					$new_image_id = $this->_wp_get_attachment_id_by_post_name('Dummy Image 1');
					$new_image_id_2 = $this->_wp_get_attachment_id_by_post_name('Dummy Image 2');
					$prod_image = $this->_wp_get_attachment_id_by_post_name('Product Dummy Image');

					// Fix Meta
					if(isset($post_data['meta']['_thumbnail_id'])){
						$post_data['meta']['_thumbnail_id'] = $new_image_id;
						if(isset($post_data['post_type']) && $post_data['post_type'] == 'product'){
							$post_data['meta']['_thumbnail_id'] = $prod_image;
						}
					}

					// Product Galleries
					if(isset($post_data['meta']['_product_image_gallery']) 
						&& is_array($post_data['meta']['_product_image_gallery'])){
						$post_data['meta']['_product_image_gallery'] = $prod_image.','.$prod_image.','.$prod_image;
					}

					// Fix post BG content
					if(preg_match_all('# bg="(\d+)"#',$post_data['post_content'],$matches)){
						foreach($matches[0] as $match_id => $string){
							$new_id = $new_image_id_2;
							if($new_id){
								$post_data['post_content'] = str_replace($string, ' bg="'.$new_id.'"', $post_data['post_content']);
							}
						}
					}

					if(preg_match_all('# id="(\d+)"#',$post_data['post_content'],$matches)){
						foreach($matches[0] as $match_id => $string){
							$new_id = $new_image_id;
							if($new_id){
								$post_data['post_content'] = str_replace($string, ' id="'.$new_id.'"', $post_data['post_content']);
							}
						}
					}

					if(preg_match_all('# img="(\d+)"#',$post_data['post_content'],$matches)){
						foreach($matches[0] as $match_id => $string){
							$new_id = $new_image_id;
							if($new_id){
								$post_data['post_content'] = str_replace($string, ' img="'.$new_id.'"', $post_data['post_content']);
							}
						}
					}

					// we have to format the post content. rewriting images and gallery stuff
					$replace = $this->_imported_post_id();
					$urls_replace = array();
					foreach($replace as $key=>$val){
						if($key && $val && !is_numeric($key) && !is_numeric($val)){
							$urls_replace[$key] = $val;
						}
					}
					if($urls_replace) {
						uksort( $urls_replace, array( &$this, 'cmpr_strlen' ) );
						foreach ( $urls_replace as $from_url => $to_url ) {
							$post_data['post_content'] = str_replace($from_url, $to_url, $post_data['post_content']);
						}
					}

					if(preg_match_all('#\[gallery[^\]]*\]#',$post_data['post_content'],$matches)){
						foreach($matches[0] as $match_id => $string){
							if(preg_match('#ids="([^"]+)"#',$string,$ids_matches)){
								$ids = explode(",",$ids_matches[1]);
								foreach($ids as $key=>$val){
									$new_id = $val ? $this->_imported_post_id($val) : false;
									if(!$new_id)unset($ids[$key]);
									else $ids[$key] = $new_id;
								}
								$new_ids = implode(',',$ids);
								$post_data['post_content'] = str_replace($ids_matches[0], 'ids="'.$new_ids.'"', $post_data['post_content']);
							}
						}
					}

					if(preg_match_all('#\[contact-form-7[^\]]*\]#',$post_data['post_content'],$matches)){
						foreach($matches[0] as $match_id => $string){
							if(preg_match('#id="(\d+)"#',$string,$id_match)){
								$new_id = $this->_imported_post_id($id_match[1]);
								if($new_id) {
									$post_data['post_content'] = str_replace($id_match[0], 'id="'.$new_id.'"', $post_data['post_content']);
								} else {
									// no imported ID found. remove this entry.
									$post_data['post_content'] = str_replace($matches[0], '(insert contact form here)', $post_data['post_content']);
								}
							}
						}
					}

					$post_id = wp_insert_post( $post_data, true );
//					echo "Processing ".$post_data['post_id']." \n\n";
					if ( !is_wp_error( $post_id ) ) {
						$this->_imported_post_id( $post_data['post_id'], $post_id );
						// add/update post meta
						if ( ! empty( $post_data['meta'] ) ) {
							foreach ( $post_data['meta'] as $meta_key => $meta_val ) {

								// export gets meta straight from the DB so could have a serialized string
								$meta_val = maybe_unserialize( $meta_val );
								if(is_array($meta_val) && count($meta_val) == 1){
									$meta_val = current($meta_val);
								}

								if( ( $meta_key == '_menu_item_object_id' || $meta_key == '_menu_item_menu_item_parent' ) && $meta_val ){
									// we get the linked page id that we should have previously entered.
									$meta_val = $this->_imported_post_id( $meta_val );
									if(!$meta_val){
										continue;
									}
								}

								$meta_val = maybe_unserialize( $meta_val );

								// if the post has a featured image, take note of this in case of remap
								if ( '_thumbnail_id' == $meta_key ) {
									/// find this inserted id and use that instead.
									$inserted_id = $this->_imported_post_id( intval( $meta_val ) );
									if($inserted_id){
										$meta_val = $inserted_id;
									}
								}
//									echo "Post meta $meta_key was $meta_val \n\n";

								update_post_meta( $post_id, $meta_key, $meta_val );

							}
						}
						if ( ! empty( $post_data['terms'] ) ) {
							$terms_to_set = array();
							foreach ( $post_data['terms'] as $term_slug => $terms ) {
								foreach($terms as $term) {
									//									echo "Adding category;";print_r($term);echo "\n\n";
									/*"term_id": 21,
									"name": "Tea",
									"slug": "tea",
									"term_group": 0,
									"term_taxonomy_id": 21,
									"taxonomy": "category",
									"description": "",
									"parent": 0,
									"count": 1,
									"filter": "raw"*/
									$taxonomy    =  $term['taxonomy'];
									if(taxonomy_exists($taxonomy)) {
										$term_exists = term_exists( $term['slug'], $taxonomy );
										$term_id     = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
										if ( ! $term_id ) {
											if(!empty( $term['parent'] )){
												// see if we have imported this yet?
												$term['parent'] = $this->_imported_term_id($term['parent']);
											}

											$t = wp_insert_term( $term['name'], $taxonomy, $term );
											if ( ! is_wp_error( $t ) ) {
												$term_id = $t['term_id'];
												//do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
											} else {
												// todo - error
												continue;
											}
										}
										$this->_imported_term_id($term['term_id'], $term_id);
										$terms_to_set[ $taxonomy ][] = intval( $term_id );
									}
								}
							}
							foreach ( $terms_to_set as $tax => $ids ) {
								wp_set_post_terms( $post_id, $ids, $tax );
							}
						}
					}

					break;
			}
			return true;
		}

		private function _content_install_type(){
			$post_type = !empty($_POST['content']) ? $_POST['content'] : false;
			$all_data = $this->_get_json('default.json');
			if(!$post_type || !isset($all_data[$post_type])){
				return false;
			}
			$limit = 10 + (isset($_REQUEST['retry_count']) ? (int)$_REQUEST['retry_count'] : 0);
			$x = 0;
			foreach($all_data[$post_type] as $post_data){

				$this->_process_post_data($post_type, $post_data);

				if($x++ > $limit){
					return array('retry' => 1, 'retry_count' => $limit);
				}

			}

			foreach($this->delay_posts as $delayed_post_type => $delayed_post_datas){
				foreach($delayed_post_datas as $delayed_post_id => $delayed_post_data){
					unset($this->delay_posts[$delayed_post_type][$delayed_post_id]);
					//echo "Processing delayed post $delayed_post_type id ".$delayed_post_data['post_id']."\n\n";
					$this->_process_post_data($delayed_post_type, $delayed_post_data);
				}
			}
			foreach($this->delay_posts as $delayed_post_type => $delayed_post_datas){
				foreach($delayed_post_datas as $delayed_post_id => $delayed_post_data){
					unset($this->delay_posts[$delayed_post_type][$delayed_post_id]);
					//echo "Processing delayed post $delayed_post_type id ".$delayed_post_data['post_id']."\n\n";
					$this->_process_post_data($delayed_post_type, $delayed_post_data, true);
				}
			}

			$this->_handle_post_orphans();

			// now we have to handle any custom SQL queries. This is needed for the events manager to store location and event details.
			$sql = $this->_get_sql(basename($post_type).'.sql');
			if($sql){
				global $wpdb;
				// do a find-replace with certain keys.
				if(preg_match_all('#__POSTID_(\d+)__#',$sql,$matches)){
					foreach($matches[0] as $match_id => $match){
						$new_id = $this->_imported_post_id($matches[1][$match_id]);
						if(!$new_id)$new_id = 0;
						$sql = str_replace($match,$new_id,$sql);
					}
				}
				$sql = str_replace("__DBPREFIX__",$wpdb->prefix,$sql);
				$bits = preg_split("/;(\s*\n|$)/", $sql);
				foreach($bits as $bit){
					$bit = trim($bit);
					if($bit){
						$wpdb->query($bit);
					}
				}
			}

			return true;

		}

		private function _handle_post_orphans(){
			$orphans = $this->_post_orphans();
			foreach($orphans as $original_post_id => $original_post_parent_id){
				if($original_post_parent_id) {
					if ( $this->_imported_post_id( $original_post_id ) && $this->_imported_post_id( $original_post_parent_id ) ) {
						$post_data = array();
						$post_data['ID'] = $this->_imported_post_id( $original_post_id );
						$post_data['post_parent'] = $this->_imported_post_id( $original_post_parent_id );
						wp_update_post( $post_data );
						$this->_post_orphans( $original_post_id, 0 ); // ignore future
					}
				}
			}
		}

		private function _fetch_remote_file( $url, $post ) {
			// extract the file name and extension from the url
			$file_name = basename( $url );
			$local_file = trailingslashit(get_template_directory()).'images/stock/'.$file_name;
			$upload = false;
			if( is_file( $local_file ) && filesize( $local_file ) > 0 ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
				WP_Filesystem();
				global $wp_filesystem;
				$file_data = $wp_filesystem->get_contents( $local_file );
				$upload = wp_upload_bits( $file_name, 0, $file_data, $post['upload_date'] );
				if ( $upload['error'] ) {
					return new WP_Error( 'upload_dir_error', $upload['error'] );
				}
			}

			if ( !$upload || $upload['error'] ) {
				// get placeholder file in the upload dir with a unique, sanitized filename
				$upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );
				if ( $upload['error'] ) {
					return new WP_Error( 'upload_dir_error', $upload['error'] );
				}

				// fetch the remote url and write it to the placeholder file
				//$headers = wp_get_http( $url, $upload['file'] );

				$max_size = (int) apply_filters( 'import_attachment_size_limit', 0 );

				// we check if this file is uploaded locally in the source folder.
				$response = wp_remote_get( $url );
				if ( is_array( $response ) && !empty($response['body']) && $response['response']['code'] == '200' ) {
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
					$headers = $response['headers'];
					WP_Filesystem();
					global $wp_filesystem;
					$wp_filesystem->put_contents( $upload['file'], $response['body'] );
					//
				} else {
					// required to download file failed.
					@unlink( $upload['file'] );
					return new WP_Error( 'import_file_error', __( 'Remote server did not respond', 'wordpress-importer' ) );
				}


				$filesize = filesize( $upload['file'] );

				if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
					@unlink( $upload['file'] );

					return new WP_Error( 'import_file_error', __( 'Remote file is incorrect size', 'wordpress-importer' ) );
				}

				if ( 0 == $filesize ) {
					@unlink( $upload['file'] );

					return new WP_Error( 'import_file_error', __( 'Zero size file downloaded', 'wordpress-importer' ) );
				}

				if ( ! empty( $max_size ) && $filesize > $max_size ) {
					@unlink( $upload['file'] );

					return new WP_Error( 'import_file_error', sprintf( __( 'Remote file is too large, limit is %s', 'wordpress-importer' ), size_format( $max_size ) ) );
				}
			}

			// keep track of the old and new urls so we can substitute them later
			$this->_imported_post_id( $url, $upload['url']);
			$this->_imported_post_id( $post['guid'], $upload['url']);
			// keep track of the destination if the remote url is redirected somewhere else
			if ( isset( $headers['x-final-location'] ) && $headers['x-final-location'] != $url ) {
				$this->_imported_post_id( $headers['x-final-location'], $upload['url'] );
			}

			return $upload;
		}


		private function _content_install_widgets() {
			// todo: pump these out into the 'content/' folder along with the XML so it's a little nicer to play with
			$import_widget_positions = $this->_get_json( 'widget_positions.json' );
			$import_widget_options = $this->_get_json( 'widget_options.json' );

			// importing.
			$widget_positions = get_option( 'sidebars_widgets' );

			// echo '<pre>'; print_r($import_widget_positions); print_r($import_widget_options); print_r($my_options); echo '</pre>';exit;
			foreach ( $import_widget_options as $widget_name => $widget_options ) {
				// replace certain elements with updated imported entries.
				foreach($widget_options as $widget_option_id => $widget_option){
					if(!empty($widget_option['nav_menu'])){
						// check if this one has been imported yet.
						$new_id = $this->_imported_term_id($widget_option['nav_menu']);
						if(!$new_id){
							unset($widget_options[$widget_option_id]);
						}else{
							$widget_options[$widget_option_id]['nav_menu'] = $new_id;
						}
					}
					if(!empty($widget_option['image_id'])){
						// check if this one has been imported yet.
						$new_id = $this->_imported_post_id($widget_option['image_id']);
						if(!$new_id){
							unset($widget_options[$widget_option_id]);
						}else{
							$widget_options[$widget_option_id]['image_id'] = $new_id;
						}
					}
				}
				$existing_options = get_option( 'widget_'.$widget_name,array() );
				$new_options = $existing_options + $widget_options;
				//                        echo $widget_name;
				//                        print_r($new_options);
				update_option( 'widget_'.$widget_name,$new_options );
			}
			update_option( 'sidebars_widgets',array_merge( $widget_positions,$import_widget_positions ) );
			//                    print_r($widget_positions + $import_widget_positions);exit;

			return true;
		}
		public function _content_install_settings() {


			$menu_ids = $this->_get_json( 'menu.json' );
			$save = array();
			foreach($menu_ids as $menu_id => $term_id){
				$new_term_id = $this->_imported_term_id($term_id);
				if($new_term_id){
					$save[$menu_id] = $new_term_id;
				}
			}
			if ( $save ) {
				set_theme_mod( 'nav_menu_locations', array_map( 'absint', $save ) );
			}

			$custom_options = $this->_get_json( 'options.json' );

			// we also want to update the widget area manager options.
			foreach ( $custom_options as $option => $value ) {
				// we have to update widget page numbers with imported page numbers.
				if(
					preg_match('#(wam__position_)(\d+)_#',$option,$matches) ||
					preg_match('#(wam__area_)(\d+)_#',$option,$matches)
				){
					$new_page_id = $this->_imported_post_id($matches[2]);
					if($new_page_id){
						// we have a new page id for this one. import the new setting value.
						$option = str_replace($matches[1].$matches[2].'_', $matches[1].$new_page_id.'_', $option);
					}
				}
				update_option( $option, $value );
			}

			// set the blog page and the home page.
			$shoppage = get_page_by_title( 'Shop' );
			if ( $shoppage ) {
				update_option( 'woocommerce_shop_page_id',$shoppage->ID );
			}
			$shoppage = get_page_by_title( 'Cart' );
			if ( $shoppage ) {
				update_option( 'woocommerce_cart_page_id',$shoppage->ID );
			}
			$shoppage = get_page_by_title( 'Checkout' );
			if ( $shoppage ) {
				update_option( 'woocommerce_checkout_page_id',$shoppage->ID );
			}
			$shoppage = get_page_by_title( 'My Account' );
			if ( $shoppage ) {
				update_option( 'woocommerce_myaccount_page_id',$shoppage->ID );
			}
			$homepage = get_page_by_title( 'Classic Shop' );
			if ( $homepage ) {
				update_option( 'page_on_front', $homepage->ID );
				update_option( 'show_on_front', 'page' );
			}
			$blogpage = get_page_by_title( 'Blog' );
			if ( $blogpage ) {
				update_option( 'page_for_posts', $blogpage->ID );
				update_option( 'show_on_front', 'page' );
			}

			// Set default image sizes
			update_option( 'thumbnail_crop', 1 );
			update_option( 'thumbnail_size_w', 280 );
			update_option( 'thumbnail_size_h', 280 );
			update_option( 'medium_size_w', 800 );
			update_option( 'medium_size_h', 400 );
			update_option( 'large_size_w', 1400 );
			update_option( 'large_size_h', 800 );

			// Fix wishlist button position
			update_option('yith_wcwl_button_position','shortcode');

			global $wp_rewrite;
			$wp_rewrite->set_permalink_structure('/%year%/%monthnum%/%day%/%postname%/');
			update_option( "rewrite_rules", FALSE );
			$wp_rewrite->flush_rules( true );
			flush_rewrite_rules();
			
			return true;
		}
		private function _get_json( $file ) {
			if ( is_file( __DIR__.'/content/'.basename( $file ) ) ) {
				WP_Filesystem();
				global $wp_filesystem;
				$file_name = __DIR__ . '/content/' . basename( $file );
				if ( file_exists( $file_name ) ) {
					return json_decode( $wp_filesystem->get_contents( $file_name ), true );
				}
			}
			return array();
		}
		private function _get_sql( $file ) {
			if ( is_file( __DIR__.'/content/'.basename( $file ) ) ) {
				WP_Filesystem();
				global $wp_filesystem;
				$file_name = __DIR__ . '/content/' . basename( $file );
				if ( file_exists( $file_name ) ) {
					return $wp_filesystem->get_contents( $file_name );
				}
			}
			return false;
		}

		/**
		 * Logo & Design
		 */
		public function envato_setup_logo_design() {			
			?>
			<h1><?php _e( 'Logo &amp; Design', 'envato_setup' ); ?></h1>
			<h3><?php _e( 'Upload Logo', 'envato_setup' ); ?></h3>
			<form method="post">
				
				<table>
					<tr>
						<td>
							<div id="current-logo">
								<?php $image_url = do_shortcode(get_theme_mod( 'site_logo', get_template_directory_uri().'/images/install-logo.eps')); 
								$image_url = apply_filters('envato_setup_logo_image',$image_url);
								if ( $image_url ) {
									$image = '<img class="site-logo" src="%s" alt="%s" style="width:%s; height:auto" />';
									printf(
										$image,
										$image_url,
										get_bloginfo( 'name' ),
										$this->get_header_logo_width()
									);
								} ?>
							</div>
						</td>
						<td>
							<a href="#" class="button button-upload"><?php _e( 'Upload New Logo', 'envato_setup' ); ?></a>
						</td>
					</tr>
				</table>
				<p>You can upload and customize this in Theme Options later.</p>

				<hr/>


				
				<?php 
				//$img_url = get_template_directory_uri().'/inc/builder/templates/thumbs/';?>
				<!--
				<h3 style="margin-top: 30px;"><?php _e( 'Select Preset', 'envato_setup' ); ?></h3>
				<div class="theme-presets">
					<ul>
						<li class="current">
							<a href="#" data-style="classic-shop">
								<img src="<?php echo $img_url; ?>classic-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="parallax-shop">
								<img src="<?php echo $img_url; ?>parallax-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="simple-corporate">
								<img src="<?php echo $img_url; ?>simple-corporate.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="mega-shop">
								<img src="<?php echo $img_url; ?>mega-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="fullscreen-fashion">
								<img src="<?php echo $img_url; ?>fullscreen-fashion.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="grid-style-1">
								<img src="<?php echo $img_url; ?>grid-style-1.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="video-cover">
								<img src="<?php echo $img_url; ?>video-cover.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="grid-style-2">
								<img src="<?php echo $img_url; ?>grid-style-2.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="grid-style-3">
								<img src="<?php echo $img_url; ?>grid-style-3.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="full-screen-fashion">
								<img src="<?php echo $img_url; ?>parallax-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="cute-shop">
								<img src="<?php echo $img_url; ?>cute-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="simple-slider">
								<img src="<?php echo $img_url; ?>simple-slider.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="vendor-shop">
								<img src="<?php echo $img_url; ?>vendor-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="sport-shop">
								<img src="<?php echo $img_url; ?>sport-shop.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="slider-cover">
								<img src="<?php echo $img_url; ?>slider-cover.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="explore">
								<img src="<?php echo $img_url; ?>explore.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="agency">
								<img src="<?php echo $img_url; ?>agency.jpg">
							</a>
						</li>
						<li>
							<a href="#" data-style="big-sale">
								<img src="<?php echo $img_url; ?>big-sale.jpg">
							</a>
						</li>
					</ul>
				</div>
-->
				<p><strong>NOTE: This works best on a fresh new installation. </strong><br/>* Images are not included. You need to replace the dummy images with your own images.
				All pages are included in the demo content, so you mix and match this in Theme Options.
				</p>

				<input type="hidden" name="new_logo_id" id="new_logo_id" value="">
				<input type="hidden" name="new_style" id="new_style" value="">

				<p class="envato-setup-actions step">
					<input type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Continue', 'envato_setup' ); ?>" name="save_step" />
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'envato_setup' ); ?></a>
					<?php wp_nonce_field( 'envato-setup' ); ?>
				</p>
			</form>
			<?php
		}

		/**
		 * Save logo & design options
		 */
		public function envato_setup_logo_design_save() {

			check_admin_referer( 'envato-setup' );

			$new_logo_id = (int) $_POST['new_logo_id'];

			if ( $new_logo_id ) {
				$attr = wp_get_attachment_image_src( $new_logo_id, 'full' );
				if ( $attr && ! empty( $attr[1] ) && ! empty( $attr[2] ) ) {
					set_theme_mod( 'site_logo', $attr[0] );			
				}
			}

			$new_style = isset($_POST['new_style']) ? $_POST['new_style'] : false;
			if($new_style) {
			  // Has tempalte
			  if (file_exists( __DIR__ . '/presets/layout-'.$new_style.'.php')) {
		  		$options = require( __DIR__ . '/presets/layout-'.$new_style.'.php' );
		  		foreach ($options as $key => $value) {
		  			 if($key == 'site_logo') continue;
	         		 set_theme_mod($key, $value);
	     		 }
			  }
			  // Set homepage
			  	$homepage = get_posts( array( 'name' => $new_style, 'post_type' => 'page' ) );
				if ( $homepage ) {
					update_option( 'page_on_front', $homepage[0]->ID );
				}
			}

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			exit;
		}

		/**
		 * Payments Step
		 */
		public function envato_setup_updates() {

			//verify purchase code if provided
			$slug = basename( get_template_directory() );
			$temp_code = '';
			$response_obj = '';
			if(isset($_POST[$slug . '_wup_purchase_code'])){
				$temp_code = esc_html($_POST[$slug . '_wup_purchase_code']);
				$homepage = file_get_contents('http://themesapi.kenzap.com/data.php?cmd=verify_code&code='.$temp_code.'&domain='.get_site_url().'&theme='.$slug);
				$response = json_decode($homepage);
				$response_obj = (object)$response;
			}

			//verify email address if provided
			$email_address = get_option( $slug . '_email_address', '' );

			?>
			<h1><?php _e( 'Welcome', 'envato_setup' ); ?></h1>
			<p class="lead">Thank you for choosing this product. It is currently one of the best solutions available on market today. It comes with constant updates and support. Feel free to customize it and redistribute. For more inspiration of other great products please visit <a target="blank" href="http://kenzap.com" >Kenzap</a> homepage.</p>
				<?php
				    
					//echo $slug;
				    $output = '';
					
				    //get errors so we can show them
				    $errors = get_option( $slug . '_wup_errors', array() );
				    delete_option( $slug . '_wup_errors' ); //delete existing errors as we will handle them next
				    //check if we have a purchase code saved already
				    $purchase_code = sanitize_text_field( get_option( $slug . '_wup_purchase_code', '' ) );

				    //output errors and notifications
				    if ( ! empty( $errors ) ) {
				      foreach ( $errors as $key => $error ) {
				        echo '<div class="notice-error notice-alt"><p>' . $error . '</p></div>';
				      }
				    }
   					//echo $purchase_code;
				    
				    if ( ! empty( $temp_code ) ) {
				      if ( ! $response_obj->{'success'} ) {
				        //since there is already a purchase code present - notify the user
				        echo '<div class="notice-warning notice-alt"><p>' . esc_html__( $response_obj->{'reason'} ) . '</p></div>';
				      } else {

				      	update_option( $slug . '_wup_purchase_code', $temp_code );
				        //this means a valid purchase code is present and no errors were found
				       	echo '<div class="notice-success notice-alt notice-large" style="margin-bottom:15px!important">' . __( 'Your <strong>purchase code is valid</strong>. Thank you! Enjoy this theme and its features.' ) . '</div>';
				      }
				    }

				    if ( empty( $temp_code ) ) {

				    	if(isset($_POST[$slug . '_wup_purchase_code']))
				    	$purchase_code = $_POST[$slug . '_wup_purchase_code'];
				    	echo '<form class="wupdates_purchase_code" action="'.esc_url( $this->get_next_step_link() ).'" method="post">' .
				             __( '<p>Important! We encourage you to avoid cheap hosting solutions as performance is one of the key aspects that will affect your end user experience, rankings and thus profits. Cheap means not only slow but limited. Amazon, DigitalOcean, Azure, Linode, KenzapCloud are good places to start your awesome website.</p>' ) .
				             '<input type="hidden" name="wupdates_pc_theme" value="' . esc_html( $slug ) . '" />' .
				             '<input type="text" id="' . sanitize_title( $slug ) . '_email_address" name="' . sanitize_title( $slug ) . '_email_address"
				              value="' . esc_html( $email_address ) . '" placeholder="Email address" style="width:100%; padding:10px;"/><br/><i style="color:#aaa;">* Your email address will be used for premium support and Kenzap subscription based services only. No promotions, special offers or spam will be sent.</i><br/>' .

				             '<br/><br/>' .
				             '<p class="envato-setup-actions step">' .
				             '<input type="submit" class="button button-large button-next button-primary" value="Continue"/>' .
				             //'<a href="'.esc_url( $this->get_next_step_link() ).'" class="button button-large button-next button-primary" >'.__( 'Continue', 'envato_setup' ).'</a>'.
 				             '</p>
				    </form>';
				  	} else{
				    echo '<form class="wupdates_purchase_code" action="" method="post">' .
				             '<input type="hidden" name="wupdates_pc_theme" value="' . $slug . '" />' .
				             '<input type="text" id="' . sanitize_title( $slug ) . '_wup_purchase_code" name="' . sanitize_title( $slug ) . '_wup_purchase_code"
				              value="' . $purchase_code . '" placeholder="Purchase code ( e.g. 9g2b13fa-10aa-2267-883a-9201a94cf9b5 )" style="width:100%; padding:10px;"/><br/><br/>' .
				              '<p class="envato-setup-actions step">' .
				              '<a href="'.esc_url( $this->get_next_step_link() ).'" class="button button-primary button-large button-next">'.__( 'Continue', 'envato_setup' ).'</a>' .
 				             '</p>
				      </form>';
				  	}
					?>
				<?php wp_nonce_field( 'envato-setup' ); ?>
	
			<?php
		}

		/**
		 * Payments Step
		 */
		public function envato_setup_updates_old() {

			//verify code
			$slug = basename( get_template_directory() );
			$temp_code = '';
			$response_obj = '';
			if(isset($_POST[$slug . '_wup_purchase_code'])){
				$temp_code = esc_html($_POST[$slug . '_wup_purchase_code']);
				$homepage = file_get_contents('http://themesapi.kenzap.com/data.php?cmd=verify_code&code='.$temp_code.'&domain='.get_site_url().'&theme='.$slug);
				$response = json_decode($homepage);
				$response_obj = (object)$response;
			}
	
			?>
			<h1><?php _e( 'Activate Theme', 'envato_setup' ); ?></h1>
			<p class="lead">Enter your purchase code to enable updates and access to Kenzap support.</p>
				<?php
				    
					//echo $slug;
				    $output = '';
					
				    //get errors so we can show them
				    $errors = get_option( $slug . '_wup_errors', array() );
				    delete_option( $slug . '_wup_errors' ); //delete existing errors as we will handle them next
				    //check if we have a purchase code saved already
				    $purchase_code = sanitize_text_field( get_option( $slug . '_wup_purchase_code', '' ) );

				    //output errors and notifications
				    if ( ! empty( $errors ) ) {
				      foreach ( $errors as $key => $error ) {
				        echo '<div class="notice-error notice-alt"><p>' . $error . '</p></div>';
				      }
				    }
   					//echo $purchase_code;
				    
				    if ( ! empty( $temp_code ) ) {
				      if ( ! $response_obj->{'success'} ) {
				        //since there is already a purchase code present - notify the user
				        echo '<div class="notice-warning notice-alt"><p>' . esc_html__( $response_obj->{'reason'} ) . '</p></div>';
				      } else {

				      	update_option( $slug . '_wup_purchase_code', $temp_code );
				        //this means a valid purchase code is present and no errors were found
				       	echo '<div class="notice-success notice-alt notice-large" style="margin-bottom:15px!important">' . __( 'Your <strong>purchase code is valid</strong>. Thank you! Enjoy this theme and its features.' ) . '</div>';
				      }
				    }

				    if ( empty( $temp_code ) ) {

				    	if(isset($_POST[$slug . '_wup_purchase_code']))
				    	$purchase_code = $_POST[$slug . '_wup_purchase_code'];
				    	echo '<form class="wupdates_purchase_code" action="" method="post">' .
				             __( '<p>Find out how to <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">get your purchase code</a> here.</p>' ) .
				             '<input type="hidden" name="wupdates_pc_theme" value="' . esc_html( $slug ) . '" />' .
				             '<input type="text" id="' . sanitize_title( $slug ) . '_wup_purchase_code" name="' . sanitize_title( $slug ) . '_wup_purchase_code"
				              value="' . esc_html( $purchase_code ) . '" placeholder="Purchase code ( e.g. 2w443er5-53ea-2267-883a-9201a94cf9b5 )" style="width:100%; padding:10px;"/><br/><br/>' .
				             '<p class="envato-setup-actions step">' .
				              '<input type="submit" class="button button-large button-next button-primary" value="Activate"/>' .
				              '<a href="'.esc_url( $this->get_next_step_link() ).'" class="button button-large button-next">'.__( 'Skip this step', 'envato_setup' ).'</a>'.
 				             '</p>
				    </form>';
				  	} else{
				    echo '<form class="wupdates_purchase_code" action="" method="post">' .
				             '<input type="hidden" name="wupdates_pc_theme" value="' . $slug . '" />' .
				             '<input type="text" id="' . sanitize_title( $slug ) . '_wup_purchase_code" name="' . sanitize_title( $slug ) . '_wup_purchase_code"
				              value="' . $purchase_code . '" placeholder="Purchase code ( e.g. 9g2b13fa-10aa-2267-883a-9201a94cf9b5 )" style="width:100%; padding:10px;"/><br/><br/>' .
				              '<p class="envato-setup-actions step">' .
				              '<a href="'.esc_url( $this->get_next_step_link() ).'" class="button button-primary button-large button-next">'.__( 'Continue', 'envato_setup' ).'</a>' .
 				             '</p>
				      </form>';
				  	}
					?>
				<?php wp_nonce_field( 'envato-setup' ); ?>
	
			<?php
		}

		/**
		 * Payments Step save
		 */
		public function envato_setup_updates_save() {

			echo "sss";die;
			check_admin_referer( 'envato-setup' );

			// redirect to our custom login URL to get a copy of this token.
			$url = $this->get_oauth_login_url( $this->get_step_link( 'updates' ) );

			wp_redirect( esc_url_raw( $url ) );
			exit;
		}


		public function envato_setup_customize() {
		?>

			<h1>Setup Child Theme (Optional)</h1>
	
			<p>
				If you are going to make changes to the theme source code please use a <a href="https://codex.wordpress.org/Child_Themes" target="_blank">Child Theme</a> rather than modifying the main theme HTML/CSS/PHP code. This allows the parent theme to receive updates without overwriting your source code changes. Use the form below to create and activate the Child Theme.
			</p>

			<?php if(!isset($_REQUEST['theme_name'])){ ?>
			<p class="lead">If you're not sure what a Child Theme is just click the "Skip this step" button.</p>
			<?php } ?>

			<?php
				// Create Child Theme
				if(isset($_REQUEST['theme_name']) && current_user_can('manage_options')){
					echo $this->_make_child_theme(esc_html($_REQUEST['theme_name'])); 
				}
				$theme = get_option('fl_has_child_theme') ? wp_get_theme(get_option('fl_has_child_theme') )->Name : $this->theme_name.' Child';
			 ?>

			<?php if(!isset($_REQUEST['theme_name'])){ ?>

			<form action="<?php $_PHP_SELF ?>" method="POST">
			 <div class="child-theme-input" style="margin-bottom: 20px;">
			 <label style="font-weight: bold;margin-bottom: 5px; display: block;">Child Theme Title</label>
		 	 <input type="text" style="padding:10px; width: 100%;" name="theme_name" value="<?php echo $theme; ?>" />
		 	 </div>
			<p class="envato-setup-actions step">
		        <button type="submit" id= type="submit"  class="button button-primary button-next button-next">
		         <?php _e( 'Create and Use Child Theme', 'envato_setup' ); ?>
		        </button>
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php _e( 'Skip this step', 'envato_setup' ); ?></a>

			</p>
			</form>
			<?php } else { ?>
			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php _e( 'Continue', 'envato_setup' ); ?></a>
			</p>
			<?php } ?>
			<?php
		}
		public function envato_setup_help_support() {
			?>
			<h1>Help and Support</h1>
			<p class="lead">This theme comes with 6 months item support from purchase date (with the option to extend this period). The support is free but limited. Please read the information below.</p>

			<p class="success">Item Support <strong>DOES</strong> Include:</p>

			<ul>
				<li>Availability of the author to answer questions</li>
				<li>Answering technical questions about item features</li>
				<li>Assistance with reported bugs and issues</li>
				<li>Help with bundled 3rd party plugins</li>
			</ul>

			<p class="error">Item Support <strong>DOES NOT</strong> Include:</p>
			<ul>
				<li>Customization services (available through <a href="https://studio.envato.com/explore/websites-programming" target="_blank">Envato Studio</a> or <a href="http://kenzap.com/contacts/" target="_blank">Kenzap</a>)</li>
				<li>Installation services (available through <a href="http://cloud.kenzap.com/" target="_blank">Kenzap Cloud</a>)</li>
				<li>Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)</li>
				<li>Error fix/installation on resource limited shared hosting environments</li>
			</ul>
			<p>More details about item support can be found in the <a href="http://kenzap.com/contacts/" target="_blank">Kenzap Support Department</a>. </p>
			<p class="envato-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-primary button-large button-next"><?php _e( 'Agree and Continue', 'envato_setup' ); ?></a>
				<?php wp_nonce_field( 'envato-setup' ); ?>
			</p>
			<?php
			

		}

		/**
		 * Final step
		 */
		public function envato_setup_ready() {

			update_option('envato_setup_complete',time());
			?>
			
			<h1><?php _e( 'Your Website is Ready!', 'envato_setup' ); ?></h1>

			<p class="lead success">Congratulations! The theme has been activated and your website is ready. Login to your WordPress dashboard to make changes and modify any of the default content to suit your needs.</p>
			<p>Please come back and <a href="http://themeforest.net/downloads" target="_blank">leave a 5-star rating</a> if you are happy with this theme. <br/>Follow <a  href="https://twitter.com/kenzap_com" target="_blank">@kenzap_com</a> on Twitter to see updates. Thanks! </p>

			<div class="envato-setup-next-steps">
				<div class="envato-setup-next-steps-first">
					<h2><?php _e( 'Next Steps', 'envato_setup' ); ?></h2>
					<ul>
						<li class="setup-product"><a class="button button-primary button-large" href="<?php echo get_site_url(); ?>/wp-admin/themes.php?page=pt-one-click-demo-import" ><?php _e( 'Install Demo Data', 'envato_setup' ); ?></a></li>
						<?php if(class_exists('woocommerce')) { ?><li class="setup-product"><a class="button  button-primary button-large woocommerce-button" href="<?php echo admin_url().'index.php?page=wc-setup';?>"><?php _e( 'Setup WooCommerce (optional)', 'envato_setup' ); ?></a></li><?php } ?>
						<li class="setup-product"><a class="button button-large" href="<?php echo esc_url( home_url() ); ?>"><?php _e( 'View your new website!', 'envato_setup' ); ?></a></li>
					</ul>
				</div>
				<div class="envato-setup-next-steps-last">
					<h2><?php _e( 'More Resources', 'envato_setup' ); ?></h2>
					<ul>
						<li class="documentation"><a target="_blank" href="http://<?php echo $this->theme_slug; ?>_docs.kenzap.com"><?php _e( 'Theme Documentation', 'envato_setup' ); ?></a></li>
						<li class="woocommerce documentation"><a target="_blank" href="https://docs.woocommerce.com/document/woocommerce-101-video-series/"><?php _e( 'Learn how to use WooCommerce', 'envato_setup' ); ?></a></li>
						<li class="howto"><a target="_blank" href="https://wordpress.org/support/"><?php _e( 'Learn how to use WordPress', 'envato_setup' ); ?></a></li>
						<li class="rating"><a target="_blank" href="http://themeforest.net/downloads"><?php _e( 'Leave an Item Rating', 'envato_setup' ); ?></a></li>
					</ul>
				</div>
			</div>
			<?php
			update_option( $this->theme_slug.'_install_url', false );
		}

		/**
		 * Helper function
		 * Take a path and return it clean
		 *
		 * @param string $path
		 *
		 * @since    1.1.2
		 */
		public static function cleanFilePath( $path ) {
			$path = str_replace( '', '', str_replace( array( "\\", "\\\\" ), '/', $path ) );
			if ( $path[ strlen( $path ) - 1 ] === '/' ) {
				$path = rtrim( $path, '/' );
			}
			return $path;
		}

		public function is_submenu_page(){
			return ( $this->parent_slug == '' ) ? false : true;
		}
	}

}// if !class_exists

/**
 * Loads the main instance of Envato_Theme_Setup_Wizard to have
 * ability extend class functionality
 *
 * @since 1.1.1
 * @return object Envato_Theme_Setup_Wizard
 */

add_action( 'after_setup_theme', 'envato_theme_setup_wizard', 10 );

if ( ! function_exists( 'envato_theme_setup_wizard' ) ) :
	function envato_theme_setup_wizard() {
		Envato_Theme_Setup_Wizard::get_instance();
	}
endif;