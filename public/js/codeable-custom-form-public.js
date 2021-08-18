( function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	// Handle form submit event.
	$( document ).on('submit','#ccf-form', function( e ) {
		e.preventDefault();

		// AJAX Call to save a new enquiry.
		$.ajax( {
			type: 'post',
			url: ccfAjaxObject.ajax_url,
			data: {
				action     : 'ccf_submit_form',
				first_name : $( '#first_name' ).val(),
				last_name  : $( '#last_name' ).val(),
				email      : $( '#email' ).val(),
				subject    : $( '#subject' ).val(),
				message    : $( '#message' ).val(),
			},
			success: function ( response ) {
				alert("Done!");
			},
			/*
			success: function(response){
				$(".success_msg").css("display","block");
			}, error: function(data){
				$(".error_msg").css("display","block");
			}
			*/

		} );
	} );

} )( jQuery );
