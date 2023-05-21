<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.aspsys.com/
 * @since      1.0.0
 *
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Jh_Nyt_Top_Stories
 * @subpackage Jh_Nyt_Top_Stories/includes
 * @author     Aspen Systems Inc. <webmaster@aspsys.com>
 */
class Jh_Nyt_Top_Stories {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Jh_Nyt_Top_Stories_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		if ( defined( 'JH_NYT_TOP_STORIES_VERSION' ) ) {
			$this->version = JH_NYT_TOP_STORIES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'jh-nyt-top-stories';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_top_stories_post();
		$this->register_cron_hook();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Jh_Nyt_Top_Stories_Loader. Orchestrates the hooks of the plugin.
	 * - Jh_Nyt_Top_Stories_i18n. Defines internationalization functionality.
	 * - Jh_Nyt_Top_Stories_Admin. Defines all hooks for the admin area.
	 * - Jh_Nyt_Top_Stories_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jh-nyt-top-stories-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jh-nyt-top-stories-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-jh-nyt-top-stories-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-jh-nyt-top-stories-public.php';
		
		/**
		 * The class responsible for defining the shortcode to display stories.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jh-nyt-top-stories-shortcode.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jh-nyt-top-stories-get-feed.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-jh-nyt-top-stories-cli.php';

		
		$this->loader = new Jh_Nyt_Top_Stories_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Jh_Nyt_Top_Stories_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Jh_Nyt_Top_Stories_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Jh_Nyt_Top_Stories_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'nyt_stories_admin_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Jh_Nyt_Top_Stories_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'build_shortcode');
		$this->loader->add_action( 'cli_init', $plugin_public, 'wds_cli_register_commands');
		
	}
  
  	private function register_top_stories_post(){
			  /**
		 * Registers the NYT Top Stories hook.
		 * @uses add_action()
		 */
		add_action( 'init' ,'wp_new_cpt');

		/**
		 * Creates a new NYT Top Stories Post Type()
		 * @uses register_post_type()
		 */

		function wp_new_cpt() {

			$labels = array(
				'name'               => _x( 'NYT Top Stories', 'post type general name', 'nyt-top-stories' ),
				'singular_name'      => _x( 'NYT Top Story', 'post type singular name', 'nyt-top-stories' ),
				'menu_name'          => _x( 'NYT Top Stories', 'admin menu', 'nyt-top-stories' ),
				'name_admin_bar'     => _x( 'NYT Top Story', 'add new on admin bar', 'nyt-top-stories' ),
				'add_new'            => _x( 'Add New', 'NYT Top Story', 'nyt-top-stories' ),
				'add_new_item'       => __( 'Add New NYT Top Story', 'nyt-top-stories' ),
				'new_item'           => __( 'New NYT Top Story', 'nyt-top-stories' ),
				'edit_item'          => __( 'Edit NYT Top Story', 'nyt-top-stories' ),
				'view_item'          => __( 'View NYT Top Story', 'nyt-top-stories' ),
				'all_items'          => __( 'All NYT Top Stories', 'nyt-top-stories' ),
				'search_items'       => __( 'Search NYT Top Stories', 'nyt-top-stories' ),
				'parent_item_colon'  => __( 'Parent NYT Top Stories:', 'nyt-top-stories' ),
				'not_found'          => __( 'No NYT Top Stories found.', 'nyt-top-stories' ),
				'not_found_in_trash' => __( 'No NYT Top Stories found in Trash.', 'nyt-top-stories' )
			);

			$args = array(
				'labels'               => $labels,  
				'description'          => __( 'Description.', 'Top Stories from the New York Times' ),
				'public'               => true,    
				'publicly_queryable'   => true,    
				'show_ui'              => true,    
				'show_in_menu'         => true,    
				'show_in_admin_bar'    => true,    
				'query_var'            => true,    
				'rewrite'              => true,	   
				'capability_type'      => 'post',  
				'has_archive'          => true,    
				'hierarchical'         => false,   
				'menu_position'        => null,    
				'exclude_from_search'  => true,   
				'supports'             => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
				'can_export'           => true,    
				'delete_with_user'     => null,    
				'taxonomies'           => array( 'nyt_category', 'nyt_tag' ),
			);

			register_post_type( 'nyt_story', $args ); 

		}
		
			 /**
			 * Add custom taxonomies
			 *
			 * Additional custom taxonomies can be defined here
			 * https://codex.wordpress.org/Function_Reference/register_taxonomy
			 */
			function add_custom_taxonomies() {
			  // Add new "Categories" taxonomy to Posts
			  register_taxonomy('nyt_category', 'nyt_story', array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => true,
				// This array of options controls the labels displayed in the WordPress Admin UI
				'labels' => array(
				  'name' => _x( 'Categories', 'taxonomy general name' ),
				  'singular_name' => _x( 'Category', 'taxonomy singular name' ),
				  'search_items' =>  __( 'Search Categories' ),
				  'all_items' => __( 'All Categories' ),
				  'edit_item' => __( 'Edit Categories' ),
				  'update_item' => __( 'Update Categories' ),
				  'add_new_item' => __( 'Add New Categories' ),
				  'new_item_name' => __( 'New Categories Name' ),
				  'menu_name' => __( 'Categories' ),
				),
			  ));
			
		
			 // Add new "Categories" taxonomy to Posts
			  register_taxonomy('nyt_tag', 'nyt_story', array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => true,
				// This array of options controls the labels displayed in the WordPress Admin UI
				'labels' => array(
				  'name' => _x( 'Tags', 'taxonomy general name' ),
				  'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
				  'search_items' =>  __( 'Search Tags' ),
				  'all_items' => __( 'All Tags' ),
				  'edit_item' => __( 'Edit Tags' ),
				  'update_item' => __( 'Update Tags' ),
				  'add_new_item' => __( 'Add New Tags' ),
				  'new_item_name' => __( 'New Tag Name' ),
				  'menu_name' => __( 'Tags' ),
				),
			  ));
			}
		
			add_action( 'init', 'add_custom_taxonomies', 0 );
    }
	
	
	private function register_cron_hook(){
		add_action ('nytcontent_scheduler_parser', 'load_cron_feed');
		function load_cron_feed(){
			$storiesPull = new Jh_Nyt_Top_Stories_Data_Parser();
    		$result = $storiesPull->get_nyt_feed();
     		//echo "Pulled Successfully";
		}
	}
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Jh_Nyt_Top_Stories_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	

}
