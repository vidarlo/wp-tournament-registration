<?php

/* edit entries */
function wptournreg_edit( $atts = [] ) {
	
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
	
	$a = shortcode_atts( array(
		'class' => null,
		'css' => null,
		'css_id' => null,
		'display_fields' => null,
		'tournament_id' => null,
	), $atts );
	
	/* error if tournament id is missing */
	if ( empty ( $a[ 'tournament_id' ] ) ) {
		
		return sprintf( __( '%sERROR: Missing %s in shortcode %s!%s', 'wp-tournament-registration' ), '<strong class="wptournreg-error">', '<kbd>tournament_id</kbd>', '<kbd>wptournregform</kbd>', '</strong>' );
	}
	
	require_once WP_TOURNREG_DATABASE_PATH . 'select.php';
	$result = wptournreg_select_tournament( $a[ 'tournament_id' ] ); 
	
	require_once WP_TOURNREG_DATABASE_PATH . 'scheme.php';
	$scheme = wptournreg_get_field_list();
	
	$fields = preg_split( '/\s*,\s*/', $a[ 'display_fields' ]);
	
	foreach( $result as $participant ) {
	}
	
	foreach( $result as $participant ) {
		
		foreach( $fields as $field ) {
			
			
		}
		
	}
}

add_shortcode( 'wptournregedit', 'wptournreg_edit' );