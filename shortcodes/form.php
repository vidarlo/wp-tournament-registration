<?php

/* shortcode for registration form */
function wp_tournreg_get_form( $atts = [], $content = null ) {
		
	// normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
	$a = shortcode_atts( array(
		'class' => null,
		'css' => null,
		'css_id' => null,
		'tournament_id' => null,
	), $atts );
	
	/* error if tournament id is missing */
	if ( empty ( $a[ 'tournament_id' ] ) ) {
		
		return sprintf( __( '%sERROR: Missing %s in shortcode %s!%s', 'wp-tournament-registration' ), '<strong class="wptournreg-error">', '<kbd>tournament_id</kbd>', '<kbd>wptournregform</kbd>', '</strong>' );
	}
	else {
		$tournament = '<input type="hidden" name="tournament_id" value="' . $a[ 'tournament_id' ] . '">';
	}
	
	/* set action URL */
	$action = ' method="POST" action="' . esc_url( admin_url('admin-post.php') ) . '"';
	
	/* add custom CSS */
	$css = ( empty ( $a{ 'css' } ) ) ? '' : ' style="' . $a{ 'css' } . '"';
	$class = ' class="wptournreg-form' . ( empty ( $a{ 'class' } ) ? '' :  ' ' . $a{ 'class' } ) . '"';
	$id = ( empty ( $a{ 'css_id' } ) ) ? '' : ' id="' . $a{ 'css_id' } . '"';
	
	return "<form$id$class$css$action target='_blank'>$tournament" . do_shortcode( $content, false ) . '<input type="hidden" name="action" value="wptournreg_add_participant"><input type="submit"><input type="reset"></form>';
}

add_shortcode( 'wptournregform', 'wp_tournreg_get_form' );

/* Action hook of registration form */
function wptournreg_add_participant() {
	
	require_once WP_TOURNREG_DATABASE_PATH.'insert.php';
	wptournreg_insert_data();

	echo '<html><head></head></html><body>';
	echo sprintf( __( '%sThank you for your registration.%s', 'wp-tournament-registration'), '<strong class="wptournreg-thanks">', '</strong>' );
	echo '</body>';
}
add_action( 'admin_post_wptournreg_add_participant', 'wptournreg_add_participant' );