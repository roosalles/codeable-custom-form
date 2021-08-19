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

	// On document.ready..
	$( function() {

		// Handle form submit event.
		$( '#ccf-form' ).on('submit', function( e ) {
			e.preventDefault();

			// AJAX Call to save a new enquiry.
			$.ajax( {
				type: 'post',
				url: ccfAjaxObject.ajax_url,
				data: {
					action     : 'ccf_submit_form',
					nonce      : ccfAjaxObject.ajax_nonce,
					first_name : $( '#first_name' ).val(),
					last_name  : $( '#last_name' ).val(),
					email      : $( '#email' ).val(),
					subject    : $( '#subject' ).val(),
					message    : $( '#message' ).val(),
				},
				success: function ( response ) {
					$( '#ccf-form' ).hide();
					$( '.ccf-success' ).show();
				},
				error: function ( response ) {
					$( '.ccf-error' ).show();
				}
			} );
		} );

		// Handle pagination links clicks.
		$( '#ccf-pagination-nav li' ).on( 'click', function() {

			if ( $( this ).hasClass( 'ccf-nav-active' ) ) {
				return;
			} else {
				$( '#ccf-pagination-nav li' ).removeClass( 'ccf-nav-active' );
				$( this ).addClass( 'ccf-nav-active' );
			}

			// AJAX Call to load entries for pagination.
			$.ajax( {
				type: 'post',
				url: ccfAjaxObject.ajax_url,
				data: {
					action           : 'ccf_load_entries_ajax',
					nonce            : ccfAjaxObject.ajax_nonce,
					page             : $( this ).data( 'page' ),
					entries_per_page : $( '#ccf-entries-table' ).data( 'entries-per-page' ),
					entries_order    : $( '#ccf-entries-table' ).data( 'entries-order' ),
				},
				success: function ( response ) {
					$( '.ccf-entry-row' ).remove();
					$( '#ccf-entries-table tbody' ).append( response.entriesHTML );
				}
			} );
		} );

		// Handle Single Entry click.
		$( '#ccf-entries-table' ).on( 'click', '.ccf-entry-row', function() {

			// AJAX Call to load single entry by ID.
			$.ajax( {
				type: 'post',
				url: ccfAjaxObject.ajax_url,
				data: {
					action   : 'ccf_load_single_entry',
					nonce    : ccfAjaxObject.ajax_nonce,
					entry_id : $( this ).data( 'entry-id' ),
				},
				success: function ( response ) {
					$( '#ccf-entry-details' ).empty();
					$( '#ccf-entry-details' ).html( response.entryHTML );
				}
			} );
		} );

		// Handle Close Details button click.
		$( '#ccf-entry-details' ).on( 'click', '#ccf-close-details-button', function() {
			$( '#ccf-entry-details' ).empty();
		} );

	} );

} )( jQuery );
