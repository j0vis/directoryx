/* global dxadultAdmin */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var testBtn = document.getElementById( 'dxadult-test-link' );
		if ( ! testBtn ) {
			return;
		}

		testBtn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			var url = testBtn.getAttribute( 'data-url' ) || '';
			// Validate URL before opening.
			try {
				var parsed = new URL( url );
				if ( parsed.protocol !== 'http:' && parsed.protocol !== 'https:' ) {
					window.alert( ( dxadultAdmin && dxadultAdmin.invalidUrl ) || 'Please enter a valid http(s) URL.' );
					return;
				}
				window.open( parsed.toString(), '_blank', 'noopener,noreferrer' );
			} catch ( err ) {
				window.alert( ( dxadultAdmin && dxadultAdmin.invalidUrl ) || 'Please enter a valid URL (including https://).' );
			}
		} );
	} );
}() );
