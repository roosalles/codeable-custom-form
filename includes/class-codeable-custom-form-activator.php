<?php
/**
 * Fired during plugin activation
 *
 * @link       https://rodrigosalles.com
 * @since      1.0.0
 *
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Codeable_Custom_Form
 * @subpackage Codeable_Custom_Form/includes
 * @author     Rodrigo Salles <rodrigo@rproject.ws>
 */
class Codeable_Custom_Form_Activator {

	/**
	 * Fired during plugin activation.
	 *
	 * This function handles all the necessary functionalities up on activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Create DB Table for custom form entries.
		global $wpdb;

		$table_name      = CODEABLE_CUSTOM_FORM_TABLE_NAME;
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				submission_date datetime NOT NULL,
				first_name tinytext NOT NULL,
				last_name tinytext NOT NULL,
				email tinytext NOT NULL,
				subject tinytext NOT NULL,
				message text NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		maybe_create_table( $table_name, $sql );
	}

}
