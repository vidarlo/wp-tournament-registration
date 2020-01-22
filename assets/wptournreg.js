jQuery(function() {
  jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
});

jQuery( '.wptournregedit-select' ).on( 'select', function() {
	
	let updateform = jQuery( this ).val();
	jQuery( '.wptournregedit-select' ).css( 'display', 'none' );
	jQuery( updateform ).css( 'display', 'block' );
	
}).first().trigger( 'select' );
