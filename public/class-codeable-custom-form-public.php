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
	 * @param    string $atts    The shortcode attributes.
	 */
	public function register_ccf_form_shortcode( $atts ) {

		return $this->render_form( $atts );
	}

	/**
	 * Create Shortcode for Users to add the button.
	 *
	 * @since    1.0.0
	 * @param    string $atts    The shortcode attributes.
	 */
	public function render_form( $atts ) {

		$attributes = shortcode_atts(
			array(
				'form-title'          => __( 'Submit your feedback', 'codeable-custom-form' ),
				'submit-button-label' => __( 'Submit Enquiry', 'codeable-custom-form' ),
			),
			$atts
		);

		$first_name = '';
		$last_name  = '';

		if ( is_user_logged_in() ) {

			$current_user = wp_get_current_user();
			if ( ! $current_user->exists() ) {
				return;
			}

			$first_name = $current_user->user_firstname;
			$last_name  = $current_user->user_lastname;
		}

		ob_start();
		?>
		<div class="ccf-wrapper">
			<h2><?php echo esc_html( $attributes['form-title'] ); ?></h2>
			<form id="ccf-form" action="#" method="post">
				<div>
					<label for="first_name"><?php esc_html_e( 'First Name:', 'codeable-custom-form' ); ?></label>
					<input type="text" name="first_name" value="<?php echo esc_attr( $first_name ); ?>" required />
				</div>
				<div>
					<label for="last_name"><?php esc_html_e( 'Last Name:', 'codeable-custom-form' ); ?></label>
					<input type="text" name="last_name" value="<?php echo esc_attr( $last_name ); ?>" required />
				</div>
				<div>
					<label for="email"><?php esc_html_e( 'Last Name:', 'codeable-custom-form' ); ?></label>
					<input type="email" name="email" required />
				</div>
				<div>
					<label for="subject"><?php esc_html_e( 'Subject:', 'codeable-custom-form' ); ?></label>
					<input type="text" name="subject" required />
				</div>
				<div>
					<label for="message"><?php esc_html_e( 'Message:', 'codeable-custom-form' ); ?></label>
					<textarea name="message" required ></textarea>
				</div>
				<div class="">
					<button type="submit"><?php echo esc_html( $attributes['submit-button-label'] ); ?></button>
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
