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
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'ccf_nonce' ),
			)
		);

	}

	/**
	 * Handle form submission.
	 *
	 * @since    1.0.0
	 */
	public function submit_form() {

		check_ajax_referer( 'ccf_nonce', 'nonce' );

		if ( empty( $_POST['first_name'] ) || empty( $_POST['last_name'] ) || empty( $_POST['email'] ) || empty( $_POST['subject'] ) || empty( $_POST['message'] ) ) {
			wp_die();
		}

		$first_name = $_POST['first_name'];
		$last_name  = $_POST['last_name'];
		$email      = $_POST['email'];
		$subject    = $_POST['subject'];
		$message    = $_POST['message'];

		global $wpdb;
		$table_name = $wpdb->prefix . 'codeable_form_entries';

		$wpdb->insert(
			$table_name,
			array(
				'submission_date' => gmdate( 'Y-m-d H:i:s' ),
				'first_name'      => $first_name,
				'last_name'       => $last_name,
				'email'           => $email,
				'subject'         => $subject,
				'message'         => $message,
			)
		);

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
				'thank-you-message'   => __( 'Thank you for sending us your feedback!', 'codeable-custom-form' ),
				'form-width'          => '100%',
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
		<div class="ccf-form-wrapper">
			<div class="ccf-success">
				<p><?php echo esc_html( $attributes['thank-you-message'] ); ?></p>
			</div>
			<div class="ccf-error">
				<p><?php esc_html_e( 'Something went wrong, please try again or contact the site administrator.', 'codeable-custom-form' ); ?></p>
			</div>
			<form id="ccf-form" method="post" style="width: <?php echo esc_attr( $attributes['form-width'] ); ?>">
				<h2><?php echo esc_html( $attributes['form-title'] ); ?></h2>
				<div class="ccf-field-wrapper">
					<label for="first_name"><?php esc_html_e( 'First Name:', 'codeable-custom-form' ); ?></label>
					<input type="text" id="first_name" value="<?php echo esc_attr( $first_name ); ?>" required />
				</div>
				<div class="ccf-field-wrapper">
					<label for="last_name"><?php esc_html_e( 'Last Name:', 'codeable-custom-form' ); ?></label>
					<input type="text" id="last_name" value="<?php echo esc_attr( $last_name ); ?>" required />
				</div>
				<div class="ccf-field-wrapper">
					<label for="email"><?php esc_html_e( 'Email:', 'codeable-custom-form' ); ?></label>
					<input type="email" id="email" required />
				</div>
				<div class="ccf-field-wrapper">
					<label for="subject"><?php esc_html_e( 'Subject:', 'codeable-custom-form' ); ?></label>
					<input type="text" id="subject" required />
				</div>
				<div class="ccf-field-wrapper">
					<label for="message"><?php esc_html_e( 'Message:', 'codeable-custom-form' ); ?></label>
					<textarea id="message" required ></textarea>
				</div>
				<div class="ccf-field-wrapper">
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
	 * @param    string $atts    The shortcode attributes.
	 */
	public function register_ccf_entries_shortcode( $atts ) {

		return $this->render_entries_table( $atts );

	}

	/**
	 * Create Shortcode for displaying form entries table.
	 *
	 * @since    1.0.0
	 * @param    string $atts    The shortcode attributes.
	 */
	public function render_entries_table( $atts ) {

		// Check if user is admin.
		if ( ! in_array( 'administrator', wp_get_current_user()->roles, true ) ) {
			return '<p>' . __( 'You are not authorized to view the content of this page.', 'codeable-custom-form' ) . '</p>';
		}

		$attributes = shortcode_atts(
			array(
				'entries-per-page' => 10,
			),
			$atts
		);

		ob_start();
		?>
		<div class="ccf-entries-wrapper">
			<table id="ccf-entries-table">
				<tr>
					<th><?php esc_html_e( 'First Name', 'codeable-custom-form' ); ?></th>
					<th><?php esc_html_e( 'Last Name', 'codeable-custom-form' ); ?></th>
					<th><?php esc_html_e( 'E-mail', 'codeable-custom-form' ); ?></th>
					<th><?php esc_html_e( 'Subject', 'codeable-custom-form' ); ?></th>
				</tr>
				<?php $this->load_entries( 1, $attributes['entries-per-page'] ); ?>
			</table>
			<?php $this->render_pagination_nav( $attributes['entries-per-page'] ); ?>
			<div id="ccf-entry-details"></div>
		</div>
		<?php

		return ob_get_clean();

	}

	/**
	 * Load form entries from the database (AJAX Call).
	 *
	 * @since    1.0.0
	 */
	public function load_entries_ajax() {

		check_ajax_referer( 'ccf_nonce', 'nonce' );

		$page             = $_POST['page'];
		$entries_per_page = $_POST['entries_per_page'];

		ob_start();
		$this->load_entries( $page, $entries_per_page );

		$entries_html = ob_get_clean();

		$ajax_response = array(
			'entriesHTML' => $entries_html,
		);

		wp_send_json( $ajax_response );

	}

	/**
	 * Load form entries from the database.
	 *
	 * @since    1.0.0
	 * @param    string $page                The page to be loaded.
	 * @param    string $entries_per_page    The number of entries to load per page..
	 */
	public function load_entries( $page, $entries_per_page ) {

		$my_sql_index = $page - 1;
		$start_index  = $my_sql_index * $entries_per_page;

		global $wpdb;
		$table_name = $wpdb->prefix . 'codeable_form_entries';

		// Query entries.
		$sql     = $wpdb->prepare( "SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT %d, %d", $start_index, $entries_per_page );
		$entries = $wpdb->get_results( $sql );

		$this->render_entries( $entries );

	}

	/**
	 * Load form entries from the database.
	 *
	 * @since    1.0.0
	 */
	public function load_single_entry() {

		$entry_id = $_POST['entry_id'];

		global $wpdb;
		$table_name = $wpdb->prefix . 'codeable_form_entries';

		// Query entries.
		$sql     = $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $entry_id );
		$entries = $wpdb->get_results( $sql );
		$entry   = $entries[0];

		ob_start();
		?>
		<table id="ccf-entry-details-table">
			<tr class="ccf-entry-details-table-header">
				<th colspan="2"><?php esc_html_e( 'Entry Details', 'codeable-custom-form' ); ?><span id="ccf-close-details-button">x</span></th>
			</tr>
			<tr class="ccf-entry-detail-row">
				<th><?php esc_html_e( 'Name:', 'codeable-custom-form' ); ?></th>
				<td><?php echo esc_html( $entry->first_name . ' ' . $entry->last_name ); ?></td>
			</tr>
			<tr class="ccf-entry-detail-row">
				<th><?php esc_html_e( 'E-mail:', 'codeable-custom-form' ); ?></th>
				<td><?php echo esc_html( $entry->email ); ?></td>
			</tr>
			<tr class="ccf-entry-detail-row">
				<th><?php esc_html_e( 'Subject:', 'codeable-custom-form' ); ?></th>
				<td><?php echo esc_html( $entry->subject ); ?></td>
			</tr>
			<tr class="ccf-entry-detail-row">
				<th><?php esc_html_e( 'Message:', 'codeable-custom-form' ); ?></th>
				<td><?php echo esc_html( $entry->message ); ?></td>
			</tr>
		</table>
		<?php

		$entry_html = ob_get_clean();

		$ajax_response = array(
			'entryHTML' => $entry_html,
		);

		wp_send_json( $ajax_response );

	}

	/**
	 * Create the HTML content for entries.
	 *
	 * @since    1.0.0
	 * @param    object $entries    The array of entries to be rendered on the table.
	 */
	public function render_entries( $entries ) {

		ob_start();

		// Loop all entries.
		foreach ( $entries as $entry ) :
			?>
			<tr class="ccf-entry-row" data-entry-id="<?php echo esc_attr( $entry->id ); ?>">
				<td><?php echo esc_html( $entry->first_name ); ?></td>
				<td><?php echo esc_html( $entry->last_name ); ?></td>
				<td><?php echo esc_html( $entry->email ); ?></td>
				<td><?php echo esc_html( $entry->subject ); ?></td>
			</tr>
			<?php
		endforeach;

		echo ob_get_clean();

	}

	/**
	 * Render pagination nav.
	 *
	 * @since    1.0.0
	 * @param    integer $entries_per_page    The number of entries to display per page.
	 */
	public function render_pagination_nav( $entries_per_page ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'codeable_form_entries';

		$count = $wpdb->get_var(
			$wpdb->prepare( "SELECT COUNT(id) FROM $table_name" )
		);

		$total_pages = ceil( $count / $entries_per_page );

		ob_start();
		?>
		<div id="ccf-pagination-nav-wrapper">
			<ul id="ccf-pagination-nav" data-entries-per-page="<?php echo esc_attr( $entries_per_page ); ?>">
				<?php for ( $i = 1; $i <= $total_pages; $i++ ) : ?>
					<li class="<?php echo $i == 1 ? 'ccf-nav-active' : ''; ?>" data-page="<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></li>
				<?php endfor; ?>
			</ul>
		</div>
		<?php
		echo ob_get_clean();

	}

}
