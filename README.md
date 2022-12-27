# Codeable Custom Form

**Contributors:** roosalles  
**Donate link:** https://rodrigosalles.com  
**Tags:** codeable, forms  
**Requires at least:** 3.0.1  
**Tested up to:** 5.8  
**Stable tag:** trunk  
**Requires PHP:** 7.0  

## Description 

Basic plugin to display custom form for general enquiries.

The fields included in the form are:  
Name, e-mail, subject and message

All entries are stored in a custom table and can be displayed on any page using a shortcode.  
Entries details are retrieved via AJAX when clicking on any entry listed in the table.

This is a basic plugin/project built for Codeable screening process.  
This plugin was built based on the popular WordPress Plugin starter kit from https://wppb.me/

## Installation

1. Upload `codeable-custom-form` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `[ccf-form]` shortcode on any page you want the form to be displayed.
4. Place `[ccf-entries]` shortcode on any page you want the form entries to be displayed.

For more options that can be used with the shortcodes above, please see below:

## [ccf-form] Shortcode Options

You can use the following options with the `[ccf-form]` shortcode:

Define a custom title for the form.  
*Default: "Submit your feedback"*

	[ccf-form form-title="Your Title"]
    

Define a custom label text for the submit button.  
*Default: "Submit Enquiry"*

	[ccf-form submit-button-label="Your custom label"]

Define a custom text when the form is submitted successfully.  
*Default: "Thank you for sending us your feedback!"*

	[ccf-form thank-you-message="Your custom thank you message!"]

Sets a custom width for the form.  
*Default: 100%*

	[ccf-form form-width="50%"]

> Note: You can also combine all options:

	[ccf-form form-title="Your Title" submit-button-label="Your custom label" thank-you-message="Your custom thank you message!" form-width="50%"]`

## [ccf-entries] Shortcode Options

You can use the following options with the `[ccf-entries]` shortcode:

Define the number of entries to be displayed per page.  
*Default: 10*

	[ccf-entries entries-per-page="20"]

Define the order (ascending/descending - by entry date) of entries listed in the entries table.  
Values accepted: "ASC" or "DESC"  
*Default: DESC*

	[ccf-entries entries-order="ASC"]

> Note: You can also combine all options:

	[ccf-entries entries-per-page="20" entries-order="ASC"]

## Demo

For basic functionalities demonstration, please visit:  

Form page: https://playground.rprojectwebstudio.com/codeable-custom-form-form-page/

Entries page: https://playground.rprojectwebstudio.com/codeable-custom-form-entries-page/

## Changelog

= 1.0 =  
* First version of the plugin.
