=== Codeable Custom Form ===
Contributors: roosalles
Donate link: https://rodrigosalles.com
Tags: codeable, forms
Requires at least: 3.0.1
Tested up to: 5.8
Stable tag: 4.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Basic plugin to display custom form for enquiries.

== Description ==

This is a basic plugin/project built for Codeable screening process.
This plugin was built based on the popular WordPress Plugin starter kit from https://wppb.me/

== Installation ==

1. Upload `codeable-custom-form.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `[ccf-form]` shortcode on any page you want the form to be displayed.
4. Place `[ccf-entries]` shortcode on any page you want the form entries to be displayed.

For more options that can be used with the shortcodes above, please see below:

= [ccf-form] Shortcode Options =

You can use the following options with the [ccf-form] shortcode:

[ccf-form form-title="Your Title"]
This defines a custom title for the form. Default: 'Submit your feedback'

[ccf-form submit-button-label="Your custom label"]
This defines a custom label text for the submit button. Default: 'Submit Enquiry'

[ccf-form thank-you-message="Your custom thank you message!"]
This defines a custom text when the form is submitted successfully. Default: 'Thank you for sending us your feedback!'

[ccf-form form-width="50%"]
Sets a custom width for the form. Default: '100%'

Note: You can also combine all options:
[ccf-form form-title="Your Title" submit-button-label="Your custom label" thank-you-message="Your custom thank you message!" form-width="50%"]

= [ccf-entries] Shortcode Options =

You can use the following options with the [ccf-entries] shortcode:

[ccf-entries entries-per-page="20"]
This defines the number of entries to be displayed per page. Default: 10

[ccf-entries entries-order="ASC"]
This defines the order (ascending/descending - by entry date) of entries listed in the entries table. Default: "DESC"
Values accepted: "ASC" or "DESC"

Note: You can also combine all options:
[ccf-entries entries-per-page="20" entries-order="ASC"]

== Frequently Asked Questions ==

No questions so far. =)

== Upgrade Notice ==

None.

== Screenshots ==

 1. None

== Changelog ==

= 1.0 =
* First version of the plugin.
