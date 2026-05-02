/* global wp, jQuery */
(function ( $ ) {
	'use strict';

	// Color pickers.
	$( '.slps-color-picker' ).wpColorPicker();

	// Generic media uploader factory.
	function slpsMediaField( inputId, btnId, removeId, previewId ) {
		var frame;

		$( '#' + btnId ).on( 'click', function ( e ) {
			e.preventDefault();
			if ( frame ) {
				frame.open();
				return;
			}
			frame = wp.media( {
				title: '',
				button: { text: 'Use This Image' },
				multiple: false,
			} );
			frame.on( 'select', function () {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				$( '#' + inputId ).val( attachment.url ).trigger( 'change' );
				$( '#' + previewId ).attr( 'src', attachment.url ).show();
				$( '#' + removeId ).show();
			} );
			frame.open();
		} );

		$( '#' + removeId ).on( 'click', function ( e ) {
			e.preventDefault();
			$( '#' + inputId ).val( '' ).trigger( 'change' );
			$( '#' + previewId ).hide().attr( 'src', '' );
			$( this ).hide();
		} );
	}

	slpsMediaField( 'slps-logo-url',      'slps-logo-upload-btn',     'slps-logo-remove',     'slps-logo-preview' );
	slpsMediaField( 'slps-bg-image-url',  'slps-bg-image-upload-btn', 'slps-bg-image-remove', 'slps-bg-image-preview' );

	// Show/hide background size and repeat rows based on whether a background image is set.
	function toggleBgImageRows() {
		var hasImage = $( '#slps-bg-image-url' ).val() !== '';
		$( '#slps-bg-size-row, #slps-bg-repeat-row' ).toggle( hasImage );
	}

	toggleBgImageRows();
	$( '#slps-bg-image-url' ).on( 'change', toggleBgImageRows );

}( jQuery ) );
