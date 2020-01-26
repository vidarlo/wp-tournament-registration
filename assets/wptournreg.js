jQuery(function() {
  jQuery(".wptournreg-list table").tablesorter({widgets: ["zebra"],});
});

jQuery( '.wptournregedit-select' ).on( 'change', function() {
	
	console.log('CHANGE');
	
	let updateform = jQuery( this ).val();
	jQuery( '.wptournregedit-participant' ).css( 'display', 'none' );
	jQuery( updateform ).css( 'display', 'block' );
	
}).trigger( 'change' );