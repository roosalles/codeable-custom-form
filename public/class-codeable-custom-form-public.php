<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rodrigosalles.com
 * @since      1.0.0
 *
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/public
 * @author     Rodrigo Salles <rodrigo@rproject.ws>
 */
class Codeable_Custom_Form_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Codeable_Custom_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Codeable_Custom_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/codeable-custom-form-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Codeable_Custom_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Codeable_Custom_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/codeable-custom-form-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'ccfAjaxObject',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);

	}

	/**
	 * Handle form submission.
	 *
	 * @since    1.0.0
	 */
	public function submit_form() {

	}

	/**
	 * Create Shortcode for rendering the form.
	 *
	 * @since    1.0.0
	 */
	public function register_ccf_form_shortcode() {

		return $this->render_form();
	}

	/**
	 * Create Shortcode for Users to add the button.
	 *
	 * @since    1.0.0
	 */
	public function render_form() {

		ob_start();
		?>
		<div class="ccf-wrapper">
			<h2>Submit your feedback</h2>
			<form id="ccf-form" action="#" method="post">
				<div>
					<label for="first_name">First Name:</label>
					<input type="text" name="first_name" />
				</div>
				<div>
					<label for="last_name">Last Name:</label>
					<input type="text" name="last_name" />
				</div>
				<div>
					<label for="email">E-mail:</label>
					<input type="email" name="email" />
				</div>
				<div>
					<label for="subject">Subject:</label>
					<input type="text" name="subject" />
				</div>
				<div>
					<label for="message">Message:</label>
					<textarea name="message"></textarea>
				</div>
				<div class="">
					<button type="submit">Submit Enquiry</button>
				</div>
			</form>
		</div>

		<?php

		return ob_get_clean();
	}

	/**
	 * Create Shortcode for rendering entries.
	 *
	 * @since    1.0.0
	 */
	public function register_ccf_entries_shortcode() {

		return $this->render_entries();
	}

	/**
	 * Create Shortcode for Users to add the button.
	 *
	 * @since    1.0.0
	 */
	public function render_entries() {

	}

}
