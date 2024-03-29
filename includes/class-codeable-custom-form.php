<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://rodrigosalles.com
 * @since      1.0.0
 *
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/includes
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
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/includes
 * @author     Rodrigo Salles <rodrigo@rprojectwebstudio.com>
 */
class Codeable_Custom_Form {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Codeable_Custom_Form_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	 * The DB table used for storing form entries.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $table_name    The DB table used for entries.
	 */
	protected $table_name;

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
		if ( defined( 'CODEABLE_CUSTOM_FORM_VERSION' ) ) {
			$this->version = CODEABLE_CUSTOM_FORM_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'codeable-custom-form';
		$this->table_name  = CODEABLE_CUSTOM_FORM_TABLE_NAME;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Codeable_Custom_Form_Loader. Orchestrates the hooks of the plugin.
	 * - Codeable_Custom_Form_i18n. Defines internationalization functionality.
	 * - Codeable_Custom_Form_Admin. Defines all hooks for the admin area.
	 * - Codeable_Custom_Form_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codeable-custom-form-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-codeable-custom-form-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-codeable-custom-form-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-codeable-custom-form-public.php';

		$this->loader = new Codeable_Custom_Form_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Codeable_Custom_Form_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Codeable_Custom_Form_i18n();

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

		$plugin_admin = new Codeable_Custom_Form_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Codeable_Custom_Form_Public( $this->get_plugin_name(), $this->get_version(), $this->get_table_name() );

		// Add Shortcodes.
		$this->loader->add_shortcode( 'ccf-form', $plugin_public, 'register_ccf_form_shortcode' );
		$this->loader->add_shortcode( 'ccf-entries', $plugin_public, 'register_ccf_entries_shortcode' );

		// Submit form AJAX.
		$this->loader->add_action( 'wp_ajax_ccf_submit_form', $plugin_public, 'submit_form' );
		$this->loader->add_action( 'wp_ajax_nopriv_ccf_submit_form', $plugin_public, 'submit_form' );

		// Load entries AJAX.
		$this->loader->add_action( 'wp_ajax_ccf_load_entries_ajax', $plugin_public, 'load_entries_ajax' );
		$this->loader->add_action( 'wp_ajax_nopriv_ccf_load_entries_ajax', $plugin_public, 'load_entries_ajax' );

		// Load single entry AJAX.
		$this->loader->add_action( 'wp_ajax_ccf_load_single_entry', $plugin_public, 'load_single_entry' );
		$this->loader->add_action( 'wp_ajax_nopriv_ccf_load_single_entry', $plugin_public, 'load_single_entry' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

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
	 * @return    Codeable_Custom_Form_Loader    Orchestrates the hooks of the plugin.
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

	/**
	 * Retrieve the DB table name for form entries.
	 *
	 * @since     1.0.0
	 * @return    string    The DB table name used for storing entries.
	 */
	public function get_table_name() {

		return $this->table_name;

	}

}
