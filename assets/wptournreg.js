jQuery(function() {
  jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
});

/* Change selected player in editor. */
jQuery( '.wptournregedit-select' ).on( 'change', function() {

	jQuery( '.wptournregedit-participant' ).css( 'display', 'none' );
	jQuery( jQuery( this ).val() ).css( 'display', 'block' );
	
}).trigger( 'change' );

/* Check registration form on human user */
var wptournregtouched = false;
jQuery( '.wptournreg-form input' ).on( 'focus mouseover touch', function() {
	
	if ( wptournregtouched === false ) {
		
		wptournregtouched = true;
		jQuery( '.wptournreg-form' ).prepend( '<input type="hidden" name="touched" value="1">' );
	}
});