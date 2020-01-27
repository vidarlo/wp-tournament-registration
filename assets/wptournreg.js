jQuery(function() {
  jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
});

jQuery( '.wptournregedit-select' ).on( 'change', function() {

	jQuery( '.wptournregedit-participant' ).css( 'display', 'none' );
	jQuery( jQuery( this ).val() ).css( 'display', 'block' );
	
}).trigger( 'change' );